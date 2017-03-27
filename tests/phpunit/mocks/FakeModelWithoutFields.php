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
     * Primary key filed name
     *
     * @var array
     */
    protected $primaryKey = 'id_model';
}
