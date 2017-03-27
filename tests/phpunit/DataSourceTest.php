<?php

/**
 * @covers \Modelight\DataSource
 */
final class DataSourceTest extends \PHPUnit\Framework\TestCase
{
    public function testCanConnectDatabase()
    {
        $database = new \Modelight\DataSource('127.0.0.1', 'db_test', 'db_test', 'db_test');

        $this->assertInstanceOf(Modelight\DataSource::class, $database);
    }

    public function testCanSelectRows()
    {
        $database = new \Modelight\DataSource('127.0.0.1', 'db_test', 'db_test', 'db_test');

        $rows = $database->query('SELECT * FROM companion WHERE id_companion = :id_companion', [
            'id_companion' => [
                'value' => 1,
                'type' => \PDO::PARAM_INT
            ]
        ]);

        $this->assertArrayHasKey('id_companion', current($rows));
    }
}
