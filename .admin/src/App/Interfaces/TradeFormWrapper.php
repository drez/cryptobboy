<?php

namespace App;


/**
 * Skeleton subclass for representing a service for the TradeForm entity.
 *
 *
 * You should add additional methods/hooks to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    GoatCheese.
 */
class TradeFormWrapper extends TradeForm
{
    public function __construct($request, $args)
    {
        parent::__construct($request, $args);
    }

    /**
     * Hook form after the data getter
     * @param array $data
     * @param Trade $dataObj
     * @return void
    **/

    public function afterFormObj( array $data, Trade &$dataObj){}

    public function beforeList(&$request, &$pmpoData)
    {

      
        $this->hookListReadyJs = "
            $('.sw-header .custom-controls').append( $('<a>').html('Sync').addClass('button-link-blue header-controls').attr('href', 'Javascript:;').attr('id', 'syncTrades') );
            sw_message('Synchronizing...', false, 'sync_load', true);
            $('#syncTrades').click(()=>{
                $.post('" . _SITE_URL . $this->virtualClassName . "/sync/', {ui:'list'}, (data)=>{
                    $('#editPopupDialog').html(data);
                    $('#editPopupDialog').dialog('open');
                    sw_message(true, false, 'sync_load');
                });
            });
        ";
    }
}
