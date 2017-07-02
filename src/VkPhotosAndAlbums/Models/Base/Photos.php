<?php

namespace VkPhotosAndAlbums\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;
use VkPhotosAndAlbums\Models\Albums as ChildAlbums;
use VkPhotosAndAlbums\Models\AlbumsQuery as ChildAlbumsQuery;
use VkPhotosAndAlbums\Models\PhotosQuery as ChildPhotosQuery;
use VkPhotosAndAlbums\Models\Users as ChildUsers;
use VkPhotosAndAlbums\Models\UsersQuery as ChildUsersQuery;
use VkPhotosAndAlbums\Models\Map\PhotosTableMap;

/**
 * Base class that represents a row from the 'photos' table.
 *
 *
 *
 * @package    propel.generator.VkPhotosAndAlbums.Models.Base
 */
abstract class Photos implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\VkPhotosAndAlbums\\Models\\Map\\PhotosTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the album_id field.
     *
     * @var        int
     */
    protected $album_id;

    /**
     * The value for the owner_id field.
     *
     * @var        int
     */
    protected $owner_id;

    /**
     * The value for the photo_75 field.
     *
     * @var        string
     */
    protected $photo_75;

    /**
     * The value for the photo_130 field.
     *
     * @var        string
     */
    protected $photo_130;

    /**
     * The value for the photo_604 field.
     *
     * @var        string
     */
    protected $photo_604;

    /**
     * The value for the photo_807 field.
     *
     * @var        string
     */
    protected $photo_807;

    /**
     * The value for the photo_1280 field.
     *
     * @var        string
     */
    protected $photo_1280;

    /**
     * The value for the photo_2560 field.
     *
     * @var        string
     */
    protected $photo_2560;

    /**
     * The value for the width field.
     *
     * @var        int
     */
    protected $width;

    /**
     * The value for the height field.
     *
     * @var        int
     */
    protected $height;

    /**
     * The value for the text field.
     *
     * @var        string
     */
    protected $text;

    /**
     * The value for the created field.
     *
     * @var        DateTime
     */
    protected $created;

    /**
     * The value for the last_sync field.
     *
     * Note: this column has a database default value of: (expression) now()
     * @var        DateTime
     */
    protected $last_sync;

    /**
     * @var        ChildUsers
     */
    protected $aUsers;

    /**
     * @var        ChildAlbums
     */
    protected $aAlbums;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
    }

    /**
     * Initializes internal state of VkPhotosAndAlbums\Models\Base\Photos object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Photos</code> instance.  If
     * <code>obj</code> is an instance of <code>Photos</code>, delegates to
     * <code>equals(Photos)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Photos The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [album_id] column value.
     *
     * @return int
     */
    public function getAlbumId()
    {
        return $this->album_id;
    }

    /**
     * Get the [owner_id] column value.
     *
     * @return int
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * Get the [photo_75] column value.
     *
     * @return string
     */
    public function getPhoto75()
    {
        return $this->photo_75;
    }

    /**
     * Get the [photo_130] column value.
     *
     * @return string
     */
    public function getPhoto130()
    {
        return $this->photo_130;
    }

    /**
     * Get the [photo_604] column value.
     *
     * @return string
     */
    public function getPhoto604()
    {
        return $this->photo_604;
    }

    /**
     * Get the [photo_807] column value.
     *
     * @return string
     */
    public function getPhoto807()
    {
        return $this->photo_807;
    }

    /**
     * Get the [photo_1280] column value.
     *
     * @return string
     */
    public function getPhoto1280()
    {
        return $this->photo_1280;
    }

    /**
     * Get the [photo_2560] column value.
     *
     * @return string
     */
    public function getPhoto2560()
    {
        return $this->photo_2560;
    }

    /**
     * Get the [width] column value.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Get the [height] column value.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Get the [text] column value.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Get the [optionally formatted] temporal [created] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreated($format = 'Y-m-d H:i:s')
    {
        if ($format === null) {
            return $this->created;
        } else {
            return $this->created instanceof \DateTimeInterface ? $this->created->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [last_sync] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getLastSync($format = 'Y-m-d H:i:s')
    {
        if ($format === null) {
            return $this->last_sync;
        } else {
            return $this->last_sync instanceof \DateTimeInterface ? $this->last_sync->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\VkPhotosAndAlbums\Models\Photos The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PhotosTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [album_id] column.
     *
     * @param int $v new value
     * @return $this|\VkPhotosAndAlbums\Models\Photos The current object (for fluent API support)
     */
    public function setAlbumId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->album_id !== $v) {
            $this->album_id = $v;
            $this->modifiedColumns[PhotosTableMap::COL_ALBUM_ID] = true;
        }

        if ($this->aAlbums !== null && $this->aAlbums->getId() !== $v) {
            $this->aAlbums = null;
        }

        return $this;
    } // setAlbumId()

    /**
     * Set the value of [owner_id] column.
     *
     * @param int $v new value
     * @return $this|\VkPhotosAndAlbums\Models\Photos The current object (for fluent API support)
     */
    public function setOwnerId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->owner_id !== $v) {
            $this->owner_id = $v;
            $this->modifiedColumns[PhotosTableMap::COL_OWNER_ID] = true;
        }

        if ($this->aUsers !== null && $this->aUsers->getId() !== $v) {
            $this->aUsers = null;
        }

        return $this;
    } // setOwnerId()

    /**
     * Set the value of [photo_75] column.
     *
     * @param string $v new value
     * @return $this|\VkPhotosAndAlbums\Models\Photos The current object (for fluent API support)
     */
    public function setPhoto75($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->photo_75 !== $v) {
            $this->photo_75 = $v;
            $this->modifiedColumns[PhotosTableMap::COL_PHOTO_75] = true;
        }

        return $this;
    } // setPhoto75()

    /**
     * Set the value of [photo_130] column.
     *
     * @param string $v new value
     * @return $this|\VkPhotosAndAlbums\Models\Photos The current object (for fluent API support)
     */
    public function setPhoto130($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->photo_130 !== $v) {
            $this->photo_130 = $v;
            $this->modifiedColumns[PhotosTableMap::COL_PHOTO_130] = true;
        }

        return $this;
    } // setPhoto130()

    /**
     * Set the value of [photo_604] column.
     *
     * @param string $v new value
     * @return $this|\VkPhotosAndAlbums\Models\Photos The current object (for fluent API support)
     */
    public function setPhoto604($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->photo_604 !== $v) {
            $this->photo_604 = $v;
            $this->modifiedColumns[PhotosTableMap::COL_PHOTO_604] = true;
        }

        return $this;
    } // setPhoto604()

    /**
     * Set the value of [photo_807] column.
     *
     * @param string $v new value
     * @return $this|\VkPhotosAndAlbums\Models\Photos The current object (for fluent API support)
     */
    public function setPhoto807($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->photo_807 !== $v) {
            $this->photo_807 = $v;
            $this->modifiedColumns[PhotosTableMap::COL_PHOTO_807] = true;
        }

        return $this;
    } // setPhoto807()

    /**
     * Set the value of [photo_1280] column.
     *
     * @param string $v new value
     * @return $this|\VkPhotosAndAlbums\Models\Photos The current object (for fluent API support)
     */
    public function setPhoto1280($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->photo_1280 !== $v) {
            $this->photo_1280 = $v;
            $this->modifiedColumns[PhotosTableMap::COL_PHOTO_1280] = true;
        }

        return $this;
    } // setPhoto1280()

    /**
     * Set the value of [photo_2560] column.
     *
     * @param string $v new value
     * @return $this|\VkPhotosAndAlbums\Models\Photos The current object (for fluent API support)
     */
    public function setPhoto2560($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->photo_2560 !== $v) {
            $this->photo_2560 = $v;
            $this->modifiedColumns[PhotosTableMap::COL_PHOTO_2560] = true;
        }

        return $this;
    } // setPhoto2560()

    /**
     * Set the value of [width] column.
     *
     * @param int $v new value
     * @return $this|\VkPhotosAndAlbums\Models\Photos The current object (for fluent API support)
     */
    public function setWidth($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->width !== $v) {
            $this->width = $v;
            $this->modifiedColumns[PhotosTableMap::COL_WIDTH] = true;
        }

        return $this;
    } // setWidth()

    /**
     * Set the value of [height] column.
     *
     * @param int $v new value
     * @return $this|\VkPhotosAndAlbums\Models\Photos The current object (for fluent API support)
     */
    public function setHeight($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->height !== $v) {
            $this->height = $v;
            $this->modifiedColumns[PhotosTableMap::COL_HEIGHT] = true;
        }

        return $this;
    } // setHeight()

    /**
     * Set the value of [text] column.
     *
     * @param string $v new value
     * @return $this|\VkPhotosAndAlbums\Models\Photos The current object (for fluent API support)
     */
    public function setText($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->text !== $v) {
            $this->text = $v;
            $this->modifiedColumns[PhotosTableMap::COL_TEXT] = true;
        }

        return $this;
    } // setText()

    /**
     * Sets the value of [created] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\VkPhotosAndAlbums\Models\Photos The current object (for fluent API support)
     */
    public function setCreated($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created !== null || $dt !== null) {
            if ($this->created === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created->format("Y-m-d H:i:s.u")) {
                $this->created = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PhotosTableMap::COL_CREATED] = true;
            }
        } // if either are not null

        return $this;
    } // setCreated()

    /**
     * Sets the value of [last_sync] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\VkPhotosAndAlbums\Models\Photos The current object (for fluent API support)
     */
    public function setLastSync($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->last_sync !== null || $dt !== null) {
            if ($this->last_sync === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->last_sync->format("Y-m-d H:i:s.u")) {
                $this->last_sync = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PhotosTableMap::COL_LAST_SYNC] = true;
            }
        } // if either are not null

        return $this;
    } // setLastSync()

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
        // otherwise, everything was equal, so return TRUE
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
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PhotosTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PhotosTableMap::translateFieldName('AlbumId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->album_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PhotosTableMap::translateFieldName('OwnerId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->owner_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PhotosTableMap::translateFieldName('Photo75', TableMap::TYPE_PHPNAME, $indexType)];
            $this->photo_75 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PhotosTableMap::translateFieldName('Photo130', TableMap::TYPE_PHPNAME, $indexType)];
            $this->photo_130 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PhotosTableMap::translateFieldName('Photo604', TableMap::TYPE_PHPNAME, $indexType)];
            $this->photo_604 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PhotosTableMap::translateFieldName('Photo807', TableMap::TYPE_PHPNAME, $indexType)];
            $this->photo_807 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PhotosTableMap::translateFieldName('Photo1280', TableMap::TYPE_PHPNAME, $indexType)];
            $this->photo_1280 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PhotosTableMap::translateFieldName('Photo2560', TableMap::TYPE_PHPNAME, $indexType)];
            $this->photo_2560 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : PhotosTableMap::translateFieldName('Width', TableMap::TYPE_PHPNAME, $indexType)];
            $this->width = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : PhotosTableMap::translateFieldName('Height', TableMap::TYPE_PHPNAME, $indexType)];
            $this->height = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : PhotosTableMap::translateFieldName('Text', TableMap::TYPE_PHPNAME, $indexType)];
            $this->text = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : PhotosTableMap::translateFieldName('Created', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : PhotosTableMap::translateFieldName('LastSync', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->last_sync = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 14; // 14 = PhotosTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\VkPhotosAndAlbums\\Models\\Photos'), 0, $e);
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
        if ($this->aAlbums !== null && $this->album_id !== $this->aAlbums->getId()) {
            $this->aAlbums = null;
        }
        if ($this->aUsers !== null && $this->owner_id !== $this->aUsers->getId()) {
            $this->aUsers = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PhotosTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPhotosQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUsers = null;
            $this->aAlbums = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Photos::setDeleted()
     * @see Photos::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PhotosTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPhotosQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PhotosTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
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
                PhotosTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUsers !== null) {
                if ($this->aUsers->isModified() || $this->aUsers->isNew()) {
                    $affectedRows += $this->aUsers->save($con);
                }
                $this->setUsers($this->aUsers);
            }

            if ($this->aAlbums !== null) {
                if ($this->aAlbums->isModified() || $this->aAlbums->isNew()) {
                    $affectedRows += $this->aAlbums->save($con);
                }
                $this->setAlbums($this->aAlbums);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PhotosTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PhotosTableMap::COL_ALBUM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'album_id';
        }
        if ($this->isColumnModified(PhotosTableMap::COL_OWNER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'owner_id';
        }
        if ($this->isColumnModified(PhotosTableMap::COL_PHOTO_75)) {
            $modifiedColumns[':p' . $index++]  = 'photo_75';
        }
        if ($this->isColumnModified(PhotosTableMap::COL_PHOTO_130)) {
            $modifiedColumns[':p' . $index++]  = 'photo_130';
        }
        if ($this->isColumnModified(PhotosTableMap::COL_PHOTO_604)) {
            $modifiedColumns[':p' . $index++]  = 'photo_604';
        }
        if ($this->isColumnModified(PhotosTableMap::COL_PHOTO_807)) {
            $modifiedColumns[':p' . $index++]  = 'photo_807';
        }
        if ($this->isColumnModified(PhotosTableMap::COL_PHOTO_1280)) {
            $modifiedColumns[':p' . $index++]  = 'photo_1280';
        }
        if ($this->isColumnModified(PhotosTableMap::COL_PHOTO_2560)) {
            $modifiedColumns[':p' . $index++]  = 'photo_2560';
        }
        if ($this->isColumnModified(PhotosTableMap::COL_WIDTH)) {
            $modifiedColumns[':p' . $index++]  = 'width';
        }
        if ($this->isColumnModified(PhotosTableMap::COL_HEIGHT)) {
            $modifiedColumns[':p' . $index++]  = 'height';
        }
        if ($this->isColumnModified(PhotosTableMap::COL_TEXT)) {
            $modifiedColumns[':p' . $index++]  = 'text';
        }
        if ($this->isColumnModified(PhotosTableMap::COL_CREATED)) {
            $modifiedColumns[':p' . $index++]  = 'created';
        }
        if ($this->isColumnModified(PhotosTableMap::COL_LAST_SYNC)) {
            $modifiedColumns[':p' . $index++]  = 'last_sync';
        }

        $sql = sprintf(
            'INSERT INTO photos (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'album_id':
                        $stmt->bindValue($identifier, $this->album_id, PDO::PARAM_INT);
                        break;
                    case 'owner_id':
                        $stmt->bindValue($identifier, $this->owner_id, PDO::PARAM_INT);
                        break;
                    case 'photo_75':
                        $stmt->bindValue($identifier, $this->photo_75, PDO::PARAM_STR);
                        break;
                    case 'photo_130':
                        $stmt->bindValue($identifier, $this->photo_130, PDO::PARAM_STR);
                        break;
                    case 'photo_604':
                        $stmt->bindValue($identifier, $this->photo_604, PDO::PARAM_STR);
                        break;
                    case 'photo_807':
                        $stmt->bindValue($identifier, $this->photo_807, PDO::PARAM_STR);
                        break;
                    case 'photo_1280':
                        $stmt->bindValue($identifier, $this->photo_1280, PDO::PARAM_STR);
                        break;
                    case 'photo_2560':
                        $stmt->bindValue($identifier, $this->photo_2560, PDO::PARAM_STR);
                        break;
                    case 'width':
                        $stmt->bindValue($identifier, $this->width, PDO::PARAM_INT);
                        break;
                    case 'height':
                        $stmt->bindValue($identifier, $this->height, PDO::PARAM_INT);
                        break;
                    case 'text':
                        $stmt->bindValue($identifier, $this->text, PDO::PARAM_STR);
                        break;
                    case 'created':
                        $stmt->bindValue($identifier, $this->created ? $this->created->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'last_sync':
                        $stmt->bindValue($identifier, $this->last_sync ? $this->last_sync->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PhotosTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getAlbumId();
                break;
            case 2:
                return $this->getOwnerId();
                break;
            case 3:
                return $this->getPhoto75();
                break;
            case 4:
                return $this->getPhoto130();
                break;
            case 5:
                return $this->getPhoto604();
                break;
            case 6:
                return $this->getPhoto807();
                break;
            case 7:
                return $this->getPhoto1280();
                break;
            case 8:
                return $this->getPhoto2560();
                break;
            case 9:
                return $this->getWidth();
                break;
            case 10:
                return $this->getHeight();
                break;
            case 11:
                return $this->getText();
                break;
            case 12:
                return $this->getCreated();
                break;
            case 13:
                return $this->getLastSync();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Photos'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Photos'][$this->hashCode()] = true;
        $keys = PhotosTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getAlbumId(),
            $keys[2] => $this->getOwnerId(),
            $keys[3] => $this->getPhoto75(),
            $keys[4] => $this->getPhoto130(),
            $keys[5] => $this->getPhoto604(),
            $keys[6] => $this->getPhoto807(),
            $keys[7] => $this->getPhoto1280(),
            $keys[8] => $this->getPhoto2560(),
            $keys[9] => $this->getWidth(),
            $keys[10] => $this->getHeight(),
            $keys[11] => $this->getText(),
            $keys[12] => $this->getCreated(),
            $keys[13] => $this->getLastSync(),
        );
        if ($result[$keys[12]] instanceof \DateTime) {
            $result[$keys[12]] = $result[$keys[12]]->format('c');
        }

        if ($result[$keys[13]] instanceof \DateTime) {
            $result[$keys[13]] = $result[$keys[13]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aUsers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'users';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'users';
                        break;
                    default:
                        $key = 'Users';
                }

                $result[$key] = $this->aUsers->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAlbums) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'albums';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'albums';
                        break;
                    default:
                        $key = 'Albums';
                }

                $result[$key] = $this->aAlbums->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\VkPhotosAndAlbums\Models\Photos
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PhotosTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\VkPhotosAndAlbums\Models\Photos
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setAlbumId($value);
                break;
            case 2:
                $this->setOwnerId($value);
                break;
            case 3:
                $this->setPhoto75($value);
                break;
            case 4:
                $this->setPhoto130($value);
                break;
            case 5:
                $this->setPhoto604($value);
                break;
            case 6:
                $this->setPhoto807($value);
                break;
            case 7:
                $this->setPhoto1280($value);
                break;
            case 8:
                $this->setPhoto2560($value);
                break;
            case 9:
                $this->setWidth($value);
                break;
            case 10:
                $this->setHeight($value);
                break;
            case 11:
                $this->setText($value);
                break;
            case 12:
                $this->setCreated($value);
                break;
            case 13:
                $this->setLastSync($value);
                break;
        } // switch()

        return $this;
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
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = PhotosTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setAlbumId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setOwnerId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPhoto75($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPhoto130($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPhoto604($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setPhoto807($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setPhoto1280($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setPhoto2560($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setWidth($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setHeight($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setText($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setCreated($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setLastSync($arr[$keys[13]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\VkPhotosAndAlbums\Models\Photos The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PhotosTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PhotosTableMap::COL_ID)) {
            $criteria->add(PhotosTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PhotosTableMap::COL_ALBUM_ID)) {
            $criteria->add(PhotosTableMap::COL_ALBUM_ID, $this->album_id);
        }
        if ($this->isColumnModified(PhotosTableMap::COL_OWNER_ID)) {
            $criteria->add(PhotosTableMap::COL_OWNER_ID, $this->owner_id);
        }
        if ($this->isColumnModified(PhotosTableMap::COL_PHOTO_75)) {
            $criteria->add(PhotosTableMap::COL_PHOTO_75, $this->photo_75);
        }
        if ($this->isColumnModified(PhotosTableMap::COL_PHOTO_130)) {
            $criteria->add(PhotosTableMap::COL_PHOTO_130, $this->photo_130);
        }
        if ($this->isColumnModified(PhotosTableMap::COL_PHOTO_604)) {
            $criteria->add(PhotosTableMap::COL_PHOTO_604, $this->photo_604);
        }
        if ($this->isColumnModified(PhotosTableMap::COL_PHOTO_807)) {
            $criteria->add(PhotosTableMap::COL_PHOTO_807, $this->photo_807);
        }
        if ($this->isColumnModified(PhotosTableMap::COL_PHOTO_1280)) {
            $criteria->add(PhotosTableMap::COL_PHOTO_1280, $this->photo_1280);
        }
        if ($this->isColumnModified(PhotosTableMap::COL_PHOTO_2560)) {
            $criteria->add(PhotosTableMap::COL_PHOTO_2560, $this->photo_2560);
        }
        if ($this->isColumnModified(PhotosTableMap::COL_WIDTH)) {
            $criteria->add(PhotosTableMap::COL_WIDTH, $this->width);
        }
        if ($this->isColumnModified(PhotosTableMap::COL_HEIGHT)) {
            $criteria->add(PhotosTableMap::COL_HEIGHT, $this->height);
        }
        if ($this->isColumnModified(PhotosTableMap::COL_TEXT)) {
            $criteria->add(PhotosTableMap::COL_TEXT, $this->text);
        }
        if ($this->isColumnModified(PhotosTableMap::COL_CREATED)) {
            $criteria->add(PhotosTableMap::COL_CREATED, $this->created);
        }
        if ($this->isColumnModified(PhotosTableMap::COL_LAST_SYNC)) {
            $criteria->add(PhotosTableMap::COL_LAST_SYNC, $this->last_sync);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildPhotosQuery::create();
        $criteria->add(PhotosTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \VkPhotosAndAlbums\Models\Photos (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setId($this->getId());
        $copyObj->setAlbumId($this->getAlbumId());
        $copyObj->setOwnerId($this->getOwnerId());
        $copyObj->setPhoto75($this->getPhoto75());
        $copyObj->setPhoto130($this->getPhoto130());
        $copyObj->setPhoto604($this->getPhoto604());
        $copyObj->setPhoto807($this->getPhoto807());
        $copyObj->setPhoto1280($this->getPhoto1280());
        $copyObj->setPhoto2560($this->getPhoto2560());
        $copyObj->setWidth($this->getWidth());
        $copyObj->setHeight($this->getHeight());
        $copyObj->setText($this->getText());
        $copyObj->setCreated($this->getCreated());
        $copyObj->setLastSync($this->getLastSync());
        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \VkPhotosAndAlbums\Models\Photos Clone of current object.
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
     * Declares an association between this object and a ChildUsers object.
     *
     * @param  ChildUsers $v
     * @return $this|\VkPhotosAndAlbums\Models\Photos The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUsers(ChildUsers $v = null)
    {
        if ($v === null) {
            $this->setOwnerId(NULL);
        } else {
            $this->setOwnerId($v->getId());
        }

        $this->aUsers = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUsers object, it will not be re-added.
        if ($v !== null) {
            $v->addPhotos($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUsers object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUsers The associated ChildUsers object.
     * @throws PropelException
     */
    public function getUsers(ConnectionInterface $con = null)
    {
        if ($this->aUsers === null && ($this->owner_id !== null)) {
            $this->aUsers = ChildUsersQuery::create()->findPk($this->owner_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUsers->addPhotoss($this);
             */
        }

        return $this->aUsers;
    }

    /**
     * Declares an association between this object and a ChildAlbums object.
     *
     * @param  ChildAlbums $v
     * @return $this|\VkPhotosAndAlbums\Models\Photos The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAlbums(ChildAlbums $v = null)
    {
        if ($v === null) {
            $this->setAlbumId(NULL);
        } else {
            $this->setAlbumId($v->getId());
        }

        $this->aAlbums = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAlbums object, it will not be re-added.
        if ($v !== null) {
            $v->addPhotos($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAlbums object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildAlbums The associated ChildAlbums object.
     * @throws PropelException
     */
    public function getAlbums(ConnectionInterface $con = null)
    {
        if ($this->aAlbums === null && ($this->album_id !== null)) {
            $this->aAlbums = ChildAlbumsQuery::create()->findPk($this->album_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAlbums->addPhotoss($this);
             */
        }

        return $this->aAlbums;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUsers) {
            $this->aUsers->removePhotos($this);
        }
        if (null !== $this->aAlbums) {
            $this->aAlbums->removePhotos($this);
        }
        $this->id = null;
        $this->album_id = null;
        $this->owner_id = null;
        $this->photo_75 = null;
        $this->photo_130 = null;
        $this->photo_604 = null;
        $this->photo_807 = null;
        $this->photo_1280 = null;
        $this->photo_2560 = null;
        $this->width = null;
        $this->height = null;
        $this->text = null;
        $this->created = null;
        $this->last_sync = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
        } // if ($deep)

        $this->aUsers = null;
        $this->aAlbums = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PhotosTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
