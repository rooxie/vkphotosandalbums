<?php

namespace VkPhotosAndAlbums\Models\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use VkPhotosAndAlbums\Models\Photos;
use VkPhotosAndAlbums\Models\PhotosQuery;


/**
 * This class defines the structure of the 'photos' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PhotosTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'VkPhotosAndAlbums.Models.Map.PhotosTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'vk_photos_and_albums';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'photos';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\VkPhotosAndAlbums\\Models\\Photos';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'VkPhotosAndAlbums.Models.Photos';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 14;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 14;

    /**
     * the column name for the id field
     */
    const COL_ID = 'photos.id';

    /**
     * the column name for the album_id field
     */
    const COL_ALBUM_ID = 'photos.album_id';

    /**
     * the column name for the owner_id field
     */
    const COL_OWNER_ID = 'photos.owner_id';

    /**
     * the column name for the photo_75 field
     */
    const COL_PHOTO_75 = 'photos.photo_75';

    /**
     * the column name for the photo_130 field
     */
    const COL_PHOTO_130 = 'photos.photo_130';

    /**
     * the column name for the photo_604 field
     */
    const COL_PHOTO_604 = 'photos.photo_604';

    /**
     * the column name for the photo_807 field
     */
    const COL_PHOTO_807 = 'photos.photo_807';

    /**
     * the column name for the photo_1280 field
     */
    const COL_PHOTO_1280 = 'photos.photo_1280';

    /**
     * the column name for the photo_2560 field
     */
    const COL_PHOTO_2560 = 'photos.photo_2560';

    /**
     * the column name for the width field
     */
    const COL_WIDTH = 'photos.width';

    /**
     * the column name for the height field
     */
    const COL_HEIGHT = 'photos.height';

    /**
     * the column name for the text field
     */
    const COL_TEXT = 'photos.text';

    /**
     * the column name for the created field
     */
    const COL_CREATED = 'photos.created';

    /**
     * the column name for the last_sync field
     */
    const COL_LAST_SYNC = 'photos.last_sync';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'AlbumId', 'OwnerId', 'Photo75', 'Photo130', 'Photo604', 'Photo807', 'Photo1280', 'Photo2560', 'Width', 'Height', 'Text', 'Created', 'LastSync', ),
        self::TYPE_CAMELNAME     => array('id', 'albumId', 'ownerId', 'photo75', 'photo130', 'photo604', 'photo807', 'photo1280', 'photo2560', 'width', 'height', 'text', 'created', 'lastSync', ),
        self::TYPE_COLNAME       => array(PhotosTableMap::COL_ID, PhotosTableMap::COL_ALBUM_ID, PhotosTableMap::COL_OWNER_ID, PhotosTableMap::COL_PHOTO_75, PhotosTableMap::COL_PHOTO_130, PhotosTableMap::COL_PHOTO_604, PhotosTableMap::COL_PHOTO_807, PhotosTableMap::COL_PHOTO_1280, PhotosTableMap::COL_PHOTO_2560, PhotosTableMap::COL_WIDTH, PhotosTableMap::COL_HEIGHT, PhotosTableMap::COL_TEXT, PhotosTableMap::COL_CREATED, PhotosTableMap::COL_LAST_SYNC, ),
        self::TYPE_FIELDNAME     => array('id', 'album_id', 'owner_id', 'photo_75', 'photo_130', 'photo_604', 'photo_807', 'photo_1280', 'photo_2560', 'width', 'height', 'text', 'created', 'last_sync', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'AlbumId' => 1, 'OwnerId' => 2, 'Photo75' => 3, 'Photo130' => 4, 'Photo604' => 5, 'Photo807' => 6, 'Photo1280' => 7, 'Photo2560' => 8, 'Width' => 9, 'Height' => 10, 'Text' => 11, 'Created' => 12, 'LastSync' => 13, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'albumId' => 1, 'ownerId' => 2, 'photo75' => 3, 'photo130' => 4, 'photo604' => 5, 'photo807' => 6, 'photo1280' => 7, 'photo2560' => 8, 'width' => 9, 'height' => 10, 'text' => 11, 'created' => 12, 'lastSync' => 13, ),
        self::TYPE_COLNAME       => array(PhotosTableMap::COL_ID => 0, PhotosTableMap::COL_ALBUM_ID => 1, PhotosTableMap::COL_OWNER_ID => 2, PhotosTableMap::COL_PHOTO_75 => 3, PhotosTableMap::COL_PHOTO_130 => 4, PhotosTableMap::COL_PHOTO_604 => 5, PhotosTableMap::COL_PHOTO_807 => 6, PhotosTableMap::COL_PHOTO_1280 => 7, PhotosTableMap::COL_PHOTO_2560 => 8, PhotosTableMap::COL_WIDTH => 9, PhotosTableMap::COL_HEIGHT => 10, PhotosTableMap::COL_TEXT => 11, PhotosTableMap::COL_CREATED => 12, PhotosTableMap::COL_LAST_SYNC => 13, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'album_id' => 1, 'owner_id' => 2, 'photo_75' => 3, 'photo_130' => 4, 'photo_604' => 5, 'photo_807' => 6, 'photo_1280' => 7, 'photo_2560' => 8, 'width' => 9, 'height' => 10, 'text' => 11, 'created' => 12, 'last_sync' => 13, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('photos');
        $this->setPhpName('Photos');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\VkPhotosAndAlbums\\Models\\Photos');
        $this->setPackage('VkPhotosAndAlbums.Models');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('album_id', 'AlbumId', 'INTEGER', 'albums', 'id', false, null, null);
        $this->addForeignKey('owner_id', 'OwnerId', 'INTEGER', 'users', 'id', true, null, null);
        $this->addColumn('photo_75', 'Photo75', 'VARCHAR', false, 255, null);
        $this->addColumn('photo_130', 'Photo130', 'VARCHAR', false, 255, null);
        $this->addColumn('photo_604', 'Photo604', 'VARCHAR', false, 255, null);
        $this->addColumn('photo_807', 'Photo807', 'VARCHAR', false, 255, null);
        $this->addColumn('photo_1280', 'Photo1280', 'VARCHAR', false, 255, null);
        $this->addColumn('photo_2560', 'Photo2560', 'VARCHAR', false, 255, null);
        $this->addColumn('width', 'Width', 'INTEGER', false, null, null);
        $this->addColumn('height', 'Height', 'INTEGER', false, null, null);
        $this->addColumn('text', 'Text', 'LONGVARCHAR', false, null, null);
        $this->addColumn('created', 'Created', 'TIMESTAMP', true, null, null);
        $this->addColumn('last_sync', 'LastSync', 'TIMESTAMP', true, null, 'now()');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Users', '\\VkPhotosAndAlbums\\Models\\Users', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':owner_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Albums', '\\VkPhotosAndAlbums\\Models\\Albums', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':album_id',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? PhotosTableMap::CLASS_DEFAULT : PhotosTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Photos object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PhotosTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PhotosTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PhotosTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PhotosTableMap::OM_CLASS;
            /** @var Photos $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PhotosTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = PhotosTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PhotosTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Photos $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PhotosTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(PhotosTableMap::COL_ID);
            $criteria->addSelectColumn(PhotosTableMap::COL_ALBUM_ID);
            $criteria->addSelectColumn(PhotosTableMap::COL_OWNER_ID);
            $criteria->addSelectColumn(PhotosTableMap::COL_PHOTO_75);
            $criteria->addSelectColumn(PhotosTableMap::COL_PHOTO_130);
            $criteria->addSelectColumn(PhotosTableMap::COL_PHOTO_604);
            $criteria->addSelectColumn(PhotosTableMap::COL_PHOTO_807);
            $criteria->addSelectColumn(PhotosTableMap::COL_PHOTO_1280);
            $criteria->addSelectColumn(PhotosTableMap::COL_PHOTO_2560);
            $criteria->addSelectColumn(PhotosTableMap::COL_WIDTH);
            $criteria->addSelectColumn(PhotosTableMap::COL_HEIGHT);
            $criteria->addSelectColumn(PhotosTableMap::COL_TEXT);
            $criteria->addSelectColumn(PhotosTableMap::COL_CREATED);
            $criteria->addSelectColumn(PhotosTableMap::COL_LAST_SYNC);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.album_id');
            $criteria->addSelectColumn($alias . '.owner_id');
            $criteria->addSelectColumn($alias . '.photo_75');
            $criteria->addSelectColumn($alias . '.photo_130');
            $criteria->addSelectColumn($alias . '.photo_604');
            $criteria->addSelectColumn($alias . '.photo_807');
            $criteria->addSelectColumn($alias . '.photo_1280');
            $criteria->addSelectColumn($alias . '.photo_2560');
            $criteria->addSelectColumn($alias . '.width');
            $criteria->addSelectColumn($alias . '.height');
            $criteria->addSelectColumn($alias . '.text');
            $criteria->addSelectColumn($alias . '.created');
            $criteria->addSelectColumn($alias . '.last_sync');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(PhotosTableMap::DATABASE_NAME)->getTable(PhotosTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PhotosTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PhotosTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PhotosTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Photos or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Photos object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PhotosTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \VkPhotosAndAlbums\Models\Photos) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PhotosTableMap::DATABASE_NAME);
            $criteria->add(PhotosTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PhotosQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PhotosTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PhotosTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the photos table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PhotosQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Photos or Criteria object.
     *
     * @param mixed               $criteria Criteria or Photos object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PhotosTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Photos object
        }


        // Set the correct dbName
        $query = PhotosQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PhotosTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PhotosTableMap::buildTableMap();
