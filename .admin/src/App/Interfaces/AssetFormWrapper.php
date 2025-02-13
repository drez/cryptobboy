<?php

namespace App;


/**
 * Skeleton subclass for representing a service for the AssetForm entity.
 *
 *
 * You should add additional methods/hooks to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    GoatCheese.
 */
class AssetFormWrapper extends AssetForm
{
    public function __construct($request, $args)
    {
        parent::__construct($request, $args);
    }

    /**
     * Hook form after the data getter
     * @param array $data
     * @param Asset $dataObj
     * @return void
    **/

    public function afterFormObj(array $data, Asset &$dataObj)
    {
        $this->hookFormIncludeJs = "
        var last_value=0;
        let color='#000';
        const getTicker = () => {
            const ticker = $('#IdToken_label').text();

            $.post('" . _SITE_URL . "Asset/getAsset/', {ui:'list', asset:ticker}, (data)=>{
                if(data?.bids){
                    const value = Number(data?.bids).toString();
                    if(last_value > value){color='#c44100';}
                    if(last_value < value){color='#00c411';}
                    last_value = value;
                    if( $('#live_ticker').length ){
                        $('#live_ticker').html(value).css('color', color); 
                    }else{
                        $('#divCntAsset .panel-heading').append(
                            $('<div>').append( $('<div>').css('display', 'inline-block').css('padding-right', '10px').html(ticker+'/USDT') )
                            .append( $('<div>').css('display', 'inline-block').attr('id', 'live_ticker').css('color', color).html(value) )
                        );
                    }
                    setTimeout(getTicker, 2000);
                }
            }, 'json');
        };
        ";

        $this->hookFormReadyJs = "
            getTicker();
            $('#ogf_Asset [for=IdToken]').parent().hide();
            $('#saveAsset').remove();
        ";
    }

    public function beforeList(&$request, &$pmpoData)
    {

        $this->hookListReadyJs = "
            

            $('.sw-header .custom-controls').append( $('<a>').html('Sync assets').addClass('button-link-blue header-controls').attr('href', 'Javascript:;').attr('id', 'syncAssets') );
           /*
            $('.sw-header .custom-controls').append( $('<a>').html('Sync trades').addClass('button-link-blue header-controls').attr('href', 'Javascript:;').attr('id', 'syncTrades') );
           */
            $('#syncAssets').click(()=>{
                sw_message('Synchronizing...', false, 'sync_load', true);
                $.post('" . _SITE_URL . $this->virtualClassName . "/syncAssets/', {ui:'list'}, (data)=>{
                    $('#editPopupDialog').html(data);
                    $('#editPopupDialog').dialog('open');
                    sw_message(true, false, 'sync_load');
                });
            });
            $('#syncTrades').click(()=>{
                $.post('" . _SITE_URL . $this->virtualClassName . "/syncTrades/', {ui:'list'}, (data)=>{
                    $('#editPopupDialog').html(data);
                    $('#editPopupDialog').dialog('open');
                });
            });
        ";
    }

    public function beforeChildListTrade(){
        $sync = new \Connector\Binance\Sync();
        $Asset = AssetQuery::create()->findPk($this->IdPk);
        $result = $sync->syncAccountTrades($Asset->getToken()->getTicker(), $this->IdPk);
        $this->hookListReadyJsFirstTrade = "
            sw_message('$result');
        ";
    }

    public function beforeListTrTrade(&$altValue, $data, $i, $param, $hookListColumnsTrade, $actionRow){
        if ($data->getType() == "Buy") {
            $altValue['Type'] = span($data->getType(), "style='color:#00c411;'");
        }

        if ($data->getType() == "Sell") {
            $altValue['Type'] = span($data->getType(), "style='color:#c44100;'");
        }
    }
}
