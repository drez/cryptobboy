<?php

namespace App\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use App\Asset;
use App\Authy;
use App\AuthyGroup;
use App\Exchange;
use App\Symbol;
use App\Token;
use App\Trade;
use App\TradePeer;
use App\TradeQuery;

/**
 * Base class that represents a query for the 'trade' table.
 *
 * Trade
 *
 * @method TradeQuery orderByIdTrade($order = Criteria::ASC) Order by the id_trade column
 * @method TradeQuery orderByStartAvg($order = Criteria::ASC) Order by the start_avg column
 * @method TradeQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method TradeQuery orderByIdExchange($order = Criteria::ASC) Order by the id_exchange column
 * @method TradeQuery orderByIdAsset($order = Criteria::ASC) Order by the id_asset column
 * @method TradeQuery orderByIdSymbol($order = Criteria::ASC) Order by the id_symbol column
 * @method TradeQuery orderByDate($order = Criteria::ASC) Order by the date column
 * @method TradeQuery orderByQty($order = Criteria::ASC) Order by the qty column
 * @method TradeQuery orderByGrossUsd($order = Criteria::ASC) Order by the gross_usd column
 * @method TradeQuery orderByCommission($order = Criteria::ASC) Order by the commission column
 * @method TradeQuery orderByCommissionAsset($order = Criteria::ASC) Order by the commission_asset column
 * @method TradeQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method TradeQuery orderByDateCreation($order = Criteria::ASC) Order by the date_creation column
 * @method TradeQuery orderByDateModification($order = Criteria::ASC) Order by the date_modification column
 * @method TradeQuery orderByIdGroupCreation($order = Criteria::ASC) Order by the id_group_creation column
 * @method TradeQuery orderByIdCreation($order = Criteria::ASC) Order by the id_creation column
 * @method TradeQuery orderByIdModification($order = Criteria::ASC) Order by the id_modification column
 *
 * @method TradeQuery groupByIdTrade() Group by the id_trade column
 * @method TradeQuery groupByStartAvg() Group by the start_avg column
 * @method TradeQuery groupByType() Group by the type column
 * @method TradeQuery groupByIdExchange() Group by the id_exchange column
 * @method TradeQuery groupByIdAsset() Group by the id_asset column
 * @method TradeQuery groupByIdSymbol() Group by the id_symbol column
 * @method TradeQuery groupByDate() Group by the date column
 * @method TradeQuery groupByQty() Group by the qty column
 * @method TradeQuery groupByGrossUsd() Group by the gross_usd column
 * @method TradeQuery groupByCommission() Group by the commission column
 * @method TradeQuery groupByCommissionAsset() Group by the commission_asset column
 * @method TradeQuery groupByOrderId() Group by the order_id column
 * @method TradeQuery groupByDateCreation() Group by the date_creation column
 * @method TradeQuery groupByDateModification() Group by the date_modification column
 * @method TradeQuery groupByIdGroupCreation() Group by the id_group_creation column
 * @method TradeQuery groupByIdCreation() Group by the id_creation column
 * @method TradeQuery groupByIdModification() Group by the id_modification column
 *
 * @method TradeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method TradeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method TradeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method TradeQuery leftJoinExchange($relationAlias = null) Adds a LEFT JOIN clause to the query using the Exchange relation
 * @method TradeQuery rightJoinExchange($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Exchange relation
 * @method TradeQuery innerJoinExchange($relationAlias = null) Adds a INNER JOIN clause to the query using the Exchange relation
 *
 * @method TradeQuery leftJoinAsset($relationAlias = null) Adds a LEFT JOIN clause to the query using the Asset relation
 * @method TradeQuery rightJoinAsset($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Asset relation
 * @method TradeQuery innerJoinAsset($relationAlias = null) Adds a INNER JOIN clause to the query using the Asset relation
 *
 * @method TradeQuery leftJoinSymbol($relationAlias = null) Adds a LEFT JOIN clause to the query using the Symbol relation
 * @method TradeQuery rightJoinSymbol($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Symbol relation
 * @method TradeQuery innerJoinSymbol($relationAlias = null) Adds a INNER JOIN clause to the query using the Symbol relation
 *
 * @method TradeQuery leftJoinToken($relationAlias = null) Adds a LEFT JOIN clause to the query using the Token relation
 * @method TradeQuery rightJoinToken($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Token relation
 * @method TradeQuery innerJoinToken($relationAlias = null) Adds a INNER JOIN clause to the query using the Token relation
 *
 * @method TradeQuery leftJoinAuthyGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyGroup relation
 * @method TradeQuery rightJoinAuthyGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyGroup relation
 * @method TradeQuery innerJoinAuthyGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyGroup relation
 *
 * @method TradeQuery leftJoinAuthyRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyRelatedByIdCreation relation
 * @method TradeQuery rightJoinAuthyRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyRelatedByIdCreation relation
 * @method TradeQuery innerJoinAuthyRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyRelatedByIdCreation relation
 *
 * @method TradeQuery leftJoinAuthyRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyRelatedByIdModification relation
 * @method TradeQuery rightJoinAuthyRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyRelatedByIdModification relation
 * @method TradeQuery innerJoinAuthyRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyRelatedByIdModification relation
 *
 * @method Trade findOne(PropelPDO $con = null) Return the first Trade matching the query
 * @method Trade findOneOrCreate(PropelPDO $con = null) Return the first Trade matching the query, or a new Trade object populated from the query conditions when no match is found
 *
 * @method Trade findOneByStartAvg(int $start_avg) Return the first Trade filtered by the start_avg column
 * @method Trade findOneByType(int $type) Return the first Trade filtered by the type column
 * @method Trade findOneByIdExchange(int $id_exchange) Return the first Trade filtered by the id_exchange column
 * @method Trade findOneByIdAsset(int $id_asset) Return the first Trade filtered by the id_asset column
 * @method Trade findOneByIdSymbol(int $id_symbol) Return the first Trade filtered by the id_symbol column
 * @method Trade findOneByDate(string $date) Return the first Trade filtered by the date column
 * @method Trade findOneByQty(string $qty) Return the first Trade filtered by the qty column
 * @method Trade findOneByGrossUsd(string $gross_usd) Return the first Trade filtered by the gross_usd column
 * @method Trade findOneByCommission(string $commission) Return the first Trade filtered by the commission column
 * @method Trade findOneByCommissionAsset(int $commission_asset) Return the first Trade filtered by the commission_asset column
 * @method Trade findOneByOrderId(string $order_id) Return the first Trade filtered by the order_id column
 * @method Trade findOneByDateCreation(string $date_creation) Return the first Trade filtered by the date_creation column
 * @method Trade findOneByDateModification(string $date_modification) Return the first Trade filtered by the date_modification column
 * @method Trade findOneByIdGroupCreation(int $id_group_creation) Return the first Trade filtered by the id_group_creation column
 * @method Trade findOneByIdCreation(int $id_creation) Return the first Trade filtered by the id_creation column
 * @method Trade findOneByIdModification(int $id_modification) Return the first Trade filtered by the id_modification column
 *
 * @method array findByIdTrade(int $id_trade) Return Trade objects filtered by the id_trade column
 * @method array findByStartAvg(int $start_avg) Return Trade objects filtered by the start_avg column
 * @method array findByType(int $type) Return Trade objects filtered by the type column
 * @method array findByIdExchange(int $id_exchange) Return Trade objects filtered by the id_exchange column
 * @method array findByIdAsset(int $id_asset) Return Trade objects filtered by the id_asset column
 * @method array findByIdSymbol(int $id_symbol) Return Trade objects filtered by the id_symbol column
 * @method array findByDate(string $date) Return Trade objects filtered by the date column
 * @method array findByQty(string $qty) Return Trade objects filtered by the qty column
 * @method array findByGrossUsd(string $gross_usd) Return Trade objects filtered by the gross_usd column
 * @method array findByCommission(string $commission) Return Trade objects filtered by the commission column
 * @method array findByCommissionAsset(int $commission_asset) Return Trade objects filtered by the commission_asset column
 * @method array findByOrderId(string $order_id) Return Trade objects filtered by the order_id column
 * @method array findByDateCreation(string $date_creation) Return Trade objects filtered by the date_creation column
 * @method array findByDateModification(string $date_modification) Return Trade objects filtered by the date_modification column
 * @method array findByIdGroupCreation(int $id_group_creation) Return Trade objects filtered by the id_group_creation column
 * @method array findByIdCreation(int $id_creation) Return Trade objects filtered by the id_creation column
 * @method array findByIdModification(int $id_modification) Return Trade objects filtered by the id_modification column
 *
 * @package    propel.generator..om
 */
abstract class BaseTradeQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseTradeQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'cryptobboy';
        }
        if (null === $modelName) {
            $modelName = 'App\\Trade';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new TradeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   TradeQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return TradeQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof TradeQuery) {
            return $criteria;
        }
        $query = new TradeQuery(null, null, $modelAlias);

        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * @Query()
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Trade|Trade[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TradePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Trade A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByIdTrade($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Trade A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id_trade`, `start_avg`, `type`, `id_exchange`, `id_asset`, `id_symbol`, `date`, `qty`, `gross_usd`, `commission`, `commission_asset`, `order_id`, `date_creation`, `date_modification`, `id_group_creation`, `id_creation`, `id_modification` FROM `trade` WHERE `id_trade` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Trade();
            $obj->hydrate($row);
            TradePeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * @Query()
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Trade|Trade[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }


    /**
     * @Query()
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Trade[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TradePeer::ID_TRADE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TradePeer::ID_TRADE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_trade column
     *
     * Example usage:
     * <code>
     * $query->filterByIdTrade(1234); // WHERE id_trade = 1234
     * $query->filterByIdTrade(array(12, 34)); // WHERE id_trade IN (12, 34)
     * $query->filterByIdTrade(array('min' => 12)); // WHERE id_trade >= 12
     * $query->filterByIdTrade(array('max' => 12)); // WHERE id_trade <= 12
     * </code>
     *
     * @param     mixed $idTrade The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function filterByIdTrade($idTrade = null, $comparison = null)
    {
        if (is_array($idTrade)) {
            $useMinMax = false;
            if (isset($idTrade['min'])) {
                $this->addUsingAlias(TradePeer::ID_TRADE, $idTrade['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTrade['max'])) {
                $this->addUsingAlias(TradePeer::ID_TRADE, $idTrade['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TradePeer::ID_TRADE, $idTrade, $comparison);
    }

    /**
     * Filter the query on the start_avg column
     *
     * @param     mixed $startAvg The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TradeQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByStartAvg($startAvg = null, $comparison = null)
    {
        if (is_scalar($startAvg)) {
            $startAvg = TradePeer::getSqlValueForEnum(TradePeer::START_AVG, $startAvg);
        } elseif (is_array($startAvg)) {
            $convertedValues = array();
            foreach ($startAvg as $value) {
                $convertedValues[] = TradePeer::getSqlValueForEnum(TradePeer::START_AVG, $value);
            }
            $startAvg = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TradePeer::START_AVG, $startAvg, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * @param     mixed $type The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TradeQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (is_scalar($type)) {
            $type = TradePeer::getSqlValueForEnum(TradePeer::TYPE, $type);
        } elseif (is_array($type)) {
            $convertedValues = array();
            foreach ($type as $value) {
                $convertedValues[] = TradePeer::getSqlValueForEnum(TradePeer::TYPE, $value);
            }
            $type = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TradePeer::TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the id_exchange column
     *
     * Example usage:
     * <code>
     * $query->filterByIdExchange(1234); // WHERE id_exchange = 1234
     * $query->filterByIdExchange(array(12, 34)); // WHERE id_exchange IN (12, 34)
     * $query->filterByIdExchange(array('min' => 12)); // WHERE id_exchange >= 12
     * $query->filterByIdExchange(array('max' => 12)); // WHERE id_exchange <= 12
     * </code>
     *
     * @see       filterByExchange()
     *
     * @param     mixed $idExchange The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function filterByIdExchange($idExchange = null, $comparison = null)
    {
        if (is_array($idExchange)) {
            $useMinMax = false;
            if (isset($idExchange['min'])) {
                $this->addUsingAlias(TradePeer::ID_EXCHANGE, $idExchange['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idExchange['max'])) {
                $this->addUsingAlias(TradePeer::ID_EXCHANGE, $idExchange['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TradePeer::ID_EXCHANGE, $idExchange, $comparison);
    }

    /**
     * Filter the query on the id_asset column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAsset(1234); // WHERE id_asset = 1234
     * $query->filterByIdAsset(array(12, 34)); // WHERE id_asset IN (12, 34)
     * $query->filterByIdAsset(array('min' => 12)); // WHERE id_asset >= 12
     * $query->filterByIdAsset(array('max' => 12)); // WHERE id_asset <= 12
     * </code>
     *
     * @see       filterByAsset()
     *
     * @param     mixed $idAsset The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function filterByIdAsset($idAsset = null, $comparison = null)
    {
        if (is_array($idAsset)) {
            $useMinMax = false;
            if (isset($idAsset['min'])) {
                $this->addUsingAlias(TradePeer::ID_ASSET, $idAsset['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAsset['max'])) {
                $this->addUsingAlias(TradePeer::ID_ASSET, $idAsset['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TradePeer::ID_ASSET, $idAsset, $comparison);
    }

    /**
     * Filter the query on the id_symbol column
     *
     * Example usage:
     * <code>
     * $query->filterByIdSymbol(1234); // WHERE id_symbol = 1234
     * $query->filterByIdSymbol(array(12, 34)); // WHERE id_symbol IN (12, 34)
     * $query->filterByIdSymbol(array('min' => 12)); // WHERE id_symbol >= 12
     * $query->filterByIdSymbol(array('max' => 12)); // WHERE id_symbol <= 12
     * </code>
     *
     * @see       filterBySymbol()
     *
     * @param     mixed $idSymbol The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function filterByIdSymbol($idSymbol = null, $comparison = null)
    {
        if (is_array($idSymbol)) {
            $useMinMax = false;
            if (isset($idSymbol['min'])) {
                $this->addUsingAlias(TradePeer::ID_SYMBOL, $idSymbol['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idSymbol['max'])) {
                $this->addUsingAlias(TradePeer::ID_SYMBOL, $idSymbol['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TradePeer::ID_SYMBOL, $idSymbol, $comparison);
    }

    /**
     * Filter the query on the date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate('2011-03-14'); // WHERE date = '2011-03-14'
     * $query->filterByDate('now'); // WHERE date = '2011-03-14'
     * $query->filterByDate(array('max' => 'yesterday')); // WHERE date < '2011-03-13'
     * </code>
     *
     * @param     mixed $date The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(TradePeer::DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(TradePeer::DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TradePeer::DATE, $date, $comparison);
    }

    /**
     * Filter the query on the qty column
     *
     * Example usage:
     * <code>
     * $query->filterByQty(1234); // WHERE qty = 1234
     * $query->filterByQty(array(12, 34)); // WHERE qty IN (12, 34)
     * $query->filterByQty(array('min' => 12)); // WHERE qty >= 12
     * $query->filterByQty(array('max' => 12)); // WHERE qty <= 12
     * </code>
     *
     * @param     mixed $qty The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function filterByQty($qty = null, $comparison = null)
    {
        if (is_array($qty)) {
            $useMinMax = false;
            if (isset($qty['min'])) {
                $this->addUsingAlias(TradePeer::QTY, $qty['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($qty['max'])) {
                $this->addUsingAlias(TradePeer::QTY, $qty['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TradePeer::QTY, $qty, $comparison);
    }

    /**
     * Filter the query on the gross_usd column
     *
     * Example usage:
     * <code>
     * $query->filterByGrossUsd(1234); // WHERE gross_usd = 1234
     * $query->filterByGrossUsd(array(12, 34)); // WHERE gross_usd IN (12, 34)
     * $query->filterByGrossUsd(array('min' => 12)); // WHERE gross_usd >= 12
     * $query->filterByGrossUsd(array('max' => 12)); // WHERE gross_usd <= 12
     * </code>
     *
     * @param     mixed $grossUsd The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function filterByGrossUsd($grossUsd = null, $comparison = null)
    {
        if (is_array($grossUsd)) {
            $useMinMax = false;
            if (isset($grossUsd['min'])) {
                $this->addUsingAlias(TradePeer::GROSS_USD, $grossUsd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($grossUsd['max'])) {
                $this->addUsingAlias(TradePeer::GROSS_USD, $grossUsd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TradePeer::GROSS_USD, $grossUsd, $comparison);
    }

    /**
     * Filter the query on the commission column
     *
     * Example usage:
     * <code>
     * $query->filterByCommission(1234); // WHERE commission = 1234
     * $query->filterByCommission(array(12, 34)); // WHERE commission IN (12, 34)
     * $query->filterByCommission(array('min' => 12)); // WHERE commission >= 12
     * $query->filterByCommission(array('max' => 12)); // WHERE commission <= 12
     * </code>
     *
     * @param     mixed $commission The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function filterByCommission($commission = null, $comparison = null)
    {
        if (is_array($commission)) {
            $useMinMax = false;
            if (isset($commission['min'])) {
                $this->addUsingAlias(TradePeer::COMMISSION, $commission['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($commission['max'])) {
                $this->addUsingAlias(TradePeer::COMMISSION, $commission['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TradePeer::COMMISSION, $commission, $comparison);
    }

    /**
     * Filter the query on the commission_asset column
     *
     * Example usage:
     * <code>
     * $query->filterByCommissionAsset(1234); // WHERE commission_asset = 1234
     * $query->filterByCommissionAsset(array(12, 34)); // WHERE commission_asset IN (12, 34)
     * $query->filterByCommissionAsset(array('min' => 12)); // WHERE commission_asset >= 12
     * $query->filterByCommissionAsset(array('max' => 12)); // WHERE commission_asset <= 12
     * </code>
     *
     * @see       filterByToken()
     *
     * @param     mixed $commissionAsset The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function filterByCommissionAsset($commissionAsset = null, $comparison = null)
    {
        if (is_array($commissionAsset)) {
            $useMinMax = false;
            if (isset($commissionAsset['min'])) {
                $this->addUsingAlias(TradePeer::COMMISSION_ASSET, $commissionAsset['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($commissionAsset['max'])) {
                $this->addUsingAlias(TradePeer::COMMISSION_ASSET, $commissionAsset['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TradePeer::COMMISSION_ASSET, $commissionAsset, $comparison);
    }

    /**
     * Filter the query on the order_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderId(1234); // WHERE order_id = 1234
     * $query->filterByOrderId(array(12, 34)); // WHERE order_id IN (12, 34)
     * $query->filterByOrderId(array('min' => 12)); // WHERE order_id >= 12
     * $query->filterByOrderId(array('max' => 12)); // WHERE order_id <= 12
     * </code>
     *
     * @param     mixed $orderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(TradePeer::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(TradePeer::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TradePeer::ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the date_creation column
     *
     * Example usage:
     * <code>
     * $query->filterByDateCreation('2011-03-14'); // WHERE date_creation = '2011-03-14'
     * $query->filterByDateCreation('now'); // WHERE date_creation = '2011-03-14'
     * $query->filterByDateCreation(array('max' => 'yesterday')); // WHERE date_creation < '2011-03-13'
     * </code>
     *
     * @param     mixed $dateCreation The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function filterByDateCreation($dateCreation = null, $comparison = null)
    {
        if (is_array($dateCreation)) {
            $useMinMax = false;
            if (isset($dateCreation['min'])) {
                $this->addUsingAlias(TradePeer::DATE_CREATION, $dateCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreation['max'])) {
                $this->addUsingAlias(TradePeer::DATE_CREATION, $dateCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TradePeer::DATE_CREATION, $dateCreation, $comparison);
    }

    /**
     * Filter the query on the date_modification column
     *
     * Example usage:
     * <code>
     * $query->filterByDateModification('2011-03-14'); // WHERE date_modification = '2011-03-14'
     * $query->filterByDateModification('now'); // WHERE date_modification = '2011-03-14'
     * $query->filterByDateModification(array('max' => 'yesterday')); // WHERE date_modification < '2011-03-13'
     * </code>
     *
     * @param     mixed $dateModification The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function filterByDateModification($dateModification = null, $comparison = null)
    {
        if (is_array($dateModification)) {
            $useMinMax = false;
            if (isset($dateModification['min'])) {
                $this->addUsingAlias(TradePeer::DATE_MODIFICATION, $dateModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateModification['max'])) {
                $this->addUsingAlias(TradePeer::DATE_MODIFICATION, $dateModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TradePeer::DATE_MODIFICATION, $dateModification, $comparison);
    }

    /**
     * Filter the query on the id_group_creation column
     *
     * Example usage:
     * <code>
     * $query->filterByIdGroupCreation(1234); // WHERE id_group_creation = 1234
     * $query->filterByIdGroupCreation(array(12, 34)); // WHERE id_group_creation IN (12, 34)
     * $query->filterByIdGroupCreation(array('min' => 12)); // WHERE id_group_creation >= 12
     * $query->filterByIdGroupCreation(array('max' => 12)); // WHERE id_group_creation <= 12
     * </code>
     *
     * @see       filterByAuthyGroup()
     *
     * @param     mixed $idGroupCreation The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function filterByIdGroupCreation($idGroupCreation = null, $comparison = null)
    {
        if (is_array($idGroupCreation)) {
            $useMinMax = false;
            if (isset($idGroupCreation['min'])) {
                $this->addUsingAlias(TradePeer::ID_GROUP_CREATION, $idGroupCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idGroupCreation['max'])) {
                $this->addUsingAlias(TradePeer::ID_GROUP_CREATION, $idGroupCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TradePeer::ID_GROUP_CREATION, $idGroupCreation, $comparison);
    }

    /**
     * Filter the query on the id_creation column
     *
     * Example usage:
     * <code>
     * $query->filterByIdCreation(1234); // WHERE id_creation = 1234
     * $query->filterByIdCreation(array(12, 34)); // WHERE id_creation IN (12, 34)
     * $query->filterByIdCreation(array('min' => 12)); // WHERE id_creation >= 12
     * $query->filterByIdCreation(array('max' => 12)); // WHERE id_creation <= 12
     * </code>
     *
     * @see       filterByAuthyRelatedByIdCreation()
     *
     * @param     mixed $idCreation The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function filterByIdCreation($idCreation = null, $comparison = null)
    {
        if (is_array($idCreation)) {
            $useMinMax = false;
            if (isset($idCreation['min'])) {
                $this->addUsingAlias(TradePeer::ID_CREATION, $idCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCreation['max'])) {
                $this->addUsingAlias(TradePeer::ID_CREATION, $idCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TradePeer::ID_CREATION, $idCreation, $comparison);
    }

    /**
     * Filter the query on the id_modification column
     *
     * Example usage:
     * <code>
     * $query->filterByIdModification(1234); // WHERE id_modification = 1234
     * $query->filterByIdModification(array(12, 34)); // WHERE id_modification IN (12, 34)
     * $query->filterByIdModification(array('min' => 12)); // WHERE id_modification >= 12
     * $query->filterByIdModification(array('max' => 12)); // WHERE id_modification <= 12
     * </code>
     *
     * @see       filterByAuthyRelatedByIdModification()
     *
     * @param     mixed $idModification The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function filterByIdModification($idModification = null, $comparison = null)
    {
        if (is_array($idModification)) {
            $useMinMax = false;
            if (isset($idModification['min'])) {
                $this->addUsingAlias(TradePeer::ID_MODIFICATION, $idModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idModification['max'])) {
                $this->addUsingAlias(TradePeer::ID_MODIFICATION, $idModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TradePeer::ID_MODIFICATION, $idModification, $comparison);
    }

    /**
     * Filter the query by a related Exchange object
     *
     * @param   Exchange|PropelObjectCollection $exchange The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TradeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByExchange($exchange, $comparison = null)
    {
        if ($exchange instanceof Exchange) {
            return $this
                ->addUsingAlias(TradePeer::ID_EXCHANGE, $exchange->getIdExchange(), $comparison);
        } elseif ($exchange instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TradePeer::ID_EXCHANGE, $exchange->toKeyValue('PrimaryKey', 'IdExchange'), $comparison);
        } else {
            throw new PropelException('filterByExchange() only accepts arguments of type Exchange or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Exchange relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function joinExchange($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Exchange');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Exchange');
        }

        return $this;
    }

    /**
     * Use the Exchange relation Exchange object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\ExchangeQuery A secondary query class using the current class as primary query
     */
    public function useExchangeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinExchange($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Exchange', '\App\ExchangeQuery');
    }

    /**
     * Filter the query by a related Asset object
     *
     * @param   Asset|PropelObjectCollection $asset The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TradeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAsset($asset, $comparison = null)
    {
        if ($asset instanceof Asset) {
            return $this
                ->addUsingAlias(TradePeer::ID_ASSET, $asset->getIdAsset(), $comparison);
        } elseif ($asset instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TradePeer::ID_ASSET, $asset->toKeyValue('PrimaryKey', 'IdAsset'), $comparison);
        } else {
            throw new PropelException('filterByAsset() only accepts arguments of type Asset or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Asset relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function joinAsset($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Asset');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Asset');
        }

        return $this;
    }

    /**
     * Use the Asset relation Asset object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AssetQuery A secondary query class using the current class as primary query
     */
    public function useAssetQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAsset($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Asset', '\App\AssetQuery');
    }

    /**
     * Filter the query by a related Symbol object
     *
     * @param   Symbol|PropelObjectCollection $symbol The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TradeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySymbol($symbol, $comparison = null)
    {
        if ($symbol instanceof Symbol) {
            return $this
                ->addUsingAlias(TradePeer::ID_SYMBOL, $symbol->getIdSymbol(), $comparison);
        } elseif ($symbol instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TradePeer::ID_SYMBOL, $symbol->toKeyValue('PrimaryKey', 'IdSymbol'), $comparison);
        } else {
            throw new PropelException('filterBySymbol() only accepts arguments of type Symbol or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Symbol relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function joinSymbol($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Symbol');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Symbol');
        }

        return $this;
    }

    /**
     * Use the Symbol relation Symbol object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\SymbolQuery A secondary query class using the current class as primary query
     */
    public function useSymbolQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSymbol($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Symbol', '\App\SymbolQuery');
    }

    /**
     * Filter the query by a related Token object
     *
     * @param   Token|PropelObjectCollection $token The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TradeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByToken($token, $comparison = null)
    {
        if ($token instanceof Token) {
            return $this
                ->addUsingAlias(TradePeer::COMMISSION_ASSET, $token->getIdToken(), $comparison);
        } elseif ($token instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TradePeer::COMMISSION_ASSET, $token->toKeyValue('PrimaryKey', 'IdToken'), $comparison);
        } else {
            throw new PropelException('filterByToken() only accepts arguments of type Token or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Token relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function joinToken($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Token');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Token');
        }

        return $this;
    }

    /**
     * Use the Token relation Token object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\TokenQuery A secondary query class using the current class as primary query
     */
    public function useTokenQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinToken($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Token', '\App\TokenQuery');
    }

    /**
     * Filter the query by a related AuthyGroup object
     *
     * @param   AuthyGroup|PropelObjectCollection $authyGroup The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TradeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyGroup($authyGroup, $comparison = null)
    {
        if ($authyGroup instanceof AuthyGroup) {
            return $this
                ->addUsingAlias(TradePeer::ID_GROUP_CREATION, $authyGroup->getIdAuthyGroup(), $comparison);
        } elseif ($authyGroup instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TradePeer::ID_GROUP_CREATION, $authyGroup->toKeyValue('PrimaryKey', 'IdAuthyGroup'), $comparison);
        } else {
            throw new PropelException('filterByAuthyGroup() only accepts arguments of type AuthyGroup or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuthyGroup relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function joinAuthyGroup($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuthyGroup');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'AuthyGroup');
        }

        return $this;
    }

    /**
     * Use the AuthyGroup relation AuthyGroup object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AuthyGroupQuery A secondary query class using the current class as primary query
     */
    public function useAuthyGroupQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAuthyGroup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuthyGroup', '\App\AuthyGroupQuery');
    }

    /**
     * Filter the query by a related Authy object
     *
     * @param   Authy|PropelObjectCollection $authy The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TradeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyRelatedByIdCreation($authy, $comparison = null)
    {
        if ($authy instanceof Authy) {
            return $this
                ->addUsingAlias(TradePeer::ID_CREATION, $authy->getIdAuthy(), $comparison);
        } elseif ($authy instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TradePeer::ID_CREATION, $authy->toKeyValue('PrimaryKey', 'IdAuthy'), $comparison);
        } else {
            throw new PropelException('filterByAuthyRelatedByIdCreation() only accepts arguments of type Authy or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuthyRelatedByIdCreation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function joinAuthyRelatedByIdCreation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuthyRelatedByIdCreation');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'AuthyRelatedByIdCreation');
        }

        return $this;
    }

    /**
     * Use the AuthyRelatedByIdCreation relation Authy object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AuthyQuery A secondary query class using the current class as primary query
     */
    public function useAuthyRelatedByIdCreationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAuthyRelatedByIdCreation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuthyRelatedByIdCreation', '\App\AuthyQuery');
    }

    /**
     * Filter the query by a related Authy object
     *
     * @param   Authy|PropelObjectCollection $authy The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TradeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyRelatedByIdModification($authy, $comparison = null)
    {
        if ($authy instanceof Authy) {
            return $this
                ->addUsingAlias(TradePeer::ID_MODIFICATION, $authy->getIdAuthy(), $comparison);
        } elseif ($authy instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TradePeer::ID_MODIFICATION, $authy->toKeyValue('PrimaryKey', 'IdAuthy'), $comparison);
        } else {
            throw new PropelException('filterByAuthyRelatedByIdModification() only accepts arguments of type Authy or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuthyRelatedByIdModification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function joinAuthyRelatedByIdModification($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuthyRelatedByIdModification');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'AuthyRelatedByIdModification');
        }

        return $this;
    }

    /**
     * Use the AuthyRelatedByIdModification relation Authy object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AuthyQuery A secondary query class using the current class as primary query
     */
    public function useAuthyRelatedByIdModificationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAuthyRelatedByIdModification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuthyRelatedByIdModification', '\App\AuthyQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Trade $trade Object to remove from the list of results
     *
     * @return TradeQuery The current query, for fluid interface
     */
    public function prune($trade = null)
    {
        if ($trade) {
            $this->addUsingAlias(TradePeer::ID_TRADE, $trade->getIdTrade(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // add_tablestamp behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     TradeQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7){
        return $this->addUsingAlias(TradePeer::DATE_MODIFICATION, time() - $nbDays * 24 * 60 * 60, \Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     TradeQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst(){
        return $this->addDescendingOrderByColumn(TradePeer::DATE_MODIFICATION);
    }

    /**
     * Order by update date asc
     *
     * @return     TradeQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst(){
        return $this->addAscendingOrderByColumn(TradePeer::DATE_MODIFICATION);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     TradeQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7){
        return $this->addUsingAlias(TradePeer::DATE_CREATION, time() - $nbDays * 24 * 60 * 60, \Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     TradeQuery The current query, for fluid interface
     */
    public function lastCreatedFirst(){
        return $this->addDescendingOrderByColumn(TradePeer::DATE_CREATION);
    }

    /**
     * Order by create date asc
     *
     * @return     TradeQuery The current query, for fluid interface
     */
    public function firstCreatedFirst(){
        return $this->addAscendingOrderByColumn(TradePeer::DATE_CREATION);
    }
}
