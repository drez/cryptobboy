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

        \Asset\Utils::setAvgPrice($dataObj);
        
    }

    public function beforeList(&$request, &$pmpoData)
    {
        $siteUrl = _SITE_URL;
        $this->hookListJs = <<<JS

    const getTickersHistories = () => {
        var allSymbols = [];
        $('#AssetTable tbody tr').each((index)=>{
            
            var symbol = $('#AssetTable tbody tr:nth-child('+index+')').attr('data-symbol');
            if(symbol){
               allSymbols.push(symbol);
            }
        });

         $.post('{$siteUrl}Asset/getTickerHistory/', {ui:'list', symbols:allSymbols}, (data)=>{
           Object.keys(data).forEach(function(key) {

                if(key && data[key]['priceChangePercent']?.length > 2){
                    var priceChange = data[key]['priceChangePercent'];
                    var icon = (priceChange.indexOf('+') > -1)?'au':'ad';
                    $("#AssetTable tbody tr[data-symbol='"+key+"'] td[c=IdToken]").append( $('<div>').addClass(icon).addClass('symbol_change').html(priceChange+'%' ));
                }
                
            });
            
        }, 'json');
    }

    var avgPrices = {};
    const getTickersSpot = () => {
        const id_token = $('#formAsset #IdToken').val();
        
        $.post('{$siteUrl}Asset/getTickersSpot/', {ui:'list'}, (tickers)=>{
            for (var ticker in tickers) {
                var data = tickers[ticker];
                if($('[data-ticker='+ticker+'] [c=AvgPrice]').text()){
                    if( $('#ticker_price_'+ticker).length == 0){
                        $('[data-ticker='+ticker+']').attr('data-symbol', data['s']);
                        var avgPrice = $('[data-ticker='+ticker+'] [c=AvgPrice]').text();
                        avgPrices[ticker] = Number(avgPrice);
                    }

                    var diff = Number(Math.round((data['p']-avgPrices[ticker])/avgPrices[ticker]*100));
                    console.log(avgPrices[ticker])
                    if(avgPrices[ticker] == 0){
                        var diff = '';
                        var color_diff = 'null';
                        var color = 'black';
                    }else{
                        var color = (diff >= 0)?'good':'bad';
                        var color_diff = color;
                        diff = diff+"%";
                    }
                    
                    if( $('#ticker_price_'+ticker).length){
                        $('#ticker_price_'+ticker).removeClass('good bad black u d').addClass(data['d']).addClass(color).html(data['p']);
                        $('#ticker_price_diff_'+ticker).removeClass('good bad').addClass(color_diff).html(diff);
                    }else{
                        $('[data-ticker='+ticker+'] [c=AvgPrice]').append( $('<div>').attr('id', 'ticker_price_'+ticker).addClass('ticker_price').addClass(data['d']).addClass(color).html(data['p']) );
                        $('[data-ticker='+ticker+'] [c=AvgPrice]').append( $('<div>').attr('id', 'ticker_price_diff_'+ticker).addClass('ticker_price').addClass(color_diff).html(diff) );
                    }
                }
                
                
            }
            setTimeout(getTickersSpot, 2000);
        }, 'json');
    };
JS;

        $this->hookListReadyJs = <<<JS
    setTimeout(getTickersHistories, 3000);
    getTickersSpot();
    $('.sw-header .custom-controls').append( $('<a>').html('Sync assets').addClass('button-link-blue header-controls').attr('href', 'Javascript:;').attr('id', 'syncAssets') );
  
    $('#syncAssets').click(()=>{
        sw_message('Synchronizing...', false, 'sync_load', true);
        $.post('{$siteUrl}Asset/syncAssets/', {ui:'list'}, (data)=>{
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
           // print_r($result);
            
            $refresh = "";
            if($result != 'Up to date'){
                $avg = \Asset\Utils::setAvgPrice($Asset);
               // print_r($avg);
                $refresh = "
                sw_message('Recalculating');
                $('#formAsset #AvgPrice_label').html('".$avg['AvgPrice']."');
                $('#formAsset #Profit_label').html('".$avg['Profit']."');
                ";
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
        $altValue['AvgPrice'] = ((float) $data->getAvgPrice() >= 0) ? round($data->getAvgPrice(), 2) : rtrim($data->getAvgPrice(), '0');
        $altValue['FreeToken'] = ((float)$data->getFreeToken() >= 0) ? round($data->getFreeToken(), 2) : rtrim($data->getFreeToken(), '0');
        $altValue['StakedToken'] = ((float)$data->getStakedToken() >= 0) ? round($data->getStakedToken(), 2) : rtrim($data->getStakedToken(), '0');
        $altValue['TotalToken'] = ((float)$data->getTotalToken() >= 0) ? round($data->getTotalToken(), 2) : rtrim($data->getTotalToken(), '0');
        $altValue['UsdValue'] = "$ ".$data->getUsdValue();
        $altValue['Profit'] = "$ ".$data->getUsdValue();
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
