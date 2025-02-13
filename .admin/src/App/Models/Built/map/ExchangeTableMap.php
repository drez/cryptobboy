<?php

namespace App\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'exchange' table.
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
class ExchangeTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.map.ExchangeTableMap';

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
        $this->setName('exchange');
        $this->setPhpName('Exchange');
        $this->setClassname('App\\Exchange');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_exchange', 'IdExchange', 'INTEGER', true, 10, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 100, null);
        $this->addColumn('api_key', 'ApiKey', 'VARCHAR', false, 1, null);
        $this->addColumn('date_creation', 'DateCreation', 'TIMESTAMP', false, null, null);
        $this->addColumn('date_modification', 'DateModification', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('id_group_creation', 'IdGroupCreation', 'INTEGER', 'authy_group', 'id_authy_group', false, null, null);
        $this->addForeignKey('id_creation', 'IdCreation', 'INTEGER', 'authy', 'id_authy', false, null, null);
        $this->addForeignKey('id_modification', 'IdModification', 'INTEGER', 'authy', 'id_authy', false, null, null);
        // validators
        $this->addValidator('name', 'required', 'propel.validator.RequiredValidator', '', 'name_required');
        $this->addValidator('id_exchange', 'required', 'propel.validator.RequiredValidator', '', ('Exchange_IdExchange_required'));
        $this->addValidator('id_exchange', 'match', 'propel.validator.MatchValidator', '/^(?:[0-9]*|null)$/', ('Exchange_IdExchange_match_/^(?:[0-9]*|null)$/'));
        $this->addValidator('name', 'type', 'propel.validator.TypeValidator', 'string', ('Exchange_Name_type_string'));
        $this->addValidator('api_key', 'type', 'propel.validator.TypeValidator', 'string', ('Exchange_ApiKey_type_string'));
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('AuthyGroup', 'App\\AuthyGroup', RelationMap::MANY_TO_ONE, array('id_group_creation' => 'id_authy_group', ), null, null);
        $this->addRelation('AuthyRelatedByIdCreation', 'App\\Authy', RelationMap::MANY_TO_ONE, array('id_creation' => 'id_authy', ), null, null);
        $this->addRelation('AuthyRelatedByIdModification', 'App\\Authy', RelationMap::MANY_TO_ONE, array('id_modification' => 'id_authy', ), null, null);
        $this->addRelation('AssetExchange', 'App\\AssetExchange', RelationMap::ONE_TO_MANY, array('id_exchange' => 'id_exchange', ), null, null, 'AssetExchanges');
        $this->addRelation('Trade', 'App\\Trade', RelationMap::ONE_TO_MANY, array('id_exchange' => 'id_exchange', ), null, null, 'Trades');
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

} // ExchangeTableMap
