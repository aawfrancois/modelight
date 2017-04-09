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
     * Primary key filed name
     *
     * @var string
     */
    protected $primaryKey = null;

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
        if (!is_string($this->primaryKey)) {
            throw new \Modelight\Exception('$primaryKey property must be defined in ' . get_called_class());
        }
        if (!is_array($this->fields) || (is_array($this->fields) && count($this->fields) === 0)) {
            throw new \Modelight\Exception('$fields property must be defined in ' . get_called_class());
        }

        $this->setData($data);
    }

    /**
     * Returns Model data
     *
     * @return array Associative array: key = field name, value = field value
     */
    public function getData()
    {
        $data = [];

        foreach ($this->getFields() as $fieldName => $fieldDefinition) {
            $data[$fieldName] = $this->get($fieldName);
        }

        return $data;
    }

    /**
     * Get Model data for a specific field
     *
     * @param string $fieldName
     * @return mixed
     */
    public function get($fieldName)
    {
        $getterMethodName = $this->getGetterMethodName($fieldName);

        return $this->$getterMethodName();
    }

    /**
     * Set Model data
     *
     * @param array $data Associative array: key = field name, value = field value
     * @return $this
     */
    public function setData(array $data = [])
    {
        foreach ($this->getFields() as $fieldName => $fieldDefinition) {
            if (!array_key_exists($fieldName, $data)) {
                continue;
            }

            $this->set($fieldName, $data[$fieldName]);
        }

        return $this;
    }

    /**
     * Set Model data for a specific field
     *
     * @param string $fieldName
     * @param mixed $value
     * @return $this
     * @throws \Modelight\Exception
     */
    public function set($fieldName, $value)
    {
        $fields = $this->getFields();
        if (!array_key_exists($fieldName, $fields)) {
            throw new \Modelight\Exception('Unable to retrieve fieldName ' . json_encode($fieldName) . ' in $fields property of ' . get_called_class());
        }

        $fieldDefinition = $fields[$fieldName];

        $fieldValue = $value;
        if ($fieldValue === null) {
            $fieldValue = null;
        } else if ($fieldDefinition['type'] === \PDO::PARAM_INT) {
            $fieldValue = (int)$value;
        } else if ($fieldDefinition['type'] === \PDO::PARAM_STR) {
            $fieldValue = (string)$value;
        } else if ($fieldDefinition['type'] === \PDO::PARAM_BOOL) {
            $fieldValue = (bool)$value;
        }

        $setterMethodName = $this->getSetterMethodName($fieldName);

        $this->$setterMethodName($fieldValue);

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
        return 'get' . ucfirst(implode('', array_map('ucfirst', preg_split("/[^a-z0-9]+/", $fieldName))));
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
        return 'set' . ucfirst(implode('', array_map('ucfirst', preg_split("/[^a-z0-9]+/", $fieldName))));
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
     * Returns primary key filed name
     *
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
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
