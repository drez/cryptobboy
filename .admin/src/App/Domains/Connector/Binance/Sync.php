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
        $this->binance = new Binance(EXCHANGE_BINANCE_KEY, EXCHANGE_BINANCE_SECRET);

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

        if(1 || $this->assetNeedSync($IdAsset)){
            $return = "Resynced";
            $symbols = $this->getTradeSymbolForTicker($IdToken);
            $trades = [];
            $avgPrice = ['qty' => 0, 'amount' => 0];
            $startTime = strtotime("-3 years")*1000;
            $endTime = time()*1000;

            foreach($symbols as $symbol => $IdSymbol){
                $results = $this->binance->user()->getMyTrades(['symbol' => $symbol, 'recvWindow' => '10000']);
              // echo pre(print_r($results, true));
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

            foreach($trades as $orderId => $trade){
                $Trade = \App\TradeQuery::create()
                            ->filterByIdExchange($this->exchangeId)
                            ->filterByIdAsset($IdAsset)
                            ->filterByOrderId($orderId)
                            ->findOneOrCreate();

                if($Trade->isNew()){
                    $Trade->fromArray($trade);
                    $Trade->save();
                }
            }

            //$results = $this->binance->system()->getHistoricalTrades(['symbol' => $symbol]);
            //echo pre(print_r($results, true));

            $this->setAssetLastSync($IdAsset);
        }

        return $return;
        
    }

    function assetNeedSync($IdAsset):bool{
        $Asset = AssetQuery::create()->findPk($IdAsset);
        $LastSync = $Asset->getLastSync();
        $trade_sync_interval = 1200; defined('trade_sync_interval') ? trade_sync_interval : 600;

        return ($LastSync)?(strtotime($LastSync) < (strtotime(date('Y-m-d H:i:s'))-$trade_sync_interval)):true;
    }

    function setAssetLastSync($IdAsset){
        $Asset = AssetQuery::create()->findPk($IdAsset);
        $Asset->setLastSync(time());
        $Asset->save();
    }

    function syncTradeSymbols()
    {

        $tokens = $this->getLocalTokensMap();
        $count = 0;
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
                        $count++;
                    }
                }
                
            }
          //  return pre(print_r($symbols, true));
        }catch (\Exception $e){
          return pre(print_r($e->getMessage(), true));
        }

        return $count;
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
           // echo json_encode($result, JSON_PRETTY_PRINT);
        }catch (\Exception $e){
            print_r($e->getMessage());
        }

         if (is_array($result['rows'])) {
            foreach ($result['rows'] as $asset) {
                if ($asset['amount'] > 0) {
                    $assets[$asset['asset']]['Locked'] = [
                        'free' => $asset['amount'],
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
                       // echo json_encode($result, JSON_PRETTY_PRINT);
                    }catch (\Exception $e){
                        print_r($ticker.":".$e->getMessage());
                        $result['price'] = 0;
                    }

                    $Asset = AssetQuery::create()
                            ->filterByIdToken($tokens[$ticker])
                            ->findOne();
                   // echo $ticker.":".$result['price']."<br>\n\n".
                    $Asset->setUsdValue(bcmul($Asset->getTotalToken(),$result['price']));
                    $Asset->save();
                   // echo $ticker.":".$Asset->getTotalToken()."<br>";
                } else {
                     $Asset = AssetQuery::create()
                            ->filterByIdToken($tokens[$ticker])
                            ->findOne();
                    
                    $Asset->setUsdValue($Asset->getTotalToken());
                    $Asset->save();
                }
                
            }
        }

      //  if($newToken > 0){
            $_SESSION[_AUTH_VAR]->sessVar['symbol_history']['time'] = 0;
            $newSymbols = $this->syncTradeSymbols();
       // }

        return div(
            div("New tokens: $newToken")
            .div("New assets: $newAsset")
            .div("New trade symbols: $newSymbols")
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