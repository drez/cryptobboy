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
use App\Asset;
use App\AssetExchange;
use App\AssetExchangeQuery;
use App\AssetQuery;
use App\Authy;
use App\AuthyGroup;
use App\AuthyGroupQuery;
use App\AuthyQuery;
use App\Symbol;
use App\SymbolQuery;
use App\Token;
use App\TokenPeer;
use App\TokenQuery;
use App\Trade;
use App\TradeQuery;

/**
 * Base class that represents a row from the 'token' table.
 *
 * Token
 *
 * @package    propel.generator..om
 */
abstract class BaseToken extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'App\\TokenPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        TokenPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_token field.
     * @var        int
     */
    protected $id_token;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the ticker field.
     * @var        string
     */
    protected $ticker;

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
     * @var        PropelObjectCollection|Asset[] Collection to store aggregation of Asset objects.
     */
    protected $collAssets;
    protected $collAssetsPartial;

    /**
     * @var        PropelObjectCollection|AssetExchange[] Collection to store aggregation of AssetExchange objects.
     */
    protected $collAssetExchanges;
    protected $collAssetExchangesPartial;

    /**
     * @var        PropelObjectCollection|Trade[] Collection to store aggregation of Trade objects.
     */
    protected $collTrades;
    protected $collTradesPartial;

    /**
     * @var        PropelObjectCollection|Symbol[] Collection to store aggregation of Symbol objects.
     */
    protected $collSymbols;
    protected $collSymbolsPartial;

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
    protected $assetsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $assetExchangesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $tradesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $symbolsScheduledForDeletion = null;

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
     * Get the [name] column value.
     * Name
     * @return string
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * @Field()
     * Get the [ticker] column value.
     * Ticker
     * @return string
     */
    public function getTicker()
    {

        return $this->ticker;
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
     * Set the value of [id_token] column.
     *
     * @param  int $v new value
     * @return Token The current object (for fluent API support)
     */
    public function setIdToken($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_token !== $v) {
            $this->id_token = $v;
            $this->modifiedColumns[] = TokenPeer::ID_TOKEN;
        }


        return $this;
    } // setIdToken()

    /**
     * Set the value of [name] column.
     * Name
     * @param  string $v new value
     * @return Token The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = TokenPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [ticker] column.
     * Ticker
     * @param  string $v new value
     * @return Token The current object (for fluent API support)
     */
    public function setTicker($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ticker !== $v) {
            $this->ticker = $v;
            $this->modifiedColumns[] = TokenPeer::TICKER;
        }


        return $this;
    } // setTicker()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Token The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_creation !== null || $dt !== null) {
            $currentDateAsString = ($this->date_creation !== null && $tmpDt = new DateTime($this->date_creation)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date_creation = $newDateAsString;
                $this->modifiedColumns[] = TokenPeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Token The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_modification !== null || $dt !== null) {
            $currentDateAsString = ($this->date_modification !== null && $tmpDt = new DateTime($this->date_modification)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date_modification = $newDateAsString;
                $this->modifiedColumns[] = TokenPeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [id_group_creation] column.
     *
     * @param  int $v new value
     * @return Token The current object (for fluent API support)
     */
    public function setIdGroupCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_group_creation !== $v) {
            $this->id_group_creation = $v;
            $this->modifiedColumns[] = TokenPeer::ID_GROUP_CREATION;
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
     * @return Token The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = TokenPeer::ID_CREATION;
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
     * @return Token The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = TokenPeer::ID_MODIFICATION;
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

            $this->id_token = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->ticker = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->date_creation = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->date_modification = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->id_group_creation = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->id_creation = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->id_modification = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 8; // 8 = TokenPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Token object", $e);
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
            $con = Propel::getConnection(TokenPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = TokenPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAuthyGroup = null;
            $this->aAuthyRelatedByIdCreation = null;
            $this->aAuthyRelatedByIdModification = null;
            $this->collAssets = null;

            $this->collAssetExchanges = null;

            $this->collTrades = null;

            $this->collSymbols = null;

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
            $con = Propel::getConnection(TokenPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = TokenQuery::create()
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
            $con = Propel::getConnection(TokenPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                TokenPeer::addInstanceToPool($this);
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

            if ($this->assetsScheduledForDeletion !== null) {
                if (!$this->assetsScheduledForDeletion->isEmpty()) {
                    AssetQuery::create()
                        ->filterByPrimaryKeys($this->assetsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->assetsScheduledForDeletion = null;
                }
            }

            if ($this->collAssets !== null) {
                foreach ($this->collAssets as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->assetExchangesScheduledForDeletion !== null) {
                if (!$this->assetExchangesScheduledForDeletion->isEmpty()) {
                    AssetExchangeQuery::create()
                        ->filterByPrimaryKeys($this->assetExchangesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->assetExchangesScheduledForDeletion = null;
                }
            }

            if ($this->collAssetExchanges !== null) {
                foreach ($this->collAssetExchanges as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->tradesScheduledForDeletion !== null) {
                if (!$this->tradesScheduledForDeletion->isEmpty()) {
                    TradeQuery::create()
                        ->filterByPrimaryKeys($this->tradesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->tradesScheduledForDeletion = null;
                }
            }

            if ($this->collTrades !== null) {
                foreach ($this->collTrades as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->symbolsScheduledForDeletion !== null) {
                if (!$this->symbolsScheduledForDeletion->isEmpty()) {
                    SymbolQuery::create()
                        ->filterByPrimaryKeys($this->symbolsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->symbolsScheduledForDeletion = null;
                }
            }

            if ($this->collSymbols !== null) {
                foreach ($this->collSymbols as $referrerFK) {
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

        $this->modifiedColumns[] = TokenPeer::ID_TOKEN;
        if (null !== $this->id_token) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TokenPeer::ID_TOKEN . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TokenPeer::ID_TOKEN)) {
            $modifiedColumns[':p' . $index++]  = '`id_token`';
        }
        if ($this->isColumnModified(TokenPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(TokenPeer::TICKER)) {
            $modifiedColumns[':p' . $index++]  = '`ticker`';
        }
        if ($this->isColumnModified(TokenPeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(TokenPeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(TokenPeer::ID_GROUP_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_group_creation`';
        }
        if ($this->isColumnModified(TokenPeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(TokenPeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `token` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_token`':
                        $stmt->bindValue($identifier, $this->id_token, PDO::PARAM_INT);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`ticker`':
                        $stmt->bindValue($identifier, $this->ticker, PDO::PARAM_STR);
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
        $this->setIdToken($pk);

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


            if (($retval = TokenPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collAssets !== null) {
                    foreach ($this->collAssets as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAssetExchanges !== null) {
                    foreach ($this->collAssetExchanges as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collTrades !== null) {
                    foreach ($this->collTrades as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collSymbols !== null) {
                    foreach ($this->collSymbols as $referrerFK) {
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
        $pos = TokenPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
        if (isset($alreadyDumpedObjects['Token'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Token'][$this->getPrimaryKey()] = true;
        $keys = TokenPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdToken(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getTicker(),
            $keys[3] => $this->getDateCreation(),
            $keys[4] => $this->getDateModification(),
            $keys[5] => $this->getIdGroupCreation(),
            $keys[6] => $this->getIdCreation(),
            $keys[7] => $this->getIdModification(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAuthyGroup) {
                $result['AuthyGroup'] = $this->aAuthyGroup->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAuthyRelatedByIdCreation) {
                $result['AuthyRelatedByIdCreation'] = $this->aAuthyRelatedByIdCreation->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAuthyRelatedByIdModification) {
                $result['AuthyRelatedByIdModification'] = $this->aAuthyRelatedByIdModification->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAssets) {
                $result['Assets'] = $this->collAssets->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAssetExchanges) {
                $result['AssetExchanges'] = $this->collAssetExchanges->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTrades) {
                $result['Trades'] = $this->collTrades->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSymbols) {
                $result['Symbols'] = $this->collSymbols->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = TokenPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setIdToken($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setTicker($value);
                break;
            case 3:
                $this->setDateCreation($value);
                break;
            case 4:
                $this->setDateModification($value);
                break;
            case 5:
                $this->setIdGroupCreation($value);
                break;
            case 6:
                $this->setIdCreation($value);
                break;
            case 7:
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
        $keys = TokenPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdToken($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setTicker($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDateCreation($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDateModification($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setIdGroupCreation($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setIdCreation($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setIdModification($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(TokenPeer::DATABASE_NAME);

        if ($this->isColumnModified(TokenPeer::ID_TOKEN)) $criteria->add(TokenPeer::ID_TOKEN, $this->id_token);
        if ($this->isColumnModified(TokenPeer::NAME)) $criteria->add(TokenPeer::NAME, $this->name);
        if ($this->isColumnModified(TokenPeer::TICKER)) $criteria->add(TokenPeer::TICKER, $this->ticker);
        if ($this->isColumnModified(TokenPeer::DATE_CREATION)) $criteria->add(TokenPeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(TokenPeer::DATE_MODIFICATION)) $criteria->add(TokenPeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(TokenPeer::ID_GROUP_CREATION)) $criteria->add(TokenPeer::ID_GROUP_CREATION, $this->id_group_creation);
        if ($this->isColumnModified(TokenPeer::ID_CREATION)) $criteria->add(TokenPeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(TokenPeer::ID_MODIFICATION)) $criteria->add(TokenPeer::ID_MODIFICATION, $this->id_modification);

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
        $criteria = new Criteria(TokenPeer::DATABASE_NAME);
        $criteria->add(TokenPeer::ID_TOKEN, $this->id_token);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdToken();
    }

    /**
     * Generic method to set the primary key (id_token column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdToken($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdToken();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Token (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setTicker($this->getTicker());
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

            foreach ($this->getAssets() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAsset($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAssetExchanges() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAssetExchange($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTrades() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTrade($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSymbols() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSymbol($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdToken(NULL); // this is a auto-increment column, so set to default value
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
     * @return Token Clone of current object.
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
     * @return TokenPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new TokenPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a AuthyGroup object.
     *
     * @param                  AuthyGroup $v
     * @return Token The current object (for fluent API support)
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
            $v->addToken($this);
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
                $this->aAuthyGroup->addTokens($this);
             */
        }

        return $this->aAuthyGroup;
    }

    /**
     * Declares an association between this object and a Authy object.
     *
     * @param                  Authy $v
     * @return Token The current object (for fluent API support)
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
            $v->addTokenRelatedByIdCreation($this);
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
                $this->aAuthyRelatedByIdCreation->addTokensRelatedByIdCreation($this);
             */
        }

        return $this->aAuthyRelatedByIdCreation;
    }

    /**
     * Declares an association between this object and a Authy object.
     *
     * @param                  Authy $v
     * @return Token The current object (for fluent API support)
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
            $v->addTokenRelatedByIdModification($this);
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
                $this->aAuthyRelatedByIdModification->addTokensRelatedByIdModification($this);
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
        if ('Asset' == $relationName) {
            $this->initAssets();
        }
        if ('AssetExchange' == $relationName) {
            $this->initAssetExchanges();
        }
        if ('Trade' == $relationName) {
            $this->initTrades();
        }
        if ('Symbol' == $relationName) {
            $this->initSymbols();
        }
    }

    /**
     * Clears out the collAssets collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Token The current object (for fluent API support)
     * @see        addAssets()
     */
    public function clearAssets()
    {
        $this->collAssets = null; // important to set this to null since that means it is uninitialized
        $this->collAssetsPartial = null;

        return $this;
    }

    /**
     * reset is the collAssets collection loaded partially
     *
     * @return void
     */
    public function resetPartialAssets($v = true)
    {
        $this->collAssetsPartial = $v;
    }

    /**
     * Initializes the collAssets collection.
     *
     * By default this just sets the collAssets collection to an empty array (like clearcollAssets());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAssets($overrideExisting = true)
    {
        if (null !== $this->collAssets && !$overrideExisting) {
            return;
        }
        $this->collAssets = new PropelObjectCollection();
        $this->collAssets->setModel('Asset');
    }

    /**
     * Gets an array of Asset objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Token is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Asset[] List of Asset objects
     * @throws PropelException
     */
    public function getAssets($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAssetsPartial && !$this->isNew();
        if (null === $this->collAssets || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAssets) {
                // return empty collection
                $this->initAssets();
            } else {
                $collAssets = AssetQuery::create(null, $criteria)
                    ->filterByToken($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAssetsPartial && count($collAssets)) {
                      $this->initAssets(false);

                      foreach ($collAssets as $obj) {
                        if (false == $this->collAssets->contains($obj)) {
                          $this->collAssets->append($obj);
                        }
                      }

                      $this->collAssetsPartial = true;
                    }

                    $collAssets->getInternalIterator()->rewind();

                    return $collAssets;
                }

                if ($partial && $this->collAssets) {
                    foreach ($this->collAssets as $obj) {
                        if ($obj->isNew()) {
                            $collAssets[] = $obj;
                        }
                    }
                }

                $this->collAssets = $collAssets;
                $this->collAssetsPartial = false;
            }
        }

        return $this->collAssets;
    }

    /**
     * Sets a collection of Asset objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $assets A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Token The current object (for fluent API support)
     */
    public function setAssets(PropelCollection $assets, PropelPDO $con = null)
    {
        $assetsToDelete = $this->getAssets(new Criteria(), $con)->diff($assets);


        $this->assetsScheduledForDeletion = $assetsToDelete;

        foreach ($assetsToDelete as $assetRemoved) {
            $assetRemoved->setToken(null);
        }

        $this->collAssets = null;
        foreach ($assets as $asset) {
            $this->addAsset($asset);
        }

        $this->collAssets = $assets;
        $this->collAssetsPartial = false;

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
    public function countAssets(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAssetsPartial && !$this->isNew();
        if (null === $this->collAssets || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAssets) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAssets());
            }
            $query = AssetQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByToken($this)
                ->count($con);
        }

        return count($this->collAssets);
    }

    /**
     * Method called to associate a Asset object to this object
     * through the Asset foreign key attribute.
     *
     * @param    Asset $l Asset
     * @return Token The current object (for fluent API support)
     */
    public function addAsset(Asset $l)
    {
        if ($this->collAssets === null) {
            $this->initAssets();
            $this->collAssetsPartial = true;
        }

        if (!in_array($l, $this->collAssets->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAsset($l);

            if ($this->assetsScheduledForDeletion and $this->assetsScheduledForDeletion->contains($l)) {
                $this->assetsScheduledForDeletion->remove($this->assetsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Asset $asset The asset object to add.
     */
    protected function doAddAsset($asset)
    {
        $this->collAssets[]= $asset;
        $asset->setToken($this);
    }

    /**
     * @param	Asset $asset The asset object to remove.
     * @return Token The current object (for fluent API support)
     */
    public function removeAsset($asset)
    {
        if ($this->getAssets()->contains($asset)) {
            $this->collAssets->remove($this->collAssets->search($asset));
            if (null === $this->assetsScheduledForDeletion) {
                $this->assetsScheduledForDeletion = clone $this->collAssets;
                $this->assetsScheduledForDeletion->clear();
            }
            $this->assetsScheduledForDeletion[]= clone $asset;
            $asset->setToken(null);
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
    public function getAssetsJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getAssets($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Asset[] List of Asset objects
     */
    public function getAssetsJoinAuthyRelatedByIdCreation($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetQuery::create(null, $criteria);
        $query->joinWith('AuthyRelatedByIdCreation', $join_behavior);

        return $this->getAssets($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Asset[] List of Asset objects
     */
    public function getAssetsJoinAuthyRelatedByIdModification($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetQuery::create(null, $criteria);
        $query->joinWith('AuthyRelatedByIdModification', $join_behavior);

        return $this->getAssets($query, $con);
    }

    /**
     * Clears out the collAssetExchanges collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Token The current object (for fluent API support)
     * @see        addAssetExchanges()
     */
    public function clearAssetExchanges()
    {
        $this->collAssetExchanges = null; // important to set this to null since that means it is uninitialized
        $this->collAssetExchangesPartial = null;

        return $this;
    }

    /**
     * reset is the collAssetExchanges collection loaded partially
     *
     * @return void
     */
    public function resetPartialAssetExchanges($v = true)
    {
        $this->collAssetExchangesPartial = $v;
    }

    /**
     * Initializes the collAssetExchanges collection.
     *
     * By default this just sets the collAssetExchanges collection to an empty array (like clearcollAssetExchanges());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAssetExchanges($overrideExisting = true)
    {
        if (null !== $this->collAssetExchanges && !$overrideExisting) {
            return;
        }
        $this->collAssetExchanges = new PropelObjectCollection();
        $this->collAssetExchanges->setModel('AssetExchange');
    }

    /**
     * Gets an array of AssetExchange objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Token is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AssetExchange[] List of AssetExchange objects
     * @throws PropelException
     */
    public function getAssetExchanges($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAssetExchangesPartial && !$this->isNew();
        if (null === $this->collAssetExchanges || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAssetExchanges) {
                // return empty collection
                $this->initAssetExchanges();
            } else {
                $collAssetExchanges = AssetExchangeQuery::create(null, $criteria)
                    ->filterByToken($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAssetExchangesPartial && count($collAssetExchanges)) {
                      $this->initAssetExchanges(false);

                      foreach ($collAssetExchanges as $obj) {
                        if (false == $this->collAssetExchanges->contains($obj)) {
                          $this->collAssetExchanges->append($obj);
                        }
                      }

                      $this->collAssetExchangesPartial = true;
                    }

                    $collAssetExchanges->getInternalIterator()->rewind();

                    return $collAssetExchanges;
                }

                if ($partial && $this->collAssetExchanges) {
                    foreach ($this->collAssetExchanges as $obj) {
                        if ($obj->isNew()) {
                            $collAssetExchanges[] = $obj;
                        }
                    }
                }

                $this->collAssetExchanges = $collAssetExchanges;
                $this->collAssetExchangesPartial = false;
            }
        }

        return $this->collAssetExchanges;
    }

    /**
     * Sets a collection of AssetExchange objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $assetExchanges A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Token The current object (for fluent API support)
     */
    public function setAssetExchanges(PropelCollection $assetExchanges, PropelPDO $con = null)
    {
        $assetExchangesToDelete = $this->getAssetExchanges(new Criteria(), $con)->diff($assetExchanges);


        $this->assetExchangesScheduledForDeletion = $assetExchangesToDelete;

        foreach ($assetExchangesToDelete as $assetExchangeRemoved) {
            $assetExchangeRemoved->setToken(null);
        }

        $this->collAssetExchanges = null;
        foreach ($assetExchanges as $assetExchange) {
            $this->addAssetExchange($assetExchange);
        }

        $this->collAssetExchanges = $assetExchanges;
        $this->collAssetExchangesPartial = false;

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
    public function countAssetExchanges(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAssetExchangesPartial && !$this->isNew();
        if (null === $this->collAssetExchanges || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAssetExchanges) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAssetExchanges());
            }
            $query = AssetExchangeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByToken($this)
                ->count($con);
        }

        return count($this->collAssetExchanges);
    }

    /**
     * Method called to associate a AssetExchange object to this object
     * through the AssetExchange foreign key attribute.
     *
     * @param    AssetExchange $l AssetExchange
     * @return Token The current object (for fluent API support)
     */
    public function addAssetExchange(AssetExchange $l)
    {
        if ($this->collAssetExchanges === null) {
            $this->initAssetExchanges();
            $this->collAssetExchangesPartial = true;
        }

        if (!in_array($l, $this->collAssetExchanges->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAssetExchange($l);

            if ($this->assetExchangesScheduledForDeletion and $this->assetExchangesScheduledForDeletion->contains($l)) {
                $this->assetExchangesScheduledForDeletion->remove($this->assetExchangesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AssetExchange $assetExchange The assetExchange object to add.
     */
    protected function doAddAssetExchange($assetExchange)
    {
        $this->collAssetExchanges[]= $assetExchange;
        $assetExchange->setToken($this);
    }

    /**
     * @param	AssetExchange $assetExchange The assetExchange object to remove.
     * @return Token The current object (for fluent API support)
     */
    public function removeAssetExchange($assetExchange)
    {
        if ($this->getAssetExchanges()->contains($assetExchange)) {
            $this->collAssetExchanges->remove($this->collAssetExchanges->search($assetExchange));
            if (null === $this->assetExchangesScheduledForDeletion) {
                $this->assetExchangesScheduledForDeletion = clone $this->collAssetExchanges;
                $this->assetExchangesScheduledForDeletion->clear();
            }
            $this->assetExchangesScheduledForDeletion[]= clone $assetExchange;
            $assetExchange->setToken(null);
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
    public function getAssetExchangesJoinAsset($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetExchangeQuery::create(null, $criteria);
        $query->joinWith('Asset', $join_behavior);

        return $this->getAssetExchanges($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AssetExchange[] List of AssetExchange objects
     */
    public function getAssetExchangesJoinExchange($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetExchangeQuery::create(null, $criteria);
        $query->joinWith('Exchange', $join_behavior);

        return $this->getAssetExchanges($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AssetExchange[] List of AssetExchange objects
     */
    public function getAssetExchangesJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetExchangeQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getAssetExchanges($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AssetExchange[] List of AssetExchange objects
     */
    public function getAssetExchangesJoinAuthyRelatedByIdCreation($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetExchangeQuery::create(null, $criteria);
        $query->joinWith('AuthyRelatedByIdCreation', $join_behavior);

        return $this->getAssetExchanges($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AssetExchange[] List of AssetExchange objects
     */
    public function getAssetExchangesJoinAuthyRelatedByIdModification($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssetExchangeQuery::create(null, $criteria);
        $query->joinWith('AuthyRelatedByIdModification', $join_behavior);

        return $this->getAssetExchanges($query, $con);
    }

    /**
     * Clears out the collTrades collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Token The current object (for fluent API support)
     * @see        addTrades()
     */
    public function clearTrades()
    {
        $this->collTrades = null; // important to set this to null since that means it is uninitialized
        $this->collTradesPartial = null;

        return $this;
    }

    /**
     * reset is the collTrades collection loaded partially
     *
     * @return void
     */
    public function resetPartialTrades($v = true)
    {
        $this->collTradesPartial = $v;
    }

    /**
     * Initializes the collTrades collection.
     *
     * By default this just sets the collTrades collection to an empty array (like clearcollTrades());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTrades($overrideExisting = true)
    {
        if (null !== $this->collTrades && !$overrideExisting) {
            return;
        }
        $this->collTrades = new PropelObjectCollection();
        $this->collTrades->setModel('Trade');
    }

    /**
     * Gets an array of Trade objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Token is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Trade[] List of Trade objects
     * @throws PropelException
     */
    public function getTrades($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collTradesPartial && !$this->isNew();
        if (null === $this->collTrades || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTrades) {
                // return empty collection
                $this->initTrades();
            } else {
                $collTrades = TradeQuery::create(null, $criteria)
                    ->filterByToken($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collTradesPartial && count($collTrades)) {
                      $this->initTrades(false);

                      foreach ($collTrades as $obj) {
                        if (false == $this->collTrades->contains($obj)) {
                          $this->collTrades->append($obj);
                        }
                      }

                      $this->collTradesPartial = true;
                    }

                    $collTrades->getInternalIterator()->rewind();

                    return $collTrades;
                }

                if ($partial && $this->collTrades) {
                    foreach ($this->collTrades as $obj) {
                        if ($obj->isNew()) {
                            $collTrades[] = $obj;
                        }
                    }
                }

                $this->collTrades = $collTrades;
                $this->collTradesPartial = false;
            }
        }

        return $this->collTrades;
    }

    /**
     * Sets a collection of Trade objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $trades A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Token The current object (for fluent API support)
     */
    public function setTrades(PropelCollection $trades, PropelPDO $con = null)
    {
        $tradesToDelete = $this->getTrades(new Criteria(), $con)->diff($trades);


        $this->tradesScheduledForDeletion = $tradesToDelete;

        foreach ($tradesToDelete as $tradeRemoved) {
            $tradeRemoved->setToken(null);
        }

        $this->collTrades = null;
        foreach ($trades as $trade) {
            $this->addTrade($trade);
        }

        $this->collTrades = $trades;
        $this->collTradesPartial = false;

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
    public function countTrades(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collTradesPartial && !$this->isNew();
        if (null === $this->collTrades || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTrades) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTrades());
            }
            $query = TradeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByToken($this)
                ->count($con);
        }

        return count($this->collTrades);
    }

    /**
     * Method called to associate a Trade object to this object
     * through the Trade foreign key attribute.
     *
     * @param    Trade $l Trade
     * @return Token The current object (for fluent API support)
     */
    public function addTrade(Trade $l)
    {
        if ($this->collTrades === null) {
            $this->initTrades();
            $this->collTradesPartial = true;
        }

        if (!in_array($l, $this->collTrades->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddTrade($l);

            if ($this->tradesScheduledForDeletion and $this->tradesScheduledForDeletion->contains($l)) {
                $this->tradesScheduledForDeletion->remove($this->tradesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Trade $trade The trade object to add.
     */
    protected function doAddTrade($trade)
    {
        $this->collTrades[]= $trade;
        $trade->setToken($this);
    }

    /**
     * @param	Trade $trade The trade object to remove.
     * @return Token The current object (for fluent API support)
     */
    public function removeTrade($trade)
    {
        if ($this->getTrades()->contains($trade)) {
            $this->collTrades->remove($this->collTrades->search($trade));
            if (null === $this->tradesScheduledForDeletion) {
                $this->tradesScheduledForDeletion = clone $this->collTrades;
                $this->tradesScheduledForDeletion->clear();
            }
            $this->tradesScheduledForDeletion[]= clone $trade;
            $trade->setToken(null);
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
    public function getTradesJoinExchange($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TradeQuery::create(null, $criteria);
        $query->joinWith('Exchange', $join_behavior);

        return $this->getTrades($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Trade[] List of Trade objects
     */
    public function getTradesJoinAsset($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TradeQuery::create(null, $criteria);
        $query->joinWith('Asset', $join_behavior);

        return $this->getTrades($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Trade[] List of Trade objects
     */
    public function getTradesJoinSymbol($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TradeQuery::create(null, $criteria);
        $query->joinWith('Symbol', $join_behavior);

        return $this->getTrades($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Trade[] List of Trade objects
     */
    public function getTradesJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TradeQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getTrades($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Trade[] List of Trade objects
     */
    public function getTradesJoinAuthyRelatedByIdCreation($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TradeQuery::create(null, $criteria);
        $query->joinWith('AuthyRelatedByIdCreation', $join_behavior);

        return $this->getTrades($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Trade[] List of Trade objects
     */
    public function getTradesJoinAuthyRelatedByIdModification($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TradeQuery::create(null, $criteria);
        $query->joinWith('AuthyRelatedByIdModification', $join_behavior);

        return $this->getTrades($query, $con);
    }

    /**
     * Clears out the collSymbols collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Token The current object (for fluent API support)
     * @see        addSymbols()
     */
    public function clearSymbols()
    {
        $this->collSymbols = null; // important to set this to null since that means it is uninitialized
        $this->collSymbolsPartial = null;

        return $this;
    }

    /**
     * reset is the collSymbols collection loaded partially
     *
     * @return void
     */
    public function resetPartialSymbols($v = true)
    {
        $this->collSymbolsPartial = $v;
    }

    /**
     * Initializes the collSymbols collection.
     *
     * By default this just sets the collSymbols collection to an empty array (like clearcollSymbols());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSymbols($overrideExisting = true)
    {
        if (null !== $this->collSymbols && !$overrideExisting) {
            return;
        }
        $this->collSymbols = new PropelObjectCollection();
        $this->collSymbols->setModel('Symbol');
    }

    /**
     * Gets an array of Symbol objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Token is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Symbol[] List of Symbol objects
     * @throws PropelException
     */
    public function getSymbols($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collSymbolsPartial && !$this->isNew();
        if (null === $this->collSymbols || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSymbols) {
                // return empty collection
                $this->initSymbols();
            } else {
                $collSymbols = SymbolQuery::create(null, $criteria)
                    ->filterByToken($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collSymbolsPartial && count($collSymbols)) {
                      $this->initSymbols(false);

                      foreach ($collSymbols as $obj) {
                        if (false == $this->collSymbols->contains($obj)) {
                          $this->collSymbols->append($obj);
                        }
                      }

                      $this->collSymbolsPartial = true;
                    }

                    $collSymbols->getInternalIterator()->rewind();

                    return $collSymbols;
                }

                if ($partial && $this->collSymbols) {
                    foreach ($this->collSymbols as $obj) {
                        if ($obj->isNew()) {
                            $collSymbols[] = $obj;
                        }
                    }
                }

                $this->collSymbols = $collSymbols;
                $this->collSymbolsPartial = false;
            }
        }

        return $this->collSymbols;
    }

    /**
     * Sets a collection of Symbol objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $symbols A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Token The current object (for fluent API support)
     */
    public function setSymbols(PropelCollection $symbols, PropelPDO $con = null)
    {
        $symbolsToDelete = $this->getSymbols(new Criteria(), $con)->diff($symbols);


        $this->symbolsScheduledForDeletion = $symbolsToDelete;

        foreach ($symbolsToDelete as $symbolRemoved) {
            $symbolRemoved->setToken(null);
        }

        $this->collSymbols = null;
        foreach ($symbols as $symbol) {
            $this->addSymbol($symbol);
        }

        $this->collSymbols = $symbols;
        $this->collSymbolsPartial = false;

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
    public function countSymbols(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collSymbolsPartial && !$this->isNew();
        if (null === $this->collSymbols || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSymbols) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSymbols());
            }
            $query = SymbolQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByToken($this)
                ->count($con);
        }

        return count($this->collSymbols);
    }

    /**
     * Method called to associate a Symbol object to this object
     * through the Symbol foreign key attribute.
     *
     * @param    Symbol $l Symbol
     * @return Token The current object (for fluent API support)
     */
    public function addSymbol(Symbol $l)
    {
        if ($this->collSymbols === null) {
            $this->initSymbols();
            $this->collSymbolsPartial = true;
        }

        if (!in_array($l, $this->collSymbols->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddSymbol($l);

            if ($this->symbolsScheduledForDeletion and $this->symbolsScheduledForDeletion->contains($l)) {
                $this->symbolsScheduledForDeletion->remove($this->symbolsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Symbol $symbol The symbol object to add.
     */
    protected function doAddSymbol($symbol)
    {
        $this->collSymbols[]= $symbol;
        $symbol->setToken($this);
    }

    /**
     * @param	Symbol $symbol The symbol object to remove.
     * @return Token The current object (for fluent API support)
     */
    public function removeSymbol($symbol)
    {
        if ($this->getSymbols()->contains($symbol)) {
            $this->collSymbols->remove($this->collSymbols->search($symbol));
            if (null === $this->symbolsScheduledForDeletion) {
                $this->symbolsScheduledForDeletion = clone $this->collSymbols;
                $this->symbolsScheduledForDeletion->clear();
            }
            $this->symbolsScheduledForDeletion[]= clone $symbol;
            $symbol->setToken(null);
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
    public function getSymbolsJoinAuthyGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = SymbolQuery::create(null, $criteria);
        $query->joinWith('AuthyGroup', $join_behavior);

        return $this->getSymbols($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Symbol[] List of Symbol objects
     */
    public function getSymbolsJoinAuthyRelatedByIdCreation($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = SymbolQuery::create(null, $criteria);
        $query->joinWith('AuthyRelatedByIdCreation', $join_behavior);

        return $this->getSymbols($query, $con);
    }


    /**

     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Symbol[] List of Symbol objects
     */
    public function getSymbolsJoinAuthyRelatedByIdModification($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = SymbolQuery::create(null, $criteria);
        $query->joinWith('AuthyRelatedByIdModification', $join_behavior);

        return $this->getSymbols($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_token = null;
        $this->name = null;
        $this->ticker = null;
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
            if ($this->collAssets) {
                foreach ($this->collAssets as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAssetExchanges) {
                foreach ($this->collAssetExchanges as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTrades) {
                foreach ($this->collTrades as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSymbols) {
                foreach ($this->collSymbols as $o) {
                    $o->clearAllReferences($deep);
                }
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

        if ($this->collAssets instanceof PropelCollection) {
            $this->collAssets->clearIterator();
        }
        $this->collAssets = null;
        if ($this->collAssetExchanges instanceof PropelCollection) {
            $this->collAssetExchanges->clearIterator();
        }
        $this->collAssetExchanges = null;
        if ($this->collTrades instanceof PropelCollection) {
            $this->collTrades->clearIterator();
        }
        $this->collTrades = null;
        if ($this->collSymbols instanceof PropelCollection) {
            $this->collSymbols->clearIterator();
        }
        $this->collSymbols = null;
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
        return (string) $this->exportTo(TokenPeer::DEFAULT_STRING_FORMAT);
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
     * @return     Token The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = TokenPeer::DATE_MODIFICATION;

        return $this;
    }

}
