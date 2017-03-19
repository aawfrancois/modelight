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
    protected $fields = ['id_model', 'field_1', 'field_2'];
}
