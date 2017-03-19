<?php

class FakeModelWithoutFields extends \Modelight\Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $tableName = 'fake_model_without_fields';

    /**
     * Array of primary keys fileds
     *
     * @var array
     */
    protected $primaryKeys = ['id_model'];
}
