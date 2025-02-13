<?php

namespace App;


/**
 * Skeleton subclass for representing a services for the TradeService entity.
 *
 * User
 *
 * You should add additional methods/hooks to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.GoatCheese.
 */
class TradeServiceWrapper extends TradeService
{
    public function __construct($request, $response, $args)
    {
        parent::__construct($request, $response, $args);

        $this->customActions['sync']            = 'syncTrades';
        $this->Form = new TradeFormWrapper($request, $args);
    }

    public function syncTrades($request)
    {
        $sync = new \Connector\Binance\Sync();
        return $sync->syncTrades();
    }
}
