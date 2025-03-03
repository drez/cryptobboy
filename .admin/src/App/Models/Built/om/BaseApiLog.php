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
use App\ApiLog;
use App\ApiLogPeer;
use App\ApiLogQuery;
use App\ApiRbac;
use App\ApiRbacQuery;
use App\Authy;
use App\AuthyQuery;

/**
 * Base class that represents a row from the 'api_log' table.
 *
 * API log
 *
 * @package    propel.generator..om
 */
abstract class BaseApiLog extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'App\\ApiLogPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ApiLogPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_api_log field.
     * @var        int
     */
    protected $id_api_log;

    /**
     * The value for the id_api_rbac field.
     * @var        int
     */
    protected $id_api_rbac;

    /**
     * The value for the id_authy field.
     * @var        int
     */
    protected $id_authy;

    /**
     * The value for the time field.
     * @var        string
     */
    protected $time;

    /**
     * @var        ApiRbac
     */
    protected $aApiRbac;

    /**
     * @var        Authy
     */
    protected $aAuthy;

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
     * Get the [id_api_log] column value.
     *
     * @return int
     */
    public function getIdApiLog()
    {

        return $this->id_api_log;
    }

    /**
     * @Field()
     * Get the [id_api_rbac] column value.
     * Rule
     * @return int
     */
    public function getIdApiRbac()
    {

        return $this->id_api_rbac;
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
     * Get the [optionally formatted] temporal [time] column value.
     * Time
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getTime($format = 'Y-m-d H:i:s')
    {
        if ($this->time === null) {
            return null;
        }

        if ($this->time === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->time);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->time, true), $x);
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
     * Set the value of [id_api_log] column.
     *
     * @param  int $v new value
     * @return ApiLog The current object (for fluent API support)
     */
    public function setIdApiLog($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_api_log !== $v) {
            $this->id_api_log = $v;
            $this->modifiedColumns[] = ApiLogPeer::ID_API_LOG;
        }


        return $this;
    } // setIdApiLog()

    /**
     * Set the value of [id_api_rbac] column.
     * Rule
     * @param  int $v new value
     * @return ApiLog The current object (for fluent API support)
     */
    public function setIdApiRbac($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_api_rbac !== $v) {
            $this->id_api_rbac = $v;
            $this->modifiedColumns[] = ApiLogPeer::ID_API_RBAC;
        }

        if ($this->aApiRbac !== null && $this->aApiRbac->getIdApiRbac() !== $v) {
            $this->aApiRbac = null;
        }


        return $this;
    } // setIdApiRbac()

    /**
     * Set the value of [id_authy] column.
     *
     * @param  int $v new value
     * @return ApiLog The current object (for fluent API support)
     */
    public function setIdAuthy($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_authy !== $v) {
            $this->id_authy = $v;
            $this->modifiedColumns[] = ApiLogPeer::ID_AUTHY;
        }

        if ($this->aAuthy !== null && $this->aAuthy->getIdAuthy() !== $v) {
            $this->aAuthy = null;
        }


        return $this;
    } // setIdAuthy()

    /**
     * Sets the value of [time] column to a normalized version of the date/time value specified.
     * Time
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return ApiLog The current object (for fluent API support)
     */
    public function setTime($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->time !== null || $dt !== null) {
            $currentDateAsString = ($this->time !== null && $tmpDt = new DateTime($this->time)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->time = $newDateAsString;
                $this->modifiedColumns[] = ApiLogPeer::TIME;
            }
        } // if either are not null


        return $this;
    } // setTime()

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

            $this->id_api_log = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->id_api_rbac = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->id_authy = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->time = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 4; // 4 = ApiLogPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating ApiLog object", $e);
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

        if ($this->aApiRbac !== null && $this->id_api_rbac !== $this->aApiRbac->getIdApiRbac()) {
            $this->aApiRbac = null;
        }
        if ($this->aAuthy !== null && $this->id_authy !== $this->aAuthy->getIdAuthy()) {
            $this->aAuthy = null;
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
            $con = Propel::getConnection(ApiLogPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ApiLogPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aApiRbac = null;
            $this->aAuthy = null;
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
            $con = Propel::getConnection(ApiLogPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ApiLogQuery::create()
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
            $con = Propel::getConnection(ApiLogPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ApiLogPeer::addInstanceToPool($this);
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

            if ($this->aApiRbac !== null) {
                if ($this->aApiRbac->isModified() || $this->aApiRbac->isNew()) {
                    $affectedRows += $this->aApiRbac->save($con);
                }
                $this->setApiRbac($this->aApiRbac);
            }

            if ($this->aAuthy !== null) {
                if ($this->aAuthy->isModified() || $this->aAuthy->isNew()) {
                    $affectedRows += $this->aAuthy->save($con);
                }
                $this->setAuthy($this->aAuthy);
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

        $this->modifiedColumns[] = ApiLogPeer::ID_API_LOG;
        if (null !== $this->id_api_log) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ApiLogPeer::ID_API_LOG . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ApiLogPeer::ID_API_LOG)) {
            $modifiedColumns[':p' . $index++]  = '`id_api_log`';
        }
        if ($this->isColumnModified(ApiLogPeer::ID_API_RBAC)) {
            $modifiedColumns[':p' . $index++]  = '`id_api_rbac`';
        }
        if ($this->isColumnModified(ApiLogPeer::ID_AUTHY)) {
            $modifiedColumns[':p' . $index++]  = '`id_authy`';
        }
        if ($this->isColumnModified(ApiLogPeer::TIME)) {
            $modifiedColumns[':p' . $index++]  = '`time`';
        }

        $sql = sprintf(
            'INSERT INTO `api_log` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_api_log`':
                        $stmt->bindValue($identifier, $this->id_api_log, PDO::PARAM_INT);
                        break;
                    case '`id_api_rbac`':
                        $stmt->bindValue($identifier, $this->id_api_rbac, PDO::PARAM_INT);
                        break;
                    case '`id_authy`':
                        $stmt->bindValue($identifier, $this->id_authy, PDO::PARAM_INT);
                        break;
                    case '`time`':
                        $stmt->bindValue($identifier, $this->time, PDO::PARAM_STR);
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
        $this->setIdApiLog($pk);

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

            if ($this->aApiRbac !== null) {
                if (!$this->aApiRbac->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aApiRbac->getValidationFailures());
                }
            }

            if ($this->aAuthy !== null) {
                if (!$this->aAuthy->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAuthy->getValidationFailures());
                }
            }


            if (($retval = ApiLogPeer::doValidate($this, $columns)) !== true) {
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
        $pos = ApiLogPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
        if (isset($alreadyDumpedObjects['ApiLog'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ApiLog'][$this->getPrimaryKey()] = true;
        $keys = ApiLogPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdApiLog(),
            $keys[1] => $this->getIdApiRbac(),
            $keys[2] => $this->getIdAuthy(),
            $keys[3] => $this->getTime(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aApiRbac) {
                $result['ApiRbac'] = $this->aApiRbac->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAuthy) {
                $result['Authy'] = $this->aAuthy->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = ApiLogPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setIdApiLog($value);
                break;
            case 1:
                $this->setIdApiRbac($value);
                break;
            case 2:
                $this->setIdAuthy($value);
                break;
            case 3:
                $this->setTime($value);
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
        $keys = ApiLogPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdApiLog($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setIdApiRbac($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setIdAuthy($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setTime($arr[$keys[3]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ApiLogPeer::DATABASE_NAME);

        if ($this->isColumnModified(ApiLogPeer::ID_API_LOG)) $criteria->add(ApiLogPeer::ID_API_LOG, $this->id_api_log);
        if ($this->isColumnModified(ApiLogPeer::ID_API_RBAC)) $criteria->add(ApiLogPeer::ID_API_RBAC, $this->id_api_rbac);
        if ($this->isColumnModified(ApiLogPeer::ID_AUTHY)) $criteria->add(ApiLogPeer::ID_AUTHY, $this->id_authy);
        if ($this->isColumnModified(ApiLogPeer::TIME)) $criteria->add(ApiLogPeer::TIME, $this->time);

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
        $criteria = new Criteria(ApiLogPeer::DATABASE_NAME);
        $criteria->add(ApiLogPeer::ID_API_LOG, $this->id_api_log);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdApiLog();
    }

    /**
     * Generic method to set the primary key (id_api_log column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdApiLog($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdApiLog();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of ApiLog (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIdApiRbac($this->getIdApiRbac());
        $copyObj->setIdAuthy($this->getIdAuthy());
        $copyObj->setTime($this->getTime());

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
            $copyObj->setIdApiLog(NULL); // this is a auto-increment column, so set to default value
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
     * @return ApiLog Clone of current object.
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
     * @return ApiLogPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ApiLogPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a ApiRbac object.
     *
     * @param                  ApiRbac $v
     * @return ApiLog The current object (for fluent API support)
     * @throws PropelException
     */
    public function setApiRbac(ApiRbac $v = null)
    {
        if ($v === null) {
            $this->setIdApiRbac(NULL);
        } else {
            $this->setIdApiRbac($v->getIdApiRbac());
        }

        $this->aApiRbac = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ApiRbac object, it will not be re-added.
        if ($v !== null) {
            $v->addApiLog($this);
        }


        return $this;
    }


    /**
     * Get the associated ApiRbac object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return ApiRbac The associated ApiRbac object.
     * @throws PropelException
     */
    public function getApiRbac(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aApiRbac === null && ($this->id_api_rbac !== null) && $doQuery) {
            $this->aApiRbac = ApiRbacQuery::create()->findPk($this->id_api_rbac, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aApiRbac->addApiLogs($this);
             */
        }

        return $this->aApiRbac;
    }

    /**
     * Declares an association between this object and a Authy object.
     *
     * @param                  Authy $v
     * @return ApiLog The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAuthy(Authy $v = null)
    {
        if ($v === null) {
            $this->setIdAuthy(NULL);
        } else {
            $this->setIdAuthy($v->getIdAuthy());
        }

        $this->aAuthy = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Authy object, it will not be re-added.
        if ($v !== null) {
            $v->addApiLog($this);
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
    public function getAuthy(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAuthy === null && ($this->id_authy !== null) && $doQuery) {
            $this->aAuthy = AuthyQuery::create()->findPk($this->id_authy, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAuthy->addApiLogs($this);
             */
        }

        return $this->aAuthy;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_api_log = null;
        $this->id_api_rbac = null;
        $this->id_authy = null;
        $this->time = null;
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
            if ($this->aApiRbac instanceof Persistent) {
              $this->aApiRbac->clearAllReferences($deep);
            }
            if ($this->aAuthy instanceof Persistent) {
              $this->aAuthy->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aApiRbac = null;
        $this->aAuthy = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ApiLogPeer::DEFAULT_STRING_FORMAT);
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

}
