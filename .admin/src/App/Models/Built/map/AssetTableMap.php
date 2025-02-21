<?php

namespace App\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'asset' table.
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
class AssetTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.map.AssetTableMap';

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
        $this->setName('asset');
        $this->setPhpName('Asset');
        $this->setClassname('App\\Asset');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_asset', 'IdAsset', 'INTEGER', true, 10, null);
        $this->addForeignKey('id_token', 'IdToken', 'INTEGER', 'token', 'id_token', true, 11, null);
        $this->addColumn('avg_price', 'AvgPrice', 'DECIMAL', false, 16, null);
        $this->addColumn('free_token', 'FreeToken', 'DECIMAL', false, 16, null);
        $this->addColumn('usd_value', 'UsdValue', 'DECIMAL', false, 12, null);
        $this->addColumn('total_token', 'TotalToken', 'DECIMAL', false, 16, null);
        $this->addColumn('profit', 'Profit', 'DECIMAL', false, 12, null);
        $this->addColumn('staked_token', 'StakedToken', 'DECIMAL', false, 16, null);
        $this->addForeignKey('id_symbol', 'IdSymbol', 'INTEGER', 'symbol', 'id_symbol', false, 11, null);
        $this->addColumn('flexible_token', 'FlexibleToken', 'DECIMAL', false, 16, null);
        $this->addColumn('locked_token', 'LockedToken', 'DECIMAL', false, 16, null);
        $this->addColumn('freeze_token', 'FreezeToken', 'DECIMAL', false, 16, null);
        $this->addColumn('last_sync', 'LastSync', 'TIMESTAMP', false, null, null);
        $this->addColumn('date_creation', 'DateCreation', 'TIMESTAMP', false, null, null);
        $this->addColumn('date_modification', 'DateModification', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('id_group_creation', 'IdGroupCreation', 'INTEGER', 'authy_group', 'id_authy_group', false, null, null);
        $this->addForeignKey('id_creation', 'IdCreation', 'INTEGER', 'authy', 'id_authy', false, null, null);
        $this->addForeignKey('id_modification', 'IdModification', 'INTEGER', 'authy', 'id_authy', false, null, null);
        // validators
        $this->addValidator('free_token', 'required', 'propel.validator.RequiredValidator', '', 'free_token_required');
        $this->addValidator('id_asset', 'required', 'propel.validator.RequiredValidator', '', ('Asset_IdAsset_required'));
        $this->addValidator('id_asset', 'match', 'propel.validator.MatchValidator', '/^(?:[0-9]*|null)$/', ('Asset_IdAsset_match_/^(?:[0-9]*|null)$/'));
        $this->addValidator('id_token', 'required', 'propel.validator.RequiredValidator', '', ('Asset_IdToken_required'));
        $this->addValidator('id_token', 'match', 'propel.validator.MatchValidator', '/^(?:[0-9]*|null)$/', ('Asset_IdToken_match_/^(?:[0-9]*|null)$/'));
        $this->addValidator('id_symbol', 'match', 'propel.validator.MatchValidator', '/^(?:[0-9]*|null)$/', ('Asset_IdSymbol_match_/^(?:[0-9]*|null)$/'));
        $this->addValidator('last_sync', 'match', 'propel.validator.MatchValidator', '', ('Asset_LastSync_match'));
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Token', 'App\\Token', RelationMap::MANY_TO_ONE, array('id_token' => 'id_token', ), null, null);
        $this->addRelation('Symbol', 'App\\Symbol', RelationMap::MANY_TO_ONE, array('id_symbol' => 'id_symbol', ), null, null);
        $this->addRelation('AuthyGroup', 'App\\AuthyGroup', RelationMap::MANY_TO_ONE, array('id_group_creation' => 'id_authy_group', ), null, null);
        $this->addRelation('AuthyRelatedByIdCreation', 'App\\Authy', RelationMap::MANY_TO_ONE, array('id_creation' => 'id_authy', ), null, null);
        $this->addRelation('AuthyRelatedByIdModification', 'App\\Authy', RelationMap::MANY_TO_ONE, array('id_modification' => 'id_authy', ), null, null);
        $this->addRelation('AssetExchange', 'App\\AssetExchange', RelationMap::ONE_TO_MANY, array('id_asset' => 'id_asset', ), 'CASCADE', null, 'AssetExchanges');
        $this->addRelation('Trade', 'App\\Trade', RelationMap::ONE_TO_MANY, array('id_asset' => 'id_asset', ), 'CASCADE', null, 'Trades');
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
  'set_menu_priority' => '100',
  'add_search_columns' => '{"Token":[["id_token","%val","multiple"]]}',
  'set_order_list_columns' => '[["total_token","DESC"]]',
  'with_child_tables' => '["trade","asset_exchange"]',
  'set_child_colunms' => '{"id_token":["ticker"]}',
  'add_tab_columns' => '{"Other":"locked_token"}',
  'set_list_hide_columns' => '["locked_token","freeze_token","id_symbol","last_sync"]',
  'set_readonly_columns' => '["free_token","staked_token","total_token","usd_value","locked_token","flexible_token","freeze_token","last_sync","avg_price","profit","last_sync"]',
  'set_selectbox_filters' => '{"id_symbol":[["id_token","%obj%.id_token"]]}',
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

} // AssetTableMap
