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
     * Array field list
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Array of primary keys fileds
     *
     * @var array
     */
    protected $primaryKeys = [];

    /**
     * Model constructor
     *
     * @param array $data Associative array: key = field name, value = field value
     */
    public function __construct(array $data = [])
    {
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
     * Returns field list
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
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
}
