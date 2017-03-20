<?php

class SimpleTestModel extends \Modelight\Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $tableName = 'test_model';

    /**
     * Array of primary keys fileds
     *
     * @var array
     */
    protected $primaryKeys = [
        'id_model'
    ];

    /**
     * Array field list
     *
     * @var array
     */
    protected $fields = [
        'id_test_model',
        'field_int',
        'field_varchar',
        'field_text',
        'field_datetime'
    ];

    /**
     * Value of test_model.id_test_model field
     *
     * @var int
     */
    protected $idTestModel = null;

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
     * Returns value of test_model.id_test_model field
     *
     * @return int
     */
    public function getIdTestModel()
    {
        return $this->idTestModel;
    }

    /**
     * Set value of test_model.id_test_model field
     *
     * @param int $idTestModel
     * @return $this
     */
    public function setIdTestModel($idTestModel)
    {
        $this->idTestModel = $idTestModel;

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
}
