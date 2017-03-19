<?php

namespace Modelight;

abstract class Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $tableName = null;

    /**
     * Array of primary key fileds
     *
     * @var array
     */
    protected $primaryKeys = [];

    /**
     * Array field list
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Model constructor
     *
     * @param array $data Associative array: key = field name, value = field value
     * @throws \Modelight\Exception
     */
    public function __construct(array $data = [])
    {
        if (!is_string($this->tableName)) {
            throw new \Modelight\Exception('$tableName property must be defined in ' . get_called_class());
        }
        if (!is_array($this->primaryKeys) || (is_array($this->primaryKeys) && count($this->primaryKeys) > 0)) {
            throw new \Modelight\Exception('$primaryKeys property must be defined in ' . get_called_class());
        }
        if (!is_array($this->fields) || (is_array($this->fields) && count($this->fields) > 0)) {
            throw new \Modelight\Exception('$fields property must be defined in ' . get_called_class());
        }

        $this->setData($data);
    }

    /**
     * Set Model data
     *
     * @param array $data Associative array: key = field name, value = field value
     * @return $this
     */
    public function setData(array $data = [])
    {
        foreach ($this->getFields() as $fieldName) {
            if (!array_key_exists($fieldName, $data)) {
                continue;
            }

            $setterMethodName = $this->getSetterMethodName($fieldName);

            $this->$setterMethodName($data[$fieldName]);
        }

        return $this;
    }

    /**
     * Get getter method name
     * Ex.: for a field named created_at, returns getCreatedAt
     *
     * @param string $fieldName
     * @return string
     */
    protected function getGetterMethodName($fieldName)
    {
        return 'get' . ucfirst(implode('', array_map('ucfirst', preg_split("/[a-zA-Z]+/", $fieldName))));
    }

    /**
     * Get setter method name
     * Ex.: for a field named created_at, returns getCreatedAt
     *
     * @param string $fieldName
     * @return string
     */
    protected function getSetterMethodName($fieldName)
    {
        return 'set' . ucfirst(implode('', array_map('ucfirst', preg_split("/[a-zA-Z]+/", $fieldName))));
    }

    /**
     * Returns table name
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * Returns primary keys fileds
     *
     * @return array
     */
    public function getPrimaryKeys()
    {
        return $this->primaryKeys;
    }

    /**
     * Returns field list
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }
}
