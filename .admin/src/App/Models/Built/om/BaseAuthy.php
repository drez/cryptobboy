<?php

namespace App\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use App\ApiLog;
use App\ApiLogQuery;
use App\ApiRbac;
use App\ApiRbacQuery;
use App\Asset;
use App\AssetExchange;
use App\AssetExchangeQuery;
use App\AssetQuery;
use App\Authy;
use App\AuthyGroup;
use App\AuthyGroupQuery;
use App\AuthyGroupX;
use App\AuthyGroupXQuery;
use App\AuthyLog;
use App\AuthyLogQuery;
use App\AuthyPeer;
use App\AuthyQuery;
use App\Config;
use App\ConfigQuery;
use App\Country;
use App\CountryQuery;
use App\Exchange;
use App\ExchangeQuery;
use App\Import;
use App\ImportQuery;
use App\MessageI18n;
use App\MessageI18nQuery;
use App\Symbol;
use App\SymbolQuery;
use App\Template;
use App\TemplateFile;
use App\TemplateFileQuery;
use App\TemplateQuery;
use App\Token;
use App\TokenQuery;
use App\Trade;
use App\TradeQuery;

/**
 * Base class that represents a row from the 'authy' table.
 *
 * User
 *
 * @package    propel.generator..om
 */
abstract class BaseAuthy extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'App\\AuthyPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AuthyPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_authy field.
     * @var        int
     */
    protected $id_authy;

    /**
     * The value for the validation_key field.
     * @var        string
     */
    protected $validation_key;

    /**
     * The value for the username field.
     * @var        string
     */
    protected $username;

    /**
     * The value for the fullname field.
     * @var        string
     */
    protected $fullname;

    /**
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the passwd_hash field.
     * @var        string
     */
    protected $passwd_hash;

    /**
     * The value for the expire field.
     * Note: this column has a database default value of: NULL
     * @var        string
     */
    protected $expire;

    /**
     * The value for the deactivate field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $deactivate;

    /**
     * The value for the is_root field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $is_root;

    /**
     * The value for the id_authy_group field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $id_authy_group;

    /**
     * The value for the is_system field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $is_system;

    /**
     * The value for the rights_all field.
     * @var        string
     */
    protected $rights_all;

    /**
     * The value for the rights_group field.
     * @var        string
     */
    protected $rights_group;

    /**
     * The value for the rights_owner field.
     * @var        string
     */
    protected $rights_owner;

    /**
     * The value for the onglet field.
     * @var        string
     */
    protected $onglet;

    /**
     * The value for the date_creation field.
     * @var        string
     */
    protected $date_creation;

    /**
     * The value for the date_modification field.
     * @var        string
     */
    protected $date_modification;

    /**
     * The value for the id_group_creation field.
     * @var        int
     */
    protected $id_group_creation;

    /**
     * The value for the id_creation field.
     * @var        int
     */
    protected $id_creation;

    /**
     * The value for the id_modification field.
     * @var        int
     */
    protected $id_modification;

    /**
     * @var        AuthyGroup
     */
    protected $aAuthyGroupRelatedByIdAuthyGroup;

    /**
     * @var        AuthyGroup
     */
    protected $aAuthyGroupRelatedByIdGroupCreation;

    /**
     * @var        Authy
     */
    protected $aAuthyRelatedByIdCreation;

    /**
     * @var        Authy
     */
    protected $aAuthyRelatedByIdModification;

    /**
     * @var        PropelObjectCollection|AuthyGroupX[] Collection to store aggregation of AuthyGroupX objects.
     */
    protected $collAuthyGroupxes;
    protected $collAuthyGroupxesPartial;

    /**
     * @var        PropelObjectCollection|AuthyLog[] Collection to store aggregation of AuthyLog objects.
     */
    protected $collAuthyLogs;
    protected $collAuthyLogsPartial;

    /**
     * @var        PropelObjectCollection|Authy[] Collection to store aggregation of Authy objects.
     */
    protected $collAuthiesRelatedByIdAuthy0;
    protected $collAuthiesRelatedByIdAuthy0Partial;

    /**
     * @var        PropelObjectCollection|Authy[] Collection to store aggregation of Authy objects.
     */
    protected $collAuthiesRelatedByIdAuthy1;
    protected $collAuthiesRelatedByIdAuthy1Partial;

    /**
     * @var        PropelObjectCollection|Country[] Collection to store aggregation of Country objects.
     */
    protected $collCountriesRelatedByIdCreation;
    protected $collCountriesRelatedByIdCreationPartial;

    /**
     * @var        PropelObjectCollection|Country[] Collection to store aggregation of Country objects.
     */
    protected $collCountriesRelatedByIdModification;
    protected $collCountriesRelatedByIdModificationPartial;

    /**
     * @var        PropelObjectCollection|Asset[] Collection to store aggregation of Asset objects.
     */
    protected $collAssetsRelatedByIdCreation;
    protected $collAssetsRelatedByIdCreationPartial;

    /**
     * @var        PropelObjectCollection|Asset[] Collection to store aggregation of Asset objects.
     */
    protected $collAssetsRelatedByIdModification;
    protected $collAssetsRelatedByIdModificationPartial;

    /**
     * @var        PropelObjectCollection|AssetExchange[] Collection to store aggregation of AssetExchange objects.
     */
    protected $collAssetExchangesRelatedByIdCreation;
    protected $collAssetExchangesRelatedByIdCreationPartial;

    /**
     * @var        PropelObjectCollection|AssetExchange[] Collection to store aggregation of AssetExchange objects.
     */
    protected $collAssetExchangesRelatedByIdModification;
    protected $collAssetExchangesRelatedByIdModificationPartial;

    /**
     * @var        PropelObjectCollection|Trade[] Collection to store aggregation of Trade objects.
     */
    protected $collTradesRelatedByIdCreation;
    protected $collTradesRelatedByIdCreationPartial;

    /**
     * @var        PropelObjectCollection|Trade[] Collection to store aggregation of Trade objects.
     */
    protected $collTradesRelatedByIdModification;
    protected $collTradesRelatedByIdModificationPartial;

    /**
     * @var        PropelObjectCollection|Exchange[] Collection to store aggregation of Exchange objects.
     */
    protected $collExchangesRelatedByIdCreation;
    protected $collExchangesRelatedByIdCreationPartial;

    /**
     * @var        PropelObjectCollection|Exchange[] Collection to store aggregation of Exchange objects.
     */
    protected $collExchangesRelatedByIdModification;
    protected $collExchangesRelatedByIdModificationPartial;

    /**
     * @var        PropelObjectCollection|Token[] Collection to store aggregation of Token objects.
     */
    protected $collTokensRelatedByIdCreation;
    protected $collTokensRelatedByIdCreationPartial;

    /**
     * @var        PropelObjectCollection|Token[] Collection to store aggregation of Token objects.
     */
    protected $collTokensRelatedByIdModification;
    protected $collTokensRelatedByIdModificationPartial;

    /**
     * @var        PropelObjectCollection|Symbol[] Collection to store aggregation of Symbol objects.
     */
    protected $collSymbolsRelatedByIdCreation;
    protected $collSymbolsRelatedByIdCreationPartial;

    /**
     * @var        PropelObjectCollection|Symbol[] Collection to store aggregation of Symbol objects.
     */
    protected $collSymbolsRelatedByIdModification;
    protected $collSymbolsRelatedByIdModificationPartial;

    /**
     * @var        PropelObjectCollection|Import[] Collection to store aggregation of Import objects.
     */
    protected $collImportsRelatedByIdCreation;
    protected $collImportsRelatedByIdCreationPartial;

    /**
     * @var        PropelObjectCollection|Import[] Collection to store aggregation of Import objects.
     */
    protected $collImportsRelatedByIdModification;
    protected $collImportsRelatedByIdModificationPartial;

    /**
     * @var        PropelObjectCollection|AuthyGroup[] Collection to store aggregation of AuthyGroup objects.
     */
    protected $collAuthyGroupsRelatedByIdCreation;
    protected $collAuthyGroupsRelatedByIdCreationPartial;

    /**
     * @var        PropelObjectCollection|AuthyGroup[] Collection to store aggregation of AuthyGroup objects.
     */
    protected $collAuthyGroupsRelatedByIdModification;
    protected $collAuthyGroupsRelatedByIdModificationPartial;

    /**
     * @var        PropelObjectCollection|Config[] Collection to store aggregation of Config objects.
     */
    protected $collConfigsRelatedByIdCreation;
    protected $collConfigsRelatedByIdCreationPartial;

    /**
     * @var        PropelObjectCollection|Config[] Collection to store aggregation of Config objects.
     */
    protected $collConfigsRelatedByIdModification;
    protected $collConfigsRelatedByIdModificationPartial;

    /**
     * @var        PropelObjectCollection|ApiRbac[] Collection to store aggregation of ApiRbac objects.
     */
    protected $collApiRbacsRelatedByIdCreation;
    protected $collApiRbacsRelatedByIdCreationPartial;

    /**
     * @var        PropelObjectCollection|ApiRbac[] Collection to store aggregation of ApiRbac objects.
     */
    protected $collApiRbacsRelatedByIdModification;
    protected $collApiRbacsRelatedByIdModificationPartial;

    /**
     * @var        PropelObjectCollection|ApiLog[] Collection to store aggregation of ApiLog objects.
     */
    protected $collApiLogs;
    protected $collApiLogsPartial;

    /**
     * @var        PropelObjectCollection|Template[] Collection to store aggregation of Template objects.
     */
    protected $collTemplatesRelatedByIdCreation;
    protected $collTemplatesRelatedByIdCreationPartial;

    /**
     * @var        PropelObjectCollection|Template[] Collection to store aggregation of Template objects.
     */
    protected $collTemplatesRelatedByIdModification;
    protected $collTemplatesRelatedByIdModificationPartial;

    /**
     * @var        PropelObjectCollection|TemplateFile[] Collection to store aggregation of TemplateFile objects.
     */
    protected $collTemplateFilesRelatedByIdCreation;
    protected $collTemplateFilesRelatedByIdCreationPartial;

    /**
     * @var        PropelObjectCollection|TemplateFile[] Collection to store aggregation of TemplateFile objects.
     */
    protected $collTemplateFilesRelatedByIdModification;
    protected $collTemplateFilesRelatedByIdModificationPartial;

    /**
     * @var        PropelObjectCollection|MessageI18n[] Collection to store aggregation of MessageI18n objects.
     */
    protected $collMessageI18nsRelatedByIdCreation;
    protected $collMessageI18nsRelatedByIdCreationPartial;

    /**
     * @var        PropelObjectCollection|MessageI18n[] Collection to store aggregation of MessageI18n objects.
     */
    protected $collMessageI18nsRelatedByIdModification;
    protected $collMessageI18nsRelatedByIdModificationPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $authyGroupxesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $authyLogsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $authiesRelatedByIdAuthy0ScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $authiesRelatedByIdAuthy1ScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $countriesRelatedByIdCreationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $countriesRelatedByIdModificationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $assetsRelatedByIdCreationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $assetsRelatedByIdModificationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $assetExchangesRelatedByIdCreationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $assetExchangesRelatedByIdModificationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $tradesRelatedByIdCreationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $tradesRelatedByIdModificationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $exchangesRelatedByIdCreationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $exchangesRelatedByIdModificationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $tokensRelatedByIdCreationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $tokensRelatedByIdModificationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $symbolsRelatedByIdCreationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $symbolsRelatedByIdModificationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $importsRelatedByIdCreationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $importsRelatedByIdModificationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $authyGroupsRelatedByIdCreationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $authyGroupsRelatedByIdModificationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $configsRelatedByIdCreationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $configsRelatedByIdModificationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $apiRbacsRelatedByIdCreationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $apiRbacsRelatedByIdModificationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $apiLogsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $templatesRelatedByIdCreationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $templatesRelatedByIdModificationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $templateFilesRelatedByIdCreationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $templateFilesRelatedByIdModificationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $messageI18nsRelatedByIdCreationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $messageI18nsRelatedByIdModificationScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->expire = NULL;
        $this->deactivate = 1;
        $this->is_root = 1;
        $this->id_authy_group = 1;
        $this->is_system = 1;
    }

    /**
     * Initializes internal state of BaseAuthy object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * @Field()
     * Get the [id_authy] column value.
     *
     * @return int
     */
    public function getIdAuthy()
    {

        return $this->id_authy;
    }

    /**
     * @Field()
     * Get the [validation_key] column value.
     *
     * @return string
     */
    public function getValidationKey()
    {

        return $this->validation_key;
    }

    /**
     * @Field()
     * Get the [username] column value.
     * Username
     * @return string
     */
    public function getUsername()
    {

        return $this->username;
    }

    /**
     * @Field()
     * Get the [fullname] column value.
     * Fullname
     * @return string
     */
    public function getFullname()
    {

        return $this->fullname;
    }

    /**
     * @Field()
     * Get the [email] column value.
     * Email
     * @return string
     */
    public function getEmail()
    {

        return $this->email;
    }

    /**
     * @Field()
     * Get the [passwd_hash] column value.
     * Password
     * @return string
     */
    public function getPasswdHash()
    {

        return $this->passwd_hash;
    }

    /**
     * @Field()
     * Get the [optionally formatted] temporal [expire] column value.
     * Expiration
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getExpire($format = 'Y-m-d')
    {
        if ($this->expire === null) {
            return null;
        }

        if ($this->expire === '0000-00-00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->expire);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->expire, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * @Field()
     * Get the [deactivate] column value.
     * Deactivated
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getDeactivate()
    {
        if (null === $this->deactivate) {
            return null;
        }
        $valueSet = AuthyPeer::getValueSet(AuthyPeer::DEACTIVATE);
        if (!isset($valueSet[$this->deactivate])) {
            throw new PropelException('Unknown stored enum key: ' . $this->deactivate);
        }

        return $valueSet[$this->deactivate];
    }

    /**
     * @Field()
     * Get the [is_root] column value.
     *
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getIsRoot()
    {
        if (null === $this->is_root) {
            return null;
        }
        $valueSet = AuthyPeer::getValueSet(AuthyPeer::IS_ROOT);
        if (!isset($valueSet[$this->is_root])) {
            throw new PropelException('Unknown stored enum key: ' . $this->is_root);
        }

        return $valueSet[$this->is_root];
    }

    /**
     * @Field()
     * Get the [id_authy_group] column value.
     * Primary group
     * @return int
     */
    public function getIdAuthyGroup()
    {

        return $this->id_authy_group;
    }

    /**
     * @Field()
     * Get the [is_system] column value.
     *
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getIsSystem()
    {
        if (null === $this->is_system) {
            return null;
        }
        $valueSet = AuthyPeer::getValueSet(AuthyPeer::IS_SYSTEM);
        if (!isset($valueSet[$this->is_system])) {
            throw new PropelException('Unknown stored enum key: ' . $this->is_system);
        }

        return $valueSet[$this->is_system];
    }

    /**
     * @Field()
     * Get the [rights_all] column value.
     * Rights
     * @return string
     */
    public function getRightsAll()
    {

        return $this->rights_all;
    }

    /**
     * @Field()
     * Get the [rights_group] column value.
     * Rights group
     * @return string
     */
    public function getRightsGroup()
    {

        return $this->rights_group;
    }

    /**
     * @Field()
     * Get the [rights_owner] column value.
     * Rights owner
     * @return string
     */
    public function getRightsOwner()
    {

        return $this->rights_owner;
    }

    /**
     * @Field()
     * Get the [onglet] column value.
     *
     * @return string
     */
    public function getOnglet()
    {

        return $this->onglet;
    }

    /**
     * @Field()
     * Get the [optionally formatted] temporal [date_creation] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateCreation($format = 'Y-m-d H:i:s')
    {
        if ($this->date_creation === null) {
            return null;
        }

        if ($this->date_creation === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->date_creation);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date_creation, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * @Field()
     * Get the [optionally formatted] temporal [date_modification] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateModification($format = 'Y-m-d H:i:s')
    {
        if ($this->date_modification === null) {
            return null;
        }

        if ($this->date_modification === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->date_modification);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date_modification, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * @Field()
     * Get the [id_group_creation] column value.
     *
     * @return int
     */
    public function getIdGroupCreation()
    {

        return $this->id_group_creation;
    }

    /**
     * @Field()
     * Get the [id_creation] column value.
     *
     * @return int
     */
    public function getIdCreation()
    {

        return $this->id_creation;
    }

    /**
     * @Field()
     * Get the [id_modification] column value.
     *
     * @return int
     */
    public function getIdModification()
    {

        return $this->id_modification;
    }

    /**
     * Set the value of [id_authy] column.
     *
     * @param  int $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setIdAuthy($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_authy !== $v) {
            $this->id_authy = $v;
            $this->modifiedColumns[] = AuthyPeer::ID_AUTHY;
        }


        return $this;
    } // setIdAuthy()

    /**
     * Set the value of [validation_key] column.
     *
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setValidationKey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->validation_key !== $v) {
            $this->validation_key = $v;
            $this->modifiedColumns[] = AuthyPeer::VALIDATION_KEY;
        }


        return $this;
    } // setValidationKey()

    /**
     * Set the value of [username] column.
     * Username
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[] = AuthyPeer::USERNAME;
        }


        return $this;
    } // setUsername()

    /**
     * Set the value of [fullname] column.
     * Fullname
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setFullname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->fullname !== $v) {
            $this->fullname = $v;
            $this->modifiedColumns[] = AuthyPeer::FULLNAME;
        }


        return $this;
    } // setFullname()

    /**
     * Set the value of [email] column.
     * Email
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[] = AuthyPeer::EMAIL;
        }


        return $this;
    } // setEmail()

    /**
     * Set the value of [passwd_hash] column.
     * Password
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setPasswdHash($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->passwd_hash !== $v) {
            $this->passwd_hash = $v;
            $this->modifiedColumns[] = AuthyPeer::PASSWD_HASH;
        }


        return $this;
    } // setPasswdHash()

    /**
     * Sets the value of [expire] column to a normalized version of the date/time value specified.
     * Expiration
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Authy The current object (for fluent API support)
     */
    public function setExpire($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->expire !== null || $dt !== null) {
            $currentDateAsString = ($this->expire !== null && $tmpDt = new DateTime($this->expire)) ? $tmpDt->format('Y-m-d') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d') : null;
            if ( ($currentDateAsString !== $newDateAsString) // normalized values don't match
                || ($dt->format('Y-m-d') === NULL) // or the entered value matches the default
                 ) {
                $this->expire = $newDateAsString;
                $this->modifiedColumns[] = AuthyPeer::EXPIRE;
            }
        } // if either are not null


        return $this;
    } // setExpire()

    /**
     * Set the value of [deactivate] column.
     * Deactivated
     * @param  int $v new value
     * @return Authy The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setDeactivate($v)
    {
        if ($v !== null) {
            $valueSet = AuthyPeer::getValueSet(AuthyPeer::DEACTIVATE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->deactivate !== $v) {
            $this->deactivate = $v;
            $this->modifiedColumns[] = AuthyPeer::DEACTIVATE;
        }


        return $this;
    } // setDeactivate()

    /**
     * Set the value of [is_root] column.
     *
     * @param  int $v new value
     * @return Authy The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setIsRoot($v)
    {
        if ($v !== null) {
            $valueSet = AuthyPeer::getValueSet(AuthyPeer::IS_ROOT);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->is_root !== $v) {
            $this->is_root = $v;
            $this->modifiedColumns[] = AuthyPeer::IS_ROOT;
        }


        return $this;
    } // setIsRoot()

    /**
     * Set the value of [id_authy_group] column.
     * Primary group
     * @param  int $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setIdAuthyGroup($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_authy_group !== $v) {
            $this->id_authy_group = $v;
            $this->modifiedColumns[] = AuthyPeer::ID_AUTHY_GROUP;
        }

        if ($this->aAuthyGroupRelatedByIdAuthyGroup !== null && $this->aAuthyGroupRelatedByIdAuthyGroup->getIdAuthyGroup() !== $v) {
            $this->aAuthyGroupRelatedByIdAuthyGroup = null;
        }


        return $this;
    } // setIdAuthyGroup()

    /**
     * Set the value of [is_system] column.
     *
     * @param  int $v new value
     * @return Authy The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setIsSystem($v)
    {
        if ($v !== null) {
            $valueSet = AuthyPeer::getValueSet(AuthyPeer::IS_SYSTEM);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->is_system !== $v) {
            $this->is_system = $v;
            $this->modifiedColumns[] = AuthyPeer::IS_SYSTEM;
        }


        return $this;
    } // setIsSystem()

    /**
     * Set the value of [rights_all] column.
     * Rights
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setRightsAll($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->rights_all !== $v) {
            $this->rights_all = $v;
            $this->modifiedColumns[] = AuthyPeer::RIGHTS_ALL;
        }


        return $this;
    } // setRightsAll()

    /**
     * Set the value of [rights_group] column.
     * Rights group
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setRightsGroup($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->rights_group !== $v) {
            $this->rights_group = $v;
            $this->modifiedColumns[] = AuthyPeer::RIGHTS_GROUP;
        }


        return $this;
    } // setRightsGroup()

    /**
     * Set the value of [rights_owner] column.
     * Rights owner
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setRightsOwner($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->rights_owner !== $v) {
            $this->rights_owner = $v;
            $this->modifiedColumns[] = AuthyPeer::RIGHTS_OWNER;
        }


        return $this;
    } // setRightsOwner()

    /**
     * Set the value of [onglet] column.
     *
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setOnglet($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->onglet !== $v) {
            $this->onglet = $v;
            $this->modifiedColumns[] = AuthyPeer::ONGLET;
        }


        return $this;
    } // setOnglet()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Authy The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_creation !== null || $dt !== null) {
            $currentDateAsString = ($this->date_creation !== null && $tmpDt = new DateTime($this->date_creation)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date_creation = $newDateAsString;
                $this->modifiedColumns[] = AuthyPeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Authy The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_modification !== null || $dt !== null) {
            $currentDateAsString = ($this->date_modification !== null && $tmpDt = new DateTime($this->date_modification)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date_modification = $newDateAsString;
                $this->modifiedColumns[] = AuthyPeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [id_group_creation] column.
     *
     * @param  int $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setIdGroupCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_group_creation !== $v) {
            $this->id_group_creation = $v;
            $this->modifiedColumns[] = AuthyPeer::ID_GROUP_CREATION;
        }

        if ($this->aAuthyGroupRelatedByIdGroupCreation !== null && $this->aAuthyGroupRelatedByIdGroupCreation->getIdAuthyGroup() !== $v) {
            $this->aAuthyGroupRelatedByIdGroupCreation = null;
        }


        return $this;
    } // setIdGroupCreation()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = AuthyPeer::ID_CREATION;
        }

        if ($this->aAuthyRelatedByIdCreation !== null && $this->aAuthyRelatedByIdCreation->getIdAuthy() !== $v) {
            $this->aAuthyRelatedByIdCreation = null;
        }


        return $this;
    } // setIdCreation()

    /**
     * Set the value of [id_modification] column.
     *
     * @param  int $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = AuthyPeer::ID_MODIFICATION;
        }

        if ($this->aAuthyRelatedByIdModification !== null && $this->aAuthyRelatedByIdModification->getIdAuthy() !== $v) {
            $this->aAuthyRelatedByIdModification = null;
        }


        return $this;
    } // setIdModification()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->expire !== NULL) {
                return false;
            }

            if ($this->deactivate !== 1) {
                return false;
            }

            if ($this->is_root !== 1) {
                return false;
            }

            if ($this->id_authy_group !== 1) {
                return false;
            }

            if ($this->is_system !== 1) {
                return false;
            }

        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id_authy = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->validation_key = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->username = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->fullname = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->email = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->passwd_hash = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->expire = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->deactivate = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->is_root = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->id_authy_group = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
            $this->is_system = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
            $this->rights_all = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->rights_group = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->rights_owner = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
            $this->onglet = ($row[$startcol + 14] !== null) ? (string) $row[$startcol + 14] : null;
            $this->date_creation = ($row[$startcol + 15] !== null) ? (string) $row[$startcol + 15] : null;
            $this->date_modification = ($row[$startcol + 16] !== null) ? (string) $row[$startcol + 16] : null;
            $this->id_group_creation = ($row[$startcol + 17] !== null) ? (int) $row[$startcol + 17] : null;
            $this->id_creation = ($row[$startcol + 18] !== null) ? (int) $row[$startcol + 18] : null;
            $this->id_modification = ($row[$startcol + 19] !== null) ? (int) $row[$startcol + 19] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 20; // 20 = AuthyPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Authy object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

        if ($this->aAuthyGroupRelatedByIdAuthyGroup !== null && $this->id_authy_group !== $this->aAuthyGroupRelatedByIdAuthyGroup->getIdAuthyGroup()) {
            $this->aAuthyGroupRelatedByIdAuthyGroup = null;
        }
        if ($this->aAuthyGroupRelatedByIdGroupCreation !== null && $this->id_group_creation !== $this->aAuthyGroupRelatedByIdGroupCreation->getIdAuthyGroup()) {
            $this->aAuthyGroupRelatedByIdGroupCreation = null;
        }
        if ($this->aAuthyRelatedByIdCreation !== null && $this->id_creation !== $this->aAuthyRelatedByIdCreation->getIdAuthy()) {
            $this->aAuthyRelatedByIdCreation = null;
        }
        if ($this->aAuthyRelatedByIdModification !== null && $this->id_modification !== $this->aAuthyRelatedByIdModification->getIdAuthy()) {
            $this->aAuthyRelatedByIdModification = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(AuthyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = AuthyPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAuthyGroupRelatedByIdAuthyGroup = null;
            $this->aAuthyGroupRelatedByIdGroupCreation = null;
            $this->aAuthyRelatedByIdCreation = null;
            $this->aAuthyRelatedByIdModification = null;
            $this->collAuthyGroupxes = null;

            $this->collAuthyLogs = null;

            $this->collAuthiesRelatedByIdAuthy0 = null;

            $this->collAuthiesRelatedByIdAuthy1 = null;

            $this->collCountriesRelatedByIdCreation = null;

            $this->collCountriesRelatedByIdModification = null;

            $this->collAssetsRelatedByIdCreation = null;

            $this->collAssetsRelatedByIdModification = null;

            $this->collAssetExchangesRelatedByIdCreation = null;

            $this->collAssetExchangesRelatedByIdModification = null;

            $this->collTradesRelatedByIdCreation = null;

            $this->collTradesRelatedByIdModification = null;

            $this->collExchangesRelatedByIdCreation = null;

            $this->collExchangesRelatedByIdModification = null;

            $this->collTokensRelatedByIdCreation = null;

            $this->collTokensRelatedByIdModification = null;

            $this->collSymbolsRelatedByIdCreation = null;

            $this->collSymbolsRelatedByIdModification = null;

            $this->collImportsRelatedByIdCreation = null;

            $this->collImportsRelatedByIdModification = null;

            $this->collAuthyGroupsRelatedByIdCreation = null;

            $this->collAuthyGroupsRelatedByIdModification = null;

            $this->collConfigsRelatedByIdCreation = null;

            $this->collConfigsRelatedByIdModification = null;

            $this->collApiRbacsRelatedByIdCreation = null;

            $this->collApiRbacsRelatedByIdModification = null;

            $this->collApiLogs = null;

            $this->collTemplatesRelatedByIdCreation = null;

            $this->collTemplatesRelatedByIdModification = null;

            $this->collTemplateFilesRelatedByIdCreation = null;

            $this->collTemplateFilesRelatedByIdModification = null;

            $this->collMessageI18nsRelatedByIdCreation = null;

            $this->collMessageI18nsRelatedByIdModification = null;

            $this->collAuthyGroups = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(AuthyPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = AuthyQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(AuthyPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            // GoatCheese behavior

            if ($isInsert) {
                \ApiGoat\Model\Authy::setDefaultsGroupRights($this);
            }
            if(method_exists($this, 'getEmail')){
                $this->setEmail(strtolower($this->getEmail()));
            }

            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // add_tablestamp behavior

                    $this->setDateCreation(time());
                    $this->setDateModification(time());
                    $this->setIdGroupCreation( (get_class($_SESSION[_AUTH_VAR]) === 'ApiGoat\Sessions\AuthySession')?$_SESSION[_AUTH_VAR]->getIdPrimaryGroup():null );
                    if(!$this->getIdCreation())
                        $this->setIdCreation( (get_class($_SESSION[_AUTH_VAR]) === 'ApiGoat\Sessions\AuthySession')?$_SESSION[_AUTH_VAR]->getIdAuthy():null );
                    if(!$this->getIdModification())
                        $this->setIdModification( (get_class($_SESSION[_AUTH_VAR]) === 'ApiGoat\Sessions\AuthySession')?$_SESSION[_AUTH_VAR]->getIdAuthy():null );

            } else {
                $ret = $ret && $this->preUpdate($con);
                // add_tablestamp behavior
                if ($this->isModified() ) {
                    $this->setDateCreation( $this->getDateCreation() );
                    $this->setDateModification(time());
                    $this->setIdGroupCreation( (get_class($_SESSION[_AUTH_VAR]) === 'ApiGoat\Sessions\AuthySession')?$_SESSION[_AUTH_VAR]->getIdPrimaryGroup():null );
                    if(!$this->getIdCreation())
                        $this->setIdCreation( (get_class($_SESSION[_AUTH_VAR]) === 'ApiGoat\Sessions\AuthySession')?$_SESSION[_AUTH_VAR]->getIdAuthy():null );
                    if(!$this->getIdModification())
                        $this->setIdModification( (get_class($_SESSION[_AUTH_VAR]) === 'ApiGoat\Sessions\AuthySession')?$_SESSION[_AUTH_VAR]->getIdAuthy():null );
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                AuthyPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aAuthyGroupRelatedByIdAuthyGroup !== null) {
                if ($this->aAuthyGroupRelatedByIdAuthyGroup->isModified() || $this->aAuthyGroupRelatedByIdAuthyGroup->isNew()) {
                    $affectedRows += $this->aAuthyGroupRelatedByIdAuthyGroup->save($con);
                }
                $this->setAuthyGroupRelatedByIdAuthyGroup($this->aAuthyGroupRelatedByIdAuthyGroup);
            }

            if ($this->aAuthyGroupRelatedByIdGroupCreation !== null) {
                if ($this->aAuthyGroupRelatedByIdGroupCreation->isModified() || $this->aAuthyGroupRelatedByIdGroupCreation->isNew()) {
                    $affectedRows += $this->aAuthyGroupRelatedByIdGroupCreation->save($con);
                }
                $this->setAuthyGroupRelatedByIdGroupCreation($this->aAuthyGroupRelatedByIdGroupCreation);
            }

            if ($this->aAuthyRelatedByIdCreation !== null) {
                if ($this->aAuthyRelatedByIdCreation->isModified() || $this->aAuthyRelatedByIdCreation->isNew()) {
                    $affectedRows += $this->aAuthyRelatedByIdCreation->save($con);
                }
                $this->setAuthyRelatedByIdCreation($this->aAuthyRelatedByIdCreation);
            }

            if ($this->aAuthyRelatedByIdModification !== null) {
                if ($this->aAuthyRelatedByIdModification->isModified() || $this->aAuthyRelatedByIdModification->isNew()) {
                    $affectedRows += $this->aAuthyRelatedByIdModification->save($con);
                }
                $this->setAuthyRelatedByIdModification($this->aAuthyRelatedByIdModification);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->authyGroupsScheduledForDeletion !== null) {
                if (!$this->authyGroupsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->authyGroupsScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    AuthyGroupXQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->authyGroupsScheduledForDeletion = null;
                }

                foreach ($this->getAuthyGroups() as $authyGroup) {
                    if ($authyGroup->isModified()) {
                        $authyGroup->save($con);
                    }
                }
            } elseif ($this->collAuthyGroups) {
                foreach ($this->collAuthyGroups as $authyGroup) {
                    if ($authyGroup->isModified()) {
                        $authyGroup->save($con);
                    }
                }
            }

            if ($this->authyGroupxesScheduledForDeletion !== null) {
                if (!$this->authyGroupxesScheduledForDeletion->isEmpty()) {
                    AuthyGroupXQuery::create()
                        ->filterByPrimaryKeys($this->authyGroupxesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->authyGroupxesScheduledForDeletion = null;
                }
            }

            if ($this->collAuthyGroupxes !== null) {
                foreach ($this->collAuthyGroupxes as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->authyLogsScheduledForDeletion !== null) {
                if (!$this->authyLogsScheduledForDeletion->isEmpty()) {
                    foreach ($this->authyLogsScheduledForDeletion as $authyLog) {
                        // need to save related object because we set the relation to null
                        $authyLog->save($con);
                    }
                    $this->authyLogsScheduledForDeletion = null;
                }
            }

            if ($this->collAuthyLogs !== null) {
                foreach ($this->collAuthyLogs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->authiesRelatedByIdAuthy0ScheduledForDeletion !== null) {
                if (!$this->authiesRelatedByIdAuthy0ScheduledForDeletion->isEmpty()) {
                    foreach ($this->authiesRelatedByIdAuthy0ScheduledForDeletion as $authyRelatedByIdAuthy0) {
                        // need to save related object because we set the relation to null
                        $authyRelatedByIdAuthy0->save($con);
                    }
                    $this->authiesRelatedByIdAuthy0ScheduledForDeletion = null;
                }
            }

            if ($this->collAuthiesRelatedByIdAuthy0 !== null) {
                foreach ($this->collAuthiesRelatedByIdAuthy0 as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->authiesRelatedByIdAuthy1ScheduledForDeletion !== null) {
                if (!$this->authiesRelatedByIdAuthy1ScheduledForDeletion->isEmpty()) {
                    foreach ($this->authiesRelatedByIdAuthy1ScheduledForDeletion as $authyRelatedByIdAuthy1) {
                        // need to save related object because we set the relation to null
                        $authyRelatedByIdAuthy1->save($con);
                    }
                    $this->authiesRelatedByIdAuthy1ScheduledForDeletion = null;
                }
            }

            if ($this->collAuthiesRelatedByIdAuthy1 !== null) {
                foreach ($this->collAuthiesRelatedByIdAuthy1 as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->countriesRelatedByIdCreationScheduledForDeletion !== null) {
                if (!$this->countriesRelatedByIdCreationScheduledForDeletion->isEmpty()) {
                    foreach ($this->countriesRelatedByIdCreationScheduledForDeletion as $countryRelatedByIdCreation) {
                        // need to save related object because we set the relation to null
                        $countryRelatedByIdCreation->save($con);
                    }
                    $this->countriesRelatedByIdCreationScheduledForDeletion = null;
                }
            }

            if ($this->collCountriesRelatedByIdCreation !== null) {
                foreach ($this->collCountriesRelatedByIdCreation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->countriesRelatedByIdModificationScheduledForDeletion !== null) {
                if (!$this->countriesRelatedByIdModificationScheduledForDeletion->isEmpty()) {
                    foreach ($this->countriesRelatedByIdModificationScheduledForDeletion as $countryRelatedByIdModification) {
                        // need to save related object because we set the relation to null
                        $countryRelatedByIdModification->save($con);
                    }
                    $this->countriesRelatedByIdModificationScheduledForDeletion = null;
                }
            }

            if ($this->collCountriesRelatedByIdModification !== null) {
                foreach ($this->collCountriesRelatedByIdModification as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->assetsRelatedByIdCreationScheduledForDeletion !== null) {
                if (!$this->assetsRelatedByIdCreationScheduledForDeletion->isEmpty()) {
                    foreach ($this->assetsRelatedByIdCreationScheduledForDeletion as $assetRelatedByIdCreation) {
                        // need to save related object because we set the relation to null
                        $assetRelatedByIdCreation->save($con);
                    }
                    $this->assetsRelatedByIdCreationScheduledForDeletion = null;
                }
            }

            if ($this->collAssetsRelatedByIdCreation !== null) {
                foreach ($this->collAssetsRelatedByIdCreation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->assetsRelatedByIdModificationScheduledForDeletion !== null) {
                if (!$this->assetsRelatedByIdModificationScheduledForDeletion->isEmpty()) {
                    foreach ($this->assetsRelatedByIdModificationScheduledForDeletion as $assetRelatedByIdModification) {
                        // need to save related object because we set the relation to null
                        $assetRelatedByIdModification->save($con);
                    }
                    $this->assetsRelatedByIdModificationScheduledForDeletion = null;
                }
            }

            if ($this->collAssetsRelatedByIdModification !== null) {
                foreach ($this->collAssetsRelatedByIdModification as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->assetExchangesRelatedByIdCreationScheduledForDeletion !== null) {
                if (!$this->assetExchangesRelatedByIdCreationScheduledForDeletion->isEmpty()) {
                    foreach ($this->assetExchangesRelatedByIdCreationScheduledForDeletion as $assetExchangeRelatedByIdCreation) {
                        // need to save related object because we set the relation to null
                        $assetExchangeRelatedByIdCreation->save($con);
                    }
                    $this->assetExchangesRelatedByIdCreationScheduledForDeletion = null;
                }
            }

            if ($this->collAssetExchangesRelatedByIdCreation !== null) {
                foreach ($this->collAssetExchangesRelatedByIdCreation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->assetExchangesRelatedByIdModificationScheduledForDeletion !== null) {
                if (!$this->assetExchangesRelatedByIdModificationScheduledForDeletion->isEmpty()) {
                    foreach ($this->assetExchangesRelatedByIdModificationScheduledForDeletion as $assetExchangeRelatedByIdModification) {
                        // need to save related object because we set the relation to null
                        $assetExchangeRelatedByIdModification->save($con);
                    }
                    $this->assetExchangesRelatedByIdModificationScheduledForDeletion = null;
                }
            }

            if ($this->collAssetExchangesRelatedByIdModification !== null) {
                foreach ($this->collAssetExchangesRelatedByIdModification as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->tradesRelatedByIdCreationScheduledForDeletion !== null) {
                if (!$this->tradesRelatedByIdCreationScheduledForDeletion->isEmpty()) {
                    foreach ($this->tradesRelatedByIdCreationScheduledForDeletion as $tradeRelatedByIdCreation) {
                        // need to save related object because we set the relation to null
                        $tradeRelatedByIdCreation->save($con);
                    }
                    $this->tradesRelatedByIdCreationScheduledForDeletion = null;
                }
            }

            if ($this->collTradesRelatedByIdCreation !== null) {
                foreach ($this->collTradesRelatedByIdCreation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->tradesRelatedByIdModificationScheduledForDeletion !== null) {
                if (!$this->tradesRelatedByIdModificationScheduledForDeletion->isEmpty()) {
                    foreach ($this->tradesRelatedByIdModificationScheduledForDeletion as $tradeRelatedByIdModification) {
                        // need to save related object because we set the relation to null
                        $tradeRelatedByIdModification->save($con);
                    }
                    $this->tradesRelatedByIdModificationScheduledForDeletion = null;
                }
            }

            if ($this->collTradesRelatedByIdModification !== null) {
                foreach ($this->collTradesRelatedByIdModification as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->exchangesRelatedByIdCreationScheduledForDeletion !== null) {
                if (!$this->exchangesRelatedByIdCreationScheduledForDeletion->isEmpty()) {
                    foreach ($this->exchangesRelatedByIdCreationScheduledForDeletion as $exchangeRelatedByIdCreation) {
                        // need to save related object because we set the relation to null
                        $exchangeRelatedByIdCreation->save($con);
                    }
                    $this->exchangesRelatedByIdCreationScheduledForDeletion = null;
                }
            }

            if ($this->collExchangesRelatedByIdCreation !== null) {
                foreach ($this->collExchangesRelatedByIdCreation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->exchangesRelatedByIdModificationScheduledForDeletion !== null) {
                if (!$this->exchangesRelatedByIdModificationScheduledForDeletion->isEmpty()) {
                    foreach ($this->exchangesRelatedByIdModificationScheduledForDeletion as $exchangeRelatedByIdModification) {
                        // need to save related object because we set the relation to null
                        $exchangeRelatedByIdModification->save($con);
                    }
                    $this->exchangesRelatedByIdModificationScheduledForDeletion = null;
                }
            }

            if ($this->collExchangesRelatedByIdModification !== null) {
                foreach ($this->collExchangesRelatedByIdModification as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->tokensRelatedByIdCreationScheduledForDeletion !== null) {
                if (!$this->tokensRelatedByIdCreationScheduledForDeletion->isEmpty()) {
                    foreach ($this->tokensRelatedByIdCreationScheduledForDeletion as $tokenRelatedByIdCreation) {
                        // need to save related object because we set the relation to null
                        $tokenRelatedByIdCreation->save($con);
                    }
                    $this->tokensRelatedByIdCreationScheduledForDeletion = null;
                }
            }

            if ($this->collTokensRelatedByIdCreation !== null) {
                foreach ($this->collTokensRelatedByIdCreation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->tokensRelatedByIdModificationScheduledForDeletion !== null) {
                if (!$this->tokensRelatedByIdModificationScheduledForDeletion->isEmpty()) {
                    foreach ($this->tokensRelatedByIdModificationScheduledForDeletion as $tokenRelatedByIdModification) {
                        // need to save related object because we set the relation to null
                        $tokenRelatedByIdModification->save($con);
                    }
                    $this->tokensRelatedByIdModificationScheduledForDeletion = null;
                }
            }

            if ($this->collTokensRelatedByIdModification !== null) {
                foreach ($this->collTokensRelatedByIdModification as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->symbolsRelatedByIdCreationScheduledForDeletion !== null) {
                if (!$this->symbolsRelatedByIdCreationScheduledForDeletion->isEmpty()) {
                    foreach ($this->symbolsRelatedByIdCreationScheduledForDeletion as $symbolRelatedByIdCreation) {
                        // need to save related object because we set the relation to null
                        $symbolRelatedByIdCreation->save($con);
                    }
                    $this->symbolsRelatedByIdCreationScheduledForDeletion = null;
                }
            }

            if ($this->collSymbolsRelatedByIdCreation !== null) {
                foreach ($this->collSymbolsRelatedByIdCreation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->symbolsRelatedByIdModificationScheduledForDeletion !== null) {
                if (!$this->symbolsRelatedByIdModificationScheduledForDeletion->isEmpty()) {
                    foreach ($this->symbolsRelatedByIdModificationScheduledForDeletion as $symbolRelatedByIdModification) {
                        // need to save related object because we set the relation to null
                        $symbolRelatedByIdModification->save($con);
                    }
                    $this->symbolsRelatedByIdModificationScheduledForDeletion = null;
                }
            }

            if ($this->collSymbolsRelatedByIdModification !== null) {
                foreach ($this->collSymbolsRelatedByIdModification as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->importsRelatedByIdCreationScheduledForDeletion !== null) {
                if (!$this->importsRelatedByIdCreationScheduledForDeletion->isEmpty()) {
                    foreach ($this->importsRelatedByIdCreationScheduledForDeletion as $importRelatedByIdCreation) {
                        // need to save related object because we set the relation to null
                        $importRelatedByIdCreation->save($con);
                    }
                    $this->importsRelatedByIdCreationScheduledForDeletion = null;
                }
            }

            if ($this->collImportsRelatedByIdCreation !== null) {
                foreach ($this->collImportsRelatedByIdCreation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->importsRelatedByIdModificationScheduledForDeletion !== null) {
                if (!$this->importsRelatedByIdModificationScheduledForDeletion->isEmpty()) {
                    foreach ($this->importsRelatedByIdModificationScheduledForDeletion as $importRelatedByIdModification) {
                        // need to save related object because we set the relation to null
                        $importRelatedByIdModification->save($con);
                    }
                    $this->importsRelatedByIdModificationScheduledForDeletion = null;
                }
            }

            if ($this->collImportsRelatedByIdModification !== null) {
                foreach ($this->collImportsRelatedByIdModification as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->authyGroupsRelatedByIdCreationScheduledForDeletion !== null) {
                if (!$this->authyGroupsRelatedByIdCreationScheduledForDeletion->isEmpty()) {
                    foreach ($this->authyGroupsRelatedByIdCreationScheduledForDeletion as $authyGroupRelatedByIdCreation) {
                        // need to save related object because we set the relation to null
                        $authyGroupRelatedByIdCreation->save($con);
                    }
                    $this->authyGroupsRelatedByIdCreationScheduledForDeletion = null;
                }
            }

            if ($this->collAuthyGroupsRelatedByIdCreation !== null) {
                foreach ($this->collAuthyGroupsRelatedByIdCreation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->authyGroupsRelatedByIdModificationScheduledForDeletion !== null) {
                if (!$this->authyGroupsRelatedByIdModificationScheduledForDeletion->isEmpty()) {
                    foreach ($this->authyGroupsRelatedByIdModificationScheduledForDeletion as $authyGroupRelatedByIdModification) {
                        // need to save related object because we set the relation to null
                        $authyGroupRelatedByIdModification->save($con);
                    }
                    $this->authyGroupsRelatedByIdModificationScheduledForDeletion = null;
                }
            }

            if ($this->collAuthyGroupsRelatedByIdModification !== null) {
                foreach ($this->collAuthyGroupsRelatedByIdModification as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->configsRelatedByIdCreationScheduledForDeletion !== null) {
                if (!$this->configsRelatedByIdCreationScheduledForDeletion->isEmpty()) {
                    foreach ($this->configsRelatedByIdCreationScheduledForDeletion as $configRelatedByIdCreation) {
                        // need to save related object because we set the relation to null
                        $configRelatedByIdCreation->save($con);
                    }
                    $this->configsRelatedByIdCreationScheduledForDeletion = null;
                }
            }

            if ($this->collConfigsRelatedByIdCreation !== null) {
                foreach ($this->collConfigsRelatedByIdCreation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->configsRelatedByIdModificationScheduledForDeletion !== null) {
                if (!$this->configsRelatedByIdModificationScheduledForDeletion->isEmpty()) {
                    foreach ($this->configsRelatedByIdModificationScheduledForDeletion as $configRelatedByIdModification) {
                        // need to save related object because we set the relation to null
                        $configRelatedByIdModification->save($con);
                    }
                    $this->configsRelatedByIdModificationScheduledForDeletion = null;
                }
            }

            if ($this->collConfigsRelatedByIdModification !== null) {
                foreach ($this->collConfigsRelatedByIdModification as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->apiRbacsRelatedByIdCreationScheduledForDeletion !== null) {
                if (!$this->apiRbacsRelatedByIdCreationScheduledForDeletion->isEmpty()) {
                    foreach ($this->apiRbacsRelatedByIdCreationScheduledForDeletion as $apiRbacRelatedByIdCreation) {
                        // need to save related object because we set the relation to null
                        $apiRbacRelatedByIdCreation->save($con);
                    }
                    $this->apiRbacsRelatedByIdCreationScheduledForDeletion = null;
                }
            }

            if ($this->collApiRbacsRelatedByIdCreation !== null) {
                foreach ($this->collApiRbacsRelatedByIdCreation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->apiRbacsRelatedByIdModificationScheduledForDeletion !== null) {
                if (!$this->apiRbacsRelatedByIdModificationScheduledForDeletion->isEmpty()) {
                    foreach ($this->apiRbacsRelatedByIdModificationScheduledForDeletion as $apiRbacRelatedByIdModification) {
                        // need to save related object because we set the relation to null
                        $apiRbacRelatedByIdModification->save($con);
                    }
                    $this->apiRbacsRelatedByIdModificationScheduledForDeletion = null;
                }
            }

            if ($this->collApiRbacsRelatedByIdModification !== null) {
                foreach ($this->collApiRbacsRelatedByIdModification as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->apiLogsScheduledForDeletion !== null) {
                if (!$this->apiLogsScheduledForDeletion->isEmpty()) {
                    ApiLogQuery::create()
                        ->filterByPrimaryKeys($this->apiLogsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->apiLogsScheduledForDeletion = null;
                }
            }

            if ($this->collApiLogs !== null) {
                foreach ($this->collApiLogs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->templatesRelatedByIdCreationScheduledForDeletion !== null) {
                if (!$this->templatesRelatedByIdCreationScheduledForDeletion->isEmpty()) {
                    foreach ($this->templatesRelatedByIdCreationScheduledForDeletion as $templateRelatedByIdCreation) {
                        // need to save related object because we set the relation to null
                        $templateRelatedByIdCreation->save($con);
                    }
                    $this->templatesRelatedByIdCreationScheduledForDeletion = null;
                }
            }

            if ($this->collTemplatesRelatedByIdCreation !== null) {
                foreach ($this->collTemplatesRelatedByIdCreation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->templatesRelatedByIdModificationScheduledForDeletion !== null) {
                if (!$this->templatesRelatedByIdModificationScheduledForDeletion->isEmpty()) {
                    foreach ($this->templatesRelatedByIdModificationScheduledForDeletion as $templateRelatedByIdModification) {
                        // need to save related object because we set the relation to null
                        $templateRelatedByIdModification->save($con);
                    }
                    $this->templatesRelatedByIdModificationScheduledForDeletion = null;
                }
            }

            if ($this->collTemplatesRelatedByIdModification !== null) {
                foreach ($this->collTemplatesRelatedByIdModification as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->templateFilesRelatedByIdCreationScheduledForDeletion !== null) {
                if (!$this->templateFilesRelatedByIdCreationScheduledForDeletion->isEmpty()) {
                    foreach ($this->templateFilesRelatedByIdCreationScheduledForDeletion as $templateFileRelatedByIdCreation) {
                        // need to save related object because we set the relation to null
                        $templateFileRelatedByIdCreation->save($con);
                    }
                    $this->templateFilesRelatedByIdCreationScheduledForDeletion = null;
                }
            }

            if ($this->collTemplateFilesRelatedByIdCreation !== null) {
                foreach ($this->collTemplateFilesRelatedByIdCreation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->templateFilesRelatedByIdModificationScheduledForDeletion !== null) {
                if (!$this->templateFilesRelatedByIdModificationScheduledForDeletion->isEmpty()) {
                    foreach ($this->templateFilesRelatedByIdModificationScheduledForDeletion as $templateFileRelatedByIdModification) {
                        // need to save related object because we set the relation to null
                        $templateFileRelatedByIdModification->save($con);
                    }
                    $this->templateFilesRelatedByIdModificationScheduledForDeletion = null;
                }
            }

            if ($this->collTemplateFilesRelatedByIdModification !== null) {
                foreach ($this->collTemplateFilesRelatedByIdModification as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->messageI18nsRelatedByIdCreationScheduledForDeletion !== null) {
                if (!$this->messageI18nsRelatedByIdCreationScheduledForDeletion->isEmpty()) {
                    foreach ($this->messageI18nsRelatedByIdCreationScheduledForDeletion as $messageI18nRelatedByIdCreation) {
                        // need to save related object because we set the relation to null
                        $messageI18nRelatedByIdCreation->save($con);
                    }
                    $this->messageI18nsRelatedByIdCreationScheduledForDeletion = null;
                }
            }

            if ($this->collMessageI18nsRelatedByIdCreation !== null) {
                foreach ($this->collMessageI18nsRelatedByIdCreation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->messageI18nsRelatedByIdModificationScheduledForDeletion !== null) {
                if (!$this->messageI18nsRelatedByIdModificationScheduledForDeletion->isEmpty()) {
                    foreach ($this->messageI18nsRelatedByIdModificationScheduledForDeletion as $messageI18nRelatedByIdModification) {
                        // need to save related object because we set the relation to null
                        $messageI18nRelatedByIdModification->save($con);
                    }
                    $this->messageI18nsRelatedByIdModificationScheduledForDeletion = null;
                }
            }

            if ($this->collMessageI18nsRelatedByIdModification !== null) {
                foreach ($this->collMessageI18nsRelatedByIdModification as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = AuthyPeer::ID_AUTHY;
        if (null !== $this->id_authy) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AuthyPeer::ID_AUTHY . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AuthyPeer::ID_AUTHY)) {
            $modifiedColumns[':p' . $index++]  = '`id_authy`';
        }
        if ($this->isColumnModified(AuthyPeer::VALIDATION_KEY)) {
            $modifiedColumns[':p' . $index++]  = '`validation_key`';
        }
        if ($this->isColumnModified(AuthyPeer::USERNAME)) {
            $modifiedColumns[':p' . $index++]  = '`username`';
        }
        if ($this->isColumnModified(AuthyPeer::FULLNAME)) {
            $modifiedColumns[':p' . $index++]  = '`fullname`';
        }
        if ($this->isColumnModified(AuthyPeer::EMAIL)) {
            $modifiedColumns[':p' . $index++]  = '`email`';
        }
        if ($this->isColumnModified(AuthyPeer::PASSWD_HASH)) {
            $modifiedColumns[':p' . $index++]  = '`passwd_hash`';
        }
        if ($this->isColumnModified(AuthyPeer::EXPIRE)) {
            $modifiedColumns[':p' . $index++]  = '`expire`';
        }
        if ($this->isColumnModified(AuthyPeer::DEACTIVATE)) {
            $modifiedColumns[':p' . $index++]  = '`deactivate`';
        }
        if ($this->isColumnModified(AuthyPeer::IS_ROOT)) {
            $modifiedColumns[':p' . $index++]  = '`is_root`';
        }
        if ($this->isColumnModified(AuthyPeer::ID_AUTHY_GROUP)) {
            $modifiedColumns[':p' . $index++]  = '`id_authy_group`';
        }
        if ($this->isColumnModified(AuthyPeer::IS_SYSTEM)) {
            $modifiedColumns[':p' . $index++]  = '`is_system`';
        }
        if ($this->isColumnModified(AuthyPeer::RIGHTS_ALL)) {
            $modifiedColumns[':p' . $index++]  = '`rights_all`';
        }
        if ($this->isColumnModified(AuthyPeer::RIGHTS_GROUP)) {
            $modifiedColumns[':p' . $index++]  = '`rights_group`';
        }
        if ($this->isColumnModified(AuthyPeer::RIGHTS_OWNER)) {
            $modifiedColumns[':p' . $index++]  = '`rights_owner`';
        }
        if ($this->isColumnModified(AuthyPeer::ONGLET)) {
            $modifiedColumns[':p' . $index++]  = '`onglet`';
        }
        if ($this->isColumnModified(AuthyPeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(AuthyPeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(AuthyPeer::ID_GROUP_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_group_creation`';
        }
        if ($this->isColumnModified(AuthyPeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(AuthyPeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `authy` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_authy`':
                        $stmt->bindValue($identifier, $this->id_authy, PDO::PARAM_INT);
                        break;
                    case '`validation_key`':
                        $stmt->bindValue($identifier, $this->validation_key, PDO::PARAM_STR);
                        break;
                    case '`username`':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case '`fullname`':
                        $stmt->bindValue($identifier, $this->fullname, PDO::PARAM_STR);
                        break;
                    case '`email`':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case '`passwd_hash`':
                        $stmt->bindValue($identifier, $this->passwd_hash, PDO::PARAM_STR);
                        break;
                    case '`expire`':
                        $stmt->bindValue($identifier, $this->expire, PDO::PARAM_STR);
                        break;
                    case '`deactivate`':
                        $stmt->bindValue($identifier, $this->deactivate, PDO::PARAM_INT);
                        break;
                    case '`is_root`':
                        $stmt->bindValue($identifier, $this->is_root, PDO::PARAM_INT);
                        break;
                    case '`id_authy_group`':
                        $stmt->bindValue($identifier, $this->id_authy_group, PDO::PARAM_INT);
                        break;
                    case '`is_system`':
                        $stmt->bindValue($identifier, $this->is_system, PDO::PARAM_INT);
                        break;
                    case '`rights_all`':
                        $stmt->bindValue($identifier, $this->rights_all, PDO::PARAM_STR);
                        break;
                    case '`rights_group`':
                        $stmt->bindValue($identifier, $this->rights_group, PDO::PARAM_STR);
                        break;
                    case '`rights_owner`':
                        $stmt->bindValue($identifier, $this->rights_owner, PDO::PARAM_STR);
                        break;
                    case '`onglet`':
                        $stmt->bindValue($identifier, $this->onglet, PDO::PARAM_STR);
                        break;
                    case '`date_creation`':
                        $stmt->bindValue($identifier, $this->date_creation, PDO::PARAM_STR);
                        break;
                    case '`date_modification`':
                        $stmt->bindValue($identifier, $this->date_modification, PDO::PARAM_STR);
                        break;
                    case '`id_group_creation`':
                        $stmt->bindValue($identifier, $this->id_group_creation, PDO::PARAM_INT);
                        break;
                    case '`id_creation`':
                        $stmt->bindValue($identifier, $this->id_creation, PDO::PARAM_INT);
                        break;
                    case '`id_modification`':
                        $stmt->bindValue($identifier, $this->id_modification, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setIdAuthy($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggregated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objects otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aAuthyGroupRelatedByIdAuthyGroup !== null) {
                if (!$this->aAuthyGroupRelatedByIdAuthyGroup->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAuthyGroupRelatedByIdAuthyGroup->getValidationFailures());
                }
            }

            if ($this->aAuthyGroupRelatedByIdGroupCreation !== null) {
                if (!$this->aAuthyGroupRelatedByIdGroupCreation->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAuthyGroupRelatedByIdGroupCreation->getValidationFailures());
                }
            }

            if ($this->aAuthyRelatedByIdCreation !== null) {
                if (!$this->aAuthyRelatedByIdCreation->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAuthyRelatedByIdCreation->getValidationFailures());
                }
            }

            if ($this->aAuthyRelatedByIdModification !== null) {
                if (!$this->aAuthyRelatedByIdModification->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAuthyRelatedByIdModification->getValidationFailures());
                }
            }


            if (($retval = AuthyPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collAuthyGroupxes !== null) {
                    foreach ($this->collAuthyGroupxes as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAuthyLogs !== null) {
                    foreach ($this->collAuthyLogs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAuthiesRelatedByIdAuthy0 !== null) {
                    foreach ($this->collAuthiesRelatedByIdAuthy0 as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAuthiesRelatedByIdAuthy1 !== null) {
                    foreach ($this->collAuthiesRelatedByIdAuthy1 as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCountriesRelatedByIdCreation !== null) {
                    foreach ($this->collCountriesRelatedByIdCreation as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCountriesRelatedByIdModification !== null) {
                    foreach ($this->collCountriesRelatedByIdModification as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAssetsRelatedByIdCreation !== null) {
                    foreach ($this->collAssetsRelatedByIdCreation as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAssetsRelatedByIdModification !== null) {
                    foreach ($this->collAssetsRelatedByIdModification as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAssetExchangesRelatedByIdCreation !== null) {
                    foreach ($this->collAssetExchangesRelatedByIdCreation as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAssetExchangesRelatedByIdModification !== null) {
                    foreach ($this->collAssetExchangesRelatedByIdModification as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collTradesRelatedByIdCreation !== null) {
                    foreach ($this->collTradesRelatedByIdCreation as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collTradesRelatedByIdModification !== null) {
                    foreach ($this->collTradesRelatedByIdModification as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collExchangesRelatedByIdCreation !== null) {
                    foreach ($this->collExchangesRelatedByIdCreation as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collExchangesRelatedByIdModification !== null) {
                    foreach ($this->collExchangesRelatedByIdModification as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collTokensRelatedByIdCreation !== null) {
                    foreach ($this->collTokensRelatedByIdCreation as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collTokensRelatedByIdModification !== null) {
                    foreach ($this->collTokensRelatedByIdModification as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collSymbolsRelatedByIdCreation !== null) {
                    foreach ($this->collSymbolsRelatedByIdCreation as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collSymbolsRelatedByIdModification !== null) {
                    foreach ($this->collSymbolsRelatedByIdModification as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collImportsRelatedByIdCreation !== null) {
                    foreach ($this->collImportsRelatedByIdCreation as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collImportsRelatedByIdModification !== null) {
                    foreach ($this->collImportsRelatedByIdModification as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAuthyGroupsRelatedByIdCreation !== null) {
                    foreach ($this->collAuthyGroupsRelatedByIdCreation as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAuthyGroupsRelatedByIdModification !== null) {
                    foreach ($this->collAuthyGroupsRelatedByIdModification as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collConfigsRelatedByIdCreation !== null) {
                    foreach ($this->collConfigsRelatedByIdCreation as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collConfigsRelatedByIdModification !== null) {
                    foreach ($this->collConfigsRelatedByIdModification as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collApiRbacsRelatedByIdCreation !== null) {
                    foreach ($this->collApiRbacsRelatedByIdCreation as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collApiRbacsRelatedByIdModification !== null) {
                    foreach ($this->collApiRbacsRelatedByIdModification as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collApiLogs !== null) {
                    foreach ($this->collApiLogs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collTemplatesRelatedByIdCreation !== null) {
                    foreach ($this->collTemplatesRelatedByIdCreation as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collTemplatesRelatedByIdModification !== null) {
                    foreach ($this->collTemplatesRelatedByIdModification as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collTemplateFilesRelatedByIdCreation !== null) {
                    foreach ($this->collTemplateFilesRelatedByIdCreation as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collTemplateFilesRelatedByIdModification !== null) {
                    foreach ($this->collTemplateFilesRelatedByIdModification as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collMessageI18nsRelatedByIdCreation !== null) {
                    foreach ($this->collMessageI18nsRelatedByIdCreation as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collMessageI18nsRelatedByIdModification !== null) {
                    foreach ($this->collMessageI18nsRelatedByIdModification as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = AuthyPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Authy'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Authy'][$this->getPrimaryKey()] = true;
        $keys = AuthyPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdAuthy(),
            $keys[1] => $this->getValidationKey(),
            $keys[2] => $this->getUsername(),
            $keys[3] => $this->getFullname(),
            $keys[4] => $this->getEmail(),
            $keys[5] => $this->getPasswdHash(),
            $keys[6] => $this->getExpire(),
            $keys[7] => $this->getDeactivate(),
            $keys[8] => $this->getIsRoot(),
            $keys[9] => $this->getIdAuthyGroup(),
            $keys[10] => $this->getIsSystem(),
            $keys[11] => $this->getRightsAll(),
            $keys[12] => $this->getRightsGroup(),
            $keys[13] => $this->getRightsOwner(),
            $keys[14] => $this->getOnglet(),
            $keys[15] => $this->getDateCreation(),
            $keys[16] => $this->getDateModification(),
            $keys[17] => $this->getIdGroupCreation(),
            $keys[18] => $this->getIdCreation(),
            $keys[19] => $this->getIdModification(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAuthyGroupRelatedByIdAuthyGroup) {
                $result['AuthyGroupRelatedByIdAuthyGroup'] = $this->aAuthyGroupRelatedByIdAuthyGroup->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAuthyGroupRelatedByIdGroupCreation) {
                $result['AuthyGroupRelatedByIdGroupCreation'] = $this->aAuthyGroupRelatedByIdGroupCreation->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAuthyRelatedByIdCreation) {
                $result['AuthyRelatedByIdCreation'] = $this->aAuthyRelatedByIdCreation->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAuthyRelatedByIdModification) {
                $result['AuthyRelatedByIdModification'] = $this->aAuthyRelatedByIdModification->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAuthyGroupxes) {
                $result['AuthyGroupxes'] = $this->collAuthyGroupxes->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAuthyLogs) {
                $result['AuthyLogs'] = $this->collAuthyLogs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAuthiesRelatedByIdAuthy0) {
                $result['AuthiesRelatedByIdAuthy0'] = $this->collAuthiesRelatedByIdAuthy0->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAuthiesRelatedByIdAuthy1) {
                $result['AuthiesRelatedByIdAuthy1'] = $this->collAuthiesRelatedByIdAuthy1->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCountriesRelatedByIdCreation) {
                $result['CountriesRelatedByIdCreation'] = $this->collCountriesRelatedByIdCreation->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCountriesRelatedByIdModification) {
                $result['CountriesRelatedByIdModification'] = $this->collCountriesRelatedByIdModification->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAssetsRelatedByIdCreation) {
                $result['AssetsRelatedByIdCreation'] = $this->collAssetsRelatedByIdCreation->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAssetsRelatedByIdModification) {
                $result['AssetsRelatedByIdModification'] = $this->collAssetsRelatedByIdModification->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAssetExchangesRelatedByIdCreation) {
                $result['AssetExchangesRelatedByIdCreation'] = $this->collAssetExchangesRelatedByIdCreation->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAssetExchangesRelatedByIdModification) {
                $result['AssetExchangesRelatedByIdModification'] = $this->collAssetExchangesRelatedByIdModification->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTradesRelatedByIdCreation) {
                $result['TradesRelatedByIdCreation'] = $this->collTradesRelatedByIdCreation->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTradesRelatedByIdModification) {
                $result['TradesRelatedByIdModification'] = $this->collTradesRelatedByIdModification->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collExchangesRelatedByIdCreation) {
                $result['ExchangesRelatedByIdCreation'] = $this->collExchangesRelatedByIdCreation->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collExchangesRelatedByIdModification) {
                $result['ExchangesRelatedByIdModification'] = $this->collExchangesRelatedByIdModification->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTokensRelatedByIdCreation) {
                $result['TokensRelatedByIdCreation'] = $this->collTokensRelatedByIdCreation->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTokensRelatedByIdModification) {
                $result['TokensRelatedByIdModification'] = $this->collTokensRelatedByIdModification->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSymbolsRelatedByIdCreation) {
                $result['SymbolsRelatedByIdCreation'] = $this->collSymbolsRelatedByIdCreation->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSymbolsRelatedByIdModification) {
                $result['SymbolsRelatedByIdModification'] = $this->collSymbolsRelatedByIdModification->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collImportsRelatedByIdCreation) {
                $result['ImportsRelatedByIdCreation'] = $this->collImportsRelatedByIdCreation->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collImportsRelatedByIdModification) {
                $result['ImportsRelatedByIdModification'] = $this->collImportsRelatedByIdModification->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAuthyGroupsRelatedByIdCreation) {
                $result['AuthyGroupsRelatedByIdCreation'] = $this->collAuthyGroupsRelatedByIdCreation->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAuthyGroupsRelatedByIdModification) {
                $result['AuthyGroupsRelatedByIdModification'] = $this->collAuthyGroupsRelatedByIdModification->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collConfigsRelatedByIdCreation) {
                $result['ConfigsRelatedByIdCreation'] = $this->collConfigsRelatedByIdCreation->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collConfigsRelatedByIdModification) {
                $result['ConfigsRelatedByIdModification'] = $this->collConfigsRelatedByIdModification->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collApiRbacsRelatedByIdCreation) {
                $result['ApiRbacsRelatedByIdCreation'] = $this->collApiRbacsRelatedByIdCreation->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collApiRbacsRelatedByIdModification) {
                $result['ApiRbacsRelatedByIdModification'] = $this->collApiRbacsRelatedByIdModification->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collApiLogs) {
                $result['ApiLogs'] = $this->collApiLogs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTemplatesRelatedByIdCreation) {
                $result['TemplatesRelatedByIdCreation'] = $this->collTemplatesRelatedByIdCreation->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTemplatesRelatedByIdModification) {
                $result['TemplatesRelatedByIdModification'] = $this->collTemplatesRelatedByIdModification->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTemplateFilesRelatedByIdCreation) {
                $result['TemplateFilesRelatedByIdCreation'] = $this->collTemplateFilesRelatedByIdCreation->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTemplateFilesRelatedByIdModification) {
                $result['TemplateFilesRelatedByIdModification'] = $this->collTemplateFilesRelatedByIdModification->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMessageI18nsRelatedByIdCreation) {
                $result['MessageI18nsRelatedByIdCreation'] = $this->collMessageI18nsRelatedByIdCreation->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMessageI18nsRelatedByIdModification) {
                $result['MessageI18nsRelatedByIdModification'] = $this->collMessageI18nsRelatedByIdModification->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = AuthyPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdAuthy($value);
                break;
            case 1:
                $this->setValidationKey($value);
                break;
            case 2:
                $this->setUsername($value);
                break;
            case 3:
                $this->setFullname($value);
                break;
            case 4:
                $this->setEmail($value);
                break;
            case 5:
                $this->setPasswdHash($value);
                break;
            case 6:
                $this->setExpire($value);
                break;
            case 7:
                $valueSet = AuthyPeer::getValueSet(AuthyPeer::DEACTIVATE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setDeactivate($value);
                break;
            case 8:
                $valueSet = AuthyPeer::getValueSet(AuthyPeer::IS_ROOT);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setIsRoot($value);
                break;
            case 9:
                $this->setIdAuthyGroup($value);
                break;
            case 10:
                $valueSet = AuthyPeer::getValueSet(AuthyPeer::IS_SYSTEM);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setIsSystem($value);
                break;
            case 11:
                $this->setRightsAll($value);
                break;
            case 12:
                $this->setRightsGroup($value);
                break;
            case 13:
                $this->setRightsOwner($value);
                break;
            case 14:
                $this->setOnglet($value);
                break;
            case 15:
                $this->setDateCreation($value);
                break;
            case 16:
                $this->setDateModification($value);
                break;
            case 17:
                $this->setIdGroupCreation($value);
                break;
            case 18:
                $this->setIdCreation($value);
                break;
            case 19:
                $this->setIdModification($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = AuthyPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdAuthy($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setValidationKey($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setUsername($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setFullname($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setEmail($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setPasswdHash($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setExpire($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setDeactivate($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setIsRoot($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setIdAuthyGroup($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setIsSystem($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setRightsAll($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setRightsGroup($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setRightsOwner($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setOnglet($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setDateCreation($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setDateModification($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setIdGroupCreation($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setIdCreation($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setIdModification($arr[$keys[19]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AuthyPeer::DATABASE_NAME);

        if ($this->isColumnModified(AuthyPeer::ID_AUTHY)) $criteria->add(AuthyPeer::ID_AUTHY, $this->id_authy);
        if ($this->isColumnModified(AuthyPeer::VALIDATION_KEY)) $criteria->add(AuthyPeer::VALIDATION_KEY, $this->validation_key);
        if ($this->isColumnModified(AuthyPeer::USERNAME)) $criteria->add(AuthyPeer::USERNAME, $this->username);
        if ($this->isColumnModified(AuthyPeer::FULLNAME)) $criteria->add(AuthyPeer::FULLNAME, $this->fullname);
        if ($this->isColumnModified(AuthyPeer::EMAIL)) $criteria->add(AuthyPeer::EMAIL, $this->email);
        if ($this->isColumnModified(AuthyPeer::PASSWD_HASH)) $criteria->add(AuthyPeer::PASSWD_HASH, $this->passwd_hash);
        if ($this->isColumnModified(AuthyPeer::EXPIRE)) $criteria->add(AuthyPeer::EXPIRE, $this->expire);
        if ($this->isColumnModified(AuthyPeer::DEACTIVATE)) $criteria->add(AuthyPeer::DEACTIVATE, $this->deactivate);
        if ($this->isColumnModified(AuthyPeer::IS_ROOT)) $criteria->add(AuthyPeer::IS_ROOT, $this->is_root);
        if ($this->isColumnModified(AuthyPeer::ID_AUTHY_GROUP)) $criteria->add(AuthyPeer::ID_AUTHY_GROUP, $this->id_authy_group);
        if ($this->isColumnModified(AuthyPeer::IS_SYSTEM)) $criteria->add(AuthyPeer::IS_SYSTEM, $this->is_system);
        if ($this->isColumnModified(AuthyPeer::RIGHTS_ALL)) $criteria->add(AuthyPeer::RIGHTS_ALL, $this->rights_all);
        if ($this->isColumnModified(AuthyPeer::RIGHTS_GROUP)) $criteria->add(AuthyPeer::RIGHTS_GROUP, $this->rights_group);
        if ($this->isColumnModified(AuthyPeer::RIGHTS_OWNER)) $criteria->add(AuthyPeer::RIGHTS_OWNER, $this->rights_owner);
        if ($this->isColumnModified(AuthyPeer::ONGLET)) $criteria->add(AuthyPeer::ONGLET, $this->onglet);
        if ($this->isColumnModified(AuthyPeer::DATE_CREATION)) $criteria->add(AuthyPeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(AuthyPeer::DATE_MODIFICATION)) $criteria->add(AuthyPeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(AuthyPeer::ID_GROUP_CREATION)) $criteria->add(AuthyPeer::ID_GROUP_CREATION, $this->id_group_creation);
        if ($this->isColumnModified(AuthyPeer::ID_CREATION)) $criteria->add(AuthyPeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(AuthyPeer::ID_MODIFICATION)) $criteria->add(AuthyPeer::ID_MODIFICATION, $this->id_modification);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(AuthyPeer::DATABASE_NAME);
        $criteria->add(AuthyPeer::ID_AUTHY, $this->id_authy);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdAuthy();
    }

    /**
     * Generic method to set the primary key (id_authy column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdAuthy($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdAuthy();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Authy (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setValidationKey($this->getValidationKey());
        $copyObj->setUsername($this->getUsername());
        $copyObj->setFullname($this->getFullname());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setPasswdHash($this->getPasswdHash());
        $copyObj->setExpire($this->getExpire());
        $copyObj->setDeactivate($this->getDeactivate());
        $copyObj->setIsRoot($this->getIsRoot());
        $copyObj->setIdAuthyGroup($this->getIdAuthyGroup());
        $copyObj->setIsSystem($this->getIsSystem());
        $copyObj->setRightsAll($this->getRightsAll());
        $copyObj->setRightsGroup($this->getRightsGroup());
        $copyObj->setRightsOwner($this->getRightsOwner());
        $copyObj->setOnglet($this->getOnglet());
        $copyObj->setDateCreation($this->getDateCreation());
        $copyObj->setDateModification($this->getDateModification());
        $copyObj->setIdGroupCreation($this->getIdGroupCreation());
        $copyObj->setIdCreation($this->getIdCreation());
        $copyObj->setIdModification($this->getIdModification());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getAuthyGroupxes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAuthyGroupX($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAuthyLogs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAuthyLog($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAuthiesRelatedByIdAuthy0() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAuthyRelatedByIdAuthy0($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAuthiesRelatedByIdAuthy1() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAuthyRelatedByIdAuthy1($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCountriesRelatedByIdCreation() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCountryRelatedByIdCreation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCountriesRelatedByIdModification() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCountryRelatedByIdModification($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAssetsRelatedByIdCreation() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAssetRelatedByIdCreation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAssetsRelatedByIdModification() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAssetRelatedByIdModification($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAssetExchangesRelatedByIdCreation() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAssetExchangeRelatedByIdCreation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAssetExchangesRelatedByIdModification() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAssetExchangeRelatedByIdModification($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTradesRelatedByIdCreation() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTradeRelatedByIdCreation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTradesRelatedByIdModification() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTradeRelatedByIdModification($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getExchangesRelatedByIdCreation() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addExchangeRelatedByIdCreation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getExchangesRelatedByIdModification() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addExchangeRelatedByIdModification($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTokensRelatedByIdCreation() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTokenRelatedByIdCreation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTokensRelatedByIdModification() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTokenRelatedByIdModification($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSymbolsRelatedByIdCreation() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSymbolRelatedByIdCreation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSymbolsRelatedByIdModification() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSymbolRelatedByIdModification($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getImportsRelatedByIdCreation() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addImportRelatedByIdCreation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getImportsRelatedByIdModification() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addImportRelatedByIdModification($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAuthyGroupsRelatedByIdCreation() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAuthyGroupRelatedByIdCreation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAuthyGroupsRelatedByIdModification() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAuthyGroupRelatedByIdModification($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getConfigsRelatedByIdCreation() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addConfigRelatedByIdCreation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getConfigsRelatedByIdModification() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addConfigRelatedByIdModification($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getApiRbacsRelatedByIdCreation() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addApiRbacRelatedByIdCreation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getApiRbacsRelatedByIdModification() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addApiRbacRelatedByIdModification($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getApiLogs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addApiLog($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTemplatesRelatedByIdCreation() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTemplateRelatedByIdCreation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTemplatesRelatedByIdModification() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTemplateRelatedByIdModification($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTemplateFilesRelatedByIdCreation() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTemplateFileRelatedByIdCreation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTemplateFilesRelatedByIdModification() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTemplateFileRelatedByIdModification($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMessageI18nsRelatedByIdCreation() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMessageI18nRelatedByIdCreation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMessageI18nsRelatedByIdModification() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMessageI18nRelatedByIdModification($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdAuthy(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Authy Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return AuthyPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AuthyPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a AuthyGroup object.
     *
     * @param                  AuthyGroup $v
     * @return Authy The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAuthyGroupRelatedByIdAuthyGroup(AuthyGroup $v = null)
    {
        if ($v === null) {
            $this->setIdAuthyGroup(1);
        } else {
            $this->setIdAuthyGroup($v->getIdAuthyGroup());
        }

        $this->aAuthyGroupRelatedByIdAuthyGroup = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the AuthyGroup object, it will not be re-added.
        if ($v !== null) {
            $v->addAuthyRelatedByIdAuthyGroup($this);
        }


        return $this;
    }


    /**
     * Get the associated AuthyGroup object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return AuthyGroup The associated AuthyGroup object.
     * @throws PropelException
     */
    public function getAuthyGroupRelatedByIdAuthyGroup(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAuthyGroupRelatedByIdAuthyGroup === null && ($this->id_authy_group !== null) && $doQuery) {
            $this->aAuthyGroupRelatedByIdAuthyGroup = AuthyGroupQuery::create()->findPk($this->id_authy_group, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAuthyGroupRelatedByIdAuthyGroup->addAuthiesRelatedByIdAuthyGroup($this);
             */
        }

        return $this->aAuthyGroupRelatedByIdAuthyGroup;
    }

    /**
     * Declares an association between this object and a AuthyGroup object.
     *
     * @param                  AuthyGroup $v
     * @return Authy The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAuthyGroupRelatedByIdGroupCreation(AuthyGroup $v = null)
    {
        if ($v === null) {
            $this->setIdGroupCreation(NULL);
        } else {
            $this->setIdGroupCreation($v->getIdAuthyGroup());
        }

        $this->aAuthyGroupRelatedByIdGroupCreation = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the AuthyGroup object, it will not be re-added.
        if ($v !== null) {
            $v->addAuthyRelatedByIdGroupCreation($this);
        }


        return $this;
    }


    /**
     * Get the associated AuthyGroup object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return AuthyGroup The associated AuthyGroup object.
     * @throws PropelException
     */
    public function getAuthyGroupRelatedByIdGroupCreation(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAuthyGroupRelatedByIdGroupCreation === null && ($this->id_group_creation !== null) && $doQuery) {
            $this->aAuthyGroupRelatedByIdGroupCreation = AuthyGroupQuery::create()->findPk($this->id_group_creation, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAuthyGroupRelatedByIdGroupCreation->addAuthiesRelatedByIdGroupCreation($this);
             */
        }

        return $this->aAuthyGroupRelatedByIdGroupCreation;
    }

    /**
     * Declares an association between this object and a Authy object.
     *
     * @param                  Authy $v
     * @return Authy The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAuthyRelatedByIdCreation(Authy $v = null)
    {
        if ($v === null) {
            $this->setIdCreation(NULL);
        } else {
            $this->setIdCreation($v->getIdAuthy());
        }

        $this->aAuthyRelatedByIdCreation = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Authy object, it will not be re-added.
        if ($v !== null) {
            $v->addAuthyRelatedByIdAuthy0($this);
        }


        return $this;
    }


    /**
     * Get the associated Authy object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Authy The associated Authy object.
     * @throws PropelException
     */
    public function getAuthyRelatedByIdCreation(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAuthyRelatedByIdCreation === null && ($this->id_creation !== null) && $doQuery) {
            $this->aAuthyRelatedByIdCreation = AuthyQuery::create()->findPk($this->id_creation, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAuthyRelatedByIdCreation->addAuthiesRelatedByIdAuthy0($this);
             */
        }

        return $this->aAuthyRelatedByIdCreation;
    }

    /**
     * Declares an association between this object and a Authy object.
     *
     * @param                  Authy $v
     * @return Authy The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAuthyRelatedByIdModification(Authy $v = null)
    {
        if ($v === null) {
            $this->setIdModification(NULL);
        } else {
            $this->setIdModification($v->getIdAuthy());
        }

        $this->aAuthyRelatedByIdModification = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Authy object, it will not be re-added.
        if ($v !== null) {
            $v->addAuthyRelatedByIdAuthy1($this);
        }


        return $this;
    }


    /**
     * Get the associated Authy object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Authy The associated Authy object.
     * @throws PropelException
     */
    public function getAuthyRelatedByIdModification(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAuthyRelatedByIdModification === null && ($this->id_modification !== null) && $doQuery) {
            $this->aAuthyRelatedByIdModification = AuthyQuery::create()->findPk($this->id_modification, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAuthyRelatedByIdModification->addAuthiesRelatedByIdAuthy1($this);
             */
        }

        return $this->aAuthyRelatedByIdModification;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('AuthyGroupX' == $relationName) {
            $this->initAuthyGroupxes();
        }
        if ('AuthyLog' == $relationName) {
            $this->initAuthyLogs();
        }
        if ('AuthyRelatedByIdAuthy0' == $relationName) {
            $this->initAuthiesRelatedByIdAuthy0();
        }
        if ('AuthyRelatedByIdAuthy1' == $relationName) {
            $this->initAuthiesRelatedByIdAuthy1();
        }
        if ('CountryRelatedByIdCreation' == $relationName) {
            $this->initCountriesRelatedByIdCreation();
        }
        if ('CountryRelatedByIdModification' == $relationName) {
            $this->initCountriesRelatedByIdModification();
        }
        if ('AssetRelatedByIdCreation' == $relationName) {
            $this->initAssetsRelatedByIdCreation();
        }
        if ('AssetRelatedByIdModification' == $relationName) {
            $this->initAssetsRelatedByIdModification();
        }
        if ('AssetExchangeRelatedByIdCreation' == $relationName) {
            $this->initAssetExchangesRelatedByIdCreation();
        }
        if ('AssetExchangeRelatedByIdModification' == $relationName) {
            $this->initAssetExchangesRelatedByIdModification();
        }
        if ('TradeRelatedByIdCreation' == $relationName) {
            $this->initTradesRelatedByIdCreation();
        }
        if ('TradeRelatedByIdModification' == $relationName) {
            $this->initTradesRelatedByIdModification();
        }
        if ('ExchangeRelatedByIdCreation' == $relationName) {
            $this->initExchangesRelatedByIdCreation();
        }
        if ('ExchangeRelatedByIdModification' == $relationName) {
            $this->initExchangesRelatedByIdModification();
        }
        if ('TokenRelatedByIdCreation' == $relationName) {
            $this->initTokensRelatedByIdCreation();
        }
        if ('TokenRelatedByIdModification' == $relationName) {
            $this->initTokensRelatedByIdModification();
        }
        if ('SymbolRelatedByIdCreation' == $relationName) {
            $this->initSymbolsRelatedByIdCreation();
        }
        if ('SymbolRelatedByIdModification' == $relationName) {
            $this->initSymbolsRelatedByIdModification();
        }
        if ('ImportRelatedByIdCreation' == $relationName) {
            $this->initImportsRelatedByIdCreation();
        }
        if ('ImportRelatedByIdModification' == $relationName) {
            $this->initImportsRelatedByIdModification();
        }
        if ('AuthyGroupRelatedByIdCreation' == $relationName) {
            $this->initAuthyGroupsRelatedByIdCreation();
        }
        if ('AuthyGroupRelatedByIdModification' == $relationName) {
            $this->initAuthyGroupsRelatedByIdModification();
        }
        if ('ConfigRelatedByIdCreation' == $relationName) {
            $this->initConfigsRelatedByIdCreation();
        }
        if ('ConfigRelatedByIdModification' == $relationName) {
            $this->initConfigsRelatedByIdModification();
        }
        if ('ApiRbacRelatedByIdCreation' == $relationName) {
            $this->initApiRbacsRelatedByIdCreation();
        }
        if ('ApiRbacRelatedByIdModification' == $relationName) {
            $this->initApiRbacsRelatedByIdModification();
        }
        if ('ApiLog' == $relationName) {
            $this->initApiLogs();
        }
        if ('TemplateRelatedByIdCreation' == $relationName) {
            $this->initTemplatesRelatedByIdCreation();
        }
        if ('TemplateRelatedByIdModification' == $relationName) {
            $this->initTemplatesRelatedByIdModification();
        }
        if ('TemplateFileRelatedByIdCreation' == $relationName) {
            $this->initTemplateFilesRelatedByIdCreation();
        }
        if ('TemplateFileRelatedByIdModification' == $relationName) {
            $this->initTemplateFilesRelatedByIdModification();
        }
        if ('MessageI18nRelatedByIdCreation' == $relationName) {
            $this->initMessageI18nsRelatedByIdCreation();
        }
        if ('MessageI18nRelatedByIdModification' == $relationName) {
            $this->initMessageI18nsRelatedByIdModification();
        }
    }

    /**
     * Clears out the collAuthyGroupxes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addAuthyGroupxes()
     */
    public function clearAuthyGroupxes()
    {
        $this->collAuthyGroupxes = null; // important to set this to null since that means it is uninitialized
        $this->collAuthyGroupxesPartial = null;

        return $this;
    }

    /**
     * reset is the collAuthyGroupxes collection loaded partially
     *
     * @return void
     */
    public function resetPartialAuthyGroupxes($v = true)
    {
        $this->collAuthyGroupxesPartial = $v;
    }

    /**
     * Initializes the collAuthyGroupxes collection.
     *
     * By default this just sets the collAuthyGroupxes collection to an empty array (like clearcollAuthyGroupxes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAuthyGroupxes($overrideExisting = true)
    {
        if (null !== $this->collAuthyGroupxes && !$overrideExisting) {
            return;
        }
        $this->collAuthyGroupxes = new PropelObjectCollection();
        $this->collAuthyGroupxes->setModel('AuthyGroupX');
    }

    /**
     * Gets an array of AuthyGroupX objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AuthyGroupX[] List of AuthyGroupX objects
     * @throws PropelException
     */
    public function getAuthyGroupxes($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAuthyGroupxesPartial && !$this->isNew();
        if (null === $this->collAuthyGroupxes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAuthyGroupxes) {
                // return empty collection
                $this->initAuthyGroupxes();
            } else {
                $collAuthyGroupxes = AuthyGroupXQuery::create(null, $criteria)
                    ->filterByAuthy($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAuthyGroupxesPartial && count($collAuthyGroupxes)) {
                      $this->initAuthyGroupxes(false);

                      foreach ($collAuthyGroupxes as $obj) {
                        if (false == $this->collAuthyGroupxes->contains($obj)) {
                          $this->collAuthyGroupxes->append($obj);
                        }
                      }

                      $this->collAuthyGroupxesPartial = true;
                    }

                    $collAuthyGroupxes->getInternalIterator()->rewind();

                    return $collAuthyGroupxes;
                }

                if ($partial && $this->collAuthyGroupxes) {
                    foreach ($this->collAuthyGroupxes as $obj) {
                        if ($obj->isNew()) {
                            $collAuthyGroupxes[] = $obj;
                        }
                    }
                }

                $this->collAuthyGroupxes = $collAuthyGroupxes;
                $this->collAuthyGroupxesPartial = false;
            }
        }

        return $this->collAuthyGroupxes;
    }

    /**
     * Sets a collection of AuthyGroupX objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $authyGroupxes A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setAuthyGroupxes(PropelCollection $authyGroupxes, PropelPDO $con = null)
    {
        $authyGroupxesToDelete = $this->getAuthyGroupxes(new Criteria(), $con)->diff($authyGroupxes);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->authyGroupxesScheduledForDeletion = clone $authyGroupxesToDelete;

        foreach ($authyGroupxesToDelete as $authyGroupXRemoved) {
            $authyGroupXRemoved->setAuthy(null);
        }

        $this->collAuthyGroupxes = null;
        foreach ($authyGroupxes as $authyGroupX) {
            $this->addAuthyGroupX($authyGroupX);
        }

        $this->collAuthyGroupxes = $authyGroupxes;
        $this->collAuthyGroupxesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AuthyGroupX objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AuthyGroupX objects.
     * @throws PropelException
     */
    public function countAuthyGroupxes(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAuthyGroupxesPartial && !$this->isNew();
        if (null === $this->collAuthyGroupxes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAuthyGroupxes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAuthyGroupxes());
            }
            $query = AuthyGroupXQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthy($this)
                ->count($con);
        }

        return count($this->collAuthyGroupxes);
    }

    /**
     * Method called to associate a AuthyGroupX object to this object
     * through the AuthyGroupX foreign key attribute.
     *
     * @param    AuthyGroupX $l AuthyGroupX
     * @return Authy The current object (for fluent API support)
     */
    public function addAuthyGroupX(AuthyGroupX $l)
    {
        if ($this->collAuthyGroupxes === null) {
            $this->initAuthyGroupxes();
            $this->collAuthyGroupxesPartial = true;
        }

        if (!in_array($l, $this->collAuthyGroupxes->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAuthyGroupX($l);

            if ($this->authyGroupxesScheduledForDeletion and $this->authyGroupxesScheduledForDeletion->contains($l)) {
                $this->authyGroupxesScheduledForDeletion->remove($this->authyGroupxesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AuthyGroupX $authyGroupX The authyGroupX object to add.
     */
    protected function doAddAuthyGroupX($authyGroupX)
    {
        $this->collAuthyGroupxes[]= $authyGroupX;
        $authyGroupX->setAuthy($this);
    }

    /**
     * @param	AuthyGroupX $authyGroupX The authyGroupX object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeAuthyGroupX($authyGroupX)
    {
        if ($this->getAuthyGroupxes()->contains($authyGroupX)) {
            $this->collAuthyGroupxes->remove($this->collAuthyGroupxes->search($authyGroupX));
            if (null === $this->authyGroupxesScheduledForDeletion) {
                $this->authyGroupxesScheduledForDeletion = clone $this->collAuthyGroupxes;
                $this->authyGroupxesScheduledForDeletion->clear();
            }
            $this->authyGroupxesScheduledForDeletion[]= clone $authyGroupX;
            $authyGroupX->setAuthy(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AuthyGroupX[] List of AuthyGroupX objects
     */
    public function getAuthyGroupxesJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AuthyGroupXQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getAuthyGroupxes($query, $con);
    }

    /**
     * Clears out the collAuthyLogs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addAuthyLogs()
     */
    public function clearAuthyLogs()
    {
        $this->collAuthyLogs = null; // important to set this to null since that means it is uninitialized
        $this->collAuthyLogsPartial = null;

        return $this;
    }

    /**
     * reset is the collAuthyLogs collection loaded partially
     *
     * @return void
     */
    public function resetPartialAuthyLogs($v = true)
    {
        $this->collAuthyLogsPartial = $v;
    }

    /**
     * Initializes the collAuthyLogs collection.
     *
     * By default this just sets the collAuthyLogs collection to an empty array (like clearcollAuthyLogs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAuthyLogs($overrideExisting = true)
    {
        if (null !== $this->collAuthyLogs && !$overrideExisting) {
            return;
        }
        $this->collAuthyLogs = new PropelObjectCollection();
        $this->collAuthyLogs->setModel('AuthyLog');
    }

    /**
     * Gets an array of AuthyLog objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AuthyLog[] List of AuthyLog objects
     * @throws PropelException
     */
    public function getAuthyLogs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAuthyLogsPartial && !$this->isNew();
        if (null === $this->collAuthyLogs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAuthyLogs) {
                // return empty collection
                $this->initAuthyLogs();
            } else {
                $collAuthyLogs = AuthyLogQuery::create(null, $criteria)
                    ->filterByAuthy($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAuthyLogsPartial && count($collAuthyLogs)) {
                      $this->initAuthyLogs(false);

                      foreach ($collAuthyLogs as $obj) {
                        if (false == $this->collAuthyLogs->contains($obj)) {
                          $this->collAuthyLogs->append($obj);
                        }
                      }

                      $this->collAuthyLogsPartial = true;
                    }

                    $collAuthyLogs->getInternalIterator()->rewind();

                    return $collAuthyLogs;
                }

                if ($partial && $this->collAuthyLogs) {
                    foreach ($this->collAuthyLogs as $obj) {
                        if ($obj->isNew()) {
                            $collAuthyLogs[] = $obj;
                        }
                    }
                }

                $this->collAuthyLogs = $collAuthyLogs;
                $this->collAuthyLogsPartial = false;
            }
        }

        return $this->collAuthyLogs;
    }

    /**
     * Sets a collection of AuthyLog objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $authyLogs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setAuthyLogs(PropelCollection $authyLogs, PropelPDO $con = null)
    {
        $authyLogsToDelete = $this->getAuthyLogs(new Criteria(), $con)->diff($authyLogs);


        $this->authyLogsScheduledForDeletion = $authyLogsToDelete;

        foreach ($authyLogsToDelete as $authyLogRemoved) {
            $authyLogRemoved->setAuthy(null);
        }

        $this->collAuthyLogs = null;
        foreach ($authyLogs as $authyLog) {
            $this->addAuthyLog($authyLog);
        }

        $this->collAuthyLogs = $authyLogs;
        $this->collAuthyLogsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AuthyLog objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AuthyLog objects.
     * @throws PropelException
     */
    public function countAuthyLogs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAuthyLogsPartial && !$this->isNew();
        if (null === $this->collAuthyLogs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAuthyLogs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAuthyLogs());
            }
            $query = AuthyLogQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthy($this)
                ->count($con);
        }

        return count($this->collAuthyLogs);
    }

    /**
     * Method called to associate a AuthyLog object to this object
     * through the AuthyLog foreign key attribute.
     *
     * @param    AuthyLog $l AuthyLog
     * @return Authy The current object (for fluent API support)
     */
    public function addAuthyLog(AuthyLog $l)
    {
        if ($this->collAuthyLogs === null) {
            $this->initAuthyLogs();
            $this->collAuthyLogsPartial = true;
        }

        if (!in_array($l, $this->collAuthyLogs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAuthyLog($l);

            if ($this->authyLogsScheduledForDeletion and $this->authyLogsScheduledForDeletion->contains($l)) {
                $this->authyLogsScheduledForDeletion->remove($this->authyLogsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AuthyLog $authyLog The authyLog object to add.
     */
    protected function doAddAuthyLog($authyLog)
    {
        $this->collAuthyLogs[]= $authyLog;
        $authyLog->setAuthy($this);
    }

    /**
     * @param	AuthyLog $authyLog The authyLog object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeAuthyLog($authyLog)
    {
        if ($this->getAuthyLogs()->contains($authyLog)) {
            $this->collAuthyLogs->remove($this->collAuthyLogs->search($authyLog));
            if (null === $this->authyLogsScheduledForDeletion) {
                $this->authyLogsScheduledForDeletion = clone $this->collAuthyLogs;
                $this->authyLogsScheduledForDeletion->clear();
            }
            $this->authyLogsScheduledForDeletion[]= $authyLog;
            $authyLog->setAuthy(null);
        }

        return $this;
    }

    /**
     * Clears out the collAuthiesRelatedByIdAuthy0 collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addAuthiesRelatedByIdAuthy0()
     */
    public function clearAuthiesRelatedByIdAuthy0()
    {
        $this->collAuthiesRelatedByIdAuthy0 = null; // important to set this to null since that means it is uninitialized
        $this->collAuthiesRelatedByIdAuthy0Partial = null;

        return $this;
    }

    /**
     * reset is the collAuthiesRelatedByIdAuthy0 collection loaded partially
     *
     * @return void
     */
    public function resetPartialAuthiesRelatedByIdAuthy0($v = true)
    {
        $this->collAuthiesRelatedByIdAuthy0Partial = $v;
    }

    /**
     * Initializes the collAuthiesRelatedByIdAuthy0 collection.
     *
     * By default this just sets the collAuthiesRelatedByIdAuthy0 collection to an empty array (like clearcollAuthiesRelatedByIdAuthy0());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAuthiesRelatedByIdAuthy0($overrideExisting = true)
    {
        if (null !== $this->collAuthiesRelatedByIdAuthy0 && !$overrideExisting) {
            return;
        }
        $this->collAuthiesRelatedByIdAuthy0 = new PropelObjectCollection();
        $this->collAuthiesRelatedByIdAuthy0->setModel('Authy');
    }

    /**
     * Gets an array of Authy objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Authy[] List of Authy objects
     * @throws PropelException
     */
    public function getAuthiesRelatedByIdAuthy0($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAuthiesRelatedByIdAuthy0Partial && !$this->isNew();
        if (null === $this->collAuthiesRelatedByIdAuthy0 || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAuthiesRelatedByIdAuthy0) {
                // return empty collection
                $this->initAuthiesRelatedByIdAuthy0();
            } else {
                $collAuthiesRelatedByIdAuthy0 = AuthyQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdCreation($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAuthiesRelatedByIdAuthy0Partial && count($collAuthiesRelatedByIdAuthy0)) {
                      $this->initAuthiesRelatedByIdAuthy0(false);

                      foreach ($collAuthiesRelatedByIdAuthy0 as $obj) {
                        if (false == $this->collAuthiesRelatedByIdAuthy0->contains($obj)) {
                          $this->collAuthiesRelatedByIdAuthy0->append($obj);
                        }
                      }

                      $this->collAuthiesRelatedByIdAuthy0Partial = true;
                    }

                    $collAuthiesRelatedByIdAuthy0->getInternalIterator()->rewind();

                    return $collAuthiesRelatedByIdAuthy0;
                }

                if ($partial && $this->collAuthiesRelatedByIdAuthy0) {
                    foreach ($this->collAuthiesRelatedByIdAuthy0 as $obj) {
                        if ($obj->isNew()) {
                            $collAuthiesRelatedByIdAuthy0[] = $obj;
                        }
                    }
                }

                $this->collAuthiesRelatedByIdAuthy0 = $collAuthiesRelatedByIdAuthy0;
                $this->collAuthiesRelatedByIdAuthy0Partial = false;
            }
        }

        return $this->collAuthiesRelatedByIdAuthy0;
    }

    /**
     * Sets a collection of AuthyRelatedByIdAuthy0 objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $authiesRelatedByIdAuthy0 A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setAuthiesRelatedByIdAuthy0(PropelCollection $authiesRelatedByIdAuthy0, PropelPDO $con = null)
    {
        $authiesRelatedByIdAuthy0ToDelete = $this->getAuthiesRelatedByIdAuthy0(new Criteria(), $con)->diff($authiesRelatedByIdAuthy0);


        $this->authiesRelatedByIdAuthy0ScheduledForDeletion = $authiesRelatedByIdAuthy0ToDelete;

        foreach ($authiesRelatedByIdAuthy0ToDelete as $authyRelatedByIdAuthy0Removed) {
            $authyRelatedByIdAuthy0Removed->setAuthyRelatedByIdCreation(null);
        }

        $this->collAuthiesRelatedByIdAuthy0 = null;
        foreach ($authiesRelatedByIdAuthy0 as $authyRelatedByIdAuthy0) {
            $this->addAuthyRelatedByIdAuthy0($authyRelatedByIdAuthy0);
        }

        $this->collAuthiesRelatedByIdAuthy0 = $authiesRelatedByIdAuthy0;
        $this->collAuthiesRelatedByIdAuthy0Partial = false;

        return $this;
    }

    /**
     * Returns the number of related Authy objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Authy objects.
     * @throws PropelException
     */
    public function countAuthiesRelatedByIdAuthy0(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAuthiesRelatedByIdAuthy0Partial && !$this->isNew();
        if (null === $this->collAuthiesRelatedByIdAuthy0 || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAuthiesRelatedByIdAuthy0) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAuthiesRelatedByIdAuthy0());
            }
            $query = AuthyQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdCreation($this)
                ->count($con);
        }

        return count($this->collAuthiesRelatedByIdAuthy0);
    }

    /**
     * Method called to associate a Authy object to this object
     * through the Authy foreign key attribute.
     *
     * @param    Authy $l Authy
     * @return Authy The current object (for fluent API support)
     */
    public function addAuthyRelatedByIdAuthy0(Authy $l)
    {
        if ($this->collAuthiesRelatedByIdAuthy0 === null) {
            $this->initAuthiesRelatedByIdAuthy0();
            $this->collAuthiesRelatedByIdAuthy0Partial = true;
        }

        if (!in_array($l, $this->collAuthiesRelatedByIdAuthy0->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAuthyRelatedByIdAuthy0($l);

            if ($this->authiesRelatedByIdAuthy0ScheduledForDeletion and $this->authiesRelatedByIdAuthy0ScheduledForDeletion->contains($l)) {
                $this->authiesRelatedByIdAuthy0ScheduledForDeletion->remove($this->authiesRelatedByIdAuthy0ScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AuthyRelatedByIdAuthy0 $authyRelatedByIdAuthy0 The authyRelatedByIdAuthy0 object to add.
     */
    protected function doAddAuthyRelatedByIdAuthy0($authyRelatedByIdAuthy0)
    {
        $this->collAuthiesRelatedByIdAuthy0[]= $authyRelatedByIdAuthy0;
        $authyRelatedByIdAuthy0->setAuthyRelatedByIdCreation($this);
    }

    /**
     * @param	AuthyRelatedByIdAuthy0 $authyRelatedByIdAuthy0 The authyRelatedByIdAuthy0 object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeAuthyRelatedByIdAuthy0($authyRelatedByIdAuthy0)
    {
        if ($this->getAuthiesRelatedByIdAuthy0()->contains($authyRelatedByIdAuthy0)) {
            $this->collAuthiesRelatedByIdAuthy0->remove($this->collAuthiesRelatedByIdAuthy0->search($authyRelatedByIdAuthy0));
            if (null === $this->authiesRelatedByIdAuthy0ScheduledForDeletion) {
                $this->authiesRelatedByIdAuthy0ScheduledForDeletion = clone $this->collAuthiesRelatedByIdAuthy0;
                $this->authiesRelatedByIdAuthy0ScheduledForDeletion->clear();
            }
            $this->authiesRelatedByIdAuthy0ScheduledForDeletion[]= $authyRelatedByIdAuthy0;
            $authyRelatedByIdAuthy0->setAuthyRelatedByIdCreation(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Authy[] List of Authy objects
     */
    public function getAuthiesRelatedByIdAuthy0JoinAuthyGroupRelatedByIdAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AuthyQuery::create(null, $criteria);
        $query->joinWith('AuthyGroupRelatedByIdAuthyGroup', $join_behavior);

        return $this->getAuthiesRelatedByIdAuthy0($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Authy[] List of Authy objects
     */
    public function getAuthiesRelatedByIdAuthy0JoinAuthyGroupRelatedByIdGroupCreation($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AuthyQuery::create(null, $criteria);
        $query->joinWith('AuthyGroupRelatedByIdGroupCreation', $join_behavior);

        return $this->getAuthiesRelatedByIdAuthy0($query, $con);
    }

    /**
     * Clears out the collAuthiesRelatedByIdAuthy1 collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addAuthiesRelatedByIdAuthy1()
     */
    public function clearAuthiesRelatedByIdAuthy1()
    {
        $this->collAuthiesRelatedByIdAuthy1 = null; // important to set this to null since that means it is uninitialized
        $this->collAuthiesRelatedByIdAuthy1Partial = null;

        return $this;
    }

    /**
     * reset is the collAuthiesRelatedByIdAuthy1 collection loaded partially
     *
     * @return void
     */
    public function resetPartialAuthiesRelatedByIdAuthy1($v = true)
    {
        $this->collAuthiesRelatedByIdAuthy1Partial = $v;
    }

    /**
     * Initializes the collAuthiesRelatedByIdAuthy1 collection.
     *
     * By default this just sets the collAuthiesRelatedByIdAuthy1 collection to an empty array (like clearcollAuthiesRelatedByIdAuthy1());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAuthiesRelatedByIdAuthy1($overrideExisting = true)
    {
        if (null !== $this->collAuthiesRelatedByIdAuthy1 && !$overrideExisting) {
            return;
        }
        $this->collAuthiesRelatedByIdAuthy1 = new PropelObjectCollection();
        $this->collAuthiesRelatedByIdAuthy1->setModel('Authy');
    }

    /**
     * Gets an array of Authy objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Authy[] List of Authy objects
     * @throws PropelException
     */
    public function getAuthiesRelatedByIdAuthy1($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAuthiesRelatedByIdAuthy1Partial && !$this->isNew();
        if (null === $this->collAuthiesRelatedByIdAuthy1 || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAuthiesRelatedByIdAuthy1) {
                // return empty collection
                $this->initAuthiesRelatedByIdAuthy1();
            } else {
                $collAuthiesRelatedByIdAuthy1 = AuthyQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdModification($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAuthiesRelatedByIdAuthy1Partial && count($collAuthiesRelatedByIdAuthy1)) {
                      $this->initAuthiesRelatedByIdAuthy1(false);

                      foreach ($collAuthiesRelatedByIdAuthy1 as $obj) {
                        if (false == $this->collAuthiesRelatedByIdAuthy1->contains($obj)) {
                          $this->collAuthiesRelatedByIdAuthy1->append($obj);
                        }
                      }

                      $this->collAuthiesRelatedByIdAuthy1Partial = true;
                    }

                    $collAuthiesRelatedByIdAuthy1->getInternalIterator()->rewind();

                    return $collAuthiesRelatedByIdAuthy1;
                }

                if ($partial && $this->collAuthiesRelatedByIdAuthy1) {
                    foreach ($this->collAuthiesRelatedByIdAuthy1 as $obj) {
                        if ($obj->isNew()) {
                            $collAuthiesRelatedByIdAuthy1[] = $obj;
                        }
                    }
                }

                $this->collAuthiesRelatedByIdAuthy1 = $collAuthiesRelatedByIdAuthy1;
                $this->collAuthiesRelatedByIdAuthy1Partial = false;
            }
        }

        return $this->collAuthiesRelatedByIdAuthy1;
    }

    /**
     * Sets a collection of AuthyRelatedByIdAuthy1 objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $authiesRelatedByIdAuthy1 A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setAuthiesRelatedByIdAuthy1(PropelCollection $authiesRelatedByIdAuthy1, PropelPDO $con = null)
    {
        $authiesRelatedByIdAuthy1ToDelete = $this->getAuthiesRelatedByIdAuthy1(new Criteria(), $con)->diff($authiesRelatedByIdAuthy1);


        $this->authiesRelatedByIdAuthy1ScheduledForDeletion = $authiesRelatedByIdAuthy1ToDelete;

        foreach ($authiesRelatedByIdAuthy1ToDelete as $authyRelatedByIdAuthy1Removed) {
            $authyRelatedByIdAuthy1Removed->setAuthyRelatedByIdModification(null);
        }

        $this->collAuthiesRelatedByIdAuthy1 = null;
        foreach ($authiesRelatedByIdAuthy1 as $authyRelatedByIdAuthy1) {
            $this->addAuthyRelatedByIdAuthy1($authyRelatedByIdAuthy1);
        }

        $this->collAuthiesRelatedByIdAuthy1 = $authiesRelatedByIdAuthy1;
        $this->collAuthiesRelatedByIdAuthy1Partial = false;

        return $this;
    }

    /**
     * Returns the number of related Authy objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Authy objects.
     * @throws PropelException
     */
    public function countAuthiesRelatedByIdAuthy1(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAuthiesRelatedByIdAuthy1Partial && !$this->isNew();
        if (null === $this->collAuthiesRelatedByIdAuthy1 || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAuthiesRelatedByIdAuthy1) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAuthiesRelatedByIdAuthy1());
            }
            $query = AuthyQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdModification($this)
                ->count($con);
        }

        return count($this->collAuthiesRelatedByIdAuthy1);
    }

    /**
     * Method called to associate a Authy object to this object
     * through the Authy foreign key attribute.
     *
     * @param    Authy $l Authy
     * @return Authy The current object (for fluent API support)
     */
    public function addAuthyRelatedByIdAuthy1(Authy $l)
    {
        if ($this->collAuthiesRelatedByIdAuthy1 === null) {
            $this->initAuthiesRelatedByIdAuthy1();
            $this->collAuthiesRelatedByIdAuthy1Partial = true;
        }

        if (!in_array($l, $this->collAuthiesRelatedByIdAuthy1->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAuthyRelatedByIdAuthy1($l);

            if ($this->authiesRelatedByIdAuthy1ScheduledForDeletion and $this->authiesRelatedByIdAuthy1ScheduledForDeletion->contains($l)) {
                $this->authiesRelatedByIdAuthy1ScheduledForDeletion->remove($this->authiesRelatedByIdAuthy1ScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AuthyRelatedByIdAuthy1 $authyRelatedByIdAuthy1 The authyRelatedByIdAuthy1 object to add.
     */
    protected function doAddAuthyRelatedByIdAuthy1($authyRelatedByIdAuthy1)
    {
        $this->collAuthiesRelatedByIdAuthy1[]= $authyRelatedByIdAuthy1;
        $authyRelatedByIdAuthy1->setAuthyRelatedByIdModification($this);
    }

    /**
     * @param	AuthyRelatedByIdAuthy1 $authyRelatedByIdAuthy1 The authyRelatedByIdAuthy1 object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeAuthyRelatedByIdAuthy1($authyRelatedByIdAuthy1)
    {
        if ($this->getAuthiesRelatedByIdAuthy1()->contains($authyRelatedByIdAuthy1)) {
            $this->collAuthiesRelatedByIdAuthy1->remove($this->collAuthiesRelatedByIdAuthy1->search($authyRelatedByIdAuthy1));
            if (null === $this->authiesRelatedByIdAuthy1ScheduledForDeletion) {
                $this->authiesRelatedByIdAuthy1ScheduledForDeletion = clone $this->collAuthiesRelatedByIdAuthy1;
                $this->authiesRelatedByIdAuthy1ScheduledForDeletion->clear();
            }
            $this->authiesRelatedByIdAuthy1ScheduledForDeletion[]= $authyRelatedByIdAuthy1;
            $authyRelatedByIdAuthy1->setAuthyRelatedByIdModification(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Authy[] List of Authy objects
     */
    public function getAuthiesRelatedByIdAuthy1JoinAuthyGroupRelatedByIdAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AuthyQuery::create(null, $criteria);
        $query->joinWith('AuthyGroupRelatedByIdAuthyGroup', $join_behavior);

        return $this->getAuthiesRelatedByIdAuthy1($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Authy[] List of Authy objects
     */
    public function getAuthiesRelatedByIdAuthy1JoinAuthyGroupRelatedByIdGroupCreation($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AuthyQuery::create(null, $criteria);
        $query->joinWith('AuthyGroupRelatedByIdGroupCreation', $join_behavior);

        return $this->getAuthiesRelatedByIdAuthy1($query, $con);
    }

    /**
     * Clears out the collCountriesRelatedByIdCreation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addCountriesRelatedByIdCreation()
     */
    public function clearCountriesRelatedByIdCreation()
    {
        $this->collCountriesRelatedByIdCreation = null; // important to set this to null since that means it is uninitialized
        $this->collCountriesRelatedByIdCreationPartial = null;

        return $this;
    }

    /**
     * reset is the collCountriesRelatedByIdCreation collection loaded partially
     *
     * @return void
     */
    public function resetPartialCountriesRelatedByIdCreation($v = true)
    {
        $this->collCountriesRelatedByIdCreationPartial = $v;
    }

    /**
     * Initializes the collCountriesRelatedByIdCreation collection.
     *
     * By default this just sets the collCountriesRelatedByIdCreation collection to an empty array (like clearcollCountriesRelatedByIdCreation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCountriesRelatedByIdCreation($overrideExisting = true)
    {
        if (null !== $this->collCountriesRelatedByIdCreation && !$overrideExisting) {
            return;
        }
        $this->collCountriesRelatedByIdCreation = new PropelObjectCollection();
        $this->collCountriesRelatedByIdCreation->setModel('Country');
    }

    /**
     * Gets an array of Country objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Country[] List of Country objects
     * @throws PropelException
     */
    public function getCountriesRelatedByIdCreation($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCountriesRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collCountriesRelatedByIdCreation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCountriesRelatedByIdCreation) {
                // return empty collection
                $this->initCountriesRelatedByIdCreation();
            } else {
                $collCountriesRelatedByIdCreation = CountryQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdCreation($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCountriesRelatedByIdCreationPartial && count($collCountriesRelatedByIdCreation)) {
                      $this->initCountriesRelatedByIdCreation(false);

                      foreach ($collCountriesRelatedByIdCreation as $obj) {
                        if (false == $this->collCountriesRelatedByIdCreation->contains($obj)) {
                          $this->collCountriesRelatedByIdCreation->append($obj);
                        }
                      }

                      $this->collCountriesRelatedByIdCreationPartial = true;
                    }

                    $collCountriesRelatedByIdCreation->getInternalIterator()->rewind();

                    return $collCountriesRelatedByIdCreation;
                }

                if ($partial && $this->collCountriesRelatedByIdCreation) {
                    foreach ($this->collCountriesRelatedByIdCreation as $obj) {
                        if ($obj->isNew()) {
                            $collCountriesRelatedByIdCreation[] = $obj;
                        }
                    }
                }

                $this->collCountriesRelatedByIdCreation = $collCountriesRelatedByIdCreation;
                $this->collCountriesRelatedByIdCreationPartial = false;
            }
        }

        return $this->collCountriesRelatedByIdCreation;
    }

    /**
     * Sets a collection of CountryRelatedByIdCreation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $countriesRelatedByIdCreation A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setCountriesRelatedByIdCreation(PropelCollection $countriesRelatedByIdCreation, PropelPDO $con = null)
    {
        $countriesRelatedByIdCreationToDelete = $this->getCountriesRelatedByIdCreation(new Criteria(), $con)->diff($countriesRelatedByIdCreation);


        $this->countriesRelatedByIdCreationScheduledForDeletion = $countriesRelatedByIdCreationToDelete;

        foreach ($countriesRelatedByIdCreationToDelete as $countryRelatedByIdCreationRemoved) {
            $countryRelatedByIdCreationRemoved->setAuthyRelatedByIdCreation(null);
        }

        $this->collCountriesRelatedByIdCreation = null;
        foreach ($countriesRelatedByIdCreation as $countryRelatedByIdCreation) {
            $this->addCountryRelatedByIdCreation($countryRelatedByIdCreation);
        }

        $this->collCountriesRelatedByIdCreation = $countriesRelatedByIdCreation;
        $this->collCountriesRelatedByIdCreationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Country objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Country objects.
     * @throws PropelException
     */
    public function countCountriesRelatedByIdCreation(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCountriesRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collCountriesRelatedByIdCreation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCountriesRelatedByIdCreation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCountriesRelatedByIdCreation());
            }
            $query = CountryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdCreation($this)
                ->count($con);
        }

        return count($this->collCountriesRelatedByIdCreation);
    }

    /**
     * Method called to associate a Country object to this object
     * through the Country foreign key attribute.
     *
     * @param    Country $l Country
     * @return Authy The current object (for fluent API support)
     */
    public function addCountryRelatedByIdCreation(Country $l)
    {
        if ($this->collCountriesRelatedByIdCreation === null) {
            $this->initCountriesRelatedByIdCreation();
            $this->collCountriesRelatedByIdCreationPartial = true;
        }

        if (!in_array($l, $this->collCountriesRelatedByIdCreation->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCountryRelatedByIdCreation($l);

            if ($this->countriesRelatedByIdCreationScheduledForDeletion and $this->countriesRelatedByIdCreationScheduledForDeletion->contains($l)) {
                $this->countriesRelatedByIdCreationScheduledForDeletion->remove($this->countriesRelatedByIdCreationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	CountryRelatedByIdCreation $countryRelatedByIdCreation The countryRelatedByIdCreation object to add.
     */
    protected function doAddCountryRelatedByIdCreation($countryRelatedByIdCreation)
    {
        $this->collCountriesRelatedByIdCreation[]= $countryRelatedByIdCreation;
        $countryRelatedByIdCreation->setAuthyRelatedByIdCreation($this);
    }

    /**
     * @param	CountryRelatedByIdCreation $countryRelatedByIdCreation The countryRelatedByIdCreation object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeCountryRelatedByIdCreation($countryRelatedByIdCreation)
    {
        if ($this->getCountriesRelatedByIdCreation()->contains($countryRelatedByIdCreation)) {
            $this->collCountriesRelatedByIdCreation->remove($this->collCountriesRelatedByIdCreation->search($countryRelatedByIdCreation));
            if (null === $this->countriesRelatedByIdCreationScheduledForDeletion) {
                $this->countriesRelatedByIdCreationScheduledForDeletion = clone $this->collCountriesRelatedByIdCreation;
                $this->countriesRelatedByIdCreationScheduledForDeletion->clear();
            }
            $this->countriesRelatedByIdCreationScheduledForDeletion[]= $countryRelatedByIdCreation;
            $countryRelatedByIdCreation->setAuthyRelatedByIdCreation(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Country[] List of Country objects
     */
    public function getCountriesRelatedByIdCreationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CountryQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getCountriesRelatedByIdCreation($query, $con);
    }

    /**
     * Clears out the collCountriesRelatedByIdModification collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addCountriesRelatedByIdModification()
     */
    public function clearCountriesRelatedByIdModification()
    {
        $this->collCountriesRelatedByIdModification = null; // important to set this to null since that means it is uninitialized
        $this->collCountriesRelatedByIdModificationPartial = null;

        return $this;
    }

    /**
     * reset is the collCountriesRelatedByIdModification collection loaded partially
     *
     * @return void
     */
    public function resetPartialCountriesRelatedByIdModification($v = true)
    {
        $this->collCountriesRelatedByIdModificationPartial = $v;
    }

    /**
     * Initializes the collCountriesRelatedByIdModification collection.
     *
     * By default this just sets the collCountriesRelatedByIdModification collection to an empty array (like clearcollCountriesRelatedByIdModification());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCountriesRelatedByIdModification($overrideExisting = true)
    {
        if (null !== $this->collCountriesRelatedByIdModification && !$overrideExisting) {
            return;
        }
        $this->collCountriesRelatedByIdModification = new PropelObjectCollection();
        $this->collCountriesRelatedByIdModification->setModel('Country');
    }

    /**
     * Gets an array of Country objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Country[] List of Country objects
     * @throws PropelException
     */
    public function getCountriesRelatedByIdModification($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCountriesRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collCountriesRelatedByIdModification || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCountriesRelatedByIdModification) {
                // return empty collection
                $this->initCountriesRelatedByIdModification();
            } else {
                $collCountriesRelatedByIdModification = CountryQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdModification($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCountriesRelatedByIdModificationPartial && count($collCountriesRelatedByIdModification)) {
                      $this->initCountriesRelatedByIdModification(false);

                      foreach ($collCountriesRelatedByIdModification as $obj) {
                        if (false == $this->collCountriesRelatedByIdModification->contains($obj)) {
                          $this->collCountriesRelatedByIdModification->append($obj);
                        }
                      }

                      $this->collCountriesRelatedByIdModificationPartial = true;
                    }

                    $collCountriesRelatedByIdModification->getInternalIterator()->rewind();

                    return $collCountriesRelatedByIdModification;
                }

                if ($partial && $this->collCountriesRelatedByIdModification) {
                    foreach ($this->collCountriesRelatedByIdModification as $obj) {
                        if ($obj->isNew()) {
                            $collCountriesRelatedByIdModification[] = $obj;
                        }
                    }
                }

                $this->collCountriesRelatedByIdModification = $collCountriesRelatedByIdModification;
                $this->collCountriesRelatedByIdModificationPartial = false;
            }
        }

        return $this->collCountriesRelatedByIdModification;
    }

    /**
     * Sets a collection of CountryRelatedByIdModification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $countriesRelatedByIdModification A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setCountriesRelatedByIdModification(PropelCollection $countriesRelatedByIdModification, PropelPDO $con = null)
    {
        $countriesRelatedByIdModificationToDelete = $this->getCountriesRelatedByIdModification(new Criteria(), $con)->diff($countriesRelatedByIdModification);


        $this->countriesRelatedByIdModificationScheduledForDeletion = $countriesRelatedByIdModificationToDelete;

        foreach ($countriesRelatedByIdModificationToDelete as $countryRelatedByIdModificationRemoved) {
            $countryRelatedByIdModificationRemoved->setAuthyRelatedByIdModification(null);
        }

        $this->collCountriesRelatedByIdModification = null;
        foreach ($countriesRelatedByIdModification as $countryRelatedByIdModification) {
            $this->addCountryRelatedByIdModification($countryRelatedByIdModification);
        }

        $this->collCountriesRelatedByIdModification = $countriesRelatedByIdModification;
        $this->collCountriesRelatedByIdModificationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Country objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Country objects.
     * @throws PropelException
     */
    public function countCountriesRelatedByIdModification(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCountriesRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collCountriesRelatedByIdModification || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCountriesRelatedByIdModification) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCountriesRelatedByIdModification());
            }
            $query = CountryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdModification($this)
                ->count($con);
        }

        return count($this->collCountriesRelatedByIdModification);
    }

    /**
     * Method called to associate a Country object to this object
     * through the Country foreign key attribute.
     *
     * @param    Country $l Country
     * @return Authy The current object (for fluent API support)
     */
    public function addCountryRelatedByIdModification(Country $l)
    {
        if ($this->collCountriesRelatedByIdModification === null) {
            $this->initCountriesRelatedByIdModification();
            $this->collCountriesRelatedByIdModificationPartial = true;
        }

        if (!in_array($l, $this->collCountriesRelatedByIdModification->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCountryRelatedByIdModification($l);

            if ($this->countriesRelatedByIdModificationScheduledForDeletion and $this->countriesRelatedByIdModificationScheduledForDeletion->contains($l)) {
                $this->countriesRelatedByIdModificationScheduledForDeletion->remove($this->countriesRelatedByIdModificationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	CountryRelatedByIdModification $countryRelatedByIdModification The countryRelatedByIdModification object to add.
     */
    protected function doAddCountryRelatedByIdModification($countryRelatedByIdModification)
    {
        $this->collCountriesRelatedByIdModification[]= $countryRelatedByIdModification;
        $countryRelatedByIdModification->setAuthyRelatedByIdModification($this);
    }

    /**
     * @param	CountryRelatedByIdModification $countryRelatedByIdModification The countryRelatedByIdModification object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeCountryRelatedByIdModification($countryRelatedByIdModification)
    {
        if ($this->getCountriesRelatedByIdModification()->contains($countryRelatedByIdModification)) {
            $this->collCountriesRelatedByIdModification->remove($this->collCountriesRelatedByIdModification->search($countryRelatedByIdModification));
            if (null === $this->countriesRelatedByIdModificationScheduledForDeletion) {
                $this->countriesRelatedByIdModificationScheduledForDeletion = clone $this->collCountriesRelatedByIdModification;
                $this->countriesRelatedByIdModificationScheduledForDeletion->clear();
            }
            $this->countriesRelatedByIdModificationScheduledForDeletion[]= $countryRelatedByIdModification;
            $countryRelatedByIdModification->setAuthyRelatedByIdModification(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Country[] List of Country objects
     */
    public function getCountriesRelatedByIdModificationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CountryQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getCountriesRelatedByIdModification($query, $con);
    }

    /**
     * Clears out the collAssetsRelatedByIdCreation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addAssetsRelatedByIdCreation()
     */
    public function clearAssetsRelatedByIdCreation()
    {
        $this->collAssetsRelatedByIdCreation = null; // important to set this to null since that means it is uninitialized
        $this->collAssetsRelatedByIdCreationPartial = null;

        return $this;
    }

    /**
     * reset is the collAssetsRelatedByIdCreation collection loaded partially
     *
     * @return void
     */
    public function resetPartialAssetsRelatedByIdCreation($v = true)
    {
        $this->collAssetsRelatedByIdCreationPartial = $v;
    }

    /**
     * Initializes the collAssetsRelatedByIdCreation collection.
     *
     * By default this just sets the collAssetsRelatedByIdCreation collection to an empty array (like clearcollAssetsRelatedByIdCreation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAssetsRelatedByIdCreation($overrideExisting = true)
    {
        if (null !== $this->collAssetsRelatedByIdCreation && !$overrideExisting) {
            return;
        }
        $this->collAssetsRelatedByIdCreation = new PropelObjectCollection();
        $this->collAssetsRelatedByIdCreation->setModel('Asset');
    }

    /**
     * Gets an array of Asset objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Asset[] List of Asset objects
     * @throws PropelException
     */
    public function getAssetsRelatedByIdCreation($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAssetsRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collAssetsRelatedByIdCreation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAssetsRelatedByIdCreation) {
                // return empty collection
                $this->initAssetsRelatedByIdCreation();
            } else {
                $collAssetsRelatedByIdCreation = AssetQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdCreation($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAssetsRelatedByIdCreationPartial && count($collAssetsRelatedByIdCreation)) {
                      $this->initAssetsRelatedByIdCreation(false);

                      foreach ($collAssetsRelatedByIdCreation as $obj) {
                        if (false == $this->collAssetsRelatedByIdCreation->contains($obj)) {
                          $this->collAssetsRelatedByIdCreation->append($obj);
                        }
                      }

                      $this->collAssetsRelatedByIdCreationPartial = true;
                    }

                    $collAssetsRelatedByIdCreation->getInternalIterator()->rewind();

                    return $collAssetsRelatedByIdCreation;
                }

                if ($partial && $this->collAssetsRelatedByIdCreation) {
                    foreach ($this->collAssetsRelatedByIdCreation as $obj) {
                        if ($obj->isNew()) {
                            $collAssetsRelatedByIdCreation[] = $obj;
                        }
                    }
                }

                $this->collAssetsRelatedByIdCreation = $collAssetsRelatedByIdCreation;
                $this->collAssetsRelatedByIdCreationPartial = false;
            }
        }

        return $this->collAssetsRelatedByIdCreation;
    }

    /**
     * Sets a collection of AssetRelatedByIdCreation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $assetsRelatedByIdCreation A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setAssetsRelatedByIdCreation(PropelCollection $assetsRelatedByIdCreation, PropelPDO $con = null)
    {
        $assetsRelatedByIdCreationToDelete = $this->getAssetsRelatedByIdCreation(new Criteria(), $con)->diff($assetsRelatedByIdCreation);


        $this->assetsRelatedByIdCreationScheduledForDeletion = $assetsRelatedByIdCreationToDelete;

        foreach ($assetsRelatedByIdCreationToDelete as $assetRelatedByIdCreationRemoved) {
            $assetRelatedByIdCreationRemoved->setAuthyRelatedByIdCreation(null);
        }

        $this->collAssetsRelatedByIdCreation = null;
        foreach ($assetsRelatedByIdCreation as $assetRelatedByIdCreation) {
            $this->addAssetRelatedByIdCreation($assetRelatedByIdCreation);
        }

        $this->collAssetsRelatedByIdCreation = $assetsRelatedByIdCreation;
        $this->collAssetsRelatedByIdCreationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Asset objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Asset objects.
     * @throws PropelException
     */
    public function countAssetsRelatedByIdCreation(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAssetsRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collAssetsRelatedByIdCreation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAssetsRelatedByIdCreation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAssetsRelatedByIdCreation());
            }
            $query = AssetQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdCreation($this)
                ->count($con);
        }

        return count($this->collAssetsRelatedByIdCreation);
    }

    /**
     * Method called to associate a Asset object to this object
     * through the Asset foreign key attribute.
     *
     * @param    Asset $l Asset
     * @return Authy The current object (for fluent API support)
     */
    public function addAssetRelatedByIdCreation(Asset $l)
    {
        if ($this->collAssetsRelatedByIdCreation === null) {
            $this->initAssetsRelatedByIdCreation();
            $this->collAssetsRelatedByIdCreationPartial = true;
        }

        if (!in_array($l, $this->collAssetsRelatedByIdCreation->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAssetRelatedByIdCreation($l);

            if ($this->assetsRelatedByIdCreationScheduledForDeletion and $this->assetsRelatedByIdCreationScheduledForDeletion->contains($l)) {
                $this->assetsRelatedByIdCreationScheduledForDeletion->remove($this->assetsRelatedByIdCreationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AssetRelatedByIdCreation $assetRelatedByIdCreation The assetRelatedByIdCreation object to add.
     */
    protected function doAddAssetRelatedByIdCreation($assetRelatedByIdCreation)
    {
        $this->collAssetsRelatedByIdCreation[]= $assetRelatedByIdCreation;
        $assetRelatedByIdCreation->setAuthyRelatedByIdCreation($this);
    }

    /**
     * @param	AssetRelatedByIdCreation $assetRelatedByIdCreation The assetRelatedByIdCreation object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeAssetRelatedByIdCreation($assetRelatedByIdCreation)
    {
        if ($this->getAssetsRelatedByIdCreation()->contains($assetRelatedByIdCreation)) {
            $this->collAssetsRelatedByIdCreation->remove($this->collAssetsRelatedByIdCreation->search($assetRelatedByIdCreation));
            if (null === $this->assetsRelatedByIdCreationScheduledForDeletion) {
                $this->assetsRelatedByIdCreationScheduledForDeletion = clone $this->collAssetsRelatedByIdCreation;
                $this->assetsRelatedByIdCreationScheduledForDeletion->clear();
            }
            $this->assetsRelatedByIdCreationScheduledForDeletion[]= $assetRelatedByIdCreation;
            $assetRelatedByIdCreation->setAuthyRelatedByIdCreation(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Asset[] List of Asset objects
     */
    public function getAssetsRelatedByIdCreationJoinToken($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetQuery::create(null, $criteria);
        $query->joinWith('Token', $join_behavior);

        return $this->getAssetsRelatedByIdCreation($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Asset[] List of Asset objects
     */
    public function getAssetsRelatedByIdCreationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getAssetsRelatedByIdCreation($query, $con);
    }

    /**
     * Clears out the collAssetsRelatedByIdModification collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addAssetsRelatedByIdModification()
     */
    public function clearAssetsRelatedByIdModification()
    {
        $this->collAssetsRelatedByIdModification = null; // important to set this to null since that means it is uninitialized
        $this->collAssetsRelatedByIdModificationPartial = null;

        return $this;
    }

    /**
     * reset is the collAssetsRelatedByIdModification collection loaded partially
     *
     * @return void
     */
    public function resetPartialAssetsRelatedByIdModification($v = true)
    {
        $this->collAssetsRelatedByIdModificationPartial = $v;
    }

    /**
     * Initializes the collAssetsRelatedByIdModification collection.
     *
     * By default this just sets the collAssetsRelatedByIdModification collection to an empty array (like clearcollAssetsRelatedByIdModification());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAssetsRelatedByIdModification($overrideExisting = true)
    {
        if (null !== $this->collAssetsRelatedByIdModification && !$overrideExisting) {
            return;
        }
        $this->collAssetsRelatedByIdModification = new PropelObjectCollection();
        $this->collAssetsRelatedByIdModification->setModel('Asset');
    }

    /**
     * Gets an array of Asset objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Asset[] List of Asset objects
     * @throws PropelException
     */
    public function getAssetsRelatedByIdModification($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAssetsRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collAssetsRelatedByIdModification || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAssetsRelatedByIdModification) {
                // return empty collection
                $this->initAssetsRelatedByIdModification();
            } else {
                $collAssetsRelatedByIdModification = AssetQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdModification($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAssetsRelatedByIdModificationPartial && count($collAssetsRelatedByIdModification)) {
                      $this->initAssetsRelatedByIdModification(false);

                      foreach ($collAssetsRelatedByIdModification as $obj) {
                        if (false == $this->collAssetsRelatedByIdModification->contains($obj)) {
                          $this->collAssetsRelatedByIdModification->append($obj);
                        }
                      }

                      $this->collAssetsRelatedByIdModificationPartial = true;
                    }

                    $collAssetsRelatedByIdModification->getInternalIterator()->rewind();

                    return $collAssetsRelatedByIdModification;
                }

                if ($partial && $this->collAssetsRelatedByIdModification) {
                    foreach ($this->collAssetsRelatedByIdModification as $obj) {
                        if ($obj->isNew()) {
                            $collAssetsRelatedByIdModification[] = $obj;
                        }
                    }
                }

                $this->collAssetsRelatedByIdModification = $collAssetsRelatedByIdModification;
                $this->collAssetsRelatedByIdModificationPartial = false;
            }
        }

        return $this->collAssetsRelatedByIdModification;
    }

    /**
     * Sets a collection of AssetRelatedByIdModification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $assetsRelatedByIdModification A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setAssetsRelatedByIdModification(PropelCollection $assetsRelatedByIdModification, PropelPDO $con = null)
    {
        $assetsRelatedByIdModificationToDelete = $this->getAssetsRelatedByIdModification(new Criteria(), $con)->diff($assetsRelatedByIdModification);


        $this->assetsRelatedByIdModificationScheduledForDeletion = $assetsRelatedByIdModificationToDelete;

        foreach ($assetsRelatedByIdModificationToDelete as $assetRelatedByIdModificationRemoved) {
            $assetRelatedByIdModificationRemoved->setAuthyRelatedByIdModification(null);
        }

        $this->collAssetsRelatedByIdModification = null;
        foreach ($assetsRelatedByIdModification as $assetRelatedByIdModification) {
            $this->addAssetRelatedByIdModification($assetRelatedByIdModification);
        }

        $this->collAssetsRelatedByIdModification = $assetsRelatedByIdModification;
        $this->collAssetsRelatedByIdModificationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Asset objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Asset objects.
     * @throws PropelException
     */
    public function countAssetsRelatedByIdModification(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAssetsRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collAssetsRelatedByIdModification || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAssetsRelatedByIdModification) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAssetsRelatedByIdModification());
            }
            $query = AssetQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdModification($this)
                ->count($con);
        }

        return count($this->collAssetsRelatedByIdModification);
    }

    /**
     * Method called to associate a Asset object to this object
     * through the Asset foreign key attribute.
     *
     * @param    Asset $l Asset
     * @return Authy The current object (for fluent API support)
     */
    public function addAssetRelatedByIdModification(Asset $l)
    {
        if ($this->collAssetsRelatedByIdModification === null) {
            $this->initAssetsRelatedByIdModification();
            $this->collAssetsRelatedByIdModificationPartial = true;
        }

        if (!in_array($l, $this->collAssetsRelatedByIdModification->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAssetRelatedByIdModification($l);

            if ($this->assetsRelatedByIdModificationScheduledForDeletion and $this->assetsRelatedByIdModificationScheduledForDeletion->contains($l)) {
                $this->assetsRelatedByIdModificationScheduledForDeletion->remove($this->assetsRelatedByIdModificationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AssetRelatedByIdModification $assetRelatedByIdModification The assetRelatedByIdModification object to add.
     */
    protected function doAddAssetRelatedByIdModification($assetRelatedByIdModification)
    {
        $this->collAssetsRelatedByIdModification[]= $assetRelatedByIdModification;
        $assetRelatedByIdModification->setAuthyRelatedByIdModification($this);
    }

    /**
     * @param	AssetRelatedByIdModification $assetRelatedByIdModification The assetRelatedByIdModification object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeAssetRelatedByIdModification($assetRelatedByIdModification)
    {
        if ($this->getAssetsRelatedByIdModification()->contains($assetRelatedByIdModification)) {
            $this->collAssetsRelatedByIdModification->remove($this->collAssetsRelatedByIdModification->search($assetRelatedByIdModification));
            if (null === $this->assetsRelatedByIdModificationScheduledForDeletion) {
                $this->assetsRelatedByIdModificationScheduledForDeletion = clone $this->collAssetsRelatedByIdModification;
                $this->assetsRelatedByIdModificationScheduledForDeletion->clear();
            }
            $this->assetsRelatedByIdModificationScheduledForDeletion[]= $assetRelatedByIdModification;
            $assetRelatedByIdModification->setAuthyRelatedByIdModification(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Asset[] List of Asset objects
     */
    public function getAssetsRelatedByIdModificationJoinToken($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetQuery::create(null, $criteria);
        $query->joinWith('Token', $join_behavior);

        return $this->getAssetsRelatedByIdModification($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Asset[] List of Asset objects
     */
    public function getAssetsRelatedByIdModificationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getAssetsRelatedByIdModification($query, $con);
    }

    /**
     * Clears out the collAssetExchangesRelatedByIdCreation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addAssetExchangesRelatedByIdCreation()
     */
    public function clearAssetExchangesRelatedByIdCreation()
    {
        $this->collAssetExchangesRelatedByIdCreation = null; // important to set this to null since that means it is uninitialized
        $this->collAssetExchangesRelatedByIdCreationPartial = null;

        return $this;
    }

    /**
     * reset is the collAssetExchangesRelatedByIdCreation collection loaded partially
     *
     * @return void
     */
    public function resetPartialAssetExchangesRelatedByIdCreation($v = true)
    {
        $this->collAssetExchangesRelatedByIdCreationPartial = $v;
    }

    /**
     * Initializes the collAssetExchangesRelatedByIdCreation collection.
     *
     * By default this just sets the collAssetExchangesRelatedByIdCreation collection to an empty array (like clearcollAssetExchangesRelatedByIdCreation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAssetExchangesRelatedByIdCreation($overrideExisting = true)
    {
        if (null !== $this->collAssetExchangesRelatedByIdCreation && !$overrideExisting) {
            return;
        }
        $this->collAssetExchangesRelatedByIdCreation = new PropelObjectCollection();
        $this->collAssetExchangesRelatedByIdCreation->setModel('AssetExchange');
    }

    /**
     * Gets an array of AssetExchange objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AssetExchange[] List of AssetExchange objects
     * @throws PropelException
     */
    public function getAssetExchangesRelatedByIdCreation($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAssetExchangesRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collAssetExchangesRelatedByIdCreation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAssetExchangesRelatedByIdCreation) {
                // return empty collection
                $this->initAssetExchangesRelatedByIdCreation();
            } else {
                $collAssetExchangesRelatedByIdCreation = AssetExchangeQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdCreation($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAssetExchangesRelatedByIdCreationPartial && count($collAssetExchangesRelatedByIdCreation)) {
                      $this->initAssetExchangesRelatedByIdCreation(false);

                      foreach ($collAssetExchangesRelatedByIdCreation as $obj) {
                        if (false == $this->collAssetExchangesRelatedByIdCreation->contains($obj)) {
                          $this->collAssetExchangesRelatedByIdCreation->append($obj);
                        }
                      }

                      $this->collAssetExchangesRelatedByIdCreationPartial = true;
                    }

                    $collAssetExchangesRelatedByIdCreation->getInternalIterator()->rewind();

                    return $collAssetExchangesRelatedByIdCreation;
                }

                if ($partial && $this->collAssetExchangesRelatedByIdCreation) {
                    foreach ($this->collAssetExchangesRelatedByIdCreation as $obj) {
                        if ($obj->isNew()) {
                            $collAssetExchangesRelatedByIdCreation[] = $obj;
                        }
                    }
                }

                $this->collAssetExchangesRelatedByIdCreation = $collAssetExchangesRelatedByIdCreation;
                $this->collAssetExchangesRelatedByIdCreationPartial = false;
            }
        }

        return $this->collAssetExchangesRelatedByIdCreation;
    }

    /**
     * Sets a collection of AssetExchangeRelatedByIdCreation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $assetExchangesRelatedByIdCreation A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setAssetExchangesRelatedByIdCreation(PropelCollection $assetExchangesRelatedByIdCreation, PropelPDO $con = null)
    {
        $assetExchangesRelatedByIdCreationToDelete = $this->getAssetExchangesRelatedByIdCreation(new Criteria(), $con)->diff($assetExchangesRelatedByIdCreation);


        $this->assetExchangesRelatedByIdCreationScheduledForDeletion = $assetExchangesRelatedByIdCreationToDelete;

        foreach ($assetExchangesRelatedByIdCreationToDelete as $assetExchangeRelatedByIdCreationRemoved) {
            $assetExchangeRelatedByIdCreationRemoved->setAuthyRelatedByIdCreation(null);
        }

        $this->collAssetExchangesRelatedByIdCreation = null;
        foreach ($assetExchangesRelatedByIdCreation as $assetExchangeRelatedByIdCreation) {
            $this->addAssetExchangeRelatedByIdCreation($assetExchangeRelatedByIdCreation);
        }

        $this->collAssetExchangesRelatedByIdCreation = $assetExchangesRelatedByIdCreation;
        $this->collAssetExchangesRelatedByIdCreationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AssetExchange objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AssetExchange objects.
     * @throws PropelException
     */
    public function countAssetExchangesRelatedByIdCreation(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAssetExchangesRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collAssetExchangesRelatedByIdCreation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAssetExchangesRelatedByIdCreation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAssetExchangesRelatedByIdCreation());
            }
            $query = AssetExchangeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdCreation($this)
                ->count($con);
        }

        return count($this->collAssetExchangesRelatedByIdCreation);
    }

    /**
     * Method called to associate a AssetExchange object to this object
     * through the AssetExchange foreign key attribute.
     *
     * @param    AssetExchange $l AssetExchange
     * @return Authy The current object (for fluent API support)
     */
    public function addAssetExchangeRelatedByIdCreation(AssetExchange $l)
    {
        if ($this->collAssetExchangesRelatedByIdCreation === null) {
            $this->initAssetExchangesRelatedByIdCreation();
            $this->collAssetExchangesRelatedByIdCreationPartial = true;
        }

        if (!in_array($l, $this->collAssetExchangesRelatedByIdCreation->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAssetExchangeRelatedByIdCreation($l);

            if ($this->assetExchangesRelatedByIdCreationScheduledForDeletion and $this->assetExchangesRelatedByIdCreationScheduledForDeletion->contains($l)) {
                $this->assetExchangesRelatedByIdCreationScheduledForDeletion->remove($this->assetExchangesRelatedByIdCreationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AssetExchangeRelatedByIdCreation $assetExchangeRelatedByIdCreation The assetExchangeRelatedByIdCreation object to add.
     */
    protected function doAddAssetExchangeRelatedByIdCreation($assetExchangeRelatedByIdCreation)
    {
        $this->collAssetExchangesRelatedByIdCreation[]= $assetExchangeRelatedByIdCreation;
        $assetExchangeRelatedByIdCreation->setAuthyRelatedByIdCreation($this);
    }

    /**
     * @param	AssetExchangeRelatedByIdCreation $assetExchangeRelatedByIdCreation The assetExchangeRelatedByIdCreation object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeAssetExchangeRelatedByIdCreation($assetExchangeRelatedByIdCreation)
    {
        if ($this->getAssetExchangesRelatedByIdCreation()->contains($assetExchangeRelatedByIdCreation)) {
            $this->collAssetExchangesRelatedByIdCreation->remove($this->collAssetExchangesRelatedByIdCreation->search($assetExchangeRelatedByIdCreation));
            if (null === $this->assetExchangesRelatedByIdCreationScheduledForDeletion) {
                $this->assetExchangesRelatedByIdCreationScheduledForDeletion = clone $this->collAssetExchangesRelatedByIdCreation;
                $this->assetExchangesRelatedByIdCreationScheduledForDeletion->clear();
            }
            $this->assetExchangesRelatedByIdCreationScheduledForDeletion[]= $assetExchangeRelatedByIdCreation;
            $assetExchangeRelatedByIdCreation->setAuthyRelatedByIdCreation(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AssetExchange[] List of AssetExchange objects
     */
    public function getAssetExchangesRelatedByIdCreationJoinAsset($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetExchangeQuery::create(null, $criteria);
        $query->joinWith('Asset', $join_behavior);

        return $this->getAssetExchangesRelatedByIdCreation($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AssetExchange[] List of AssetExchange objects
     */
    public function getAssetExchangesRelatedByIdCreationJoinExchange($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetExchangeQuery::create(null, $criteria);
        $query->joinWith('Exchange', $join_behavior);

        return $this->getAssetExchangesRelatedByIdCreation($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AssetExchange[] List of AssetExchange objects
     */
    public function getAssetExchangesRelatedByIdCreationJoinToken($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetExchangeQuery::create(null, $criteria);
        $query->joinWith('Token', $join_behavior);

        return $this->getAssetExchangesRelatedByIdCreation($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AssetExchange[] List of AssetExchange objects
     */
    public function getAssetExchangesRelatedByIdCreationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetExchangeQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getAssetExchangesRelatedByIdCreation($query, $con);
    }

    /**
     * Clears out the collAssetExchangesRelatedByIdModification collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addAssetExchangesRelatedByIdModification()
     */
    public function clearAssetExchangesRelatedByIdModification()
    {
        $this->collAssetExchangesRelatedByIdModification = null; // important to set this to null since that means it is uninitialized
        $this->collAssetExchangesRelatedByIdModificationPartial = null;

        return $this;
    }

    /**
     * reset is the collAssetExchangesRelatedByIdModification collection loaded partially
     *
     * @return void
     */
    public function resetPartialAssetExchangesRelatedByIdModification($v = true)
    {
        $this->collAssetExchangesRelatedByIdModificationPartial = $v;
    }

    /**
     * Initializes the collAssetExchangesRelatedByIdModification collection.
     *
     * By default this just sets the collAssetExchangesRelatedByIdModification collection to an empty array (like clearcollAssetExchangesRelatedByIdModification());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAssetExchangesRelatedByIdModification($overrideExisting = true)
    {
        if (null !== $this->collAssetExchangesRelatedByIdModification && !$overrideExisting) {
            return;
        }
        $this->collAssetExchangesRelatedByIdModification = new PropelObjectCollection();
        $this->collAssetExchangesRelatedByIdModification->setModel('AssetExchange');
    }

    /**
     * Gets an array of AssetExchange objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AssetExchange[] List of AssetExchange objects
     * @throws PropelException
     */
    public function getAssetExchangesRelatedByIdModification($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAssetExchangesRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collAssetExchangesRelatedByIdModification || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAssetExchangesRelatedByIdModification) {
                // return empty collection
                $this->initAssetExchangesRelatedByIdModification();
            } else {
                $collAssetExchangesRelatedByIdModification = AssetExchangeQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdModification($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAssetExchangesRelatedByIdModificationPartial && count($collAssetExchangesRelatedByIdModification)) {
                      $this->initAssetExchangesRelatedByIdModification(false);

                      foreach ($collAssetExchangesRelatedByIdModification as $obj) {
                        if (false == $this->collAssetExchangesRelatedByIdModification->contains($obj)) {
                          $this->collAssetExchangesRelatedByIdModification->append($obj);
                        }
                      }

                      $this->collAssetExchangesRelatedByIdModificationPartial = true;
                    }

                    $collAssetExchangesRelatedByIdModification->getInternalIterator()->rewind();

                    return $collAssetExchangesRelatedByIdModification;
                }

                if ($partial && $this->collAssetExchangesRelatedByIdModification) {
                    foreach ($this->collAssetExchangesRelatedByIdModification as $obj) {
                        if ($obj->isNew()) {
                            $collAssetExchangesRelatedByIdModification[] = $obj;
                        }
                    }
                }

                $this->collAssetExchangesRelatedByIdModification = $collAssetExchangesRelatedByIdModification;
                $this->collAssetExchangesRelatedByIdModificationPartial = false;
            }
        }

        return $this->collAssetExchangesRelatedByIdModification;
    }

    /**
     * Sets a collection of AssetExchangeRelatedByIdModification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $assetExchangesRelatedByIdModification A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setAssetExchangesRelatedByIdModification(PropelCollection $assetExchangesRelatedByIdModification, PropelPDO $con = null)
    {
        $assetExchangesRelatedByIdModificationToDelete = $this->getAssetExchangesRelatedByIdModification(new Criteria(), $con)->diff($assetExchangesRelatedByIdModification);


        $this->assetExchangesRelatedByIdModificationScheduledForDeletion = $assetExchangesRelatedByIdModificationToDelete;

        foreach ($assetExchangesRelatedByIdModificationToDelete as $assetExchangeRelatedByIdModificationRemoved) {
            $assetExchangeRelatedByIdModificationRemoved->setAuthyRelatedByIdModification(null);
        }

        $this->collAssetExchangesRelatedByIdModification = null;
        foreach ($assetExchangesRelatedByIdModification as $assetExchangeRelatedByIdModification) {
            $this->addAssetExchangeRelatedByIdModification($assetExchangeRelatedByIdModification);
        }

        $this->collAssetExchangesRelatedByIdModification = $assetExchangesRelatedByIdModification;
        $this->collAssetExchangesRelatedByIdModificationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AssetExchange objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AssetExchange objects.
     * @throws PropelException
     */
    public function countAssetExchangesRelatedByIdModification(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAssetExchangesRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collAssetExchangesRelatedByIdModification || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAssetExchangesRelatedByIdModification) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAssetExchangesRelatedByIdModification());
            }
            $query = AssetExchangeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdModification($this)
                ->count($con);
        }

        return count($this->collAssetExchangesRelatedByIdModification);
    }

    /**
     * Method called to associate a AssetExchange object to this object
     * through the AssetExchange foreign key attribute.
     *
     * @param    AssetExchange $l AssetExchange
     * @return Authy The current object (for fluent API support)
     */
    public function addAssetExchangeRelatedByIdModification(AssetExchange $l)
    {
        if ($this->collAssetExchangesRelatedByIdModification === null) {
            $this->initAssetExchangesRelatedByIdModification();
            $this->collAssetExchangesRelatedByIdModificationPartial = true;
        }

        if (!in_array($l, $this->collAssetExchangesRelatedByIdModification->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAssetExchangeRelatedByIdModification($l);

            if ($this->assetExchangesRelatedByIdModificationScheduledForDeletion and $this->assetExchangesRelatedByIdModificationScheduledForDeletion->contains($l)) {
                $this->assetExchangesRelatedByIdModificationScheduledForDeletion->remove($this->assetExchangesRelatedByIdModificationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AssetExchangeRelatedByIdModification $assetExchangeRelatedByIdModification The assetExchangeRelatedByIdModification object to add.
     */
    protected function doAddAssetExchangeRelatedByIdModification($assetExchangeRelatedByIdModification)
    {
        $this->collAssetExchangesRelatedByIdModification[]= $assetExchangeRelatedByIdModification;
        $assetExchangeRelatedByIdModification->setAuthyRelatedByIdModification($this);
    }

    /**
     * @param	AssetExchangeRelatedByIdModification $assetExchangeRelatedByIdModification The assetExchangeRelatedByIdModification object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeAssetExchangeRelatedByIdModification($assetExchangeRelatedByIdModification)
    {
        if ($this->getAssetExchangesRelatedByIdModification()->contains($assetExchangeRelatedByIdModification)) {
            $this->collAssetExchangesRelatedByIdModification->remove($this->collAssetExchangesRelatedByIdModification->search($assetExchangeRelatedByIdModification));
            if (null === $this->assetExchangesRelatedByIdModificationScheduledForDeletion) {
                $this->assetExchangesRelatedByIdModificationScheduledForDeletion = clone $this->collAssetExchangesRelatedByIdModification;
                $this->assetExchangesRelatedByIdModificationScheduledForDeletion->clear();
            }
            $this->assetExchangesRelatedByIdModificationScheduledForDeletion[]= $assetExchangeRelatedByIdModification;
            $assetExchangeRelatedByIdModification->setAuthyRelatedByIdModification(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AssetExchange[] List of AssetExchange objects
     */
    public function getAssetExchangesRelatedByIdModificationJoinAsset($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetExchangeQuery::create(null, $criteria);
        $query->joinWith('Asset', $join_behavior);

        return $this->getAssetExchangesRelatedByIdModification($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AssetExchange[] List of AssetExchange objects
     */
    public function getAssetExchangesRelatedByIdModificationJoinExchange($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetExchangeQuery::create(null, $criteria);
        $query->joinWith('Exchange', $join_behavior);

        return $this->getAssetExchangesRelatedByIdModification($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AssetExchange[] List of AssetExchange objects
     */
    public function getAssetExchangesRelatedByIdModificationJoinToken($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetExchangeQuery::create(null, $criteria);
        $query->joinWith('Token', $join_behavior);

        return $this->getAssetExchangesRelatedByIdModification($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AssetExchange[] List of AssetExchange objects
     */
    public function getAssetExchangesRelatedByIdModificationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetExchangeQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getAssetExchangesRelatedByIdModification($query, $con);
    }

    /**
     * Clears out the collTradesRelatedByIdCreation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addTradesRelatedByIdCreation()
     */
    public function clearTradesRelatedByIdCreation()
    {
        $this->collTradesRelatedByIdCreation = null; // important to set this to null since that means it is uninitialized
        $this->collTradesRelatedByIdCreationPartial = null;

        return $this;
    }

    /**
     * reset is the collTradesRelatedByIdCreation collection loaded partially
     *
     * @return void
     */
    public function resetPartialTradesRelatedByIdCreation($v = true)
    {
        $this->collTradesRelatedByIdCreationPartial = $v;
    }

    /**
     * Initializes the collTradesRelatedByIdCreation collection.
     *
     * By default this just sets the collTradesRelatedByIdCreation collection to an empty array (like clearcollTradesRelatedByIdCreation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTradesRelatedByIdCreation($overrideExisting = true)
    {
        if (null !== $this->collTradesRelatedByIdCreation && !$overrideExisting) {
            return;
        }
        $this->collTradesRelatedByIdCreation = new PropelObjectCollection();
        $this->collTradesRelatedByIdCreation->setModel('Trade');
    }

    /**
     * Gets an array of Trade objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Trade[] List of Trade objects
     * @throws PropelException
     */
    public function getTradesRelatedByIdCreation($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collTradesRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collTradesRelatedByIdCreation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTradesRelatedByIdCreation) {
                // return empty collection
                $this->initTradesRelatedByIdCreation();
            } else {
                $collTradesRelatedByIdCreation = TradeQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdCreation($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collTradesRelatedByIdCreationPartial && count($collTradesRelatedByIdCreation)) {
                      $this->initTradesRelatedByIdCreation(false);

                      foreach ($collTradesRelatedByIdCreation as $obj) {
                        if (false == $this->collTradesRelatedByIdCreation->contains($obj)) {
                          $this->collTradesRelatedByIdCreation->append($obj);
                        }
                      }

                      $this->collTradesRelatedByIdCreationPartial = true;
                    }

                    $collTradesRelatedByIdCreation->getInternalIterator()->rewind();

                    return $collTradesRelatedByIdCreation;
                }

                if ($partial && $this->collTradesRelatedByIdCreation) {
                    foreach ($this->collTradesRelatedByIdCreation as $obj) {
                        if ($obj->isNew()) {
                            $collTradesRelatedByIdCreation[] = $obj;
                        }
                    }
                }

                $this->collTradesRelatedByIdCreation = $collTradesRelatedByIdCreation;
                $this->collTradesRelatedByIdCreationPartial = false;
            }
        }

        return $this->collTradesRelatedByIdCreation;
    }

    /**
     * Sets a collection of TradeRelatedByIdCreation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $tradesRelatedByIdCreation A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setTradesRelatedByIdCreation(PropelCollection $tradesRelatedByIdCreation, PropelPDO $con = null)
    {
        $tradesRelatedByIdCreationToDelete = $this->getTradesRelatedByIdCreation(new Criteria(), $con)->diff($tradesRelatedByIdCreation);


        $this->tradesRelatedByIdCreationScheduledForDeletion = $tradesRelatedByIdCreationToDelete;

        foreach ($tradesRelatedByIdCreationToDelete as $tradeRelatedByIdCreationRemoved) {
            $tradeRelatedByIdCreationRemoved->setAuthyRelatedByIdCreation(null);
        }

        $this->collTradesRelatedByIdCreation = null;
        foreach ($tradesRelatedByIdCreation as $tradeRelatedByIdCreation) {
            $this->addTradeRelatedByIdCreation($tradeRelatedByIdCreation);
        }

        $this->collTradesRelatedByIdCreation = $tradesRelatedByIdCreation;
        $this->collTradesRelatedByIdCreationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Trade objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Trade objects.
     * @throws PropelException
     */
    public function countTradesRelatedByIdCreation(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collTradesRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collTradesRelatedByIdCreation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTradesRelatedByIdCreation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTradesRelatedByIdCreation());
            }
            $query = TradeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdCreation($this)
                ->count($con);
        }

        return count($this->collTradesRelatedByIdCreation);
    }

    /**
     * Method called to associate a Trade object to this object
     * through the Trade foreign key attribute.
     *
     * @param    Trade $l Trade
     * @return Authy The current object (for fluent API support)
     */
    public function addTradeRelatedByIdCreation(Trade $l)
    {
        if ($this->collTradesRelatedByIdCreation === null) {
            $this->initTradesRelatedByIdCreation();
            $this->collTradesRelatedByIdCreationPartial = true;
        }

        if (!in_array($l, $this->collTradesRelatedByIdCreation->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddTradeRelatedByIdCreation($l);

            if ($this->tradesRelatedByIdCreationScheduledForDeletion and $this->tradesRelatedByIdCreationScheduledForDeletion->contains($l)) {
                $this->tradesRelatedByIdCreationScheduledForDeletion->remove($this->tradesRelatedByIdCreationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	TradeRelatedByIdCreation $tradeRelatedByIdCreation The tradeRelatedByIdCreation object to add.
     */
    protected function doAddTradeRelatedByIdCreation($tradeRelatedByIdCreation)
    {
        $this->collTradesRelatedByIdCreation[]= $tradeRelatedByIdCreation;
        $tradeRelatedByIdCreation->setAuthyRelatedByIdCreation($this);
    }

    /**
     * @param	TradeRelatedByIdCreation $tradeRelatedByIdCreation The tradeRelatedByIdCreation object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeTradeRelatedByIdCreation($tradeRelatedByIdCreation)
    {
        if ($this->getTradesRelatedByIdCreation()->contains($tradeRelatedByIdCreation)) {
            $this->collTradesRelatedByIdCreation->remove($this->collTradesRelatedByIdCreation->search($tradeRelatedByIdCreation));
            if (null === $this->tradesRelatedByIdCreationScheduledForDeletion) {
                $this->tradesRelatedByIdCreationScheduledForDeletion = clone $this->collTradesRelatedByIdCreation;
                $this->tradesRelatedByIdCreationScheduledForDeletion->clear();
            }
            $this->tradesRelatedByIdCreationScheduledForDeletion[]= $tradeRelatedByIdCreation;
            $tradeRelatedByIdCreation->setAuthyRelatedByIdCreation(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Trade[] List of Trade objects
     */
    public function getTradesRelatedByIdCreationJoinExchange($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TradeQuery::create(null, $criteria);
        $query->joinWith('Exchange', $join_behavior);

        return $this->getTradesRelatedByIdCreation($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Trade[] List of Trade objects
     */
    public function getTradesRelatedByIdCreationJoinAsset($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TradeQuery::create(null, $criteria);
        $query->joinWith('Asset', $join_behavior);

        return $this->getTradesRelatedByIdCreation($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Trade[] List of Trade objects
     */
    public function getTradesRelatedByIdCreationJoinSymbol($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TradeQuery::create(null, $criteria);
        $query->joinWith('Symbol', $join_behavior);

        return $this->getTradesRelatedByIdCreation($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Trade[] List of Trade objects
     */
    public function getTradesRelatedByIdCreationJoinToken($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TradeQuery::create(null, $criteria);
        $query->joinWith('Token', $join_behavior);

        return $this->getTradesRelatedByIdCreation($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Trade[] List of Trade objects
     */
    public function getTradesRelatedByIdCreationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TradeQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getTradesRelatedByIdCreation($query, $con);
    }

    /**
     * Clears out the collTradesRelatedByIdModification collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addTradesRelatedByIdModification()
     */
    public function clearTradesRelatedByIdModification()
    {
        $this->collTradesRelatedByIdModification = null; // important to set this to null since that means it is uninitialized
        $this->collTradesRelatedByIdModificationPartial = null;

        return $this;
    }

    /**
     * reset is the collTradesRelatedByIdModification collection loaded partially
     *
     * @return void
     */
    public function resetPartialTradesRelatedByIdModification($v = true)
    {
        $this->collTradesRelatedByIdModificationPartial = $v;
    }

    /**
     * Initializes the collTradesRelatedByIdModification collection.
     *
     * By default this just sets the collTradesRelatedByIdModification collection to an empty array (like clearcollTradesRelatedByIdModification());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTradesRelatedByIdModification($overrideExisting = true)
    {
        if (null !== $this->collTradesRelatedByIdModification && !$overrideExisting) {
            return;
        }
        $this->collTradesRelatedByIdModification = new PropelObjectCollection();
        $this->collTradesRelatedByIdModification->setModel('Trade');
    }

    /**
     * Gets an array of Trade objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Trade[] List of Trade objects
     * @throws PropelException
     */
    public function getTradesRelatedByIdModification($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collTradesRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collTradesRelatedByIdModification || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTradesRelatedByIdModification) {
                // return empty collection
                $this->initTradesRelatedByIdModification();
            } else {
                $collTradesRelatedByIdModification = TradeQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdModification($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collTradesRelatedByIdModificationPartial && count($collTradesRelatedByIdModification)) {
                      $this->initTradesRelatedByIdModification(false);

                      foreach ($collTradesRelatedByIdModification as $obj) {
                        if (false == $this->collTradesRelatedByIdModification->contains($obj)) {
                          $this->collTradesRelatedByIdModification->append($obj);
                        }
                      }

                      $this->collTradesRelatedByIdModificationPartial = true;
                    }

                    $collTradesRelatedByIdModification->getInternalIterator()->rewind();

                    return $collTradesRelatedByIdModification;
                }

                if ($partial && $this->collTradesRelatedByIdModification) {
                    foreach ($this->collTradesRelatedByIdModification as $obj) {
                        if ($obj->isNew()) {
                            $collTradesRelatedByIdModification[] = $obj;
                        }
                    }
                }

                $this->collTradesRelatedByIdModification = $collTradesRelatedByIdModification;
                $this->collTradesRelatedByIdModificationPartial = false;
            }
        }

        return $this->collTradesRelatedByIdModification;
    }

    /**
     * Sets a collection of TradeRelatedByIdModification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $tradesRelatedByIdModification A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setTradesRelatedByIdModification(PropelCollection $tradesRelatedByIdModification, PropelPDO $con = null)
    {
        $tradesRelatedByIdModificationToDelete = $this->getTradesRelatedByIdModification(new Criteria(), $con)->diff($tradesRelatedByIdModification);


        $this->tradesRelatedByIdModificationScheduledForDeletion = $tradesRelatedByIdModificationToDelete;

        foreach ($tradesRelatedByIdModificationToDelete as $tradeRelatedByIdModificationRemoved) {
            $tradeRelatedByIdModificationRemoved->setAuthyRelatedByIdModification(null);
        }

        $this->collTradesRelatedByIdModification = null;
        foreach ($tradesRelatedByIdModification as $tradeRelatedByIdModification) {
            $this->addTradeRelatedByIdModification($tradeRelatedByIdModification);
        }

        $this->collTradesRelatedByIdModification = $tradesRelatedByIdModification;
        $this->collTradesRelatedByIdModificationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Trade objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Trade objects.
     * @throws PropelException
     */
    public function countTradesRelatedByIdModification(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collTradesRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collTradesRelatedByIdModification || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTradesRelatedByIdModification) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTradesRelatedByIdModification());
            }
            $query = TradeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdModification($this)
                ->count($con);
        }

        return count($this->collTradesRelatedByIdModification);
    }

    /**
     * Method called to associate a Trade object to this object
     * through the Trade foreign key attribute.
     *
     * @param    Trade $l Trade
     * @return Authy The current object (for fluent API support)
     */
    public function addTradeRelatedByIdModification(Trade $l)
    {
        if ($this->collTradesRelatedByIdModification === null) {
            $this->initTradesRelatedByIdModification();
            $this->collTradesRelatedByIdModificationPartial = true;
        }

        if (!in_array($l, $this->collTradesRelatedByIdModification->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddTradeRelatedByIdModification($l);

            if ($this->tradesRelatedByIdModificationScheduledForDeletion and $this->tradesRelatedByIdModificationScheduledForDeletion->contains($l)) {
                $this->tradesRelatedByIdModificationScheduledForDeletion->remove($this->tradesRelatedByIdModificationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	TradeRelatedByIdModification $tradeRelatedByIdModification The tradeRelatedByIdModification object to add.
     */
    protected function doAddTradeRelatedByIdModification($tradeRelatedByIdModification)
    {
        $this->collTradesRelatedByIdModification[]= $tradeRelatedByIdModification;
        $tradeRelatedByIdModification->setAuthyRelatedByIdModification($this);
    }

    /**
     * @param	TradeRelatedByIdModification $tradeRelatedByIdModification The tradeRelatedByIdModification object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeTradeRelatedByIdModification($tradeRelatedByIdModification)
    {
        if ($this->getTradesRelatedByIdModification()->contains($tradeRelatedByIdModification)) {
            $this->collTradesRelatedByIdModification->remove($this->collTradesRelatedByIdModification->search($tradeRelatedByIdModification));
            if (null === $this->tradesRelatedByIdModificationScheduledForDeletion) {
                $this->tradesRelatedByIdModificationScheduledForDeletion = clone $this->collTradesRelatedByIdModification;
                $this->tradesRelatedByIdModificationScheduledForDeletion->clear();
            }
            $this->tradesRelatedByIdModificationScheduledForDeletion[]= $tradeRelatedByIdModification;
            $tradeRelatedByIdModification->setAuthyRelatedByIdModification(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Trade[] List of Trade objects
     */
    public function getTradesRelatedByIdModificationJoinExchange($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TradeQuery::create(null, $criteria);
        $query->joinWith('Exchange', $join_behavior);

        return $this->getTradesRelatedByIdModification($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Trade[] List of Trade objects
     */
    public function getTradesRelatedByIdModificationJoinAsset($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TradeQuery::create(null, $criteria);
        $query->joinWith('Asset', $join_behavior);

        return $this->getTradesRelatedByIdModification($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Trade[] List of Trade objects
     */
    public function getTradesRelatedByIdModificationJoinSymbol($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TradeQuery::create(null, $criteria);
        $query->joinWith('Symbol', $join_behavior);

        return $this->getTradesRelatedByIdModification($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Trade[] List of Trade objects
     */
    public function getTradesRelatedByIdModificationJoinToken($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TradeQuery::create(null, $criteria);
        $query->joinWith('Token', $join_behavior);

        return $this->getTradesRelatedByIdModification($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Trade[] List of Trade objects
     */
    public function getTradesRelatedByIdModificationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TradeQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getTradesRelatedByIdModification($query, $con);
    }

    /**
     * Clears out the collExchangesRelatedByIdCreation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addExchangesRelatedByIdCreation()
     */
    public function clearExchangesRelatedByIdCreation()
    {
        $this->collExchangesRelatedByIdCreation = null; // important to set this to null since that means it is uninitialized
        $this->collExchangesRelatedByIdCreationPartial = null;

        return $this;
    }

    /**
     * reset is the collExchangesRelatedByIdCreation collection loaded partially
     *
     * @return void
     */
    public function resetPartialExchangesRelatedByIdCreation($v = true)
    {
        $this->collExchangesRelatedByIdCreationPartial = $v;
    }

    /**
     * Initializes the collExchangesRelatedByIdCreation collection.
     *
     * By default this just sets the collExchangesRelatedByIdCreation collection to an empty array (like clearcollExchangesRelatedByIdCreation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initExchangesRelatedByIdCreation($overrideExisting = true)
    {
        if (null !== $this->collExchangesRelatedByIdCreation && !$overrideExisting) {
            return;
        }
        $this->collExchangesRelatedByIdCreation = new PropelObjectCollection();
        $this->collExchangesRelatedByIdCreation->setModel('Exchange');
    }

    /**
     * Gets an array of Exchange objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Exchange[] List of Exchange objects
     * @throws PropelException
     */
    public function getExchangesRelatedByIdCreation($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collExchangesRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collExchangesRelatedByIdCreation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collExchangesRelatedByIdCreation) {
                // return empty collection
                $this->initExchangesRelatedByIdCreation();
            } else {
                $collExchangesRelatedByIdCreation = ExchangeQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdCreation($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collExchangesRelatedByIdCreationPartial && count($collExchangesRelatedByIdCreation)) {
                      $this->initExchangesRelatedByIdCreation(false);

                      foreach ($collExchangesRelatedByIdCreation as $obj) {
                        if (false == $this->collExchangesRelatedByIdCreation->contains($obj)) {
                          $this->collExchangesRelatedByIdCreation->append($obj);
                        }
                      }

                      $this->collExchangesRelatedByIdCreationPartial = true;
                    }

                    $collExchangesRelatedByIdCreation->getInternalIterator()->rewind();

                    return $collExchangesRelatedByIdCreation;
                }

                if ($partial && $this->collExchangesRelatedByIdCreation) {
                    foreach ($this->collExchangesRelatedByIdCreation as $obj) {
                        if ($obj->isNew()) {
                            $collExchangesRelatedByIdCreation[] = $obj;
                        }
                    }
                }

                $this->collExchangesRelatedByIdCreation = $collExchangesRelatedByIdCreation;
                $this->collExchangesRelatedByIdCreationPartial = false;
            }
        }

        return $this->collExchangesRelatedByIdCreation;
    }

    /**
     * Sets a collection of ExchangeRelatedByIdCreation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $exchangesRelatedByIdCreation A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setExchangesRelatedByIdCreation(PropelCollection $exchangesRelatedByIdCreation, PropelPDO $con = null)
    {
        $exchangesRelatedByIdCreationToDelete = $this->getExchangesRelatedByIdCreation(new Criteria(), $con)->diff($exchangesRelatedByIdCreation);


        $this->exchangesRelatedByIdCreationScheduledForDeletion = $exchangesRelatedByIdCreationToDelete;

        foreach ($exchangesRelatedByIdCreationToDelete as $exchangeRelatedByIdCreationRemoved) {
            $exchangeRelatedByIdCreationRemoved->setAuthyRelatedByIdCreation(null);
        }

        $this->collExchangesRelatedByIdCreation = null;
        foreach ($exchangesRelatedByIdCreation as $exchangeRelatedByIdCreation) {
            $this->addExchangeRelatedByIdCreation($exchangeRelatedByIdCreation);
        }

        $this->collExchangesRelatedByIdCreation = $exchangesRelatedByIdCreation;
        $this->collExchangesRelatedByIdCreationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Exchange objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Exchange objects.
     * @throws PropelException
     */
    public function countExchangesRelatedByIdCreation(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collExchangesRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collExchangesRelatedByIdCreation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collExchangesRelatedByIdCreation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getExchangesRelatedByIdCreation());
            }
            $query = ExchangeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdCreation($this)
                ->count($con);
        }

        return count($this->collExchangesRelatedByIdCreation);
    }

    /**
     * Method called to associate a Exchange object to this object
     * through the Exchange foreign key attribute.
     *
     * @param    Exchange $l Exchange
     * @return Authy The current object (for fluent API support)
     */
    public function addExchangeRelatedByIdCreation(Exchange $l)
    {
        if ($this->collExchangesRelatedByIdCreation === null) {
            $this->initExchangesRelatedByIdCreation();
            $this->collExchangesRelatedByIdCreationPartial = true;
        }

        if (!in_array($l, $this->collExchangesRelatedByIdCreation->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddExchangeRelatedByIdCreation($l);

            if ($this->exchangesRelatedByIdCreationScheduledForDeletion and $this->exchangesRelatedByIdCreationScheduledForDeletion->contains($l)) {
                $this->exchangesRelatedByIdCreationScheduledForDeletion->remove($this->exchangesRelatedByIdCreationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	ExchangeRelatedByIdCreation $exchangeRelatedByIdCreation The exchangeRelatedByIdCreation object to add.
     */
    protected function doAddExchangeRelatedByIdCreation($exchangeRelatedByIdCreation)
    {
        $this->collExchangesRelatedByIdCreation[]= $exchangeRelatedByIdCreation;
        $exchangeRelatedByIdCreation->setAuthyRelatedByIdCreation($this);
    }

    /**
     * @param	ExchangeRelatedByIdCreation $exchangeRelatedByIdCreation The exchangeRelatedByIdCreation object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeExchangeRelatedByIdCreation($exchangeRelatedByIdCreation)
    {
        if ($this->getExchangesRelatedByIdCreation()->contains($exchangeRelatedByIdCreation)) {
            $this->collExchangesRelatedByIdCreation->remove($this->collExchangesRelatedByIdCreation->search($exchangeRelatedByIdCreation));
            if (null === $this->exchangesRelatedByIdCreationScheduledForDeletion) {
                $this->exchangesRelatedByIdCreationScheduledForDeletion = clone $this->collExchangesRelatedByIdCreation;
                $this->exchangesRelatedByIdCreationScheduledForDeletion->clear();
            }
            $this->exchangesRelatedByIdCreationScheduledForDeletion[]= $exchangeRelatedByIdCreation;
            $exchangeRelatedByIdCreation->setAuthyRelatedByIdCreation(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Exchange[] List of Exchange objects
     */
    public function getExchangesRelatedByIdCreationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ExchangeQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getExchangesRelatedByIdCreation($query, $con);
    }

    /**
     * Clears out the collExchangesRelatedByIdModification collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addExchangesRelatedByIdModification()
     */
    public function clearExchangesRelatedByIdModification()
    {
        $this->collExchangesRelatedByIdModification = null; // important to set this to null since that means it is uninitialized
        $this->collExchangesRelatedByIdModificationPartial = null;

        return $this;
    }

    /**
     * reset is the collExchangesRelatedByIdModification collection loaded partially
     *
     * @return void
     */
    public function resetPartialExchangesRelatedByIdModification($v = true)
    {
        $this->collExchangesRelatedByIdModificationPartial = $v;
    }

    /**
     * Initializes the collExchangesRelatedByIdModification collection.
     *
     * By default this just sets the collExchangesRelatedByIdModification collection to an empty array (like clearcollExchangesRelatedByIdModification());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initExchangesRelatedByIdModification($overrideExisting = true)
    {
        if (null !== $this->collExchangesRelatedByIdModification && !$overrideExisting) {
            return;
        }
        $this->collExchangesRelatedByIdModification = new PropelObjectCollection();
        $this->collExchangesRelatedByIdModification->setModel('Exchange');
    }

    /**
     * Gets an array of Exchange objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Exchange[] List of Exchange objects
     * @throws PropelException
     */
    public function getExchangesRelatedByIdModification($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collExchangesRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collExchangesRelatedByIdModification || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collExchangesRelatedByIdModification) {
                // return empty collection
                $this->initExchangesRelatedByIdModification();
            } else {
                $collExchangesRelatedByIdModification = ExchangeQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdModification($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collExchangesRelatedByIdModificationPartial && count($collExchangesRelatedByIdModification)) {
                      $this->initExchangesRelatedByIdModification(false);

                      foreach ($collExchangesRelatedByIdModification as $obj) {
                        if (false == $this->collExchangesRelatedByIdModification->contains($obj)) {
                          $this->collExchangesRelatedByIdModification->append($obj);
                        }
                      }

                      $this->collExchangesRelatedByIdModificationPartial = true;
                    }

                    $collExchangesRelatedByIdModification->getInternalIterator()->rewind();

                    return $collExchangesRelatedByIdModification;
                }

                if ($partial && $this->collExchangesRelatedByIdModification) {
                    foreach ($this->collExchangesRelatedByIdModification as $obj) {
                        if ($obj->isNew()) {
                            $collExchangesRelatedByIdModification[] = $obj;
                        }
                    }
                }

                $this->collExchangesRelatedByIdModification = $collExchangesRelatedByIdModification;
                $this->collExchangesRelatedByIdModificationPartial = false;
            }
        }

        return $this->collExchangesRelatedByIdModification;
    }

    /**
     * Sets a collection of ExchangeRelatedByIdModification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $exchangesRelatedByIdModification A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setExchangesRelatedByIdModification(PropelCollection $exchangesRelatedByIdModification, PropelPDO $con = null)
    {
        $exchangesRelatedByIdModificationToDelete = $this->getExchangesRelatedByIdModification(new Criteria(), $con)->diff($exchangesRelatedByIdModification);


        $this->exchangesRelatedByIdModificationScheduledForDeletion = $exchangesRelatedByIdModificationToDelete;

        foreach ($exchangesRelatedByIdModificationToDelete as $exchangeRelatedByIdModificationRemoved) {
            $exchangeRelatedByIdModificationRemoved->setAuthyRelatedByIdModification(null);
        }

        $this->collExchangesRelatedByIdModification = null;
        foreach ($exchangesRelatedByIdModification as $exchangeRelatedByIdModification) {
            $this->addExchangeRelatedByIdModification($exchangeRelatedByIdModification);
        }

        $this->collExchangesRelatedByIdModification = $exchangesRelatedByIdModification;
        $this->collExchangesRelatedByIdModificationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Exchange objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Exchange objects.
     * @throws PropelException
     */
    public function countExchangesRelatedByIdModification(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collExchangesRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collExchangesRelatedByIdModification || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collExchangesRelatedByIdModification) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getExchangesRelatedByIdModification());
            }
            $query = ExchangeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdModification($this)
                ->count($con);
        }

        return count($this->collExchangesRelatedByIdModification);
    }

    /**
     * Method called to associate a Exchange object to this object
     * through the Exchange foreign key attribute.
     *
     * @param    Exchange $l Exchange
     * @return Authy The current object (for fluent API support)
     */
    public function addExchangeRelatedByIdModification(Exchange $l)
    {
        if ($this->collExchangesRelatedByIdModification === null) {
            $this->initExchangesRelatedByIdModification();
            $this->collExchangesRelatedByIdModificationPartial = true;
        }

        if (!in_array($l, $this->collExchangesRelatedByIdModification->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddExchangeRelatedByIdModification($l);

            if ($this->exchangesRelatedByIdModificationScheduledForDeletion and $this->exchangesRelatedByIdModificationScheduledForDeletion->contains($l)) {
                $this->exchangesRelatedByIdModificationScheduledForDeletion->remove($this->exchangesRelatedByIdModificationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	ExchangeRelatedByIdModification $exchangeRelatedByIdModification The exchangeRelatedByIdModification object to add.
     */
    protected function doAddExchangeRelatedByIdModification($exchangeRelatedByIdModification)
    {
        $this->collExchangesRelatedByIdModification[]= $exchangeRelatedByIdModification;
        $exchangeRelatedByIdModification->setAuthyRelatedByIdModification($this);
    }

    /**
     * @param	ExchangeRelatedByIdModification $exchangeRelatedByIdModification The exchangeRelatedByIdModification object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeExchangeRelatedByIdModification($exchangeRelatedByIdModification)
    {
        if ($this->getExchangesRelatedByIdModification()->contains($exchangeRelatedByIdModification)) {
            $this->collExchangesRelatedByIdModification->remove($this->collExchangesRelatedByIdModification->search($exchangeRelatedByIdModification));
            if (null === $this->exchangesRelatedByIdModificationScheduledForDeletion) {
                $this->exchangesRelatedByIdModificationScheduledForDeletion = clone $this->collExchangesRelatedByIdModification;
                $this->exchangesRelatedByIdModificationScheduledForDeletion->clear();
            }
            $this->exchangesRelatedByIdModificationScheduledForDeletion[]= $exchangeRelatedByIdModification;
            $exchangeRelatedByIdModification->setAuthyRelatedByIdModification(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Exchange[] List of Exchange objects
     */
    public function getExchangesRelatedByIdModificationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ExchangeQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getExchangesRelatedByIdModification($query, $con);
    }

    /**
     * Clears out the collTokensRelatedByIdCreation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addTokensRelatedByIdCreation()
     */
    public function clearTokensRelatedByIdCreation()
    {
        $this->collTokensRelatedByIdCreation = null; // important to set this to null since that means it is uninitialized
        $this->collTokensRelatedByIdCreationPartial = null;

        return $this;
    }

    /**
     * reset is the collTokensRelatedByIdCreation collection loaded partially
     *
     * @return void
     */
    public function resetPartialTokensRelatedByIdCreation($v = true)
    {
        $this->collTokensRelatedByIdCreationPartial = $v;
    }

    /**
     * Initializes the collTokensRelatedByIdCreation collection.
     *
     * By default this just sets the collTokensRelatedByIdCreation collection to an empty array (like clearcollTokensRelatedByIdCreation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTokensRelatedByIdCreation($overrideExisting = true)
    {
        if (null !== $this->collTokensRelatedByIdCreation && !$overrideExisting) {
            return;
        }
        $this->collTokensRelatedByIdCreation = new PropelObjectCollection();
        $this->collTokensRelatedByIdCreation->setModel('Token');
    }

    /**
     * Gets an array of Token objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Token[] List of Token objects
     * @throws PropelException
     */
    public function getTokensRelatedByIdCreation($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collTokensRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collTokensRelatedByIdCreation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTokensRelatedByIdCreation) {
                // return empty collection
                $this->initTokensRelatedByIdCreation();
            } else {
                $collTokensRelatedByIdCreation = TokenQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdCreation($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collTokensRelatedByIdCreationPartial && count($collTokensRelatedByIdCreation)) {
                      $this->initTokensRelatedByIdCreation(false);

                      foreach ($collTokensRelatedByIdCreation as $obj) {
                        if (false == $this->collTokensRelatedByIdCreation->contains($obj)) {
                          $this->collTokensRelatedByIdCreation->append($obj);
                        }
                      }

                      $this->collTokensRelatedByIdCreationPartial = true;
                    }

                    $collTokensRelatedByIdCreation->getInternalIterator()->rewind();

                    return $collTokensRelatedByIdCreation;
                }

                if ($partial && $this->collTokensRelatedByIdCreation) {
                    foreach ($this->collTokensRelatedByIdCreation as $obj) {
                        if ($obj->isNew()) {
                            $collTokensRelatedByIdCreation[] = $obj;
                        }
                    }
                }

                $this->collTokensRelatedByIdCreation = $collTokensRelatedByIdCreation;
                $this->collTokensRelatedByIdCreationPartial = false;
            }
        }

        return $this->collTokensRelatedByIdCreation;
    }

    /**
     * Sets a collection of TokenRelatedByIdCreation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $tokensRelatedByIdCreation A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setTokensRelatedByIdCreation(PropelCollection $tokensRelatedByIdCreation, PropelPDO $con = null)
    {
        $tokensRelatedByIdCreationToDelete = $this->getTokensRelatedByIdCreation(new Criteria(), $con)->diff($tokensRelatedByIdCreation);


        $this->tokensRelatedByIdCreationScheduledForDeletion = $tokensRelatedByIdCreationToDelete;

        foreach ($tokensRelatedByIdCreationToDelete as $tokenRelatedByIdCreationRemoved) {
            $tokenRelatedByIdCreationRemoved->setAuthyRelatedByIdCreation(null);
        }

        $this->collTokensRelatedByIdCreation = null;
        foreach ($tokensRelatedByIdCreation as $tokenRelatedByIdCreation) {
            $this->addTokenRelatedByIdCreation($tokenRelatedByIdCreation);
        }

        $this->collTokensRelatedByIdCreation = $tokensRelatedByIdCreation;
        $this->collTokensRelatedByIdCreationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Token objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Token objects.
     * @throws PropelException
     */
    public function countTokensRelatedByIdCreation(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collTokensRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collTokensRelatedByIdCreation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTokensRelatedByIdCreation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTokensRelatedByIdCreation());
            }
            $query = TokenQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdCreation($this)
                ->count($con);
        }

        return count($this->collTokensRelatedByIdCreation);
    }

    /**
     * Method called to associate a Token object to this object
     * through the Token foreign key attribute.
     *
     * @param    Token $l Token
     * @return Authy The current object (for fluent API support)
     */
    public function addTokenRelatedByIdCreation(Token $l)
    {
        if ($this->collTokensRelatedByIdCreation === null) {
            $this->initTokensRelatedByIdCreation();
            $this->collTokensRelatedByIdCreationPartial = true;
        }

        if (!in_array($l, $this->collTokensRelatedByIdCreation->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddTokenRelatedByIdCreation($l);

            if ($this->tokensRelatedByIdCreationScheduledForDeletion and $this->tokensRelatedByIdCreationScheduledForDeletion->contains($l)) {
                $this->tokensRelatedByIdCreationScheduledForDeletion->remove($this->tokensRelatedByIdCreationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	TokenRelatedByIdCreation $tokenRelatedByIdCreation The tokenRelatedByIdCreation object to add.
     */
    protected function doAddTokenRelatedByIdCreation($tokenRelatedByIdCreation)
    {
        $this->collTokensRelatedByIdCreation[]= $tokenRelatedByIdCreation;
        $tokenRelatedByIdCreation->setAuthyRelatedByIdCreation($this);
    }

    /**
     * @param	TokenRelatedByIdCreation $tokenRelatedByIdCreation The tokenRelatedByIdCreation object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeTokenRelatedByIdCreation($tokenRelatedByIdCreation)
    {
        if ($this->getTokensRelatedByIdCreation()->contains($tokenRelatedByIdCreation)) {
            $this->collTokensRelatedByIdCreation->remove($this->collTokensRelatedByIdCreation->search($tokenRelatedByIdCreation));
            if (null === $this->tokensRelatedByIdCreationScheduledForDeletion) {
                $this->tokensRelatedByIdCreationScheduledForDeletion = clone $this->collTokensRelatedByIdCreation;
                $this->tokensRelatedByIdCreationScheduledForDeletion->clear();
            }
            $this->tokensRelatedByIdCreationScheduledForDeletion[]= $tokenRelatedByIdCreation;
            $tokenRelatedByIdCreation->setAuthyRelatedByIdCreation(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Token[] List of Token objects
     */
    public function getTokensRelatedByIdCreationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TokenQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getTokensRelatedByIdCreation($query, $con);
    }

    /**
     * Clears out the collTokensRelatedByIdModification collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addTokensRelatedByIdModification()
     */
    public function clearTokensRelatedByIdModification()
    {
        $this->collTokensRelatedByIdModification = null; // important to set this to null since that means it is uninitialized
        $this->collTokensRelatedByIdModificationPartial = null;

        return $this;
    }

    /**
     * reset is the collTokensRelatedByIdModification collection loaded partially
     *
     * @return void
     */
    public function resetPartialTokensRelatedByIdModification($v = true)
    {
        $this->collTokensRelatedByIdModificationPartial = $v;
    }

    /**
     * Initializes the collTokensRelatedByIdModification collection.
     *
     * By default this just sets the collTokensRelatedByIdModification collection to an empty array (like clearcollTokensRelatedByIdModification());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTokensRelatedByIdModification($overrideExisting = true)
    {
        if (null !== $this->collTokensRelatedByIdModification && !$overrideExisting) {
            return;
        }
        $this->collTokensRelatedByIdModification = new PropelObjectCollection();
        $this->collTokensRelatedByIdModification->setModel('Token');
    }

    /**
     * Gets an array of Token objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Token[] List of Token objects
     * @throws PropelException
     */
    public function getTokensRelatedByIdModification($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collTokensRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collTokensRelatedByIdModification || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTokensRelatedByIdModification) {
                // return empty collection
                $this->initTokensRelatedByIdModification();
            } else {
                $collTokensRelatedByIdModification = TokenQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdModification($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collTokensRelatedByIdModificationPartial && count($collTokensRelatedByIdModification)) {
                      $this->initTokensRelatedByIdModification(false);

                      foreach ($collTokensRelatedByIdModification as $obj) {
                        if (false == $this->collTokensRelatedByIdModification->contains($obj)) {
                          $this->collTokensRelatedByIdModification->append($obj);
                        }
                      }

                      $this->collTokensRelatedByIdModificationPartial = true;
                    }

                    $collTokensRelatedByIdModification->getInternalIterator()->rewind();

                    return $collTokensRelatedByIdModification;
                }

                if ($partial && $this->collTokensRelatedByIdModification) {
                    foreach ($this->collTokensRelatedByIdModification as $obj) {
                        if ($obj->isNew()) {
                            $collTokensRelatedByIdModification[] = $obj;
                        }
                    }
                }

                $this->collTokensRelatedByIdModification = $collTokensRelatedByIdModification;
                $this->collTokensRelatedByIdModificationPartial = false;
            }
        }

        return $this->collTokensRelatedByIdModification;
    }

    /**
     * Sets a collection of TokenRelatedByIdModification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $tokensRelatedByIdModification A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setTokensRelatedByIdModification(PropelCollection $tokensRelatedByIdModification, PropelPDO $con = null)
    {
        $tokensRelatedByIdModificationToDelete = $this->getTokensRelatedByIdModification(new Criteria(), $con)->diff($tokensRelatedByIdModification);


        $this->tokensRelatedByIdModificationScheduledForDeletion = $tokensRelatedByIdModificationToDelete;

        foreach ($tokensRelatedByIdModificationToDelete as $tokenRelatedByIdModificationRemoved) {
            $tokenRelatedByIdModificationRemoved->setAuthyRelatedByIdModification(null);
        }

        $this->collTokensRelatedByIdModification = null;
        foreach ($tokensRelatedByIdModification as $tokenRelatedByIdModification) {
            $this->addTokenRelatedByIdModification($tokenRelatedByIdModification);
        }

        $this->collTokensRelatedByIdModification = $tokensRelatedByIdModification;
        $this->collTokensRelatedByIdModificationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Token objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Token objects.
     * @throws PropelException
     */
    public function countTokensRelatedByIdModification(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collTokensRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collTokensRelatedByIdModification || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTokensRelatedByIdModification) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTokensRelatedByIdModification());
            }
            $query = TokenQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdModification($this)
                ->count($con);
        }

        return count($this->collTokensRelatedByIdModification);
    }

    /**
     * Method called to associate a Token object to this object
     * through the Token foreign key attribute.
     *
     * @param    Token $l Token
     * @return Authy The current object (for fluent API support)
     */
    public function addTokenRelatedByIdModification(Token $l)
    {
        if ($this->collTokensRelatedByIdModification === null) {
            $this->initTokensRelatedByIdModification();
            $this->collTokensRelatedByIdModificationPartial = true;
        }

        if (!in_array($l, $this->collTokensRelatedByIdModification->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddTokenRelatedByIdModification($l);

            if ($this->tokensRelatedByIdModificationScheduledForDeletion and $this->tokensRelatedByIdModificationScheduledForDeletion->contains($l)) {
                $this->tokensRelatedByIdModificationScheduledForDeletion->remove($this->tokensRelatedByIdModificationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	TokenRelatedByIdModification $tokenRelatedByIdModification The tokenRelatedByIdModification object to add.
     */
    protected function doAddTokenRelatedByIdModification($tokenRelatedByIdModification)
    {
        $this->collTokensRelatedByIdModification[]= $tokenRelatedByIdModification;
        $tokenRelatedByIdModification->setAuthyRelatedByIdModification($this);
    }

    /**
     * @param	TokenRelatedByIdModification $tokenRelatedByIdModification The tokenRelatedByIdModification object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeTokenRelatedByIdModification($tokenRelatedByIdModification)
    {
        if ($this->getTokensRelatedByIdModification()->contains($tokenRelatedByIdModification)) {
            $this->collTokensRelatedByIdModification->remove($this->collTokensRelatedByIdModification->search($tokenRelatedByIdModification));
            if (null === $this->tokensRelatedByIdModificationScheduledForDeletion) {
                $this->tokensRelatedByIdModificationScheduledForDeletion = clone $this->collTokensRelatedByIdModification;
                $this->tokensRelatedByIdModificationScheduledForDeletion->clear();
            }
            $this->tokensRelatedByIdModificationScheduledForDeletion[]= $tokenRelatedByIdModification;
            $tokenRelatedByIdModification->setAuthyRelatedByIdModification(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Token[] List of Token objects
     */
    public function getTokensRelatedByIdModificationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TokenQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getTokensRelatedByIdModification($query, $con);
    }

    /**
     * Clears out the collSymbolsRelatedByIdCreation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addSymbolsRelatedByIdCreation()
     */
    public function clearSymbolsRelatedByIdCreation()
    {
        $this->collSymbolsRelatedByIdCreation = null; // important to set this to null since that means it is uninitialized
        $this->collSymbolsRelatedByIdCreationPartial = null;

        return $this;
    }

    /**
     * reset is the collSymbolsRelatedByIdCreation collection loaded partially
     *
     * @return void
     */
    public function resetPartialSymbolsRelatedByIdCreation($v = true)
    {
        $this->collSymbolsRelatedByIdCreationPartial = $v;
    }

    /**
     * Initializes the collSymbolsRelatedByIdCreation collection.
     *
     * By default this just sets the collSymbolsRelatedByIdCreation collection to an empty array (like clearcollSymbolsRelatedByIdCreation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSymbolsRelatedByIdCreation($overrideExisting = true)
    {
        if (null !== $this->collSymbolsRelatedByIdCreation && !$overrideExisting) {
            return;
        }
        $this->collSymbolsRelatedByIdCreation = new PropelObjectCollection();
        $this->collSymbolsRelatedByIdCreation->setModel('Symbol');
    }

    /**
     * Gets an array of Symbol objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Symbol[] List of Symbol objects
     * @throws PropelException
     */
    public function getSymbolsRelatedByIdCreation($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collSymbolsRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collSymbolsRelatedByIdCreation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSymbolsRelatedByIdCreation) {
                // return empty collection
                $this->initSymbolsRelatedByIdCreation();
            } else {
                $collSymbolsRelatedByIdCreation = SymbolQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdCreation($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collSymbolsRelatedByIdCreationPartial && count($collSymbolsRelatedByIdCreation)) {
                      $this->initSymbolsRelatedByIdCreation(false);

                      foreach ($collSymbolsRelatedByIdCreation as $obj) {
                        if (false == $this->collSymbolsRelatedByIdCreation->contains($obj)) {
                          $this->collSymbolsRelatedByIdCreation->append($obj);
                        }
                      }

                      $this->collSymbolsRelatedByIdCreationPartial = true;
                    }

                    $collSymbolsRelatedByIdCreation->getInternalIterator()->rewind();

                    return $collSymbolsRelatedByIdCreation;
                }

                if ($partial && $this->collSymbolsRelatedByIdCreation) {
                    foreach ($this->collSymbolsRelatedByIdCreation as $obj) {
                        if ($obj->isNew()) {
                            $collSymbolsRelatedByIdCreation[] = $obj;
                        }
                    }
                }

                $this->collSymbolsRelatedByIdCreation = $collSymbolsRelatedByIdCreation;
                $this->collSymbolsRelatedByIdCreationPartial = false;
            }
        }

        return $this->collSymbolsRelatedByIdCreation;
    }

    /**
     * Sets a collection of SymbolRelatedByIdCreation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $symbolsRelatedByIdCreation A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setSymbolsRelatedByIdCreation(PropelCollection $symbolsRelatedByIdCreation, PropelPDO $con = null)
    {
        $symbolsRelatedByIdCreationToDelete = $this->getSymbolsRelatedByIdCreation(new Criteria(), $con)->diff($symbolsRelatedByIdCreation);


        $this->symbolsRelatedByIdCreationScheduledForDeletion = $symbolsRelatedByIdCreationToDelete;

        foreach ($symbolsRelatedByIdCreationToDelete as $symbolRelatedByIdCreationRemoved) {
            $symbolRelatedByIdCreationRemoved->setAuthyRelatedByIdCreation(null);
        }

        $this->collSymbolsRelatedByIdCreation = null;
        foreach ($symbolsRelatedByIdCreation as $symbolRelatedByIdCreation) {
            $this->addSymbolRelatedByIdCreation($symbolRelatedByIdCreation);
        }

        $this->collSymbolsRelatedByIdCreation = $symbolsRelatedByIdCreation;
        $this->collSymbolsRelatedByIdCreationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Symbol objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Symbol objects.
     * @throws PropelException
     */
    public function countSymbolsRelatedByIdCreation(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collSymbolsRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collSymbolsRelatedByIdCreation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSymbolsRelatedByIdCreation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSymbolsRelatedByIdCreation());
            }
            $query = SymbolQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdCreation($this)
                ->count($con);
        }

        return count($this->collSymbolsRelatedByIdCreation);
    }

    /**
     * Method called to associate a Symbol object to this object
     * through the Symbol foreign key attribute.
     *
     * @param    Symbol $l Symbol
     * @return Authy The current object (for fluent API support)
     */
    public function addSymbolRelatedByIdCreation(Symbol $l)
    {
        if ($this->collSymbolsRelatedByIdCreation === null) {
            $this->initSymbolsRelatedByIdCreation();
            $this->collSymbolsRelatedByIdCreationPartial = true;
        }

        if (!in_array($l, $this->collSymbolsRelatedByIdCreation->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddSymbolRelatedByIdCreation($l);

            if ($this->symbolsRelatedByIdCreationScheduledForDeletion and $this->symbolsRelatedByIdCreationScheduledForDeletion->contains($l)) {
                $this->symbolsRelatedByIdCreationScheduledForDeletion->remove($this->symbolsRelatedByIdCreationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	SymbolRelatedByIdCreation $symbolRelatedByIdCreation The symbolRelatedByIdCreation object to add.
     */
    protected function doAddSymbolRelatedByIdCreation($symbolRelatedByIdCreation)
    {
        $this->collSymbolsRelatedByIdCreation[]= $symbolRelatedByIdCreation;
        $symbolRelatedByIdCreation->setAuthyRelatedByIdCreation($this);
    }

    /**
     * @param	SymbolRelatedByIdCreation $symbolRelatedByIdCreation The symbolRelatedByIdCreation object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeSymbolRelatedByIdCreation($symbolRelatedByIdCreation)
    {
        if ($this->getSymbolsRelatedByIdCreation()->contains($symbolRelatedByIdCreation)) {
            $this->collSymbolsRelatedByIdCreation->remove($this->collSymbolsRelatedByIdCreation->search($symbolRelatedByIdCreation));
            if (null === $this->symbolsRelatedByIdCreationScheduledForDeletion) {
                $this->symbolsRelatedByIdCreationScheduledForDeletion = clone $this->collSymbolsRelatedByIdCreation;
                $this->symbolsRelatedByIdCreationScheduledForDeletion->clear();
            }
            $this->symbolsRelatedByIdCreationScheduledForDeletion[]= $symbolRelatedByIdCreation;
            $symbolRelatedByIdCreation->setAuthyRelatedByIdCreation(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Symbol[] List of Symbol objects
     */
    public function getSymbolsRelatedByIdCreationJoinToken($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = SymbolQuery::create(null, $criteria);
        $query->joinWith('Token', $join_behavior);

        return $this->getSymbolsRelatedByIdCreation($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Symbol[] List of Symbol objects
     */
    public function getSymbolsRelatedByIdCreationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = SymbolQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getSymbolsRelatedByIdCreation($query, $con);
    }

    /**
     * Clears out the collSymbolsRelatedByIdModification collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addSymbolsRelatedByIdModification()
     */
    public function clearSymbolsRelatedByIdModification()
    {
        $this->collSymbolsRelatedByIdModification = null; // important to set this to null since that means it is uninitialized
        $this->collSymbolsRelatedByIdModificationPartial = null;

        return $this;
    }

    /**
     * reset is the collSymbolsRelatedByIdModification collection loaded partially
     *
     * @return void
     */
    public function resetPartialSymbolsRelatedByIdModification($v = true)
    {
        $this->collSymbolsRelatedByIdModificationPartial = $v;
    }

    /**
     * Initializes the collSymbolsRelatedByIdModification collection.
     *
     * By default this just sets the collSymbolsRelatedByIdModification collection to an empty array (like clearcollSymbolsRelatedByIdModification());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSymbolsRelatedByIdModification($overrideExisting = true)
    {
        if (null !== $this->collSymbolsRelatedByIdModification && !$overrideExisting) {
            return;
        }
        $this->collSymbolsRelatedByIdModification = new PropelObjectCollection();
        $this->collSymbolsRelatedByIdModification->setModel('Symbol');
    }

    /**
     * Gets an array of Symbol objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Symbol[] List of Symbol objects
     * @throws PropelException
     */
    public function getSymbolsRelatedByIdModification($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collSymbolsRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collSymbolsRelatedByIdModification || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSymbolsRelatedByIdModification) {
                // return empty collection
                $this->initSymbolsRelatedByIdModification();
            } else {
                $collSymbolsRelatedByIdModification = SymbolQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdModification($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collSymbolsRelatedByIdModificationPartial && count($collSymbolsRelatedByIdModification)) {
                      $this->initSymbolsRelatedByIdModification(false);

                      foreach ($collSymbolsRelatedByIdModification as $obj) {
                        if (false == $this->collSymbolsRelatedByIdModification->contains($obj)) {
                          $this->collSymbolsRelatedByIdModification->append($obj);
                        }
                      }

                      $this->collSymbolsRelatedByIdModificationPartial = true;
                    }

                    $collSymbolsRelatedByIdModification->getInternalIterator()->rewind();

                    return $collSymbolsRelatedByIdModification;
                }

                if ($partial && $this->collSymbolsRelatedByIdModification) {
                    foreach ($this->collSymbolsRelatedByIdModification as $obj) {
                        if ($obj->isNew()) {
                            $collSymbolsRelatedByIdModification[] = $obj;
                        }
                    }
                }

                $this->collSymbolsRelatedByIdModification = $collSymbolsRelatedByIdModification;
                $this->collSymbolsRelatedByIdModificationPartial = false;
            }
        }

        return $this->collSymbolsRelatedByIdModification;
    }

    /**
     * Sets a collection of SymbolRelatedByIdModification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $symbolsRelatedByIdModification A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setSymbolsRelatedByIdModification(PropelCollection $symbolsRelatedByIdModification, PropelPDO $con = null)
    {
        $symbolsRelatedByIdModificationToDelete = $this->getSymbolsRelatedByIdModification(new Criteria(), $con)->diff($symbolsRelatedByIdModification);


        $this->symbolsRelatedByIdModificationScheduledForDeletion = $symbolsRelatedByIdModificationToDelete;

        foreach ($symbolsRelatedByIdModificationToDelete as $symbolRelatedByIdModificationRemoved) {
            $symbolRelatedByIdModificationRemoved->setAuthyRelatedByIdModification(null);
        }

        $this->collSymbolsRelatedByIdModification = null;
        foreach ($symbolsRelatedByIdModification as $symbolRelatedByIdModification) {
            $this->addSymbolRelatedByIdModification($symbolRelatedByIdModification);
        }

        $this->collSymbolsRelatedByIdModification = $symbolsRelatedByIdModification;
        $this->collSymbolsRelatedByIdModificationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Symbol objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Symbol objects.
     * @throws PropelException
     */
    public function countSymbolsRelatedByIdModification(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collSymbolsRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collSymbolsRelatedByIdModification || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSymbolsRelatedByIdModification) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSymbolsRelatedByIdModification());
            }
            $query = SymbolQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdModification($this)
                ->count($con);
        }

        return count($this->collSymbolsRelatedByIdModification);
    }

    /**
     * Method called to associate a Symbol object to this object
     * through the Symbol foreign key attribute.
     *
     * @param    Symbol $l Symbol
     * @return Authy The current object (for fluent API support)
     */
    public function addSymbolRelatedByIdModification(Symbol $l)
    {
        if ($this->collSymbolsRelatedByIdModification === null) {
            $this->initSymbolsRelatedByIdModification();
            $this->collSymbolsRelatedByIdModificationPartial = true;
        }

        if (!in_array($l, $this->collSymbolsRelatedByIdModification->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddSymbolRelatedByIdModification($l);

            if ($this->symbolsRelatedByIdModificationScheduledForDeletion and $this->symbolsRelatedByIdModificationScheduledForDeletion->contains($l)) {
                $this->symbolsRelatedByIdModificationScheduledForDeletion->remove($this->symbolsRelatedByIdModificationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	SymbolRelatedByIdModification $symbolRelatedByIdModification The symbolRelatedByIdModification object to add.
     */
    protected function doAddSymbolRelatedByIdModification($symbolRelatedByIdModification)
    {
        $this->collSymbolsRelatedByIdModification[]= $symbolRelatedByIdModification;
        $symbolRelatedByIdModification->setAuthyRelatedByIdModification($this);
    }

    /**
     * @param	SymbolRelatedByIdModification $symbolRelatedByIdModification The symbolRelatedByIdModification object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeSymbolRelatedByIdModification($symbolRelatedByIdModification)
    {
        if ($this->getSymbolsRelatedByIdModification()->contains($symbolRelatedByIdModification)) {
            $this->collSymbolsRelatedByIdModification->remove($this->collSymbolsRelatedByIdModification->search($symbolRelatedByIdModification));
            if (null === $this->symbolsRelatedByIdModificationScheduledForDeletion) {
                $this->symbolsRelatedByIdModificationScheduledForDeletion = clone $this->collSymbolsRelatedByIdModification;
                $this->symbolsRelatedByIdModificationScheduledForDeletion->clear();
            }
            $this->symbolsRelatedByIdModificationScheduledForDeletion[]= $symbolRelatedByIdModification;
            $symbolRelatedByIdModification->setAuthyRelatedByIdModification(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Symbol[] List of Symbol objects
     */
    public function getSymbolsRelatedByIdModificationJoinToken($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = SymbolQuery::create(null, $criteria);
        $query->joinWith('Token', $join_behavior);

        return $this->getSymbolsRelatedByIdModification($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Symbol[] List of Symbol objects
     */
    public function getSymbolsRelatedByIdModificationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = SymbolQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getSymbolsRelatedByIdModification($query, $con);
    }

    /**
     * Clears out the collImportsRelatedByIdCreation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addImportsRelatedByIdCreation()
     */
    public function clearImportsRelatedByIdCreation()
    {
        $this->collImportsRelatedByIdCreation = null; // important to set this to null since that means it is uninitialized
        $this->collImportsRelatedByIdCreationPartial = null;

        return $this;
    }

    /**
     * reset is the collImportsRelatedByIdCreation collection loaded partially
     *
     * @return void
     */
    public function resetPartialImportsRelatedByIdCreation($v = true)
    {
        $this->collImportsRelatedByIdCreationPartial = $v;
    }

    /**
     * Initializes the collImportsRelatedByIdCreation collection.
     *
     * By default this just sets the collImportsRelatedByIdCreation collection to an empty array (like clearcollImportsRelatedByIdCreation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initImportsRelatedByIdCreation($overrideExisting = true)
    {
        if (null !== $this->collImportsRelatedByIdCreation && !$overrideExisting) {
            return;
        }
        $this->collImportsRelatedByIdCreation = new PropelObjectCollection();
        $this->collImportsRelatedByIdCreation->setModel('Import');
    }

    /**
     * Gets an array of Import objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Import[] List of Import objects
     * @throws PropelException
     */
    public function getImportsRelatedByIdCreation($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collImportsRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collImportsRelatedByIdCreation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collImportsRelatedByIdCreation) {
                // return empty collection
                $this->initImportsRelatedByIdCreation();
            } else {
                $collImportsRelatedByIdCreation = ImportQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdCreation($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collImportsRelatedByIdCreationPartial && count($collImportsRelatedByIdCreation)) {
                      $this->initImportsRelatedByIdCreation(false);

                      foreach ($collImportsRelatedByIdCreation as $obj) {
                        if (false == $this->collImportsRelatedByIdCreation->contains($obj)) {
                          $this->collImportsRelatedByIdCreation->append($obj);
                        }
                      }

                      $this->collImportsRelatedByIdCreationPartial = true;
                    }

                    $collImportsRelatedByIdCreation->getInternalIterator()->rewind();

                    return $collImportsRelatedByIdCreation;
                }

                if ($partial && $this->collImportsRelatedByIdCreation) {
                    foreach ($this->collImportsRelatedByIdCreation as $obj) {
                        if ($obj->isNew()) {
                            $collImportsRelatedByIdCreation[] = $obj;
                        }
                    }
                }

                $this->collImportsRelatedByIdCreation = $collImportsRelatedByIdCreation;
                $this->collImportsRelatedByIdCreationPartial = false;
            }
        }

        return $this->collImportsRelatedByIdCreation;
    }

    /**
     * Sets a collection of ImportRelatedByIdCreation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $importsRelatedByIdCreation A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setImportsRelatedByIdCreation(PropelCollection $importsRelatedByIdCreation, PropelPDO $con = null)
    {
        $importsRelatedByIdCreationToDelete = $this->getImportsRelatedByIdCreation(new Criteria(), $con)->diff($importsRelatedByIdCreation);


        $this->importsRelatedByIdCreationScheduledForDeletion = $importsRelatedByIdCreationToDelete;

        foreach ($importsRelatedByIdCreationToDelete as $importRelatedByIdCreationRemoved) {
            $importRelatedByIdCreationRemoved->setAuthyRelatedByIdCreation(null);
        }

        $this->collImportsRelatedByIdCreation = null;
        foreach ($importsRelatedByIdCreation as $importRelatedByIdCreation) {
            $this->addImportRelatedByIdCreation($importRelatedByIdCreation);
        }

        $this->collImportsRelatedByIdCreation = $importsRelatedByIdCreation;
        $this->collImportsRelatedByIdCreationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Import objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Import objects.
     * @throws PropelException
     */
    public function countImportsRelatedByIdCreation(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collImportsRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collImportsRelatedByIdCreation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collImportsRelatedByIdCreation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getImportsRelatedByIdCreation());
            }
            $query = ImportQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdCreation($this)
                ->count($con);
        }

        return count($this->collImportsRelatedByIdCreation);
    }

    /**
     * Method called to associate a Import object to this object
     * through the Import foreign key attribute.
     *
     * @param    Import $l Import
     * @return Authy The current object (for fluent API support)
     */
    public function addImportRelatedByIdCreation(Import $l)
    {
        if ($this->collImportsRelatedByIdCreation === null) {
            $this->initImportsRelatedByIdCreation();
            $this->collImportsRelatedByIdCreationPartial = true;
        }

        if (!in_array($l, $this->collImportsRelatedByIdCreation->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddImportRelatedByIdCreation($l);

            if ($this->importsRelatedByIdCreationScheduledForDeletion and $this->importsRelatedByIdCreationScheduledForDeletion->contains($l)) {
                $this->importsRelatedByIdCreationScheduledForDeletion->remove($this->importsRelatedByIdCreationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	ImportRelatedByIdCreation $importRelatedByIdCreation The importRelatedByIdCreation object to add.
     */
    protected function doAddImportRelatedByIdCreation($importRelatedByIdCreation)
    {
        $this->collImportsRelatedByIdCreation[]= $importRelatedByIdCreation;
        $importRelatedByIdCreation->setAuthyRelatedByIdCreation($this);
    }

    /**
     * @param	ImportRelatedByIdCreation $importRelatedByIdCreation The importRelatedByIdCreation object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeImportRelatedByIdCreation($importRelatedByIdCreation)
    {
        if ($this->getImportsRelatedByIdCreation()->contains($importRelatedByIdCreation)) {
            $this->collImportsRelatedByIdCreation->remove($this->collImportsRelatedByIdCreation->search($importRelatedByIdCreation));
            if (null === $this->importsRelatedByIdCreationScheduledForDeletion) {
                $this->importsRelatedByIdCreationScheduledForDeletion = clone $this->collImportsRelatedByIdCreation;
                $this->importsRelatedByIdCreationScheduledForDeletion->clear();
            }
            $this->importsRelatedByIdCreationScheduledForDeletion[]= $importRelatedByIdCreation;
            $importRelatedByIdCreation->setAuthyRelatedByIdCreation(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Import[] List of Import objects
     */
    public function getImportsRelatedByIdCreationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ImportQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getImportsRelatedByIdCreation($query, $con);
    }

    /**
     * Clears out the collImportsRelatedByIdModification collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addImportsRelatedByIdModification()
     */
    public function clearImportsRelatedByIdModification()
    {
        $this->collImportsRelatedByIdModification = null; // important to set this to null since that means it is uninitialized
        $this->collImportsRelatedByIdModificationPartial = null;

        return $this;
    }

    /**
     * reset is the collImportsRelatedByIdModification collection loaded partially
     *
     * @return void
     */
    public function resetPartialImportsRelatedByIdModification($v = true)
    {
        $this->collImportsRelatedByIdModificationPartial = $v;
    }

    /**
     * Initializes the collImportsRelatedByIdModification collection.
     *
     * By default this just sets the collImportsRelatedByIdModification collection to an empty array (like clearcollImportsRelatedByIdModification());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initImportsRelatedByIdModification($overrideExisting = true)
    {
        if (null !== $this->collImportsRelatedByIdModification && !$overrideExisting) {
            return;
        }
        $this->collImportsRelatedByIdModification = new PropelObjectCollection();
        $this->collImportsRelatedByIdModification->setModel('Import');
    }

    /**
     * Gets an array of Import objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Import[] List of Import objects
     * @throws PropelException
     */
    public function getImportsRelatedByIdModification($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collImportsRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collImportsRelatedByIdModification || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collImportsRelatedByIdModification) {
                // return empty collection
                $this->initImportsRelatedByIdModification();
            } else {
                $collImportsRelatedByIdModification = ImportQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdModification($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collImportsRelatedByIdModificationPartial && count($collImportsRelatedByIdModification)) {
                      $this->initImportsRelatedByIdModification(false);

                      foreach ($collImportsRelatedByIdModification as $obj) {
                        if (false == $this->collImportsRelatedByIdModification->contains($obj)) {
                          $this->collImportsRelatedByIdModification->append($obj);
                        }
                      }

                      $this->collImportsRelatedByIdModificationPartial = true;
                    }

                    $collImportsRelatedByIdModification->getInternalIterator()->rewind();

                    return $collImportsRelatedByIdModification;
                }

                if ($partial && $this->collImportsRelatedByIdModification) {
                    foreach ($this->collImportsRelatedByIdModification as $obj) {
                        if ($obj->isNew()) {
                            $collImportsRelatedByIdModification[] = $obj;
                        }
                    }
                }

                $this->collImportsRelatedByIdModification = $collImportsRelatedByIdModification;
                $this->collImportsRelatedByIdModificationPartial = false;
            }
        }

        return $this->collImportsRelatedByIdModification;
    }

    /**
     * Sets a collection of ImportRelatedByIdModification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $importsRelatedByIdModification A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setImportsRelatedByIdModification(PropelCollection $importsRelatedByIdModification, PropelPDO $con = null)
    {
        $importsRelatedByIdModificationToDelete = $this->getImportsRelatedByIdModification(new Criteria(), $con)->diff($importsRelatedByIdModification);


        $this->importsRelatedByIdModificationScheduledForDeletion = $importsRelatedByIdModificationToDelete;

        foreach ($importsRelatedByIdModificationToDelete as $importRelatedByIdModificationRemoved) {
            $importRelatedByIdModificationRemoved->setAuthyRelatedByIdModification(null);
        }

        $this->collImportsRelatedByIdModification = null;
        foreach ($importsRelatedByIdModification as $importRelatedByIdModification) {
            $this->addImportRelatedByIdModification($importRelatedByIdModification);
        }

        $this->collImportsRelatedByIdModification = $importsRelatedByIdModification;
        $this->collImportsRelatedByIdModificationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Import objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Import objects.
     * @throws PropelException
     */
    public function countImportsRelatedByIdModification(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collImportsRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collImportsRelatedByIdModification || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collImportsRelatedByIdModification) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getImportsRelatedByIdModification());
            }
            $query = ImportQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdModification($this)
                ->count($con);
        }

        return count($this->collImportsRelatedByIdModification);
    }

    /**
     * Method called to associate a Import object to this object
     * through the Import foreign key attribute.
     *
     * @param    Import $l Import
     * @return Authy The current object (for fluent API support)
     */
    public function addImportRelatedByIdModification(Import $l)
    {
        if ($this->collImportsRelatedByIdModification === null) {
            $this->initImportsRelatedByIdModification();
            $this->collImportsRelatedByIdModificationPartial = true;
        }

        if (!in_array($l, $this->collImportsRelatedByIdModification->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddImportRelatedByIdModification($l);

            if ($this->importsRelatedByIdModificationScheduledForDeletion and $this->importsRelatedByIdModificationScheduledForDeletion->contains($l)) {
                $this->importsRelatedByIdModificationScheduledForDeletion->remove($this->importsRelatedByIdModificationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	ImportRelatedByIdModification $importRelatedByIdModification The importRelatedByIdModification object to add.
     */
    protected function doAddImportRelatedByIdModification($importRelatedByIdModification)
    {
        $this->collImportsRelatedByIdModification[]= $importRelatedByIdModification;
        $importRelatedByIdModification->setAuthyRelatedByIdModification($this);
    }

    /**
     * @param	ImportRelatedByIdModification $importRelatedByIdModification The importRelatedByIdModification object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeImportRelatedByIdModification($importRelatedByIdModification)
    {
        if ($this->getImportsRelatedByIdModification()->contains($importRelatedByIdModification)) {
            $this->collImportsRelatedByIdModification->remove($this->collImportsRelatedByIdModification->search($importRelatedByIdModification));
            if (null === $this->importsRelatedByIdModificationScheduledForDeletion) {
                $this->importsRelatedByIdModificationScheduledForDeletion = clone $this->collImportsRelatedByIdModification;
                $this->importsRelatedByIdModificationScheduledForDeletion->clear();
            }
            $this->importsRelatedByIdModificationScheduledForDeletion[]= $importRelatedByIdModification;
            $importRelatedByIdModification->setAuthyRelatedByIdModification(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Import[] List of Import objects
     */
    public function getImportsRelatedByIdModificationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ImportQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getImportsRelatedByIdModification($query, $con);
    }

    /**
     * Clears out the collAuthyGroupsRelatedByIdCreation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addAuthyGroupsRelatedByIdCreation()
     */
    public function clearAuthyGroupsRelatedByIdCreation()
    {
        $this->collAuthyGroupsRelatedByIdCreation = null; // important to set this to null since that means it is uninitialized
        $this->collAuthyGroupsRelatedByIdCreationPartial = null;

        return $this;
    }

    /**
     * reset is the collAuthyGroupsRelatedByIdCreation collection loaded partially
     *
     * @return void
     */
    public function resetPartialAuthyGroupsRelatedByIdCreation($v = true)
    {
        $this->collAuthyGroupsRelatedByIdCreationPartial = $v;
    }

    /**
     * Initializes the collAuthyGroupsRelatedByIdCreation collection.
     *
     * By default this just sets the collAuthyGroupsRelatedByIdCreation collection to an empty array (like clearcollAuthyGroupsRelatedByIdCreation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAuthyGroupsRelatedByIdCreation($overrideExisting = true)
    {
        if (null !== $this->collAuthyGroupsRelatedByIdCreation && !$overrideExisting) {
            return;
        }
        $this->collAuthyGroupsRelatedByIdCreation = new PropelObjectCollection();
        $this->collAuthyGroupsRelatedByIdCreation->setModel('AuthyGroup');
    }

    /**
     * Gets an array of AuthyGroup objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AuthyGroup[] List of AuthyGroup objects
     * @throws PropelException
     */
    public function getAuthyGroupsRelatedByIdCreation($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAuthyGroupsRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collAuthyGroupsRelatedByIdCreation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAuthyGroupsRelatedByIdCreation) {
                // return empty collection
                $this->initAuthyGroupsRelatedByIdCreation();
            } else {
                $collAuthyGroupsRelatedByIdCreation = AuthyGroupQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdCreation($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAuthyGroupsRelatedByIdCreationPartial && count($collAuthyGroupsRelatedByIdCreation)) {
                      $this->initAuthyGroupsRelatedByIdCreation(false);

                      foreach ($collAuthyGroupsRelatedByIdCreation as $obj) {
                        if (false == $this->collAuthyGroupsRelatedByIdCreation->contains($obj)) {
                          $this->collAuthyGroupsRelatedByIdCreation->append($obj);
                        }
                      }

                      $this->collAuthyGroupsRelatedByIdCreationPartial = true;
                    }

                    $collAuthyGroupsRelatedByIdCreation->getInternalIterator()->rewind();

                    return $collAuthyGroupsRelatedByIdCreation;
                }

                if ($partial && $this->collAuthyGroupsRelatedByIdCreation) {
                    foreach ($this->collAuthyGroupsRelatedByIdCreation as $obj) {
                        if ($obj->isNew()) {
                            $collAuthyGroupsRelatedByIdCreation[] = $obj;
                        }
                    }
                }

                $this->collAuthyGroupsRelatedByIdCreation = $collAuthyGroupsRelatedByIdCreation;
                $this->collAuthyGroupsRelatedByIdCreationPartial = false;
            }
        }

        return $this->collAuthyGroupsRelatedByIdCreation;
    }

    /**
     * Sets a collection of AuthyGroupRelatedByIdCreation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $authyGroupsRelatedByIdCreation A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setAuthyGroupsRelatedByIdCreation(PropelCollection $authyGroupsRelatedByIdCreation, PropelPDO $con = null)
    {
        $authyGroupsRelatedByIdCreationToDelete = $this->getAuthyGroupsRelatedByIdCreation(new Criteria(), $con)->diff($authyGroupsRelatedByIdCreation);


        $this->authyGroupsRelatedByIdCreationScheduledForDeletion = $authyGroupsRelatedByIdCreationToDelete;

        foreach ($authyGroupsRelatedByIdCreationToDelete as $authyGroupRelatedByIdCreationRemoved) {
            $authyGroupRelatedByIdCreationRemoved->setAuthyRelatedByIdCreation(null);
        }

        $this->collAuthyGroupsRelatedByIdCreation = null;
        foreach ($authyGroupsRelatedByIdCreation as $authyGroupRelatedByIdCreation) {
            $this->addAuthyGroupRelatedByIdCreation($authyGroupRelatedByIdCreation);
        }

        $this->collAuthyGroupsRelatedByIdCreation = $authyGroupsRelatedByIdCreation;
        $this->collAuthyGroupsRelatedByIdCreationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AuthyGroup objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AuthyGroup objects.
     * @throws PropelException
     */
    public function countAuthyGroupsRelatedByIdCreation(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAuthyGroupsRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collAuthyGroupsRelatedByIdCreation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAuthyGroupsRelatedByIdCreation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAuthyGroupsRelatedByIdCreation());
            }
            $query = AuthyGroupQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdCreation($this)
                ->count($con);
        }

        return count($this->collAuthyGroupsRelatedByIdCreation);
    }

    /**
     * Method called to associate a AuthyGroup object to this object
     * through the AuthyGroup foreign key attribute.
     *
     * @param    AuthyGroup $l AuthyGroup
     * @return Authy The current object (for fluent API support)
     */
    public function addAuthyGroupRelatedByIdCreation(AuthyGroup $l)
    {
        if ($this->collAuthyGroupsRelatedByIdCreation === null) {
            $this->initAuthyGroupsRelatedByIdCreation();
            $this->collAuthyGroupsRelatedByIdCreationPartial = true;
        }

        if (!in_array($l, $this->collAuthyGroupsRelatedByIdCreation->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAuthyGroupRelatedByIdCreation($l);

            if ($this->authyGroupsRelatedByIdCreationScheduledForDeletion and $this->authyGroupsRelatedByIdCreationScheduledForDeletion->contains($l)) {
                $this->authyGroupsRelatedByIdCreationScheduledForDeletion->remove($this->authyGroupsRelatedByIdCreationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AuthyGroupRelatedByIdCreation $authyGroupRelatedByIdCreation The authyGroupRelatedByIdCreation object to add.
     */
    protected function doAddAuthyGroupRelatedByIdCreation($authyGroupRelatedByIdCreation)
    {
        $this->collAuthyGroupsRelatedByIdCreation[]= $authyGroupRelatedByIdCreation;
        $authyGroupRelatedByIdCreation->setAuthyRelatedByIdCreation($this);
    }

    /**
     * @param	AuthyGroupRelatedByIdCreation $authyGroupRelatedByIdCreation The authyGroupRelatedByIdCreation object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeAuthyGroupRelatedByIdCreation($authyGroupRelatedByIdCreation)
    {
        if ($this->getAuthyGroupsRelatedByIdCreation()->contains($authyGroupRelatedByIdCreation)) {
            $this->collAuthyGroupsRelatedByIdCreation->remove($this->collAuthyGroupsRelatedByIdCreation->search($authyGroupRelatedByIdCreation));
            if (null === $this->authyGroupsRelatedByIdCreationScheduledForDeletion) {
                $this->authyGroupsRelatedByIdCreationScheduledForDeletion = clone $this->collAuthyGroupsRelatedByIdCreation;
                $this->authyGroupsRelatedByIdCreationScheduledForDeletion->clear();
            }
            $this->authyGroupsRelatedByIdCreationScheduledForDeletion[]= $authyGroupRelatedByIdCreation;
            $authyGroupRelatedByIdCreation->setAuthyRelatedByIdCreation(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AuthyGroup[] List of AuthyGroup objects
     */
    public function getAuthyGroupsRelatedByIdCreationJoinAuthyGroupRelatedByIdGroupCreation($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AuthyGroupQuery::create(null, $criteria);
        $query->joinWith('AuthyGroupRelatedByIdGroupCreation', $join_behavior);

        return $this->getAuthyGroupsRelatedByIdCreation($query, $con);
    }

    /**
     * Clears out the collAuthyGroupsRelatedByIdModification collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addAuthyGroupsRelatedByIdModification()
     */
    public function clearAuthyGroupsRelatedByIdModification()
    {
        $this->collAuthyGroupsRelatedByIdModification = null; // important to set this to null since that means it is uninitialized
        $this->collAuthyGroupsRelatedByIdModificationPartial = null;

        return $this;
    }

    /**
     * reset is the collAuthyGroupsRelatedByIdModification collection loaded partially
     *
     * @return void
     */
    public function resetPartialAuthyGroupsRelatedByIdModification($v = true)
    {
        $this->collAuthyGroupsRelatedByIdModificationPartial = $v;
    }

    /**
     * Initializes the collAuthyGroupsRelatedByIdModification collection.
     *
     * By default this just sets the collAuthyGroupsRelatedByIdModification collection to an empty array (like clearcollAuthyGroupsRelatedByIdModification());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAuthyGroupsRelatedByIdModification($overrideExisting = true)
    {
        if (null !== $this->collAuthyGroupsRelatedByIdModification && !$overrideExisting) {
            return;
        }
        $this->collAuthyGroupsRelatedByIdModification = new PropelObjectCollection();
        $this->collAuthyGroupsRelatedByIdModification->setModel('AuthyGroup');
    }

    /**
     * Gets an array of AuthyGroup objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AuthyGroup[] List of AuthyGroup objects
     * @throws PropelException
     */
    public function getAuthyGroupsRelatedByIdModification($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAuthyGroupsRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collAuthyGroupsRelatedByIdModification || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAuthyGroupsRelatedByIdModification) {
                // return empty collection
                $this->initAuthyGroupsRelatedByIdModification();
            } else {
                $collAuthyGroupsRelatedByIdModification = AuthyGroupQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdModification($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAuthyGroupsRelatedByIdModificationPartial && count($collAuthyGroupsRelatedByIdModification)) {
                      $this->initAuthyGroupsRelatedByIdModification(false);

                      foreach ($collAuthyGroupsRelatedByIdModification as $obj) {
                        if (false == $this->collAuthyGroupsRelatedByIdModification->contains($obj)) {
                          $this->collAuthyGroupsRelatedByIdModification->append($obj);
                        }
                      }

                      $this->collAuthyGroupsRelatedByIdModificationPartial = true;
                    }

                    $collAuthyGroupsRelatedByIdModification->getInternalIterator()->rewind();

                    return $collAuthyGroupsRelatedByIdModification;
                }

                if ($partial && $this->collAuthyGroupsRelatedByIdModification) {
                    foreach ($this->collAuthyGroupsRelatedByIdModification as $obj) {
                        if ($obj->isNew()) {
                            $collAuthyGroupsRelatedByIdModification[] = $obj;
                        }
                    }
                }

                $this->collAuthyGroupsRelatedByIdModification = $collAuthyGroupsRelatedByIdModification;
                $this->collAuthyGroupsRelatedByIdModificationPartial = false;
            }
        }

        return $this->collAuthyGroupsRelatedByIdModification;
    }

    /**
     * Sets a collection of AuthyGroupRelatedByIdModification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $authyGroupsRelatedByIdModification A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setAuthyGroupsRelatedByIdModification(PropelCollection $authyGroupsRelatedByIdModification, PropelPDO $con = null)
    {
        $authyGroupsRelatedByIdModificationToDelete = $this->getAuthyGroupsRelatedByIdModification(new Criteria(), $con)->diff($authyGroupsRelatedByIdModification);


        $this->authyGroupsRelatedByIdModificationScheduledForDeletion = $authyGroupsRelatedByIdModificationToDelete;

        foreach ($authyGroupsRelatedByIdModificationToDelete as $authyGroupRelatedByIdModificationRemoved) {
            $authyGroupRelatedByIdModificationRemoved->setAuthyRelatedByIdModification(null);
        }

        $this->collAuthyGroupsRelatedByIdModification = null;
        foreach ($authyGroupsRelatedByIdModification as $authyGroupRelatedByIdModification) {
            $this->addAuthyGroupRelatedByIdModification($authyGroupRelatedByIdModification);
        }

        $this->collAuthyGroupsRelatedByIdModification = $authyGroupsRelatedByIdModification;
        $this->collAuthyGroupsRelatedByIdModificationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AuthyGroup objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AuthyGroup objects.
     * @throws PropelException
     */
    public function countAuthyGroupsRelatedByIdModification(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAuthyGroupsRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collAuthyGroupsRelatedByIdModification || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAuthyGroupsRelatedByIdModification) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAuthyGroupsRelatedByIdModification());
            }
            $query = AuthyGroupQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdModification($this)
                ->count($con);
        }

        return count($this->collAuthyGroupsRelatedByIdModification);
    }

    /**
     * Method called to associate a AuthyGroup object to this object
     * through the AuthyGroup foreign key attribute.
     *
     * @param    AuthyGroup $l AuthyGroup
     * @return Authy The current object (for fluent API support)
     */
    public function addAuthyGroupRelatedByIdModification(AuthyGroup $l)
    {
        if ($this->collAuthyGroupsRelatedByIdModification === null) {
            $this->initAuthyGroupsRelatedByIdModification();
            $this->collAuthyGroupsRelatedByIdModificationPartial = true;
        }

        if (!in_array($l, $this->collAuthyGroupsRelatedByIdModification->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAuthyGroupRelatedByIdModification($l);

            if ($this->authyGroupsRelatedByIdModificationScheduledForDeletion and $this->authyGroupsRelatedByIdModificationScheduledForDeletion->contains($l)) {
                $this->authyGroupsRelatedByIdModificationScheduledForDeletion->remove($this->authyGroupsRelatedByIdModificationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AuthyGroupRelatedByIdModification $authyGroupRelatedByIdModification The authyGroupRelatedByIdModification object to add.
     */
    protected function doAddAuthyGroupRelatedByIdModification($authyGroupRelatedByIdModification)
    {
        $this->collAuthyGroupsRelatedByIdModification[]= $authyGroupRelatedByIdModification;
        $authyGroupRelatedByIdModification->setAuthyRelatedByIdModification($this);
    }

    /**
     * @param	AuthyGroupRelatedByIdModification $authyGroupRelatedByIdModification The authyGroupRelatedByIdModification object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeAuthyGroupRelatedByIdModification($authyGroupRelatedByIdModification)
    {
        if ($this->getAuthyGroupsRelatedByIdModification()->contains($authyGroupRelatedByIdModification)) {
            $this->collAuthyGroupsRelatedByIdModification->remove($this->collAuthyGroupsRelatedByIdModification->search($authyGroupRelatedByIdModification));
            if (null === $this->authyGroupsRelatedByIdModificationScheduledForDeletion) {
                $this->authyGroupsRelatedByIdModificationScheduledForDeletion = clone $this->collAuthyGroupsRelatedByIdModification;
                $this->authyGroupsRelatedByIdModificationScheduledForDeletion->clear();
            }
            $this->authyGroupsRelatedByIdModificationScheduledForDeletion[]= $authyGroupRelatedByIdModification;
            $authyGroupRelatedByIdModification->setAuthyRelatedByIdModification(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AuthyGroup[] List of AuthyGroup objects
     */
    public function getAuthyGroupsRelatedByIdModificationJoinAuthyGroupRelatedByIdGroupCreation($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AuthyGroupQuery::create(null, $criteria);
        $query->joinWith('AuthyGroupRelatedByIdGroupCreation', $join_behavior);

        return $this->getAuthyGroupsRelatedByIdModification($query, $con);
    }

    /**
     * Clears out the collConfigsRelatedByIdCreation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addConfigsRelatedByIdCreation()
     */
    public function clearConfigsRelatedByIdCreation()
    {
        $this->collConfigsRelatedByIdCreation = null; // important to set this to null since that means it is uninitialized
        $this->collConfigsRelatedByIdCreationPartial = null;

        return $this;
    }

    /**
     * reset is the collConfigsRelatedByIdCreation collection loaded partially
     *
     * @return void
     */
    public function resetPartialConfigsRelatedByIdCreation($v = true)
    {
        $this->collConfigsRelatedByIdCreationPartial = $v;
    }

    /**
     * Initializes the collConfigsRelatedByIdCreation collection.
     *
     * By default this just sets the collConfigsRelatedByIdCreation collection to an empty array (like clearcollConfigsRelatedByIdCreation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initConfigsRelatedByIdCreation($overrideExisting = true)
    {
        if (null !== $this->collConfigsRelatedByIdCreation && !$overrideExisting) {
            return;
        }
        $this->collConfigsRelatedByIdCreation = new PropelObjectCollection();
        $this->collConfigsRelatedByIdCreation->setModel('Config');
    }

    /**
     * Gets an array of Config objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Config[] List of Config objects
     * @throws PropelException
     */
    public function getConfigsRelatedByIdCreation($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collConfigsRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collConfigsRelatedByIdCreation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collConfigsRelatedByIdCreation) {
                // return empty collection
                $this->initConfigsRelatedByIdCreation();
            } else {
                $collConfigsRelatedByIdCreation = ConfigQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdCreation($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collConfigsRelatedByIdCreationPartial && count($collConfigsRelatedByIdCreation)) {
                      $this->initConfigsRelatedByIdCreation(false);

                      foreach ($collConfigsRelatedByIdCreation as $obj) {
                        if (false == $this->collConfigsRelatedByIdCreation->contains($obj)) {
                          $this->collConfigsRelatedByIdCreation->append($obj);
                        }
                      }

                      $this->collConfigsRelatedByIdCreationPartial = true;
                    }

                    $collConfigsRelatedByIdCreation->getInternalIterator()->rewind();

                    return $collConfigsRelatedByIdCreation;
                }

                if ($partial && $this->collConfigsRelatedByIdCreation) {
                    foreach ($this->collConfigsRelatedByIdCreation as $obj) {
                        if ($obj->isNew()) {
                            $collConfigsRelatedByIdCreation[] = $obj;
                        }
                    }
                }

                $this->collConfigsRelatedByIdCreation = $collConfigsRelatedByIdCreation;
                $this->collConfigsRelatedByIdCreationPartial = false;
            }
        }

        return $this->collConfigsRelatedByIdCreation;
    }

    /**
     * Sets a collection of ConfigRelatedByIdCreation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $configsRelatedByIdCreation A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setConfigsRelatedByIdCreation(PropelCollection $configsRelatedByIdCreation, PropelPDO $con = null)
    {
        $configsRelatedByIdCreationToDelete = $this->getConfigsRelatedByIdCreation(new Criteria(), $con)->diff($configsRelatedByIdCreation);


        $this->configsRelatedByIdCreationScheduledForDeletion = $configsRelatedByIdCreationToDelete;

        foreach ($configsRelatedByIdCreationToDelete as $configRelatedByIdCreationRemoved) {
            $configRelatedByIdCreationRemoved->setAuthyRelatedByIdCreation(null);
        }

        $this->collConfigsRelatedByIdCreation = null;
        foreach ($configsRelatedByIdCreation as $configRelatedByIdCreation) {
            $this->addConfigRelatedByIdCreation($configRelatedByIdCreation);
        }

        $this->collConfigsRelatedByIdCreation = $configsRelatedByIdCreation;
        $this->collConfigsRelatedByIdCreationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Config objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Config objects.
     * @throws PropelException
     */
    public function countConfigsRelatedByIdCreation(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collConfigsRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collConfigsRelatedByIdCreation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collConfigsRelatedByIdCreation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getConfigsRelatedByIdCreation());
            }
            $query = ConfigQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdCreation($this)
                ->count($con);
        }

        return count($this->collConfigsRelatedByIdCreation);
    }

    /**
     * Method called to associate a Config object to this object
     * through the Config foreign key attribute.
     *
     * @param    Config $l Config
     * @return Authy The current object (for fluent API support)
     */
    public function addConfigRelatedByIdCreation(Config $l)
    {
        if ($this->collConfigsRelatedByIdCreation === null) {
            $this->initConfigsRelatedByIdCreation();
            $this->collConfigsRelatedByIdCreationPartial = true;
        }

        if (!in_array($l, $this->collConfigsRelatedByIdCreation->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddConfigRelatedByIdCreation($l);

            if ($this->configsRelatedByIdCreationScheduledForDeletion and $this->configsRelatedByIdCreationScheduledForDeletion->contains($l)) {
                $this->configsRelatedByIdCreationScheduledForDeletion->remove($this->configsRelatedByIdCreationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	ConfigRelatedByIdCreation $configRelatedByIdCreation The configRelatedByIdCreation object to add.
     */
    protected function doAddConfigRelatedByIdCreation($configRelatedByIdCreation)
    {
        $this->collConfigsRelatedByIdCreation[]= $configRelatedByIdCreation;
        $configRelatedByIdCreation->setAuthyRelatedByIdCreation($this);
    }

    /**
     * @param	ConfigRelatedByIdCreation $configRelatedByIdCreation The configRelatedByIdCreation object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeConfigRelatedByIdCreation($configRelatedByIdCreation)
    {
        if ($this->getConfigsRelatedByIdCreation()->contains($configRelatedByIdCreation)) {
            $this->collConfigsRelatedByIdCreation->remove($this->collConfigsRelatedByIdCreation->search($configRelatedByIdCreation));
            if (null === $this->configsRelatedByIdCreationScheduledForDeletion) {
                $this->configsRelatedByIdCreationScheduledForDeletion = clone $this->collConfigsRelatedByIdCreation;
                $this->configsRelatedByIdCreationScheduledForDeletion->clear();
            }
            $this->configsRelatedByIdCreationScheduledForDeletion[]= $configRelatedByIdCreation;
            $configRelatedByIdCreation->setAuthyRelatedByIdCreation(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Config[] List of Config objects
     */
    public function getConfigsRelatedByIdCreationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ConfigQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getConfigsRelatedByIdCreation($query, $con);
    }

    /**
     * Clears out the collConfigsRelatedByIdModification collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addConfigsRelatedByIdModification()
     */
    public function clearConfigsRelatedByIdModification()
    {
        $this->collConfigsRelatedByIdModification = null; // important to set this to null since that means it is uninitialized
        $this->collConfigsRelatedByIdModificationPartial = null;

        return $this;
    }

    /**
     * reset is the collConfigsRelatedByIdModification collection loaded partially
     *
     * @return void
     */
    public function resetPartialConfigsRelatedByIdModification($v = true)
    {
        $this->collConfigsRelatedByIdModificationPartial = $v;
    }

    /**
     * Initializes the collConfigsRelatedByIdModification collection.
     *
     * By default this just sets the collConfigsRelatedByIdModification collection to an empty array (like clearcollConfigsRelatedByIdModification());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initConfigsRelatedByIdModification($overrideExisting = true)
    {
        if (null !== $this->collConfigsRelatedByIdModification && !$overrideExisting) {
            return;
        }
        $this->collConfigsRelatedByIdModification = new PropelObjectCollection();
        $this->collConfigsRelatedByIdModification->setModel('Config');
    }

    /**
     * Gets an array of Config objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Config[] List of Config objects
     * @throws PropelException
     */
    public function getConfigsRelatedByIdModification($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collConfigsRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collConfigsRelatedByIdModification || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collConfigsRelatedByIdModification) {
                // return empty collection
                $this->initConfigsRelatedByIdModification();
            } else {
                $collConfigsRelatedByIdModification = ConfigQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdModification($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collConfigsRelatedByIdModificationPartial && count($collConfigsRelatedByIdModification)) {
                      $this->initConfigsRelatedByIdModification(false);

                      foreach ($collConfigsRelatedByIdModification as $obj) {
                        if (false == $this->collConfigsRelatedByIdModification->contains($obj)) {
                          $this->collConfigsRelatedByIdModification->append($obj);
                        }
                      }

                      $this->collConfigsRelatedByIdModificationPartial = true;
                    }

                    $collConfigsRelatedByIdModification->getInternalIterator()->rewind();

                    return $collConfigsRelatedByIdModification;
                }

                if ($partial && $this->collConfigsRelatedByIdModification) {
                    foreach ($this->collConfigsRelatedByIdModification as $obj) {
                        if ($obj->isNew()) {
                            $collConfigsRelatedByIdModification[] = $obj;
                        }
                    }
                }

                $this->collConfigsRelatedByIdModification = $collConfigsRelatedByIdModification;
                $this->collConfigsRelatedByIdModificationPartial = false;
            }
        }

        return $this->collConfigsRelatedByIdModification;
    }

    /**
     * Sets a collection of ConfigRelatedByIdModification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $configsRelatedByIdModification A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setConfigsRelatedByIdModification(PropelCollection $configsRelatedByIdModification, PropelPDO $con = null)
    {
        $configsRelatedByIdModificationToDelete = $this->getConfigsRelatedByIdModification(new Criteria(), $con)->diff($configsRelatedByIdModification);


        $this->configsRelatedByIdModificationScheduledForDeletion = $configsRelatedByIdModificationToDelete;

        foreach ($configsRelatedByIdModificationToDelete as $configRelatedByIdModificationRemoved) {
            $configRelatedByIdModificationRemoved->setAuthyRelatedByIdModification(null);
        }

        $this->collConfigsRelatedByIdModification = null;
        foreach ($configsRelatedByIdModification as $configRelatedByIdModification) {
            $this->addConfigRelatedByIdModification($configRelatedByIdModification);
        }

        $this->collConfigsRelatedByIdModification = $configsRelatedByIdModification;
        $this->collConfigsRelatedByIdModificationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Config objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Config objects.
     * @throws PropelException
     */
    public function countConfigsRelatedByIdModification(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collConfigsRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collConfigsRelatedByIdModification || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collConfigsRelatedByIdModification) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getConfigsRelatedByIdModification());
            }
            $query = ConfigQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdModification($this)
                ->count($con);
        }

        return count($this->collConfigsRelatedByIdModification);
    }

    /**
     * Method called to associate a Config object to this object
     * through the Config foreign key attribute.
     *
     * @param    Config $l Config
     * @return Authy The current object (for fluent API support)
     */
    public function addConfigRelatedByIdModification(Config $l)
    {
        if ($this->collConfigsRelatedByIdModification === null) {
            $this->initConfigsRelatedByIdModification();
            $this->collConfigsRelatedByIdModificationPartial = true;
        }

        if (!in_array($l, $this->collConfigsRelatedByIdModification->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddConfigRelatedByIdModification($l);

            if ($this->configsRelatedByIdModificationScheduledForDeletion and $this->configsRelatedByIdModificationScheduledForDeletion->contains($l)) {
                $this->configsRelatedByIdModificationScheduledForDeletion->remove($this->configsRelatedByIdModificationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	ConfigRelatedByIdModification $configRelatedByIdModification The configRelatedByIdModification object to add.
     */
    protected function doAddConfigRelatedByIdModification($configRelatedByIdModification)
    {
        $this->collConfigsRelatedByIdModification[]= $configRelatedByIdModification;
        $configRelatedByIdModification->setAuthyRelatedByIdModification($this);
    }

    /**
     * @param	ConfigRelatedByIdModification $configRelatedByIdModification The configRelatedByIdModification object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeConfigRelatedByIdModification($configRelatedByIdModification)
    {
        if ($this->getConfigsRelatedByIdModification()->contains($configRelatedByIdModification)) {
            $this->collConfigsRelatedByIdModification->remove($this->collConfigsRelatedByIdModification->search($configRelatedByIdModification));
            if (null === $this->configsRelatedByIdModificationScheduledForDeletion) {
                $this->configsRelatedByIdModificationScheduledForDeletion = clone $this->collConfigsRelatedByIdModification;
                $this->configsRelatedByIdModificationScheduledForDeletion->clear();
            }
            $this->configsRelatedByIdModificationScheduledForDeletion[]= $configRelatedByIdModification;
            $configRelatedByIdModification->setAuthyRelatedByIdModification(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Config[] List of Config objects
     */
    public function getConfigsRelatedByIdModificationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ConfigQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getConfigsRelatedByIdModification($query, $con);
    }

    /**
     * Clears out the collApiRbacsRelatedByIdCreation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addApiRbacsRelatedByIdCreation()
     */
    public function clearApiRbacsRelatedByIdCreation()
    {
        $this->collApiRbacsRelatedByIdCreation = null; // important to set this to null since that means it is uninitialized
        $this->collApiRbacsRelatedByIdCreationPartial = null;

        return $this;
    }

    /**
     * reset is the collApiRbacsRelatedByIdCreation collection loaded partially
     *
     * @return void
     */
    public function resetPartialApiRbacsRelatedByIdCreation($v = true)
    {
        $this->collApiRbacsRelatedByIdCreationPartial = $v;
    }

    /**
     * Initializes the collApiRbacsRelatedByIdCreation collection.
     *
     * By default this just sets the collApiRbacsRelatedByIdCreation collection to an empty array (like clearcollApiRbacsRelatedByIdCreation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initApiRbacsRelatedByIdCreation($overrideExisting = true)
    {
        if (null !== $this->collApiRbacsRelatedByIdCreation && !$overrideExisting) {
            return;
        }
        $this->collApiRbacsRelatedByIdCreation = new PropelObjectCollection();
        $this->collApiRbacsRelatedByIdCreation->setModel('ApiRbac');
    }

    /**
     * Gets an array of ApiRbac objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ApiRbac[] List of ApiRbac objects
     * @throws PropelException
     */
    public function getApiRbacsRelatedByIdCreation($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collApiRbacsRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collApiRbacsRelatedByIdCreation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collApiRbacsRelatedByIdCreation) {
                // return empty collection
                $this->initApiRbacsRelatedByIdCreation();
            } else {
                $collApiRbacsRelatedByIdCreation = ApiRbacQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdCreation($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collApiRbacsRelatedByIdCreationPartial && count($collApiRbacsRelatedByIdCreation)) {
                      $this->initApiRbacsRelatedByIdCreation(false);

                      foreach ($collApiRbacsRelatedByIdCreation as $obj) {
                        if (false == $this->collApiRbacsRelatedByIdCreation->contains($obj)) {
                          $this->collApiRbacsRelatedByIdCreation->append($obj);
                        }
                      }

                      $this->collApiRbacsRelatedByIdCreationPartial = true;
                    }

                    $collApiRbacsRelatedByIdCreation->getInternalIterator()->rewind();

                    return $collApiRbacsRelatedByIdCreation;
                }

                if ($partial && $this->collApiRbacsRelatedByIdCreation) {
                    foreach ($this->collApiRbacsRelatedByIdCreation as $obj) {
                        if ($obj->isNew()) {
                            $collApiRbacsRelatedByIdCreation[] = $obj;
                        }
                    }
                }

                $this->collApiRbacsRelatedByIdCreation = $collApiRbacsRelatedByIdCreation;
                $this->collApiRbacsRelatedByIdCreationPartial = false;
            }
        }

        return $this->collApiRbacsRelatedByIdCreation;
    }

    /**
     * Sets a collection of ApiRbacRelatedByIdCreation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $apiRbacsRelatedByIdCreation A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setApiRbacsRelatedByIdCreation(PropelCollection $apiRbacsRelatedByIdCreation, PropelPDO $con = null)
    {
        $apiRbacsRelatedByIdCreationToDelete = $this->getApiRbacsRelatedByIdCreation(new Criteria(), $con)->diff($apiRbacsRelatedByIdCreation);


        $this->apiRbacsRelatedByIdCreationScheduledForDeletion = $apiRbacsRelatedByIdCreationToDelete;

        foreach ($apiRbacsRelatedByIdCreationToDelete as $apiRbacRelatedByIdCreationRemoved) {
            $apiRbacRelatedByIdCreationRemoved->setAuthyRelatedByIdCreation(null);
        }

        $this->collApiRbacsRelatedByIdCreation = null;
        foreach ($apiRbacsRelatedByIdCreation as $apiRbacRelatedByIdCreation) {
            $this->addApiRbacRelatedByIdCreation($apiRbacRelatedByIdCreation);
        }

        $this->collApiRbacsRelatedByIdCreation = $apiRbacsRelatedByIdCreation;
        $this->collApiRbacsRelatedByIdCreationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ApiRbac objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ApiRbac objects.
     * @throws PropelException
     */
    public function countApiRbacsRelatedByIdCreation(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collApiRbacsRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collApiRbacsRelatedByIdCreation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collApiRbacsRelatedByIdCreation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getApiRbacsRelatedByIdCreation());
            }
            $query = ApiRbacQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdCreation($this)
                ->count($con);
        }

        return count($this->collApiRbacsRelatedByIdCreation);
    }

    /**
     * Method called to associate a ApiRbac object to this object
     * through the ApiRbac foreign key attribute.
     *
     * @param    ApiRbac $l ApiRbac
     * @return Authy The current object (for fluent API support)
     */
    public function addApiRbacRelatedByIdCreation(ApiRbac $l)
    {
        if ($this->collApiRbacsRelatedByIdCreation === null) {
            $this->initApiRbacsRelatedByIdCreation();
            $this->collApiRbacsRelatedByIdCreationPartial = true;
        }

        if (!in_array($l, $this->collApiRbacsRelatedByIdCreation->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddApiRbacRelatedByIdCreation($l);

            if ($this->apiRbacsRelatedByIdCreationScheduledForDeletion and $this->apiRbacsRelatedByIdCreationScheduledForDeletion->contains($l)) {
                $this->apiRbacsRelatedByIdCreationScheduledForDeletion->remove($this->apiRbacsRelatedByIdCreationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	ApiRbacRelatedByIdCreation $apiRbacRelatedByIdCreation The apiRbacRelatedByIdCreation object to add.
     */
    protected function doAddApiRbacRelatedByIdCreation($apiRbacRelatedByIdCreation)
    {
        $this->collApiRbacsRelatedByIdCreation[]= $apiRbacRelatedByIdCreation;
        $apiRbacRelatedByIdCreation->setAuthyRelatedByIdCreation($this);
    }

    /**
     * @param	ApiRbacRelatedByIdCreation $apiRbacRelatedByIdCreation The apiRbacRelatedByIdCreation object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeApiRbacRelatedByIdCreation($apiRbacRelatedByIdCreation)
    {
        if ($this->getApiRbacsRelatedByIdCreation()->contains($apiRbacRelatedByIdCreation)) {
            $this->collApiRbacsRelatedByIdCreation->remove($this->collApiRbacsRelatedByIdCreation->search($apiRbacRelatedByIdCreation));
            if (null === $this->apiRbacsRelatedByIdCreationScheduledForDeletion) {
                $this->apiRbacsRelatedByIdCreationScheduledForDeletion = clone $this->collApiRbacsRelatedByIdCreation;
                $this->apiRbacsRelatedByIdCreationScheduledForDeletion->clear();
            }
            $this->apiRbacsRelatedByIdCreationScheduledForDeletion[]= $apiRbacRelatedByIdCreation;
            $apiRbacRelatedByIdCreation->setAuthyRelatedByIdCreation(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ApiRbac[] List of ApiRbac objects
     */
    public function getApiRbacsRelatedByIdCreationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ApiRbacQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getApiRbacsRelatedByIdCreation($query, $con);
    }

    /**
     * Clears out the collApiRbacsRelatedByIdModification collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addApiRbacsRelatedByIdModification()
     */
    public function clearApiRbacsRelatedByIdModification()
    {
        $this->collApiRbacsRelatedByIdModification = null; // important to set this to null since that means it is uninitialized
        $this->collApiRbacsRelatedByIdModificationPartial = null;

        return $this;
    }

    /**
     * reset is the collApiRbacsRelatedByIdModification collection loaded partially
     *
     * @return void
     */
    public function resetPartialApiRbacsRelatedByIdModification($v = true)
    {
        $this->collApiRbacsRelatedByIdModificationPartial = $v;
    }

    /**
     * Initializes the collApiRbacsRelatedByIdModification collection.
     *
     * By default this just sets the collApiRbacsRelatedByIdModification collection to an empty array (like clearcollApiRbacsRelatedByIdModification());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initApiRbacsRelatedByIdModification($overrideExisting = true)
    {
        if (null !== $this->collApiRbacsRelatedByIdModification && !$overrideExisting) {
            return;
        }
        $this->collApiRbacsRelatedByIdModification = new PropelObjectCollection();
        $this->collApiRbacsRelatedByIdModification->setModel('ApiRbac');
    }

    /**
     * Gets an array of ApiRbac objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ApiRbac[] List of ApiRbac objects
     * @throws PropelException
     */
    public function getApiRbacsRelatedByIdModification($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collApiRbacsRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collApiRbacsRelatedByIdModification || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collApiRbacsRelatedByIdModification) {
                // return empty collection
                $this->initApiRbacsRelatedByIdModification();
            } else {
                $collApiRbacsRelatedByIdModification = ApiRbacQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdModification($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collApiRbacsRelatedByIdModificationPartial && count($collApiRbacsRelatedByIdModification)) {
                      $this->initApiRbacsRelatedByIdModification(false);

                      foreach ($collApiRbacsRelatedByIdModification as $obj) {
                        if (false == $this->collApiRbacsRelatedByIdModification->contains($obj)) {
                          $this->collApiRbacsRelatedByIdModification->append($obj);
                        }
                      }

                      $this->collApiRbacsRelatedByIdModificationPartial = true;
                    }

                    $collApiRbacsRelatedByIdModification->getInternalIterator()->rewind();

                    return $collApiRbacsRelatedByIdModification;
                }

                if ($partial && $this->collApiRbacsRelatedByIdModification) {
                    foreach ($this->collApiRbacsRelatedByIdModification as $obj) {
                        if ($obj->isNew()) {
                            $collApiRbacsRelatedByIdModification[] = $obj;
                        }
                    }
                }

                $this->collApiRbacsRelatedByIdModification = $collApiRbacsRelatedByIdModification;
                $this->collApiRbacsRelatedByIdModificationPartial = false;
            }
        }

        return $this->collApiRbacsRelatedByIdModification;
    }

    /**
     * Sets a collection of ApiRbacRelatedByIdModification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $apiRbacsRelatedByIdModification A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setApiRbacsRelatedByIdModification(PropelCollection $apiRbacsRelatedByIdModification, PropelPDO $con = null)
    {
        $apiRbacsRelatedByIdModificationToDelete = $this->getApiRbacsRelatedByIdModification(new Criteria(), $con)->diff($apiRbacsRelatedByIdModification);


        $this->apiRbacsRelatedByIdModificationScheduledForDeletion = $apiRbacsRelatedByIdModificationToDelete;

        foreach ($apiRbacsRelatedByIdModificationToDelete as $apiRbacRelatedByIdModificationRemoved) {
            $apiRbacRelatedByIdModificationRemoved->setAuthyRelatedByIdModification(null);
        }

        $this->collApiRbacsRelatedByIdModification = null;
        foreach ($apiRbacsRelatedByIdModification as $apiRbacRelatedByIdModification) {
            $this->addApiRbacRelatedByIdModification($apiRbacRelatedByIdModification);
        }

        $this->collApiRbacsRelatedByIdModification = $apiRbacsRelatedByIdModification;
        $this->collApiRbacsRelatedByIdModificationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ApiRbac objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ApiRbac objects.
     * @throws PropelException
     */
    public function countApiRbacsRelatedByIdModification(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collApiRbacsRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collApiRbacsRelatedByIdModification || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collApiRbacsRelatedByIdModification) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getApiRbacsRelatedByIdModification());
            }
            $query = ApiRbacQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdModification($this)
                ->count($con);
        }

        return count($this->collApiRbacsRelatedByIdModification);
    }

    /**
     * Method called to associate a ApiRbac object to this object
     * through the ApiRbac foreign key attribute.
     *
     * @param    ApiRbac $l ApiRbac
     * @return Authy The current object (for fluent API support)
     */
    public function addApiRbacRelatedByIdModification(ApiRbac $l)
    {
        if ($this->collApiRbacsRelatedByIdModification === null) {
            $this->initApiRbacsRelatedByIdModification();
            $this->collApiRbacsRelatedByIdModificationPartial = true;
        }

        if (!in_array($l, $this->collApiRbacsRelatedByIdModification->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddApiRbacRelatedByIdModification($l);

            if ($this->apiRbacsRelatedByIdModificationScheduledForDeletion and $this->apiRbacsRelatedByIdModificationScheduledForDeletion->contains($l)) {
                $this->apiRbacsRelatedByIdModificationScheduledForDeletion->remove($this->apiRbacsRelatedByIdModificationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	ApiRbacRelatedByIdModification $apiRbacRelatedByIdModification The apiRbacRelatedByIdModification object to add.
     */
    protected function doAddApiRbacRelatedByIdModification($apiRbacRelatedByIdModification)
    {
        $this->collApiRbacsRelatedByIdModification[]= $apiRbacRelatedByIdModification;
        $apiRbacRelatedByIdModification->setAuthyRelatedByIdModification($this);
    }

    /**
     * @param	ApiRbacRelatedByIdModification $apiRbacRelatedByIdModification The apiRbacRelatedByIdModification object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeApiRbacRelatedByIdModification($apiRbacRelatedByIdModification)
    {
        if ($this->getApiRbacsRelatedByIdModification()->contains($apiRbacRelatedByIdModification)) {
            $this->collApiRbacsRelatedByIdModification->remove($this->collApiRbacsRelatedByIdModification->search($apiRbacRelatedByIdModification));
            if (null === $this->apiRbacsRelatedByIdModificationScheduledForDeletion) {
                $this->apiRbacsRelatedByIdModificationScheduledForDeletion = clone $this->collApiRbacsRelatedByIdModification;
                $this->apiRbacsRelatedByIdModificationScheduledForDeletion->clear();
            }
            $this->apiRbacsRelatedByIdModificationScheduledForDeletion[]= $apiRbacRelatedByIdModification;
            $apiRbacRelatedByIdModification->setAuthyRelatedByIdModification(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ApiRbac[] List of ApiRbac objects
     */
    public function getApiRbacsRelatedByIdModificationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ApiRbacQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getApiRbacsRelatedByIdModification($query, $con);
    }

    /**
     * Clears out the collApiLogs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addApiLogs()
     */
    public function clearApiLogs()
    {
        $this->collApiLogs = null; // important to set this to null since that means it is uninitialized
        $this->collApiLogsPartial = null;

        return $this;
    }

    /**
     * reset is the collApiLogs collection loaded partially
     *
     * @return void
     */
    public function resetPartialApiLogs($v = true)
    {
        $this->collApiLogsPartial = $v;
    }

    /**
     * Initializes the collApiLogs collection.
     *
     * By default this just sets the collApiLogs collection to an empty array (like clearcollApiLogs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initApiLogs($overrideExisting = true)
    {
        if (null !== $this->collApiLogs && !$overrideExisting) {
            return;
        }
        $this->collApiLogs = new PropelObjectCollection();
        $this->collApiLogs->setModel('ApiLog');
    }

    /**
     * Gets an array of ApiLog objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ApiLog[] List of ApiLog objects
     * @throws PropelException
     */
    public function getApiLogs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collApiLogsPartial && !$this->isNew();
        if (null === $this->collApiLogs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collApiLogs) {
                // return empty collection
                $this->initApiLogs();
            } else {
                $collApiLogs = ApiLogQuery::create(null, $criteria)
                    ->filterByAuthy($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collApiLogsPartial && count($collApiLogs)) {
                      $this->initApiLogs(false);

                      foreach ($collApiLogs as $obj) {
                        if (false == $this->collApiLogs->contains($obj)) {
                          $this->collApiLogs->append($obj);
                        }
                      }

                      $this->collApiLogsPartial = true;
                    }

                    $collApiLogs->getInternalIterator()->rewind();

                    return $collApiLogs;
                }

                if ($partial && $this->collApiLogs) {
                    foreach ($this->collApiLogs as $obj) {
                        if ($obj->isNew()) {
                            $collApiLogs[] = $obj;
                        }
                    }
                }

                $this->collApiLogs = $collApiLogs;
                $this->collApiLogsPartial = false;
            }
        }

        return $this->collApiLogs;
    }

    /**
     * Sets a collection of ApiLog objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $apiLogs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setApiLogs(PropelCollection $apiLogs, PropelPDO $con = null)
    {
        $apiLogsToDelete = $this->getApiLogs(new Criteria(), $con)->diff($apiLogs);


        $this->apiLogsScheduledForDeletion = $apiLogsToDelete;

        foreach ($apiLogsToDelete as $apiLogRemoved) {
            $apiLogRemoved->setAuthy(null);
        }

        $this->collApiLogs = null;
        foreach ($apiLogs as $apiLog) {
            $this->addApiLog($apiLog);
        }

        $this->collApiLogs = $apiLogs;
        $this->collApiLogsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ApiLog objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ApiLog objects.
     * @throws PropelException
     */
    public function countApiLogs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collApiLogsPartial && !$this->isNew();
        if (null === $this->collApiLogs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collApiLogs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getApiLogs());
            }
            $query = ApiLogQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthy($this)
                ->count($con);
        }

        return count($this->collApiLogs);
    }

    /**
     * Method called to associate a ApiLog object to this object
     * through the ApiLog foreign key attribute.
     *
     * @param    ApiLog $l ApiLog
     * @return Authy The current object (for fluent API support)
     */
    public function addApiLog(ApiLog $l)
    {
        if ($this->collApiLogs === null) {
            $this->initApiLogs();
            $this->collApiLogsPartial = true;
        }

        if (!in_array($l, $this->collApiLogs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddApiLog($l);

            if ($this->apiLogsScheduledForDeletion and $this->apiLogsScheduledForDeletion->contains($l)) {
                $this->apiLogsScheduledForDeletion->remove($this->apiLogsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	ApiLog $apiLog The apiLog object to add.
     */
    protected function doAddApiLog($apiLog)
    {
        $this->collApiLogs[]= $apiLog;
        $apiLog->setAuthy($this);
    }

    /**
     * @param	ApiLog $apiLog The apiLog object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeApiLog($apiLog)
    {
        if ($this->getApiLogs()->contains($apiLog)) {
            $this->collApiLogs->remove($this->collApiLogs->search($apiLog));
            if (null === $this->apiLogsScheduledForDeletion) {
                $this->apiLogsScheduledForDeletion = clone $this->collApiLogs;
                $this->apiLogsScheduledForDeletion->clear();
            }
            $this->apiLogsScheduledForDeletion[]= $apiLog;
            $apiLog->setAuthy(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ApiLog[] List of ApiLog objects
     */
    public function getApiLogsJoinApiRbac($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ApiLogQuery::create(null, $criteria);
        $query->joinWith('ApiRbac', $join_behavior);

        return $this->getApiLogs($query, $con);
    }

    /**
     * Clears out the collTemplatesRelatedByIdCreation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addTemplatesRelatedByIdCreation()
     */
    public function clearTemplatesRelatedByIdCreation()
    {
        $this->collTemplatesRelatedByIdCreation = null; // important to set this to null since that means it is uninitialized
        $this->collTemplatesRelatedByIdCreationPartial = null;

        return $this;
    }

    /**
     * reset is the collTemplatesRelatedByIdCreation collection loaded partially
     *
     * @return void
     */
    public function resetPartialTemplatesRelatedByIdCreation($v = true)
    {
        $this->collTemplatesRelatedByIdCreationPartial = $v;
    }

    /**
     * Initializes the collTemplatesRelatedByIdCreation collection.
     *
     * By default this just sets the collTemplatesRelatedByIdCreation collection to an empty array (like clearcollTemplatesRelatedByIdCreation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTemplatesRelatedByIdCreation($overrideExisting = true)
    {
        if (null !== $this->collTemplatesRelatedByIdCreation && !$overrideExisting) {
            return;
        }
        $this->collTemplatesRelatedByIdCreation = new PropelObjectCollection();
        $this->collTemplatesRelatedByIdCreation->setModel('Template');
    }

    /**
     * Gets an array of Template objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Template[] List of Template objects
     * @throws PropelException
     */
    public function getTemplatesRelatedByIdCreation($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collTemplatesRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collTemplatesRelatedByIdCreation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTemplatesRelatedByIdCreation) {
                // return empty collection
                $this->initTemplatesRelatedByIdCreation();
            } else {
                $collTemplatesRelatedByIdCreation = TemplateQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdCreation($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collTemplatesRelatedByIdCreationPartial && count($collTemplatesRelatedByIdCreation)) {
                      $this->initTemplatesRelatedByIdCreation(false);

                      foreach ($collTemplatesRelatedByIdCreation as $obj) {
                        if (false == $this->collTemplatesRelatedByIdCreation->contains($obj)) {
                          $this->collTemplatesRelatedByIdCreation->append($obj);
                        }
                      }

                      $this->collTemplatesRelatedByIdCreationPartial = true;
                    }

                    $collTemplatesRelatedByIdCreation->getInternalIterator()->rewind();

                    return $collTemplatesRelatedByIdCreation;
                }

                if ($partial && $this->collTemplatesRelatedByIdCreation) {
                    foreach ($this->collTemplatesRelatedByIdCreation as $obj) {
                        if ($obj->isNew()) {
                            $collTemplatesRelatedByIdCreation[] = $obj;
                        }
                    }
                }

                $this->collTemplatesRelatedByIdCreation = $collTemplatesRelatedByIdCreation;
                $this->collTemplatesRelatedByIdCreationPartial = false;
            }
        }

        return $this->collTemplatesRelatedByIdCreation;
    }

    /**
     * Sets a collection of TemplateRelatedByIdCreation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $templatesRelatedByIdCreation A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setTemplatesRelatedByIdCreation(PropelCollection $templatesRelatedByIdCreation, PropelPDO $con = null)
    {
        $templatesRelatedByIdCreationToDelete = $this->getTemplatesRelatedByIdCreation(new Criteria(), $con)->diff($templatesRelatedByIdCreation);


        $this->templatesRelatedByIdCreationScheduledForDeletion = $templatesRelatedByIdCreationToDelete;

        foreach ($templatesRelatedByIdCreationToDelete as $templateRelatedByIdCreationRemoved) {
            $templateRelatedByIdCreationRemoved->setAuthyRelatedByIdCreation(null);
        }

        $this->collTemplatesRelatedByIdCreation = null;
        foreach ($templatesRelatedByIdCreation as $templateRelatedByIdCreation) {
            $this->addTemplateRelatedByIdCreation($templateRelatedByIdCreation);
        }

        $this->collTemplatesRelatedByIdCreation = $templatesRelatedByIdCreation;
        $this->collTemplatesRelatedByIdCreationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Template objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Template objects.
     * @throws PropelException
     */
    public function countTemplatesRelatedByIdCreation(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collTemplatesRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collTemplatesRelatedByIdCreation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTemplatesRelatedByIdCreation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTemplatesRelatedByIdCreation());
            }
            $query = TemplateQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdCreation($this)
                ->count($con);
        }

        return count($this->collTemplatesRelatedByIdCreation);
    }

    /**
     * Method called to associate a Template object to this object
     * through the Template foreign key attribute.
     *
     * @param    Template $l Template
     * @return Authy The current object (for fluent API support)
     */
    public function addTemplateRelatedByIdCreation(Template $l)
    {
        if ($this->collTemplatesRelatedByIdCreation === null) {
            $this->initTemplatesRelatedByIdCreation();
            $this->collTemplatesRelatedByIdCreationPartial = true;
        }

        if (!in_array($l, $this->collTemplatesRelatedByIdCreation->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddTemplateRelatedByIdCreation($l);

            if ($this->templatesRelatedByIdCreationScheduledForDeletion and $this->templatesRelatedByIdCreationScheduledForDeletion->contains($l)) {
                $this->templatesRelatedByIdCreationScheduledForDeletion->remove($this->templatesRelatedByIdCreationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	TemplateRelatedByIdCreation $templateRelatedByIdCreation The templateRelatedByIdCreation object to add.
     */
    protected function doAddTemplateRelatedByIdCreation($templateRelatedByIdCreation)
    {
        $this->collTemplatesRelatedByIdCreation[]= $templateRelatedByIdCreation;
        $templateRelatedByIdCreation->setAuthyRelatedByIdCreation($this);
    }

    /**
     * @param	TemplateRelatedByIdCreation $templateRelatedByIdCreation The templateRelatedByIdCreation object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeTemplateRelatedByIdCreation($templateRelatedByIdCreation)
    {
        if ($this->getTemplatesRelatedByIdCreation()->contains($templateRelatedByIdCreation)) {
            $this->collTemplatesRelatedByIdCreation->remove($this->collTemplatesRelatedByIdCreation->search($templateRelatedByIdCreation));
            if (null === $this->templatesRelatedByIdCreationScheduledForDeletion) {
                $this->templatesRelatedByIdCreationScheduledForDeletion = clone $this->collTemplatesRelatedByIdCreation;
                $this->templatesRelatedByIdCreationScheduledForDeletion->clear();
            }
            $this->templatesRelatedByIdCreationScheduledForDeletion[]= $templateRelatedByIdCreation;
            $templateRelatedByIdCreation->setAuthyRelatedByIdCreation(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Template[] List of Template objects
     */
    public function getTemplatesRelatedByIdCreationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TemplateQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getTemplatesRelatedByIdCreation($query, $con);
    }

    /**
     * Clears out the collTemplatesRelatedByIdModification collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addTemplatesRelatedByIdModification()
     */
    public function clearTemplatesRelatedByIdModification()
    {
        $this->collTemplatesRelatedByIdModification = null; // important to set this to null since that means it is uninitialized
        $this->collTemplatesRelatedByIdModificationPartial = null;

        return $this;
    }

    /**
     * reset is the collTemplatesRelatedByIdModification collection loaded partially
     *
     * @return void
     */
    public function resetPartialTemplatesRelatedByIdModification($v = true)
    {
        $this->collTemplatesRelatedByIdModificationPartial = $v;
    }

    /**
     * Initializes the collTemplatesRelatedByIdModification collection.
     *
     * By default this just sets the collTemplatesRelatedByIdModification collection to an empty array (like clearcollTemplatesRelatedByIdModification());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTemplatesRelatedByIdModification($overrideExisting = true)
    {
        if (null !== $this->collTemplatesRelatedByIdModification && !$overrideExisting) {
            return;
        }
        $this->collTemplatesRelatedByIdModification = new PropelObjectCollection();
        $this->collTemplatesRelatedByIdModification->setModel('Template');
    }

    /**
     * Gets an array of Template objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Template[] List of Template objects
     * @throws PropelException
     */
    public function getTemplatesRelatedByIdModification($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collTemplatesRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collTemplatesRelatedByIdModification || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTemplatesRelatedByIdModification) {
                // return empty collection
                $this->initTemplatesRelatedByIdModification();
            } else {
                $collTemplatesRelatedByIdModification = TemplateQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdModification($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collTemplatesRelatedByIdModificationPartial && count($collTemplatesRelatedByIdModification)) {
                      $this->initTemplatesRelatedByIdModification(false);

                      foreach ($collTemplatesRelatedByIdModification as $obj) {
                        if (false == $this->collTemplatesRelatedByIdModification->contains($obj)) {
                          $this->collTemplatesRelatedByIdModification->append($obj);
                        }
                      }

                      $this->collTemplatesRelatedByIdModificationPartial = true;
                    }

                    $collTemplatesRelatedByIdModification->getInternalIterator()->rewind();

                    return $collTemplatesRelatedByIdModification;
                }

                if ($partial && $this->collTemplatesRelatedByIdModification) {
                    foreach ($this->collTemplatesRelatedByIdModification as $obj) {
                        if ($obj->isNew()) {
                            $collTemplatesRelatedByIdModification[] = $obj;
                        }
                    }
                }

                $this->collTemplatesRelatedByIdModification = $collTemplatesRelatedByIdModification;
                $this->collTemplatesRelatedByIdModificationPartial = false;
            }
        }

        return $this->collTemplatesRelatedByIdModification;
    }

    /**
     * Sets a collection of TemplateRelatedByIdModification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $templatesRelatedByIdModification A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setTemplatesRelatedByIdModification(PropelCollection $templatesRelatedByIdModification, PropelPDO $con = null)
    {
        $templatesRelatedByIdModificationToDelete = $this->getTemplatesRelatedByIdModification(new Criteria(), $con)->diff($templatesRelatedByIdModification);


        $this->templatesRelatedByIdModificationScheduledForDeletion = $templatesRelatedByIdModificationToDelete;

        foreach ($templatesRelatedByIdModificationToDelete as $templateRelatedByIdModificationRemoved) {
            $templateRelatedByIdModificationRemoved->setAuthyRelatedByIdModification(null);
        }

        $this->collTemplatesRelatedByIdModification = null;
        foreach ($templatesRelatedByIdModification as $templateRelatedByIdModification) {
            $this->addTemplateRelatedByIdModification($templateRelatedByIdModification);
        }

        $this->collTemplatesRelatedByIdModification = $templatesRelatedByIdModification;
        $this->collTemplatesRelatedByIdModificationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Template objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Template objects.
     * @throws PropelException
     */
    public function countTemplatesRelatedByIdModification(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collTemplatesRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collTemplatesRelatedByIdModification || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTemplatesRelatedByIdModification) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTemplatesRelatedByIdModification());
            }
            $query = TemplateQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdModification($this)
                ->count($con);
        }

        return count($this->collTemplatesRelatedByIdModification);
    }

    /**
     * Method called to associate a Template object to this object
     * through the Template foreign key attribute.
     *
     * @param    Template $l Template
     * @return Authy The current object (for fluent API support)
     */
    public function addTemplateRelatedByIdModification(Template $l)
    {
        if ($this->collTemplatesRelatedByIdModification === null) {
            $this->initTemplatesRelatedByIdModification();
            $this->collTemplatesRelatedByIdModificationPartial = true;
        }

        if (!in_array($l, $this->collTemplatesRelatedByIdModification->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddTemplateRelatedByIdModification($l);

            if ($this->templatesRelatedByIdModificationScheduledForDeletion and $this->templatesRelatedByIdModificationScheduledForDeletion->contains($l)) {
                $this->templatesRelatedByIdModificationScheduledForDeletion->remove($this->templatesRelatedByIdModificationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	TemplateRelatedByIdModification $templateRelatedByIdModification The templateRelatedByIdModification object to add.
     */
    protected function doAddTemplateRelatedByIdModification($templateRelatedByIdModification)
    {
        $this->collTemplatesRelatedByIdModification[]= $templateRelatedByIdModification;
        $templateRelatedByIdModification->setAuthyRelatedByIdModification($this);
    }

    /**
     * @param	TemplateRelatedByIdModification $templateRelatedByIdModification The templateRelatedByIdModification object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeTemplateRelatedByIdModification($templateRelatedByIdModification)
    {
        if ($this->getTemplatesRelatedByIdModification()->contains($templateRelatedByIdModification)) {
            $this->collTemplatesRelatedByIdModification->remove($this->collTemplatesRelatedByIdModification->search($templateRelatedByIdModification));
            if (null === $this->templatesRelatedByIdModificationScheduledForDeletion) {
                $this->templatesRelatedByIdModificationScheduledForDeletion = clone $this->collTemplatesRelatedByIdModification;
                $this->templatesRelatedByIdModificationScheduledForDeletion->clear();
            }
            $this->templatesRelatedByIdModificationScheduledForDeletion[]= $templateRelatedByIdModification;
            $templateRelatedByIdModification->setAuthyRelatedByIdModification(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Template[] List of Template objects
     */
    public function getTemplatesRelatedByIdModificationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TemplateQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getTemplatesRelatedByIdModification($query, $con);
    }

    /**
     * Clears out the collTemplateFilesRelatedByIdCreation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addTemplateFilesRelatedByIdCreation()
     */
    public function clearTemplateFilesRelatedByIdCreation()
    {
        $this->collTemplateFilesRelatedByIdCreation = null; // important to set this to null since that means it is uninitialized
        $this->collTemplateFilesRelatedByIdCreationPartial = null;

        return $this;
    }

    /**
     * reset is the collTemplateFilesRelatedByIdCreation collection loaded partially
     *
     * @return void
     */
    public function resetPartialTemplateFilesRelatedByIdCreation($v = true)
    {
        $this->collTemplateFilesRelatedByIdCreationPartial = $v;
    }

    /**
     * Initializes the collTemplateFilesRelatedByIdCreation collection.
     *
     * By default this just sets the collTemplateFilesRelatedByIdCreation collection to an empty array (like clearcollTemplateFilesRelatedByIdCreation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTemplateFilesRelatedByIdCreation($overrideExisting = true)
    {
        if (null !== $this->collTemplateFilesRelatedByIdCreation && !$overrideExisting) {
            return;
        }
        $this->collTemplateFilesRelatedByIdCreation = new PropelObjectCollection();
        $this->collTemplateFilesRelatedByIdCreation->setModel('TemplateFile');
    }

    /**
     * Gets an array of TemplateFile objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|TemplateFile[] List of TemplateFile objects
     * @throws PropelException
     */
    public function getTemplateFilesRelatedByIdCreation($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collTemplateFilesRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collTemplateFilesRelatedByIdCreation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTemplateFilesRelatedByIdCreation) {
                // return empty collection
                $this->initTemplateFilesRelatedByIdCreation();
            } else {
                $collTemplateFilesRelatedByIdCreation = TemplateFileQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdCreation($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collTemplateFilesRelatedByIdCreationPartial && count($collTemplateFilesRelatedByIdCreation)) {
                      $this->initTemplateFilesRelatedByIdCreation(false);

                      foreach ($collTemplateFilesRelatedByIdCreation as $obj) {
                        if (false == $this->collTemplateFilesRelatedByIdCreation->contains($obj)) {
                          $this->collTemplateFilesRelatedByIdCreation->append($obj);
                        }
                      }

                      $this->collTemplateFilesRelatedByIdCreationPartial = true;
                    }

                    $collTemplateFilesRelatedByIdCreation->getInternalIterator()->rewind();

                    return $collTemplateFilesRelatedByIdCreation;
                }

                if ($partial && $this->collTemplateFilesRelatedByIdCreation) {
                    foreach ($this->collTemplateFilesRelatedByIdCreation as $obj) {
                        if ($obj->isNew()) {
                            $collTemplateFilesRelatedByIdCreation[] = $obj;
                        }
                    }
                }

                $this->collTemplateFilesRelatedByIdCreation = $collTemplateFilesRelatedByIdCreation;
                $this->collTemplateFilesRelatedByIdCreationPartial = false;
            }
        }

        return $this->collTemplateFilesRelatedByIdCreation;
    }

    /**
     * Sets a collection of TemplateFileRelatedByIdCreation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $templateFilesRelatedByIdCreation A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setTemplateFilesRelatedByIdCreation(PropelCollection $templateFilesRelatedByIdCreation, PropelPDO $con = null)
    {
        $templateFilesRelatedByIdCreationToDelete = $this->getTemplateFilesRelatedByIdCreation(new Criteria(), $con)->diff($templateFilesRelatedByIdCreation);


        $this->templateFilesRelatedByIdCreationScheduledForDeletion = $templateFilesRelatedByIdCreationToDelete;

        foreach ($templateFilesRelatedByIdCreationToDelete as $templateFileRelatedByIdCreationRemoved) {
            $templateFileRelatedByIdCreationRemoved->setAuthyRelatedByIdCreation(null);
        }

        $this->collTemplateFilesRelatedByIdCreation = null;
        foreach ($templateFilesRelatedByIdCreation as $templateFileRelatedByIdCreation) {
            $this->addTemplateFileRelatedByIdCreation($templateFileRelatedByIdCreation);
        }

        $this->collTemplateFilesRelatedByIdCreation = $templateFilesRelatedByIdCreation;
        $this->collTemplateFilesRelatedByIdCreationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TemplateFile objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related TemplateFile objects.
     * @throws PropelException
     */
    public function countTemplateFilesRelatedByIdCreation(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collTemplateFilesRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collTemplateFilesRelatedByIdCreation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTemplateFilesRelatedByIdCreation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTemplateFilesRelatedByIdCreation());
            }
            $query = TemplateFileQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdCreation($this)
                ->count($con);
        }

        return count($this->collTemplateFilesRelatedByIdCreation);
    }

    /**
     * Method called to associate a TemplateFile object to this object
     * through the TemplateFile foreign key attribute.
     *
     * @param    TemplateFile $l TemplateFile
     * @return Authy The current object (for fluent API support)
     */
    public function addTemplateFileRelatedByIdCreation(TemplateFile $l)
    {
        if ($this->collTemplateFilesRelatedByIdCreation === null) {
            $this->initTemplateFilesRelatedByIdCreation();
            $this->collTemplateFilesRelatedByIdCreationPartial = true;
        }

        if (!in_array($l, $this->collTemplateFilesRelatedByIdCreation->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddTemplateFileRelatedByIdCreation($l);

            if ($this->templateFilesRelatedByIdCreationScheduledForDeletion and $this->templateFilesRelatedByIdCreationScheduledForDeletion->contains($l)) {
                $this->templateFilesRelatedByIdCreationScheduledForDeletion->remove($this->templateFilesRelatedByIdCreationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	TemplateFileRelatedByIdCreation $templateFileRelatedByIdCreation The templateFileRelatedByIdCreation object to add.
     */
    protected function doAddTemplateFileRelatedByIdCreation($templateFileRelatedByIdCreation)
    {
        $this->collTemplateFilesRelatedByIdCreation[]= $templateFileRelatedByIdCreation;
        $templateFileRelatedByIdCreation->setAuthyRelatedByIdCreation($this);
    }

    /**
     * @param	TemplateFileRelatedByIdCreation $templateFileRelatedByIdCreation The templateFileRelatedByIdCreation object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeTemplateFileRelatedByIdCreation($templateFileRelatedByIdCreation)
    {
        if ($this->getTemplateFilesRelatedByIdCreation()->contains($templateFileRelatedByIdCreation)) {
            $this->collTemplateFilesRelatedByIdCreation->remove($this->collTemplateFilesRelatedByIdCreation->search($templateFileRelatedByIdCreation));
            if (null === $this->templateFilesRelatedByIdCreationScheduledForDeletion) {
                $this->templateFilesRelatedByIdCreationScheduledForDeletion = clone $this->collTemplateFilesRelatedByIdCreation;
                $this->templateFilesRelatedByIdCreationScheduledForDeletion->clear();
            }
            $this->templateFilesRelatedByIdCreationScheduledForDeletion[]= $templateFileRelatedByIdCreation;
            $templateFileRelatedByIdCreation->setAuthyRelatedByIdCreation(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|TemplateFile[] List of TemplateFile objects
     */
    public function getTemplateFilesRelatedByIdCreationJoinTemplate($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TemplateFileQuery::create(null, $criteria);
        $query->joinWith('Template', $join_behavior);

        return $this->getTemplateFilesRelatedByIdCreation($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|TemplateFile[] List of TemplateFile objects
     */
    public function getTemplateFilesRelatedByIdCreationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TemplateFileQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getTemplateFilesRelatedByIdCreation($query, $con);
    }

    /**
     * Clears out the collTemplateFilesRelatedByIdModification collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addTemplateFilesRelatedByIdModification()
     */
    public function clearTemplateFilesRelatedByIdModification()
    {
        $this->collTemplateFilesRelatedByIdModification = null; // important to set this to null since that means it is uninitialized
        $this->collTemplateFilesRelatedByIdModificationPartial = null;

        return $this;
    }

    /**
     * reset is the collTemplateFilesRelatedByIdModification collection loaded partially
     *
     * @return void
     */
    public function resetPartialTemplateFilesRelatedByIdModification($v = true)
    {
        $this->collTemplateFilesRelatedByIdModificationPartial = $v;
    }

    /**
     * Initializes the collTemplateFilesRelatedByIdModification collection.
     *
     * By default this just sets the collTemplateFilesRelatedByIdModification collection to an empty array (like clearcollTemplateFilesRelatedByIdModification());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTemplateFilesRelatedByIdModification($overrideExisting = true)
    {
        if (null !== $this->collTemplateFilesRelatedByIdModification && !$overrideExisting) {
            return;
        }
        $this->collTemplateFilesRelatedByIdModification = new PropelObjectCollection();
        $this->collTemplateFilesRelatedByIdModification->setModel('TemplateFile');
    }

    /**
     * Gets an array of TemplateFile objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|TemplateFile[] List of TemplateFile objects
     * @throws PropelException
     */
    public function getTemplateFilesRelatedByIdModification($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collTemplateFilesRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collTemplateFilesRelatedByIdModification || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTemplateFilesRelatedByIdModification) {
                // return empty collection
                $this->initTemplateFilesRelatedByIdModification();
            } else {
                $collTemplateFilesRelatedByIdModification = TemplateFileQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdModification($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collTemplateFilesRelatedByIdModificationPartial && count($collTemplateFilesRelatedByIdModification)) {
                      $this->initTemplateFilesRelatedByIdModification(false);

                      foreach ($collTemplateFilesRelatedByIdModification as $obj) {
                        if (false == $this->collTemplateFilesRelatedByIdModification->contains($obj)) {
                          $this->collTemplateFilesRelatedByIdModification->append($obj);
                        }
                      }

                      $this->collTemplateFilesRelatedByIdModificationPartial = true;
                    }

                    $collTemplateFilesRelatedByIdModification->getInternalIterator()->rewind();

                    return $collTemplateFilesRelatedByIdModification;
                }

                if ($partial && $this->collTemplateFilesRelatedByIdModification) {
                    foreach ($this->collTemplateFilesRelatedByIdModification as $obj) {
                        if ($obj->isNew()) {
                            $collTemplateFilesRelatedByIdModification[] = $obj;
                        }
                    }
                }

                $this->collTemplateFilesRelatedByIdModification = $collTemplateFilesRelatedByIdModification;
                $this->collTemplateFilesRelatedByIdModificationPartial = false;
            }
        }

        return $this->collTemplateFilesRelatedByIdModification;
    }

    /**
     * Sets a collection of TemplateFileRelatedByIdModification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $templateFilesRelatedByIdModification A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setTemplateFilesRelatedByIdModification(PropelCollection $templateFilesRelatedByIdModification, PropelPDO $con = null)
    {
        $templateFilesRelatedByIdModificationToDelete = $this->getTemplateFilesRelatedByIdModification(new Criteria(), $con)->diff($templateFilesRelatedByIdModification);


        $this->templateFilesRelatedByIdModificationScheduledForDeletion = $templateFilesRelatedByIdModificationToDelete;

        foreach ($templateFilesRelatedByIdModificationToDelete as $templateFileRelatedByIdModificationRemoved) {
            $templateFileRelatedByIdModificationRemoved->setAuthyRelatedByIdModification(null);
        }

        $this->collTemplateFilesRelatedByIdModification = null;
        foreach ($templateFilesRelatedByIdModification as $templateFileRelatedByIdModification) {
            $this->addTemplateFileRelatedByIdModification($templateFileRelatedByIdModification);
        }

        $this->collTemplateFilesRelatedByIdModification = $templateFilesRelatedByIdModification;
        $this->collTemplateFilesRelatedByIdModificationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TemplateFile objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related TemplateFile objects.
     * @throws PropelException
     */
    public function countTemplateFilesRelatedByIdModification(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collTemplateFilesRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collTemplateFilesRelatedByIdModification || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTemplateFilesRelatedByIdModification) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTemplateFilesRelatedByIdModification());
            }
            $query = TemplateFileQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdModification($this)
                ->count($con);
        }

        return count($this->collTemplateFilesRelatedByIdModification);
    }

    /**
     * Method called to associate a TemplateFile object to this object
     * through the TemplateFile foreign key attribute.
     *
     * @param    TemplateFile $l TemplateFile
     * @return Authy The current object (for fluent API support)
     */
    public function addTemplateFileRelatedByIdModification(TemplateFile $l)
    {
        if ($this->collTemplateFilesRelatedByIdModification === null) {
            $this->initTemplateFilesRelatedByIdModification();
            $this->collTemplateFilesRelatedByIdModificationPartial = true;
        }

        if (!in_array($l, $this->collTemplateFilesRelatedByIdModification->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddTemplateFileRelatedByIdModification($l);

            if ($this->templateFilesRelatedByIdModificationScheduledForDeletion and $this->templateFilesRelatedByIdModificationScheduledForDeletion->contains($l)) {
                $this->templateFilesRelatedByIdModificationScheduledForDeletion->remove($this->templateFilesRelatedByIdModificationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	TemplateFileRelatedByIdModification $templateFileRelatedByIdModification The templateFileRelatedByIdModification object to add.
     */
    protected function doAddTemplateFileRelatedByIdModification($templateFileRelatedByIdModification)
    {
        $this->collTemplateFilesRelatedByIdModification[]= $templateFileRelatedByIdModification;
        $templateFileRelatedByIdModification->setAuthyRelatedByIdModification($this);
    }

    /**
     * @param	TemplateFileRelatedByIdModification $templateFileRelatedByIdModification The templateFileRelatedByIdModification object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeTemplateFileRelatedByIdModification($templateFileRelatedByIdModification)
    {
        if ($this->getTemplateFilesRelatedByIdModification()->contains($templateFileRelatedByIdModification)) {
            $this->collTemplateFilesRelatedByIdModification->remove($this->collTemplateFilesRelatedByIdModification->search($templateFileRelatedByIdModification));
            if (null === $this->templateFilesRelatedByIdModificationScheduledForDeletion) {
                $this->templateFilesRelatedByIdModificationScheduledForDeletion = clone $this->collTemplateFilesRelatedByIdModification;
                $this->templateFilesRelatedByIdModificationScheduledForDeletion->clear();
            }
            $this->templateFilesRelatedByIdModificationScheduledForDeletion[]= $templateFileRelatedByIdModification;
            $templateFileRelatedByIdModification->setAuthyRelatedByIdModification(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|TemplateFile[] List of TemplateFile objects
     */
    public function getTemplateFilesRelatedByIdModificationJoinTemplate($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TemplateFileQuery::create(null, $criteria);
        $query->joinWith('Template', $join_behavior);

        return $this->getTemplateFilesRelatedByIdModification($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|TemplateFile[] List of TemplateFile objects
     */
    public function getTemplateFilesRelatedByIdModificationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TemplateFileQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getTemplateFilesRelatedByIdModification($query, $con);
    }

    /**
     * Clears out the collMessageI18nsRelatedByIdCreation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addMessageI18nsRelatedByIdCreation()
     */
    public function clearMessageI18nsRelatedByIdCreation()
    {
        $this->collMessageI18nsRelatedByIdCreation = null; // important to set this to null since that means it is uninitialized
        $this->collMessageI18nsRelatedByIdCreationPartial = null;

        return $this;
    }

    /**
     * reset is the collMessageI18nsRelatedByIdCreation collection loaded partially
     *
     * @return void
     */
    public function resetPartialMessageI18nsRelatedByIdCreation($v = true)
    {
        $this->collMessageI18nsRelatedByIdCreationPartial = $v;
    }

    /**
     * Initializes the collMessageI18nsRelatedByIdCreation collection.
     *
     * By default this just sets the collMessageI18nsRelatedByIdCreation collection to an empty array (like clearcollMessageI18nsRelatedByIdCreation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMessageI18nsRelatedByIdCreation($overrideExisting = true)
    {
        if (null !== $this->collMessageI18nsRelatedByIdCreation && !$overrideExisting) {
            return;
        }
        $this->collMessageI18nsRelatedByIdCreation = new PropelObjectCollection();
        $this->collMessageI18nsRelatedByIdCreation->setModel('MessageI18n');
    }

    /**
     * Gets an array of MessageI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|MessageI18n[] List of MessageI18n objects
     * @throws PropelException
     */
    public function getMessageI18nsRelatedByIdCreation($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collMessageI18nsRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collMessageI18nsRelatedByIdCreation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMessageI18nsRelatedByIdCreation) {
                // return empty collection
                $this->initMessageI18nsRelatedByIdCreation();
            } else {
                $collMessageI18nsRelatedByIdCreation = MessageI18nQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdCreation($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collMessageI18nsRelatedByIdCreationPartial && count($collMessageI18nsRelatedByIdCreation)) {
                      $this->initMessageI18nsRelatedByIdCreation(false);

                      foreach ($collMessageI18nsRelatedByIdCreation as $obj) {
                        if (false == $this->collMessageI18nsRelatedByIdCreation->contains($obj)) {
                          $this->collMessageI18nsRelatedByIdCreation->append($obj);
                        }
                      }

                      $this->collMessageI18nsRelatedByIdCreationPartial = true;
                    }

                    $collMessageI18nsRelatedByIdCreation->getInternalIterator()->rewind();

                    return $collMessageI18nsRelatedByIdCreation;
                }

                if ($partial && $this->collMessageI18nsRelatedByIdCreation) {
                    foreach ($this->collMessageI18nsRelatedByIdCreation as $obj) {
                        if ($obj->isNew()) {
                            $collMessageI18nsRelatedByIdCreation[] = $obj;
                        }
                    }
                }

                $this->collMessageI18nsRelatedByIdCreation = $collMessageI18nsRelatedByIdCreation;
                $this->collMessageI18nsRelatedByIdCreationPartial = false;
            }
        }

        return $this->collMessageI18nsRelatedByIdCreation;
    }

    /**
     * Sets a collection of MessageI18nRelatedByIdCreation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $messageI18nsRelatedByIdCreation A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setMessageI18nsRelatedByIdCreation(PropelCollection $messageI18nsRelatedByIdCreation, PropelPDO $con = null)
    {
        $messageI18nsRelatedByIdCreationToDelete = $this->getMessageI18nsRelatedByIdCreation(new Criteria(), $con)->diff($messageI18nsRelatedByIdCreation);


        $this->messageI18nsRelatedByIdCreationScheduledForDeletion = $messageI18nsRelatedByIdCreationToDelete;

        foreach ($messageI18nsRelatedByIdCreationToDelete as $messageI18nRelatedByIdCreationRemoved) {
            $messageI18nRelatedByIdCreationRemoved->setAuthyRelatedByIdCreation(null);
        }

        $this->collMessageI18nsRelatedByIdCreation = null;
        foreach ($messageI18nsRelatedByIdCreation as $messageI18nRelatedByIdCreation) {
            $this->addMessageI18nRelatedByIdCreation($messageI18nRelatedByIdCreation);
        }

        $this->collMessageI18nsRelatedByIdCreation = $messageI18nsRelatedByIdCreation;
        $this->collMessageI18nsRelatedByIdCreationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MessageI18n objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related MessageI18n objects.
     * @throws PropelException
     */
    public function countMessageI18nsRelatedByIdCreation(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collMessageI18nsRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collMessageI18nsRelatedByIdCreation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMessageI18nsRelatedByIdCreation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMessageI18nsRelatedByIdCreation());
            }
            $query = MessageI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdCreation($this)
                ->count($con);
        }

        return count($this->collMessageI18nsRelatedByIdCreation);
    }

    /**
     * Method called to associate a MessageI18n object to this object
     * through the MessageI18n foreign key attribute.
     *
     * @param    MessageI18n $l MessageI18n
     * @return Authy The current object (for fluent API support)
     */
    public function addMessageI18nRelatedByIdCreation(MessageI18n $l)
    {
        if ($this->collMessageI18nsRelatedByIdCreation === null) {
            $this->initMessageI18nsRelatedByIdCreation();
            $this->collMessageI18nsRelatedByIdCreationPartial = true;
        }

        if (!in_array($l, $this->collMessageI18nsRelatedByIdCreation->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddMessageI18nRelatedByIdCreation($l);

            if ($this->messageI18nsRelatedByIdCreationScheduledForDeletion and $this->messageI18nsRelatedByIdCreationScheduledForDeletion->contains($l)) {
                $this->messageI18nsRelatedByIdCreationScheduledForDeletion->remove($this->messageI18nsRelatedByIdCreationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	MessageI18nRelatedByIdCreation $messageI18nRelatedByIdCreation The messageI18nRelatedByIdCreation object to add.
     */
    protected function doAddMessageI18nRelatedByIdCreation($messageI18nRelatedByIdCreation)
    {
        $this->collMessageI18nsRelatedByIdCreation[]= $messageI18nRelatedByIdCreation;
        $messageI18nRelatedByIdCreation->setAuthyRelatedByIdCreation($this);
    }

    /**
     * @param	MessageI18nRelatedByIdCreation $messageI18nRelatedByIdCreation The messageI18nRelatedByIdCreation object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeMessageI18nRelatedByIdCreation($messageI18nRelatedByIdCreation)
    {
        if ($this->getMessageI18nsRelatedByIdCreation()->contains($messageI18nRelatedByIdCreation)) {
            $this->collMessageI18nsRelatedByIdCreation->remove($this->collMessageI18nsRelatedByIdCreation->search($messageI18nRelatedByIdCreation));
            if (null === $this->messageI18nsRelatedByIdCreationScheduledForDeletion) {
                $this->messageI18nsRelatedByIdCreationScheduledForDeletion = clone $this->collMessageI18nsRelatedByIdCreation;
                $this->messageI18nsRelatedByIdCreationScheduledForDeletion->clear();
            }
            $this->messageI18nsRelatedByIdCreationScheduledForDeletion[]= $messageI18nRelatedByIdCreation;
            $messageI18nRelatedByIdCreation->setAuthyRelatedByIdCreation(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|MessageI18n[] List of MessageI18n objects
     */
    public function getMessageI18nsRelatedByIdCreationJoinMessage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = MessageI18nQuery::create(null, $criteria);
        $query->joinWith('Message', $join_behavior);

        return $this->getMessageI18nsRelatedByIdCreation($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|MessageI18n[] List of MessageI18n objects
     */
    public function getMessageI18nsRelatedByIdCreationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = MessageI18nQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getMessageI18nsRelatedByIdCreation($query, $con);
    }

    /**
     * Clears out the collMessageI18nsRelatedByIdModification collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addMessageI18nsRelatedByIdModification()
     */
    public function clearMessageI18nsRelatedByIdModification()
    {
        $this->collMessageI18nsRelatedByIdModification = null; // important to set this to null since that means it is uninitialized
        $this->collMessageI18nsRelatedByIdModificationPartial = null;

        return $this;
    }

    /**
     * reset is the collMessageI18nsRelatedByIdModification collection loaded partially
     *
     * @return void
     */
    public function resetPartialMessageI18nsRelatedByIdModification($v = true)
    {
        $this->collMessageI18nsRelatedByIdModificationPartial = $v;
    }

    /**
     * Initializes the collMessageI18nsRelatedByIdModification collection.
     *
     * By default this just sets the collMessageI18nsRelatedByIdModification collection to an empty array (like clearcollMessageI18nsRelatedByIdModification());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMessageI18nsRelatedByIdModification($overrideExisting = true)
    {
        if (null !== $this->collMessageI18nsRelatedByIdModification && !$overrideExisting) {
            return;
        }
        $this->collMessageI18nsRelatedByIdModification = new PropelObjectCollection();
        $this->collMessageI18nsRelatedByIdModification->setModel('MessageI18n');
    }

    /**
     * Gets an array of MessageI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|MessageI18n[] List of MessageI18n objects
     * @throws PropelException
     */
    public function getMessageI18nsRelatedByIdModification($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collMessageI18nsRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collMessageI18nsRelatedByIdModification || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMessageI18nsRelatedByIdModification) {
                // return empty collection
                $this->initMessageI18nsRelatedByIdModification();
            } else {
                $collMessageI18nsRelatedByIdModification = MessageI18nQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdModification($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collMessageI18nsRelatedByIdModificationPartial && count($collMessageI18nsRelatedByIdModification)) {
                      $this->initMessageI18nsRelatedByIdModification(false);

                      foreach ($collMessageI18nsRelatedByIdModification as $obj) {
                        if (false == $this->collMessageI18nsRelatedByIdModification->contains($obj)) {
                          $this->collMessageI18nsRelatedByIdModification->append($obj);
                        }
                      }

                      $this->collMessageI18nsRelatedByIdModificationPartial = true;
                    }

                    $collMessageI18nsRelatedByIdModification->getInternalIterator()->rewind();

                    return $collMessageI18nsRelatedByIdModification;
                }

                if ($partial && $this->collMessageI18nsRelatedByIdModification) {
                    foreach ($this->collMessageI18nsRelatedByIdModification as $obj) {
                        if ($obj->isNew()) {
                            $collMessageI18nsRelatedByIdModification[] = $obj;
                        }
                    }
                }

                $this->collMessageI18nsRelatedByIdModification = $collMessageI18nsRelatedByIdModification;
                $this->collMessageI18nsRelatedByIdModificationPartial = false;
            }
        }

        return $this->collMessageI18nsRelatedByIdModification;
    }

    /**
     * Sets a collection of MessageI18nRelatedByIdModification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $messageI18nsRelatedByIdModification A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setMessageI18nsRelatedByIdModification(PropelCollection $messageI18nsRelatedByIdModification, PropelPDO $con = null)
    {
        $messageI18nsRelatedByIdModificationToDelete = $this->getMessageI18nsRelatedByIdModification(new Criteria(), $con)->diff($messageI18nsRelatedByIdModification);


        $this->messageI18nsRelatedByIdModificationScheduledForDeletion = $messageI18nsRelatedByIdModificationToDelete;

        foreach ($messageI18nsRelatedByIdModificationToDelete as $messageI18nRelatedByIdModificationRemoved) {
            $messageI18nRelatedByIdModificationRemoved->setAuthyRelatedByIdModification(null);
        }

        $this->collMessageI18nsRelatedByIdModification = null;
        foreach ($messageI18nsRelatedByIdModification as $messageI18nRelatedByIdModification) {
            $this->addMessageI18nRelatedByIdModification($messageI18nRelatedByIdModification);
        }

        $this->collMessageI18nsRelatedByIdModification = $messageI18nsRelatedByIdModification;
        $this->collMessageI18nsRelatedByIdModificationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MessageI18n objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related MessageI18n objects.
     * @throws PropelException
     */
    public function countMessageI18nsRelatedByIdModification(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collMessageI18nsRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collMessageI18nsRelatedByIdModification || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMessageI18nsRelatedByIdModification) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMessageI18nsRelatedByIdModification());
            }
            $query = MessageI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdModification($this)
                ->count($con);
        }

        return count($this->collMessageI18nsRelatedByIdModification);
    }

    /**
     * Method called to associate a MessageI18n object to this object
     * through the MessageI18n foreign key attribute.
     *
     * @param    MessageI18n $l MessageI18n
     * @return Authy The current object (for fluent API support)
     */
    public function addMessageI18nRelatedByIdModification(MessageI18n $l)
    {
        if ($this->collMessageI18nsRelatedByIdModification === null) {
            $this->initMessageI18nsRelatedByIdModification();
            $this->collMessageI18nsRelatedByIdModificationPartial = true;
        }

        if (!in_array($l, $this->collMessageI18nsRelatedByIdModification->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddMessageI18nRelatedByIdModification($l);

            if ($this->messageI18nsRelatedByIdModificationScheduledForDeletion and $this->messageI18nsRelatedByIdModificationScheduledForDeletion->contains($l)) {
                $this->messageI18nsRelatedByIdModificationScheduledForDeletion->remove($this->messageI18nsRelatedByIdModificationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	MessageI18nRelatedByIdModification $messageI18nRelatedByIdModification The messageI18nRelatedByIdModification object to add.
     */
    protected function doAddMessageI18nRelatedByIdModification($messageI18nRelatedByIdModification)
    {
        $this->collMessageI18nsRelatedByIdModification[]= $messageI18nRelatedByIdModification;
        $messageI18nRelatedByIdModification->setAuthyRelatedByIdModification($this);
    }

    /**
     * @param	MessageI18nRelatedByIdModification $messageI18nRelatedByIdModification The messageI18nRelatedByIdModification object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeMessageI18nRelatedByIdModification($messageI18nRelatedByIdModification)
    {
        if ($this->getMessageI18nsRelatedByIdModification()->contains($messageI18nRelatedByIdModification)) {
            $this->collMessageI18nsRelatedByIdModification->remove($this->collMessageI18nsRelatedByIdModification->search($messageI18nRelatedByIdModification));
            if (null === $this->messageI18nsRelatedByIdModificationScheduledForDeletion) {
                $this->messageI18nsRelatedByIdModificationScheduledForDeletion = clone $this->collMessageI18nsRelatedByIdModification;
                $this->messageI18nsRelatedByIdModificationScheduledForDeletion->clear();
            }
            $this->messageI18nsRelatedByIdModificationScheduledForDeletion[]= $messageI18nRelatedByIdModification;
            $messageI18nRelatedByIdModification->setAuthyRelatedByIdModification(null);
        }

        return $this;
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|MessageI18n[] List of MessageI18n objects
     */
    public function getMessageI18nsRelatedByIdModificationJoinMessage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = MessageI18nQuery::create(null, $criteria);
        $query->joinWith('Message', $join_behavior);

        return $this->getMessageI18nsRelatedByIdModification($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|MessageI18n[] List of MessageI18n objects
     */
    public function getMessageI18nsRelatedByIdModificationJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = MessageI18nQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getMessageI18nsRelatedByIdModification($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_authy = null;
        $this->validation_key = null;
        $this->username = null;
        $this->fullname = null;
        $this->email = null;
        $this->passwd_hash = null;
        $this->expire = null;
        $this->deactivate = null;
        $this->is_root = null;
        $this->id_authy_group = null;
        $this->is_system = null;
        $this->rights_all = null;
        $this->rights_group = null;
        $this->rights_owner = null;
        $this->onglet = null;
        $this->date_creation = null;
        $this->date_modification = null;
        $this->id_group_creation = null;
        $this->id_creation = null;
        $this->id_modification = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collAuthyGroupxes) {
                foreach ($this->collAuthyGroupxes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAuthyLogs) {
                foreach ($this->collAuthyLogs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAuthiesRelatedByIdAuthy0) {
                foreach ($this->collAuthiesRelatedByIdAuthy0 as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAuthiesRelatedByIdAuthy1) {
                foreach ($this->collAuthiesRelatedByIdAuthy1 as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCountriesRelatedByIdCreation) {
                foreach ($this->collCountriesRelatedByIdCreation as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCountriesRelatedByIdModification) {
                foreach ($this->collCountriesRelatedByIdModification as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAssetsRelatedByIdCreation) {
                foreach ($this->collAssetsRelatedByIdCreation as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAssetsRelatedByIdModification) {
                foreach ($this->collAssetsRelatedByIdModification as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAssetExchangesRelatedByIdCreation) {
                foreach ($this->collAssetExchangesRelatedByIdCreation as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAssetExchangesRelatedByIdModification) {
                foreach ($this->collAssetExchangesRelatedByIdModification as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTradesRelatedByIdCreation) {
                foreach ($this->collTradesRelatedByIdCreation as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTradesRelatedByIdModification) {
                foreach ($this->collTradesRelatedByIdModification as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collExchangesRelatedByIdCreation) {
                foreach ($this->collExchangesRelatedByIdCreation as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collExchangesRelatedByIdModification) {
                foreach ($this->collExchangesRelatedByIdModification as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTokensRelatedByIdCreation) {
                foreach ($this->collTokensRelatedByIdCreation as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTokensRelatedByIdModification) {
                foreach ($this->collTokensRelatedByIdModification as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSymbolsRelatedByIdCreation) {
                foreach ($this->collSymbolsRelatedByIdCreation as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSymbolsRelatedByIdModification) {
                foreach ($this->collSymbolsRelatedByIdModification as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collImportsRelatedByIdCreation) {
                foreach ($this->collImportsRelatedByIdCreation as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collImportsRelatedByIdModification) {
                foreach ($this->collImportsRelatedByIdModification as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAuthyGroupsRelatedByIdCreation) {
                foreach ($this->collAuthyGroupsRelatedByIdCreation as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAuthyGroupsRelatedByIdModification) {
                foreach ($this->collAuthyGroupsRelatedByIdModification as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collConfigsRelatedByIdCreation) {
                foreach ($this->collConfigsRelatedByIdCreation as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collConfigsRelatedByIdModification) {
                foreach ($this->collConfigsRelatedByIdModification as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collApiRbacsRelatedByIdCreation) {
                foreach ($this->collApiRbacsRelatedByIdCreation as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collApiRbacsRelatedByIdModification) {
                foreach ($this->collApiRbacsRelatedByIdModification as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collApiLogs) {
                foreach ($this->collApiLogs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTemplatesRelatedByIdCreation) {
                foreach ($this->collTemplatesRelatedByIdCreation as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTemplatesRelatedByIdModification) {
                foreach ($this->collTemplatesRelatedByIdModification as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTemplateFilesRelatedByIdCreation) {
                foreach ($this->collTemplateFilesRelatedByIdCreation as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTemplateFilesRelatedByIdModification) {
                foreach ($this->collTemplateFilesRelatedByIdModification as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMessageI18nsRelatedByIdCreation) {
                foreach ($this->collMessageI18nsRelatedByIdCreation as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMessageI18nsRelatedByIdModification) {
                foreach ($this->collMessageI18nsRelatedByIdModification as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAuthyGroups) {
                foreach ($this->collAuthyGroups as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aAuthyGroupRelatedByIdAuthyGroup instanceof Persistent) {
              $this->aAuthyGroupRelatedByIdAuthyGroup->clearAllReferences($deep);
            }
            if ($this->aAuthyGroupRelatedByIdGroupCreation instanceof Persistent) {
              $this->aAuthyGroupRelatedByIdGroupCreation->clearAllReferences($deep);
            }
            if ($this->aAuthyRelatedByIdCreation instanceof Persistent) {
              $this->aAuthyRelatedByIdCreation->clearAllReferences($deep);
            }
            if ($this->aAuthyRelatedByIdModification instanceof Persistent) {
              $this->aAuthyRelatedByIdModification->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collAuthyGroupxes instanceof PropelCollection) {
            $this->collAuthyGroupxes->clearIterator();
        }
        $this->collAuthyGroupxes = null;
        if ($this->collAuthyLogs instanceof PropelCollection) {
            $this->collAuthyLogs->clearIterator();
        }
        $this->collAuthyLogs = null;
        if ($this->collAuthiesRelatedByIdAuthy0 instanceof PropelCollection) {
            $this->collAuthiesRelatedByIdAuthy0->clearIterator();
        }
        $this->collAuthiesRelatedByIdAuthy0 = null;
        if ($this->collAuthiesRelatedByIdAuthy1 instanceof PropelCollection) {
            $this->collAuthiesRelatedByIdAuthy1->clearIterator();
        }
        $this->collAuthiesRelatedByIdAuthy1 = null;
        if ($this->collCountriesRelatedByIdCreation instanceof PropelCollection) {
            $this->collCountriesRelatedByIdCreation->clearIterator();
        }
        $this->collCountriesRelatedByIdCreation = null;
        if ($this->collCountriesRelatedByIdModification instanceof PropelCollection) {
            $this->collCountriesRelatedByIdModification->clearIterator();
        }
        $this->collCountriesRelatedByIdModification = null;
        if ($this->collAssetsRelatedByIdCreation instanceof PropelCollection) {
            $this->collAssetsRelatedByIdCreation->clearIterator();
        }
        $this->collAssetsRelatedByIdCreation = null;
        if ($this->collAssetsRelatedByIdModification instanceof PropelCollection) {
            $this->collAssetsRelatedByIdModification->clearIterator();
        }
        $this->collAssetsRelatedByIdModification = null;
        if ($this->collAssetExchangesRelatedByIdCreation instanceof PropelCollection) {
            $this->collAssetExchangesRelatedByIdCreation->clearIterator();
        }
        $this->collAssetExchangesRelatedByIdCreation = null;
        if ($this->collAssetExchangesRelatedByIdModification instanceof PropelCollection) {
            $this->collAssetExchangesRelatedByIdModification->clearIterator();
        }
        $this->collAssetExchangesRelatedByIdModification = null;
        if ($this->collTradesRelatedByIdCreation instanceof PropelCollection) {
            $this->collTradesRelatedByIdCreation->clearIterator();
        }
        $this->collTradesRelatedByIdCreation = null;
        if ($this->collTradesRelatedByIdModification instanceof PropelCollection) {
            $this->collTradesRelatedByIdModification->clearIterator();
        }
        $this->collTradesRelatedByIdModification = null;
        if ($this->collExchangesRelatedByIdCreation instanceof PropelCollection) {
            $this->collExchangesRelatedByIdCreation->clearIterator();
        }
        $this->collExchangesRelatedByIdCreation = null;
        if ($this->collExchangesRelatedByIdModification instanceof PropelCollection) {
            $this->collExchangesRelatedByIdModification->clearIterator();
        }
        $this->collExchangesRelatedByIdModification = null;
        if ($this->collTokensRelatedByIdCreation instanceof PropelCollection) {
            $this->collTokensRelatedByIdCreation->clearIterator();
        }
        $this->collTokensRelatedByIdCreation = null;
        if ($this->collTokensRelatedByIdModification instanceof PropelCollection) {
            $this->collTokensRelatedByIdModification->clearIterator();
        }
        $this->collTokensRelatedByIdModification = null;
        if ($this->collSymbolsRelatedByIdCreation instanceof PropelCollection) {
            $this->collSymbolsRelatedByIdCreation->clearIterator();
        }
        $this->collSymbolsRelatedByIdCreation = null;
        if ($this->collSymbolsRelatedByIdModification instanceof PropelCollection) {
            $this->collSymbolsRelatedByIdModification->clearIterator();
        }
        $this->collSymbolsRelatedByIdModification = null;
        if ($this->collImportsRelatedByIdCreation instanceof PropelCollection) {
            $this->collImportsRelatedByIdCreation->clearIterator();
        }
        $this->collImportsRelatedByIdCreation = null;
        if ($this->collImportsRelatedByIdModification instanceof PropelCollection) {
            $this->collImportsRelatedByIdModification->clearIterator();
        }
        $this->collImportsRelatedByIdModification = null;
        if ($this->collAuthyGroupsRelatedByIdCreation instanceof PropelCollection) {
            $this->collAuthyGroupsRelatedByIdCreation->clearIterator();
        }
        $this->collAuthyGroupsRelatedByIdCreation = null;
        if ($this->collAuthyGroupsRelatedByIdModification instanceof PropelCollection) {
            $this->collAuthyGroupsRelatedByIdModification->clearIterator();
        }
        $this->collAuthyGroupsRelatedByIdModification = null;
        if ($this->collConfigsRelatedByIdCreation instanceof PropelCollection) {
            $this->collConfigsRelatedByIdCreation->clearIterator();
        }
        $this->collConfigsRelatedByIdCreation = null;
        if ($this->collConfigsRelatedByIdModification instanceof PropelCollection) {
            $this->collConfigsRelatedByIdModification->clearIterator();
        }
        $this->collConfigsRelatedByIdModification = null;
        if ($this->collApiRbacsRelatedByIdCreation instanceof PropelCollection) {
            $this->collApiRbacsRelatedByIdCreation->clearIterator();
        }
        $this->collApiRbacsRelatedByIdCreation = null;
        if ($this->collApiRbacsRelatedByIdModification instanceof PropelCollection) {
            $this->collApiRbacsRelatedByIdModification->clearIterator();
        }
        $this->collApiRbacsRelatedByIdModification = null;
        if ($this->collApiLogs instanceof PropelCollection) {
            $this->collApiLogs->clearIterator();
        }
        $this->collApiLogs = null;
        if ($this->collTemplatesRelatedByIdCreation instanceof PropelCollection) {
            $this->collTemplatesRelatedByIdCreation->clearIterator();
        }
        $this->collTemplatesRelatedByIdCreation = null;
        if ($this->collTemplatesRelatedByIdModification instanceof PropelCollection) {
            $this->collTemplatesRelatedByIdModification->clearIterator();
        }
        $this->collTemplatesRelatedByIdModification = null;
        if ($this->collTemplateFilesRelatedByIdCreation instanceof PropelCollection) {
            $this->collTemplateFilesRelatedByIdCreation->clearIterator();
        }
        $this->collTemplateFilesRelatedByIdCreation = null;
        if ($this->collTemplateFilesRelatedByIdModification instanceof PropelCollection) {
            $this->collTemplateFilesRelatedByIdModification->clearIterator();
        }
        $this->collTemplateFilesRelatedByIdModification = null;
        if ($this->collMessageI18nsRelatedByIdCreation instanceof PropelCollection) {
            $this->collMessageI18nsRelatedByIdCreation->clearIterator();
        }
        $this->collMessageI18nsRelatedByIdCreation = null;
        if ($this->collMessageI18nsRelatedByIdModification instanceof PropelCollection) {
            $this->collMessageI18nsRelatedByIdModification->clearIterator();
        }
        $this->collMessageI18nsRelatedByIdModification = null;
        if ($this->collAuthyGroups instanceof PropelCollection) {
            $this->collAuthyGroups->clearIterator();
        }
        $this->collAuthyGroups = null;
        $this->aAuthyGroupRelatedByIdAuthyGroup = null;
        $this->aAuthyGroupRelatedByIdGroupCreation = null;
        $this->aAuthyRelatedByIdCreation = null;
        $this->aAuthyRelatedByIdModification = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AuthyPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

    // add_tablestamp behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     Authy The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = AuthyPeer::DATE_MODIFICATION;

        return $this;
    }

}
