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
use App\ApiLog;
use App\ApiRbac;
use App\Asset;
use App\AssetExchange;
use App\Authy;
use App\AuthyGroup;
use App\AuthyGroupX;
use App\AuthyLog;
use App\AuthyPeer;
use App\AuthyQuery;
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
 * Base class that represents a query for the 'authy' table.
 *
 * User
 *
 * @method AuthyQuery orderByIdAuthy($order = Criteria::ASC) Order by the id_authy column
 * @method AuthyQuery orderByValidationKey($order = Criteria::ASC) Order by the validation_key column
 * @method AuthyQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method AuthyQuery orderByFullname($order = Criteria::ASC) Order by the fullname column
 * @method AuthyQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method AuthyQuery orderByPasswdHash($order = Criteria::ASC) Order by the passwd_hash column
 * @method AuthyQuery orderByExpire($order = Criteria::ASC) Order by the expire column
 * @method AuthyQuery orderByDeactivate($order = Criteria::ASC) Order by the deactivate column
 * @method AuthyQuery orderByIsRoot($order = Criteria::ASC) Order by the is_root column
 * @method AuthyQuery orderByIdAuthyGroup($order = Criteria::ASC) Order by the id_authy_group column
 * @method AuthyQuery orderByIsSystem($order = Criteria::ASC) Order by the is_system column
 * @method AuthyQuery orderByRightsAll($order = Criteria::ASC) Order by the rights_all column
 * @method AuthyQuery orderByRightsGroup($order = Criteria::ASC) Order by the rights_group column
 * @method AuthyQuery orderByRightsOwner($order = Criteria::ASC) Order by the rights_owner column
 * @method AuthyQuery orderByOnglet($order = Criteria::ASC) Order by the onglet column
 * @method AuthyQuery orderByDateCreation($order = Criteria::ASC) Order by the date_creation column
 * @method AuthyQuery orderByDateModification($order = Criteria::ASC) Order by the date_modification column
 * @method AuthyQuery orderByIdGroupCreation($order = Criteria::ASC) Order by the id_group_creation column
 * @method AuthyQuery orderByIdCreation($order = Criteria::ASC) Order by the id_creation column
 * @method AuthyQuery orderByIdModification($order = Criteria::ASC) Order by the id_modification column
 *
 * @method AuthyQuery groupByIdAuthy() Group by the id_authy column
 * @method AuthyQuery groupByValidationKey() Group by the validation_key column
 * @method AuthyQuery groupByUsername() Group by the username column
 * @method AuthyQuery groupByFullname() Group by the fullname column
 * @method AuthyQuery groupByEmail() Group by the email column
 * @method AuthyQuery groupByPasswdHash() Group by the passwd_hash column
 * @method AuthyQuery groupByExpire() Group by the expire column
 * @method AuthyQuery groupByDeactivate() Group by the deactivate column
 * @method AuthyQuery groupByIsRoot() Group by the is_root column
 * @method AuthyQuery groupByIdAuthyGroup() Group by the id_authy_group column
 * @method AuthyQuery groupByIsSystem() Group by the is_system column
 * @method AuthyQuery groupByRightsAll() Group by the rights_all column
 * @method AuthyQuery groupByRightsGroup() Group by the rights_group column
 * @method AuthyQuery groupByRightsOwner() Group by the rights_owner column
 * @method AuthyQuery groupByOnglet() Group by the onglet column
 * @method AuthyQuery groupByDateCreation() Group by the date_creation column
 * @method AuthyQuery groupByDateModification() Group by the date_modification column
 * @method AuthyQuery groupByIdGroupCreation() Group by the id_group_creation column
 * @method AuthyQuery groupByIdCreation() Group by the id_creation column
 * @method AuthyQuery groupByIdModification() Group by the id_modification column
 *
 * @method AuthyQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AuthyQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AuthyQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AuthyQuery leftJoinAuthyGroupRelatedByIdAuthyGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyGroupRelatedByIdAuthyGroup relation
 * @method AuthyQuery rightJoinAuthyGroupRelatedByIdAuthyGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyGroupRelatedByIdAuthyGroup relation
 * @method AuthyQuery innerJoinAuthyGroupRelatedByIdAuthyGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyGroupRelatedByIdAuthyGroup relation
 *
 * @method AuthyQuery leftJoinAuthyGroupRelatedByIdGroupCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyGroupRelatedByIdGroupCreation relation
 * @method AuthyQuery rightJoinAuthyGroupRelatedByIdGroupCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyGroupRelatedByIdGroupCreation relation
 * @method AuthyQuery innerJoinAuthyGroupRelatedByIdGroupCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyGroupRelatedByIdGroupCreation relation
 *
 * @method AuthyQuery leftJoinAuthyRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyRelatedByIdCreation relation
 * @method AuthyQuery rightJoinAuthyRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyRelatedByIdCreation relation
 * @method AuthyQuery innerJoinAuthyRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyRelatedByIdCreation relation
 *
 * @method AuthyQuery leftJoinAuthyRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyRelatedByIdModification relation
 * @method AuthyQuery rightJoinAuthyRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyRelatedByIdModification relation
 * @method AuthyQuery innerJoinAuthyRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyRelatedByIdModification relation
 *
 * @method AuthyQuery leftJoinAuthyGroupX($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyGroupX relation
 * @method AuthyQuery rightJoinAuthyGroupX($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyGroupX relation
 * @method AuthyQuery innerJoinAuthyGroupX($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyGroupX relation
 *
 * @method AuthyQuery leftJoinAuthyLog($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyLog relation
 * @method AuthyQuery rightJoinAuthyLog($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyLog relation
 * @method AuthyQuery innerJoinAuthyLog($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyLog relation
 *
 * @method AuthyQuery leftJoinAuthyRelatedByIdAuthy0($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyRelatedByIdAuthy0 relation
 * @method AuthyQuery rightJoinAuthyRelatedByIdAuthy0($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyRelatedByIdAuthy0 relation
 * @method AuthyQuery innerJoinAuthyRelatedByIdAuthy0($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyRelatedByIdAuthy0 relation
 *
 * @method AuthyQuery leftJoinAuthyRelatedByIdAuthy1($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyRelatedByIdAuthy1 relation
 * @method AuthyQuery rightJoinAuthyRelatedByIdAuthy1($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyRelatedByIdAuthy1 relation
 * @method AuthyQuery innerJoinAuthyRelatedByIdAuthy1($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyRelatedByIdAuthy1 relation
 *
 * @method AuthyQuery leftJoinCountryRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the CountryRelatedByIdCreation relation
 * @method AuthyQuery rightJoinCountryRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CountryRelatedByIdCreation relation
 * @method AuthyQuery innerJoinCountryRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the CountryRelatedByIdCreation relation
 *
 * @method AuthyQuery leftJoinCountryRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the CountryRelatedByIdModification relation
 * @method AuthyQuery rightJoinCountryRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CountryRelatedByIdModification relation
 * @method AuthyQuery innerJoinCountryRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the CountryRelatedByIdModification relation
 *
 * @method AuthyQuery leftJoinAssetRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the AssetRelatedByIdCreation relation
 * @method AuthyQuery rightJoinAssetRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AssetRelatedByIdCreation relation
 * @method AuthyQuery innerJoinAssetRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the AssetRelatedByIdCreation relation
 *
 * @method AuthyQuery leftJoinAssetRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the AssetRelatedByIdModification relation
 * @method AuthyQuery rightJoinAssetRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AssetRelatedByIdModification relation
 * @method AuthyQuery innerJoinAssetRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the AssetRelatedByIdModification relation
 *
 * @method AuthyQuery leftJoinAssetExchangeRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the AssetExchangeRelatedByIdCreation relation
 * @method AuthyQuery rightJoinAssetExchangeRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AssetExchangeRelatedByIdCreation relation
 * @method AuthyQuery innerJoinAssetExchangeRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the AssetExchangeRelatedByIdCreation relation
 *
 * @method AuthyQuery leftJoinAssetExchangeRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the AssetExchangeRelatedByIdModification relation
 * @method AuthyQuery rightJoinAssetExchangeRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AssetExchangeRelatedByIdModification relation
 * @method AuthyQuery innerJoinAssetExchangeRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the AssetExchangeRelatedByIdModification relation
 *
 * @method AuthyQuery leftJoinTradeRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the TradeRelatedByIdCreation relation
 * @method AuthyQuery rightJoinTradeRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TradeRelatedByIdCreation relation
 * @method AuthyQuery innerJoinTradeRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the TradeRelatedByIdCreation relation
 *
 * @method AuthyQuery leftJoinTradeRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the TradeRelatedByIdModification relation
 * @method AuthyQuery rightJoinTradeRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TradeRelatedByIdModification relation
 * @method AuthyQuery innerJoinTradeRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the TradeRelatedByIdModification relation
 *
 * @method AuthyQuery leftJoinExchangeRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the ExchangeRelatedByIdCreation relation
 * @method AuthyQuery rightJoinExchangeRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ExchangeRelatedByIdCreation relation
 * @method AuthyQuery innerJoinExchangeRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the ExchangeRelatedByIdCreation relation
 *
 * @method AuthyQuery leftJoinExchangeRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the ExchangeRelatedByIdModification relation
 * @method AuthyQuery rightJoinExchangeRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ExchangeRelatedByIdModification relation
 * @method AuthyQuery innerJoinExchangeRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the ExchangeRelatedByIdModification relation
 *
 * @method AuthyQuery leftJoinTokenRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the TokenRelatedByIdCreation relation
 * @method AuthyQuery rightJoinTokenRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TokenRelatedByIdCreation relation
 * @method AuthyQuery innerJoinTokenRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the TokenRelatedByIdCreation relation
 *
 * @method AuthyQuery leftJoinTokenRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the TokenRelatedByIdModification relation
 * @method AuthyQuery rightJoinTokenRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TokenRelatedByIdModification relation
 * @method AuthyQuery innerJoinTokenRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the TokenRelatedByIdModification relation
 *
 * @method AuthyQuery leftJoinSymbolRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the SymbolRelatedByIdCreation relation
 * @method AuthyQuery rightJoinSymbolRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SymbolRelatedByIdCreation relation
 * @method AuthyQuery innerJoinSymbolRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the SymbolRelatedByIdCreation relation
 *
 * @method AuthyQuery leftJoinSymbolRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the SymbolRelatedByIdModification relation
 * @method AuthyQuery rightJoinSymbolRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SymbolRelatedByIdModification relation
 * @method AuthyQuery innerJoinSymbolRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the SymbolRelatedByIdModification relation
 *
 * @method AuthyQuery leftJoinAuthyGroupRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyGroupRelatedByIdCreation relation
 * @method AuthyQuery rightJoinAuthyGroupRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyGroupRelatedByIdCreation relation
 * @method AuthyQuery innerJoinAuthyGroupRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyGroupRelatedByIdCreation relation
 *
 * @method AuthyQuery leftJoinAuthyGroupRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuthyGroupRelatedByIdModification relation
 * @method AuthyQuery rightJoinAuthyGroupRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuthyGroupRelatedByIdModification relation
 * @method AuthyQuery innerJoinAuthyGroupRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the AuthyGroupRelatedByIdModification relation
 *
 * @method AuthyQuery leftJoinConfigRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the ConfigRelatedByIdCreation relation
 * @method AuthyQuery rightJoinConfigRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ConfigRelatedByIdCreation relation
 * @method AuthyQuery innerJoinConfigRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the ConfigRelatedByIdCreation relation
 *
 * @method AuthyQuery leftJoinConfigRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the ConfigRelatedByIdModification relation
 * @method AuthyQuery rightJoinConfigRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ConfigRelatedByIdModification relation
 * @method AuthyQuery innerJoinConfigRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the ConfigRelatedByIdModification relation
 *
 * @method AuthyQuery leftJoinApiRbacRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the ApiRbacRelatedByIdCreation relation
 * @method AuthyQuery rightJoinApiRbacRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ApiRbacRelatedByIdCreation relation
 * @method AuthyQuery innerJoinApiRbacRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the ApiRbacRelatedByIdCreation relation
 *
 * @method AuthyQuery leftJoinApiRbacRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the ApiRbacRelatedByIdModification relation
 * @method AuthyQuery rightJoinApiRbacRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ApiRbacRelatedByIdModification relation
 * @method AuthyQuery innerJoinApiRbacRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the ApiRbacRelatedByIdModification relation
 *
 * @method AuthyQuery leftJoinApiLog($relationAlias = null) Adds a LEFT JOIN clause to the query using the ApiLog relation
 * @method AuthyQuery rightJoinApiLog($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ApiLog relation
 * @method AuthyQuery innerJoinApiLog($relationAlias = null) Adds a INNER JOIN clause to the query using the ApiLog relation
 *
 * @method AuthyQuery leftJoinTemplateRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the TemplateRelatedByIdCreation relation
 * @method AuthyQuery rightJoinTemplateRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TemplateRelatedByIdCreation relation
 * @method AuthyQuery innerJoinTemplateRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the TemplateRelatedByIdCreation relation
 *
 * @method AuthyQuery leftJoinTemplateRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the TemplateRelatedByIdModification relation
 * @method AuthyQuery rightJoinTemplateRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TemplateRelatedByIdModification relation
 * @method AuthyQuery innerJoinTemplateRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the TemplateRelatedByIdModification relation
 *
 * @method AuthyQuery leftJoinTemplateFileRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the TemplateFileRelatedByIdCreation relation
 * @method AuthyQuery rightJoinTemplateFileRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TemplateFileRelatedByIdCreation relation
 * @method AuthyQuery innerJoinTemplateFileRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the TemplateFileRelatedByIdCreation relation
 *
 * @method AuthyQuery leftJoinTemplateFileRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the TemplateFileRelatedByIdModification relation
 * @method AuthyQuery rightJoinTemplateFileRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TemplateFileRelatedByIdModification relation
 * @method AuthyQuery innerJoinTemplateFileRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the TemplateFileRelatedByIdModification relation
 *
 * @method AuthyQuery leftJoinMessageI18nRelatedByIdCreation($relationAlias = null) Adds a LEFT JOIN clause to the query using the MessageI18nRelatedByIdCreation relation
 * @method AuthyQuery rightJoinMessageI18nRelatedByIdCreation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MessageI18nRelatedByIdCreation relation
 * @method AuthyQuery innerJoinMessageI18nRelatedByIdCreation($relationAlias = null) Adds a INNER JOIN clause to the query using the MessageI18nRelatedByIdCreation relation
 *
 * @method AuthyQuery leftJoinMessageI18nRelatedByIdModification($relationAlias = null) Adds a LEFT JOIN clause to the query using the MessageI18nRelatedByIdModification relation
 * @method AuthyQuery rightJoinMessageI18nRelatedByIdModification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MessageI18nRelatedByIdModification relation
 * @method AuthyQuery innerJoinMessageI18nRelatedByIdModification($relationAlias = null) Adds a INNER JOIN clause to the query using the MessageI18nRelatedByIdModification relation
 *
 * @method Authy findOne(PropelPDO $con = null) Return the first Authy matching the query
 * @method Authy findOneOrCreate(PropelPDO $con = null) Return the first Authy matching the query, or a new Authy object populated from the query conditions when no match is found
 *
 * @method Authy findOneByValidationKey(string $validation_key) Return the first Authy filtered by the validation_key column
 * @method Authy findOneByUsername(string $username) Return the first Authy filtered by the username column
 * @method Authy findOneByFullname(string $fullname) Return the first Authy filtered by the fullname column
 * @method Authy findOneByEmail(string $email) Return the first Authy filtered by the email column
 * @method Authy findOneByPasswdHash(string $passwd_hash) Return the first Authy filtered by the passwd_hash column
 * @method Authy findOneByExpire(string $expire) Return the first Authy filtered by the expire column
 * @method Authy findOneByDeactivate(int $deactivate) Return the first Authy filtered by the deactivate column
 * @method Authy findOneByIsRoot(int $is_root) Return the first Authy filtered by the is_root column
 * @method Authy findOneByIdAuthyGroup(int $id_authy_group) Return the first Authy filtered by the id_authy_group column
 * @method Authy findOneByIsSystem(int $is_system) Return the first Authy filtered by the is_system column
 * @method Authy findOneByRightsAll(string $rights_all) Return the first Authy filtered by the rights_all column
 * @method Authy findOneByRightsGroup(string $rights_group) Return the first Authy filtered by the rights_group column
 * @method Authy findOneByRightsOwner(string $rights_owner) Return the first Authy filtered by the rights_owner column
 * @method Authy findOneByOnglet(string $onglet) Return the first Authy filtered by the onglet column
 * @method Authy findOneByDateCreation(string $date_creation) Return the first Authy filtered by the date_creation column
 * @method Authy findOneByDateModification(string $date_modification) Return the first Authy filtered by the date_modification column
 * @method Authy findOneByIdGroupCreation(int $id_group_creation) Return the first Authy filtered by the id_group_creation column
 * @method Authy findOneByIdCreation(int $id_creation) Return the first Authy filtered by the id_creation column
 * @method Authy findOneByIdModification(int $id_modification) Return the first Authy filtered by the id_modification column
 *
 * @method array findByIdAuthy(int $id_authy) Return Authy objects filtered by the id_authy column
 * @method array findByValidationKey(string $validation_key) Return Authy objects filtered by the validation_key column
 * @method array findByUsername(string $username) Return Authy objects filtered by the username column
 * @method array findByFullname(string $fullname) Return Authy objects filtered by the fullname column
 * @method array findByEmail(string $email) Return Authy objects filtered by the email column
 * @method array findByPasswdHash(string $passwd_hash) Return Authy objects filtered by the passwd_hash column
 * @method array findByExpire(string $expire) Return Authy objects filtered by the expire column
 * @method array findByDeactivate(int $deactivate) Return Authy objects filtered by the deactivate column
 * @method array findByIsRoot(int $is_root) Return Authy objects filtered by the is_root column
 * @method array findByIdAuthyGroup(int $id_authy_group) Return Authy objects filtered by the id_authy_group column
 * @method array findByIsSystem(int $is_system) Return Authy objects filtered by the is_system column
 * @method array findByRightsAll(string $rights_all) Return Authy objects filtered by the rights_all column
 * @method array findByRightsGroup(string $rights_group) Return Authy objects filtered by the rights_group column
 * @method array findByRightsOwner(string $rights_owner) Return Authy objects filtered by the rights_owner column
 * @method array findByOnglet(string $onglet) Return Authy objects filtered by the onglet column
 * @method array findByDateCreation(string $date_creation) Return Authy objects filtered by the date_creation column
 * @method array findByDateModification(string $date_modification) Return Authy objects filtered by the date_modification column
 * @method array findByIdGroupCreation(int $id_group_creation) Return Authy objects filtered by the id_group_creation column
 * @method array findByIdCreation(int $id_creation) Return Authy objects filtered by the id_creation column
 * @method array findByIdModification(int $id_modification) Return Authy objects filtered by the id_modification column
 *
 * @package    propel.generator..om
 */
abstract class BaseAuthyQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAuthyQuery object.
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
            $modelName = 'App\\Authy';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AuthyQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AuthyQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AuthyQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AuthyQuery) {
            return $criteria;
        }
        $query = new AuthyQuery(null, null, $modelAlias);

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
     * @return   Authy|Authy[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AuthyPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AuthyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Authy A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByIdAuthy($key, $con = null)
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
     * @return                 Authy A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id_authy`, `validation_key`, `username`, `fullname`, `email`, `passwd_hash`, `expire`, `deactivate`, `is_root`, `id_authy_group`, `is_system`, `rights_all`, `rights_group`, `rights_owner`, `onglet`, `date_creation`, `date_modification`, `id_group_creation`, `id_creation`, `id_modification` FROM `authy` WHERE `id_authy` = :p0';
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
            $obj = new Authy();
            $obj->hydrate($row);
            AuthyPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Authy|Authy[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Authy[]|mixed the list of results, formatted by the current formatter
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
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AuthyPeer::ID_AUTHY, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AuthyPeer::ID_AUTHY, $keys, Criteria::IN);
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
     * @param     mixed $idAuthy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByIdAuthy($idAuthy = null, $comparison = null)
    {
        if (is_array($idAuthy)) {
            $useMinMax = false;
            if (isset($idAuthy['min'])) {
                $this->addUsingAlias(AuthyPeer::ID_AUTHY, $idAuthy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAuthy['max'])) {
                $this->addUsingAlias(AuthyPeer::ID_AUTHY, $idAuthy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::ID_AUTHY, $idAuthy, $comparison);
    }

    /**
     * Filter the query on the validation_key column
     *
     * Example usage:
     * <code>
     * $query->filterByValidationKey('fooValue');   // WHERE validation_key = 'fooValue'
     * $query->filterByValidationKey('%fooValue%'); // WHERE validation_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $validationKey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByValidationKey($validationKey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($validationKey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $validationKey)) {
                $validationKey = str_replace('*', '%', $validationKey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyPeer::VALIDATION_KEY, $validationKey, $comparison);
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByUsername('%fooValue%'); // WHERE username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $username)) {
                $username = str_replace('*', '%', $username);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyPeer::USERNAME, $username, $comparison);
    }

    /**
     * Filter the query on the fullname column
     *
     * Example usage:
     * <code>
     * $query->filterByFullname('fooValue');   // WHERE fullname = 'fooValue'
     * $query->filterByFullname('%fooValue%'); // WHERE fullname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fullname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByFullname($fullname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fullname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fullname)) {
                $fullname = str_replace('*', '%', $fullname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyPeer::FULLNAME, $fullname, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyPeer::EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the passwd_hash column
     *
     * Example usage:
     * <code>
     * $query->filterByPasswdHash('fooValue');   // WHERE passwd_hash = 'fooValue'
     * $query->filterByPasswdHash('%fooValue%'); // WHERE passwd_hash LIKE '%fooValue%'
     * </code>
     *
     * @param     string $passwdHash The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByPasswdHash($passwdHash = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($passwdHash)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $passwdHash)) {
                $passwdHash = str_replace('*', '%', $passwdHash);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyPeer::PASSWD_HASH, $passwdHash, $comparison);
    }

    /**
     * Filter the query on the expire column
     *
     * Example usage:
     * <code>
     * $query->filterByExpire('2011-03-14'); // WHERE expire = '2011-03-14'
     * $query->filterByExpire('now'); // WHERE expire = '2011-03-14'
     * $query->filterByExpire(array('max' => 'yesterday')); // WHERE expire < '2011-03-13'
     * </code>
     *
     * @param     mixed $expire The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByExpire($expire = null, $comparison = null)
    {
        if (is_array($expire)) {
            $useMinMax = false;
            if (isset($expire['min'])) {
                $this->addUsingAlias(AuthyPeer::EXPIRE, $expire['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expire['max'])) {
                $this->addUsingAlias(AuthyPeer::EXPIRE, $expire['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::EXPIRE, $expire, $comparison);
    }

    /**
     * Filter the query on the deactivate column
     *
     * @param     mixed $deactivate The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByDeactivate($deactivate = null, $comparison = null)
    {
        if (is_scalar($deactivate)) {
            $deactivate = AuthyPeer::getSqlValueForEnum(AuthyPeer::DEACTIVATE, $deactivate);
        } elseif (is_array($deactivate)) {
            $convertedValues = array();
            foreach ($deactivate as $value) {
                $convertedValues[] = AuthyPeer::getSqlValueForEnum(AuthyPeer::DEACTIVATE, $value);
            }
            $deactivate = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::DEACTIVATE, $deactivate, $comparison);
    }

    /**
     * Filter the query on the is_root column
     *
     * @param     mixed $isRoot The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByIsRoot($isRoot = null, $comparison = null)
    {
        if (is_scalar($isRoot)) {
            $isRoot = AuthyPeer::getSqlValueForEnum(AuthyPeer::IS_ROOT, $isRoot);
        } elseif (is_array($isRoot)) {
            $convertedValues = array();
            foreach ($isRoot as $value) {
                $convertedValues[] = AuthyPeer::getSqlValueForEnum(AuthyPeer::IS_ROOT, $value);
            }
            $isRoot = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::IS_ROOT, $isRoot, $comparison);
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
     * @see       filterByAuthyGroupRelatedByIdAuthyGroup()
     *
     * @param     mixed $idAuthyGroup The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByIdAuthyGroup($idAuthyGroup = null, $comparison = null)
    {
        if (is_array($idAuthyGroup)) {
            $useMinMax = false;
            if (isset($idAuthyGroup['min'])) {
                $this->addUsingAlias(AuthyPeer::ID_AUTHY_GROUP, $idAuthyGroup['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAuthyGroup['max'])) {
                $this->addUsingAlias(AuthyPeer::ID_AUTHY_GROUP, $idAuthyGroup['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::ID_AUTHY_GROUP, $idAuthyGroup, $comparison);
    }

    /**
     * Filter the query on the is_system column
     *
     * @param     mixed $isSystem The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByIsSystem($isSystem = null, $comparison = null)
    {
        if (is_scalar($isSystem)) {
            $isSystem = AuthyPeer::getSqlValueForEnum(AuthyPeer::IS_SYSTEM, $isSystem);
        } elseif (is_array($isSystem)) {
            $convertedValues = array();
            foreach ($isSystem as $value) {
                $convertedValues[] = AuthyPeer::getSqlValueForEnum(AuthyPeer::IS_SYSTEM, $value);
            }
            $isSystem = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::IS_SYSTEM, $isSystem, $comparison);
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
     * @return AuthyQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AuthyPeer::RIGHTS_ALL, $rightsAll, $comparison);
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
     * @return AuthyQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AuthyPeer::RIGHTS_GROUP, $rightsGroup, $comparison);
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
     * @return AuthyQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AuthyPeer::RIGHTS_OWNER, $rightsOwner, $comparison);
    }

    /**
     * Filter the query on the onglet column
     *
     * Example usage:
     * <code>
     * $query->filterByOnglet('fooValue');   // WHERE onglet = 'fooValue'
     * $query->filterByOnglet('%fooValue%'); // WHERE onglet LIKE '%fooValue%'
     * </code>
     *
     * @param     string $onglet The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByOnglet($onglet = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($onglet)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $onglet)) {
                $onglet = str_replace('*', '%', $onglet);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyPeer::ONGLET, $onglet, $comparison);
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
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByDateCreation($dateCreation = null, $comparison = null)
    {
        if (is_array($dateCreation)) {
            $useMinMax = false;
            if (isset($dateCreation['min'])) {
                $this->addUsingAlias(AuthyPeer::DATE_CREATION, $dateCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreation['max'])) {
                $this->addUsingAlias(AuthyPeer::DATE_CREATION, $dateCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::DATE_CREATION, $dateCreation, $comparison);
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
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByDateModification($dateModification = null, $comparison = null)
    {
        if (is_array($dateModification)) {
            $useMinMax = false;
            if (isset($dateModification['min'])) {
                $this->addUsingAlias(AuthyPeer::DATE_MODIFICATION, $dateModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateModification['max'])) {
                $this->addUsingAlias(AuthyPeer::DATE_MODIFICATION, $dateModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::DATE_MODIFICATION, $dateModification, $comparison);
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
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByIdGroupCreation($idGroupCreation = null, $comparison = null)
    {
        if (is_array($idGroupCreation)) {
            $useMinMax = false;
            if (isset($idGroupCreation['min'])) {
                $this->addUsingAlias(AuthyPeer::ID_GROUP_CREATION, $idGroupCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idGroupCreation['max'])) {
                $this->addUsingAlias(AuthyPeer::ID_GROUP_CREATION, $idGroupCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::ID_GROUP_CREATION, $idGroupCreation, $comparison);
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
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByIdCreation($idCreation = null, $comparison = null)
    {
        if (is_array($idCreation)) {
            $useMinMax = false;
            if (isset($idCreation['min'])) {
                $this->addUsingAlias(AuthyPeer::ID_CREATION, $idCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCreation['max'])) {
                $this->addUsingAlias(AuthyPeer::ID_CREATION, $idCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::ID_CREATION, $idCreation, $comparison);
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
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByIdModification($idModification = null, $comparison = null)
    {
        if (is_array($idModification)) {
            $useMinMax = false;
            if (isset($idModification['min'])) {
                $this->addUsingAlias(AuthyPeer::ID_MODIFICATION, $idModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idModification['max'])) {
                $this->addUsingAlias(AuthyPeer::ID_MODIFICATION, $idModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::ID_MODIFICATION, $idModification, $comparison);
    }

    /**
     * Filter the query by a related AuthyGroup object
     *
     * @param   AuthyGroup|PropelObjectCollection $authyGroup The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyGroupRelatedByIdAuthyGroup($authyGroup, $comparison = null)
    {
        if ($authyGroup instanceof AuthyGroup) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY_GROUP, $authyGroup->getIdAuthyGroup(), $comparison);
        } elseif ($authyGroup instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY_GROUP, $authyGroup->toKeyValue('PrimaryKey', 'IdAuthyGroup'), $comparison);
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
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinAuthyGroupRelatedByIdAuthyGroup($relationAlias = null, $joinType = 'LEFT JOIN')
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
    public function useAuthyGroupRelatedByIdAuthyGroupQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinAuthyGroupRelatedByIdAuthyGroup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuthyGroupRelatedByIdAuthyGroup', '\App\AuthyGroupQuery');
    }

    /**
     * Filter the query by a related AuthyGroup object
     *
     * @param   AuthyGroup|PropelObjectCollection $authyGroup The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyGroupRelatedByIdGroupCreation($authyGroup, $comparison = null)
    {
        if ($authyGroup instanceof AuthyGroup) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_GROUP_CREATION, $authyGroup->getIdAuthyGroup(), $comparison);
        } elseif ($authyGroup instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AuthyPeer::ID_GROUP_CREATION, $authyGroup->toKeyValue('PrimaryKey', 'IdAuthyGroup'), $comparison);
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
     * @return AuthyQuery The current query, for fluid interface
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
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyRelatedByIdCreation($authy, $comparison = null)
    {
        if ($authy instanceof Authy) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_CREATION, $authy->getIdAuthy(), $comparison);
        } elseif ($authy instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AuthyPeer::ID_CREATION, $authy->toKeyValue('PrimaryKey', 'IdAuthy'), $comparison);
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
     * @return AuthyQuery The current query, for fluid interface
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
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyRelatedByIdModification($authy, $comparison = null)
    {
        if ($authy instanceof Authy) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_MODIFICATION, $authy->getIdAuthy(), $comparison);
        } elseif ($authy instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AuthyPeer::ID_MODIFICATION, $authy->toKeyValue('PrimaryKey', 'IdAuthy'), $comparison);
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
     * @return AuthyQuery The current query, for fluid interface
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
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyGroupX($authyGroupX, $comparison = null)
    {
        if ($authyGroupX instanceof AuthyGroupX) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $authyGroupX->getIdAuthy(), $comparison);
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
     * @return AuthyQuery The current query, for fluid interface
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
     * Filter the query by a related AuthyLog object
     *
     * @param   AuthyLog|PropelObjectCollection $authyLog  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyLog($authyLog, $comparison = null)
    {
        if ($authyLog instanceof AuthyLog) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $authyLog->getIdAuthy(), $comparison);
        } elseif ($authyLog instanceof PropelObjectCollection) {
            return $this
                ->useAuthyLogQuery()
                ->filterByPrimaryKeys($authyLog->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAuthyLog() only accepts arguments of type AuthyLog or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuthyLog relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinAuthyLog($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuthyLog');

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
            $this->addJoinObject($join, 'AuthyLog');
        }

        return $this;
    }

    /**
     * Use the AuthyLog relation AuthyLog object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AuthyLogQuery A secondary query class using the current class as primary query
     */
    public function useAuthyLogQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAuthyLog($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuthyLog', '\App\AuthyLogQuery');
    }

    /**
     * Filter the query by a related Authy object
     *
     * @param   Authy|PropelObjectCollection $authy  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyRelatedByIdAuthy0($authy, $comparison = null)
    {
        if ($authy instanceof Authy) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $authy->getIdCreation(), $comparison);
        } elseif ($authy instanceof PropelObjectCollection) {
            return $this
                ->useAuthyRelatedByIdAuthy0Query()
                ->filterByPrimaryKeys($authy->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAuthyRelatedByIdAuthy0() only accepts arguments of type Authy or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuthyRelatedByIdAuthy0 relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinAuthyRelatedByIdAuthy0($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuthyRelatedByIdAuthy0');

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
            $this->addJoinObject($join, 'AuthyRelatedByIdAuthy0');
        }

        return $this;
    }

    /**
     * Use the AuthyRelatedByIdAuthy0 relation Authy object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AuthyQuery A secondary query class using the current class as primary query
     */
    public function useAuthyRelatedByIdAuthy0Query($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAuthyRelatedByIdAuthy0($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuthyRelatedByIdAuthy0', '\App\AuthyQuery');
    }

    /**
     * Filter the query by a related Authy object
     *
     * @param   Authy|PropelObjectCollection $authy  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyRelatedByIdAuthy1($authy, $comparison = null)
    {
        if ($authy instanceof Authy) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $authy->getIdModification(), $comparison);
        } elseif ($authy instanceof PropelObjectCollection) {
            return $this
                ->useAuthyRelatedByIdAuthy1Query()
                ->filterByPrimaryKeys($authy->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAuthyRelatedByIdAuthy1() only accepts arguments of type Authy or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuthyRelatedByIdAuthy1 relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinAuthyRelatedByIdAuthy1($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuthyRelatedByIdAuthy1');

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
            $this->addJoinObject($join, 'AuthyRelatedByIdAuthy1');
        }

        return $this;
    }

    /**
     * Use the AuthyRelatedByIdAuthy1 relation Authy object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AuthyQuery A secondary query class using the current class as primary query
     */
    public function useAuthyRelatedByIdAuthy1Query($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAuthyRelatedByIdAuthy1($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuthyRelatedByIdAuthy1', '\App\AuthyQuery');
    }

    /**
     * Filter the query by a related Country object
     *
     * @param   Country|PropelObjectCollection $country  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCountryRelatedByIdCreation($country, $comparison = null)
    {
        if ($country instanceof Country) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $country->getIdCreation(), $comparison);
        } elseif ($country instanceof PropelObjectCollection) {
            return $this
                ->useCountryRelatedByIdCreationQuery()
                ->filterByPrimaryKeys($country->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCountryRelatedByIdCreation() only accepts arguments of type Country or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CountryRelatedByIdCreation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinCountryRelatedByIdCreation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CountryRelatedByIdCreation');

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
            $this->addJoinObject($join, 'CountryRelatedByIdCreation');
        }

        return $this;
    }

    /**
     * Use the CountryRelatedByIdCreation relation Country object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\CountryQuery A secondary query class using the current class as primary query
     */
    public function useCountryRelatedByIdCreationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCountryRelatedByIdCreation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CountryRelatedByIdCreation', '\App\CountryQuery');
    }

    /**
     * Filter the query by a related Country object
     *
     * @param   Country|PropelObjectCollection $country  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCountryRelatedByIdModification($country, $comparison = null)
    {
        if ($country instanceof Country) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $country->getIdModification(), $comparison);
        } elseif ($country instanceof PropelObjectCollection) {
            return $this
                ->useCountryRelatedByIdModificationQuery()
                ->filterByPrimaryKeys($country->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCountryRelatedByIdModification() only accepts arguments of type Country or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CountryRelatedByIdModification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinCountryRelatedByIdModification($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CountryRelatedByIdModification');

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
            $this->addJoinObject($join, 'CountryRelatedByIdModification');
        }

        return $this;
    }

    /**
     * Use the CountryRelatedByIdModification relation Country object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\CountryQuery A secondary query class using the current class as primary query
     */
    public function useCountryRelatedByIdModificationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCountryRelatedByIdModification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CountryRelatedByIdModification', '\App\CountryQuery');
    }

    /**
     * Filter the query by a related Asset object
     *
     * @param   Asset|PropelObjectCollection $asset  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssetRelatedByIdCreation($asset, $comparison = null)
    {
        if ($asset instanceof Asset) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $asset->getIdCreation(), $comparison);
        } elseif ($asset instanceof PropelObjectCollection) {
            return $this
                ->useAssetRelatedByIdCreationQuery()
                ->filterByPrimaryKeys($asset->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAssetRelatedByIdCreation() only accepts arguments of type Asset or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AssetRelatedByIdCreation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinAssetRelatedByIdCreation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AssetRelatedByIdCreation');

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
            $this->addJoinObject($join, 'AssetRelatedByIdCreation');
        }

        return $this;
    }

    /**
     * Use the AssetRelatedByIdCreation relation Asset object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AssetQuery A secondary query class using the current class as primary query
     */
    public function useAssetRelatedByIdCreationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAssetRelatedByIdCreation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AssetRelatedByIdCreation', '\App\AssetQuery');
    }

    /**
     * Filter the query by a related Asset object
     *
     * @param   Asset|PropelObjectCollection $asset  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssetRelatedByIdModification($asset, $comparison = null)
    {
        if ($asset instanceof Asset) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $asset->getIdModification(), $comparison);
        } elseif ($asset instanceof PropelObjectCollection) {
            return $this
                ->useAssetRelatedByIdModificationQuery()
                ->filterByPrimaryKeys($asset->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAssetRelatedByIdModification() only accepts arguments of type Asset or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AssetRelatedByIdModification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinAssetRelatedByIdModification($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AssetRelatedByIdModification');

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
            $this->addJoinObject($join, 'AssetRelatedByIdModification');
        }

        return $this;
    }

    /**
     * Use the AssetRelatedByIdModification relation Asset object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AssetQuery A secondary query class using the current class as primary query
     */
    public function useAssetRelatedByIdModificationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAssetRelatedByIdModification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AssetRelatedByIdModification', '\App\AssetQuery');
    }

    /**
     * Filter the query by a related AssetExchange object
     *
     * @param   AssetExchange|PropelObjectCollection $assetExchange  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssetExchangeRelatedByIdCreation($assetExchange, $comparison = null)
    {
        if ($assetExchange instanceof AssetExchange) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $assetExchange->getIdCreation(), $comparison);
        } elseif ($assetExchange instanceof PropelObjectCollection) {
            return $this
                ->useAssetExchangeRelatedByIdCreationQuery()
                ->filterByPrimaryKeys($assetExchange->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAssetExchangeRelatedByIdCreation() only accepts arguments of type AssetExchange or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AssetExchangeRelatedByIdCreation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinAssetExchangeRelatedByIdCreation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AssetExchangeRelatedByIdCreation');

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
            $this->addJoinObject($join, 'AssetExchangeRelatedByIdCreation');
        }

        return $this;
    }

    /**
     * Use the AssetExchangeRelatedByIdCreation relation AssetExchange object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AssetExchangeQuery A secondary query class using the current class as primary query
     */
    public function useAssetExchangeRelatedByIdCreationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAssetExchangeRelatedByIdCreation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AssetExchangeRelatedByIdCreation', '\App\AssetExchangeQuery');
    }

    /**
     * Filter the query by a related AssetExchange object
     *
     * @param   AssetExchange|PropelObjectCollection $assetExchange  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssetExchangeRelatedByIdModification($assetExchange, $comparison = null)
    {
        if ($assetExchange instanceof AssetExchange) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $assetExchange->getIdModification(), $comparison);
        } elseif ($assetExchange instanceof PropelObjectCollection) {
            return $this
                ->useAssetExchangeRelatedByIdModificationQuery()
                ->filterByPrimaryKeys($assetExchange->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAssetExchangeRelatedByIdModification() only accepts arguments of type AssetExchange or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AssetExchangeRelatedByIdModification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinAssetExchangeRelatedByIdModification($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AssetExchangeRelatedByIdModification');

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
            $this->addJoinObject($join, 'AssetExchangeRelatedByIdModification');
        }

        return $this;
    }

    /**
     * Use the AssetExchangeRelatedByIdModification relation AssetExchange object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AssetExchangeQuery A secondary query class using the current class as primary query
     */
    public function useAssetExchangeRelatedByIdModificationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAssetExchangeRelatedByIdModification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AssetExchangeRelatedByIdModification', '\App\AssetExchangeQuery');
    }

    /**
     * Filter the query by a related Trade object
     *
     * @param   Trade|PropelObjectCollection $trade  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTradeRelatedByIdCreation($trade, $comparison = null)
    {
        if ($trade instanceof Trade) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $trade->getIdCreation(), $comparison);
        } elseif ($trade instanceof PropelObjectCollection) {
            return $this
                ->useTradeRelatedByIdCreationQuery()
                ->filterByPrimaryKeys($trade->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTradeRelatedByIdCreation() only accepts arguments of type Trade or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TradeRelatedByIdCreation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinTradeRelatedByIdCreation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TradeRelatedByIdCreation');

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
            $this->addJoinObject($join, 'TradeRelatedByIdCreation');
        }

        return $this;
    }

    /**
     * Use the TradeRelatedByIdCreation relation Trade object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\TradeQuery A secondary query class using the current class as primary query
     */
    public function useTradeRelatedByIdCreationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTradeRelatedByIdCreation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TradeRelatedByIdCreation', '\App\TradeQuery');
    }

    /**
     * Filter the query by a related Trade object
     *
     * @param   Trade|PropelObjectCollection $trade  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTradeRelatedByIdModification($trade, $comparison = null)
    {
        if ($trade instanceof Trade) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $trade->getIdModification(), $comparison);
        } elseif ($trade instanceof PropelObjectCollection) {
            return $this
                ->useTradeRelatedByIdModificationQuery()
                ->filterByPrimaryKeys($trade->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTradeRelatedByIdModification() only accepts arguments of type Trade or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TradeRelatedByIdModification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinTradeRelatedByIdModification($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TradeRelatedByIdModification');

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
            $this->addJoinObject($join, 'TradeRelatedByIdModification');
        }

        return $this;
    }

    /**
     * Use the TradeRelatedByIdModification relation Trade object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\TradeQuery A secondary query class using the current class as primary query
     */
    public function useTradeRelatedByIdModificationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTradeRelatedByIdModification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TradeRelatedByIdModification', '\App\TradeQuery');
    }

    /**
     * Filter the query by a related Exchange object
     *
     * @param   Exchange|PropelObjectCollection $exchange  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByExchangeRelatedByIdCreation($exchange, $comparison = null)
    {
        if ($exchange instanceof Exchange) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $exchange->getIdCreation(), $comparison);
        } elseif ($exchange instanceof PropelObjectCollection) {
            return $this
                ->useExchangeRelatedByIdCreationQuery()
                ->filterByPrimaryKeys($exchange->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByExchangeRelatedByIdCreation() only accepts arguments of type Exchange or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ExchangeRelatedByIdCreation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinExchangeRelatedByIdCreation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ExchangeRelatedByIdCreation');

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
            $this->addJoinObject($join, 'ExchangeRelatedByIdCreation');
        }

        return $this;
    }

    /**
     * Use the ExchangeRelatedByIdCreation relation Exchange object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\ExchangeQuery A secondary query class using the current class as primary query
     */
    public function useExchangeRelatedByIdCreationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinExchangeRelatedByIdCreation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ExchangeRelatedByIdCreation', '\App\ExchangeQuery');
    }

    /**
     * Filter the query by a related Exchange object
     *
     * @param   Exchange|PropelObjectCollection $exchange  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByExchangeRelatedByIdModification($exchange, $comparison = null)
    {
        if ($exchange instanceof Exchange) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $exchange->getIdModification(), $comparison);
        } elseif ($exchange instanceof PropelObjectCollection) {
            return $this
                ->useExchangeRelatedByIdModificationQuery()
                ->filterByPrimaryKeys($exchange->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByExchangeRelatedByIdModification() only accepts arguments of type Exchange or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ExchangeRelatedByIdModification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinExchangeRelatedByIdModification($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ExchangeRelatedByIdModification');

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
            $this->addJoinObject($join, 'ExchangeRelatedByIdModification');
        }

        return $this;
    }

    /**
     * Use the ExchangeRelatedByIdModification relation Exchange object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\ExchangeQuery A secondary query class using the current class as primary query
     */
    public function useExchangeRelatedByIdModificationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinExchangeRelatedByIdModification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ExchangeRelatedByIdModification', '\App\ExchangeQuery');
    }

    /**
     * Filter the query by a related Token object
     *
     * @param   Token|PropelObjectCollection $token  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTokenRelatedByIdCreation($token, $comparison = null)
    {
        if ($token instanceof Token) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $token->getIdCreation(), $comparison);
        } elseif ($token instanceof PropelObjectCollection) {
            return $this
                ->useTokenRelatedByIdCreationQuery()
                ->filterByPrimaryKeys($token->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTokenRelatedByIdCreation() only accepts arguments of type Token or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TokenRelatedByIdCreation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinTokenRelatedByIdCreation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TokenRelatedByIdCreation');

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
            $this->addJoinObject($join, 'TokenRelatedByIdCreation');
        }

        return $this;
    }

    /**
     * Use the TokenRelatedByIdCreation relation Token object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\TokenQuery A secondary query class using the current class as primary query
     */
    public function useTokenRelatedByIdCreationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTokenRelatedByIdCreation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TokenRelatedByIdCreation', '\App\TokenQuery');
    }

    /**
     * Filter the query by a related Token object
     *
     * @param   Token|PropelObjectCollection $token  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTokenRelatedByIdModification($token, $comparison = null)
    {
        if ($token instanceof Token) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $token->getIdModification(), $comparison);
        } elseif ($token instanceof PropelObjectCollection) {
            return $this
                ->useTokenRelatedByIdModificationQuery()
                ->filterByPrimaryKeys($token->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTokenRelatedByIdModification() only accepts arguments of type Token or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TokenRelatedByIdModification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinTokenRelatedByIdModification($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TokenRelatedByIdModification');

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
            $this->addJoinObject($join, 'TokenRelatedByIdModification');
        }

        return $this;
    }

    /**
     * Use the TokenRelatedByIdModification relation Token object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\TokenQuery A secondary query class using the current class as primary query
     */
    public function useTokenRelatedByIdModificationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTokenRelatedByIdModification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TokenRelatedByIdModification', '\App\TokenQuery');
    }

    /**
     * Filter the query by a related Symbol object
     *
     * @param   Symbol|PropelObjectCollection $symbol  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySymbolRelatedByIdCreation($symbol, $comparison = null)
    {
        if ($symbol instanceof Symbol) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $symbol->getIdCreation(), $comparison);
        } elseif ($symbol instanceof PropelObjectCollection) {
            return $this
                ->useSymbolRelatedByIdCreationQuery()
                ->filterByPrimaryKeys($symbol->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySymbolRelatedByIdCreation() only accepts arguments of type Symbol or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SymbolRelatedByIdCreation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinSymbolRelatedByIdCreation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SymbolRelatedByIdCreation');

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
            $this->addJoinObject($join, 'SymbolRelatedByIdCreation');
        }

        return $this;
    }

    /**
     * Use the SymbolRelatedByIdCreation relation Symbol object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\SymbolQuery A secondary query class using the current class as primary query
     */
    public function useSymbolRelatedByIdCreationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSymbolRelatedByIdCreation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SymbolRelatedByIdCreation', '\App\SymbolQuery');
    }

    /**
     * Filter the query by a related Symbol object
     *
     * @param   Symbol|PropelObjectCollection $symbol  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySymbolRelatedByIdModification($symbol, $comparison = null)
    {
        if ($symbol instanceof Symbol) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $symbol->getIdModification(), $comparison);
        } elseif ($symbol instanceof PropelObjectCollection) {
            return $this
                ->useSymbolRelatedByIdModificationQuery()
                ->filterByPrimaryKeys($symbol->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySymbolRelatedByIdModification() only accepts arguments of type Symbol or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SymbolRelatedByIdModification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinSymbolRelatedByIdModification($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SymbolRelatedByIdModification');

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
            $this->addJoinObject($join, 'SymbolRelatedByIdModification');
        }

        return $this;
    }

    /**
     * Use the SymbolRelatedByIdModification relation Symbol object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\SymbolQuery A secondary query class using the current class as primary query
     */
    public function useSymbolRelatedByIdModificationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSymbolRelatedByIdModification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SymbolRelatedByIdModification', '\App\SymbolQuery');
    }

    /**
     * Filter the query by a related AuthyGroup object
     *
     * @param   AuthyGroup|PropelObjectCollection $authyGroup  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyGroupRelatedByIdCreation($authyGroup, $comparison = null)
    {
        if ($authyGroup instanceof AuthyGroup) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $authyGroup->getIdCreation(), $comparison);
        } elseif ($authyGroup instanceof PropelObjectCollection) {
            return $this
                ->useAuthyGroupRelatedByIdCreationQuery()
                ->filterByPrimaryKeys($authyGroup->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAuthyGroupRelatedByIdCreation() only accepts arguments of type AuthyGroup or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuthyGroupRelatedByIdCreation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinAuthyGroupRelatedByIdCreation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuthyGroupRelatedByIdCreation');

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
            $this->addJoinObject($join, 'AuthyGroupRelatedByIdCreation');
        }

        return $this;
    }

    /**
     * Use the AuthyGroupRelatedByIdCreation relation AuthyGroup object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AuthyGroupQuery A secondary query class using the current class as primary query
     */
    public function useAuthyGroupRelatedByIdCreationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAuthyGroupRelatedByIdCreation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuthyGroupRelatedByIdCreation', '\App\AuthyGroupQuery');
    }

    /**
     * Filter the query by a related AuthyGroup object
     *
     * @param   AuthyGroup|PropelObjectCollection $authyGroup  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyGroupRelatedByIdModification($authyGroup, $comparison = null)
    {
        if ($authyGroup instanceof AuthyGroup) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $authyGroup->getIdModification(), $comparison);
        } elseif ($authyGroup instanceof PropelObjectCollection) {
            return $this
                ->useAuthyGroupRelatedByIdModificationQuery()
                ->filterByPrimaryKeys($authyGroup->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAuthyGroupRelatedByIdModification() only accepts arguments of type AuthyGroup or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuthyGroupRelatedByIdModification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinAuthyGroupRelatedByIdModification($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuthyGroupRelatedByIdModification');

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
            $this->addJoinObject($join, 'AuthyGroupRelatedByIdModification');
        }

        return $this;
    }

    /**
     * Use the AuthyGroupRelatedByIdModification relation AuthyGroup object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\AuthyGroupQuery A secondary query class using the current class as primary query
     */
    public function useAuthyGroupRelatedByIdModificationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAuthyGroupRelatedByIdModification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuthyGroupRelatedByIdModification', '\App\AuthyGroupQuery');
    }

    /**
     * Filter the query by a related Config object
     *
     * @param   Config|PropelObjectCollection $config  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByConfigRelatedByIdCreation($config, $comparison = null)
    {
        if ($config instanceof Config) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $config->getIdCreation(), $comparison);
        } elseif ($config instanceof PropelObjectCollection) {
            return $this
                ->useConfigRelatedByIdCreationQuery()
                ->filterByPrimaryKeys($config->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByConfigRelatedByIdCreation() only accepts arguments of type Config or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ConfigRelatedByIdCreation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinConfigRelatedByIdCreation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ConfigRelatedByIdCreation');

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
            $this->addJoinObject($join, 'ConfigRelatedByIdCreation');
        }

        return $this;
    }

    /**
     * Use the ConfigRelatedByIdCreation relation Config object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\ConfigQuery A secondary query class using the current class as primary query
     */
    public function useConfigRelatedByIdCreationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinConfigRelatedByIdCreation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ConfigRelatedByIdCreation', '\App\ConfigQuery');
    }

    /**
     * Filter the query by a related Config object
     *
     * @param   Config|PropelObjectCollection $config  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByConfigRelatedByIdModification($config, $comparison = null)
    {
        if ($config instanceof Config) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $config->getIdModification(), $comparison);
        } elseif ($config instanceof PropelObjectCollection) {
            return $this
                ->useConfigRelatedByIdModificationQuery()
                ->filterByPrimaryKeys($config->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByConfigRelatedByIdModification() only accepts arguments of type Config or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ConfigRelatedByIdModification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinConfigRelatedByIdModification($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ConfigRelatedByIdModification');

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
            $this->addJoinObject($join, 'ConfigRelatedByIdModification');
        }

        return $this;
    }

    /**
     * Use the ConfigRelatedByIdModification relation Config object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\ConfigQuery A secondary query class using the current class as primary query
     */
    public function useConfigRelatedByIdModificationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinConfigRelatedByIdModification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ConfigRelatedByIdModification', '\App\ConfigQuery');
    }

    /**
     * Filter the query by a related ApiRbac object
     *
     * @param   ApiRbac|PropelObjectCollection $apiRbac  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByApiRbacRelatedByIdCreation($apiRbac, $comparison = null)
    {
        if ($apiRbac instanceof ApiRbac) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $apiRbac->getIdCreation(), $comparison);
        } elseif ($apiRbac instanceof PropelObjectCollection) {
            return $this
                ->useApiRbacRelatedByIdCreationQuery()
                ->filterByPrimaryKeys($apiRbac->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByApiRbacRelatedByIdCreation() only accepts arguments of type ApiRbac or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ApiRbacRelatedByIdCreation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinApiRbacRelatedByIdCreation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ApiRbacRelatedByIdCreation');

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
            $this->addJoinObject($join, 'ApiRbacRelatedByIdCreation');
        }

        return $this;
    }

    /**
     * Use the ApiRbacRelatedByIdCreation relation ApiRbac object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\ApiRbacQuery A secondary query class using the current class as primary query
     */
    public function useApiRbacRelatedByIdCreationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinApiRbacRelatedByIdCreation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ApiRbacRelatedByIdCreation', '\App\ApiRbacQuery');
    }

    /**
     * Filter the query by a related ApiRbac object
     *
     * @param   ApiRbac|PropelObjectCollection $apiRbac  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByApiRbacRelatedByIdModification($apiRbac, $comparison = null)
    {
        if ($apiRbac instanceof ApiRbac) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $apiRbac->getIdModification(), $comparison);
        } elseif ($apiRbac instanceof PropelObjectCollection) {
            return $this
                ->useApiRbacRelatedByIdModificationQuery()
                ->filterByPrimaryKeys($apiRbac->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByApiRbacRelatedByIdModification() only accepts arguments of type ApiRbac or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ApiRbacRelatedByIdModification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinApiRbacRelatedByIdModification($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ApiRbacRelatedByIdModification');

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
            $this->addJoinObject($join, 'ApiRbacRelatedByIdModification');
        }

        return $this;
    }

    /**
     * Use the ApiRbacRelatedByIdModification relation ApiRbac object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\ApiRbacQuery A secondary query class using the current class as primary query
     */
    public function useApiRbacRelatedByIdModificationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinApiRbacRelatedByIdModification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ApiRbacRelatedByIdModification', '\App\ApiRbacQuery');
    }

    /**
     * Filter the query by a related ApiLog object
     *
     * @param   ApiLog|PropelObjectCollection $apiLog  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByApiLog($apiLog, $comparison = null)
    {
        if ($apiLog instanceof ApiLog) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $apiLog->getIdAuthy(), $comparison);
        } elseif ($apiLog instanceof PropelObjectCollection) {
            return $this
                ->useApiLogQuery()
                ->filterByPrimaryKeys($apiLog->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByApiLog() only accepts arguments of type ApiLog or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ApiLog relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinApiLog($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ApiLog');

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
            $this->addJoinObject($join, 'ApiLog');
        }

        return $this;
    }

    /**
     * Use the ApiLog relation ApiLog object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\ApiLogQuery A secondary query class using the current class as primary query
     */
    public function useApiLogQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinApiLog($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ApiLog', '\App\ApiLogQuery');
    }

    /**
     * Filter the query by a related Template object
     *
     * @param   Template|PropelObjectCollection $template  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTemplateRelatedByIdCreation($template, $comparison = null)
    {
        if ($template instanceof Template) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $template->getIdCreation(), $comparison);
        } elseif ($template instanceof PropelObjectCollection) {
            return $this
                ->useTemplateRelatedByIdCreationQuery()
                ->filterByPrimaryKeys($template->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTemplateRelatedByIdCreation() only accepts arguments of type Template or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TemplateRelatedByIdCreation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinTemplateRelatedByIdCreation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TemplateRelatedByIdCreation');

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
            $this->addJoinObject($join, 'TemplateRelatedByIdCreation');
        }

        return $this;
    }

    /**
     * Use the TemplateRelatedByIdCreation relation Template object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\TemplateQuery A secondary query class using the current class as primary query
     */
    public function useTemplateRelatedByIdCreationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTemplateRelatedByIdCreation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TemplateRelatedByIdCreation', '\App\TemplateQuery');
    }

    /**
     * Filter the query by a related Template object
     *
     * @param   Template|PropelObjectCollection $template  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTemplateRelatedByIdModification($template, $comparison = null)
    {
        if ($template instanceof Template) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $template->getIdModification(), $comparison);
        } elseif ($template instanceof PropelObjectCollection) {
            return $this
                ->useTemplateRelatedByIdModificationQuery()
                ->filterByPrimaryKeys($template->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTemplateRelatedByIdModification() only accepts arguments of type Template or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TemplateRelatedByIdModification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinTemplateRelatedByIdModification($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TemplateRelatedByIdModification');

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
            $this->addJoinObject($join, 'TemplateRelatedByIdModification');
        }

        return $this;
    }

    /**
     * Use the TemplateRelatedByIdModification relation Template object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\TemplateQuery A secondary query class using the current class as primary query
     */
    public function useTemplateRelatedByIdModificationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTemplateRelatedByIdModification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TemplateRelatedByIdModification', '\App\TemplateQuery');
    }

    /**
     * Filter the query by a related TemplateFile object
     *
     * @param   TemplateFile|PropelObjectCollection $templateFile  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTemplateFileRelatedByIdCreation($templateFile, $comparison = null)
    {
        if ($templateFile instanceof TemplateFile) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $templateFile->getIdCreation(), $comparison);
        } elseif ($templateFile instanceof PropelObjectCollection) {
            return $this
                ->useTemplateFileRelatedByIdCreationQuery()
                ->filterByPrimaryKeys($templateFile->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTemplateFileRelatedByIdCreation() only accepts arguments of type TemplateFile or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TemplateFileRelatedByIdCreation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinTemplateFileRelatedByIdCreation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TemplateFileRelatedByIdCreation');

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
            $this->addJoinObject($join, 'TemplateFileRelatedByIdCreation');
        }

        return $this;
    }

    /**
     * Use the TemplateFileRelatedByIdCreation relation TemplateFile object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\TemplateFileQuery A secondary query class using the current class as primary query
     */
    public function useTemplateFileRelatedByIdCreationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTemplateFileRelatedByIdCreation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TemplateFileRelatedByIdCreation', '\App\TemplateFileQuery');
    }

    /**
     * Filter the query by a related TemplateFile object
     *
     * @param   TemplateFile|PropelObjectCollection $templateFile  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTemplateFileRelatedByIdModification($templateFile, $comparison = null)
    {
        if ($templateFile instanceof TemplateFile) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $templateFile->getIdModification(), $comparison);
        } elseif ($templateFile instanceof PropelObjectCollection) {
            return $this
                ->useTemplateFileRelatedByIdModificationQuery()
                ->filterByPrimaryKeys($templateFile->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTemplateFileRelatedByIdModification() only accepts arguments of type TemplateFile or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TemplateFileRelatedByIdModification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinTemplateFileRelatedByIdModification($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TemplateFileRelatedByIdModification');

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
            $this->addJoinObject($join, 'TemplateFileRelatedByIdModification');
        }

        return $this;
    }

    /**
     * Use the TemplateFileRelatedByIdModification relation TemplateFile object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\TemplateFileQuery A secondary query class using the current class as primary query
     */
    public function useTemplateFileRelatedByIdModificationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTemplateFileRelatedByIdModification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TemplateFileRelatedByIdModification', '\App\TemplateFileQuery');
    }

    /**
     * Filter the query by a related MessageI18n object
     *
     * @param   MessageI18n|PropelObjectCollection $messageI18n  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMessageI18nRelatedByIdCreation($messageI18n, $comparison = null)
    {
        if ($messageI18n instanceof MessageI18n) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $messageI18n->getIdCreation(), $comparison);
        } elseif ($messageI18n instanceof PropelObjectCollection) {
            return $this
                ->useMessageI18nRelatedByIdCreationQuery()
                ->filterByPrimaryKeys($messageI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMessageI18nRelatedByIdCreation() only accepts arguments of type MessageI18n or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MessageI18nRelatedByIdCreation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinMessageI18nRelatedByIdCreation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MessageI18nRelatedByIdCreation');

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
            $this->addJoinObject($join, 'MessageI18nRelatedByIdCreation');
        }

        return $this;
    }

    /**
     * Use the MessageI18nRelatedByIdCreation relation MessageI18n object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\MessageI18nQuery A secondary query class using the current class as primary query
     */
    public function useMessageI18nRelatedByIdCreationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMessageI18nRelatedByIdCreation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MessageI18nRelatedByIdCreation', '\App\MessageI18nQuery');
    }

    /**
     * Filter the query by a related MessageI18n object
     *
     * @param   MessageI18n|PropelObjectCollection $messageI18n  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMessageI18nRelatedByIdModification($messageI18n, $comparison = null)
    {
        if ($messageI18n instanceof MessageI18n) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $messageI18n->getIdModification(), $comparison);
        } elseif ($messageI18n instanceof PropelObjectCollection) {
            return $this
                ->useMessageI18nRelatedByIdModificationQuery()
                ->filterByPrimaryKeys($messageI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMessageI18nRelatedByIdModification() only accepts arguments of type MessageI18n or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MessageI18nRelatedByIdModification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinMessageI18nRelatedByIdModification($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MessageI18nRelatedByIdModification');

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
            $this->addJoinObject($join, 'MessageI18nRelatedByIdModification');
        }

        return $this;
    }

    /**
     * Use the MessageI18nRelatedByIdModification relation MessageI18n object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \App\MessageI18nQuery A secondary query class using the current class as primary query
     */
    public function useMessageI18nRelatedByIdModificationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMessageI18nRelatedByIdModification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MessageI18nRelatedByIdModification', '\App\MessageI18nQuery');
    }

    /**
     * Filter the query by a related AuthyGroup object
     * using the authy_group_x table as cross reference
     *
     * @param   AuthyGroup $authyGroup the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   AuthyQuery The current query, for fluid interface
     */
    public function filterByRelAuthyGroup($authyGroup, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useAuthyGroupXQuery()
            ->filterByAuthyGroup($authyGroup, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   Authy $authy Object to remove from the list of results
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function prune($authy = null)
    {
        if ($authy) {
            $this->addUsingAlias(AuthyPeer::ID_AUTHY, $authy->getIdAuthy(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // add_tablestamp behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     AuthyQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7){
        return $this->addUsingAlias(AuthyPeer::DATE_MODIFICATION, time() - $nbDays * 24 * 60 * 60, \Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     AuthyQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst(){
        return $this->addDescendingOrderByColumn(AuthyPeer::DATE_MODIFICATION);
    }

    /**
     * Order by update date asc
     *
     * @return     AuthyQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst(){
        return $this->addAscendingOrderByColumn(AuthyPeer::DATE_MODIFICATION);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     AuthyQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7){
        return $this->addUsingAlias(AuthyPeer::DATE_CREATION, time() - $nbDays * 24 * 60 * 60, \Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     AuthyQuery The current query, for fluid interface
     */
    public function lastCreatedFirst(){
        return $this->addDescendingOrderByColumn(AuthyPeer::DATE_CREATION);
    }

    /**
     * Order by create date asc
     *
     * @return     AuthyQuery The current query, for fluid interface
     */
    public function firstCreatedFirst(){
        return $this->addAscendingOrderByColumn(AuthyPeer::DATE_CREATION);
    }
}
