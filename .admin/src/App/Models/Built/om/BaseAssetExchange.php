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
use \PropelDateTime;
use \PropelException;
use \PropelPDO;
use App\Asset;
use App\AssetExchange;
use App\AssetExchangePeer;
use App\AssetExchangeQuery;
use App\AssetQuery;
use App\Authy;
use App\AuthyGroup;
use App\AuthyGroupQuery;
use App\AuthyQuery;
use App\Exchange;
use App\ExchangeQuery;
use App\Token;
use App\TokenQuery;

/**
 * Base class that represents a row from the 'asset_exchange' table.
 *
 * Wallet
 *
 * @package    propel.generator..om
 */
abstract class BaseAssetExchange extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'App\\AssetExchangePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AssetExchangePeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_asset_exchange field.
     * @var        int
     */
    protected $id_asset_exchange;

    /**
     * The value for the id_asset field.
     * @var        int
     */
    protected $id_asset;

    /**
     * The value for the type field.
     * @var        int
     */
    protected $type;

    /**
     * The value for the id_exchange field.
     * @var        int
     */
    protected $id_exchange;

    /**
     * The value for the id_token field.
     * @var        int
     */
    protected $id_token;

    /**
     * The value for the free_token field.
     * @var        string
     */
    protected $free_token;

    /**
     * The value for the locked_token field.
     * @var        string
     */
    protected $locked_token;

    /**
     * The value for the freeze_token field.
     * @var        string
     */
    protected $freeze_token;

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
     * @var        Asset
     */
    protected $aAsset;

    /**
     * @var        Exchange
     */
    protected $aExchange;

    /**
     * @var        Token
     */
    protected $aToken;

    /**
     * @var        AuthyGroup
     */
    protected $aAuthyGroup;

    /**
     * @var        Authy
     */
    protected $aAuthyRelatedByIdCreation;

    /**
     * @var        Authy
     */
    protected $aAuthyRelatedByIdModification;

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
     * @Field()
     * Get the [id_asset_exchange] column value.
     *
     * @return int
     */
    public function getIdAssetExchange()
    {

        return $this->id_asset_exchange;
    }

    /**
     * @Field()
     * Get the [id_asset] column value.
     *
     * @return int
     */
    public function getIdAsset()
    {

        return $this->id_asset;
    }

    /**
     * @Field()
     * Get the [type] column value.
     * Type
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getType()
    {
        if (null === $this->type) {
            return null;
        }
        $valueSet = AssetExchangePeer::getValueSet(AssetExchangePeer::TYPE);
        if (!isset($valueSet[$this->type])) {
            throw new PropelException('Unknown stored enum key: ' . $this->type);
        }

        return $valueSet[$this->type];
    }

    /**
     * @Field()
     * Get the [id_exchange] column value.
     * Exchange
     * @return int
     */
    public function getIdExchange()
    {

        return $this->id_exchange;
    }

    /**
     * @Field()
     * Get the [id_token] column value.
     *
     * @return int
     */
    public function getIdToken()
    {

        return $this->id_token;
    }

    /**
     * @Field()
     * Get the [free_token] column value.
     * Free
     * @return string
     */
    public function getFreeToken()
    {

        return $this->free_token;
    }

    /**
     * @Field()
     * Get the [locked_token] column value.
     * Locked
     * @return string
     */
    public function getLockedToken()
    {

        return $this->locked_token;
    }

    /**
     * @Field()
     * Get the [freeze_token] column value.
     * Frozen
     * @return string
     */
    public function getFreezeToken()
    {

        return $this->freeze_token;
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
     * Set the value of [id_asset_exchange] column.
     *
     * @param  int $v new value
     * @return AssetExchange The current object (for fluent API support)
     */
    public function setIdAssetExchange($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_asset_exchange !== $v) {
            $this->id_asset_exchange = $v;
            $this->modifiedColumns[] = AssetExchangePeer::ID_ASSET_EXCHANGE;
        }


        return $this;
    } // setIdAssetExchange()

    /**
     * Set the value of [id_asset] column.
     *
     * @param  int $v new value
     * @return AssetExchange The current object (for fluent API support)
     */
    public function setIdAsset($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_asset !== $v) {
            $this->id_asset = $v;
            $this->modifiedColumns[] = AssetExchangePeer::ID_ASSET;
        }

        if ($this->aAsset !== null && $this->aAsset->getIdAsset() !== $v) {
            $this->aAsset = null;
        }


        return $this;
    } // setIdAsset()

    /**
     * Set the value of [type] column.
     * Type
     * @param  int $v new value
     * @return AssetExchange The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setType($v)
    {
        if ($v !== null) {
            $valueSet = AssetExchangePeer::getValueSet(AssetExchangePeer::TYPE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[] = AssetExchangePeer::TYPE;
        }


        return $this;
    } // setType()

    /**
     * Set the value of [id_exchange] column.
     * Exchange
     * @param  int $v new value
     * @return AssetExchange The current object (for fluent API support)
     */
    public function setIdExchange($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_exchange !== $v) {
            $this->id_exchange = $v;
            $this->modifiedColumns[] = AssetExchangePeer::ID_EXCHANGE;
        }

        if ($this->aExchange !== null && $this->aExchange->getIdExchange() !== $v) {
            $this->aExchange = null;
        }


        return $this;
    } // setIdExchange()

    /**
     * Set the value of [id_token] column.
     *
     * @param  int $v new value
     * @return AssetExchange The current object (for fluent API support)
     */
    public function setIdToken($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_token !== $v) {
            $this->id_token = $v;
            $this->modifiedColumns[] = AssetExchangePeer::ID_TOKEN;
        }

        if ($this->aToken !== null && $this->aToken->getIdToken() !== $v) {
            $this->aToken = null;
        }


        return $this;
    } // setIdToken()

    /**
     * Set the value of [free_token] column.
     * Free
     * @param  string $v new value
     * @return AssetExchange The current object (for fluent API support)
     */
    public function setFreeToken($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->free_token !== $v) {
            $this->free_token = $v;
            $this->modifiedColumns[] = AssetExchangePeer::FREE_TOKEN;
        }


        return $this;
    } // setFreeToken()

    /**
     * Set the value of [locked_token] column.
     * Locked
     * @param  string $v new value
     * @return AssetExchange The current object (for fluent API support)
     */
    public function setLockedToken($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->locked_token !== $v) {
            $this->locked_token = $v;
            $this->modifiedColumns[] = AssetExchangePeer::LOCKED_TOKEN;
        }


        return $this;
    } // setLockedToken()

    /**
     * Set the value of [freeze_token] column.
     * Frozen
     * @param  string $v new value
     * @return AssetExchange The current object (for fluent API support)
     */
    public function setFreezeToken($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->freeze_token !== $v) {
            $this->freeze_token = $v;
            $this->modifiedColumns[] = AssetExchangePeer::FREEZE_TOKEN;
        }


        return $this;
    } // setFreezeToken()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return AssetExchange The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_creation !== null || $dt !== null) {
            $currentDateAsString = ($this->date_creation !== null && $tmpDt = new DateTime($this->date_creation)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date_creation = $newDateAsString;
                $this->modifiedColumns[] = AssetExchangePeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return AssetExchange The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_modification !== null || $dt !== null) {
            $currentDateAsString = ($this->date_modification !== null && $tmpDt = new DateTime($this->date_modification)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date_modification = $newDateAsString;
                $this->modifiedColumns[] = AssetExchangePeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [id_group_creation] column.
     *
     * @param  int $v new value
     * @return AssetExchange The current object (for fluent API support)
     */
    public function setIdGroupCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_group_creation !== $v) {
            $this->id_group_creation = $v;
            $this->modifiedColumns[] = AssetExchangePeer::ID_GROUP_CREATION;
        }

        if ($this->aAuthyGroup !== null && $this->aAuthyGroup->getIdAuthyGroup() !== $v) {
            $this->aAuthyGroup = null;
        }


        return $this;
    } // setIdGroupCreation()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return AssetExchange The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = AssetExchangePeer::ID_CREATION;
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
     * @return AssetExchange The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = AssetExchangePeer::ID_MODIFICATION;
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

            $this->id_asset_exchange = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->id_asset = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->type = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->id_exchange = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->id_token = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->free_token = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->locked_token = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->freeze_token = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->date_creation = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->date_modification = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->id_group_creation = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
            $this->id_creation = ($row[$startcol + 11] !== null) ? (int) $row[$startcol + 11] : null;
            $this->id_modification = ($row[$startcol + 12] !== null) ? (int) $row[$startcol + 12] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 13; // 13 = AssetExchangePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating AssetExchange object", $e);
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

        if ($this->aAsset !== null && $this->id_asset !== $this->aAsset->getIdAsset()) {
            $this->aAsset = null;
        }
        if ($this->aExchange !== null && $this->id_exchange !== $this->aExchange->getIdExchange()) {
            $this->aExchange = null;
        }
        if ($this->aToken !== null && $this->id_token !== $this->aToken->getIdToken()) {
            $this->aToken = null;
        }
        if ($this->aAuthyGroup !== null && $this->id_group_creation !== $this->aAuthyGroup->getIdAuthyGroup()) {
            $this->aAuthyGroup = null;
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
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = AssetExchangePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAsset = null;
            $this->aExchange = null;
            $this->aToken = null;
            $this->aAuthyGroup = null;
            $this->aAuthyRelatedByIdCreation = null;
            $this->aAuthyRelatedByIdModification = null;
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
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = AssetExchangeQuery::create()
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
            $con = Propel::getConnection(AssetExchangePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
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
                AssetExchangePeer::addInstanceToPool($this);
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

            if ($this->aAsset !== null) {
                if ($this->aAsset->isModified() || $this->aAsset->isNew()) {
                    $affectedRows += $this->aAsset->save($con);
                }
                $this->setAsset($this->aAsset);
            }

            if ($this->aExchange !== null) {
                if ($this->aExchange->isModified() || $this->aExchange->isNew()) {
                    $affectedRows += $this->aExchange->save($con);
                }
                $this->setExchange($this->aExchange);
            }

            if ($this->aToken !== null) {
                if ($this->aToken->isModified() || $this->aToken->isNew()) {
                    $affectedRows += $this->aToken->save($con);
                }
                $this->setToken($this->aToken);
            }

            if ($this->aAuthyGroup !== null) {
                if ($this->aAuthyGroup->isModified() || $this->aAuthyGroup->isNew()) {
                    $affectedRows += $this->aAuthyGroup->save($con);
                }
                $this->setAuthyGroup($this->aAuthyGroup);
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

        $this->modifiedColumns[] = AssetExchangePeer::ID_ASSET_EXCHANGE;
        if (null !== $this->id_asset_exchange) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AssetExchangePeer::ID_ASSET_EXCHANGE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AssetExchangePeer::ID_ASSET_EXCHANGE)) {
            $modifiedColumns[':p' . $index++]  = '`id_asset_exchange`';
        }
        if ($this->isColumnModified(AssetExchangePeer::ID_ASSET)) {
            $modifiedColumns[':p' . $index++]  = '`id_asset`';
        }
        if ($this->isColumnModified(AssetExchangePeer::TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`type`';
        }
        if ($this->isColumnModified(AssetExchangePeer::ID_EXCHANGE)) {
            $modifiedColumns[':p' . $index++]  = '`id_exchange`';
        }
        if ($this->isColumnModified(AssetExchangePeer::ID_TOKEN)) {
            $modifiedColumns[':p' . $index++]  = '`id_token`';
        }
        if ($this->isColumnModified(AssetExchangePeer::FREE_TOKEN)) {
            $modifiedColumns[':p' . $index++]  = '`free_token`';
        }
        if ($this->isColumnModified(AssetExchangePeer::LOCKED_TOKEN)) {
            $modifiedColumns[':p' . $index++]  = '`locked_token`';
        }
        if ($this->isColumnModified(AssetExchangePeer::FREEZE_TOKEN)) {
            $modifiedColumns[':p' . $index++]  = '`freeze_token`';
        }
        if ($this->isColumnModified(AssetExchangePeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(AssetExchangePeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(AssetExchangePeer::ID_GROUP_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_group_creation`';
        }
        if ($this->isColumnModified(AssetExchangePeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(AssetExchangePeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `asset_exchange` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_asset_exchange`':
                        $stmt->bindValue($identifier, $this->id_asset_exchange, PDO::PARAM_INT);
                        break;
                    case '`id_asset`':
                        $stmt->bindValue($identifier, $this->id_asset, PDO::PARAM_INT);
                        break;
                    case '`type`':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_INT);
                        break;
                    case '`id_exchange`':
                        $stmt->bindValue($identifier, $this->id_exchange, PDO::PARAM_INT);
                        break;
                    case '`id_token`':
                        $stmt->bindValue($identifier, $this->id_token, PDO::PARAM_INT);
                        break;
                    case '`free_token`':
                        $stmt->bindValue($identifier, $this->free_token, PDO::PARAM_STR);
                        break;
                    case '`locked_token`':
                        $stmt->bindValue($identifier, $this->locked_token, PDO::PARAM_STR);
                        break;
                    case '`freeze_token`':
                        $stmt->bindValue($identifier, $this->freeze_token, PDO::PARAM_STR);
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
        $this->setIdAssetExchange($pk);

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

            if ($this->aAsset !== null) {
                if (!$this->aAsset->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAsset->getValidationFailures());
                }
            }

            if ($this->aExchange !== null) {
                if (!$this->aExchange->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aExchange->getValidationFailures());
                }
            }

            if ($this->aToken !== null) {
                if (!$this->aToken->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aToken->getValidationFailures());
                }
            }

            if ($this->aAuthyGroup !== null) {
                if (!$this->aAuthyGroup->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAuthyGroup->getValidationFailures());
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


            if (($retval = AssetExchangePeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
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
        $pos = AssetExchangePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
        if (isset($alreadyDumpedObjects['AssetExchange'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AssetExchange'][$this->getPrimaryKey()] = true;
        $keys = AssetExchangePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdAssetExchange(),
            $keys[1] => $this->getIdAsset(),
            $keys[2] => $this->getType(),
            $keys[3] => $this->getIdExchange(),
            $keys[4] => $this->getIdToken(),
            $keys[5] => $this->getFreeToken(),
            $keys[6] => $this->getLockedToken(),
            $keys[7] => $this->getFreezeToken(),
            $keys[8] => $this->getDateCreation(),
            $keys[9] => $this->getDateModification(),
            $keys[10] => $this->getIdGroupCreation(),
            $keys[11] => $this->getIdCreation(),
            $keys[12] => $this->getIdModification(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAsset) {
                $result['Asset'] = $this->aAsset->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aExchange) {
                $result['Exchange'] = $this->aExchange->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aToken) {
                $result['Token'] = $this->aToken->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAuthyGroup) {
                $result['AuthyGroup'] = $this->aAuthyGroup->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAuthyRelatedByIdCreation) {
                $result['AuthyRelatedByIdCreation'] = $this->aAuthyRelatedByIdCreation->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAuthyRelatedByIdModification) {
                $result['AuthyRelatedByIdModification'] = $this->aAuthyRelatedByIdModification->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = AssetExchangePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setIdAssetExchange($value);
                break;
            case 1:
                $this->setIdAsset($value);
                break;
            case 2:
                $valueSet = AssetExchangePeer::getValueSet(AssetExchangePeer::TYPE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setType($value);
                break;
            case 3:
                $this->setIdExchange($value);
                break;
            case 4:
                $this->setIdToken($value);
                break;
            case 5:
                $this->setFreeToken($value);
                break;
            case 6:
                $this->setLockedToken($value);
                break;
            case 7:
                $this->setFreezeToken($value);
                break;
            case 8:
                $this->setDateCreation($value);
                break;
            case 9:
                $this->setDateModification($value);
                break;
            case 10:
                $this->setIdGroupCreation($value);
                break;
            case 11:
                $this->setIdCreation($value);
                break;
            case 12:
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
        $keys = AssetExchangePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdAssetExchange($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setIdAsset($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setType($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setIdExchange($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setIdToken($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setFreeToken($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setLockedToken($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setFreezeToken($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setDateCreation($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setDateModification($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setIdGroupCreation($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setIdCreation($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setIdModification($arr[$keys[12]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AssetExchangePeer::DATABASE_NAME);

        if ($this->isColumnModified(AssetExchangePeer::ID_ASSET_EXCHANGE)) $criteria->add(AssetExchangePeer::ID_ASSET_EXCHANGE, $this->id_asset_exchange);
        if ($this->isColumnModified(AssetExchangePeer::ID_ASSET)) $criteria->add(AssetExchangePeer::ID_ASSET, $this->id_asset);
        if ($this->isColumnModified(AssetExchangePeer::TYPE)) $criteria->add(AssetExchangePeer::TYPE, $this->type);
        if ($this->isColumnModified(AssetExchangePeer::ID_EXCHANGE)) $criteria->add(AssetExchangePeer::ID_EXCHANGE, $this->id_exchange);
        if ($this->isColumnModified(AssetExchangePeer::ID_TOKEN)) $criteria->add(AssetExchangePeer::ID_TOKEN, $this->id_token);
        if ($this->isColumnModified(AssetExchangePeer::FREE_TOKEN)) $criteria->add(AssetExchangePeer::FREE_TOKEN, $this->free_token);
        if ($this->isColumnModified(AssetExchangePeer::LOCKED_TOKEN)) $criteria->add(AssetExchangePeer::LOCKED_TOKEN, $this->locked_token);
        if ($this->isColumnModified(AssetExchangePeer::FREEZE_TOKEN)) $criteria->add(AssetExchangePeer::FREEZE_TOKEN, $this->freeze_token);
        if ($this->isColumnModified(AssetExchangePeer::DATE_CREATION)) $criteria->add(AssetExchangePeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(AssetExchangePeer::DATE_MODIFICATION)) $criteria->add(AssetExchangePeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(AssetExchangePeer::ID_GROUP_CREATION)) $criteria->add(AssetExchangePeer::ID_GROUP_CREATION, $this->id_group_creation);
        if ($this->isColumnModified(AssetExchangePeer::ID_CREATION)) $criteria->add(AssetExchangePeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(AssetExchangePeer::ID_MODIFICATION)) $criteria->add(AssetExchangePeer::ID_MODIFICATION, $this->id_modification);

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
        $criteria = new Criteria(AssetExchangePeer::DATABASE_NAME);
        $criteria->add(AssetExchangePeer::ID_ASSET_EXCHANGE, $this->id_asset_exchange);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdAssetExchange();
    }

    /**
     * Generic method to set the primary key (id_asset_exchange column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdAssetExchange($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdAssetExchange();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of AssetExchange (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIdAsset($this->getIdAsset());
        $copyObj->setType($this->getType());
        $copyObj->setIdExchange($this->getIdExchange());
        $copyObj->setIdToken($this->getIdToken());
        $copyObj->setFreeToken($this->getFreeToken());
        $copyObj->setLockedToken($this->getLockedToken());
        $copyObj->setFreezeToken($this->getFreezeToken());
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

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdAssetExchange(NULL); // this is a auto-increment column, so set to default value
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
     * @return AssetExchange Clone of current object.
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
     * @return AssetExchangePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AssetExchangePeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Asset object.
     *
     * @param                  Asset $v
     * @return AssetExchange The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAsset(Asset $v = null)
    {
        if ($v === null) {
            $this->setIdAsset(NULL);
        } else {
            $this->setIdAsset($v->getIdAsset());
        }

        $this->aAsset = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Asset object, it will not be re-added.
        if ($v !== null) {
            $v->addAssetExchange($this);
        }


        return $this;
    }


    /**
     * Get the associated Asset object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Asset The associated Asset object.
     * @throws PropelException
     */
    public function getAsset(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAsset === null && ($this->id_asset !== null) && $doQuery) {
            $this->aAsset = AssetQuery::create()->findPk($this->id_asset, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAsset->addAssetExchanges($this);
             */
        }

        return $this->aAsset;
    }

    /**
     * Declares an association between this object and a Exchange object.
     *
     * @param                  Exchange $v
     * @return AssetExchange The current object (for fluent API support)
     * @throws PropelException
     */
    public function setExchange(Exchange $v = null)
    {
        if ($v === null) {
            $this->setIdExchange(NULL);
        } else {
            $this->setIdExchange($v->getIdExchange());
        }

        $this->aExchange = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Exchange object, it will not be re-added.
        if ($v !== null) {
            $v->addAssetExchange($this);
        }


        return $this;
    }


    /**
     * Get the associated Exchange object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Exchange The associated Exchange object.
     * @throws PropelException
     */
    public function getExchange(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aExchange === null && ($this->id_exchange !== null) && $doQuery) {
            $this->aExchange = ExchangeQuery::create()->findPk($this->id_exchange, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aExchange->addAssetExchanges($this);
             */
        }

        return $this->aExchange;
    }

    /**
     * Declares an association between this object and a Token object.
     *
     * @param                  Token $v
     * @return AssetExchange The current object (for fluent API support)
     * @throws PropelException
     */
    public function setToken(Token $v = null)
    {
        if ($v === null) {
            $this->setIdToken(NULL);
        } else {
            $this->setIdToken($v->getIdToken());
        }

        $this->aToken = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Token object, it will not be re-added.
        if ($v !== null) {
            $v->addAssetExchange($this);
        }


        return $this;
    }


    /**
     * Get the associated Token object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Token The associated Token object.
     * @throws PropelException
     */
    public function getToken(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aToken === null && ($this->id_token !== null) && $doQuery) {
            $this->aToken = TokenQuery::create()->findPk($this->id_token, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aToken->addAssetExchanges($this);
             */
        }

        return $this->aToken;
    }

    /**
     * Declares an association between this object and a AuthyGroup object.
     *
     * @param                  AuthyGroup $v
     * @return AssetExchange The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAuthyGroup(AuthyGroup $v = null)
    {
        if ($v === null) {
            $this->setIdGroupCreation(NULL);
        } else {
            $this->setIdGroupCreation($v->getIdAuthyGroup());
        }

        $this->aAuthyGroup = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the AuthyGroup object, it will not be re-added.
        if ($v !== null) {
            $v->addAssetExchange($this);
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
    public function getAuthyGroup(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAuthyGroup === null && ($this->id_group_creation !== null) && $doQuery) {
            $this->aAuthyGroup = AuthyGroupQuery::create()->findPk($this->id_group_creation, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAuthyGroup->addAssetExchanges($this);
             */
        }

        return $this->aAuthyGroup;
    }

    /**
     * Declares an association between this object and a Authy object.
     *
     * @param                  Authy $v
     * @return AssetExchange The current object (for fluent API support)
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
            $v->addAssetExchangeRelatedByIdCreation($this);
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
                $this->aAuthyRelatedByIdCreation->addAssetExchangesRelatedByIdCreation($this);
             */
        }

        return $this->aAuthyRelatedByIdCreation;
    }

    /**
     * Declares an association between this object and a Authy object.
     *
     * @param                  Authy $v
     * @return AssetExchange The current object (for fluent API support)
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
            $v->addAssetExchangeRelatedByIdModification($this);
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
                $this->aAuthyRelatedByIdModification->addAssetExchangesRelatedByIdModification($this);
             */
        }

        return $this->aAuthyRelatedByIdModification;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_asset_exchange = null;
        $this->id_asset = null;
        $this->type = null;
        $this->id_exchange = null;
        $this->id_token = null;
        $this->free_token = null;
        $this->locked_token = null;
        $this->freeze_token = null;
        $this->date_creation = null;
        $this->date_modification = null;
        $this->id_group_creation = null;
        $this->id_creation = null;
        $this->id_modification = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
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
            if ($this->aAsset instanceof Persistent) {
              $this->aAsset->clearAllReferences($deep);
            }
            if ($this->aExchange instanceof Persistent) {
              $this->aExchange->clearAllReferences($deep);
            }
            if ($this->aToken instanceof Persistent) {
              $this->aToken->clearAllReferences($deep);
            }
            if ($this->aAuthyGroup instanceof Persistent) {
              $this->aAuthyGroup->clearAllReferences($deep);
            }
            if ($this->aAuthyRelatedByIdCreation instanceof Persistent) {
              $this->aAuthyRelatedByIdCreation->clearAllReferences($deep);
            }
            if ($this->aAuthyRelatedByIdModification instanceof Persistent) {
              $this->aAuthyRelatedByIdModification->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aAsset = null;
        $this->aExchange = null;
        $this->aToken = null;
        $this->aAuthyGroup = null;
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
        return (string) $this->exportTo(AssetExchangePeer::DEFAULT_STRING_FORMAT);
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
     * @return     AssetExchange The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = AssetExchangePeer::DATE_MODIFICATION;

        return $this;
    }

}
