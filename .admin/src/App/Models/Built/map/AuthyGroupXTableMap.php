<?php

namespace App\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'authy_group_x' table.
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
class AuthyGroupXTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.map.AuthyGroupXTableMap';

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
        $this->setName('authy_group_x');
        $this->setPhpName('AuthyGroupX');
        $this->setClassname('App\\AuthyGroupX');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        $this->setIsCrossRef(true);
        // columns
        $this->addForeignPrimaryKey('id_authy', 'IdAuthy', 'INTEGER' , 'authy', 'id_authy', true, null, null);
        $this->addForeignPrimaryKey('id_authy_group', 'IdAuthyGroup', 'INTEGER' , 'authy_group', 'id_authy_group', true, null, null);
        // validators
        $this->addValidator('id_authy', 'required', 'propel.validator.RequiredValidator', '', ('AuthyGroupX_IdAuthy_required'));
        $this->addValidator('id_authy', 'match', 'propel.validator.MatchValidator', '/^(?:[0-9]*|null)$/', ('AuthyGroupX_IdAuthy_match_/^(?:[0-9]*|null)$/'));
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('AuthyGroup', 'App\\AuthyGroup', RelationMap::MANY_TO_ONE, array('id_authy_group' => 'id_authy_group', ), 'CASCADE', null);
        $this->addRelation('Authy', 'App\\Authy', RelationMap::MANY_TO_ONE, array('id_authy' => 'id_authy', ), null, 'CASCADE');
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
            'add_tablestamp' =>  array (
  'create_column' => 'date_creation',
  'update_column' => 'date_modification',
  'create_id_column' => 'id_creation',
  'group_id_column' => 'id_group_creation',
  'update_id_column' => 'id_modification',
  'exclude' => 'all',
  'foreign_keys' => 'all',
),
            'GoatCheese' =>  array (
  'i18n_langs' => '["en_US"]',
  'parent_table' => 'authy',
  'checkbox_all_child' => 'yes',
),
            'add_validator' =>  array (
),
        );
    } // getBehaviors()

} // AuthyGroupXTableMap
