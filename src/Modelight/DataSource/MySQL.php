<?php

namespace Modelight\DataSource;

class MySQL extends \Modelight\DataSource implements \Modelight\DataSourceInterface
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
     * @return int Number of affected rows
     * @throws \Modelight\Exception
     */
    public function execute($query, array $params = array())
    {
        $stmt = $this->pdo->prepare($query);

        $this->bindParams($stmt, $params);

        if (!$stmt->execute()) {
            throw new \Modelight\Exception('Unexpected PDO result. PDOStatement::execute returns false. errorInfo: ' . json_encode($stmt->errorInfo()));
        }

        return $stmt->rowCount();
    }

    /**
     * Executes query for fetching results
     *
     * @param string $query
     * @param array $params
     * @return array
     * @throws \Modelight\Exception
     */
    public function fetch($query, array $params = array())
    {
        $stmt = $this->pdo->prepare($query);

        $this->bindParams($stmt, $params);

        if (!$stmt->execute()) {
            throw new \Modelight\Exception('Unexpected PDO result. PDOStatement::execute returns false. errorInfo: ' . json_encode($stmt->errorInfo()));
        }

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Runs PDOStatement::bindValue for each given param
     *
     * @param \PDOStatement $stmt
     * @param array $params
     * @return $this
     * @throws \Modelight\Exception
     */
    protected function bindParams(\PDOStatement $stmt, array $params = array())
    {
        foreach ($params as $fieldName => $fieldDefinition) {
            if (!is_array($fieldDefinition)) {
                throw new \Modelight\Exception('Field definition must be an array.');
            }
            if (!array_key_exists('value', $fieldDefinition)) {
                throw new \Modelight\Exception('value entry is missing in field definition.');
            }
            if (!array_key_exists('type', $fieldDefinition)) {
                throw new \Modelight\Exception('type entry is missing in field definition.');
            }

            $stmt->bindValue($fieldName, $fieldDefinition['value'], $fieldDefinition['type']);
        }

        return $this;
    }

    /**
     * Find one Model by primary key value
     *
     * @param string $modelClassName
     * @param mixed $primaryKeyValue
     * @return \Modelight\Model
     * @throws \Modelight\Exception
     */
    public function find($modelClassName, $primaryKeyValue)
    {
        $refClass = new \ReflectionClass($modelClassName);
        $defaultProperties = $refClass->getDefaultProperties();
        if (!array_key_exists('primaryKey', $defaultProperties)) {
            throw new \Modelight\Exception('primaryKey property is missing in ' . var_export($modelClassName, true) . ' class.');
        }
        if (!array_key_exists('fields', $defaultProperties)) {
            throw new \Modelight\Exception('fields property is missing in ' . var_export($modelClassName, true) . ' class.');
        }

        return $this->findOneBy($modelClassName, [
            $defaultProperties['primaryKey'] => [
                'value' => $primaryKeyValue,
                'type' => $defaultProperties['fields'][$defaultProperties['primaryKey']]['type']
            ]
        ]);
    }

    /**
     * Find all Model
     *
     * @param string $modelClassName
     * @param int|null $limit
     * @param int|null $offset
     * @param array $sortBy
     * @return \Modelight\Collection
     * @throws \Modelight\Exception
     */
    public function findAll($modelClassName, $limit = null, $offset = null, array $sortBy = array())
    {
        $refClass = new \ReflectionClass($modelClassName);
        $defaultProperties = $refClass->getDefaultProperties();
        if (!array_key_exists('tableName', $defaultProperties)) {
            throw new \Modelight\Exception('tableName property is missing in ' . var_export($modelClassName, true) . ' class.');
        }

        $query = "SELECT t.* FROM " . $defaultProperties['tableName'] . " t" .
            $this->prepareSortByClause($sortBy) .
            $this->prepareLimitClause($limit, $offset);

        $collection = new \Modelight\Collection();

        foreach ($this->fetch($query) as $row) {
            $collection->append(new $modelClassName($row));
        }

        return $collection;
    }

    /**
     * Find Model by criterias
     *
     * @param string $modelClassName
     * @param array $criterias
     * @param int|null $limit
     * @param int|null $offset
     * @param array $sortBy
     * @return \Modelight\Collection
     * @throws \Modelight\Exception
     */
    public function findBy($modelClassName, array $criterias, $limit = null, $offset = null, array $sortBy = array())
    {
        $refClass = new \ReflectionClass($modelClassName);
        $defaultProperties = $refClass->getDefaultProperties();
        if (!array_key_exists('tableName', $defaultProperties)) {
            throw new \Modelight\Exception('tableName property is missing in ' . var_export($modelClassName, true) . ' class.');
        }

        $query = "SELECT t.* FROM " . $defaultProperties['tableName'] . " t";

        $whereClauses = [];
        foreach ($criterias as $fieldName => $fieldValue) {
            $whereClauses[] = " ( " . $fieldName . " = :" . $fieldName . " ) ";
        }

        $query .= count($whereClauses) > 0 ? " WHERE " . implode(' AND ', $whereClauses) : "";
        $query .= $this->prepareSortByClause($sortBy);
        $query .= $this->prepareLimitClause($limit, $offset);

        $collection = new \Modelight\Collection();

        foreach ($this->fetch($query, $criterias) as $row) {
            $collection->append(new $modelClassName($row));
        }

        return $collection;
    }

    /**
     * Find one Model by criterias
     *
     * @param string $modelClassName
     * @param array $criterias
     * @param int|null $limit
     * @param int|null $offset
     * @param array $sortBy
     * @return \Modelight\Model
     * @throws \Modelight\Exception
     */
    public function findOneBy($modelClassName, array $criterias, $limit = null, $offset = null, array $sortBy = array())
    {
        $collection = $this->findBy($modelClassName, $criterias, $limit, $offset, $sortBy);

        if (!$collection->offsetExists(0)) {
            return null;
        }

        return $collection->offsetGet(0);
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
     * @throws \Modelight\Exception
     */
    public function insert(\Modelight\Model $model)
    {
        $query = "INSERT INTO " . $model->getTableName() . " SET ";

        $setClauses = [];
        $params = [];

        foreach ($model->getFields() as $fieldName => $fieldDefinition) {
            if ($fieldName === $model->getPrimaryKey()) {
                continue;
            }

            $setClauses[] = $fieldName . " = :" . $fieldName;

            $params[$fieldName] = [
                'value' => $model->get($fieldName),
                'type' => $fieldDefinition['type']
            ];
        }

        $query .= " " . implode(", ", $setClauses);

        $stmt = $this->pdo->prepare($query);

        $this->bindParams($stmt, $params);

        if (!$stmt->execute()) {
            throw new \Modelight\Exception('Unexpected PDO result. PDOStatement::execute returns false. errorInfo: ' . json_encode($stmt->errorInfo()));
        }

        $model->set($model->getPrimaryKey(), $this->pdo->lastInsertId());

        return $model;
    }

    /**
     * Update Model
     *
     * @param \Modelight\Model $model
     * @return \Modelight\Model
     * @throws \Modelight\Exception
     */
    public function update(\Modelight\Model $model)
    {
        $query = "UPDATE " . $model->getTableName() . " SET ";

        $setClauses = [];
        $params = [];

        foreach ($model->getFields() as $fieldName => $fieldDefinition) {
            if ($fieldName !== $model->getPrimaryKey()) {
                $setClauses[] = $fieldName . " = :" . $fieldName;
            }

            $params[$fieldName] = [
                'value' => $model->get($fieldName),
                'type' => $fieldDefinition['type']
            ];
        }

        $query .= " " . implode(", ", $setClauses);
        $query .= " WHERE " . $model->getPrimaryKey() . " = :" . $model->getPrimaryKey() . " ";

        $this->execute($query, $params);

        return $model;
    }

    /**
     * Delete Model
     *
     * @param \Modelight\Model $model
     * @return \Modelight\Model
     * @throws \Modelight\Exception
     */
    public function delete(\Modelight\Model $model)
    {
        $query = "DELETE FROM " . $model->getTableName() . " WHERE " . $model->getPrimaryKey() . " = :" . $model->getPrimaryKey();

        $fields = $model->getFields();

        $this->execute($query, [
            $model->getPrimaryKey() => [
                'value' => $model->get($model->getPrimaryKey()),
                'type' => $fields[$model->getPrimaryKey()]['type']
            ]
        ]);

        return $model;
    }

    /**
     * Prepare sortBy clause
     *
     * @param array $sortyBy Ex.: ['fieldName1' => 'ASC', 'fieldNameTest' => 'DESC']
     * @return string
     */
    protected function prepareSortByClause(array $sortyBy)
    {
        $clauses = [];
        foreach ($sortyBy as $fieldName => $sortOrder) {
            $clauses[] = $fieldName . " " . $sortOrder;
        }

        return count($clauses) > 0 ? " ORDER BY " . implode(', ', $clauses) : "";
    }

    /**
     * Prepare limit clause
     *
     * @param int|null $limit
     * @param int|null $offset
     * @return string
     */
    protected function prepareLimitClause($limit = null, $offset = null)
    {
        if ($limit === null && $offset === null) {
            return "";
        }

        if ($offset === null) {
            return " LIMIT " . (int)$limit . " ";
        }

        return " LIMIT " . (int)$offset . "," . (int)$limit . " ";
    }
}
