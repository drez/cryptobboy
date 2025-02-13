<?php

namespace App\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use App\AssetExchange;
use App\AssetExchangePeer;
use App\AssetPeer;
use App\AuthyGroupPeer;
use App\AuthyPeer;
use App\ExchangePeer;
use App\TokenPeer;
use App\map\AssetExchangeTableMap;

/**
 * Base static class for performing query and update operations on the 'asset_exchange' table.
 *
 * Wallet
 *
 * @package propel.generator..om
 */
abstract class BaseAssetExchangePeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'cryptobboy';

    /** the table name for this class */
    const TABLE_NAME = 'asset_exchange';

    /** the related Propel class for this table */
    const OM_CLASS = 'App\\AssetExchange';

    /** the related TableMap class for this table */
    const TM_CLASS = 'App\\map\\AssetExchangeTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 13;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 13;

    /** the column name for the id_asset_exchange field */
    const ID_ASSET_EXCHANGE = 'asset_exchange.id_asset_exchange';

    /** the column name for the id_asset field */
    const ID_ASSET = 'asset_exchange.id_asset';

    /** the column name for the type field */
    const TYPE = 'asset_exchange.type';

    /** the column name for the id_exchange field */
    const ID_EXCHANGE = 'asset_exchange.id_exchange';

    /** the column name for the id_token field */
    const ID_TOKEN = 'asset_exchange.id_token';

    /** the column name for the free_token field */
    const FREE_TOKEN = 'asset_exchange.free_token';

    /** the column name for the locked_token field */
    const LOCKED_TOKEN = 'asset_exchange.locked_token';

    /** the column name for the freeze_token field */
    const FREEZE_TOKEN = 'asset_exchange.freeze_token';

    /** the column name for the date_creation field */
    const DATE_CREATION = 'asset_exchange.date_creation';

    /** the column name for the date_modification field */
    const DATE_MODIFICATION = 'asset_exchange.date_modification';

    /** the column name for the id_group_creation field */
    const ID_GROUP_CREATION = 'asset_exchange.id_group_creation';

    /** the column name for the id_creation field */
    const ID_CREATION = 'asset_exchange.id_creation';

    /** the column name for the id_modification field */
    const ID_MODIFICATION = 'asset_exchange.id_modification';

    /** The enumerated values for the type field */
    const TYPE_SPOT = 'Spot';
    const TYPE_LOCKED = 'Locked';
    const TYPE_FLEXIBLE = 'Flexible';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of AssetExchange objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array AssetExchange[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. AssetExchangePeer::$fieldNames[AssetExchangePeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('IdAssetExchange', 'IdAsset', 'Type', 'IdExchange', 'IdToken', 'FreeToken', 'LockedToken', 'FreezeToken', 'DateCreation', 'DateModification', 'IdGroupCreation', 'IdCreation', 'IdModification', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idAssetExchange', 'idAsset', 'type', 'idExchange', 'idToken', 'freeToken', 'lockedToken', 'freezeToken', 'dateCreation', 'dateModification', 'idGroupCreation', 'idCreation', 'idModification', ),
        BasePeer::TYPE_COLNAME => array (AssetExchangePeer::ID_ASSET_EXCHANGE, AssetExchangePeer::ID_ASSET, AssetExchangePeer::TYPE, AssetExchangePeer::ID_EXCHANGE, AssetExchangePeer::ID_TOKEN, AssetExchangePeer::FREE_TOKEN, AssetExchangePeer::LOCKED_TOKEN, AssetExchangePeer::FREEZE_TOKEN, AssetExchangePeer::DATE_CREATION, AssetExchangePeer::DATE_MODIFICATION, AssetExchangePeer::ID_GROUP_CREATION, AssetExchangePeer::ID_CREATION, AssetExchangePeer::ID_MODIFICATION, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_ASSET_EXCHANGE', 'ID_ASSET', 'TYPE', 'ID_EXCHANGE', 'ID_TOKEN', 'FREE_TOKEN', 'LOCKED_TOKEN', 'FREEZE_TOKEN', 'DATE_CREATION', 'DATE_MODIFICATION', 'ID_GROUP_CREATION', 'ID_CREATION', 'ID_MODIFICATION', ),
        BasePeer::TYPE_FIELDNAME => array ('id_asset_exchange', 'id_asset', 'type', 'id_exchange', 'id_token', 'free_token', 'locked_token', 'freeze_token', 'date_creation', 'date_modification', 'id_group_creation', 'id_creation', 'id_modification', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. AssetExchangePeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('IdAssetExchange' => 0, 'IdAsset' => 1, 'Type' => 2, 'IdExchange' => 3, 'IdToken' => 4, 'FreeToken' => 5, 'LockedToken' => 6, 'FreezeToken' => 7, 'DateCreation' => 8, 'DateModification' => 9, 'IdGroupCreation' => 10, 'IdCreation' => 11, 'IdModification' => 12, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idAssetExchange' => 0, 'idAsset' => 1, 'type' => 2, 'idExchange' => 3, 'idToken' => 4, 'freeToken' => 5, 'lockedToken' => 6, 'freezeToken' => 7, 'dateCreation' => 8, 'dateModification' => 9, 'idGroupCreation' => 10, 'idCreation' => 11, 'idModification' => 12, ),
        BasePeer::TYPE_COLNAME => array (AssetExchangePeer::ID_ASSET_EXCHANGE => 0, AssetExchangePeer::ID_ASSET => 1, AssetExchangePeer::TYPE => 2, AssetExchangePeer::ID_EXCHANGE => 3, AssetExchangePeer::ID_TOKEN => 4, AssetExchangePeer::FREE_TOKEN => 5, AssetExchangePeer::LOCKED_TOKEN => 6, AssetExchangePeer::FREEZE_TOKEN => 7, AssetExchangePeer::DATE_CREATION => 8, AssetExchangePeer::DATE_MODIFICATION => 9, AssetExchangePeer::ID_GROUP_CREATION => 10, AssetExchangePeer::ID_CREATION => 11, AssetExchangePeer::ID_MODIFICATION => 12, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_ASSET_EXCHANGE' => 0, 'ID_ASSET' => 1, 'TYPE' => 2, 'ID_EXCHANGE' => 3, 'ID_TOKEN' => 4, 'FREE_TOKEN' => 5, 'LOCKED_TOKEN' => 6, 'FREEZE_TOKEN' => 7, 'DATE_CREATION' => 8, 'DATE_MODIFICATION' => 9, 'ID_GROUP_CREATION' => 10, 'ID_CREATION' => 11, 'ID_MODIFICATION' => 12, ),
        BasePeer::TYPE_FIELDNAME => array ('id_asset_exchange' => 0, 'id_asset' => 1, 'type' => 2, 'id_exchange' => 3, 'id_token' => 4, 'free_token' => 5, 'locked_token' => 6, 'freeze_token' => 7, 'date_creation' => 8, 'date_modification' => 9, 'id_group_creation' => 10, 'id_creation' => 11, 'id_modification' => 12, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
        AssetExchangePeer::TYPE => array(
            AssetExchangePeer::TYPE_SPOT,
            AssetExchangePeer::TYPE_LOCKED,
            AssetExchangePeer::TYPE_FLEXIBLE,
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
        $toNames = AssetExchangePeer::getFieldNames($toType);
        $key = isset(AssetExchangePeer::$fieldKeys[$fromType][$name]) ? AssetExchangePeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(AssetExchangePeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, AssetExchangePeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return AssetExchangePeer::$fieldNames[$type];
    }

    /**
     * Gets the list of values for all ENUM columns
     * @return array
     */
    public static function getValueSets()
    {
      return AssetExchangePeer::$enumValueSets;
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
        $valueSets = AssetExchangePeer::getValueSets();

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
        $values = AssetExchangePeer::getValueSet($colname);
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
     * @param      string $column The column name for current table. (i.e. AssetExchangePeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(AssetExchangePeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(AssetExchangePeer::ID_ASSET_EXCHANGE);
            $criteria->addSelectColumn(AssetExchangePeer::ID_ASSET);
            $criteria->addSelectColumn(AssetExchangePeer::TYPE);
            $criteria->addSelectColumn(AssetExchangePeer::ID_EXCHANGE);
            $criteria->addSelectColumn(AssetExchangePeer::ID_TOKEN);
            $criteria->addSelectColumn(AssetExchangePeer::FREE_TOKEN);
            $criteria->addSelectColumn(AssetExchangePeer::LOCKED_TOKEN);
            $criteria->addSelectColumn(AssetExchangePeer::FREEZE_TOKEN);
            $criteria->addSelectColumn(AssetExchangePeer::DATE_CREATION);
            $criteria->addSelectColumn(AssetExchangePeer::DATE_MODIFICATION);
            $criteria->addSelectColumn(AssetExchangePeer::ID_GROUP_CREATION);
            $criteria->addSelectColumn(AssetExchangePeer::ID_CREATION);
            $criteria->addSelectColumn(AssetExchangePeer::ID_MODIFICATION);
        } else {
            $criteria->addSelectColumn($alias . '.id_asset_exchange');
            $criteria->addSelectColumn($alias . '.id_asset');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.id_exchange');
            $criteria->addSelectColumn($alias . '.id_token');
            $criteria->addSelectColumn($alias . '.free_token');
            $criteria->addSelectColumn($alias . '.locked_token');
            $criteria->addSelectColumn($alias . '.freeze_token');
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
        $criteria->setPrimaryTableName(AssetExchangePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AssetExchangePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return AssetExchange
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = AssetExchangePeer::doSelect($critcopy, $con);
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
        return AssetExchangePeer::populateObjects(AssetExchangePeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            AssetExchangePeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);

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
     * @param AssetExchange $obj A AssetExchange object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getIdAssetExchange();
            } // if key === null
            AssetExchangePeer::$instances[$key] = $obj;
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
     * @param      mixed $value A AssetExchange object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof AssetExchange) {
                $key = (string) $value->getIdAssetExchange();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or AssetExchange object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(AssetExchangePeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return AssetExchange Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(AssetExchangePeer::$instances[$key])) {
                return AssetExchangePeer::$instances[$key];
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
        foreach (AssetExchangePeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        AssetExchangePeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to asset_exchange
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
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
        $cls = AssetExchangePeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = AssetExchangePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = AssetExchangePeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AssetExchangePeer::addInstanceToPool($obj, $key);
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
     * @return array (AssetExchange object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = AssetExchangePeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = AssetExchangePeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + AssetExchangePeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AssetExchangePeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            AssetExchangePeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * Gets the SQL value for Type ENUM value
     *
     * @param  string $enumVal ENUM value to get SQL value for
     * @return int SQL value
     */
    public static function getTypeSqlValue($enumVal)
    {
        return AssetExchangePeer::getSqlValueForEnum(AssetExchangePeer::TYPE, $enumVal);
    }


    /**
     * Returns the number of rows matching criteria, joining the related Asset table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAsset(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AssetExchangePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AssetExchangePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AssetExchangePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Exchange table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinExchange(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AssetExchangePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AssetExchangePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AssetExchangePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Token table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinToken(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AssetExchangePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AssetExchangePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AssetExchangePeer::ID_TOKEN, TokenPeer::ID_TOKEN, $join_behavior);

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
        $criteria->setPrimaryTableName(AssetExchangePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AssetExchangePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AssetExchangePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

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
        $criteria->setPrimaryTableName(AssetExchangePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AssetExchangePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AssetExchangePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

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
        $criteria->setPrimaryTableName(AssetExchangePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AssetExchangePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AssetExchangePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

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
     * Selects a collection of AssetExchange objects pre-filled with their Asset objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AssetExchange objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAsset(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);
        }

        AssetExchangePeer::addSelectColumns($criteria);
        $startcol = AssetExchangePeer::NUM_HYDRATE_COLUMNS;
        AssetPeer::addSelectColumns($criteria);

        $criteria->addJoin(AssetExchangePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AssetExchangePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AssetExchangePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AssetExchangePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AssetExchangePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AssetPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AssetPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AssetPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AssetPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (AssetExchange) to $obj2 (Asset)
                $obj2->addAssetExchange($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AssetExchange objects pre-filled with their Exchange objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AssetExchange objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinExchange(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);
        }

        AssetExchangePeer::addSelectColumns($criteria);
        $startcol = AssetExchangePeer::NUM_HYDRATE_COLUMNS;
        ExchangePeer::addSelectColumns($criteria);

        $criteria->addJoin(AssetExchangePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AssetExchangePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AssetExchangePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AssetExchangePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AssetExchangePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = ExchangePeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = ExchangePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = ExchangePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    ExchangePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (AssetExchange) to $obj2 (Exchange)
                $obj2->addAssetExchange($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AssetExchange objects pre-filled with their Token objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AssetExchange objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinToken(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);
        }

        AssetExchangePeer::addSelectColumns($criteria);
        $startcol = AssetExchangePeer::NUM_HYDRATE_COLUMNS;
        TokenPeer::addSelectColumns($criteria);

        $criteria->addJoin(AssetExchangePeer::ID_TOKEN, TokenPeer::ID_TOKEN, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AssetExchangePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AssetExchangePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AssetExchangePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AssetExchangePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = TokenPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = TokenPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = TokenPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    TokenPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (AssetExchange) to $obj2 (Token)
                $obj2->addAssetExchange($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AssetExchange objects pre-filled with their AuthyGroup objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AssetExchange objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAuthyGroup(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);
        }

        AssetExchangePeer::addSelectColumns($criteria);
        $startcol = AssetExchangePeer::NUM_HYDRATE_COLUMNS;
        AuthyGroupPeer::addSelectColumns($criteria);

        $criteria->addJoin(AssetExchangePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AssetExchangePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AssetExchangePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AssetExchangePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AssetExchangePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (AssetExchange) to $obj2 (AuthyGroup)
                $obj2->addAssetExchange($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AssetExchange objects pre-filled with their Authy objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AssetExchange objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAuthyRelatedByIdCreation(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);
        }

        AssetExchangePeer::addSelectColumns($criteria);
        $startcol = AssetExchangePeer::NUM_HYDRATE_COLUMNS;
        AuthyPeer::addSelectColumns($criteria);

        $criteria->addJoin(AssetExchangePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AssetExchangePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AssetExchangePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AssetExchangePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AssetExchangePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (AssetExchange) to $obj2 (Authy)
                $obj2->addAssetExchangeRelatedByIdCreation($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AssetExchange objects pre-filled with their Authy objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AssetExchange objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAuthyRelatedByIdModification(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);
        }

        AssetExchangePeer::addSelectColumns($criteria);
        $startcol = AssetExchangePeer::NUM_HYDRATE_COLUMNS;
        AuthyPeer::addSelectColumns($criteria);

        $criteria->addJoin(AssetExchangePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AssetExchangePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AssetExchangePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AssetExchangePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AssetExchangePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (AssetExchange) to $obj2 (Authy)
                $obj2->addAssetExchangeRelatedByIdModification($obj1);

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
        $criteria->setPrimaryTableName(AssetExchangePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AssetExchangePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AssetExchangePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_TOKEN, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

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
     * Selects a collection of AssetExchange objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AssetExchange objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);
        }

        AssetExchangePeer::addSelectColumns($criteria);
        $startcol2 = AssetExchangePeer::NUM_HYDRATE_COLUMNS;

        AssetPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AssetPeer::NUM_HYDRATE_COLUMNS;

        ExchangePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + ExchangePeer::NUM_HYDRATE_COLUMNS;

        TokenPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + TokenPeer::NUM_HYDRATE_COLUMNS;

        AuthyGroupPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + AuthyGroupPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol8 = $startcol7 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AssetExchangePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_TOKEN, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AssetExchangePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AssetExchangePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AssetExchangePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AssetExchangePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined Asset rows

            $key2 = AssetPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = AssetPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AssetPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AssetPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj2 (Asset)
                $obj2->addAssetExchange($obj1);
            } // if joined row not null

            // Add objects for joined Exchange rows

            $key3 = ExchangePeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = ExchangePeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = ExchangePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    ExchangePeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj3 (Exchange)
                $obj3->addAssetExchange($obj1);
            } // if joined row not null

            // Add objects for joined Token rows

            $key4 = TokenPeer::getPrimaryKeyHashFromRow($row, $startcol4);
            if ($key4 !== null) {
                $obj4 = TokenPeer::getInstanceFromPool($key4);
                if (!$obj4) {

                    $cls = TokenPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    TokenPeer::addInstanceToPool($obj4, $key4);
                } // if obj4 loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj4 (Token)
                $obj4->addAssetExchange($obj1);
            } // if joined row not null

            // Add objects for joined AuthyGroup rows

            $key5 = AuthyGroupPeer::getPrimaryKeyHashFromRow($row, $startcol5);
            if ($key5 !== null) {
                $obj5 = AuthyGroupPeer::getInstanceFromPool($key5);
                if (!$obj5) {

                    $cls = AuthyGroupPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    AuthyGroupPeer::addInstanceToPool($obj5, $key5);
                } // if obj5 loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj5 (AuthyGroup)
                $obj5->addAssetExchange($obj1);
            } // if joined row not null

            // Add objects for joined Authy rows

            $key6 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol6);
            if ($key6 !== null) {
                $obj6 = AuthyPeer::getInstanceFromPool($key6);
                if (!$obj6) {

                    $cls = AuthyPeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    AuthyPeer::addInstanceToPool($obj6, $key6);
                } // if obj6 loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj6 (Authy)
                $obj6->addAssetExchangeRelatedByIdCreation($obj1);
            } // if joined row not null

            // Add objects for joined Authy rows

            $key7 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol7);
            if ($key7 !== null) {
                $obj7 = AuthyPeer::getInstanceFromPool($key7);
                if (!$obj7) {

                    $cls = AuthyPeer::getOMClass();

                    $obj7 = new $cls();
                    $obj7->hydrate($row, $startcol7);
                    AuthyPeer::addInstanceToPool($obj7, $key7);
                } // if obj7 loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj7 (Authy)
                $obj7->addAssetExchangeRelatedByIdModification($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Asset table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptAsset(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AssetExchangePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AssetExchangePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AssetExchangePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_TOKEN, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Exchange table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptExchange(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AssetExchangePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AssetExchangePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AssetExchangePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_TOKEN, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Token table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptToken(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AssetExchangePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AssetExchangePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AssetExchangePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

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
        $criteria->setPrimaryTableName(AssetExchangePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AssetExchangePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AssetExchangePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_TOKEN, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

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
        $criteria->setPrimaryTableName(AssetExchangePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AssetExchangePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AssetExchangePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_TOKEN, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

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
        $criteria->setPrimaryTableName(AssetExchangePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AssetExchangePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AssetExchangePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_TOKEN, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

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
     * Selects a collection of AssetExchange objects pre-filled with all related objects except Asset.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AssetExchange objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptAsset(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);
        }

        AssetExchangePeer::addSelectColumns($criteria);
        $startcol2 = AssetExchangePeer::NUM_HYDRATE_COLUMNS;

        ExchangePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ExchangePeer::NUM_HYDRATE_COLUMNS;

        TokenPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + TokenPeer::NUM_HYDRATE_COLUMNS;

        AuthyGroupPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + AuthyGroupPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AssetExchangePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_TOKEN, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AssetExchangePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AssetExchangePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AssetExchangePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AssetExchangePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Exchange rows

                $key2 = ExchangePeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = ExchangePeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = ExchangePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    ExchangePeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj2 (Exchange)
                $obj2->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined Token rows

                $key3 = TokenPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = TokenPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = TokenPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    TokenPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj3 (Token)
                $obj3->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined AuthyGroup rows

                $key4 = AuthyGroupPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = AuthyGroupPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = AuthyGroupPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    AuthyGroupPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj4 (AuthyGroup)
                $obj4->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined Authy rows

                $key5 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = AuthyPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = AuthyPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    AuthyPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj5 (Authy)
                $obj5->addAssetExchangeRelatedByIdCreation($obj1);

            } // if joined row is not null

                // Add objects for joined Authy rows

                $key6 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol6);
                if ($key6 !== null) {
                    $obj6 = AuthyPeer::getInstanceFromPool($key6);
                    if (!$obj6) {

                        $cls = AuthyPeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    AuthyPeer::addInstanceToPool($obj6, $key6);
                } // if $obj6 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj6 (Authy)
                $obj6->addAssetExchangeRelatedByIdModification($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AssetExchange objects pre-filled with all related objects except Exchange.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AssetExchange objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptExchange(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);
        }

        AssetExchangePeer::addSelectColumns($criteria);
        $startcol2 = AssetExchangePeer::NUM_HYDRATE_COLUMNS;

        AssetPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AssetPeer::NUM_HYDRATE_COLUMNS;

        TokenPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + TokenPeer::NUM_HYDRATE_COLUMNS;

        AuthyGroupPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + AuthyGroupPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AssetExchangePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_TOKEN, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AssetExchangePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AssetExchangePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AssetExchangePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AssetExchangePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Asset rows

                $key2 = AssetPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AssetPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AssetPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AssetPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj2 (Asset)
                $obj2->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined Token rows

                $key3 = TokenPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = TokenPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = TokenPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    TokenPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj3 (Token)
                $obj3->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined AuthyGroup rows

                $key4 = AuthyGroupPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = AuthyGroupPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = AuthyGroupPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    AuthyGroupPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj4 (AuthyGroup)
                $obj4->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined Authy rows

                $key5 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = AuthyPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = AuthyPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    AuthyPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj5 (Authy)
                $obj5->addAssetExchangeRelatedByIdCreation($obj1);

            } // if joined row is not null

                // Add objects for joined Authy rows

                $key6 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol6);
                if ($key6 !== null) {
                    $obj6 = AuthyPeer::getInstanceFromPool($key6);
                    if (!$obj6) {

                        $cls = AuthyPeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    AuthyPeer::addInstanceToPool($obj6, $key6);
                } // if $obj6 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj6 (Authy)
                $obj6->addAssetExchangeRelatedByIdModification($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AssetExchange objects pre-filled with all related objects except Token.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AssetExchange objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptToken(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);
        }

        AssetExchangePeer::addSelectColumns($criteria);
        $startcol2 = AssetExchangePeer::NUM_HYDRATE_COLUMNS;

        AssetPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AssetPeer::NUM_HYDRATE_COLUMNS;

        ExchangePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + ExchangePeer::NUM_HYDRATE_COLUMNS;

        AuthyGroupPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + AuthyGroupPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AssetExchangePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AssetExchangePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AssetExchangePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AssetExchangePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AssetExchangePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Asset rows

                $key2 = AssetPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AssetPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AssetPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AssetPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj2 (Asset)
                $obj2->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined Exchange rows

                $key3 = ExchangePeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = ExchangePeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = ExchangePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    ExchangePeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj3 (Exchange)
                $obj3->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined AuthyGroup rows

                $key4 = AuthyGroupPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = AuthyGroupPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = AuthyGroupPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    AuthyGroupPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj4 (AuthyGroup)
                $obj4->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined Authy rows

                $key5 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = AuthyPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = AuthyPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    AuthyPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj5 (Authy)
                $obj5->addAssetExchangeRelatedByIdCreation($obj1);

            } // if joined row is not null

                // Add objects for joined Authy rows

                $key6 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol6);
                if ($key6 !== null) {
                    $obj6 = AuthyPeer::getInstanceFromPool($key6);
                    if (!$obj6) {

                        $cls = AuthyPeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    AuthyPeer::addInstanceToPool($obj6, $key6);
                } // if $obj6 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj6 (Authy)
                $obj6->addAssetExchangeRelatedByIdModification($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AssetExchange objects pre-filled with all related objects except AuthyGroup.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AssetExchange objects.
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
            $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);
        }

        AssetExchangePeer::addSelectColumns($criteria);
        $startcol2 = AssetExchangePeer::NUM_HYDRATE_COLUMNS;

        AssetPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AssetPeer::NUM_HYDRATE_COLUMNS;

        ExchangePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + ExchangePeer::NUM_HYDRATE_COLUMNS;

        TokenPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + TokenPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AssetExchangePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_TOKEN, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AssetExchangePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AssetExchangePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AssetExchangePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AssetExchangePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Asset rows

                $key2 = AssetPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AssetPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AssetPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AssetPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj2 (Asset)
                $obj2->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined Exchange rows

                $key3 = ExchangePeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = ExchangePeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = ExchangePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    ExchangePeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj3 (Exchange)
                $obj3->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined Token rows

                $key4 = TokenPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = TokenPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = TokenPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    TokenPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj4 (Token)
                $obj4->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined Authy rows

                $key5 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = AuthyPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = AuthyPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    AuthyPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj5 (Authy)
                $obj5->addAssetExchangeRelatedByIdCreation($obj1);

            } // if joined row is not null

                // Add objects for joined Authy rows

                $key6 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol6);
                if ($key6 !== null) {
                    $obj6 = AuthyPeer::getInstanceFromPool($key6);
                    if (!$obj6) {

                        $cls = AuthyPeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    AuthyPeer::addInstanceToPool($obj6, $key6);
                } // if $obj6 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj6 (Authy)
                $obj6->addAssetExchangeRelatedByIdModification($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AssetExchange objects pre-filled with all related objects except AuthyRelatedByIdCreation.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AssetExchange objects.
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
            $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);
        }

        AssetExchangePeer::addSelectColumns($criteria);
        $startcol2 = AssetExchangePeer::NUM_HYDRATE_COLUMNS;

        AssetPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AssetPeer::NUM_HYDRATE_COLUMNS;

        ExchangePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + ExchangePeer::NUM_HYDRATE_COLUMNS;

        TokenPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + TokenPeer::NUM_HYDRATE_COLUMNS;

        AuthyGroupPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + AuthyGroupPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AssetExchangePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_TOKEN, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AssetExchangePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AssetExchangePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AssetExchangePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AssetExchangePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Asset rows

                $key2 = AssetPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AssetPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AssetPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AssetPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj2 (Asset)
                $obj2->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined Exchange rows

                $key3 = ExchangePeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = ExchangePeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = ExchangePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    ExchangePeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj3 (Exchange)
                $obj3->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined Token rows

                $key4 = TokenPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = TokenPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = TokenPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    TokenPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj4 (Token)
                $obj4->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined AuthyGroup rows

                $key5 = AuthyGroupPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = AuthyGroupPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = AuthyGroupPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    AuthyGroupPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj5 (AuthyGroup)
                $obj5->addAssetExchange($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AssetExchange objects pre-filled with all related objects except AuthyRelatedByIdModification.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AssetExchange objects.
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
            $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);
        }

        AssetExchangePeer::addSelectColumns($criteria);
        $startcol2 = AssetExchangePeer::NUM_HYDRATE_COLUMNS;

        AssetPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AssetPeer::NUM_HYDRATE_COLUMNS;

        ExchangePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + ExchangePeer::NUM_HYDRATE_COLUMNS;

        TokenPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + TokenPeer::NUM_HYDRATE_COLUMNS;

        AuthyGroupPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + AuthyGroupPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AssetExchangePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_TOKEN, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(AssetExchangePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AssetExchangePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AssetExchangePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AssetExchangePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AssetExchangePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Asset rows

                $key2 = AssetPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AssetPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AssetPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AssetPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj2 (Asset)
                $obj2->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined Exchange rows

                $key3 = ExchangePeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = ExchangePeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = ExchangePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    ExchangePeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj3 (Exchange)
                $obj3->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined Token rows

                $key4 = TokenPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = TokenPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = TokenPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    TokenPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj4 (Token)
                $obj4->addAssetExchange($obj1);

            } // if joined row is not null

                // Add objects for joined AuthyGroup rows

                $key5 = AuthyGroupPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = AuthyGroupPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = AuthyGroupPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    AuthyGroupPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (AssetExchange) to the collection in $obj5 (AuthyGroup)
                $obj5->addAssetExchange($obj1);

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
        return Propel::getDatabaseMap(AssetExchangePeer::DATABASE_NAME)->getTable(AssetExchangePeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseAssetExchangePeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseAssetExchangePeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \App\map\AssetExchangeTableMap());
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
        return AssetExchangePeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a AssetExchange or Criteria object.
     *
     * @param      mixed $values Criteria or AssetExchange object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from AssetExchange object
        }

        if ($criteria->containsKey(AssetExchangePeer::ID_ASSET_EXCHANGE) && $criteria->keyContainsValue(AssetExchangePeer::ID_ASSET_EXCHANGE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AssetExchangePeer::ID_ASSET_EXCHANGE.')');
        }


        // Set the correct dbName
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a AssetExchange or Criteria object.
     *
     * @param      mixed $values Criteria or AssetExchange object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(AssetExchangePeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(AssetExchangePeer::ID_ASSET_EXCHANGE);
            $value = $criteria->remove(AssetExchangePeer::ID_ASSET_EXCHANGE);
            if ($value) {
                $selectCriteria->add(AssetExchangePeer::ID_ASSET_EXCHANGE, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(AssetExchangePeer::TABLE_NAME);
            }

        } else { // $values is AssetExchange object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the asset_exchange table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(AssetExchangePeer::TABLE_NAME, $con, AssetExchangePeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AssetExchangePeer::clearInstancePool();
            AssetExchangePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a AssetExchange or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or AssetExchange object or primary key or array of primary keys
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
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            AssetExchangePeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof AssetExchange) { // it's a model object
            // invalidate the cache for this single object
            AssetExchangePeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AssetExchangePeer::DATABASE_NAME);
            $criteria->add(AssetExchangePeer::ID_ASSET_EXCHANGE, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                AssetExchangePeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(AssetExchangePeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            AssetExchangePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given AssetExchange object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param AssetExchange $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(AssetExchangePeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(AssetExchangePeer::TABLE_NAME);

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

        if ($obj->isNew() || $obj->isColumnModified(AssetExchangePeer::ID_EXCHANGE))
            $columns[AssetExchangePeer::ID_EXCHANGE] = $obj->getIdExchange();

        if ($obj->isNew() || $obj->isColumnModified(AssetExchangePeer::ID_ASSET))
            $columns[AssetExchangePeer::ID_ASSET] = $obj->getIdAsset();

        if ($obj->isNew() || $obj->isColumnModified(AssetExchangePeer::ID_ASSET))
            $columns[AssetExchangePeer::ID_ASSET] = $obj->getIdAsset();

        if ($obj->isNew() || $obj->isColumnModified(AssetExchangePeer::TYPE))
            $columns[AssetExchangePeer::TYPE] = $obj->getType();

        if ($obj->isNew() || $obj->isColumnModified(AssetExchangePeer::TYPE))
            $columns[AssetExchangePeer::TYPE] = $obj->getType();

        if ($obj->isNew() || $obj->isColumnModified(AssetExchangePeer::ID_EXCHANGE))
            $columns[AssetExchangePeer::ID_EXCHANGE] = $obj->getIdExchange();

        if ($obj->isNew() || $obj->isColumnModified(AssetExchangePeer::ID_TOKEN))
            $columns[AssetExchangePeer::ID_TOKEN] = $obj->getIdToken();

        if ($obj->isNew() || $obj->isColumnModified(AssetExchangePeer::ID_TOKEN))
            $columns[AssetExchangePeer::ID_TOKEN] = $obj->getIdToken();

        }

        return BasePeer::doValidate(AssetExchangePeer::DATABASE_NAME, AssetExchangePeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return AssetExchange
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = AssetExchangePeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(AssetExchangePeer::DATABASE_NAME);
        $criteria->add(AssetExchangePeer::ID_ASSET_EXCHANGE, $pk);

        $v = AssetExchangePeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return AssetExchange[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(AssetExchangePeer::DATABASE_NAME);
            $criteria->add(AssetExchangePeer::ID_ASSET_EXCHANGE, $pks, Criteria::IN);
            $objs = AssetExchangePeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseAssetExchangePeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseAssetExchangePeer::buildTableMap();

