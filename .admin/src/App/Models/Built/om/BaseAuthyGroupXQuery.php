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
use App\Authy;
use App\AuthyGroup;
use App\AuthyGroupX;
use App\AuthyGroupXPeer;
use App\AuthyGroupXQuery;

/**
 * Base class that represents a query for the 'authy_group_x' table.
 *
 * Group
 *
 * @method AuthyGroupXQuery orderByIdAuthy($order = Criteria::ASC) Order by the id_authy column
 * @method AuthyGroupXQuery orderByIdAuthyGroup($order = Criteria::ASC) Order by the id_authy_group column
 *
 * @method AuthyGroupXQuery groupByIdAuthy() Group by the id_authy column
 * @method AuthyGroupXQuery groupByIdAuthyGroup() Group by the id_authy_group column
 *
 * @method AuthyGroupXQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AuthyGroupXQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AuthyGroupXQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AuthyGroupXQuery leftJoinAuthyGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyGroup relation
 * @method AuthyGroupXQuery rightJoinAuthyGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyGroup relation
 * @method AuthyGroupXQuery innerJoinAuthyGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyGroup relation
 *
 * @method AuthyGroupXQuery leftJoinAuthy($relationAlias = null) Adds a LEFT JOIN clause to the query using the Authy relation
 * @method AuthyGroupXQuery rightJoinAuthy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Authy relation
 * @method AuthyGroupXQuery innerJoinAuthy($relationAlias = null) Adds a INNER JOIN clause to the query using the Authy relation
 *
 * @method AuthyGroupX findOne(PropelPDO $con = null) Return the first AuthyGroupX matching the query
 * @method AuthyGroupX findOneOrCreate(PropelPDO $con = null) Return the first AuthyGroupX matching the query, or a new AuthyGroupX object populated from the query conditions when no match is found
 *
 * @method AuthyGroupX findOneByIdAuthy(int $id_authy) Return the first AuthyGroupX filtered by the id_authy column
 * @method AuthyGroupX findOneByIdAuthyGroup(int $id_authy_group) Return the first AuthyGroupX filtered by the id_authy_group column
 *
 * @method array findByIdAuthy(int $id_authy) Return AuthyGroupX objects filtered by the id_authy column
 * @method array findByIdAuthyGroup(int $id_authy_group) Return AuthyGroupX objects filtered by the id_authy_group column
 *
 * @package    propel.generator..om
 */
abstract class BaseAuthyGroupXQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAuthyGroupXQuery object.
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
            $modelName = 'App\\AuthyGroupX';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AuthyGroupXQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AuthyGroupXQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AuthyGroupXQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AuthyGroupXQuery) {
            return $criteria;
        }
        $query = new AuthyGroupXQuery(null, null, $modelAlias);

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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array $key Primary key to use for the query
                         A Primary key composition: [$id_authy, $id_authy_group]
     * @param     PropelPDO $con an optional connection object
     *
     * @return   AuthyGroupX|AuthyGroupX[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AuthyGroupXPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AuthyGroupXPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 AuthyGroupX A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id_authy`, `id_authy_group` FROM `authy_group_x` WHERE `id_authy` = :p0 AND `id_authy_group` = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new AuthyGroupX();
            $obj->hydrate($row);
            AuthyGroupXPeer::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return AuthyGroupX|AuthyGroupX[]|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|AuthyGroupX[]|mixed the list of results, formatted by the current formatter
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
     * @return AuthyGroupXQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(AuthyGroupXPeer::ID_AUTHY, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(AuthyGroupXPeer::ID_AUTHY_GROUP, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AuthyGroupXQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(AuthyGroupXPeer::ID_AUTHY, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(AuthyGroupXPeer::ID_AUTHY_GROUP, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the id_authy column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAuthy(1234); // WHERE id_authy = 1234
     * $query->filterByIdAuthy(array(12, 34)); // WHERE id_authy IN (12, 34)
     * $query->filterByIdAuthy(array('min' => 12)); // WHERE id_authy >= 12
     * $query->filterByIdAuthy(array('max' => 12)); // WHERE id_authy <= 12
     * </code>
     *
     * @see       filterByAuthy()
     *
     * @param     mixed $idAuthy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyGroupXQuery The current query, for fluid interface
     */
    public function filterByIdAuthy($idAuthy = null, $comparison = null)
    {
        if (is_array($idAuthy)) {
            $useMinMax = false;
            if (isset($idAuthy['min'])) {
                $this->addUsingAlias(AuthyGroupXPeer::ID_AUTHY, $idAuthy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAuthy['max'])) {
                $this->addUsingAlias(AuthyGroupXPeer::ID_AUTHY, $idAuthy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyGroupXPeer::ID_AUTHY, $idAuthy, $comparison);
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
     * @see       filterByAuthyGroup()
     *
     * @param     mixed $idAuthyGroup The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyGroupXQuery The current query, for fluid interface
     */
    public function filterByIdAuthyGroup($idAuthyGroup = null, $comparison = null)
    {
        if (is_array($idAuthyGroup)) {
            $useMinMax = false;
            if (isset($idAuthyGroup['min'])) {
                $this->addUsingAlias(AuthyGroupXPeer::ID_AUTHY_GROUP, $idAuthyGroup['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAuthyGroup['max'])) {
                $this->addUsingAlias(AuthyGroupXPeer::ID_AUTHY_GROUP, $idAuthyGroup['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyGroupXPeer::ID_AUTHY_GROUP, $idAuthyGroup, $comparison);
    }

    /**
     * Filter the query by a related AuthyGroup object
     *
     * @param   AuthyGroup|PropelObjectCollection $authyGroup The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyGroupXQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyGroup($authyGroup, $comparison = null)
    {
        if ($authyGroup instanceof AuthyGroup) {
            return $this
                ->addUsingAlias(AuthyGroupXPeer::ID_AUTHY_GROUP, $authyGroup->getIdAuthyGroup(), $comparison);
        } elseif ($authyGroup instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AuthyGroupXPeer::ID_AUTHY_GROUP, $authyGroup->toKeyValue('PrimaryKey', 'IdAuthyGroup'), $comparison);
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
     * @return AuthyGroupXQuery The current query, for fluid interface
     */
    public function joinAuthyGroup($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useAuthyGroupQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
     * @return                 AuthyGroupXQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthy($authy, $comparison = null)
    {
        if ($authy instanceof Authy) {
            return $this
                ->addUsingAlias(AuthyGroupXPeer::ID_AUTHY, $authy->getIdAuthy(), $comparison);
        } elseif ($authy instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AuthyGroupXPeer::ID_AUTHY, $authy->toKeyValue('PrimaryKey', 'IdAuthy'), $comparison);
        } else {
            throw new PropelException('filterByAuthy() only accepts arguments of type Authy or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Authy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyGroupXQuery The current query, for fluid interface
     */
    public function joinAuthy($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Authy');

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
            $this->addJoinObject($join, 'Authy');
        }

        return $this;
    }

    /**
     * Use the Authy relation Authy object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AuthyQuery A secondary query class using the current class as primary query
     */
    public function useAuthyQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAuthy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Authy', '\App\AuthyQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   AuthyGroupX $authyGroupX Object to remove from the list of results
     *
     * @return AuthyGroupXQuery The current query, for fluid interface
     */
    public function prune($authyGroupX = null)
    {
        if ($authyGroupX) {
            $this->addCond('pruneCond0', $this->getAliasedColName(AuthyGroupXPeer::ID_AUTHY), $authyGroupX->getIdAuthy(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(AuthyGroupXPeer::ID_AUTHY_GROUP), $authyGroupX->getIdAuthyGroup(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

}
