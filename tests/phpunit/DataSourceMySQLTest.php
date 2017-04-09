<?php

/**
 * @covers \Modelight\DataSource\MySQL
 */
final class DataSourceMySQLTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Modelight\DataSource\MySQL
     */
    protected static $dataSource;

    /**
     * Used for insert/update/delete tests
     *
     * @var int|null
     */
    protected static $idTestModelUpsert;

    /**
     * setUpBeforeClass (one time setup)
     */
    public static function setUpBeforeClass()
    {
        self::$dataSource = new \Modelight\DataSource\MySQL('127.0.0.1', 'db_test', 'db_test', 'db_test');
    }

    /**
     * tearDownAfterClass (one time tearDown)
     */
    public static function tearDownAfterClass()
    {
        self::$dataSource = null;
    }

    /**
     * testCanConnectDatabase
     */
    public function testCanConnectDatabase()
    {
        $this->assertInstanceOf(\Modelight\DataSource\MySQL::class, self::$dataSource);
    }

    /**
     * testCanFetchRows
     */
    public function testCanFetchRows()
    {
        $rows = self::$dataSource->fetch('SELECT * FROM test_model WHERE id_test_model = :id_test_model', [
            'id_test_model' => [
                'value' => 1,
                'type' => \PDO::PARAM_INT
            ]
        ]);

        $this->assertInternalType('array', $rows);
        $this->assertArrayHasKey('john_doe_is_active', current($rows));
    }

    /**
     * testCanFindAll
     */
    public function testCanFindAll()
    {
        $collection = self::$dataSource->findAll(\TestModel::class);

        $this->assertInstanceOf(\Modelight\Collection::class, $collection);

        foreach ($collection as $model) {
            $this->assertInstanceOf(\TestModel::class, $model);
        }

        $this->assertEquals(8, $collection->count());
    }

    /**
     * testCanFindAllWithSortBy
     */
    public function testCanFindAllWithSortBy()
    {
        $collection = self::$dataSource->findAll(\TestModel::class, null, null, ['field_int' => 'DESC']);
        /** @var \TestModel $model */
        $model = $collection->offsetGet(0);

        $this->assertEquals(26, $model->getFieldInt());
    }

    /**
     * testCanFindAllWithLimit
     */
    public function testCanFindAllWithLimit()
    {
        $collection = self::$dataSource->findAll(\TestModel::class, 2);

        $this->assertEquals(2, $collection->count());
    }

    /**
     * testCanFindAllWithLimitAndOffset
     */
    public function testCanFindAllWithLimitAndOffset()
    {
        $collection = self::$dataSource->findAll(\TestModel::class, 3, 2);

        $this->assertEquals(3, $collection->count());
    }

    /**
     * testCanFindBy
     */
    public function testCanFindBy()
    {
        $collection = self::$dataSource->findBy(\TestModel::class, [
            'john_doe_is_active' => [
                'type' => \PDO::PARAM_BOOL,
                'value' => true
            ]
        ]);

        $this->assertEquals(3, $collection->count());
    }

    /**
     * testCanFindOneBy
     */
    public function testCanFindOneBy()
    {
        /** @var \TestModel $model */
        $model = self::$dataSource->findOneBy(\TestModel::class, [
            'john_doe_is_active' => [
                'type' => \PDO::PARAM_BOOL,
                'value' => true
            ]
        ]);

        $this->assertInstanceOf(\TestModel::class, $model);
        $this->assertEquals(2, $model->getIdTestModel());
    }

    /**
     * testCanFindOneByReturnsNull
     */
    public function testCanFindOneByReturnsNull()
    {
        /** @var \TestModel $model */
        $model = self::$dataSource->findOneBy(\TestModel::class, [
            'john_doe_is_active' => [
                'type' => \PDO::PARAM_INT,
                'value' => 12
            ]
        ]);

        $this->assertNull($model);
    }

    /**
     * testCanFind
     */
    public function testCanFind()
    {
        /** @var \TestModel $model */
        $model = self::$dataSource->find(\TestModel::class, 8);

        $this->assertInstanceOf(\TestModel::class, $model);
        $this->assertEquals(8, $model->getIdTestModel());
    }

    /**
     * testCanFindReturnsNull
     */
    public function testCanFindReturnsNull()
    {
        /** @var \TestModel $model */
        $model = self::$dataSource->find(\TestModel::class, rand(1000, 5000));

        $this->assertNull($model);
    }

    /**
     * testCanFindReturnsNull
     */
    public function testCanExecuteAndFetch()
    {
        self::$dataSource->execute("DELETE FROM test_model_upsert");

        $results = self::$dataSource->fetch("SELECT COUNT(*) AS counter FROM test_model_upsert");
        $firstResult = current($results);

        $this->assertArrayHasKey('counter', $firstResult);
        $this->assertEquals(0, $firstResult['counter']);
    }

    /**
     * testCanInsert
     */
    public function testCanInsert()
    {
        $model = new \TestModelUpsert();

        self::$dataSource->save($model);

        self::$idTestModelUpsert = $model->getIdTestModelUpsert();

        $this->assertInternalType('int', self::$idTestModelUpsert);
    }

    /**
     * testCanUpdate
     */
    public function testCanUpdate()
    {
        /** @var \TestModelUpsert $model */
        $model = self::$dataSource->find(\TestModelUpsert::class, self::$idTestModelUpsert);

        $model->setFieldInt(1000);

        self::$dataSource->save($model);

        unset($model);

        /** @var \TestModelUpsert $model */
        $model = self::$dataSource->find(\TestModelUpsert::class, self::$idTestModelUpsert);

        $this->assertEquals(1000, $model->getFieldInt());
    }

    /**
     * testCanDelete
     */
    public function testCanDelete()
    {
        /** @var \TestModelUpsert $model */
        $model = self::$dataSource->find(\TestModelUpsert::class, self::$idTestModelUpsert);

        self::$dataSource->delete($model);

        unset($model);

        /** @var \TestModelUpsert $model */
        $model = self::$dataSource->find(\TestModelUpsert::class, self::$idTestModelUpsert);

        $this->assertNull($model);
    }
}
