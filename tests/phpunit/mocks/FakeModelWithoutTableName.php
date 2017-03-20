<?php

class FakeModelWithoutTableName extends \Modelight\Model
{
    /**
     * Array of primary keys fileds
     *
     * @var array
     */
    protected $primaryKeys = ['id_model'];

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
