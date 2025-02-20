<?php

namespace App;

use Lin\Binance\Binance;
/**
 * Skeleton subclass for representing a services for the AssetService entity.
 *
 * User
 *
 * You should add additional methods/hooks to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.GoatCheese.
 */
class AssetServiceWrapper extends AssetService
{
    public function __construct($request, $response, $args)
    {
        parent::__construct($request, $response, $args);
        $this->customActions['syncAssets']            = 'syncAssets';
        $this->customActions['syncTrades']            = 'syncAccountTrades';
        $this->customActions['getAsset']            = 'getAsset';
        $this->customActions['syncPair']            = 'syncPair';
        $this->Form = new AssetFormWrapper($request, $args);
    }

    public function getAsset($request){

        if ($request['data']['id_token'] || $request['data']['id_symbol']) {
            if ($request['data']['id_symbol']) {
                $Symbol = SymbolQuery::create()->findPk($request['data']['id_symbol']);
                $tradingPair = $Symbol->getName();
            } else {

                $Token = TokenQuery::create()->findPk($request['data']['id_token']);
                $tradingPair = $Token->getTicker() . default_trading_pair;
            }

            try {
                $binance = new Binance($_ENV['BINANCE_KEY'], $_ENV['BINANCE_SECRET']);
                $result = $binance->system()->getTickerPrice(['symbol' => $tradingPair]);
                // echo pre(print_r($result, true));

                return json_encode(['bids' => $result['price'], 'symbol' => $tradingPair]);
            } catch (\Exception $e) {
                print_r($e->getMessage());
            }
        } 
    }

    public function syncAssets($request)
    {
        $sync = new \Connector\Binance\Sync();
        return $sync->syncAccountAssets();
    }
    public function syncAccountTrades($request)
    {
        $sync = new \Connector\Binance\Sync();
        return $sync->syncAccountTrades($request['data']['IdToken'], ['data']['IdAsset']);
    }

    public function syncPair(){

    }


}
