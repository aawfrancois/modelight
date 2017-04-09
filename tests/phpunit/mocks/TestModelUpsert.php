<?php

class TestModelUpsert extends \Modelight\Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $tableName = 'test_model_upsert';

    /**
     * Primary key filed name
     *
     * @var array
     */
    protected $primaryKey = 'id_test_model_upsert';

    /**
     * Array field list
     *
     * @var array
     */
    protected $fields = [
        'id_test_model_upsert' => [
            'type' => \PDO::PARAM_INT
        ],
        'field_int' => [
            'type' => \PDO::PARAM_INT
        ],
        'field_varchar' => [
            'type' => \PDO::PARAM_STR
        ],
        'field_text' => [
            'type' => \PDO::PARAM_STR
        ],
        'field_datetime' => [
            'type' => \PDO::PARAM_STR
        ],
        'john_doe_is_active' => [
            'type' => \PDO::PARAM_BOOL
        ]
    ];

    /**
     * Value of test_model.id_test_model_upsert field
     *
     * @var int
     */
    protected $idTestModelUpsert = null;

    /**
     * Value of test_model.field_int field
     *
     * @var int
     */
    protected $fieldInt = 12;

    /**
     * Value of test_model.field_varchar field
     *
     * @var string
     */
    protected $fieldVarchar = null;

    /**
     * Value of test_model.field_text field
     *
     * @var string
     */
    protected $fieldText = null;

    /**
     * Value of test_model.field_datetime field
     *
     * @var string
     */
    protected $fieldDatetime = null;

    /**
     * Value of test_model.john_doe_is_active field
     *
     * @var bool
     */
    protected $johnDoeIsActive = true;

    /**
     * Returns value of test_model.id_test_model_upsert field
     *
     * @return int
     */
    public function getIdTestModelUpsert()
    {
        return $this->idTestModelUpsert;
    }

    /**
     * Set value of test_model.id_test_model_upsert field
     *
     * @param int $idTestModelUpsert
     * @return $this
     */
    public function setIdTestModelUpsert($idTestModelUpsert)
    {
        $this->idTestModelUpsert = $idTestModelUpsert;

        return $this;
    }

    /**
     * Returns value of test_model.field_int
     *
     * @return int
     */
    public function getFieldInt()
    {
        return $this->fieldInt;
    }

    /**
     * Set value of test_model.field_int
     *
     * @param int $fieldInt
     * @return $this
     */
    public function setFieldInt($fieldInt)
    {
        $this->fieldInt = $fieldInt;

        return $this;
    }

    /**
     * Returns value of test_model.field_varchar field
     *
     * @return string
     */
    public function getFieldVarchar()
    {
        return $this->fieldVarchar;
    }

    /**
     * Set value of test_model.field_varchar field
     *
     * @param string $fieldVarchar
     * @return $this
     */
    public function setFieldVarchar($fieldVarchar)
    {
        $this->fieldVarchar = $fieldVarchar;

        return $this;
    }

    /**
     * Returns value of test_model.field_text field
     *
     * @return string
     */
    public function getFieldText()
    {
        return $this->fieldText;
    }

    /**
     * Set value of test_model.field_text field
     *
     * @param string $fieldText
     * @return $this
     */
    public function setFieldText($fieldText)
    {
        $this->fieldText = $fieldText;

        return $this;
    }

    /**
     * Returns value of test_model.field_datetime field
     *
     * @return string
     */
    public function getFieldDatetime()
    {
        return $this->fieldDatetime;
    }

    /**
     * Set value of test_model.field_datetime field
     *
     * @param string $fieldDatetime
     * @return $this
     */
    public function setFieldDatetime($fieldDatetime)
    {
        $this->fieldDatetime = $fieldDatetime;

        return $this;
    }

    /**
     * Returns value of test_model.john_doe_is_active field
     *
     * @return string
     */
    public function getJohnDoeIsActive()
    {
        return $this->johnDoeIsActive;
    }

    /**
     * Set value of test_model.john_doe_is_active field
     *
     * @param bool $johnDoeIsActive
     * @return $this
     */
    public function setJohnDoeIsActive($johnDoeIsActive)
    {
        $this->johnDoeIsActive = $johnDoeIsActive;

        return $this;
    }
}
