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
        'id_model' => [
            'type' => \PDO::PARAM_INT
        ],
        'field_1' => [
            'type' => \PDO::PARAM_STR
        ],
        'field_2' => [
            'type' => \PDO::PARAM_BOOL
        ]
    ];
}
