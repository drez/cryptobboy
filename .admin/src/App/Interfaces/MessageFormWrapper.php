<?php

namespace App;


/**
 * Skeleton subclass for representing a service for the MessageForm entity.
 *
 *
 * You should add additional methods/hooks to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    GoatCheese.
 */
class MessageFormWrapper extends MessageForm
{
    public function __construct($request, $args)
    {
        parent::__construct($request, $args);
    }

    /**
     * Hook form after the data getter
     * @param array $data
     * @param Message $dataObj
     * @return void
    **/

    public function afterFormObj( array $data, Message &$dataObj){}
}
