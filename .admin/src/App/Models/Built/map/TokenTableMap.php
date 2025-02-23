<?php

namespace App\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'token' table.
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
class TokenTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.map.TokenTableMap';

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
        $this->setName('token');
        $this->setPhpName('Token');
        $this->setClassname('App\\Token');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_token', 'IdToken', 'INTEGER', true, 10, null);
        $this->addColumn('ticker', 'Ticker', 'VARCHAR', false, 100, null);
        $this->addColumn('is_stablecoin', 'IsStablecoin', 'ENUM', true, null, null);
        $this->getColumn('is_stablecoin', false)->setValueSet(array (
  0 => 'No',
  1 => 'Yes',
));
        $this->addColumn('name', 'Name', 'VARCHAR', false, 100, null);
        $this->addColumn('date_creation', 'DateCreation', 'TIMESTAMP', false, null, null);
        $this->addColumn('date_modification', 'DateModification', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('id_group_creation', 'IdGroupCreation', 'INTEGER', 'authy_group', 'id_authy_group', false, null, null);
        $this->addForeignKey('id_creation', 'IdCreation', 'INTEGER', 'authy', 'id_authy', false, null, null);
        $this->addForeignKey('id_modification', 'IdModification', 'INTEGER', 'authy', 'id_authy', false, null, null);
        // validators
        $this->addValidator('ticker', 'required', 'propel.validator.RequiredValidator', '', 'ticker_required');
        $this->addValidator('id_token', 'required', 'propel.validator.RequiredValidator', '', ('Token_IdToken_required'));
        $this->addValidator('id_token', 'match', 'propel.validator.MatchValidator', '/^(?:[0-9]*|null)$/', ('Token_IdToken_match_/^(?:[0-9]*|null)$/'));
        $this->addValidator('ticker', 'type', 'propel.validator.TypeValidator', 'string', ('Token_Ticker_type_string'));
        $this->addValidator('is_stablecoin', 'required', 'propel.validator.RequiredValidator', '', ('Token_IsStablecoin_required'));
        $this->addValidator('is_stablecoin', 'type', 'propel.validator.TypeValidator', 'string', ('Token_IsStablecoin_type_string'));
        $this->addValidator('name', 'type', 'propel.validator.TypeValidator', 'string', ('Token_Name_type_string'));
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('AuthyGroup', 'App\\AuthyGroup', RelationMap::MANY_TO_ONE, array('id_group_creation' => 'id_authy_group', ), null, null);
        $this->addRelation('AuthyRelatedByIdCreation', 'App\\Authy', RelationMap::MANY_TO_ONE, array('id_creation' => 'id_authy', ), null, null);
        $this->addRelation('AuthyRelatedByIdModification', 'App\\Authy', RelationMap::MANY_TO_ONE, array('id_modification' => 'id_authy', ), null, null);
        $this->addRelation('Asset', 'App\\Asset', RelationMap::ONE_TO_MANY, array('id_token' => 'id_token', ), null, null, 'Assets');
        $this->addRelation('AssetExchange', 'App\\AssetExchange', RelationMap::ONE_TO_MANY, array('id_token' => 'id_token', ), null, null, 'AssetExchanges');
        $this->addRelation('Trade', 'App\\Trade', RelationMap::ONE_TO_MANY, array('id_token' => 'commission_asset', ), null, null, 'Trades');
        $this->addRelation('Symbol', 'App\\Symbol', RelationMap::ONE_TO_MANY, array('id_token' => 'id_token', ), null, null, 'Symbols');
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
  'add_search_columns' => '{"Ticker":[["ticker","%val"]]}',
  'set_parent_menu' => 'Settings',
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

} // TokenTableMap
