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
use App\ApiRbac;
use App\Asset;
use App\AssetExchange;
use App\Authy;
use App\AuthyGroup;
use App\AuthyGroupPeer;
use App\AuthyGroupQuery;
use App\AuthyGroupX;
use App\Config;
use App\Country;
use App\Exchange;
use App\MessageI18n;
use App\Symbol;
use App\Template;
use App\TemplateFile;
use App\Token;
use App\Trade;

/**
 * Base class that represents a query for the 'authy_group' table.
 *
 * Group
 *
 * @method AuthyGroupQuery orderByIdAuthyGroup($order = Criteria::ASC) Order by the id_authy_group column
 * @method AuthyGroupQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method AuthyGroupQuery orderByDesc($order = Criteria::ASC) Order by the desc column
 * @method AuthyGroupQuery orderByDefaultGroup($order = Criteria::ASC) Order by the default_group column
 * @method AuthyGroupQuery orderByAdmin($order = Criteria::ASC) Order by the admin column
 * @method AuthyGroupQuery orderByRightsAll($order = Criteria::ASC) Order by the rights_all column
 * @method AuthyGroupQuery orderByRightsOwner($order = Criteria::ASC) Order by the rights_owner column
 * @method AuthyGroupQuery orderByRightsGroup($order = Criteria::ASC) Order by the rights_group column
 * @method AuthyGroupQuery orderByDateCreation($order = Criteria::ASC) Order by the date_creation column
 * @method AuthyGroupQuery orderByDateModification($order = Criteria::ASC) Order by the date_modification column
 * @method AuthyGroupQuery orderByIdGroupCreation($order = Criteria::ASC) Order by the id_group_creation column
 * @method AuthyGroupQuery orderByIdCreation($order = Criteria::ASC) Order by the id_creation column
 * @method AuthyGroupQuery orderByIdModification($order = Criteria::ASC) Order by the id_modification column
 *
 * @method AuthyGroupQuery groupByIdAuthyGroup() Group by the id_authy_group column
 * @method AuthyGroupQuery groupByName() Group by the name column
 * @method AuthyGroupQuery groupByDesc() Group by the desc column
 * @method AuthyGroupQuery groupByDefaultGroup() Group by the default_group column
 * @method AuthyGroupQuery groupByAdmin() Group by the admin column
 * @method AuthyGroupQuery groupByRightsAll() Group by the rights_all column
 * @method AuthyGroupQuery groupByRightsOwner() Group by the rights_owner column
 * @method AuthyGroupQuery groupByRightsGroup() Group by the rights_group column
 * @method AuthyGroupQuery groupByDateCreation() Group by the date_creation column
 * @method AuthyGroupQuery groupByDateModification() Group by the date_modification column
 * @method AuthyGroupQuery groupByIdGroupCreation() Group by the id_group_creation column
 * @method AuthyGroupQuery groupByIdCreation() Group by the id_creation column
 * @method AuthyGroupQuery groupByIdModification() Group by the id_modification column
 *
 * @method AuthyGroupQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AuthyGroupQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AuthyGroupQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AuthyGroupQuery leftJoinAuthyGroupRelatedByIdGroupCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyGroupRelatedByIdGroupCreation relation
 * @method AuthyGroupQuery rightJoinAuthyGroupRelatedByIdGroupCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyGroupRelatedByIdGroupCreation relation
 * @method AuthyGroupQuery innerJoinAuthyGroupRelatedByIdGroupCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyGroupRelatedByIdGroupCreation relation
 *
 * @method AuthyGroupQuery leftJoinAuthyRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyRelatedByIdCreation relation
 * @method AuthyGroupQuery rightJoinAuthyRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyRelatedByIdCreation relation
 * @method AuthyGroupQuery innerJoinAuthyRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyRelatedByIdCreation relation
 *
 * @method AuthyGroupQuery leftJoinAuthyRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyRelatedByIdModification relation
 * @method AuthyGroupQuery rightJoinAuthyRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyRelatedByIdModification relation
 * @method AuthyGroupQuery innerJoinAuthyRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyRelatedByIdModification relation
 *
 * @method AuthyGroupQuery leftJoinAuthyGroupX($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyGroupX relation
 * @method AuthyGroupQuery rightJoinAuthyGroupX($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyGroupX relation
 * @method AuthyGroupQuery innerJoinAuthyGroupX($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyGroupX relation
 *
 * @method AuthyGroupQuery leftJoinAuthyRelatedByIdAuthyGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyRelatedByIdAuthyGroup relation
 * @method AuthyGroupQuery rightJoinAuthyRelatedByIdAuthyGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyRelatedByIdAuthyGroup relation
 * @method AuthyGroupQuery innerJoinAuthyRelatedByIdAuthyGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyRelatedByIdAuthyGroup relation
 *
 * @method AuthyGroupQuery leftJoinAuthyRelatedByIdGroupCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyRelatedByIdGroupCreation relation
 * @method AuthyGroupQuery rightJoinAuthyRelatedByIdGroupCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyRelatedByIdGroupCreation relation
 * @method AuthyGroupQuery innerJoinAuthyRelatedByIdGroupCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyRelatedByIdGroupCreation relation
 *
 * @method AuthyGroupQuery leftJoinCountry($relationAlias = null) Adds a LEFT JOIN clause to the query using the Country relation
 * @method AuthyGroupQuery rightJoinCountry($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Country relation
 * @method AuthyGroupQuery innerJoinCountry($relationAlias = null) Adds a INNER JOIN clause to the query using the Country relation
 *
 * @method AuthyGroupQuery leftJoinAsset($relationAlias = null) Adds a LEFT JOIN clause to the query using the Asset relation
 * @method AuthyGroupQuery rightJoinAsset($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Asset relation
 * @method AuthyGroupQuery innerJoinAsset($relationAlias = null) Adds a INNER JOIN clause to the query using the Asset relation
 *
 * @method AuthyGroupQuery leftJoinAssetExchange($relationAlias = null) Adds a LEFT JOIN clause to the query using the AssetExchange relation
 * @method AuthyGroupQuery rightJoinAssetExchange($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AssetExchange relation
 * @method AuthyGroupQuery innerJoinAssetExchange($relationAlias = null) Adds a INNER JOIN clause to the query using the AssetExchange relation
 *
 * @method AuthyGroupQuery leftJoinTrade($relationAlias = null) Adds a LEFT JOIN clause to the query using the Trade relation
 * @method AuthyGroupQuery rightJoinTrade($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Trade relation
 * @method AuthyGroupQuery innerJoinTrade($relationAlias = null) Adds a INNER JOIN clause to the query using the Trade relation
 *
 * @method AuthyGroupQuery leftJoinExchange($relationAlias = null) Adds a LEFT JOIN clause to the query using the Exchange relation
 * @method AuthyGroupQuery rightJoinExchange($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Exchange relation
 * @method AuthyGroupQuery innerJoinExchange($relationAlias = null) Adds a INNER JOIN clause to the query using the Exchange relation
 *
 * @method AuthyGroupQuery leftJoinToken($relationAlias = null) Adds a LEFT JOIN clause to the query using the Token relation
 * @method AuthyGroupQuery rightJoinToken($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Token relation
 * @method AuthyGroupQuery innerJoinToken($relationAlias = null) Adds a INNER JOIN clause to the query using the Token relation
 *
 * @method AuthyGroupQuery leftJoinSymbol($relationAlias = null) Adds a LEFT JOIN clause to the query using the Symbol relation
 * @method AuthyGroupQuery rightJoinSymbol($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Symbol relation
 * @method AuthyGroupQuery innerJoinSymbol($relationAlias = null) Adds a INNER JOIN clause to the query using the Symbol relation
 *
 * @method AuthyGroupQuery leftJoinAuthyGroupRelatedByIdAuthyGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyGroupRelatedByIdAuthyGroup relation
 * @method AuthyGroupQuery rightJoinAuthyGroupRelatedByIdAuthyGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyGroupRelatedByIdAuthyGroup relation
 * @method AuthyGroupQuery innerJoinAuthyGroupRelatedByIdAuthyGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyGroupRelatedByIdAuthyGroup relation
 *
 * @method AuthyGroupQuery leftJoinConfig($relationAlias = null) Adds a LEFT JOIN clause to the query using the Config relation
 * @method AuthyGroupQuery rightJoinConfig($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Config relation
 * @method AuthyGroupQuery innerJoinConfig($relationAlias = null) Adds a INNER JOIN clause to the query using the Config relation
 *
 * @method AuthyGroupQuery leftJoinApiRbac($relationAlias = null) Adds a LEFT JOIN clause to the query using the ApiRbac relation
 * @method AuthyGroupQuery rightJoinApiRbac($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ApiRbac relation
 * @method AuthyGroupQuery innerJoinApiRbac($relationAlias = null) Adds a INNER JOIN clause to the query using the ApiRbac relation
 *
 * @method AuthyGroupQuery leftJoinTemplate($relationAlias = null) Adds a LEFT JOIN clause to the query using the Template relation
 * @method AuthyGroupQuery rightJoinTemplate($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Template relation
 * @method AuthyGroupQuery innerJoinTemplate($relationAlias = null) Adds a INNER JOIN clause to the query using the Template relation
 *
 * @method AuthyGroupQuery leftJoinTemplateFile($relationAlias = null) Adds a LEFT JOIN clause to the query using the TemplateFile relation
 * @method AuthyGroupQuery rightJoinTemplateFile($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TemplateFile relation
 * @method AuthyGroupQuery innerJoinTemplateFile($relationAlias = null) Adds a INNER JOIN clause to the query using the TemplateFile relation
 *
 * @method AuthyGroupQuery leftJoinMessageI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the MessageI18n relation
 * @method AuthyGroupQuery rightJoinMessageI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MessageI18n relation
 * @method AuthyGroupQuery innerJoinMessageI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the MessageI18n relation
 *
 * @method AuthyGroup findOne(PropelPDO $con = null) Return the first AuthyGroup matching the query
 * @method AuthyGroup findOneOrCreate(PropelPDO $con = null) Return the first AuthyGroup matching the query, or a new AuthyGroup object populated from the query conditions when no match is found
 *
 * @method AuthyGroup findOneByName(string $name) Return the first AuthyGroup filtered by the name column
 * @method AuthyGroup findOneByDesc(string $desc) Return the first AuthyGroup filtered by the desc column
 * @method AuthyGroup findOneByDefaultGroup(int $default_group) Return the first AuthyGroup filtered by the default_group column
 * @method AuthyGroup findOneByAdmin(int $admin) Return the first AuthyGroup filtered by the admin column
 * @method AuthyGroup findOneByRightsAll(string $rights_all) Return the first AuthyGroup filtered by the rights_all column
 * @method AuthyGroup findOneByRightsOwner(string $rights_owner) Return the first AuthyGroup filtered by the rights_owner column
 * @method AuthyGroup findOneByRightsGroup(string $rights_group) Return the first AuthyGroup filtered by the rights_group column
 * @method AuthyGroup findOneByDateCreation(string $date_creation) Return the first AuthyGroup filtered by the date_creation column
 * @method AuthyGroup findOneByDateModification(string $date_modification) Return the first AuthyGroup filtered by the date_modification column
 * @method AuthyGroup findOneByIdGroupCreation(int $id_group_creation) Return the first AuthyGroup filtered by the id_group_creation column
 * @method AuthyGroup findOneByIdCreation(int $id_creation) Return the first AuthyGroup filtered by the id_creation column
 * @method AuthyGroup findOneByIdModification(int $id_modification) Return the first AuthyGroup filtered by the id_modification column
 *
 * @method array findByIdAuthyGroup(int $id_authy_group) Return AuthyGroup objects filtered by the id_authy_group column
 * @method array findByName(string $name) Return AuthyGroup objects filtered by the name column
 * @method array findByDesc(string $desc) Return AuthyGroup objects filtered by the desc column
 * @method array findByDefaultGroup(int $default_group) Return AuthyGroup objects filtered by the default_group column
 * @method array findByAdmin(int $admin) Return AuthyGroup objects filtered by the admin column
 * @method array findByRightsAll(string $rights_all) Return AuthyGroup objects filtered by the rights_all column
 * @method array findByRightsOwner(string $rights_owner) Return AuthyGroup objects filtered by the rights_owner column
 * @method array findByRightsGroup(string $rights_group) Return AuthyGroup objects filtered by the rights_group column
 * @method array findByDateCreation(string $date_creation) Return AuthyGroup objects filtered by the date_creation column
 * @method array findByDateModification(string $date_modification) Return AuthyGroup objects filtered by the date_modification column
 * @method array findByIdGroupCreation(int $id_group_creation) Return AuthyGroup objects filtered by the id_group_creation column
 * @method array findByIdCreation(int $id_creation) Return AuthyGroup objects filtered by the id_creation column
 * @method array findByIdModification(int $id_modification) Return AuthyGroup objects filtered by the id_modification column
 *
 * @package    propel.generator..om
 */
abstract class BaseAuthyGroupQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAuthyGroupQuery object.
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
            $modelName = 'App\\AuthyGroup';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AuthyGroupQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AuthyGroupQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AuthyGroupQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AuthyGroupQuery) {
            return $criteria;
        }
        $query = new AuthyGroupQuery(null, null, $modelAlias);

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
     * @return   AuthyGroup|AuthyGroup[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AuthyGroupPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AuthyGroupPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 AuthyGroup A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByIdAuthyGroup($key, $con = null)
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
     * @return                 AuthyGroup A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id_authy_group`, `name`, `desc`, `default_group`, `admin`, `rights_all`, `rights_owner`, `rights_group`, `date_creation`, `date_modification`, `id_group_creation`, `id_creation`, `id_modification` FROM `authy_group` WHERE `id_authy_group` = :p0';
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
            $obj = new AuthyGroup();
            $obj->hydrate($row);
            AuthyGroupPeer::addInstanceToPool($obj, (string) $key);
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
     * @return AuthyGroup|AuthyGroup[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|AuthyGroup[]|mixed the list of results, formatted by the current formatter
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
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_authy_group column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAuthyGroup(1234); // WHERE id_authy_group = 1234
     * $query->filterByIdAuthyGroup(array(12, 34)); // WHERE id_authy_group IN (12, 34)
     * $query->filterByIdAuthyGroup(array('min' => 12)); // WHERE id_authy_group >= 12
     * $query->filterByIdAuthyGroup(array('max' => 12)); // WHERE id_authy_group <= 12
     * </code>
     *
     * @param     mixed $idAuthyGroup The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function filterByIdAuthyGroup($idAuthyGroup = null, $comparison = null)
    {
        if (is_array($idAuthyGroup)) {
            $useMinMax = false;
            if (isset($idAuthyGroup['min'])) {
                $this->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $idAuthyGroup['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAuthyGroup['max'])) {
                $this->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $idAuthyGroup['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $idAuthyGroup, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyGroupPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the desc column
     *
     * Example usage:
     * <code>
     * $query->filterByDesc('fooValue');   // WHERE desc = 'fooValue'
     * $query->filterByDesc('%fooValue%'); // WHERE desc LIKE '%fooValue%'
     * </code>
     *
     * @param     string $desc The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function filterByDesc($desc = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($desc)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $desc)) {
                $desc = str_replace('*', '%', $desc);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyGroupPeer::DESC, $desc, $comparison);
    }

    /**
     * Filter the query on the default_group column
     *
     * @param     mixed $defaultGroup The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByDefaultGroup($defaultGroup = null, $comparison = null)
    {
        if (is_scalar($defaultGroup)) {
            $defaultGroup = AuthyGroupPeer::getSqlValueForEnum(AuthyGroupPeer::DEFAULT_GROUP, $defaultGroup);
        } elseif (is_array($defaultGroup)) {
            $convertedValues = array();
            foreach ($defaultGroup as $value) {
                $convertedValues[] = AuthyGroupPeer::getSqlValueForEnum(AuthyGroupPeer::DEFAULT_GROUP, $value);
            }
            $defaultGroup = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyGroupPeer::DEFAULT_GROUP, $defaultGroup, $comparison);
    }

    /**
     * Filter the query on the admin column
     *
     * @param     mixed $admin The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByAdmin($admin = null, $comparison = null)
    {
        if (is_scalar($admin)) {
            $admin = AuthyGroupPeer::getSqlValueForEnum(AuthyGroupPeer::ADMIN, $admin);
        } elseif (is_array($admin)) {
            $convertedValues = array();
            foreach ($admin as $value) {
                $convertedValues[] = AuthyGroupPeer::getSqlValueForEnum(AuthyGroupPeer::ADMIN, $value);
            }
            $admin = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyGroupPeer::ADMIN, $admin, $comparison);
    }

    /**
     * Filter the query on the rights_all column
     *
     * Example usage:
     * <code>
     * $query->filterByRightsAll('fooValue');   // WHERE rights_all = 'fooValue'
     * $query->filterByRightsAll('%fooValue%'); // WHERE rights_all LIKE '%fooValue%'
     * </code>
     *
     * @param     string $rightsAll The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function filterByRightsAll($rightsAll = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($rightsAll)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $rightsAll)) {
                $rightsAll = str_replace('*', '%', $rightsAll);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyGroupPeer::RIGHTS_ALL, $rightsAll, $comparison);
    }

    /**
     * Filter the query on the rights_owner column
     *
     * Example usage:
     * <code>
     * $query->filterByRightsOwner('fooValue');   // WHERE rights_owner = 'fooValue'
     * $query->filterByRightsOwner('%fooValue%'); // WHERE rights_owner LIKE '%fooValue%'
     * </code>
     *
     * @param     string $rightsOwner The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function filterByRightsOwner($rightsOwner = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($rightsOwner)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $rightsOwner)) {
                $rightsOwner = str_replace('*', '%', $rightsOwner);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyGroupPeer::RIGHTS_OWNER, $rightsOwner, $comparison);
    }

    /**
     * Filter the query on the rights_group column
     *
     * Example usage:
     * <code>
     * $query->filterByRightsGroup('fooValue');   // WHERE rights_group = 'fooValue'
     * $query->filterByRightsGroup('%fooValue%'); // WHERE rights_group LIKE '%fooValue%'
     * </code>
     *
     * @param     string $rightsGroup The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function filterByRightsGroup($rightsGroup = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($rightsGroup)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $rightsGroup)) {
                $rightsGroup = str_replace('*', '%', $rightsGroup);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyGroupPeer::RIGHTS_GROUP, $rightsGroup, $comparison);
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
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function filterByDateCreation($dateCreation = null, $comparison = null)
    {
        if (is_array($dateCreation)) {
            $useMinMax = false;
            if (isset($dateCreation['min'])) {
                $this->addUsingAlias(AuthyGroupPeer::DATE_CREATION, $dateCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreation['max'])) {
                $this->addUsingAlias(AuthyGroupPeer::DATE_CREATION, $dateCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyGroupPeer::DATE_CREATION, $dateCreation, $comparison);
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
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function filterByDateModification($dateModification = null, $comparison = null)
    {
        if (is_array($dateModification)) {
            $useMinMax = false;
            if (isset($dateModification['min'])) {
                $this->addUsingAlias(AuthyGroupPeer::DATE_MODIFICATION, $dateModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateModification['max'])) {
                $this->addUsingAlias(AuthyGroupPeer::DATE_MODIFICATION, $dateModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyGroupPeer::DATE_MODIFICATION, $dateModification, $comparison);
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
     * @see       filterByAuthyGroupRelatedByIdGroupCreation()
     *
     * @param     mixed $idGroupCreation The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function filterByIdGroupCreation($idGroupCreation = null, $comparison = null)
    {
        if (is_array($idGroupCreation)) {
            $useMinMax = false;
            if (isset($idGroupCreation['min'])) {
                $this->addUsingAlias(AuthyGroupPeer::ID_GROUP_CREATION, $idGroupCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idGroupCreation['max'])) {
                $this->addUsingAlias(AuthyGroupPeer::ID_GROUP_CREATION, $idGroupCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyGroupPeer::ID_GROUP_CREATION, $idGroupCreation, $comparison);
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
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function filterByIdCreation($idCreation = null, $comparison = null)
    {
        if (is_array($idCreation)) {
            $useMinMax = false;
            if (isset($idCreation['min'])) {
                $this->addUsingAlias(AuthyGroupPeer::ID_CREATION, $idCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCreation['max'])) {
                $this->addUsingAlias(AuthyGroupPeer::ID_CREATION, $idCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyGroupPeer::ID_CREATION, $idCreation, $comparison);
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
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function filterByIdModification($idModification = null, $comparison = null)
    {
        if (is_array($idModification)) {
            $useMinMax = false;
            if (isset($idModification['min'])) {
                $this->addUsingAlias(AuthyGroupPeer::ID_MODIFICATION, $idModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idModification['max'])) {
                $this->addUsingAlias(AuthyGroupPeer::ID_MODIFICATION, $idModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyGroupPeer::ID_MODIFICATION, $idModification, $comparison);
    }

    /**
     * Filter the query by a related AuthyGroup object
     *
     * @param   AuthyGroup|PropelObjectCollection $authyGroup The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyGroupRelatedByIdGroupCreation($authyGroup, $comparison = null)
    {
        if ($authyGroup instanceof AuthyGroup) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_GROUP_CREATION, $authyGroup->getIdAuthyGroup(), $comparison);
        } elseif ($authyGroup instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_GROUP_CREATION, $authyGroup->toKeyValue('PrimaryKey', 'IdAuthyGroup'), $comparison);
        } else {
            throw new PropelException('filterByAuthyGroupRelatedByIdGroupCreation() only accepts arguments of type AuthyGroup or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuthyGroupRelatedByIdGroupCreation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function joinAuthyGroupRelatedByIdGroupCreation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuthyGroupRelatedByIdGroupCreation');

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
            $this->addJoinObject($join, 'AuthyGroupRelatedByIdGroupCreation');
        }

        return $this;
    }

    /**
     * Use the AuthyGroupRelatedByIdGroupCreation relation AuthyGroup object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AuthyGroupQuery A secondary query class using the current class as primary query
     */
    public function useAuthyGroupRelatedByIdGroupCreationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAuthyGroupRelatedByIdGroupCreation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuthyGroupRelatedByIdGroupCreation', '\App\AuthyGroupQuery');
    }

    /**
     * Filter the query by a related Authy object
     *
     * @param   Authy|PropelObjectCollection $authy The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyRelatedByIdCreation($authy, $comparison = null)
    {
        if ($authy instanceof Authy) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_CREATION, $authy->getIdAuthy(), $comparison);
        } elseif ($authy instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_CREATION, $authy->toKeyValue('PrimaryKey', 'IdAuthy'), $comparison);
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
     * @return AuthyGroupQuery The current query, for fluid interface
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
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyRelatedByIdModification($authy, $comparison = null)
    {
        if ($authy instanceof Authy) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_MODIFICATION, $authy->getIdAuthy(), $comparison);
        } elseif ($authy instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_MODIFICATION, $authy->toKeyValue('PrimaryKey', 'IdAuthy'), $comparison);
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
     * @return AuthyGroupQuery The current query, for fluid interface
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
     * Filter the query by a related AuthyGroupX object
     *
     * @param   AuthyGroupX|PropelObjectCollection $authyGroupX  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyGroupX($authyGroupX, $comparison = null)
    {
        if ($authyGroupX instanceof AuthyGroupX) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $authyGroupX->getIdAuthyGroup(), $comparison);
        } elseif ($authyGroupX instanceof PropelObjectCollection) {
            return $this
                ->useAuthyGroupXQuery()
                ->filterByPrimaryKeys($authyGroupX->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAuthyGroupX() only accepts arguments of type AuthyGroupX or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuthyGroupX relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function joinAuthyGroupX($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuthyGroupX');

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
            $this->addJoinObject($join, 'AuthyGroupX');
        }

        return $this;
    }

    /**
     * Use the AuthyGroupX relation AuthyGroupX object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AuthyGroupXQuery A secondary query class using the current class as primary query
     */
    public function useAuthyGroupXQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAuthyGroupX($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuthyGroupX', '\App\AuthyGroupXQuery');
    }

    /**
     * Filter the query by a related Authy object
     *
     * @param   Authy|PropelObjectCollection $authy  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyRelatedByIdAuthyGroup($authy, $comparison = null)
    {
        if ($authy instanceof Authy) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $authy->getIdAuthyGroup(), $comparison);
        } elseif ($authy instanceof PropelObjectCollection) {
            return $this
                ->useAuthyRelatedByIdAuthyGroupQuery()
                ->filterByPrimaryKeys($authy->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAuthyRelatedByIdAuthyGroup() only accepts arguments of type Authy or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuthyRelatedByIdAuthyGroup relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function joinAuthyRelatedByIdAuthyGroup($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuthyRelatedByIdAuthyGroup');

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
            $this->addJoinObject($join, 'AuthyRelatedByIdAuthyGroup');
        }

        return $this;
    }

    /**
     * Use the AuthyRelatedByIdAuthyGroup relation Authy object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AuthyQuery A secondary query class using the current class as primary query
     */
    public function useAuthyRelatedByIdAuthyGroupQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinAuthyRelatedByIdAuthyGroup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuthyRelatedByIdAuthyGroup', '\App\AuthyQuery');
    }

    /**
     * Filter the query by a related Authy object
     *
     * @param   Authy|PropelObjectCollection $authy  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyRelatedByIdGroupCreation($authy, $comparison = null)
    {
        if ($authy instanceof Authy) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $authy->getIdGroupCreation(), $comparison);
        } elseif ($authy instanceof PropelObjectCollection) {
            return $this
                ->useAuthyRelatedByIdGroupCreationQuery()
                ->filterByPrimaryKeys($authy->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAuthyRelatedByIdGroupCreation() only accepts arguments of type Authy or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuthyRelatedByIdGroupCreation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function joinAuthyRelatedByIdGroupCreation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuthyRelatedByIdGroupCreation');

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
            $this->addJoinObject($join, 'AuthyRelatedByIdGroupCreation');
        }

        return $this;
    }

    /**
     * Use the AuthyRelatedByIdGroupCreation relation Authy object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AuthyQuery A secondary query class using the current class as primary query
     */
    public function useAuthyRelatedByIdGroupCreationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAuthyRelatedByIdGroupCreation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuthyRelatedByIdGroupCreation', '\App\AuthyQuery');
    }

    /**
     * Filter the query by a related Country object
     *
     * @param   Country|PropelObjectCollection $country  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCountry($country, $comparison = null)
    {
        if ($country instanceof Country) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $country->getIdGroupCreation(), $comparison);
        } elseif ($country instanceof PropelObjectCollection) {
            return $this
                ->useCountryQuery()
                ->filterByPrimaryKeys($country->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCountry() only accepts arguments of type Country or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Country relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function joinCountry($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Country');

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
            $this->addJoinObject($join, 'Country');
        }

        return $this;
    }

    /**
     * Use the Country relation Country object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\CountryQuery A secondary query class using the current class as primary query
     */
    public function useCountryQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCountry($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Country', '\App\CountryQuery');
    }

    /**
     * Filter the query by a related Asset object
     *
     * @param   Asset|PropelObjectCollection $asset  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAsset($asset, $comparison = null)
    {
        if ($asset instanceof Asset) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $asset->getIdGroupCreation(), $comparison);
        } elseif ($asset instanceof PropelObjectCollection) {
            return $this
                ->useAssetQuery()
                ->filterByPrimaryKeys($asset->getPrimaryKeys())
                ->endUse();
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
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function joinAsset($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useAssetQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAsset($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Asset', '\App\AssetQuery');
    }

    /**
     * Filter the query by a related AssetExchange object
     *
     * @param   AssetExchange|PropelObjectCollection $assetExchange  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssetExchange($assetExchange, $comparison = null)
    {
        if ($assetExchange instanceof AssetExchange) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $assetExchange->getIdGroupCreation(), $comparison);
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
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function joinAssetExchange($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useAssetExchangeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTrade($trade, $comparison = null)
    {
        if ($trade instanceof Trade) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $trade->getIdGroupCreation(), $comparison);
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
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function joinTrade($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useTradeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTrade($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Trade', '\App\TradeQuery');
    }

    /**
     * Filter the query by a related Exchange object
     *
     * @param   Exchange|PropelObjectCollection $exchange  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByExchange($exchange, $comparison = null)
    {
        if ($exchange instanceof Exchange) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $exchange->getIdGroupCreation(), $comparison);
        } elseif ($exchange instanceof PropelObjectCollection) {
            return $this
                ->useExchangeQuery()
                ->filterByPrimaryKeys($exchange->getPrimaryKeys())
                ->endUse();
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
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function joinExchange($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useExchangeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinExchange($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Exchange', '\App\ExchangeQuery');
    }

    /**
     * Filter the query by a related Token object
     *
     * @param   Token|PropelObjectCollection $token  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByToken($token, $comparison = null)
    {
        if ($token instanceof Token) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $token->getIdGroupCreation(), $comparison);
        } elseif ($token instanceof PropelObjectCollection) {
            return $this
                ->useTokenQuery()
                ->filterByPrimaryKeys($token->getPrimaryKeys())
                ->endUse();
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
     * @return AuthyGroupQuery The current query, for fluid interface
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
     * Filter the query by a related Symbol object
     *
     * @param   Symbol|PropelObjectCollection $symbol  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySymbol($symbol, $comparison = null)
    {
        if ($symbol instanceof Symbol) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $symbol->getIdGroupCreation(), $comparison);
        } elseif ($symbol instanceof PropelObjectCollection) {
            return $this
                ->useSymbolQuery()
                ->filterByPrimaryKeys($symbol->getPrimaryKeys())
                ->endUse();
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
     * @return AuthyGroupQuery The current query, for fluid interface
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
     * @param   AuthyGroup|PropelObjectCollection $authyGroup  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyGroupRelatedByIdAuthyGroup($authyGroup, $comparison = null)
    {
        if ($authyGroup instanceof AuthyGroup) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $authyGroup->getIdGroupCreation(), $comparison);
        } elseif ($authyGroup instanceof PropelObjectCollection) {
            return $this
                ->useAuthyGroupRelatedByIdAuthyGroupQuery()
                ->filterByPrimaryKeys($authyGroup->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAuthyGroupRelatedByIdAuthyGroup() only accepts arguments of type AuthyGroup or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuthyGroupRelatedByIdAuthyGroup relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function joinAuthyGroupRelatedByIdAuthyGroup($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuthyGroupRelatedByIdAuthyGroup');

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
            $this->addJoinObject($join, 'AuthyGroupRelatedByIdAuthyGroup');
        }

        return $this;
    }

    /**
     * Use the AuthyGroupRelatedByIdAuthyGroup relation AuthyGroup object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AuthyGroupQuery A secondary query class using the current class as primary query
     */
    public function useAuthyGroupRelatedByIdAuthyGroupQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAuthyGroupRelatedByIdAuthyGroup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuthyGroupRelatedByIdAuthyGroup', '\App\AuthyGroupQuery');
    }

    /**
     * Filter the query by a related Config object
     *
     * @param   Config|PropelObjectCollection $config  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByConfig($config, $comparison = null)
    {
        if ($config instanceof Config) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $config->getIdGroupCreation(), $comparison);
        } elseif ($config instanceof PropelObjectCollection) {
            return $this
                ->useConfigQuery()
                ->filterByPrimaryKeys($config->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByConfig() only accepts arguments of type Config or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Config relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function joinConfig($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Config');

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
            $this->addJoinObject($join, 'Config');
        }

        return $this;
    }

    /**
     * Use the Config relation Config object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\ConfigQuery A secondary query class using the current class as primary query
     */
    public function useConfigQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinConfig($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Config', '\App\ConfigQuery');
    }

    /**
     * Filter the query by a related ApiRbac object
     *
     * @param   ApiRbac|PropelObjectCollection $apiRbac  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByApiRbac($apiRbac, $comparison = null)
    {
        if ($apiRbac instanceof ApiRbac) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $apiRbac->getIdGroupCreation(), $comparison);
        } elseif ($apiRbac instanceof PropelObjectCollection) {
            return $this
                ->useApiRbacQuery()
                ->filterByPrimaryKeys($apiRbac->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByApiRbac() only accepts arguments of type ApiRbac or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ApiRbac relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function joinApiRbac($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ApiRbac');

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
            $this->addJoinObject($join, 'ApiRbac');
        }

        return $this;
    }

    /**
     * Use the ApiRbac relation ApiRbac object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\ApiRbacQuery A secondary query class using the current class as primary query
     */
    public function useApiRbacQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinApiRbac($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ApiRbac', '\App\ApiRbacQuery');
    }

    /**
     * Filter the query by a related Template object
     *
     * @param   Template|PropelObjectCollection $template  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTemplate($template, $comparison = null)
    {
        if ($template instanceof Template) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $template->getIdGroupCreation(), $comparison);
        } elseif ($template instanceof PropelObjectCollection) {
            return $this
                ->useTemplateQuery()
                ->filterByPrimaryKeys($template->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTemplate() only accepts arguments of type Template or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Template relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function joinTemplate($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Template');

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
            $this->addJoinObject($join, 'Template');
        }

        return $this;
    }

    /**
     * Use the Template relation Template object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\TemplateQuery A secondary query class using the current class as primary query
     */
    public function useTemplateQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTemplate($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Template', '\App\TemplateQuery');
    }

    /**
     * Filter the query by a related TemplateFile object
     *
     * @param   TemplateFile|PropelObjectCollection $templateFile  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTemplateFile($templateFile, $comparison = null)
    {
        if ($templateFile instanceof TemplateFile) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $templateFile->getIdGroupCreation(), $comparison);
        } elseif ($templateFile instanceof PropelObjectCollection) {
            return $this
                ->useTemplateFileQuery()
                ->filterByPrimaryKeys($templateFile->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTemplateFile() only accepts arguments of type TemplateFile or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TemplateFile relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function joinTemplateFile($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TemplateFile');

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
            $this->addJoinObject($join, 'TemplateFile');
        }

        return $this;
    }

    /**
     * Use the TemplateFile relation TemplateFile object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\TemplateFileQuery A secondary query class using the current class as primary query
     */
    public function useTemplateFileQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTemplateFile($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TemplateFile', '\App\TemplateFileQuery');
    }

    /**
     * Filter the query by a related MessageI18n object
     *
     * @param   MessageI18n|PropelObjectCollection $messageI18n  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMessageI18n($messageI18n, $comparison = null)
    {
        if ($messageI18n instanceof MessageI18n) {
            return $this
                ->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $messageI18n->getIdGroupCreation(), $comparison);
        } elseif ($messageI18n instanceof PropelObjectCollection) {
            return $this
                ->useMessageI18nQuery()
                ->filterByPrimaryKeys($messageI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMessageI18n() only accepts arguments of type MessageI18n or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MessageI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function joinMessageI18n($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MessageI18n');

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
            $this->addJoinObject($join, 'MessageI18n');
        }

        return $this;
    }

    /**
     * Use the MessageI18n relation MessageI18n object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\MessageI18nQuery A secondary query class using the current class as primary query
     */
    public function useMessageI18nQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMessageI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MessageI18n', '\App\MessageI18nQuery');
    }

    /**
     * Filter the query by a related Authy object
     * using the authy_group_x table as cross reference
     *
     * @param   Authy $authy the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   AuthyGroupQuery The current query, for fluid interface
     */
    public function filterByRelAuthy($authy, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useAuthyGroupXQuery()
            ->filterByAuthy($authy, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   AuthyGroup $authyGroup Object to remove from the list of results
     *
     * @return AuthyGroupQuery The current query, for fluid interface
     */
    public function prune($authyGroup = null)
    {
        if ($authyGroup) {
            $this->addUsingAlias(AuthyGroupPeer::ID_AUTHY_GROUP, $authyGroup->getIdAuthyGroup(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // add_tablestamp behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     AuthyGroupQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7){
        return $this->addUsingAlias(AuthyGroupPeer::DATE_MODIFICATION, time() - $nbDays * 24 * 60 * 60, \Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     AuthyGroupQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst(){
        return $this->addDescendingOrderByColumn(AuthyGroupPeer::DATE_MODIFICATION);
    }

    /**
     * Order by update date asc
     *
     * @return     AuthyGroupQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst(){
        return $this->addAscendingOrderByColumn(AuthyGroupPeer::DATE_MODIFICATION);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     AuthyGroupQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7){
        return $this->addUsingAlias(AuthyGroupPeer::DATE_CREATION, time() - $nbDays * 24 * 60 * 60, \Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     AuthyGroupQuery The current query, for fluid interface
     */
    public function lastCreatedFirst(){
        return $this->addDescendingOrderByColumn(AuthyGroupPeer::DATE_CREATION);
    }

    /**
     * Order by create date asc
     *
     * @return     AuthyGroupQuery The current query, for fluid interface
     */
    public function firstCreatedFirst(){
        return $this->addAscendingOrderByColumn(AuthyGroupPeer::DATE_CREATION);
    }
}
