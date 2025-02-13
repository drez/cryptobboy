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
use App\AssetExchangePeer;
use App\AssetExchangeQuery;
use App\Authy;
use App\AuthyGroup;
use App\Exchange;
use App\Token;

/**
 * Base class that represents a query for the 'asset_exchange' table.
 *
 * Wallet
 *
 * @method AssetExchangeQuery orderByIdAssetExchange($order = Criteria::ASC) Order by the id_asset_exchange column
 * @method AssetExchangeQuery orderByIdAsset($order = Criteria::ASC) Order by the id_asset column
 * @method AssetExchangeQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method AssetExchangeQuery orderByIdExchange($order = Criteria::ASC) Order by the id_exchange column
 * @method AssetExchangeQuery orderByIdToken($order = Criteria::ASC) Order by the id_token column
 * @method AssetExchangeQuery orderByFreeToken($order = Criteria::ASC) Order by the free_token column
 * @method AssetExchangeQuery orderByLockedToken($order = Criteria::ASC) Order by the locked_token column
 * @method AssetExchangeQuery orderByFreezeToken($order = Criteria::ASC) Order by the freeze_token column
 * @method AssetExchangeQuery orderByDateCreation($order = Criteria::ASC) Order by the date_creation column
 * @method AssetExchangeQuery orderByDateModification($order = Criteria::ASC) Order by the date_modification column
 * @method AssetExchangeQuery orderByIdGroupCreation($order = Criteria::ASC) Order by the id_group_creation column
 * @method AssetExchangeQuery orderByIdCreation($order = Criteria::ASC) Order by the id_creation column
 * @method AssetExchangeQuery orderByIdModification($order = Criteria::ASC) Order by the id_modification column
 *
 * @method AssetExchangeQuery groupByIdAssetExchange() Group by the id_asset_exchange column
 * @method AssetExchangeQuery groupByIdAsset() Group by the id_asset column
 * @method AssetExchangeQuery groupByType() Group by the type column
 * @method AssetExchangeQuery groupByIdExchange() Group by the id_exchange column
 * @method AssetExchangeQuery groupByIdToken() Group by the id_token column
 * @method AssetExchangeQuery groupByFreeToken() Group by the free_token column
 * @method AssetExchangeQuery groupByLockedToken() Group by the locked_token column
 * @method AssetExchangeQuery groupByFreezeToken() Group by the freeze_token column
 * @method AssetExchangeQuery groupByDateCreation() Group by the date_creation column
 * @method AssetExchangeQuery groupByDateModification() Group by the date_modification column
 * @method AssetExchangeQuery groupByIdGroupCreation() Group by the id_group_creation column
 * @method AssetExchangeQuery groupByIdCreation() Group by the id_creation column
 * @method AssetExchangeQuery groupByIdModification() Group by the id_modification column
 *
 * @method AssetExchangeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AssetExchangeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AssetExchangeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AssetExchangeQuery leftJoinAsset($relationAlias = null) Adds a LEFT JOIN clause to the query using the Asset relation
 * @method AssetExchangeQuery rightJoinAsset($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Asset relation
 * @method AssetExchangeQuery innerJoinAsset($relationAlias = null) Adds a INNER JOIN clause to the query using the Asset relation
 *
 * @method AssetExchangeQuery leftJoinExchange($relationAlias = null) Adds a LEFT JOIN clause to the query using the Exchange relation
 * @method AssetExchangeQuery rightJoinExchange($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Exchange relation
 * @method AssetExchangeQuery innerJoinExchange($relationAlias = null) Adds a INNER JOIN clause to the query using the Exchange relation
 *
 * @method AssetExchangeQuery leftJoinToken($relationAlias = null) Adds a LEFT JOIN clause to the query using the Token relation
 * @method AssetExchangeQuery rightJoinToken($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Token relation
 * @method AssetExchangeQuery innerJoinToken($relationAlias = null) Adds a INNER JOIN clause to the query using the Token relation
 *
 * @method AssetExchangeQuery leftJoinAuthyGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyGroup relation
 * @method AssetExchangeQuery rightJoinAuthyGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyGroup relation
 * @method AssetExchangeQuery innerJoinAuthyGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyGroup relation
 *
 * @method AssetExchangeQuery leftJoinAuthyRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyRelatedByIdCreation relation
 * @method AssetExchangeQuery rightJoinAuthyRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyRelatedByIdCreation relation
 * @method AssetExchangeQuery innerJoinAuthyRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyRelatedByIdCreation relation
 *
 * @method AssetExchangeQuery leftJoinAuthyRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyRelatedByIdModification relation
 * @method AssetExchangeQuery rightJoinAuthyRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyRelatedByIdModification relation
 * @method AssetExchangeQuery innerJoinAuthyRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyRelatedByIdModification relation
 *
 * @method AssetExchange findOne(PropelPDO $con = null) Return the first AssetExchange matching the query
 * @method AssetExchange findOneOrCreate(PropelPDO $con = null) Return the first AssetExchange matching the query, or a new AssetExchange object populated from the query conditions when no match is found
 *
 * @method AssetExchange findOneByIdAsset(int $id_asset) Return the first AssetExchange filtered by the id_asset column
 * @method AssetExchange findOneByType(int $type) Return the first AssetExchange filtered by the type column
 * @method AssetExchange findOneByIdExchange(int $id_exchange) Return the first AssetExchange filtered by the id_exchange column
 * @method AssetExchange findOneByIdToken(int $id_token) Return the first AssetExchange filtered by the id_token column
 * @method AssetExchange findOneByFreeToken(string $free_token) Return the first AssetExchange filtered by the free_token column
 * @method AssetExchange findOneByLockedToken(string $locked_token) Return the first AssetExchange filtered by the locked_token column
 * @method AssetExchange findOneByFreezeToken(string $freeze_token) Return the first AssetExchange filtered by the freeze_token column
 * @method AssetExchange findOneByDateCreation(string $date_creation) Return the first AssetExchange filtered by the date_creation column
 * @method AssetExchange findOneByDateModification(string $date_modification) Return the first AssetExchange filtered by the date_modification column
 * @method AssetExchange findOneByIdGroupCreation(int $id_group_creation) Return the first AssetExchange filtered by the id_group_creation column
 * @method AssetExchange findOneByIdCreation(int $id_creation) Return the first AssetExchange filtered by the id_creation column
 * @method AssetExchange findOneByIdModification(int $id_modification) Return the first AssetExchange filtered by the id_modification column
 *
 * @method array findByIdAssetExchange(int $id_asset_exchange) Return AssetExchange objects filtered by the id_asset_exchange column
 * @method array findByIdAsset(int $id_asset) Return AssetExchange objects filtered by the id_asset column
 * @method array findByType(int $type) Return AssetExchange objects filtered by the type column
 * @method array findByIdExchange(int $id_exchange) Return AssetExchange objects filtered by the id_exchange column
 * @method array findByIdToken(int $id_token) Return AssetExchange objects filtered by the id_token column
 * @method array findByFreeToken(string $free_token) Return AssetExchange objects filtered by the free_token column
 * @method array findByLockedToken(string $locked_token) Return AssetExchange objects filtered by the locked_token column
 * @method array findByFreezeToken(string $freeze_token) Return AssetExchange objects filtered by the freeze_token column
 * @method array findByDateCreation(string $date_creation) Return AssetExchange objects filtered by the date_creation column
 * @method array findByDateModification(string $date_modification) Return AssetExchange objects filtered by the date_modification column
 * @method array findByIdGroupCreation(int $id_group_creation) Return AssetExchange objects filtered by the id_group_creation column
 * @method array findByIdCreation(int $id_creation) Return AssetExchange objects filtered by the id_creation column
 * @method array findByIdModification(int $id_modification) Return AssetExchange objects filtered by the id_modification column
 *
 * @package    propel.generator..om
 */
abstract class BaseAssetExchangeQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAssetExchangeQuery object.
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
            $modelName = 'App\\AssetExchange';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AssetExchangeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AssetExchangeQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AssetExchangeQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AssetExchangeQuery) {
            return $criteria;
        }
        $query = new AssetExchangeQuery(null, null, $modelAlias);

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
     * @return   AssetExchange|AssetExchange[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AssetExchangePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 AssetExchange A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByIdAssetExchange($key, $con = null)
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
     * @return                 AssetExchange A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id_asset_exchange`, `id_asset`, `type`, `id_exchange`, `id_token`, `free_token`, `locked_token`, `freeze_token`, `date_creation`, `date_modification`, `id_group_creation`, `id_creation`, `id_modification` FROM `asset_exchange` WHERE `id_asset_exchange` = :p0';
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
            $obj = new AssetExchange();
            $obj->hydrate($row);
            AssetExchangePeer::addInstanceToPool($obj, (string) $key);
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
     * @return AssetExchange|AssetExchange[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|AssetExchange[]|mixed the list of results, formatted by the current formatter
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
     * @return AssetExchangeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AssetExchangePeer::ID_ASSET_EXCHANGE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AssetExchangeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AssetExchangePeer::ID_ASSET_EXCHANGE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_asset_exchange column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAssetExchange(1234); // WHERE id_asset_exchange = 1234
     * $query->filterByIdAssetExchange(array(12, 34)); // WHERE id_asset_exchange IN (12, 34)
     * $query->filterByIdAssetExchange(array('min' => 12)); // WHERE id_asset_exchange >= 12
     * $query->filterByIdAssetExchange(array('max' => 12)); // WHERE id_asset_exchange <= 12
     * </code>
     *
     * @param     mixed $idAssetExchange The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssetExchangeQuery The current query, for fluid interface
     */
    public function filterByIdAssetExchange($idAssetExchange = null, $comparison = null)
    {
        if (is_array($idAssetExchange)) {
            $useMinMax = false;
            if (isset($idAssetExchange['min'])) {
                $this->addUsingAlias(AssetExchangePeer::ID_ASSET_EXCHANGE, $idAssetExchange['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAssetExchange['max'])) {
                $this->addUsingAlias(AssetExchangePeer::ID_ASSET_EXCHANGE, $idAssetExchange['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetExchangePeer::ID_ASSET_EXCHANGE, $idAssetExchange, $comparison);
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
     * @return AssetExchangeQuery The current query, for fluid interface
     */
    public function filterByIdAsset($idAsset = null, $comparison = null)
    {
        if (is_array($idAsset)) {
            $useMinMax = false;
            if (isset($idAsset['min'])) {
                $this->addUsingAlias(AssetExchangePeer::ID_ASSET, $idAsset['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAsset['max'])) {
                $this->addUsingAlias(AssetExchangePeer::ID_ASSET, $idAsset['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetExchangePeer::ID_ASSET, $idAsset, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * @param     mixed $type The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssetExchangeQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (is_scalar($type)) {
            $type = AssetExchangePeer::getSqlValueForEnum(AssetExchangePeer::TYPE, $type);
        } elseif (is_array($type)) {
            $convertedValues = array();
            foreach ($type as $value) {
                $convertedValues[] = AssetExchangePeer::getSqlValueForEnum(AssetExchangePeer::TYPE, $value);
            }
            $type = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetExchangePeer::TYPE, $type, $comparison);
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
     * @return AssetExchangeQuery The current query, for fluid interface
     */
    public function filterByIdExchange($idExchange = null, $comparison = null)
    {
        if (is_array($idExchange)) {
            $useMinMax = false;
            if (isset($idExchange['min'])) {
                $this->addUsingAlias(AssetExchangePeer::ID_EXCHANGE, $idExchange['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idExchange['max'])) {
                $this->addUsingAlias(AssetExchangePeer::ID_EXCHANGE, $idExchange['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetExchangePeer::ID_EXCHANGE, $idExchange, $comparison);
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
     * @return AssetExchangeQuery The current query, for fluid interface
     */
    public function filterByIdToken($idToken = null, $comparison = null)
    {
        if (is_array($idToken)) {
            $useMinMax = false;
            if (isset($idToken['min'])) {
                $this->addUsingAlias(AssetExchangePeer::ID_TOKEN, $idToken['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idToken['max'])) {
                $this->addUsingAlias(AssetExchangePeer::ID_TOKEN, $idToken['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetExchangePeer::ID_TOKEN, $idToken, $comparison);
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
     * @return AssetExchangeQuery The current query, for fluid interface
     */
    public function filterByFreeToken($freeToken = null, $comparison = null)
    {
        if (is_array($freeToken)) {
            $useMinMax = false;
            if (isset($freeToken['min'])) {
                $this->addUsingAlias(AssetExchangePeer::FREE_TOKEN, $freeToken['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($freeToken['max'])) {
                $this->addUsingAlias(AssetExchangePeer::FREE_TOKEN, $freeToken['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetExchangePeer::FREE_TOKEN, $freeToken, $comparison);
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
     * @return AssetExchangeQuery The current query, for fluid interface
     */
    public function filterByLockedToken($lockedToken = null, $comparison = null)
    {
        if (is_array($lockedToken)) {
            $useMinMax = false;
            if (isset($lockedToken['min'])) {
                $this->addUsingAlias(AssetExchangePeer::LOCKED_TOKEN, $lockedToken['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lockedToken['max'])) {
                $this->addUsingAlias(AssetExchangePeer::LOCKED_TOKEN, $lockedToken['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetExchangePeer::LOCKED_TOKEN, $lockedToken, $comparison);
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
     * @return AssetExchangeQuery The current query, for fluid interface
     */
    public function filterByFreezeToken($freezeToken = null, $comparison = null)
    {
        if (is_array($freezeToken)) {
            $useMinMax = false;
            if (isset($freezeToken['min'])) {
                $this->addUsingAlias(AssetExchangePeer::FREEZE_TOKEN, $freezeToken['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($freezeToken['max'])) {
                $this->addUsingAlias(AssetExchangePeer::FREEZE_TOKEN, $freezeToken['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetExchangePeer::FREEZE_TOKEN, $freezeToken, $comparison);
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
     * @return AssetExchangeQuery The current query, for fluid interface
     */
    public function filterByDateCreation($dateCreation = null, $comparison = null)
    {
        if (is_array($dateCreation)) {
            $useMinMax = false;
            if (isset($dateCreation['min'])) {
                $this->addUsingAlias(AssetExchangePeer::DATE_CREATION, $dateCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreation['max'])) {
                $this->addUsingAlias(AssetExchangePeer::DATE_CREATION, $dateCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetExchangePeer::DATE_CREATION, $dateCreation, $comparison);
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
     * @return AssetExchangeQuery The current query, for fluid interface
     */
    public function filterByDateModification($dateModification = null, $comparison = null)
    {
        if (is_array($dateModification)) {
            $useMinMax = false;
            if (isset($dateModification['min'])) {
                $this->addUsingAlias(AssetExchangePeer::DATE_MODIFICATION, $dateModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateModification['max'])) {
                $this->addUsingAlias(AssetExchangePeer::DATE_MODIFICATION, $dateModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetExchangePeer::DATE_MODIFICATION, $dateModification, $comparison);
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
     * @return AssetExchangeQuery The current query, for fluid interface
     */
    public function filterByIdGroupCreation($idGroupCreation = null, $comparison = null)
    {
        if (is_array($idGroupCreation)) {
            $useMinMax = false;
            if (isset($idGroupCreation['min'])) {
                $this->addUsingAlias(AssetExchangePeer::ID_GROUP_CREATION, $idGroupCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idGroupCreation['max'])) {
                $this->addUsingAlias(AssetExchangePeer::ID_GROUP_CREATION, $idGroupCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetExchangePeer::ID_GROUP_CREATION, $idGroupCreation, $comparison);
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
     * @return AssetExchangeQuery The current query, for fluid interface
     */
    public function filterByIdCreation($idCreation = null, $comparison = null)
    {
        if (is_array($idCreation)) {
            $useMinMax = false;
            if (isset($idCreation['min'])) {
                $this->addUsingAlias(AssetExchangePeer::ID_CREATION, $idCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCreation['max'])) {
                $this->addUsingAlias(AssetExchangePeer::ID_CREATION, $idCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetExchangePeer::ID_CREATION, $idCreation, $comparison);
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
     * @return AssetExchangeQuery The current query, for fluid interface
     */
    public function filterByIdModification($idModification = null, $comparison = null)
    {
        if (is_array($idModification)) {
            $useMinMax = false;
            if (isset($idModification['min'])) {
                $this->addUsingAlias(AssetExchangePeer::ID_MODIFICATION, $idModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idModification['max'])) {
                $this->addUsingAlias(AssetExchangePeer::ID_MODIFICATION, $idModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssetExchangePeer::ID_MODIFICATION, $idModification, $comparison);
    }

    /**
     * Filter the query by a related Asset object
     *
     * @param   Asset|PropelObjectCollection $asset The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AssetExchangeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAsset($asset, $comparison = null)
    {
        if ($asset instanceof Asset) {
            return $this
                ->addUsingAlias(AssetExchangePeer::ID_ASSET, $asset->getIdAsset(), $comparison);
        } elseif ($asset instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssetExchangePeer::ID_ASSET, $asset->toKeyValue('PrimaryKey', 'IdAsset'), $comparison);
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
     * @return AssetExchangeQuery The current query, for fluid interface
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
     * Filter the query by a related Exchange object
     *
     * @param   Exchange|PropelObjectCollection $exchange The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AssetExchangeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByExchange($exchange, $comparison = null)
    {
        if ($exchange instanceof Exchange) {
            return $this
                ->addUsingAlias(AssetExchangePeer::ID_EXCHANGE, $exchange->getIdExchange(), $comparison);
        } elseif ($exchange instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssetExchangePeer::ID_EXCHANGE, $exchange->toKeyValue('PrimaryKey', 'IdExchange'), $comparison);
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
     * @return AssetExchangeQuery The current query, for fluid interface
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
     * Filter the query by a related Token object
     *
     * @param   Token|PropelObjectCollection $token The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AssetExchangeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByToken($token, $comparison = null)
    {
        if ($token instanceof Token) {
            return $this
                ->addUsingAlias(AssetExchangePeer::ID_TOKEN, $token->getIdToken(), $comparison);
        } elseif ($token instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssetExchangePeer::ID_TOKEN, $token->toKeyValue('PrimaryKey', 'IdToken'), $comparison);
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
     * @return AssetExchangeQuery The current query, for fluid interface
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
     * Filter the query by a related AuthyGroup object
     *
     * @param   AuthyGroup|PropelObjectCollection $authyGroup The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AssetExchangeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyGroup($authyGroup, $comparison = null)
    {
        if ($authyGroup instanceof AuthyGroup) {
            return $this
                ->addUsingAlias(AssetExchangePeer::ID_GROUP_CREATION, $authyGroup->getIdAuthyGroup(), $comparison);
        } elseif ($authyGroup instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssetExchangePeer::ID_GROUP_CREATION, $authyGroup->toKeyValue('PrimaryKey', 'IdAuthyGroup'), $comparison);
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
     * @return AssetExchangeQuery The current query, for fluid interface
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
     * @return                 AssetExchangeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyRelatedByIdCreation($authy, $comparison = null)
    {
        if ($authy instanceof Authy) {
            return $this
                ->addUsingAlias(AssetExchangePeer::ID_CREATION, $authy->getIdAuthy(), $comparison);
        } elseif ($authy instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssetExchangePeer::ID_CREATION, $authy->toKeyValue('PrimaryKey', 'IdAuthy'), $comparison);
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
     * @return AssetExchangeQuery The current query, for fluid interface
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
     * @return                 AssetExchangeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyRelatedByIdModification($authy, $comparison = null)
    {
        if ($authy instanceof Authy) {
            return $this
                ->addUsingAlias(AssetExchangePeer::ID_MODIFICATION, $authy->getIdAuthy(), $comparison);
        } elseif ($authy instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssetExchangePeer::ID_MODIFICATION, $authy->toKeyValue('PrimaryKey', 'IdAuthy'), $comparison);
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
     * @return AssetExchangeQuery The current query, for fluid interface
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
     * @param   AssetExchange $assetExchange Object to remove from the list of results
     *
     * @return AssetExchangeQuery The current query, for fluid interface
     */
    public function prune($assetExchange = null)
    {
        if ($assetExchange) {
            $this->addUsingAlias(AssetExchangePeer::ID_ASSET_EXCHANGE, $assetExchange->getIdAssetExchange(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // add_tablestamp behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     AssetExchangeQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7){
        return $this->addUsingAlias(AssetExchangePeer::DATE_MODIFICATION, time() - $nbDays * 24 * 60 * 60, \Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     AssetExchangeQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst(){
        return $this->addDescendingOrderByColumn(AssetExchangePeer::DATE_MODIFICATION);
    }

    /**
     * Order by update date asc
     *
     * @return     AssetExchangeQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst(){
        return $this->addAscendingOrderByColumn(AssetExchangePeer::DATE_MODIFICATION);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     AssetExchangeQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7){
        return $this->addUsingAlias(AssetExchangePeer::DATE_CREATION, time() - $nbDays * 24 * 60 * 60, \Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     AssetExchangeQuery The current query, for fluid interface
     */
    public function lastCreatedFirst(){
        return $this->addDescendingOrderByColumn(AssetExchangePeer::DATE_CREATION);
    }

    /**
     * Order by create date asc
     *
     * @return     AssetExchangeQuery The current query, for fluid interface
     */
    public function firstCreatedFirst(){
        return $this->addAscendingOrderByColumn(AssetExchangePeer::DATE_CREATION);
    }
}
