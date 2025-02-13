<?php

namespace App\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use App\AuthyGroupPeer;
use App\AuthyPeer;
use App\Template;
use App\TemplateFilePeer;
use App\TemplatePeer;
use App\map\TemplateTableMap;

/**
 * Base static class for performing query and update operations on the 'template' table.
 *
 * Template
 *
 * @package propel.generator..om
 */
abstract class BaseTemplatePeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'cryptobboy';

    /** the table name for this class */
    const TABLE_NAME = 'template';

    /** the related Propel class for this table */
    const OM_CLASS = 'App\\Template';

    /** the related TableMap class for this table */
    const TM_CLASS = 'App\\map\\TemplateTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 13;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 13;

    /** the column name for the id_template field */
    const ID_TEMPLATE = 'template.id_template';

    /** the column name for the name field */
    const NAME = 'template.name';

    /** the column name for the subject field */
    const SUBJECT = 'template.subject';

    /** the column name for the color_1 field */
    const COLOR_1 = 'template.color_1';

    /** the column name for the color_2 field */
    const COLOR_2 = 'template.color_2';

    /** the column name for the color_3 field */
    const COLOR_3 = 'template.color_3';

    /** the column name for the status field */
    const STATUS = 'template.status';

    /** the column name for the body field */
    const BODY = 'template.body';

    /** the column name for the date_creation field */
    const DATE_CREATION = 'template.date_creation';

    /** the column name for the date_modification field */
    const DATE_MODIFICATION = 'template.date_modification';

    /** the column name for the id_group_creation field */
    const ID_GROUP_CREATION = 'template.id_group_creation';

    /** the column name for the id_creation field */
    const ID_CREATION = 'template.id_creation';

    /** the column name for the id_modification field */
    const ID_MODIFICATION = 'template.id_modification';

    /** The enumerated values for the status field */
    const STATUS_ACTIVE = 'Active';
    const STATUS_INACTIVE = 'Inactive';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of Template objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Template[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. TemplatePeer::$fieldNames[TemplatePeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('IdTemplate', 'Name', 'Subject', 'Color1', 'Color2', 'Color3', 'Status', 'Body', 'DateCreation', 'DateModification', 'IdGroupCreation', 'IdCreation', 'IdModification', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idTemplate', 'name', 'subject', 'color1', 'color2', 'color3', 'status', 'body', 'dateCreation', 'dateModification', 'idGroupCreation', 'idCreation', 'idModification', ),
        BasePeer::TYPE_COLNAME => array (TemplatePeer::ID_TEMPLATE, TemplatePeer::NAME, TemplatePeer::SUBJECT, TemplatePeer::COLOR_1, TemplatePeer::COLOR_2, TemplatePeer::COLOR_3, TemplatePeer::STATUS, TemplatePeer::BODY, TemplatePeer::DATE_CREATION, TemplatePeer::DATE_MODIFICATION, TemplatePeer::ID_GROUP_CREATION, TemplatePeer::ID_CREATION, TemplatePeer::ID_MODIFICATION, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_TEMPLATE', 'NAME', 'SUBJECT', 'COLOR_1', 'COLOR_2', 'COLOR_3', 'STATUS', 'BODY', 'DATE_CREATION', 'DATE_MODIFICATION', 'ID_GROUP_CREATION', 'ID_CREATION', 'ID_MODIFICATION', ),
        BasePeer::TYPE_FIELDNAME => array ('id_template', 'name', 'subject', 'color_1', 'color_2', 'color_3', 'status', 'body', 'date_creation', 'date_modification', 'id_group_creation', 'id_creation', 'id_modification', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. TemplatePeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('IdTemplate' => 0, 'Name' => 1, 'Subject' => 2, 'Color1' => 3, 'Color2' => 4, 'Color3' => 5, 'Status' => 6, 'Body' => 7, 'DateCreation' => 8, 'DateModification' => 9, 'IdGroupCreation' => 10, 'IdCreation' => 11, 'IdModification' => 12, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idTemplate' => 0, 'name' => 1, 'subject' => 2, 'color1' => 3, 'color2' => 4, 'color3' => 5, 'status' => 6, 'body' => 7, 'dateCreation' => 8, 'dateModification' => 9, 'idGroupCreation' => 10, 'idCreation' => 11, 'idModification' => 12, ),
        BasePeer::TYPE_COLNAME => array (TemplatePeer::ID_TEMPLATE => 0, TemplatePeer::NAME => 1, TemplatePeer::SUBJECT => 2, TemplatePeer::COLOR_1 => 3, TemplatePeer::COLOR_2 => 4, TemplatePeer::COLOR_3 => 5, TemplatePeer::STATUS => 6, TemplatePeer::BODY => 7, TemplatePeer::DATE_CREATION => 8, TemplatePeer::DATE_MODIFICATION => 9, TemplatePeer::ID_GROUP_CREATION => 10, TemplatePeer::ID_CREATION => 11, TemplatePeer::ID_MODIFICATION => 12, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_TEMPLATE' => 0, 'NAME' => 1, 'SUBJECT' => 2, 'COLOR_1' => 3, 'COLOR_2' => 4, 'COLOR_3' => 5, 'STATUS' => 6, 'BODY' => 7, 'DATE_CREATION' => 8, 'DATE_MODIFICATION' => 9, 'ID_GROUP_CREATION' => 10, 'ID_CREATION' => 11, 'ID_MODIFICATION' => 12, ),
        BasePeer::TYPE_FIELDNAME => array ('id_template' => 0, 'name' => 1, 'subject' => 2, 'color_1' => 3, 'color_2' => 4, 'color_3' => 5, 'status' => 6, 'body' => 7, 'date_creation' => 8, 'date_modification' => 9, 'id_group_creation' => 10, 'id_creation' => 11, 'id_modification' => 12, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
        TemplatePeer::STATUS => array(
            TemplatePeer::STATUS_ACTIVE,
            TemplatePeer::STATUS_INACTIVE,
        ),
    );

    /**
     * Translates a fieldname to another type
     *
     * @param      string $name field name
     * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param      string $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = TemplatePeer::getFieldNames($toType);
        $key = isset(TemplatePeer::$fieldKeys[$fromType][$name]) ? TemplatePeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(TemplatePeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param      string $type The type of fieldnames to return:
     *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, TemplatePeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return TemplatePeer::$fieldNames[$type];
    }

    /**
     * Gets the list of values for all ENUM columns
     * @return array
     */
    public static function getValueSets()
    {
      return TemplatePeer::$enumValueSets;
    }

    /**
     * Gets the list of values for an ENUM column
     *
     * @param string $colname The ENUM column name.
     *
     * @return array list of possible values for the column
     */
    public static function getValueSet($colname)
    {
        $valueSets = TemplatePeer::getValueSets();

        if (!isset($valueSets[$colname])) {
            throw new PropelException(sprintf('Column "%s" has no ValueSet.', $colname));
        }

        return $valueSets[$colname];
    }

    /**
     * Gets the SQL value for the ENUM column value
     *
     * @param string $colname ENUM column name.
     * @param string $enumVal ENUM value.
     *
     * @return int SQL value
     */
    public static function getSqlValueForEnum($colname, $enumVal)
    {
        $values = TemplatePeer::getValueSet($colname);
        if (!in_array($enumVal, $values)) {
            throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $colname));
        }

        return array_search($enumVal, $values);
    }

    /**
     * Convenience method which changes table.column to alias.column.
     *
     * Using this method you can maintain SQL abstraction while using column aliases.
     * <code>
     *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
     *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
     * </code>
     * @param      string $alias The alias for the current table.
     * @param      string $column The column name for current table. (i.e. TemplatePeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(TemplatePeer::TABLE_NAME.'.', $alias.'.', $column);
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param      Criteria $criteria object containing the columns to add.
     * @param      string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(TemplatePeer::ID_TEMPLATE);
            $criteria->addSelectColumn(TemplatePeer::NAME);
            $criteria->addSelectColumn(TemplatePeer::SUBJECT);
            $criteria->addSelectColumn(TemplatePeer::COLOR_1);
            $criteria->addSelectColumn(TemplatePeer::COLOR_2);
            $criteria->addSelectColumn(TemplatePeer::COLOR_3);
            $criteria->addSelectColumn(TemplatePeer::STATUS);
            $criteria->addSelectColumn(TemplatePeer::BODY);
            $criteria->addSelectColumn(TemplatePeer::DATE_CREATION);
            $criteria->addSelectColumn(TemplatePeer::DATE_MODIFICATION);
            $criteria->addSelectColumn(TemplatePeer::ID_GROUP_CREATION);
            $criteria->addSelectColumn(TemplatePeer::ID_CREATION);
            $criteria->addSelectColumn(TemplatePeer::ID_MODIFICATION);
        } else {
            $criteria->addSelectColumn($alias . '.id_template');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.subject');
            $criteria->addSelectColumn($alias . '.color_1');
            $criteria->addSelectColumn($alias . '.color_2');
            $criteria->addSelectColumn($alias . '.color_3');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.body');
            $criteria->addSelectColumn($alias . '.date_creation');
            $criteria->addSelectColumn($alias . '.date_modification');
            $criteria->addSelectColumn($alias . '.id_group_creation');
            $criteria->addSelectColumn($alias . '.id_creation');
            $criteria->addSelectColumn($alias . '.id_modification');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @return int Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(TemplatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TemplatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(TemplatePeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(TemplatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        // BasePeer returns a PDOStatement
        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }
    /**
     * Selects one object from the DB.
     *
     * @param      Criteria $criteria object used to create the SELECT statement.
     * @param      PropelPDO $con
     * @return Template
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = TemplatePeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }
    /**
     * Selects several row from the DB.
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con
     * @return array           Array of selected Objects
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return TemplatePeer::populateObjects(TemplatePeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement directly (for example
     * to perform your own object hydration).
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return PDOStatement The executed PDOStatement object.
     * @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(TemplatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            TemplatePeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(TemplatePeer::DATABASE_NAME);

        // BasePeer returns a PDOStatement
        return BasePeer::doSelect($criteria, $con);
    }
    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doSelect*()
     * methods in your stub classes -- you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by doSelect*()
     * and retrieveByPK*() calls.
     *
     * @param Template $obj A Template object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getIdTemplate();
            } // if key === null
            TemplatePeer::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param      mixed $value A Template object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Template) {
                $key = (string) $value->getIdTemplate();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Template object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(TemplatePeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return Template Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(TemplatePeer::$instances[$key])) {
                return TemplatePeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }

    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool($and_clear_all_references = false)
    {
      if ($and_clear_all_references) {
        foreach (TemplatePeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        TemplatePeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to template
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in TemplateFilePeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        TemplateFilePeer::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol] === null) {
            return null;
        }

        return (string) $row[$startcol];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return (int) $row[$startcol];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = TemplatePeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = TemplatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = TemplatePeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TemplatePeer::addInstanceToPool($obj, $key);
            } // if key exists
        }
        $stmt->closeCursor();

        return $results;
    }
    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return array (Template object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = TemplatePeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = TemplatePeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + TemplatePeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TemplatePeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            TemplatePeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * Gets the SQL value for Status ENUM value
     *
     * @param  string $enumVal ENUM value to get SQL value for
     * @return int SQL value
     */
    public static function getStatusSqlValue($enumVal)
    {
        return TemplatePeer::getSqlValueForEnum(TemplatePeer::STATUS, $enumVal);
    }


    /**
     * Returns the number of rows matching criteria, joining the related AuthyGroup table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAuthyGroup(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(TemplatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TemplatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(TemplatePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TemplatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TemplatePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related AuthyRelatedByIdCreation table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAuthyRelatedByIdCreation(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(TemplatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TemplatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(TemplatePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TemplatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TemplatePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related AuthyRelatedByIdModification table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAuthyRelatedByIdModification(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(TemplatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TemplatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(TemplatePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TemplatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TemplatePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of Template objects pre-filled with their AuthyGroup objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Template objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAuthyGroup(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(TemplatePeer::DATABASE_NAME);
        }

        TemplatePeer::addSelectColumns($criteria);
        $startcol = TemplatePeer::NUM_HYDRATE_COLUMNS;
        AuthyGroupPeer::addSelectColumns($criteria);

        $criteria->addJoin(TemplatePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TemplatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TemplatePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = TemplatePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TemplatePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AuthyGroupPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AuthyGroupPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AuthyGroupPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AuthyGroupPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Template) to $obj2 (AuthyGroup)
                $obj2->addTemplate($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Template objects pre-filled with their Authy objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Template objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAuthyRelatedByIdCreation(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(TemplatePeer::DATABASE_NAME);
        }

        TemplatePeer::addSelectColumns($criteria);
        $startcol = TemplatePeer::NUM_HYDRATE_COLUMNS;
        AuthyPeer::addSelectColumns($criteria);

        $criteria->addJoin(TemplatePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TemplatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TemplatePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = TemplatePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TemplatePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AuthyPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AuthyPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AuthyPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Template) to $obj2 (Authy)
                $obj2->addTemplateRelatedByIdCreation($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Template objects pre-filled with their Authy objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Template objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAuthyRelatedByIdModification(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(TemplatePeer::DATABASE_NAME);
        }

        TemplatePeer::addSelectColumns($criteria);
        $startcol = TemplatePeer::NUM_HYDRATE_COLUMNS;
        AuthyPeer::addSelectColumns($criteria);

        $criteria->addJoin(TemplatePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TemplatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TemplatePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = TemplatePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TemplatePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AuthyPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AuthyPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AuthyPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Template) to $obj2 (Authy)
                $obj2->addTemplateRelatedByIdModification($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining all related tables
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(TemplatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TemplatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(TemplatePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TemplatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TemplatePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(TemplatePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(TemplatePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    /**
     * Selects a collection of Template objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Template objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(TemplatePeer::DATABASE_NAME);
        }

        TemplatePeer::addSelectColumns($criteria);
        $startcol2 = TemplatePeer::NUM_HYDRATE_COLUMNS;

        AuthyGroupPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AuthyGroupPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(TemplatePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(TemplatePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(TemplatePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TemplatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TemplatePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = TemplatePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TemplatePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined AuthyGroup rows

            $key2 = AuthyGroupPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = AuthyGroupPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AuthyGroupPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AuthyGroupPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (Template) to the collection in $obj2 (AuthyGroup)
                $obj2->addTemplate($obj1);
            } // if joined row not null

            // Add objects for joined Authy rows

            $key3 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = AuthyPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = AuthyPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AuthyPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (Template) to the collection in $obj3 (Authy)
                $obj3->addTemplateRelatedByIdCreation($obj1);
            } // if joined row not null

            // Add objects for joined Authy rows

            $key4 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol4);
            if ($key4 !== null) {
                $obj4 = AuthyPeer::getInstanceFromPool($key4);
                if (!$obj4) {

                    $cls = AuthyPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    AuthyPeer::addInstanceToPool($obj4, $key4);
                } // if obj4 loaded

                // Add the $obj1 (Template) to the collection in $obj4 (Authy)
                $obj4->addTemplateRelatedByIdModification($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related AuthyGroup table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptAuthyGroup(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(TemplatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TemplatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(TemplatePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TemplatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TemplatePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(TemplatePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related AuthyRelatedByIdCreation table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptAuthyRelatedByIdCreation(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(TemplatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TemplatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(TemplatePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TemplatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TemplatePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related AuthyRelatedByIdModification table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptAuthyRelatedByIdModification(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(TemplatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TemplatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(TemplatePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TemplatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TemplatePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of Template objects pre-filled with all related objects except AuthyGroup.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Template objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptAuthyGroup(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(TemplatePeer::DATABASE_NAME);
        }

        TemplatePeer::addSelectColumns($criteria);
        $startcol2 = TemplatePeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(TemplatePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(TemplatePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TemplatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TemplatePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = TemplatePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TemplatePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Authy rows

                $key2 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AuthyPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AuthyPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AuthyPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Template) to the collection in $obj2 (Authy)
                $obj2->addTemplateRelatedByIdCreation($obj1);

            } // if joined row is not null

                // Add objects for joined Authy rows

                $key3 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = AuthyPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = AuthyPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AuthyPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Template) to the collection in $obj3 (Authy)
                $obj3->addTemplateRelatedByIdModification($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Template objects pre-filled with all related objects except AuthyRelatedByIdCreation.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Template objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptAuthyRelatedByIdCreation(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(TemplatePeer::DATABASE_NAME);
        }

        TemplatePeer::addSelectColumns($criteria);
        $startcol2 = TemplatePeer::NUM_HYDRATE_COLUMNS;

        AuthyGroupPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AuthyGroupPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(TemplatePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TemplatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TemplatePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = TemplatePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TemplatePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined AuthyGroup rows

                $key2 = AuthyGroupPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AuthyGroupPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AuthyGroupPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AuthyGroupPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Template) to the collection in $obj2 (AuthyGroup)
                $obj2->addTemplate($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Template objects pre-filled with all related objects except AuthyRelatedByIdModification.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Template objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptAuthyRelatedByIdModification(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(TemplatePeer::DATABASE_NAME);
        }

        TemplatePeer::addSelectColumns($criteria);
        $startcol2 = TemplatePeer::NUM_HYDRATE_COLUMNS;

        AuthyGroupPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AuthyGroupPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(TemplatePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TemplatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TemplatePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = TemplatePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TemplatePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined AuthyGroup rows

                $key2 = AuthyGroupPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AuthyGroupPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AuthyGroupPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AuthyGroupPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Template) to the collection in $obj2 (AuthyGroup)
                $obj2->addTemplate($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(TemplatePeer::DATABASE_NAME)->getTable(TemplatePeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseTemplatePeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseTemplatePeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \App\map\TemplateTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass($row = 0, $colnum = 0)
    {
        return TemplatePeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Template or Criteria object.
     *
     * @param      mixed $values Criteria or Template object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(TemplatePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Template object
        }

        if ($criteria->containsKey(TemplatePeer::ID_TEMPLATE) && $criteria->keyContainsValue(TemplatePeer::ID_TEMPLATE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TemplatePeer::ID_TEMPLATE.')');
        }


        // Set the correct dbName
        $criteria->setDbName(TemplatePeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a Template or Criteria object.
     *
     * @param      mixed $values Criteria or Template object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(TemplatePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(TemplatePeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(TemplatePeer::ID_TEMPLATE);
            $value = $criteria->remove(TemplatePeer::ID_TEMPLATE);
            if ($value) {
                $selectCriteria->add(TemplatePeer::ID_TEMPLATE, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(TemplatePeer::TABLE_NAME);
            }

        } else { // $values is Template object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(TemplatePeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the template table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(TemplatePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(TemplatePeer::TABLE_NAME, $con, TemplatePeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TemplatePeer::clearInstancePool();
            TemplatePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Template or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Template object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param      PropelPDO $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *				if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(TemplatePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            TemplatePeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Template) { // it's a model object
            // invalidate the cache for this single object
            TemplatePeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TemplatePeer::DATABASE_NAME);
            $criteria->add(TemplatePeer::ID_TEMPLATE, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                TemplatePeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(TemplatePeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            TemplatePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Template object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param Template $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(TemplatePeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(TemplatePeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        if ($obj->isNew() || $obj->isColumnModified(TemplatePeer::NAME))
            $columns[TemplatePeer::NAME] = $obj->getName();

        if ($obj->isNew() || $obj->isColumnModified(TemplatePeer::NAME))
            $columns[TemplatePeer::NAME] = $obj->getName();

        if ($obj->isNew() || $obj->isColumnModified(TemplatePeer::SUBJECT))
            $columns[TemplatePeer::SUBJECT] = $obj->getSubject();

        if ($obj->isNew() || $obj->isColumnModified(TemplatePeer::COLOR_1))
            $columns[TemplatePeer::COLOR_1] = $obj->getColor1();

        if ($obj->isNew() || $obj->isColumnModified(TemplatePeer::COLOR_2))
            $columns[TemplatePeer::COLOR_2] = $obj->getColor2();

        if ($obj->isNew() || $obj->isColumnModified(TemplatePeer::COLOR_3))
            $columns[TemplatePeer::COLOR_3] = $obj->getColor3();

        if ($obj->isNew() || $obj->isColumnModified(TemplatePeer::STATUS))
            $columns[TemplatePeer::STATUS] = $obj->getStatus();

        if ($obj->isNew() || $obj->isColumnModified(TemplatePeer::STATUS))
            $columns[TemplatePeer::STATUS] = $obj->getStatus();

        if ($obj->isNew() || $obj->isColumnModified(TemplatePeer::BODY))
            $columns[TemplatePeer::BODY] = $obj->getBody();

        }

        return BasePeer::doValidate(TemplatePeer::DATABASE_NAME, TemplatePeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Template
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = TemplatePeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(TemplatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(TemplatePeer::DATABASE_NAME);
        $criteria->add(TemplatePeer::ID_TEMPLATE, $pk);

        $v = TemplatePeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Template[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(TemplatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(TemplatePeer::DATABASE_NAME);
            $criteria->add(TemplatePeer::ID_TEMPLATE, $pks, Criteria::IN);
            $objs = TemplatePeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseTemplatePeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseTemplatePeer::buildTableMap();

