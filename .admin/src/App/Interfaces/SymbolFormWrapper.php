<?php

namespace App;


/**
 * Skeleton subclass for representing a service for the SymbolForm entity.
 *
 *
 * You should add additional methods/hooks to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    GoatCheese.
 */
class SymbolFormWrapper extends SymbolForm
{
    public function __construct($request, $args)
    {
        parent::__construct($request, $args);
    }

    /**
     * Hook form after the data getter
     * @param array $data
     * @param Symbol $dataObj
     * @return void
    **/

    public function afterFormObj( array $data, Symbol &$dataObj){}
}
