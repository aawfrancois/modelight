<?php

/**
 * @covers \Modelight\DataSource\MySQL
 */
final class DataSourceMySQLTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Modelight\DataSource\MySQL
     */
    protected $database;

    function setUp()
    {
        $this->database = new \Modelight\DataSource\MySQL('127.0.0.1', 'db_test', 'db_test', 'db_test');
    }

    public function testCanConnectDatabase()
    {
        $this->assertInstanceOf(\Modelight\DataSource\MySQL::class, $this->database);
    }

    public function testCanSelectRows()
    {
        $rows = $this->database->query('SELECT * FROM test_model WHERE id_test_model = :id_test_model', [
            'id_test_model' => [
                'value' => 1,
                'type' => \PDO::PARAM_INT
            ]
        ]);

        $this->assertInternalType('array', $rows);
        $this->assertArrayHasKey('john_doe_is_active', current($rows));
    }

    public function testCanFindAll()
    {
        $collection = $this->database->findAll(\SimpleTestModel::class);

        $this->assertInstanceOf(\Modelight\Collection::class, $collection);

        foreach ($collection as $model) {
            $this->assertInstanceOf(\SimpleTestModel::class, $model);
        }

        $this->assertEquals(8, $collection->count());
    }

    public function testCanFindAllWithSortBy()
    {
        $collection = $this->database->findAll(\SimpleTestModel::class, null, null, ['field_int' => 'DESC']);
        /** @var \SimpleTestModel $model */
        $model = $collection->offsetGet(0);

        $this->assertEquals(26, $model->getFieldInt());
    }

    public function testCanFindAllWithLimit()
    {
        $collection = $this->database->findAll(\SimpleTestModel::class, 2);

        $this->assertEquals(2, $collection->count());
    }

    public function testCanFindAllWithLimitAndOffset()
    {
        $collection = $this->database->findAll(\SimpleTestModel::class, 3, 2);

        $this->assertEquals(3, $collection->count());
    }

    public function testCanFindBy()
    {
        $collection = $this->database->findBy(\SimpleTestModel::class, [
            'john_doe_is_active' => [
                'type' => \PDO::PARAM_BOOL,
                'value' => true
            ]
        ]);

        $this->assertEquals(3, $collection->count());
    }

    public function testCanFindOneBy()
    {
        /** @var \SimpleTestModel $model */
        $model = $this->database->findOneBy(\SimpleTestModel::class, [
            'john_doe_is_active' => [
                'type' => \PDO::PARAM_BOOL,
                'value' => true
            ]
        ]);

        $this->assertInstanceOf(\SimpleTestModel::class, $model);
        $this->assertEquals(2, $model->getIdTestModel());
    }

    public function testCanFindOneByReturnsNull()
    {
        /** @var \SimpleTestModel $model */
        $model = $this->database->findOneBy(\SimpleTestModel::class, [
            'john_doe_is_active' => [
                'type' => \PDO::PARAM_INT,
                'value' => 12
            ]
        ]);

        $this->assertNull($model);
    }

    public function testCanFind()
    {
        /** @var \SimpleTestModel $model */
        $model = $this->database->find(\SimpleTestModel::class, 8);

        $this->assertInstanceOf(\SimpleTestModel::class, $model);
        $this->assertEquals(8, $model->getIdTestModel());
    }

    public function testCanFindReturnsNull()
    {
        /** @var \SimpleTestModel $model */
        $model = $this->database->find(\SimpleTestModel::class, 158);

        $this->assertNull($model);
    }
}
