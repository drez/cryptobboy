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
use App\AssetQuery;
use App\Authy;
use App\AuthyGroup;
use App\AuthyGroupQuery;
use App\AuthyQuery;
use App\Exchange;
use App\ExchangeQuery;
use App\Symbol;
use App\SymbolQuery;
use App\Token;
use App\TokenQuery;
use App\Trade;
use App\TradePeer;
use App\TradeQuery;

/**
 * Base class that represents a row from the 'trade' table.
 *
 * Trade
 *
 * @package    propel.generator..om
 */
abstract class BaseTrade extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'App\\TradePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        TradePeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_trade field.
     * @var        int
     */
    protected $id_trade;

    /**
     * The value for the start_avg field.
     * @var        int
     */
    protected $start_avg;

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
     * The value for the id_asset field.
     * @var        int
     */
    protected $id_asset;

    /**
     * The value for the id_symbol field.
     * @var        int
     */
    protected $id_symbol;

    /**
     * The value for the date field.
     * @var        string
     */
    protected $date;

    /**
     * The value for the qty field.
     * @var        string
     */
    protected $qty;

    /**
     * The value for the gross_usd field.
     * @var        string
     */
    protected $gross_usd;

    /**
     * The value for the commission field.
     * @var        string
     */
    protected $commission;

    /**
     * The value for the commission_asset field.
     * @var        int
     */
    protected $commission_asset;

    /**
     * The value for the order_id field.
     * @var        string
     */
    protected $order_id;

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
     * @var        Exchange
     */
    protected $aExchange;

    /**
     * @var        Asset
     */
    protected $aAsset;

    /**
     * @var        Symbol
     */
    protected $aSymbol;

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
     * Get the [id_trade] column value.
     *
     * @return int
     */
    public function getIdTrade()
    {

        return $this->id_trade;
    }

    /**
     * @Field()
     * Get the [start_avg] column value.
     * Avg
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getStartAvg()
    {
        if (null === $this->start_avg) {
            return null;
        }
        $valueSet = TradePeer::getValueSet(TradePeer::START_AVG);
        if (!isset($valueSet[$this->start_avg])) {
            throw new PropelException('Unknown stored enum key: ' . $this->start_avg);
        }

        return $valueSet[$this->start_avg];
    }

    /**
     * @Field()
     * Get the [type] column value.
     * State
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getType()
    {
        if (null === $this->type) {
            return null;
        }
        $valueSet = TradePeer::getValueSet(TradePeer::TYPE);
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
     * Get the [id_symbol] column value.
     * Trading pair
     * @return int
     */
    public function getIdSymbol()
    {

        return $this->id_symbol;
    }

    /**
     * @Field()
     * Get the [optionally formatted] temporal [date] column value.
     * Date
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDate($format = 'Y-m-d H:i:s')
    {
        if ($this->date === null) {
            return null;
        }

        if ($this->date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date, true), $x);
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
     * Get the [qty] column value.
     * Qty
     * @return string
     */
    public function getQty()
    {

        return $this->qty;
    }

    /**
     * @Field()
     * Get the [gross_usd] column value.
     * Price
     * @return string
     */
    public function getGrossUsd()
    {

        return $this->gross_usd;
    }

    /**
     * @Field()
     * Get the [commission] column value.
     * Commission
     * @return string
     */
    public function getCommission()
    {

        return $this->commission;
    }

    /**
     * @Field()
     * Get the [commission_asset] column value.
     * commissionAsset
     * @return int
     */
    public function getCommissionAsset()
    {

        return $this->commission_asset;
    }

    /**
     * @Field()
     * Get the [order_id] column value.
     *
     * @return string
     */
    public function getOrderId()
    {

        return $this->order_id;
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
     * Set the value of [id_trade] column.
     *
     * @param  int $v new value
     * @return Trade The current object (for fluent API support)
     */
    public function setIdTrade($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_trade !== $v) {
            $this->id_trade = $v;
            $this->modifiedColumns[] = TradePeer::ID_TRADE;
        }


        return $this;
    } // setIdTrade()

    /**
     * Set the value of [start_avg] column.
     * Avg
     * @param  int $v new value
     * @return Trade The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setStartAvg($v)
    {
        if ($v !== null) {
            $valueSet = TradePeer::getValueSet(TradePeer::START_AVG);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->start_avg !== $v) {
            $this->start_avg = $v;
            $this->modifiedColumns[] = TradePeer::START_AVG;
        }


        return $this;
    } // setStartAvg()

    /**
     * Set the value of [type] column.
     * State
     * @param  int $v new value
     * @return Trade The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setType($v)
    {
        if ($v !== null) {
            $valueSet = TradePeer::getValueSet(TradePeer::TYPE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[] = TradePeer::TYPE;
        }


        return $this;
    } // setType()

    /**
     * Set the value of [id_exchange] column.
     * Exchange
     * @param  int $v new value
     * @return Trade The current object (for fluent API support)
     */
    public function setIdExchange($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_exchange !== $v) {
            $this->id_exchange = $v;
            $this->modifiedColumns[] = TradePeer::ID_EXCHANGE;
        }

        if ($this->aExchange !== null && $this->aExchange->getIdExchange() !== $v) {
            $this->aExchange = null;
        }


        return $this;
    } // setIdExchange()

    /**
     * Set the value of [id_asset] column.
     *
     * @param  int $v new value
     * @return Trade The current object (for fluent API support)
     */
    public function setIdAsset($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_asset !== $v) {
            $this->id_asset = $v;
            $this->modifiedColumns[] = TradePeer::ID_ASSET;
        }

        if ($this->aAsset !== null && $this->aAsset->getIdAsset() !== $v) {
            $this->aAsset = null;
        }


        return $this;
    } // setIdAsset()

    /**
     * Set the value of [id_symbol] column.
     * Trading pair
     * @param  int $v new value
     * @return Trade The current object (for fluent API support)
     */
    public function setIdSymbol($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_symbol !== $v) {
            $this->id_symbol = $v;
            $this->modifiedColumns[] = TradePeer::ID_SYMBOL;
        }

        if ($this->aSymbol !== null && $this->aSymbol->getIdSymbol() !== $v) {
            $this->aSymbol = null;
        }


        return $this;
    } // setIdSymbol()

    /**
     * Sets the value of [date] column to a normalized version of the date/time value specified.
     * Date
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Trade The current object (for fluent API support)
     */
    public function setDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date !== null || $dt !== null) {
            $currentDateAsString = ($this->date !== null && $tmpDt = new DateTime($this->date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date = $newDateAsString;
                $this->modifiedColumns[] = TradePeer::DATE;
            }
        } // if either are not null


        return $this;
    } // setDate()

    /**
     * Set the value of [qty] column.
     * Qty
     * @param  string $v new value
     * @return Trade The current object (for fluent API support)
     */
    public function setQty($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->qty !== $v) {
            $this->qty = $v;
            $this->modifiedColumns[] = TradePeer::QTY;
        }


        return $this;
    } // setQty()

    /**
     * Set the value of [gross_usd] column.
     * Price
     * @param  string $v new value
     * @return Trade The current object (for fluent API support)
     */
    public function setGrossUsd($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->gross_usd !== $v) {
            $this->gross_usd = $v;
            $this->modifiedColumns[] = TradePeer::GROSS_USD;
        }


        return $this;
    } // setGrossUsd()

    /**
     * Set the value of [commission] column.
     * Commission
     * @param  string $v new value
     * @return Trade The current object (for fluent API support)
     */
    public function setCommission($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->commission !== $v) {
            $this->commission = $v;
            $this->modifiedColumns[] = TradePeer::COMMISSION;
        }


        return $this;
    } // setCommission()

    /**
     * Set the value of [commission_asset] column.
     * commissionAsset
     * @param  int $v new value
     * @return Trade The current object (for fluent API support)
     */
    public function setCommissionAsset($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->commission_asset !== $v) {
            $this->commission_asset = $v;
            $this->modifiedColumns[] = TradePeer::COMMISSION_ASSET;
        }

        if ($this->aToken !== null && $this->aToken->getIdToken() !== $v) {
            $this->aToken = null;
        }


        return $this;
    } // setCommissionAsset()

    /**
     * Set the value of [order_id] column.
     *
     * @param  string $v new value
     * @return Trade The current object (for fluent API support)
     */
    public function setOrderId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->order_id !== $v) {
            $this->order_id = $v;
            $this->modifiedColumns[] = TradePeer::ORDER_ID;
        }


        return $this;
    } // setOrderId()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Trade The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_creation !== null || $dt !== null) {
            $currentDateAsString = ($this->date_creation !== null && $tmpDt = new DateTime($this->date_creation)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date_creation = $newDateAsString;
                $this->modifiedColumns[] = TradePeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Trade The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_modification !== null || $dt !== null) {
            $currentDateAsString = ($this->date_modification !== null && $tmpDt = new DateTime($this->date_modification)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date_modification = $newDateAsString;
                $this->modifiedColumns[] = TradePeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [id_group_creation] column.
     *
     * @param  int $v new value
     * @return Trade The current object (for fluent API support)
     */
    public function setIdGroupCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_group_creation !== $v) {
            $this->id_group_creation = $v;
            $this->modifiedColumns[] = TradePeer::ID_GROUP_CREATION;
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
     * @return Trade The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = TradePeer::ID_CREATION;
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
     * @return Trade The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = TradePeer::ID_MODIFICATION;
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

            $this->id_trade = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->start_avg = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->type = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->id_exchange = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->id_asset = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->id_symbol = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->date = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->qty = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->gross_usd = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->commission = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->commission_asset = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
            $this->order_id = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->date_creation = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->date_modification = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
            $this->id_group_creation = ($row[$startcol + 14] !== null) ? (int) $row[$startcol + 14] : null;
            $this->id_creation = ($row[$startcol + 15] !== null) ? (int) $row[$startcol + 15] : null;
            $this->id_modification = ($row[$startcol + 16] !== null) ? (int) $row[$startcol + 16] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 17; // 17 = TradePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Trade object", $e);
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

        if ($this->aExchange !== null && $this->id_exchange !== $this->aExchange->getIdExchange()) {
            $this->aExchange = null;
        }
        if ($this->aAsset !== null && $this->id_asset !== $this->aAsset->getIdAsset()) {
            $this->aAsset = null;
        }
        if ($this->aSymbol !== null && $this->id_symbol !== $this->aSymbol->getIdSymbol()) {
            $this->aSymbol = null;
        }
        if ($this->aToken !== null && $this->commission_asset !== $this->aToken->getIdToken()) {
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
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = TradePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aExchange = null;
            $this->aAsset = null;
            $this->aSymbol = null;
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
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = TradeQuery::create()
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
            $con = Propel::getConnection(TradePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                TradePeer::addInstanceToPool($this);
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

            if ($this->aExchange !== null) {
                if ($this->aExchange->isModified() || $this->aExchange->isNew()) {
                    $affectedRows += $this->aExchange->save($con);
                }
                $this->setExchange($this->aExchange);
            }

            if ($this->aAsset !== null) {
                if ($this->aAsset->isModified() || $this->aAsset->isNew()) {
                    $affectedRows += $this->aAsset->save($con);
                }
                $this->setAsset($this->aAsset);
            }

            if ($this->aSymbol !== null) {
                if ($this->aSymbol->isModified() || $this->aSymbol->isNew()) {
                    $affectedRows += $this->aSymbol->save($con);
                }
                $this->setSymbol($this->aSymbol);
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

        $this->modifiedColumns[] = TradePeer::ID_TRADE;
        if (null !== $this->id_trade) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TradePeer::ID_TRADE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TradePeer::ID_TRADE)) {
            $modifiedColumns[':p' . $index++]  = '`id_trade`';
        }
        if ($this->isColumnModified(TradePeer::START_AVG)) {
            $modifiedColumns[':p' . $index++]  = '`start_avg`';
        }
        if ($this->isColumnModified(TradePeer::TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`type`';
        }
        if ($this->isColumnModified(TradePeer::ID_EXCHANGE)) {
            $modifiedColumns[':p' . $index++]  = '`id_exchange`';
        }
        if ($this->isColumnModified(TradePeer::ID_ASSET)) {
            $modifiedColumns[':p' . $index++]  = '`id_asset`';
        }
        if ($this->isColumnModified(TradePeer::ID_SYMBOL)) {
            $modifiedColumns[':p' . $index++]  = '`id_symbol`';
        }
        if ($this->isColumnModified(TradePeer::DATE)) {
            $modifiedColumns[':p' . $index++]  = '`date`';
        }
        if ($this->isColumnModified(TradePeer::QTY)) {
            $modifiedColumns[':p' . $index++]  = '`qty`';
        }
        if ($this->isColumnModified(TradePeer::GROSS_USD)) {
            $modifiedColumns[':p' . $index++]  = '`gross_usd`';
        }
        if ($this->isColumnModified(TradePeer::COMMISSION)) {
            $modifiedColumns[':p' . $index++]  = '`commission`';
        }
        if ($this->isColumnModified(TradePeer::COMMISSION_ASSET)) {
            $modifiedColumns[':p' . $index++]  = '`commission_asset`';
        }
        if ($this->isColumnModified(TradePeer::ORDER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`order_id`';
        }
        if ($this->isColumnModified(TradePeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(TradePeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(TradePeer::ID_GROUP_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_group_creation`';
        }
        if ($this->isColumnModified(TradePeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(TradePeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `trade` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_trade`':
                        $stmt->bindValue($identifier, $this->id_trade, PDO::PARAM_INT);
                        break;
                    case '`start_avg`':
                        $stmt->bindValue($identifier, $this->start_avg, PDO::PARAM_INT);
                        break;
                    case '`type`':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_INT);
                        break;
                    case '`id_exchange`':
                        $stmt->bindValue($identifier, $this->id_exchange, PDO::PARAM_INT);
                        break;
                    case '`id_asset`':
                        $stmt->bindValue($identifier, $this->id_asset, PDO::PARAM_INT);
                        break;
                    case '`id_symbol`':
                        $stmt->bindValue($identifier, $this->id_symbol, PDO::PARAM_INT);
                        break;
                    case '`date`':
                        $stmt->bindValue($identifier, $this->date, PDO::PARAM_STR);
                        break;
                    case '`qty`':
                        $stmt->bindValue($identifier, $this->qty, PDO::PARAM_STR);
                        break;
                    case '`gross_usd`':
                        $stmt->bindValue($identifier, $this->gross_usd, PDO::PARAM_STR);
                        break;
                    case '`commission`':
                        $stmt->bindValue($identifier, $this->commission, PDO::PARAM_STR);
                        break;
                    case '`commission_asset`':
                        $stmt->bindValue($identifier, $this->commission_asset, PDO::PARAM_INT);
                        break;
                    case '`order_id`':
                        $stmt->bindValue($identifier, $this->order_id, PDO::PARAM_STR);
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
        $this->setIdTrade($pk);

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

            if ($this->aExchange !== null) {
                if (!$this->aExchange->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aExchange->getValidationFailures());
                }
            }

            if ($this->aAsset !== null) {
                if (!$this->aAsset->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAsset->getValidationFailures());
                }
            }

            if ($this->aSymbol !== null) {
                if (!$this->aSymbol->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aSymbol->getValidationFailures());
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


            if (($retval = TradePeer::doValidate($this, $columns)) !== true) {
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
        $pos = TradePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
        if (isset($alreadyDumpedObjects['Trade'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Trade'][$this->getPrimaryKey()] = true;
        $keys = TradePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdTrade(),
            $keys[1] => $this->getStartAvg(),
            $keys[2] => $this->getType(),
            $keys[3] => $this->getIdExchange(),
            $keys[4] => $this->getIdAsset(),
            $keys[5] => $this->getIdSymbol(),
            $keys[6] => $this->getDate(),
            $keys[7] => $this->getQty(),
            $keys[8] => $this->getGrossUsd(),
            $keys[9] => $this->getCommission(),
            $keys[10] => $this->getCommissionAsset(),
            $keys[11] => $this->getOrderId(),
            $keys[12] => $this->getDateCreation(),
            $keys[13] => $this->getDateModification(),
            $keys[14] => $this->getIdGroupCreation(),
            $keys[15] => $this->getIdCreation(),
            $keys[16] => $this->getIdModification(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aExchange) {
                $result['Exchange'] = $this->aExchange->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAsset) {
                $result['Asset'] = $this->aAsset->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSymbol) {
                $result['Symbol'] = $this->aSymbol->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = TradePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setIdTrade($value);
                break;
            case 1:
                $valueSet = TradePeer::getValueSet(TradePeer::START_AVG);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setStartAvg($value);
                break;
            case 2:
                $valueSet = TradePeer::getValueSet(TradePeer::TYPE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setType($value);
                break;
            case 3:
                $this->setIdExchange($value);
                break;
            case 4:
                $this->setIdAsset($value);
                break;
            case 5:
                $this->setIdSymbol($value);
                break;
            case 6:
                $this->setDate($value);
                break;
            case 7:
                $this->setQty($value);
                break;
            case 8:
                $this->setGrossUsd($value);
                break;
            case 9:
                $this->setCommission($value);
                break;
            case 10:
                $this->setCommissionAsset($value);
                break;
            case 11:
                $this->setOrderId($value);
                break;
            case 12:
                $this->setDateCreation($value);
                break;
            case 13:
                $this->setDateModification($value);
                break;
            case 14:
                $this->setIdGroupCreation($value);
                break;
            case 15:
                $this->setIdCreation($value);
                break;
            case 16:
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
        $keys = TradePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdTrade($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setStartAvg($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setType($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setIdExchange($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setIdAsset($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setIdSymbol($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setDate($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setQty($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setGrossUsd($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setCommission($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setCommissionAsset($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setOrderId($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setDateCreation($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setDateModification($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setIdGroupCreation($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setIdCreation($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setIdModification($arr[$keys[16]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(TradePeer::DATABASE_NAME);

        if ($this->isColumnModified(TradePeer::ID_TRADE)) $criteria->add(TradePeer::ID_TRADE, $this->id_trade);
        if ($this->isColumnModified(TradePeer::START_AVG)) $criteria->add(TradePeer::START_AVG, $this->start_avg);
        if ($this->isColumnModified(TradePeer::TYPE)) $criteria->add(TradePeer::TYPE, $this->type);
        if ($this->isColumnModified(TradePeer::ID_EXCHANGE)) $criteria->add(TradePeer::ID_EXCHANGE, $this->id_exchange);
        if ($this->isColumnModified(TradePeer::ID_ASSET)) $criteria->add(TradePeer::ID_ASSET, $this->id_asset);
        if ($this->isColumnModified(TradePeer::ID_SYMBOL)) $criteria->add(TradePeer::ID_SYMBOL, $this->id_symbol);
        if ($this->isColumnModified(TradePeer::DATE)) $criteria->add(TradePeer::DATE, $this->date);
        if ($this->isColumnModified(TradePeer::QTY)) $criteria->add(TradePeer::QTY, $this->qty);
        if ($this->isColumnModified(TradePeer::GROSS_USD)) $criteria->add(TradePeer::GROSS_USD, $this->gross_usd);
        if ($this->isColumnModified(TradePeer::COMMISSION)) $criteria->add(TradePeer::COMMISSION, $this->commission);
        if ($this->isColumnModified(TradePeer::COMMISSION_ASSET)) $criteria->add(TradePeer::COMMISSION_ASSET, $this->commission_asset);
        if ($this->isColumnModified(TradePeer::ORDER_ID)) $criteria->add(TradePeer::ORDER_ID, $this->order_id);
        if ($this->isColumnModified(TradePeer::DATE_CREATION)) $criteria->add(TradePeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(TradePeer::DATE_MODIFICATION)) $criteria->add(TradePeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(TradePeer::ID_GROUP_CREATION)) $criteria->add(TradePeer::ID_GROUP_CREATION, $this->id_group_creation);
        if ($this->isColumnModified(TradePeer::ID_CREATION)) $criteria->add(TradePeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(TradePeer::ID_MODIFICATION)) $criteria->add(TradePeer::ID_MODIFICATION, $this->id_modification);

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
        $criteria = new Criteria(TradePeer::DATABASE_NAME);
        $criteria->add(TradePeer::ID_TRADE, $this->id_trade);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdTrade();
    }

    /**
     * Generic method to set the primary key (id_trade column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdTrade($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdTrade();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Trade (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setStartAvg($this->getStartAvg());
        $copyObj->setType($this->getType());
        $copyObj->setIdExchange($this->getIdExchange());
        $copyObj->setIdAsset($this->getIdAsset());
        $copyObj->setIdSymbol($this->getIdSymbol());
        $copyObj->setDate($this->getDate());
        $copyObj->setQty($this->getQty());
        $copyObj->setGrossUsd($this->getGrossUsd());
        $copyObj->setCommission($this->getCommission());
        $copyObj->setCommissionAsset($this->getCommissionAsset());
        $copyObj->setOrderId($this->getOrderId());
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
            $copyObj->setIdTrade(NULL); // this is a auto-increment column, so set to default value
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
     * @return Trade Clone of current object.
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
     * @return TradePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new TradePeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Exchange object.
     *
     * @param                  Exchange $v
     * @return Trade The current object (for fluent API support)
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
            $v->addTrade($this);
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
                $this->aExchange->addTrades($this);
             */
        }

        return $this->aExchange;
    }

    /**
     * Declares an association between this object and a Asset object.
     *
     * @param                  Asset $v
     * @return Trade The current object (for fluent API support)
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
            $v->addTrade($this);
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
                $this->aAsset->addTrades($this);
             */
        }

        return $this->aAsset;
    }

    /**
     * Declares an association between this object and a Symbol object.
     *
     * @param                  Symbol $v
     * @return Trade The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSymbol(Symbol $v = null)
    {
        if ($v === null) {
            $this->setIdSymbol(NULL);
        } else {
            $this->setIdSymbol($v->getIdSymbol());
        }

        $this->aSymbol = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Symbol object, it will not be re-added.
        if ($v !== null) {
            $v->addTrade($this);
        }


        return $this;
    }


    /**
     * Get the associated Symbol object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Symbol The associated Symbol object.
     * @throws PropelException
     */
    public function getSymbol(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aSymbol === null && ($this->id_symbol !== null) && $doQuery) {
            $this->aSymbol = SymbolQuery::create()->findPk($this->id_symbol, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSymbol->addTrades($this);
             */
        }

        return $this->aSymbol;
    }

    /**
     * Declares an association between this object and a Token object.
     *
     * @param                  Token $v
     * @return Trade The current object (for fluent API support)
     * @throws PropelException
     */
    public function setToken(Token $v = null)
    {
        if ($v === null) {
            $this->setCommissionAsset(NULL);
        } else {
            $this->setCommissionAsset($v->getIdToken());
        }

        $this->aToken = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Token object, it will not be re-added.
        if ($v !== null) {
            $v->addTrade($this);
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
        if ($this->aToken === null && ($this->commission_asset !== null) && $doQuery) {
            $this->aToken = TokenQuery::create()->findPk($this->commission_asset, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aToken->addTrades($this);
             */
        }

        return $this->aToken;
    }

    /**
     * Declares an association between this object and a AuthyGroup object.
     *
     * @param                  AuthyGroup $v
     * @return Trade The current object (for fluent API support)
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
            $v->addTrade($this);
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
                $this->aAuthyGroup->addTrades($this);
             */
        }

        return $this->aAuthyGroup;
    }

    /**
     * Declares an association between this object and a Authy object.
     *
     * @param                  Authy $v
     * @return Trade The current object (for fluent API support)
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
            $v->addTradeRelatedByIdCreation($this);
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
                $this->aAuthyRelatedByIdCreation->addTradesRelatedByIdCreation($this);
             */
        }

        return $this->aAuthyRelatedByIdCreation;
    }

    /**
     * Declares an association between this object and a Authy object.
     *
     * @param                  Authy $v
     * @return Trade The current object (for fluent API support)
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
            $v->addTradeRelatedByIdModification($this);
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
                $this->aAuthyRelatedByIdModification->addTradesRelatedByIdModification($this);
             */
        }

        return $this->aAuthyRelatedByIdModification;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_trade = null;
        $this->start_avg = null;
        $this->type = null;
        $this->id_exchange = null;
        $this->id_asset = null;
        $this->id_symbol = null;
        $this->date = null;
        $this->qty = null;
        $this->gross_usd = null;
        $this->commission = null;
        $this->commission_asset = null;
        $this->order_id = null;
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
            if ($this->aExchange instanceof Persistent) {
              $this->aExchange->clearAllReferences($deep);
            }
            if ($this->aAsset instanceof Persistent) {
              $this->aAsset->clearAllReferences($deep);
            }
            if ($this->aSymbol instanceof Persistent) {
              $this->aSymbol->clearAllReferences($deep);
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

        $this->aExchange = null;
        $this->aAsset = null;
        $this->aSymbol = null;
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
        return (string) $this->exportTo(TradePeer::DEFAULT_STRING_FORMAT);
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
     * @return     Trade The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = TradePeer::DATE_MODIFICATION;

        return $this;
    }

}
