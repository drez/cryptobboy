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

        $swmessage = "";
        if($this->args['data']['sw']){
            $swmessage = "sw_message('".$this->args['data']['sw']."')";
        }

        $siteUrl = _SITE_URL;
        $this->hookFormIncludeJs = <<<JS
        var last_value=0;
        let color='#000';
        const getTicker = () => {
            const id_token = $('#formAsset #IdToken').val();

            $.post('{$siteUrl}Asset/getAsset/', {ui:'list', id_token:id_token, id_symbol:$('#formAsset #IdSymbol').val()}, (data)=>{
                if(data?.bids){
                    const value = Number(data?.bids).toString();
                    if(last_value > value){color='#c44100';}
                    if(last_value < value){color='#00c411';}
                    last_value = value;
                    if( $('#live_ticker').length ){
                        $('#live_ticker').html(value).css('color', color); 
                    }else{
                        $('#divCntAsset .panel-heading').append(
                            $('<div>').append( $('<div>').css('display', 'inline-block').css('padding-right', '10px').html(data?.symbol) )
                            .append( $('<div>').css('display', 'inline-block').attr('id', 'live_ticker').css('color', color).html(value) )
                        );
                    }
                    setTimeout(getTicker, 2000);
                }
            }, 'json');
        };
JS;

        $this->hookFormReadyJs = <<<JS
    getTicker();
    $('#ogf_Asset [for=IdToken]').parent().hide();

    /*$('[in=inIdSymbol] label').css('width', '85%');
    $('[in=inIdSymbol]').append( $('<a>').attr('href', 'Javascript:;').attr('id', 'syncPair').html($('<i>').addClass('ri-restart-fill').css('display', 'inline-block')) );
    $('#syncPair').click(()=>{
         $('#syncTrades').click(()=>{
            $.post('" . _SITE_URL . $this->virtualClassName . "/syncPair/".$dataObj->getToken()->getTicker()."?i=".$dataObj->getIdToken()."', {ui:'list'}, (data)=>{
                $('#editPopupDialog').html(data);
                $('#editPopupDialog').dialog('open');
            });
        });
    });*/
JS; 
    $this->hookFormReadyJs .= $swmessage;

        $avgPrice = ['qty' => 0, 'amount' => 0];
        $Trades = TradeQuery::create()
            ->filterByIdAsset($dataObj->getPrimaryKey())
            ->orderByDate('ASC')
            ->find();
        foreach($Trades as $Trade){
                if($Trade->getStartAvg() == 'Reset'){
                    $avgPrice['qty'] = 0;
                    $avgPrice['amount'] = 0;
                    $curavg = 0;
                }

                if($Trade->getType() == 'Buy'){
                    $avgPrice['qty'] += $Trade->getQty();
                    $avgPrice['amount'] += $Trade->getQty()*$Trade->getGrossUsd();
                }elseif($avgPrice['qty'] > 0){
                    $curavg = $avgPrice['amount'] / $avgPrice['qty'];
                    $profit += ($Trade->getGrossUsd() - $curavg) * $Trade->getQty();

                    $avgPrice['amount'] -= $Trade->getQty()*$curavg;
                    $avgPrice['qty'] -= $Trade->getQty();
                }
            }

            if($avgPrice['amount'] || $curavg){
                if($avgPrice['qty'] > 0){
                    $avg = $avgPrice['amount'] / $avgPrice['qty'];
                }
                $dataObj->setAvgPrice(($avgPrice['qty'] > 0)?$avg:$curavg);
                $dataObj->setProfit($profit);
                ($dataObj->getSymbol()->isNew())?$dataObj->setSymbol(null):'';
                $dataObj->save();
            }
        
    }

    public function beforeList(&$request, &$pmpoData)
    {
        $siteUrl = _SITE_URL;
        $this->hookListJs = <<<JS
    var avgPrices = {};
    const getTickersSpot = () => {
        const id_token = $('#formAsset #IdToken').val();
        
        $.post('{$siteUrl}Asset/getTickersSpot/', {ui:'list'}, (tickers)=>{
            for (var ticker in tickers) {
                var data = tickers[ticker];
                if($('[data-ticker='+ticker+'] [c=AvgPrice]').text()){
                    if( $('#ticker_price_'+ticker).length == 0){
                        var avgPrice = $('[data-ticker='+ticker+'] [c=AvgPrice]').text();
                        avgPrices[ticker] = Number(avgPrice);
                    }

                    var diff = Number(Math.round((data['p']-avgPrices[ticker])/avgPrices[ticker]*100));
                    var color = (diff >= 0)?'good':'bad';

                    if( $('#ticker_price_'+ticker).length){
                        $('#ticker_price_'+ticker).removeClass('good bad u d').addClass(data['d']).addClass(color).html(data['p']);
                        $('#ticker_price_diff_'+ticker).removeClass('good bad').addClass(color).html(diff+"%");
                    }else{
                        $('[data-ticker='+ticker+'] [c=AvgPrice]').append( $('<div>').attr('id', 'ticker_price_'+ticker).addClass('ticker_price').addClass(data['d']).addClass(color).html(data['p']) );
                        $('[data-ticker='+ticker+'] [c=AvgPrice]').prepend( $('<div>').attr('id', 'ticker_price_diff_'+ticker).addClass('ticker_price').addClass(color).html(diff+"%") );
                    }
                }
                
                
            }
            setTimeout(getTickersSpot, 6000);
        }, 'json');
    };
JS;

        $this->hookListReadyJs = <<<JS
    getTickersSpot();
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
        sw_message('Synchronizing...', false, 'sync_load', true);
        $.post('" . _SITE_URL . $this->virtualClassName . "/syncTrades/', {ui:'list'}, (data)=>{
            $('#editPopupDialog').html(data);
            $('#editPopupDialog').dialog('open');
            sw_message(true, false, 'sync_load');
        });
    });
JS;
    }

    public function beforeChildListTrade(){
        if (empty($this->args['pg']) && empty($this->args['order']) && empty($this->args['ms'])) {
            $sync = new \Connector\Binance\Sync();
            $Asset = AssetQuery::create()->findPk($this->IdPk);
            $result = $sync->syncAccountTrades($Asset->getToken()->getTicker(), $this->IdPk);

            $refresh = "";
            if($result != 'Up to date'){
                $refresh = "
                sw_message('Recalculating');
                document.location = '"._SITE_URL."Asset/edit/".$this->IdPk."?sw=".urlencode($result)."';";
            }else{
                $refresh = "sw_message('$result');";
            }

            $this->hookListReadyJsFirstTrade = "
            
            ".$refresh."
        ";
        }
    }

    public function beforeListTr(&$altValue, $data, $i, &$param, $actionRow){
        $param['tr'] = "data-ticker='".$data->getToken()->getTicker()."'";
    }

    public function beforeListTrTrade(&$altValue, $data, $i, $param, $actionRow){
        if ($data->getType() == "Buy") {
            $altValue['Type'] = span($data->getType(), "style='color:#00c411;'");
        }

        if ($data->getType() == "Sell") {
            $altValue['Type'] = span($data->getType(), "style='color:#c44100;'");
        }
    }

    public function selectboxDataAsset_IdSymbol($pcDataO, $q, $override){

    }
}
