<?php

/**
 * @covers \Modelight\Model
 */
final class EmailTest extends \PHPUnit\Framework\TestCase
{
    public function testCanInstanciateTestModel()
    {
        $testModel = new \TestModel();

        $this->assertInstanceOf(
            \Modelight\Model::class,
            $testModel
        );
    }
}
