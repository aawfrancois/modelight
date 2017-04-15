<?php

class FakeModelWithoutTableName extends \Modelight\Model
{
    /**
     * Primary key filed name
     *
     * @var array
     */
    protected $primaryKey = 'id_model';

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
