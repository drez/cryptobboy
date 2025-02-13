<?php

namespace App\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use App\AssetPeer;
use App\AuthyGroupPeer;
use App\AuthyPeer;
use App\ExchangePeer;
use App\SymbolPeer;
use App\TokenPeer;
use App\Trade;
use App\TradePeer;
use App\map\TradeTableMap;

/**
 * Base static class for performing query and update operations on the 'trade' table.
 *
 * Trade
 *
 * @package propel.generator..om
 */
abstract class BaseTradePeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'cryptobboy';

    /** the table name for this class */
    const TABLE_NAME = 'trade';

    /** the related Propel class for this table */
    const OM_CLASS = 'App\\Trade';

    /** the related TableMap class for this table */
    const TM_CLASS = 'App\\map\\TradeTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 16;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 16;

    /** the column name for the id_trade field */
    const ID_TRADE = 'trade.id_trade';

    /** the column name for the type field */
    const TYPE = 'trade.type';

    /** the column name for the id_exchange field */
    const ID_EXCHANGE = 'trade.id_exchange';

    /** the column name for the id_asset field */
    const ID_ASSET = 'trade.id_asset';

    /** the column name for the qty field */
    const QTY = 'trade.qty';

    /** the column name for the id_symbol field */
    const ID_SYMBOL = 'trade.id_symbol';

    /** the column name for the date field */
    const DATE = 'trade.date';

    /** the column name for the gross_usd field */
    const GROSS_USD = 'trade.gross_usd';

    /** the column name for the commission field */
    const COMMISSION = 'trade.commission';

    /** the column name for the commission_asset field */
    const COMMISSION_ASSET = 'trade.commission_asset';

    /** the column name for the order_id field */
    const ORDER_ID = 'trade.order_id';

    /** the column name for the date_creation field */
    const DATE_CREATION = 'trade.date_creation';

    /** the column name for the date_modification field */
    const DATE_MODIFICATION = 'trade.date_modification';

    /** the column name for the id_group_creation field */
    const ID_GROUP_CREATION = 'trade.id_group_creation';

    /** the column name for the id_creation field */
    const ID_CREATION = 'trade.id_creation';

    /** the column name for the id_modification field */
    const ID_MODIFICATION = 'trade.id_modification';

    /** The enumerated values for the type field */
    const TYPE_BUY = 'Buy';
    const TYPE_SELL = 'Sell';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of Trade objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Trade[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. TradePeer::$fieldNames[TradePeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('IdTrade', 'Type', 'IdExchange', 'IdAsset', 'Qty', 'IdSymbol', 'Date', 'GrossUsd', 'Commission', 'CommissionAsset', 'OrderId', 'DateCreation', 'DateModification', 'IdGroupCreation', 'IdCreation', 'IdModification', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idTrade', 'type', 'idExchange', 'idAsset', 'qty', 'idSymbol', 'date', 'grossUsd', 'commission', 'commissionAsset', 'orderId', 'dateCreation', 'dateModification', 'idGroupCreation', 'idCreation', 'idModification', ),
        BasePeer::TYPE_COLNAME => array (TradePeer::ID_TRADE, TradePeer::TYPE, TradePeer::ID_EXCHANGE, TradePeer::ID_ASSET, TradePeer::QTY, TradePeer::ID_SYMBOL, TradePeer::DATE, TradePeer::GROSS_USD, TradePeer::COMMISSION, TradePeer::COMMISSION_ASSET, TradePeer::ORDER_ID, TradePeer::DATE_CREATION, TradePeer::DATE_MODIFICATION, TradePeer::ID_GROUP_CREATION, TradePeer::ID_CREATION, TradePeer::ID_MODIFICATION, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_TRADE', 'TYPE', 'ID_EXCHANGE', 'ID_ASSET', 'QTY', 'ID_SYMBOL', 'DATE', 'GROSS_USD', 'COMMISSION', 'COMMISSION_ASSET', 'ORDER_ID', 'DATE_CREATION', 'DATE_MODIFICATION', 'ID_GROUP_CREATION', 'ID_CREATION', 'ID_MODIFICATION', ),
        BasePeer::TYPE_FIELDNAME => array ('id_trade', 'type', 'id_exchange', 'id_asset', 'qty', 'id_symbol', 'date', 'gross_usd', 'commission', 'commission_asset', 'order_id', 'date_creation', 'date_modification', 'id_group_creation', 'id_creation', 'id_modification', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. TradePeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('IdTrade' => 0, 'Type' => 1, 'IdExchange' => 2, 'IdAsset' => 3, 'Qty' => 4, 'IdSymbol' => 5, 'Date' => 6, 'GrossUsd' => 7, 'Commission' => 8, 'CommissionAsset' => 9, 'OrderId' => 10, 'DateCreation' => 11, 'DateModification' => 12, 'IdGroupCreation' => 13, 'IdCreation' => 14, 'IdModification' => 15, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idTrade' => 0, 'type' => 1, 'idExchange' => 2, 'idAsset' => 3, 'qty' => 4, 'idSymbol' => 5, 'date' => 6, 'grossUsd' => 7, 'commission' => 8, 'commissionAsset' => 9, 'orderId' => 10, 'dateCreation' => 11, 'dateModification' => 12, 'idGroupCreation' => 13, 'idCreation' => 14, 'idModification' => 15, ),
        BasePeer::TYPE_COLNAME => array (TradePeer::ID_TRADE => 0, TradePeer::TYPE => 1, TradePeer::ID_EXCHANGE => 2, TradePeer::ID_ASSET => 3, TradePeer::QTY => 4, TradePeer::ID_SYMBOL => 5, TradePeer::DATE => 6, TradePeer::GROSS_USD => 7, TradePeer::COMMISSION => 8, TradePeer::COMMISSION_ASSET => 9, TradePeer::ORDER_ID => 10, TradePeer::DATE_CREATION => 11, TradePeer::DATE_MODIFICATION => 12, TradePeer::ID_GROUP_CREATION => 13, TradePeer::ID_CREATION => 14, TradePeer::ID_MODIFICATION => 15, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_TRADE' => 0, 'TYPE' => 1, 'ID_EXCHANGE' => 2, 'ID_ASSET' => 3, 'QTY' => 4, 'ID_SYMBOL' => 5, 'DATE' => 6, 'GROSS_USD' => 7, 'COMMISSION' => 8, 'COMMISSION_ASSET' => 9, 'ORDER_ID' => 10, 'DATE_CREATION' => 11, 'DATE_MODIFICATION' => 12, 'ID_GROUP_CREATION' => 13, 'ID_CREATION' => 14, 'ID_MODIFICATION' => 15, ),
        BasePeer::TYPE_FIELDNAME => array ('id_trade' => 0, 'type' => 1, 'id_exchange' => 2, 'id_asset' => 3, 'qty' => 4, 'id_symbol' => 5, 'date' => 6, 'gross_usd' => 7, 'commission' => 8, 'commission_asset' => 9, 'order_id' => 10, 'date_creation' => 11, 'date_modification' => 12, 'id_group_creation' => 13, 'id_creation' => 14, 'id_modification' => 15, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
        TradePeer::TYPE => array(
            TradePeer::TYPE_BUY,
            TradePeer::TYPE_SELL,
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
        $toNames = TradePeer::getFieldNames($toType);
        $key = isset(TradePeer::$fieldKeys[$fromType][$name]) ? TradePeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(TradePeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, TradePeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return TradePeer::$fieldNames[$type];
    }

    /**
     * Gets the list of values for all ENUM columns
     * @return array
     */
    public static function getValueSets()
    {
      return TradePeer::$enumValueSets;
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
        $valueSets = TradePeer::getValueSets();

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
        $values = TradePeer::getValueSet($colname);
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
     * @param      string $column The column name for current table. (i.e. TradePeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(TradePeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(TradePeer::ID_TRADE);
            $criteria->addSelectColumn(TradePeer::TYPE);
            $criteria->addSelectColumn(TradePeer::ID_EXCHANGE);
            $criteria->addSelectColumn(TradePeer::ID_ASSET);
            $criteria->addSelectColumn(TradePeer::QTY);
            $criteria->addSelectColumn(TradePeer::ID_SYMBOL);
            $criteria->addSelectColumn(TradePeer::DATE);
            $criteria->addSelectColumn(TradePeer::GROSS_USD);
            $criteria->addSelectColumn(TradePeer::COMMISSION);
            $criteria->addSelectColumn(TradePeer::COMMISSION_ASSET);
            $criteria->addSelectColumn(TradePeer::ORDER_ID);
            $criteria->addSelectColumn(TradePeer::DATE_CREATION);
            $criteria->addSelectColumn(TradePeer::DATE_MODIFICATION);
            $criteria->addSelectColumn(TradePeer::ID_GROUP_CREATION);
            $criteria->addSelectColumn(TradePeer::ID_CREATION);
            $criteria->addSelectColumn(TradePeer::ID_MODIFICATION);
        } else {
            $criteria->addSelectColumn($alias . '.id_trade');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.id_exchange');
            $criteria->addSelectColumn($alias . '.id_asset');
            $criteria->addSelectColumn($alias . '.qty');
            $criteria->addSelectColumn($alias . '.id_symbol');
            $criteria->addSelectColumn($alias . '.date');
            $criteria->addSelectColumn($alias . '.gross_usd');
            $criteria->addSelectColumn($alias . '.commission');
            $criteria->addSelectColumn($alias . '.commission_asset');
            $criteria->addSelectColumn($alias . '.order_id');
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
        $criteria->setPrimaryTableName(TradePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TradePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(TradePeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return Trade
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = TradePeer::doSelect($critcopy, $con);
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
        return TradePeer::populateObjects(TradePeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            TradePeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

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
     * @param Trade $obj A Trade object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getIdTrade();
            } // if key === null
            TradePeer::$instances[$key] = $obj;
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
     * @param      mixed $value A Trade object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Trade) {
                $key = (string) $value->getIdTrade();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Trade object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(TradePeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return Trade Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(TradePeer::$instances[$key])) {
                return TradePeer::$instances[$key];
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
        foreach (TradePeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        TradePeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to trade
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
        $cls = TradePeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = TradePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = TradePeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TradePeer::addInstanceToPool($obj, $key);
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
     * @return array (Trade object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = TradePeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = TradePeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + TradePeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TradePeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            TradePeer::addInstanceToPool($obj, $key);
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
        return TradePeer::getSqlValueForEnum(TradePeer::TYPE, $enumVal);
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
        $criteria->setPrimaryTableName(TradePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TradePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TradePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

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
        $criteria->setPrimaryTableName(TradePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TradePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TradePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Symbol table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinSymbol(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(TradePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TradePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TradePeer::ID_SYMBOL, SymbolPeer::ID_SYMBOL, $join_behavior);

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
        $criteria->setPrimaryTableName(TradePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TradePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TradePeer::COMMISSION_ASSET, TokenPeer::ID_TOKEN, $join_behavior);

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
        $criteria->setPrimaryTableName(TradePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TradePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TradePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

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
        $criteria->setPrimaryTableName(TradePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TradePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TradePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

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
        $criteria->setPrimaryTableName(TradePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TradePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TradePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

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
     * Selects a collection of Trade objects pre-filled with their Exchange objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Trade objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinExchange(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(TradePeer::DATABASE_NAME);
        }

        TradePeer::addSelectColumns($criteria);
        $startcol = TradePeer::NUM_HYDRATE_COLUMNS;
        ExchangePeer::addSelectColumns($criteria);

        $criteria->addJoin(TradePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TradePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TradePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = TradePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TradePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Trade) to $obj2 (Exchange)
                $obj2->addTrade($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Trade objects pre-filled with their Asset objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Trade objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAsset(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(TradePeer::DATABASE_NAME);
        }

        TradePeer::addSelectColumns($criteria);
        $startcol = TradePeer::NUM_HYDRATE_COLUMNS;
        AssetPeer::addSelectColumns($criteria);

        $criteria->addJoin(TradePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TradePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TradePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = TradePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TradePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Trade) to $obj2 (Asset)
                $obj2->addTrade($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Trade objects pre-filled with their Symbol objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Trade objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinSymbol(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(TradePeer::DATABASE_NAME);
        }

        TradePeer::addSelectColumns($criteria);
        $startcol = TradePeer::NUM_HYDRATE_COLUMNS;
        SymbolPeer::addSelectColumns($criteria);

        $criteria->addJoin(TradePeer::ID_SYMBOL, SymbolPeer::ID_SYMBOL, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TradePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TradePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = TradePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TradePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = SymbolPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = SymbolPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = SymbolPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    SymbolPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Trade) to $obj2 (Symbol)
                $obj2->addTrade($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Trade objects pre-filled with their Token objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Trade objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinToken(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(TradePeer::DATABASE_NAME);
        }

        TradePeer::addSelectColumns($criteria);
        $startcol = TradePeer::NUM_HYDRATE_COLUMNS;
        TokenPeer::addSelectColumns($criteria);

        $criteria->addJoin(TradePeer::COMMISSION_ASSET, TokenPeer::ID_TOKEN, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TradePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TradePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = TradePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TradePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Trade) to $obj2 (Token)
                $obj2->addTrade($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Trade objects pre-filled with their AuthyGroup objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Trade objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAuthyGroup(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(TradePeer::DATABASE_NAME);
        }

        TradePeer::addSelectColumns($criteria);
        $startcol = TradePeer::NUM_HYDRATE_COLUMNS;
        AuthyGroupPeer::addSelectColumns($criteria);

        $criteria->addJoin(TradePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TradePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TradePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = TradePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TradePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Trade) to $obj2 (AuthyGroup)
                $obj2->addTrade($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Trade objects pre-filled with their Authy objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Trade objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAuthyRelatedByIdCreation(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(TradePeer::DATABASE_NAME);
        }

        TradePeer::addSelectColumns($criteria);
        $startcol = TradePeer::NUM_HYDRATE_COLUMNS;
        AuthyPeer::addSelectColumns($criteria);

        $criteria->addJoin(TradePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TradePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TradePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = TradePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TradePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Trade) to $obj2 (Authy)
                $obj2->addTradeRelatedByIdCreation($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Trade objects pre-filled with their Authy objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Trade objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAuthyRelatedByIdModification(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(TradePeer::DATABASE_NAME);
        }

        TradePeer::addSelectColumns($criteria);
        $startcol = TradePeer::NUM_HYDRATE_COLUMNS;
        AuthyPeer::addSelectColumns($criteria);

        $criteria->addJoin(TradePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TradePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TradePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = TradePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TradePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Trade) to $obj2 (Authy)
                $obj2->addTradeRelatedByIdModification($obj1);

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
        $criteria->setPrimaryTableName(TradePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TradePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TradePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(TradePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(TradePeer::ID_SYMBOL, SymbolPeer::ID_SYMBOL, $join_behavior);

        $criteria->addJoin(TradePeer::COMMISSION_ASSET, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(TradePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(TradePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(TradePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

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
     * Selects a collection of Trade objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Trade objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(TradePeer::DATABASE_NAME);
        }

        TradePeer::addSelectColumns($criteria);
        $startcol2 = TradePeer::NUM_HYDRATE_COLUMNS;

        ExchangePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ExchangePeer::NUM_HYDRATE_COLUMNS;

        AssetPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AssetPeer::NUM_HYDRATE_COLUMNS;

        SymbolPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + SymbolPeer::NUM_HYDRATE_COLUMNS;

        TokenPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + TokenPeer::NUM_HYDRATE_COLUMNS;

        AuthyGroupPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + AuthyGroupPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol8 = $startcol7 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol9 = $startcol8 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(TradePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(TradePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(TradePeer::ID_SYMBOL, SymbolPeer::ID_SYMBOL, $join_behavior);

        $criteria->addJoin(TradePeer::COMMISSION_ASSET, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(TradePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(TradePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(TradePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TradePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TradePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = TradePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TradePeer::addInstanceToPool($obj1, $key1);
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
                } // if obj2 loaded

                // Add the $obj1 (Trade) to the collection in $obj2 (Exchange)
                $obj2->addTrade($obj1);
            } // if joined row not null

            // Add objects for joined Asset rows

            $key3 = AssetPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = AssetPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = AssetPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AssetPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (Trade) to the collection in $obj3 (Asset)
                $obj3->addTrade($obj1);
            } // if joined row not null

            // Add objects for joined Symbol rows

            $key4 = SymbolPeer::getPrimaryKeyHashFromRow($row, $startcol4);
            if ($key4 !== null) {
                $obj4 = SymbolPeer::getInstanceFromPool($key4);
                if (!$obj4) {

                    $cls = SymbolPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    SymbolPeer::addInstanceToPool($obj4, $key4);
                } // if obj4 loaded

                // Add the $obj1 (Trade) to the collection in $obj4 (Symbol)
                $obj4->addTrade($obj1);
            } // if joined row not null

            // Add objects for joined Token rows

            $key5 = TokenPeer::getPrimaryKeyHashFromRow($row, $startcol5);
            if ($key5 !== null) {
                $obj5 = TokenPeer::getInstanceFromPool($key5);
                if (!$obj5) {

                    $cls = TokenPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    TokenPeer::addInstanceToPool($obj5, $key5);
                } // if obj5 loaded

                // Add the $obj1 (Trade) to the collection in $obj5 (Token)
                $obj5->addTrade($obj1);
            } // if joined row not null

            // Add objects for joined AuthyGroup rows

            $key6 = AuthyGroupPeer::getPrimaryKeyHashFromRow($row, $startcol6);
            if ($key6 !== null) {
                $obj6 = AuthyGroupPeer::getInstanceFromPool($key6);
                if (!$obj6) {

                    $cls = AuthyGroupPeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    AuthyGroupPeer::addInstanceToPool($obj6, $key6);
                } // if obj6 loaded

                // Add the $obj1 (Trade) to the collection in $obj6 (AuthyGroup)
                $obj6->addTrade($obj1);
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

                // Add the $obj1 (Trade) to the collection in $obj7 (Authy)
                $obj7->addTradeRelatedByIdCreation($obj1);
            } // if joined row not null

            // Add objects for joined Authy rows

            $key8 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol8);
            if ($key8 !== null) {
                $obj8 = AuthyPeer::getInstanceFromPool($key8);
                if (!$obj8) {

                    $cls = AuthyPeer::getOMClass();

                    $obj8 = new $cls();
                    $obj8->hydrate($row, $startcol8);
                    AuthyPeer::addInstanceToPool($obj8, $key8);
                } // if obj8 loaded

                // Add the $obj1 (Trade) to the collection in $obj8 (Authy)
                $obj8->addTradeRelatedByIdModification($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
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
        $criteria->setPrimaryTableName(TradePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TradePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TradePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(TradePeer::ID_SYMBOL, SymbolPeer::ID_SYMBOL, $join_behavior);

        $criteria->addJoin(TradePeer::COMMISSION_ASSET, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(TradePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(TradePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(TradePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

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
        $criteria->setPrimaryTableName(TradePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TradePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TradePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(TradePeer::ID_SYMBOL, SymbolPeer::ID_SYMBOL, $join_behavior);

        $criteria->addJoin(TradePeer::COMMISSION_ASSET, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(TradePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(TradePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(TradePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Symbol table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptSymbol(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(TradePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TradePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TradePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(TradePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(TradePeer::COMMISSION_ASSET, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(TradePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(TradePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(TradePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

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
        $criteria->setPrimaryTableName(TradePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TradePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TradePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(TradePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(TradePeer::ID_SYMBOL, SymbolPeer::ID_SYMBOL, $join_behavior);

        $criteria->addJoin(TradePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(TradePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(TradePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

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
        $criteria->setPrimaryTableName(TradePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TradePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TradePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(TradePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(TradePeer::ID_SYMBOL, SymbolPeer::ID_SYMBOL, $join_behavior);

        $criteria->addJoin(TradePeer::COMMISSION_ASSET, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(TradePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(TradePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);

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
        $criteria->setPrimaryTableName(TradePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TradePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TradePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(TradePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(TradePeer::ID_SYMBOL, SymbolPeer::ID_SYMBOL, $join_behavior);

        $criteria->addJoin(TradePeer::COMMISSION_ASSET, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(TradePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

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
        $criteria->setPrimaryTableName(TradePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            TradePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(TradePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(TradePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(TradePeer::ID_SYMBOL, SymbolPeer::ID_SYMBOL, $join_behavior);

        $criteria->addJoin(TradePeer::COMMISSION_ASSET, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(TradePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

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
     * Selects a collection of Trade objects pre-filled with all related objects except Exchange.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Trade objects.
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
            $criteria->setDbName(TradePeer::DATABASE_NAME);
        }

        TradePeer::addSelectColumns($criteria);
        $startcol2 = TradePeer::NUM_HYDRATE_COLUMNS;

        AssetPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AssetPeer::NUM_HYDRATE_COLUMNS;

        SymbolPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + SymbolPeer::NUM_HYDRATE_COLUMNS;

        TokenPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + TokenPeer::NUM_HYDRATE_COLUMNS;

        AuthyGroupPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + AuthyGroupPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol8 = $startcol7 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(TradePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(TradePeer::ID_SYMBOL, SymbolPeer::ID_SYMBOL, $join_behavior);

        $criteria->addJoin(TradePeer::COMMISSION_ASSET, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(TradePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(TradePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(TradePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TradePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TradePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = TradePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TradePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Trade) to the collection in $obj2 (Asset)
                $obj2->addTrade($obj1);

            } // if joined row is not null

                // Add objects for joined Symbol rows

                $key3 = SymbolPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = SymbolPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = SymbolPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    SymbolPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Trade) to the collection in $obj3 (Symbol)
                $obj3->addTrade($obj1);

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

                // Add the $obj1 (Trade) to the collection in $obj4 (Token)
                $obj4->addTrade($obj1);

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

                // Add the $obj1 (Trade) to the collection in $obj5 (AuthyGroup)
                $obj5->addTrade($obj1);

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

                // Add the $obj1 (Trade) to the collection in $obj6 (Authy)
                $obj6->addTradeRelatedByIdCreation($obj1);

            } // if joined row is not null

                // Add objects for joined Authy rows

                $key7 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol7);
                if ($key7 !== null) {
                    $obj7 = AuthyPeer::getInstanceFromPool($key7);
                    if (!$obj7) {

                        $cls = AuthyPeer::getOMClass();

                    $obj7 = new $cls();
                    $obj7->hydrate($row, $startcol7);
                    AuthyPeer::addInstanceToPool($obj7, $key7);
                } // if $obj7 already loaded

                // Add the $obj1 (Trade) to the collection in $obj7 (Authy)
                $obj7->addTradeRelatedByIdModification($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Trade objects pre-filled with all related objects except Asset.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Trade objects.
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
            $criteria->setDbName(TradePeer::DATABASE_NAME);
        }

        TradePeer::addSelectColumns($criteria);
        $startcol2 = TradePeer::NUM_HYDRATE_COLUMNS;

        ExchangePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ExchangePeer::NUM_HYDRATE_COLUMNS;

        SymbolPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + SymbolPeer::NUM_HYDRATE_COLUMNS;

        TokenPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + TokenPeer::NUM_HYDRATE_COLUMNS;

        AuthyGroupPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + AuthyGroupPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol8 = $startcol7 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(TradePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(TradePeer::ID_SYMBOL, SymbolPeer::ID_SYMBOL, $join_behavior);

        $criteria->addJoin(TradePeer::COMMISSION_ASSET, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(TradePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(TradePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(TradePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TradePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TradePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = TradePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TradePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Trade) to the collection in $obj2 (Exchange)
                $obj2->addTrade($obj1);

            } // if joined row is not null

                // Add objects for joined Symbol rows

                $key3 = SymbolPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = SymbolPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = SymbolPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    SymbolPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Trade) to the collection in $obj3 (Symbol)
                $obj3->addTrade($obj1);

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

                // Add the $obj1 (Trade) to the collection in $obj4 (Token)
                $obj4->addTrade($obj1);

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

                // Add the $obj1 (Trade) to the collection in $obj5 (AuthyGroup)
                $obj5->addTrade($obj1);

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

                // Add the $obj1 (Trade) to the collection in $obj6 (Authy)
                $obj6->addTradeRelatedByIdCreation($obj1);

            } // if joined row is not null

                // Add objects for joined Authy rows

                $key7 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol7);
                if ($key7 !== null) {
                    $obj7 = AuthyPeer::getInstanceFromPool($key7);
                    if (!$obj7) {

                        $cls = AuthyPeer::getOMClass();

                    $obj7 = new $cls();
                    $obj7->hydrate($row, $startcol7);
                    AuthyPeer::addInstanceToPool($obj7, $key7);
                } // if $obj7 already loaded

                // Add the $obj1 (Trade) to the collection in $obj7 (Authy)
                $obj7->addTradeRelatedByIdModification($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Trade objects pre-filled with all related objects except Symbol.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Trade objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptSymbol(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(TradePeer::DATABASE_NAME);
        }

        TradePeer::addSelectColumns($criteria);
        $startcol2 = TradePeer::NUM_HYDRATE_COLUMNS;

        ExchangePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ExchangePeer::NUM_HYDRATE_COLUMNS;

        AssetPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AssetPeer::NUM_HYDRATE_COLUMNS;

        TokenPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + TokenPeer::NUM_HYDRATE_COLUMNS;

        AuthyGroupPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + AuthyGroupPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol8 = $startcol7 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(TradePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(TradePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(TradePeer::COMMISSION_ASSET, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(TradePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(TradePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(TradePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TradePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TradePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = TradePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TradePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Trade) to the collection in $obj2 (Exchange)
                $obj2->addTrade($obj1);

            } // if joined row is not null

                // Add objects for joined Asset rows

                $key3 = AssetPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = AssetPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = AssetPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AssetPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Trade) to the collection in $obj3 (Asset)
                $obj3->addTrade($obj1);

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

                // Add the $obj1 (Trade) to the collection in $obj4 (Token)
                $obj4->addTrade($obj1);

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

                // Add the $obj1 (Trade) to the collection in $obj5 (AuthyGroup)
                $obj5->addTrade($obj1);

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

                // Add the $obj1 (Trade) to the collection in $obj6 (Authy)
                $obj6->addTradeRelatedByIdCreation($obj1);

            } // if joined row is not null

                // Add objects for joined Authy rows

                $key7 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol7);
                if ($key7 !== null) {
                    $obj7 = AuthyPeer::getInstanceFromPool($key7);
                    if (!$obj7) {

                        $cls = AuthyPeer::getOMClass();

                    $obj7 = new $cls();
                    $obj7->hydrate($row, $startcol7);
                    AuthyPeer::addInstanceToPool($obj7, $key7);
                } // if $obj7 already loaded

                // Add the $obj1 (Trade) to the collection in $obj7 (Authy)
                $obj7->addTradeRelatedByIdModification($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Trade objects pre-filled with all related objects except Token.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Trade objects.
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
            $criteria->setDbName(TradePeer::DATABASE_NAME);
        }

        TradePeer::addSelectColumns($criteria);
        $startcol2 = TradePeer::NUM_HYDRATE_COLUMNS;

        ExchangePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ExchangePeer::NUM_HYDRATE_COLUMNS;

        AssetPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AssetPeer::NUM_HYDRATE_COLUMNS;

        SymbolPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + SymbolPeer::NUM_HYDRATE_COLUMNS;

        AuthyGroupPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + AuthyGroupPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol8 = $startcol7 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(TradePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(TradePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(TradePeer::ID_SYMBOL, SymbolPeer::ID_SYMBOL, $join_behavior);

        $criteria->addJoin(TradePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);

        $criteria->addJoin(TradePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(TradePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TradePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TradePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = TradePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TradePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Trade) to the collection in $obj2 (Exchange)
                $obj2->addTrade($obj1);

            } // if joined row is not null

                // Add objects for joined Asset rows

                $key3 = AssetPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = AssetPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = AssetPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AssetPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Trade) to the collection in $obj3 (Asset)
                $obj3->addTrade($obj1);

            } // if joined row is not null

                // Add objects for joined Symbol rows

                $key4 = SymbolPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = SymbolPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = SymbolPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    SymbolPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Trade) to the collection in $obj4 (Symbol)
                $obj4->addTrade($obj1);

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

                // Add the $obj1 (Trade) to the collection in $obj5 (AuthyGroup)
                $obj5->addTrade($obj1);

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

                // Add the $obj1 (Trade) to the collection in $obj6 (Authy)
                $obj6->addTradeRelatedByIdCreation($obj1);

            } // if joined row is not null

                // Add objects for joined Authy rows

                $key7 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol7);
                if ($key7 !== null) {
                    $obj7 = AuthyPeer::getInstanceFromPool($key7);
                    if (!$obj7) {

                        $cls = AuthyPeer::getOMClass();

                    $obj7 = new $cls();
                    $obj7->hydrate($row, $startcol7);
                    AuthyPeer::addInstanceToPool($obj7, $key7);
                } // if $obj7 already loaded

                // Add the $obj1 (Trade) to the collection in $obj7 (Authy)
                $obj7->addTradeRelatedByIdModification($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Trade objects pre-filled with all related objects except AuthyGroup.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Trade objects.
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
            $criteria->setDbName(TradePeer::DATABASE_NAME);
        }

        TradePeer::addSelectColumns($criteria);
        $startcol2 = TradePeer::NUM_HYDRATE_COLUMNS;

        ExchangePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ExchangePeer::NUM_HYDRATE_COLUMNS;

        AssetPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AssetPeer::NUM_HYDRATE_COLUMNS;

        SymbolPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + SymbolPeer::NUM_HYDRATE_COLUMNS;

        TokenPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + TokenPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol8 = $startcol7 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(TradePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(TradePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(TradePeer::ID_SYMBOL, SymbolPeer::ID_SYMBOL, $join_behavior);

        $criteria->addJoin(TradePeer::COMMISSION_ASSET, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(TradePeer::ID_CREATION, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(TradePeer::ID_MODIFICATION, AuthyPeer::ID_AUTHY, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TradePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TradePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = TradePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TradePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Trade) to the collection in $obj2 (Exchange)
                $obj2->addTrade($obj1);

            } // if joined row is not null

                // Add objects for joined Asset rows

                $key3 = AssetPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = AssetPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = AssetPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AssetPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Trade) to the collection in $obj3 (Asset)
                $obj3->addTrade($obj1);

            } // if joined row is not null

                // Add objects for joined Symbol rows

                $key4 = SymbolPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = SymbolPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = SymbolPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    SymbolPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Trade) to the collection in $obj4 (Symbol)
                $obj4->addTrade($obj1);

            } // if joined row is not null

                // Add objects for joined Token rows

                $key5 = TokenPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = TokenPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = TokenPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    TokenPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Trade) to the collection in $obj5 (Token)
                $obj5->addTrade($obj1);

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

                // Add the $obj1 (Trade) to the collection in $obj6 (Authy)
                $obj6->addTradeRelatedByIdCreation($obj1);

            } // if joined row is not null

                // Add objects for joined Authy rows

                $key7 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol7);
                if ($key7 !== null) {
                    $obj7 = AuthyPeer::getInstanceFromPool($key7);
                    if (!$obj7) {

                        $cls = AuthyPeer::getOMClass();

                    $obj7 = new $cls();
                    $obj7->hydrate($row, $startcol7);
                    AuthyPeer::addInstanceToPool($obj7, $key7);
                } // if $obj7 already loaded

                // Add the $obj1 (Trade) to the collection in $obj7 (Authy)
                $obj7->addTradeRelatedByIdModification($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Trade objects pre-filled with all related objects except AuthyRelatedByIdCreation.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Trade objects.
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
            $criteria->setDbName(TradePeer::DATABASE_NAME);
        }

        TradePeer::addSelectColumns($criteria);
        $startcol2 = TradePeer::NUM_HYDRATE_COLUMNS;

        ExchangePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ExchangePeer::NUM_HYDRATE_COLUMNS;

        AssetPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AssetPeer::NUM_HYDRATE_COLUMNS;

        SymbolPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + SymbolPeer::NUM_HYDRATE_COLUMNS;

        TokenPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + TokenPeer::NUM_HYDRATE_COLUMNS;

        AuthyGroupPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + AuthyGroupPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(TradePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(TradePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(TradePeer::ID_SYMBOL, SymbolPeer::ID_SYMBOL, $join_behavior);

        $criteria->addJoin(TradePeer::COMMISSION_ASSET, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(TradePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TradePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TradePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = TradePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TradePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Trade) to the collection in $obj2 (Exchange)
                $obj2->addTrade($obj1);

            } // if joined row is not null

                // Add objects for joined Asset rows

                $key3 = AssetPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = AssetPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = AssetPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AssetPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Trade) to the collection in $obj3 (Asset)
                $obj3->addTrade($obj1);

            } // if joined row is not null

                // Add objects for joined Symbol rows

                $key4 = SymbolPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = SymbolPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = SymbolPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    SymbolPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Trade) to the collection in $obj4 (Symbol)
                $obj4->addTrade($obj1);

            } // if joined row is not null

                // Add objects for joined Token rows

                $key5 = TokenPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = TokenPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = TokenPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    TokenPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Trade) to the collection in $obj5 (Token)
                $obj5->addTrade($obj1);

            } // if joined row is not null

                // Add objects for joined AuthyGroup rows

                $key6 = AuthyGroupPeer::getPrimaryKeyHashFromRow($row, $startcol6);
                if ($key6 !== null) {
                    $obj6 = AuthyGroupPeer::getInstanceFromPool($key6);
                    if (!$obj6) {

                        $cls = AuthyGroupPeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    AuthyGroupPeer::addInstanceToPool($obj6, $key6);
                } // if $obj6 already loaded

                // Add the $obj1 (Trade) to the collection in $obj6 (AuthyGroup)
                $obj6->addTrade($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Trade objects pre-filled with all related objects except AuthyRelatedByIdModification.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Trade objects.
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
            $criteria->setDbName(TradePeer::DATABASE_NAME);
        }

        TradePeer::addSelectColumns($criteria);
        $startcol2 = TradePeer::NUM_HYDRATE_COLUMNS;

        ExchangePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ExchangePeer::NUM_HYDRATE_COLUMNS;

        AssetPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AssetPeer::NUM_HYDRATE_COLUMNS;

        SymbolPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + SymbolPeer::NUM_HYDRATE_COLUMNS;

        TokenPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + TokenPeer::NUM_HYDRATE_COLUMNS;

        AuthyGroupPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + AuthyGroupPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(TradePeer::ID_EXCHANGE, ExchangePeer::ID_EXCHANGE, $join_behavior);

        $criteria->addJoin(TradePeer::ID_ASSET, AssetPeer::ID_ASSET, $join_behavior);

        $criteria->addJoin(TradePeer::ID_SYMBOL, SymbolPeer::ID_SYMBOL, $join_behavior);

        $criteria->addJoin(TradePeer::COMMISSION_ASSET, TokenPeer::ID_TOKEN, $join_behavior);

        $criteria->addJoin(TradePeer::ID_GROUP_CREATION, AuthyGroupPeer::ID_AUTHY_GROUP, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = TradePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = TradePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = TradePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                TradePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Trade) to the collection in $obj2 (Exchange)
                $obj2->addTrade($obj1);

            } // if joined row is not null

                // Add objects for joined Asset rows

                $key3 = AssetPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = AssetPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = AssetPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AssetPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Trade) to the collection in $obj3 (Asset)
                $obj3->addTrade($obj1);

            } // if joined row is not null

                // Add objects for joined Symbol rows

                $key4 = SymbolPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = SymbolPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = SymbolPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    SymbolPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Trade) to the collection in $obj4 (Symbol)
                $obj4->addTrade($obj1);

            } // if joined row is not null

                // Add objects for joined Token rows

                $key5 = TokenPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = TokenPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = TokenPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    TokenPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Trade) to the collection in $obj5 (Token)
                $obj5->addTrade($obj1);

            } // if joined row is not null

                // Add objects for joined AuthyGroup rows

                $key6 = AuthyGroupPeer::getPrimaryKeyHashFromRow($row, $startcol6);
                if ($key6 !== null) {
                    $obj6 = AuthyGroupPeer::getInstanceFromPool($key6);
                    if (!$obj6) {

                        $cls = AuthyGroupPeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    AuthyGroupPeer::addInstanceToPool($obj6, $key6);
                } // if $obj6 already loaded

                // Add the $obj1 (Trade) to the collection in $obj6 (AuthyGroup)
                $obj6->addTrade($obj1);

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
        return Propel::getDatabaseMap(TradePeer::DATABASE_NAME)->getTable(TradePeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseTradePeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseTradePeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \App\map\TradeTableMap());
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
        return TradePeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Trade or Criteria object.
     *
     * @param      mixed $values Criteria or Trade object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Trade object
        }

        if ($criteria->containsKey(TradePeer::ID_TRADE) && $criteria->keyContainsValue(TradePeer::ID_TRADE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TradePeer::ID_TRADE.')');
        }


        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a Trade or Criteria object.
     *
     * @param      mixed $values Criteria or Trade object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(TradePeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(TradePeer::ID_TRADE);
            $value = $criteria->remove(TradePeer::ID_TRADE);
            if ($value) {
                $selectCriteria->add(TradePeer::ID_TRADE, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(TradePeer::TABLE_NAME);
            }

        } else { // $values is Trade object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the trade table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(TradePeer::TABLE_NAME, $con, TradePeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TradePeer::clearInstancePool();
            TradePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Trade or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Trade object or primary key or array of primary keys
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
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            TradePeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Trade) { // it's a model object
            // invalidate the cache for this single object
            TradePeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TradePeer::DATABASE_NAME);
            $criteria->add(TradePeer::ID_TRADE, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                TradePeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(TradePeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            TradePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Trade object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param Trade $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(TradePeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(TradePeer::TABLE_NAME);

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

        if ($obj->isNew() || $obj->isColumnModified(TradePeer::QTY))
            $columns[TradePeer::QTY] = $obj->getQty();

        if ($obj->isNew() || $obj->isColumnModified(TradePeer::TYPE))
            $columns[TradePeer::TYPE] = $obj->getType();

        if ($obj->isNew() || $obj->isColumnModified(TradePeer::TYPE))
            $columns[TradePeer::TYPE] = $obj->getType();

        if ($obj->isNew() || $obj->isColumnModified(TradePeer::ID_EXCHANGE))
            $columns[TradePeer::ID_EXCHANGE] = $obj->getIdExchange();

        if ($obj->isNew() || $obj->isColumnModified(TradePeer::ID_EXCHANGE))
            $columns[TradePeer::ID_EXCHANGE] = $obj->getIdExchange();

        if ($obj->isNew() || $obj->isColumnModified(TradePeer::ID_ASSET))
            $columns[TradePeer::ID_ASSET] = $obj->getIdAsset();

        if ($obj->isNew() || $obj->isColumnModified(TradePeer::ID_ASSET))
            $columns[TradePeer::ID_ASSET] = $obj->getIdAsset();

        if ($obj->isNew() || $obj->isColumnModified(TradePeer::ID_SYMBOL))
            $columns[TradePeer::ID_SYMBOL] = $obj->getIdSymbol();

        if ($obj->isNew() || $obj->isColumnModified(TradePeer::ID_SYMBOL))
            $columns[TradePeer::ID_SYMBOL] = $obj->getIdSymbol();

        if ($obj->isNew() || $obj->isColumnModified(TradePeer::DATE))
            $columns[TradePeer::DATE] = $obj->getDate();

        if ($obj->isNew() || $obj->isColumnModified(TradePeer::COMMISSION_ASSET))
            $columns[TradePeer::COMMISSION_ASSET] = $obj->getCommissionAsset();

        if ($obj->isNew() || $obj->isColumnModified(TradePeer::COMMISSION_ASSET))
            $columns[TradePeer::COMMISSION_ASSET] = $obj->getCommissionAsset();

        if ($obj->isNew() || $obj->isColumnModified(TradePeer::ORDER_ID))
            $columns[TradePeer::ORDER_ID] = $obj->getOrderId();

        }

        return BasePeer::doValidate(TradePeer::DATABASE_NAME, TradePeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Trade
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = TradePeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(TradePeer::DATABASE_NAME);
        $criteria->add(TradePeer::ID_TRADE, $pk);

        $v = TradePeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Trade[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(TradePeer::DATABASE_NAME);
            $criteria->add(TradePeer::ID_TRADE, $pks, Criteria::IN);
            $objs = TradePeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseTradePeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseTradePeer::buildTableMap();

