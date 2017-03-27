<?php

/**
 * @covers \Modelight\DataSource\MySQL
 */
final class DataSourceTest extends \PHPUnit\Framework\TestCase
{
    public function testCanConnectDatabase()
    {
        $database = new \Modelight\DataSource\MySQL('127.0.0.1', 'db_test', 'db_test', 'db_test');

        $this->assertInstanceOf(\Modelight\DataSource\MySQL::class, $database);
    }

    public function testCanSelectRows()
    {
        $database = new \Modelight\DataSource\MySQL('127.0.0.1', 'db_test', 'db_test', 'db_test');

        $rows = $database->query('SELECT * FROM companion WHERE id_companion = :id_companion', [
            'id_companion' => [
                'value' => 1,
                'type' => \PDO::PARAM_INT
            ]
        ]);

        $this->assertArrayHasKey('id_companion', current($rows));
    }
}
