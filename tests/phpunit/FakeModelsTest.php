<?php

/**
 * @covers \Modelight\Model
 */
final class FakeModelsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @expectedException \Modelight\Exception
     */
    public function testCannotInstanciateModelWithoutTableName()
    {
        new \FakeModelWithoutTableName();
    }

    /**
     * @expectedException \Modelight\Exception
     */
    public function testCannotInstanciateModelWithoutPrimaryKeys()
    {
        new \FakeModelWithoutPrimaryKey();
    }

    /**
     * @expectedException \Modelight\Exception
     */
    public function testCannotInstanciateModelWithoutFields()
    {
        new \FakeModelWithoutFields();
    }
}
