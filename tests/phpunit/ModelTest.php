<?php

/**
 * @covers \Modelight\Model
 */
final class ModelTest extends \PHPUnit\Framework\TestCase
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
        new \FakeModelWithoutPrimaryKeys();
    }

    /**
     * @expectedException \Modelight\Exception
     */
    public function testCannotInstanciateModelWithoutFields()
    {
        new \FakeModelWithoutFields();
    }
}
