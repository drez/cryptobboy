<?php

namespace App;


/**
 * Skeleton subclass for representing a services for the ImportService entity.
 *
 * User
 *
 * You should add additional methods/hooks to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.GoatCheese.
 */
class ImportServiceWrapper extends ImportService
{

    public $exchangeId;
    public function __construct($request, $response, $args)
    {
        parent::__construct($request, $response, $args);
        $this->customActions['import']            = 'import';
        $this->Form = new ImportFormWrapper($request, $args);

        
    }


    function import($request){
        if($request['i']){
            $Exchanges = ExchangeQuery::create()->find();
            if ($Exchanges) {
                foreach($Exchanges as $Exchange){
                    $this->exchangeId[$Exchange->getName()] = $Exchange->getIdExchange();
                }
                
            } else {
                throw \Exception("Cant find Exchange");
            }

            $Import = ImportQuery::create()->findPk($request['i']);

            $exports['Binance'] = ["DateUTC","OrderNo","Pair","Type","Side","Order Price","Order Amount","Time","Executed","Average Price","Trading total","Status"];

            $row = 0;
            $num = 0;
            $found = null;
            $msg = [];
            if (($handle = fopen(_BASE_DIR.$Import->getFile(), "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    if($row == 0){
                        for ($c=0; $c < $num; $c++) {
                            $header[] = str_replace(['"',"'", '(', ')'], '', trim($data[$c]));
                        }

                        foreach($exports as $key => $export){
                            

                            if(strcmp(implode(",", $header),"\xef\xbb\xbf".implode(",", $export)) === 0){
                                $found = "import".$key;
                                continue;
                            }  
                        }
                        if(empty($found)){
                            return ["html" => "Format not found"]; 
                        }
                        
                        $headerCount = $num;
                    }else{
                        if($headerCount == $num){
                            $return = $this->$found($data);
                            $newTrades += ($return[0]) ? 1 : 0;
                            if(is_array($return[1])){
                                $msg = array_merge($msg, $return[1]);
                            }
                            
                        }else{
                            return ["html" => "Error inconsistent row count"];
                        } 
                    }
                    
                    //echo "<p> $num fields in line $row: <br /></p>\n";

                    $row++; 
                }
                fclose($handle);
            }
        }

        if($newTrades > 0){
            $Import->setItems($newTrades);
            $Import->save();
            
        }

        return ["html" => "$newTrades new trades<br/><br/>".implode("<br/>", $msg)];
    }

    function importBinance($data){
        $newTrade = false;
        $token = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$data[8]);
        $price = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$data[10]);

        if($data[11] == 'FILLED' || $data[11] == 'PARTIALLY_FILLED'){
            $Token = TokenQuery::create()->filterByTicker($token[1])->findOneOrCreate();
            if($Token->isnew()){
                $Token->save();
                $msg[] = "New token: " . $token[1]."\r\n";
            }

            $Asset = AssetQuery::create()
                ->filterByIdToken($Token->getIdToken())
                ->findOneOrCreate();
            if($Asset->isnew()){
                $Asset->save();
                $msg[] = "New asset: " . $token[1]."\r\n";
            }

        
            $Symbol = SymbolQuery::create()
                ->filterByName($data[2])
                ->findOneOrCreate();
            if($Symbol->isnew()){
                $Symbol->setIdToken($Asset->getIdToken());
                $Symbol->save();
                $msg[] = "New symbol: " . $data[2]."\r\n";
            }

            $trade = [
                'IdAsset' => $Asset->getIdAsset(),
                'Type' => ucfirst(strtolower($data[4])),
                'IdSymbol' => $Symbol->getPrimaryKey(),
                'Qty' => $token[0],
                'Date' => $data[0],
                'GrossUsd' => $data[5],
                'Commission' => 0,
                'OrderId' => $data[1],
            ];

            //echo json_encode($trade, JSON_PRETTY_PRINT)."\r\n";

            $Trade = TradeQuery::create()
                ->filterByIdExchange($this->exchangeId['Binance'])
                ->filterByIdAsset($Asset->getIdAsset())
                ->filterByOrderId($trade['OrderId'])
                ->findOneOrCreate();

            if($Trade->isNew()){
                $Trade->fromArray($trade);
                $Trade->setCommissionAsset(null);
                $Trade->save();

                $newTrade = true;
            }

            return [$newTrade, $msg];

        }
    }
}
