<?php

namespace App\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'asset_exchange' table.
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
class AssetExchangeTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.map.AssetExchangeTableMap';

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
        $this->setName('asset_exchange');
        $this->setPhpName('AssetExchange');
        $this->setClassname('App\\AssetExchange');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_asset_exchange', 'IdAssetExchange', 'INTEGER', true, 10, null);
        $this->addForeignKey('id_asset', 'IdAsset', 'INTEGER', 'asset', 'id_asset', true, 11, null);
        $this->addColumn('type', 'Type', 'ENUM', true, null, null);
        $this->getColumn('type', false)->setValueSet(array (
  0 => 'Spot',
  1 => 'Locked',
  2 => 'Flexible',
));
        $this->addForeignKey('id_exchange', 'IdExchange', 'INTEGER', 'exchange', 'id_exchange', true, 11, null);
        $this->addForeignKey('id_token', 'IdToken', 'INTEGER', 'token', 'id_token', true, 11, null);
        $this->addColumn('free_token', 'FreeToken', 'DECIMAL', false, 16, null);
        $this->addColumn('locked_token', 'LockedToken', 'DECIMAL', false, 16, null);
        $this->addColumn('freeze_token', 'FreezeToken', 'DECIMAL', false, 16, null);
        $this->addColumn('date_creation', 'DateCreation', 'TIMESTAMP', false, null, null);
        $this->addColumn('date_modification', 'DateModification', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('id_group_creation', 'IdGroupCreation', 'INTEGER', 'authy_group', 'id_authy_group', false, null, null);
        $this->addForeignKey('id_creation', 'IdCreation', 'INTEGER', 'authy', 'id_authy', false, null, null);
        $this->addForeignKey('id_modification', 'IdModification', 'INTEGER', 'authy', 'id_authy', false, null, null);
        // validators
        $this->addValidator('id_exchange', 'required', 'propel.validator.RequiredValidator', '', 'id_exchange_required');
        $this->addValidator('id_asset_exchange', 'required', 'propel.validator.RequiredValidator', '', ('AssetExchange_IdAssetExchange_required'));
        $this->addValidator('id_asset_exchange', 'match', 'propel.validator.MatchValidator', '/^(?:[0-9]*|null)$/', ('AssetExchange_IdAssetExchange_match_/^(?:[0-9]*|null)$/'));
        $this->addValidator('id_asset', 'required', 'propel.validator.RequiredValidator', '', ('AssetExchange_IdAsset_required'));
        $this->addValidator('id_asset', 'match', 'propel.validator.MatchValidator', '/^(?:[0-9]*|null)$/', ('AssetExchange_IdAsset_match_/^(?:[0-9]*|null)$/'));
        $this->addValidator('type', 'required', 'propel.validator.RequiredValidator', '', ('AssetExchange_Type_required'));
        $this->addValidator('type', 'type', 'propel.validator.TypeValidator', 'string', ('AssetExchange_Type_type_string'));
        $this->addValidator('id_exchange', 'match', 'propel.validator.MatchValidator', '/^(?:[0-9]*|null)$/', ('AssetExchange_IdExchange_match_/^(?:[0-9]*|null)$/'));
        $this->addValidator('id_token', 'required', 'propel.validator.RequiredValidator', '', ('AssetExchange_IdToken_required'));
        $this->addValidator('id_token', 'match', 'propel.validator.MatchValidator', '/^(?:[0-9]*|null)$/', ('AssetExchange_IdToken_match_/^(?:[0-9]*|null)$/'));
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Asset', 'App\\Asset', RelationMap::MANY_TO_ONE, array('id_asset' => 'id_asset', ), null, null);
        $this->addRelation('Exchange', 'App\\Exchange', RelationMap::MANY_TO_ONE, array('id_exchange' => 'id_exchange', ), null, null);
        $this->addRelation('Token', 'App\\Token', RelationMap::MANY_TO_ONE, array('id_token' => 'id_token', ), null, null);
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
  'add_search_columns' => '{"Token":[["id_token","%val","multiple"]]}',
  'set_order_list_columns' => '[["free_token","DESC"]]',
  'add_tab_columns' => '{"Other":"locked_token"}',
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

} // AssetExchangeTableMap
