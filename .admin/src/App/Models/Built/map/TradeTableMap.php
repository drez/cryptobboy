<?php

namespace App\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'trade' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator..map
 */
class TradeTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.map.TradeTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('trade');
        $this->setPhpName('Trade');
        $this->setClassname('App\\Trade');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_trade', 'IdTrade', 'INTEGER', true, 10, null);
        $this->addColumn('start_avg', 'StartAvg', 'ENUM', false, null, null);
        $this->getColumn('start_avg', false)->setValueSet(array (
  0 => '-',
  1 => 'Reset',
));
        $this->addColumn('type', 'Type', 'ENUM', true, null, null);
        $this->getColumn('type', false)->setValueSet(array (
  0 => 'Buy',
  1 => 'Sell',
));
        $this->addForeignKey('id_exchange', 'IdExchange', 'INTEGER', 'exchange', 'id_exchange', true, 11, null);
        $this->addForeignKey('id_asset', 'IdAsset', 'INTEGER', 'asset', 'id_asset', true, 11, null);
        $this->addForeignKey('id_symbol', 'IdSymbol', 'INTEGER', 'symbol', 'id_symbol', true, 11, null);
        $this->addColumn('date', 'Date', 'TIMESTAMP', false, null, null);
        $this->addColumn('qty', 'Qty', 'DECIMAL', false, 16, null);
        $this->addColumn('gross_usd', 'GrossUsd', 'DECIMAL', false, 16, null);
        $this->addColumn('commission', 'Commission', 'DECIMAL', false, 16, null);
        $this->addForeignKey('commission_asset', 'CommissionAsset', 'INTEGER', 'token', 'id_token', false, 11, null);
        $this->addColumn('order_id', 'OrderId', 'BIGINT', false, 10, null);
        $this->addColumn('date_creation', 'DateCreation', 'TIMESTAMP', false, null, null);
        $this->addColumn('date_modification', 'DateModification', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('id_group_creation', 'IdGroupCreation', 'INTEGER', 'authy_group', 'id_authy_group', false, null, null);
        $this->addForeignKey('id_creation', 'IdCreation', 'INTEGER', 'authy', 'id_authy', false, null, null);
        $this->addForeignKey('id_modification', 'IdModification', 'INTEGER', 'authy', 'id_authy', false, null, null);
        // validators
        $this->addValidator('qty', 'required', 'propel.validator.RequiredValidator', '', 'qty_required');
        $this->addValidator('id_trade', 'required', 'propel.validator.RequiredValidator', '', ('Trade_IdTrade_required'));
        $this->addValidator('id_trade', 'match', 'propel.validator.MatchValidator', '/^(?:[0-9]*|null)$/', ('Trade_IdTrade_match_/^(?:[0-9]*|null)$/'));
        $this->addValidator('start_avg', 'type', 'propel.validator.TypeValidator', 'string', ('Trade_StartAvg_type_string'));
        $this->addValidator('type', 'required', 'propel.validator.RequiredValidator', '', ('Trade_Type_required'));
        $this->addValidator('type', 'type', 'propel.validator.TypeValidator', 'string', ('Trade_Type_type_string'));
        $this->addValidator('id_exchange', 'required', 'propel.validator.RequiredValidator', '', ('Trade_IdExchange_required'));
        $this->addValidator('id_exchange', 'match', 'propel.validator.MatchValidator', '/^(?:[0-9]*|null)$/', ('Trade_IdExchange_match_/^(?:[0-9]*|null)$/'));
        $this->addValidator('id_asset', 'required', 'propel.validator.RequiredValidator', '', ('Trade_IdAsset_required'));
        $this->addValidator('id_asset', 'match', 'propel.validator.MatchValidator', '/^(?:[0-9]*|null)$/', ('Trade_IdAsset_match_/^(?:[0-9]*|null)$/'));
        $this->addValidator('id_symbol', 'required', 'propel.validator.RequiredValidator', '', ('Trade_IdSymbol_required'));
        $this->addValidator('id_symbol', 'match', 'propel.validator.MatchValidator', '/^(?:[0-9]*|null)$/', ('Trade_IdSymbol_match_/^(?:[0-9]*|null)$/'));
        $this->addValidator('date', 'match', 'propel.validator.MatchValidator', '', ('Trade_Date_match'));
        $this->addValidator('commission_asset', 'match', 'propel.validator.MatchValidator', '/^(?:[0-9]*|null)$/', ('Trade_CommissionAsset_match_/^(?:[0-9]*|null)$/'));
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Exchange', 'App\\Exchange', RelationMap::MANY_TO_ONE, array('id_exchange' => 'id_exchange', ), null, null);
        $this->addRelation('Asset', 'App\\Asset', RelationMap::MANY_TO_ONE, array('id_asset' => 'id_asset', ), 'CASCADE', null);
        $this->addRelation('Symbol', 'App\\Symbol', RelationMap::MANY_TO_ONE, array('id_symbol' => 'id_symbol', ), null, null);
        $this->addRelation('Token', 'App\\Token', RelationMap::MANY_TO_ONE, array('commission_asset' => 'id_token', ), null, null);
        $this->addRelation('AuthyGroup', 'App\\AuthyGroup', RelationMap::MANY_TO_ONE, array('id_group_creation' => 'id_authy_group', ), null, null);
        $this->addRelation('AuthyRelatedByIdCreation', 'App\\Authy', RelationMap::MANY_TO_ONE, array('id_creation' => 'id_authy', ), null, null);
        $this->addRelation('AuthyRelatedByIdModification', 'App\\Authy', RelationMap::MANY_TO_ONE, array('id_modification' => 'id_authy', ), null, null);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'GoatCheese' =>  array (
  'i18n_langs' => '["en_US"]',
  'set_parent_table' => 'asset',
  'add_search_columns' => '{"Type":[["type","%val","multiple"]],"Exchange":[["id_exchange","%val","multiple"]],"Date":[["date","%val"]],"Date before":[["date","%val","LE"]],"Date after":[["date","%val","GE"]]}',
  'set_order_list_columns' => '[["date","DESC"]]',
  'set_child_colunms' => '{"id_asset":["token.ticker"],"commission_asset":["ticker"]}',
  'set_list_hide_columns' => '["commission","commission_asset"]',
),
            'add_validator' =>  array (
),
            'add_tablestamp' =>  array (
  'create_column' => 'date_creation',
  'update_column' => 'date_modification',
  'create_id_column' => 'id_creation',
  'group_id_column' => 'id_group_creation',
  'update_id_column' => 'id_modification',
  'exclude' => 'none',
  'foreign_keys' => 'all',
),
        );
    } // getBehaviors()

} // TradeTableMap
