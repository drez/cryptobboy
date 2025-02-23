<?php
namespace Asset;

class Utils {

    static function setAvgPrice($dataObj){

        $ret = ['AvgPrice' => 0, 'Profit' => 0];

        $avgPrice = ['qty' => 0, 'amount' => 0];
        $Trades = \App\TradeQuery::create()
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
                $avgPrice['qty'] = ($avgPrice['qty'] - $Trade->getQty() < 0) ? 0 : $avgPrice['qty'] - $Trade->getQty();

            }
        }

        if($avgPrice['amount'] || $curavg){
            if($avgPrice['qty'] > 0){
                $avg = $avgPrice['amount'] / $avgPrice['qty'];
            }
            $dataObj->setAvgPrice(($avgPrice['qty'] > 0)?$avg:$curavg);
            $ret ['AvgPrice'] = ($avgPrice['qty'] > 0)?$avg:$curavg;
            $ret ['Profit'] = ($profit)?$profit:0;
            $dataObj->setProfit($profit);
            (($dataObj->getSymbol()) && $dataObj->getSymbol()->isNew())?$dataObj->setSymbol(null):'';
            $dataObj->save();
        }

        return $ret;
    }

    

}