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
use App\AssetExchange;
use App\AssetPeer;
use App\AssetQuery;
use App\Authy;
use App\AuthyGroup;
use App\Symbol;
use App\Token;
use App\Trade;

/**
 * Base class that represents a query for the 'asset' table.
 *
 * Asset
 *
 * @method AssetQuery orderByIdAsset($order = Criteria::ASC) Order by the id_asset column
 * @method AssetQuery orderByIdToken($order = Criteria::ASC) Order by the id_token column
 * @method AssetQuery orderByFreeToken($order = Criteria::ASC) Order by the free_token column
 * @method AssetQuery orderByStakedToken($order = Criteria::ASC) Order by the staked_token column
 * @method AssetQuery orderByTotalToken($order = Criteria::ASC) Order by the total_token column
 * @method AssetQuery orderByUsdValue($order = Criteria::ASC) Order by the usd_value column
 * @method AssetQuery orderByIdSymbol($order = Criteria::ASC) Order by the id_symbol column
 * @method AssetQuery orderByAvgPrice($order = Criteria::ASC) Order by the avg_price column
 * @method AssetQuery orderByProfit($order = Criteria::ASC) Order by the profit column
 * @method AssetQuery orderByFlexibleToken($order = Criteria::ASC) Order by the flexible_token column
 * @method AssetQuery orderByLockedToken($order = Criteria::ASC) Order by the locked_token column
 * @method AssetQuery orderByFreezeToken($order = Criteria::ASC) Order by the freeze_token column
 * @method AssetQuery orderByLastSync($order = Criteria::ASC) Order by the last_sync column
 * @method AssetQuery orderByDateCreation($order = Criteria::ASC) Order by the date_creation column
 * @method AssetQuery orderByDateModification($order = Criteria::ASC) Order by the date_modification column
 * @method AssetQuery orderByIdGroupCreation($order = Criteria::ASC) Order by the id_group_creation column
 * @method AssetQuery orderByIdCreation($order = Criteria::ASC) Order by the id_creation column
 * @method AssetQuery orderByIdModification($order = Criteria::ASC) Order by the id_modification column
 *
 * @method AssetQuery groupByIdAsset() Group by the id_asset column
 * @method AssetQuery groupByIdToken() Group by the id_token column
 * @method AssetQuery groupByFreeToken() Group by the free_token column
 * @method AssetQuery groupByStakedToken() Group by the staked_token column
 * @method AssetQuery groupByTotalToken() Group by the total_token column
 * @method AssetQuery groupByUsdValue() Group by the usd_value column
 * @method AssetQuery groupByIdSymbol() Group by the id_symbol column
 * @method AssetQuery groupByAvgPrice() Group by the avg_price column
 * @method AssetQuery groupByProfit() Group by the profit column
 * @method AssetQuery groupByFlexibleToken() Group by the flexible_token column
 * @method AssetQuery groupByLockedToken() Group by the locked_token column
 * @method AssetQuery groupByFreezeToken() Group by the freeze_token column
 * @method AssetQuery groupByLastSync() Group by the last_sync column
 * @method AssetQuery groupByDateCreation() Group by the date_creation column
 * @method AssetQuery groupByDateModification() Group by the date_modification column
 * @method AssetQuery groupByIdGroupCreation() Group by the id_group_creation column
 * @method AssetQuery groupByIdCreation() Group by the id_creation column
 * @method AssetQuery groupByIdModification() Group by the id_modification column
 *
 * @method AssetQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AssetQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AssetQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AssetQuery leftJoinToken($relationAlias = null) Adds a LEFT JOIN clause to the query using the Token relation
 * @method AssetQuery rightJoinToken($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Token relation
 * @method AssetQuery innerJoinToken($relationAlias = null) Adds a INNER JOIN clause to the query using the Token relation
 *
 * @method AssetQuery leftJoinSymbol($relationAlias = null) Adds a LEFT JOIN clause to the query using the Symbol relation
 * @method AssetQuery rightJoinSymbol($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Symbol relation
 * @method AssetQuery innerJoinSymbol($relationAlias = null) Adds a INNER JOIN clause to the query using the Symbol relation
 *
 * @method AssetQuery leftJoinAuthyGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyGroup relation
 * @method AssetQuery rightJoinAuthyGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyGroup relation
 * @method AssetQuery innerJoinAuthyGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyGroup relation
 *
 * @method AssetQuery leftJoinAuthyRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyRelatedByIdCreation relation
 * @method AssetQuery rightJoinAuthyRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyRelatedByIdCreation relation
 * @method AssetQuery innerJoinAuthyRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyRelatedByIdCreation relation
 *
 * @method AssetQuery leftJoinAuthyRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyRelatedByIdModification relation
 * @method AssetQuery rightJoinAuthyRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyRelatedByIdModification relation
 * @method AssetQuery innerJoinAuthyRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyRelatedByIdModification relation
 *
 * @method AssetQuery leftJoinAssetExchange($relationAlias = null) Adds a LEFT JOIN clause to the query using the AssetExchange relation
 * @method AssetQuery rightJoinAssetExchange($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AssetExchange relation
 * @method AssetQuery innerJoinAssetExchange($relationAlias = null) Adds a INNER JOIN clause to the query using the AssetExchange relation
 *
 * @method AssetQuery leftJoinTrade($relationAlias = null) Adds a LEFT JOIN clause to the query using the Trade relation
 * @method AssetQuery rightJoinTrade($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Trade relation
 * @method AssetQuery innerJoinTrade($relationAlias = null) Adds a INNER JOIN clause to the query using the Trade relation
 *
 * @method Asset findOne(PropelPDO $con = null) Return the first Asset matching the query
 * @method Asset findOneOrCreate(PropelPDO $con = null) Return the first Asset matching the query, or a new Asset object populated from the query conditions when no match is found
 *
 * @method Asset findOneByIdToken(int $id_token) Return the first Asset filtered by the id_token column
 * @method Asset findOneByFreeToken(string $free_token) Return the first Asset filtered by the free_token column
 * @method Asset findOneByStakedToken(string $staked_token) Return the first Asset filtered by the staked_token column
 * @method Asset findOneByTotalToken(string $total_token) Return the first Asset filtered by the total_token column
 * @method Asset findOneByUsdValue(string $usd_value) Return the first Asset filtered by the usd_value column
 * @method Asset findOneByIdSymbol(int $id_symbol) Return the first Asset filtered by the id_symbol column
 * @method Asset findOneByAvgPrice(string $avg_price) Return the first Asset filtered by the avg_price column
 * @method Asset findOneByProfit(string $profit) Return the first Asset filtered by the profit column
 * @method Asset findOneByFlexibleToken(string $flexible_token) Return the first Asset filtered by the flexible_token column
 * @method Asset findOneByLockedToken(string $locked_token) Return the first Asset filtered by the locked_token column
 * @method Asset findOneByFreezeToken(string $freeze_token) Return the first Asset filtered by the freeze_token column
 * @method Asset findOneByLastSync(string $last_sync) Return the first Asset filtered by the last_sync column
 * @method Asset findOneByDateCreation(string $date_creation) Return the first Asset filtered by the date_creation column
 * @method Asset findOneByDateModification(string $date_modification) Return the first Asset filtered by the date_modification column
 * @method Asset findOneByIdGroupCreation(int $id_group_creation) Return the first Asset filtered by the id_group_creation column
 * @method Asset findOneByIdCreation(int $id_creation) Return the first Asset filtered by the id_creation column
 * @method Asset findOneByIdModification(int $id_modification) Return the first Asset filtered by the id_modification column
 *
 * @method array findByIdAsset(int $id_asset) Return Asset objects filtered by the id_asset column
 * @method array findByIdToken(int $id_token) Return Asset objects filtered by the id_token column
 * @method array findByFreeToken(string $free_token) Return Asset objects filtered by the free_token column
 * @method array findByStakedToken(string $staked_token) Return Asset objects filtered by the staked_token column
 * @method array findByTotalToken(string $total_token) Return Asset objects filtered by the total_token column
 * @method array findByUsdValue(string $usd_value) Return Asset objects filtered by the usd_value column
 * @method array findByIdSymbol(int $id_symbol) Return Asset objects filtered by the id_symbol column
 * @method array findByAvgPrice(string $avg_price) Return Asset objects filtered by the avg_price column
 * @method array findByProfit(string $profit) Return Asset objects filtered by the profit column
 * @method array findByFlexibleToken(string $flexible_token) Return Asset objects filtered by the flexible_token column
 * @method array findByLockedToken(string $locked_token) Return Asset objects filtered by the locked_token column
 * @method array findByFreezeToken(string $freeze_token) Return Asset objects filtered by the freeze_token column
 * @method array findByLastSync(string $last_sync) Return Asset objects filtered by the last_sync column
 * @method array findByDateCreation(string $date_creation) Return Asset objects filtered by the date_creation column
 * @method array findByDateModification(string $date_modification) Return Asset objects filtered by the date_modification column
 * @method array findByIdGroupCreation(int $id_group_creation) Return Asset objects filtered by the id_group_creation column
 * @method array findByIdCreation(int $id_creation) Return Asset objects filtered by the id_creation column
 * @method array findByIdModification(int $id_modification) Return Asset objects filtered by the id_modification column
 *
 * @package    propel.generator..om
 */
abstract class BaseAssetQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAssetQuery object.
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
            $modelName = 'App\\Asset';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AssetQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AssetQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AssetQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AssetQuery) {
            return $criteria;
        }
        $query = new AssetQuery(null, null, $modelAlias);

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
     * @return   Asset|Asset[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AssetPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AssetPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Asset A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByIdAsset($key, $con = null)
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
     * @return                 Asset A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id_asset`, `id_token`, `free_token`, `staked_token`, `total_token`, `usd_value`, `id_symbol`, `avg_price`, `profit`, `flexible_token`, `locked_token`, `freeze_token`, `last_sync`, `date_creation`, `date_modification`, `id_group_creation`, `id_creation`, `id_modification` FROM `asset` WHERE `id_asset` = :p0';
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
            $obj = new Asset();
            $obj->hydrate($row);
            AssetPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Asset|Asset[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Asset[]|mixed the list of results, formatted by the current formatter
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
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AssetPeer::ID_ASSET, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AssetPeer::ID_ASSET, $keys, Criteria::IN);
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
     * @param     mixed $idAsset The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByIdAsset($idAsset = null, $comparison = null)
    {
        if (is_array($idAsset)) {
            $useMinMax = false;
            if (isset($idAsset['min'])) {
                $this->addUsingAlias(AssetPeer::ID_ASSET, $idAsset['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAsset['max'])) {
                $this->addUsingAlias(AssetPeer::ID_ASSET, $idAsset['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::ID_ASSET, $idAsset, $comparison);
    }

    /**
     * Filter the query on the id_token column
     *
     * Example usage:
     * <code>
     * $query->filterByIdToken(1234); // WHERE id_token = 1234
     * $query->filterByIdToken(array(12, 34)); // WHERE id_token IN (12, 34)
     * $query->filterByIdToken(array('min' => 12)); // WHERE id_token >= 12
     * $query->filterByIdToken(array('max' => 12)); // WHERE id_token <= 12
     * </code>
     *
     * @see       filterByToken()
     *
     * @param     mixed $idToken The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByIdToken($idToken = null, $comparison = null)
    {
        if (is_array($idToken)) {
            $useMinMax = false;
            if (isset($idToken['min'])) {
                $this->addUsingAlias(AssetPeer::ID_TOKEN, $idToken['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idToken['max'])) {
                $this->addUsingAlias(AssetPeer::ID_TOKEN, $idToken['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::ID_TOKEN, $idToken, $comparison);
    }

    /**
     * Filter the query on the free_token column
     *
     * Example usage:
     * <code>
     * $query->filterByFreeToken(1234); // WHERE free_token = 1234
     * $query->filterByFreeToken(array(12, 34)); // WHERE free_token IN (12, 34)
     * $query->filterByFreeToken(array('min' => 12)); // WHERE free_token >= 12
     * $query->filterByFreeToken(array('max' => 12)); // WHERE free_token <= 12
     * </code>
     *
     * @param     mixed $freeToken The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByFreeToken($freeToken = null, $comparison = null)
    {
        if (is_array($freeToken)) {
            $useMinMax = false;
            if (isset($freeToken['min'])) {
                $this->addUsingAlias(AssetPeer::FREE_TOKEN, $freeToken['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($freeToken['max'])) {
                $this->addUsingAlias(AssetPeer::FREE_TOKEN, $freeToken['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::FREE_TOKEN, $freeToken, $comparison);
    }

    /**
     * Filter the query on the staked_token column
     *
     * Example usage:
     * <code>
     * $query->filterByStakedToken(1234); // WHERE staked_token = 1234
     * $query->filterByStakedToken(array(12, 34)); // WHERE staked_token IN (12, 34)
     * $query->filterByStakedToken(array('min' => 12)); // WHERE staked_token >= 12
     * $query->filterByStakedToken(array('max' => 12)); // WHERE staked_token <= 12
     * </code>
     *
     * @param     mixed $stakedToken The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByStakedToken($stakedToken = null, $comparison = null)
    {
        if (is_array($stakedToken)) {
            $useMinMax = false;
            if (isset($stakedToken['min'])) {
                $this->addUsingAlias(AssetPeer::STAKED_TOKEN, $stakedToken['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stakedToken['max'])) {
                $this->addUsingAlias(AssetPeer::STAKED_TOKEN, $stakedToken['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::STAKED_TOKEN, $stakedToken, $comparison);
    }

    /**
     * Filter the query on the total_token column
     *
     * Example usage:
     * <code>
     * $query->filterByTotalToken(1234); // WHERE total_token = 1234
     * $query->filterByTotalToken(array(12, 34)); // WHERE total_token IN (12, 34)
     * $query->filterByTotalToken(array('min' => 12)); // WHERE total_token >= 12
     * $query->filterByTotalToken(array('max' => 12)); // WHERE total_token <= 12
     * </code>
     *
     * @param     mixed $totalToken The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByTotalToken($totalToken = null, $comparison = null)
    {
        if (is_array($totalToken)) {
            $useMinMax = false;
            if (isset($totalToken['min'])) {
                $this->addUsingAlias(AssetPeer::TOTAL_TOKEN, $totalToken['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($totalToken['max'])) {
                $this->addUsingAlias(AssetPeer::TOTAL_TOKEN, $totalToken['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::TOTAL_TOKEN, $totalToken, $comparison);
    }

    /**
     * Filter the query on the usd_value column
     *
     * Example usage:
     * <code>
     * $query->filterByUsdValue(1234); // WHERE usd_value = 1234
     * $query->filterByUsdValue(array(12, 34)); // WHERE usd_value IN (12, 34)
     * $query->filterByUsdValue(array('min' => 12)); // WHERE usd_value >= 12
     * $query->filterByUsdValue(array('max' => 12)); // WHERE usd_value <= 12
     * </code>
     *
     * @param     mixed $usdValue The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByUsdValue($usdValue = null, $comparison = null)
    {
        if (is_array($usdValue)) {
            $useMinMax = false;
            if (isset($usdValue['min'])) {
                $this->addUsingAlias(AssetPeer::USD_VALUE, $usdValue['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($usdValue['max'])) {
                $this->addUsingAlias(AssetPeer::USD_VALUE, $usdValue['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::USD_VALUE, $usdValue, $comparison);
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
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByIdSymbol($idSymbol = null, $comparison = null)
    {
        if (is_array($idSymbol)) {
            $useMinMax = false;
            if (isset($idSymbol['min'])) {
                $this->addUsingAlias(AssetPeer::ID_SYMBOL, $idSymbol['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idSymbol['max'])) {
                $this->addUsingAlias(AssetPeer::ID_SYMBOL, $idSymbol['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::ID_SYMBOL, $idSymbol, $comparison);
    }

    /**
     * Filter the query on the avg_price column
     *
     * Example usage:
     * <code>
     * $query->filterByAvgPrice(1234); // WHERE avg_price = 1234
     * $query->filterByAvgPrice(array(12, 34)); // WHERE avg_price IN (12, 34)
     * $query->filterByAvgPrice(array('min' => 12)); // WHERE avg_price >= 12
     * $query->filterByAvgPrice(array('max' => 12)); // WHERE avg_price <= 12
     * </code>
     *
     * @param     mixed $avgPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByAvgPrice($avgPrice = null, $comparison = null)
    {
        if (is_array($avgPrice)) {
            $useMinMax = false;
            if (isset($avgPrice['min'])) {
                $this->addUsingAlias(AssetPeer::AVG_PRICE, $avgPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($avgPrice['max'])) {
                $this->addUsingAlias(AssetPeer::AVG_PRICE, $avgPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::AVG_PRICE, $avgPrice, $comparison);
    }

    /**
     * Filter the query on the profit column
     *
     * Example usage:
     * <code>
     * $query->filterByProfit(1234); // WHERE profit = 1234
     * $query->filterByProfit(array(12, 34)); // WHERE profit IN (12, 34)
     * $query->filterByProfit(array('min' => 12)); // WHERE profit >= 12
     * $query->filterByProfit(array('max' => 12)); // WHERE profit <= 12
     * </code>
     *
     * @param     mixed $profit The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByProfit($profit = null, $comparison = null)
    {
        if (is_array($profit)) {
            $useMinMax = false;
            if (isset($profit['min'])) {
                $this->addUsingAlias(AssetPeer::PROFIT, $profit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($profit['max'])) {
                $this->addUsingAlias(AssetPeer::PROFIT, $profit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::PROFIT, $profit, $comparison);
    }

    /**
     * Filter the query on the flexible_token column
     *
     * Example usage:
     * <code>
     * $query->filterByFlexibleToken(1234); // WHERE flexible_token = 1234
     * $query->filterByFlexibleToken(array(12, 34)); // WHERE flexible_token IN (12, 34)
     * $query->filterByFlexibleToken(array('min' => 12)); // WHERE flexible_token >= 12
     * $query->filterByFlexibleToken(array('max' => 12)); // WHERE flexible_token <= 12
     * </code>
     *
     * @param     mixed $flexibleToken The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByFlexibleToken($flexibleToken = null, $comparison = null)
    {
        if (is_array($flexibleToken)) {
            $useMinMax = false;
            if (isset($flexibleToken['min'])) {
                $this->addUsingAlias(AssetPeer::FLEXIBLE_TOKEN, $flexibleToken['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($flexibleToken['max'])) {
                $this->addUsingAlias(AssetPeer::FLEXIBLE_TOKEN, $flexibleToken['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::FLEXIBLE_TOKEN, $flexibleToken, $comparison);
    }

    /**
     * Filter the query on the locked_token column
     *
     * Example usage:
     * <code>
     * $query->filterByLockedToken(1234); // WHERE locked_token = 1234
     * $query->filterByLockedToken(array(12, 34)); // WHERE locked_token IN (12, 34)
     * $query->filterByLockedToken(array('min' => 12)); // WHERE locked_token >= 12
     * $query->filterByLockedToken(array('max' => 12)); // WHERE locked_token <= 12
     * </code>
     *
     * @param     mixed $lockedToken The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByLockedToken($lockedToken = null, $comparison = null)
    {
        if (is_array($lockedToken)) {
            $useMinMax = false;
            if (isset($lockedToken['min'])) {
                $this->addUsingAlias(AssetPeer::LOCKED_TOKEN, $lockedToken['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lockedToken['max'])) {
                $this->addUsingAlias(AssetPeer::LOCKED_TOKEN, $lockedToken['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::LOCKED_TOKEN, $lockedToken, $comparison);
    }

    /**
     * Filter the query on the freeze_token column
     *
     * Example usage:
     * <code>
     * $query->filterByFreezeToken(1234); // WHERE freeze_token = 1234
     * $query->filterByFreezeToken(array(12, 34)); // WHERE freeze_token IN (12, 34)
     * $query->filterByFreezeToken(array('min' => 12)); // WHERE freeze_token >= 12
     * $query->filterByFreezeToken(array('max' => 12)); // WHERE freeze_token <= 12
     * </code>
     *
     * @param     mixed $freezeToken The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByFreezeToken($freezeToken = null, $comparison = null)
    {
        if (is_array($freezeToken)) {
            $useMinMax = false;
            if (isset($freezeToken['min'])) {
                $this->addUsingAlias(AssetPeer::FREEZE_TOKEN, $freezeToken['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($freezeToken['max'])) {
                $this->addUsingAlias(AssetPeer::FREEZE_TOKEN, $freezeToken['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::FREEZE_TOKEN, $freezeToken, $comparison);
    }

    /**
     * Filter the query on the last_sync column
     *
     * Example usage:
     * <code>
     * $query->filterByLastSync('2011-03-14'); // WHERE last_sync = '2011-03-14'
     * $query->filterByLastSync('now'); // WHERE last_sync = '2011-03-14'
     * $query->filterByLastSync(array('max' => 'yesterday')); // WHERE last_sync < '2011-03-13'
     * </code>
     *
     * @param     mixed $lastSync The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByLastSync($lastSync = null, $comparison = null)
    {
        if (is_array($lastSync)) {
            $useMinMax = false;
            if (isset($lastSync['min'])) {
                $this->addUsingAlias(AssetPeer::LAST_SYNC, $lastSync['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastSync['max'])) {
                $this->addUsingAlias(AssetPeer::LAST_SYNC, $lastSync['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::LAST_SYNC, $lastSync, $comparison);
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
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByDateCreation($dateCreation = null, $comparison = null)
    {
        if (is_array($dateCreation)) {
            $useMinMax = false;
            if (isset($dateCreation['min'])) {
                $this->addUsingAlias(AssetPeer::DATE_CREATION, $dateCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreation['max'])) {
                $this->addUsingAlias(AssetPeer::DATE_CREATION, $dateCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::DATE_CREATION, $dateCreation, $comparison);
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
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByDateModification($dateModification = null, $comparison = null)
    {
        if (is_array($dateModification)) {
            $useMinMax = false;
            if (isset($dateModification['min'])) {
                $this->addUsingAlias(AssetPeer::DATE_MODIFICATION, $dateModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateModification['max'])) {
                $this->addUsingAlias(AssetPeer::DATE_MODIFICATION, $dateModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::DATE_MODIFICATION, $dateModification, $comparison);
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
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByIdGroupCreation($idGroupCreation = null, $comparison = null)
    {
        if (is_array($idGroupCreation)) {
            $useMinMax = false;
            if (isset($idGroupCreation['min'])) {
                $this->addUsingAlias(AssetPeer::ID_GROUP_CREATION, $idGroupCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idGroupCreation['max'])) {
                $this->addUsingAlias(AssetPeer::ID_GROUP_CREATION, $idGroupCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::ID_GROUP_CREATION, $idGroupCreation, $comparison);
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
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByIdCreation($idCreation = null, $comparison = null)
    {
        if (is_array($idCreation)) {
            $useMinMax = false;
            if (isset($idCreation['min'])) {
                $this->addUsingAlias(AssetPeer::ID_CREATION, $idCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCreation['max'])) {
                $this->addUsingAlias(AssetPeer::ID_CREATION, $idCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::ID_CREATION, $idCreation, $comparison);
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
     * @return AssetQuery The current query, for fluid interface
     */
    public function filterByIdModification($idModification = null, $comparison = null)
    {
        if (is_array($idModification)) {
            $useMinMax = false;
            if (isset($idModification['min'])) {
                $this->addUsingAlias(AssetPeer::ID_MODIFICATION, $idModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idModification['max'])) {
                $this->addUsingAlias(AssetPeer::ID_MODIFICATION, $idModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetPeer::ID_MODIFICATION, $idModification, $comparison);
    }

    /**
     * Filter the query by a related Token object
     *
     * @param   Token|PropelObjectCollection $token The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AssetQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByToken($token, $comparison = null)
    {
        if ($token instanceof Token) {
            return $this
                ->addUsingAlias(AssetPeer::ID_TOKEN, $token->getIdToken(), $comparison);
        } elseif ($token instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssetPeer::ID_TOKEN, $token->toKeyValue('PrimaryKey', 'IdToken'), $comparison);
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
     * @return AssetQuery The current query, for fluid interface
     */
    public function joinToken($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useTokenQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinToken($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Token', '\App\TokenQuery');
    }

    /**
     * Filter the query by a related Symbol object
     *
     * @param   Symbol|PropelObjectCollection $symbol The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AssetQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySymbol($symbol, $comparison = null)
    {
        if ($symbol instanceof Symbol) {
            return $this
                ->addUsingAlias(AssetPeer::ID_SYMBOL, $symbol->getIdSymbol(), $comparison);
        } elseif ($symbol instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssetPeer::ID_SYMBOL, $symbol->toKeyValue('PrimaryKey', 'IdSymbol'), $comparison);
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
     * @return AssetQuery The current query, for fluid interface
     */
    public function joinSymbol($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useSymbolQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSymbol($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Symbol', '\App\SymbolQuery');
    }

    /**
     * Filter the query by a related AuthyGroup object
     *
     * @param   AuthyGroup|PropelObjectCollection $authyGroup The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AssetQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyGroup($authyGroup, $comparison = null)
    {
        if ($authyGroup instanceof AuthyGroup) {
            return $this
                ->addUsingAlias(AssetPeer::ID_GROUP_CREATION, $authyGroup->getIdAuthyGroup(), $comparison);
        } elseif ($authyGroup instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssetPeer::ID_GROUP_CREATION, $authyGroup->toKeyValue('PrimaryKey', 'IdAuthyGroup'), $comparison);
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
     * @return AssetQuery The current query, for fluid interface
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
     * @return                 AssetQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyRelatedByIdCreation($authy, $comparison = null)
    {
        if ($authy instanceof Authy) {
            return $this
                ->addUsingAlias(AssetPeer::ID_CREATION, $authy->getIdAuthy(), $comparison);
        } elseif ($authy instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssetPeer::ID_CREATION, $authy->toKeyValue('PrimaryKey', 'IdAuthy'), $comparison);
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
     * @return AssetQuery The current query, for fluid interface
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
     * @return                 AssetQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyRelatedByIdModification($authy, $comparison = null)
    {
        if ($authy instanceof Authy) {
            return $this
                ->addUsingAlias(AssetPeer::ID_MODIFICATION, $authy->getIdAuthy(), $comparison);
        } elseif ($authy instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssetPeer::ID_MODIFICATION, $authy->toKeyValue('PrimaryKey', 'IdAuthy'), $comparison);
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
     * @return AssetQuery The current query, for fluid interface
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
     * Filter the query by a related AssetExchange object
     *
     * @param   AssetExchange|PropelObjectCollection $assetExchange  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AssetQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssetExchange($assetExchange, $comparison = null)
    {
        if ($assetExchange instanceof AssetExchange) {
            return $this
                ->addUsingAlias(AssetPeer::ID_ASSET, $assetExchange->getIdAsset(), $comparison);
        } elseif ($assetExchange instanceof PropelObjectCollection) {
            return $this
                ->useAssetExchangeQuery()
                ->filterByPrimaryKeys($assetExchange->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAssetExchange() only accepts arguments of type AssetExchange or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AssetExchange relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AssetQuery The current query, for fluid interface
     */
    public function joinAssetExchange($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AssetExchange');

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
            $this->addJoinObject($join, 'AssetExchange');
        }

        return $this;
    }

    /**
     * Use the AssetExchange relation AssetExchange object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AssetExchangeQuery A secondary query class using the current class as primary query
     */
    public function useAssetExchangeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAssetExchange($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AssetExchange', '\App\AssetExchangeQuery');
    }

    /**
     * Filter the query by a related Trade object
     *
     * @param   Trade|PropelObjectCollection $trade  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AssetQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTrade($trade, $comparison = null)
    {
        if ($trade instanceof Trade) {
            return $this
                ->addUsingAlias(AssetPeer::ID_ASSET, $trade->getIdAsset(), $comparison);
        } elseif ($trade instanceof PropelObjectCollection) {
            return $this
                ->useTradeQuery()
                ->filterByPrimaryKeys($trade->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTrade() only accepts arguments of type Trade or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Trade relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AssetQuery The current query, for fluid interface
     */
    public function joinTrade($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Trade');

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
            $this->addJoinObject($join, 'Trade');
        }

        return $this;
    }

    /**
     * Use the Trade relation Trade object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\TradeQuery A secondary query class using the current class as primary query
     */
    public function useTradeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTrade($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Trade', '\App\TradeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Asset $asset Object to remove from the list of results
     *
     * @return AssetQuery The current query, for fluid interface
     */
    public function prune($asset = null)
    {
        if ($asset) {
            $this->addUsingAlias(AssetPeer::ID_ASSET, $asset->getIdAsset(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // add_tablestamp behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     AssetQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7){
        return $this->addUsingAlias(AssetPeer::DATE_MODIFICATION, time() - $nbDays * 24 * 60 * 60, \Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     AssetQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst(){
        return $this->addDescendingOrderByColumn(AssetPeer::DATE_MODIFICATION);
    }

    /**
     * Order by update date asc
     *
     * @return     AssetQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst(){
        return $this->addAscendingOrderByColumn(AssetPeer::DATE_MODIFICATION);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     AssetQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7){
        return $this->addUsingAlias(AssetPeer::DATE_CREATION, time() - $nbDays * 24 * 60 * 60, \Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     AssetQuery The current query, for fluid interface
     */
    public function lastCreatedFirst(){
        return $this->addDescendingOrderByColumn(AssetPeer::DATE_CREATION);
    }

    /**
     * Order by create date asc
     *
     * @return     AssetQuery The current query, for fluid interface
     */
    public function firstCreatedFirst(){
        return $this->addAscendingOrderByColumn(AssetPeer::DATE_CREATION);
    }
}
