<?php

class FakeModelWithoutPrimaryKeys extends \Modelight\Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $tableName = 'fake_model_without_primary_keys';

    /**
     * Array field list
     *
     * @var array
     */
    protected $fields = [
        'id_model',
        'field_1',
        'field_2'
    ];
}
