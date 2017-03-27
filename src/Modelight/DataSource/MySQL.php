<?php

namespace Modelight\DataSource;

class MySQL implements \Modelight\DataSourceInterface
{
    /**
     * @var \PDO
     */
    protected $pdo = null;

    /**
     * Database constructor
     *
     * @param string $host
     * @param string $databaseName
     * @param string $username
     * @param string $password
     */
    public function __construct($host, $databaseName, $username, $password)
    {
        $this->pdo = new \PDO('mysql:dbname=' . $databaseName . ';host=' . $host, $username, $password, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_PERSISTENT => true
        ]);
    }

    /**
     * Executes query
     *
     * @param string $query
     * @param array $params
     * @return array
     * @throws \Modelight\Exception
     */
    public function query($query, array $params = array())
    {
        $stmt = $this->pdo->prepare($query);

        foreach ($params as $fieldName => $fieldDefinition) {
            if (!array_key_exists('value', $fieldDefinition)) {
                throw new \Modelight\Exception('value entry is missing in field definition.');
            }
            if (!array_key_exists('type', $fieldDefinition)) {
                throw new \Modelight\Exception('type entry is missing in field definition.');
            }

            $stmt->bindValue($fieldName, $fieldDefinition['value'], $fieldDefinition['type']);
        }

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Save Model
     *
     * @param \Modelight\Model $model
     * @return \Modelight\Model
     */
    public function save(\Modelight\Model $model)
    {
        $pkValue = $model->get($model->getPrimaryKey());

        if ($pkValue === null) {
            $this->insert($model);
        } else {
            $this->update($model);
        }

        return $model;
    }

    /**
     * Insert Model
     *
     * @param \Modelight\Model $model
     * @return \Modelight\Model
     */
    public function insert(\Modelight\Model $model)
    {

        return $model;
    }

    /**
     * Update Model
     *
     * @param \Modelight\Model $model
     * @return \Modelight\Model
     */
    public function update(\Modelight\Model $model)
    {

        return $model;
    }

    /**
     * Delete Model
     *
     * @param \Modelight\Model $model
     * @return \Modelight\Model
     */
    public function delete(\Modelight\Model $model)
    {

        return $model;
    }
}
