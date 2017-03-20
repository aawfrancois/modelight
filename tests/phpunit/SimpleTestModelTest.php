<?php

/**
 * @covers \Modelight\Model
 */
final class SimpleTestModelTest extends \PHPUnit\Framework\TestCase
{
    public function testCanInstanciateSimpleTestModel()
    {
        $model = new \SimpleTestModel();

        $this->assertInstanceOf(\Modelight\Model::class, $model);
    }

    public function testCanFormatGetterMethodName()
    {
        $model = new \SimpleTestModel();

        $method = new \ReflectionMethod('SimpleTestModel', 'getGetterMethodName');
        $method->setAccessible(true);

        $this->assertEquals('getFieldInt', $method->invoke($model, 'field_int'));
        $this->assertEquals('getFieldSome123', $method->invoke($model, 'field_some_123'));
    }

    public function testCanFormatSetterMethodName()
    {
        $model = new \SimpleTestModel();

        $method = new \ReflectionMethod('SimpleTestModel', 'getSetterMethodName');
        $method->setAccessible(true);

        $this->assertEquals('setFieldInt', $method->invoke($model, 'field_int'));
        $this->assertEquals('setFieldIntAnd123And', $method->invoke($model, 'field_int_and_123_and'));
        $this->assertEquals('setFieldIntAnd123and', $method->invoke($model, 'field_int_and_123and'));
    }

    public function testCanSetSimpleTestModelData()
    {
        $expectedFieldVarchar = 'Hello!';

        $model = new \SimpleTestModel([
            'field_varchar' => $expectedFieldVarchar
        ]);

        $this->assertEquals($expectedFieldVarchar, $model->getFieldVarchar());

        // field_int has 12 as default value :)
        $this->assertEquals(12, $model->getFieldInt());
    }

    public function testCanGetSimpleTestModelData()
    {
        $expectedFieldText = 'Hello!';

        $model = new \SimpleTestModel([
            'field_text' => $expectedFieldText
        ]);

        $model->setJohnDoeIsActive(false);

        $this->assertEquals([
            'id_test_model' => null,
            'field_int' => 12, // field_int has 12 as default value :)
            'field_varchar' => null,
            'field_text' => $expectedFieldText,
            'field_datetime' => null,
            'john_doe_is_active' => false
        ], $model->getData());
    }
}
