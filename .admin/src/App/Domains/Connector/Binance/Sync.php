<?php

namespace Connector\Binance;

use App\SymbolQuery;
use Lin\Binance\Binance;


use App\AssetQuery;
use App\TokenQuery;
use App\ExchangeQuery;
use App\AssetExchangeQuery;
use \Exception;

class Sync {

    private $binance;
    private $exchangeId;
    private $tokenMap = null;

    function __construct()
    {
        $this->binance = new Binance($_ENV['BINANCE_KEY'], $_ENV['BINANCE_SECRET']);

        $Exchange = ExchangeQuery::create()->filterByName('Binance')->findOne();
        if ($Exchange) {
            $this->exchangeId = $Exchange->getIdExchange();
        } else {
            throw \Exception("Cant find Exchange");
        }
    }

    function getTokenId(string $ticker):int|null{
        if($this->tokenMap == null){
            $this->getLocalTokensMap();
        }

        if(isset($this->tokenMap[$ticker])){
            return $this->tokenMap[$ticker];
        }else{
            $Token = new \App\Token();
            $Token->setTicker($ticker);
            $Token->save();

            $this->tokenMap[$ticker] = $Token->getPrimaryKey();
            return $this->tokenMap[$ticker];
        }
    }

    static function getTradeSymbolForTicker(string $TokenTicker):array|null{
        $Symbols = SymbolQuery::create()
                ->filterByName("%".$TokenTicker."%", \Criteria::LIKE)
        ->find();

        foreach($Symbols as $Symbol){
            $ret[$Symbol->getName()] = $Symbol->getIdSymbol();
        }
        return $ret;
    }
    

    function syncAccountTrades($IdToken, $IdAsset){
        $return = "Up to date";

        if($this->assetNeedSync($IdAsset)){
            $return = "Resynced";
            $symbols = $this->getTradeSymbolForTicker($IdToken);
            $trades = [];
            foreach($symbols as $symbol => $IdSymbol){
                $results = $this->binance->user()->getMyTrades(['symbol' => $symbol]);
                if($results){
                    foreach($results as $result){
                        if(isset($trades[$result['orderId']])){
                            $trades[$result['orderId']]['Qty'] += $result['qty'];
                        }else{
                            $trades[$result['orderId']]['Type'] = ($result['isBuyer'] == '1') ? 'Buy' : 'Sell';
                            $trades[$result['orderId']]['IdSymbol'] = $IdSymbol;
                            $trades[$result['orderId']]['Qty'] = $result['qty'];
                            $trades[$result['orderId']]['Date'] = date('Y-m-d H:i:s',$result['time']/1000);
                            $trades[$result['orderId']]['GrossUsd'] = $result['price'];
                            $trades[$result['orderId']]['Commission'] = $result['commission'];
                            $trades[$result['orderId']]['CommissionAsset'] = $this->getTokenId($result['commissionAsset']);
                            $trades[$result['orderId']]['OrderId'] = $result['orderId'];
                        }
                       // echo pre(print_r($results));
                    }
                }
            }

           // echo pre(print_r($trades));

            foreach($trades as $trade){
                $Trade = \App\TradeQuery::create()
                            ->filterByIdExchange($this->exchangeId)
                            ->filterByIdAsset($IdAsset)
                            ->filterByDate($trade['Date'])
                            ->findOneOrCreate();

                        $Trade->fromArray($trade);
                        $Trade->save();
            }

            $this->setAssetLastSync($IdAsset);
        }

        return $return;
        
    }

    function assetNeedSync($IdAsset):bool{
        $Asset = AssetQuery::create()->findPk($IdAsset);
        $LastSync = $Asset->getLastSync();
        $trade_sync_interval = defined('trade_sync_interval') ? trade_sync_interval : 600;

        return ($LastSync)?(strtotime($LastSync) < (strtotime(date('Y-m-d H:i:s'))-$trade_sync_interval)):true;
    }

    function setAssetLastSync($IdAsset){
        $Asset = AssetQuery::create()->findPk($IdAsset);
        $Asset->setLastSync(time());
        $Asset->save();
    }

    function syncTadeSymbols()
    {

        $tokens = $this->getLocalTokensMap();

        try {
           
            $result = $this->binance->system()->getExchangeInfo();
            foreach($result['symbols'] as $symbol){
                $symbols[] = [
                    'symbol' => $symbol['symbol'], 'baseAsset' => $symbol['baseAsset'],
                    'status' => $symbol['status'], 'quoteAsset' => $symbol['quoteAsset']];

                if($tokens[$symbol['baseAsset']] && $symbol['status'] == 'TRADING'){
                    $Symbol = SymbolQuery::create()
                        ->filterByName($symbol['symbol'])
                        ->filterByIdToken($tokens[$symbol['baseAsset']])
                        ->findOneOrCreate();

                    if($Symbol->isNew()){

                        $Symbol->save();
                    }
                }
                
            }
          //  return pre(print_r($symbols, true));
        }catch (\Exception $e){
          return pre(print_r($e->getMessage(), true));
        }
    }

    function syncAccountAssets()
    {
        try {
            $result = $this->binance->user()->getAccount();
           // echo pre(print_r($result, true));
        }catch (\Exception $e){
            print_r($e->getMessage());
        }

        if (is_array($result['balances'])) {
            foreach ($result['balances'] as $asset) {
                if ($asset['free'] > 0) {
                    if (substr($asset['asset'], 0, 2) != 'LD' || empty(substr($asset['asset'],  2))) {
                        
                        $assets[$asset['asset']]['Spot'] = [
                            'free' => $asset['free'],
                            'locked' => ($asset['locked'])?$asset['locked']:0,
                            'freeze' => ($asset['freeze'])?$asset['freeze']:0,
                        ];    
                    } 
                }
                
            }
        }

        try {
            $result = $this->binance->user()->getEarnFlexibleBalances();
        }catch (\Exception $e){
            print_r($e->getMessage());
        }

        if (is_array($result['rows'])) {
            foreach ($result['rows'] as $asset) {
                if ($asset['totalAmount'] > 0) {
                    $assets[$asset['asset']]['Flexible'] = [
                        'free' => $asset['totalAmount'],
                        'locked' => 0,
                        'freeze' => 0,
                    ];
                }
            }
        }

        try {
            $result = $this->binance->user()->getEarnLockedBalances();
        }catch (\Exception $e){
            print_r($e->getMessage());
        }

         if (is_array($result['rows'])) {
            foreach ($result['rows'] as $asset) {
                if ($asset['totalAmount'] > 0) {
                    $assets[$asset['asset']]['Locked'] = [
                        'free' => $asset['totalAmount'],
                        'locked' => 0,
                        'freeze' => 0,
                    ];
                }
            }
        }

        $newToken = 0;
        $newAsset = 0;

        //return pre(print_r($assets, true));

        if(is_array($assets)){
            // sync tokens
            foreach($assets as $ticker => $asset){
                $Token = TokenQuery::create()->filterByTicker($ticker)->findOneOrCreate();
                if ($Token->isNew()) {
                    $Token->save();
                    $newToken++;
                }

                $tokens[$ticker] = $Token->getPrimaryKey();
                
            }

            // sync asssets
            foreach($assets as $ticker => $asset){
                foreach ($asset as $type => $balance) {
                    $Asset = AssetQuery::create()
                        ->filterByIdToken($tokens[$ticker])
                        ->findOneOrCreate();

                    if ($Asset->isNew()) {
                        $Asset->save();
                    }

                    $AssetExchange = AssetExchangeQuery::create()
                        ->filterByIdExchange($this->exchangeId)
                        ->filterByIdToken($tokens[$ticker])
                        ->filterByType($type)
                        ->findOneOrCreate();
                    if ($AssetExchange->isNew()) {
                        $newAsset++;
                    }

                    $AssetExchange->setIdAsset($Asset->getPrimaryKey());
                    $AssetExchange->setFreeToken($balance['free']);
                    $AssetExchange->setLockedToken($balance['locked']);
                    $AssetExchange->setFreezeToken($balance['freeze']);
                    $AssetExchange->save();
                }

                if ($ticker != 'USDT') {
                    try {
                        $result = $this->binance->system()->getTickerPrice(['symbol' => $ticker.'USDT']);
                    }catch (\Exception $e){
                        print_r($ticker.":".$e->getMessage());
                    }

                    $Asset = AssetQuery::create()
                            ->filterByIdToken($tokens[$ticker])
                            ->findOne();
                    
                    $Asset->setUsdValue(bcmul($Asset->getTotalToken(),$result['price']));
                    $Asset->save();
                    echo $ticker.":".$Asset->getTotalToken()."<br>";
                } else {
                     $Asset = AssetQuery::create()
                            ->filterByIdToken($tokens[$ticker])
                            ->findOne();
                    
                    $Asset->setUsdValue($Asset->getTotalToken());
                    $Asset->save();
                }
                
            }
        }

        return div(
            div("New tokens: $newToken")
            .div("New assets: $newAsset")
        );  
        
    }

    function getLocalTokensMap(){
        $Tokens = TokenQuery::create()->find();
        foreach($Tokens as $Token){
            $this->tokenMap[$Token->getTicker()] = $Token->getPrimaryKey();
        }
        
        return $this->tokenMap;
    }

    

}