<?php

namespace Modelight;

interface DataSourceInterface
{
    /**
     * Executes query
     *
     * @param string $query
     * @param array $params
     * @return array
     * @throws \Modelight\Exception
     */
    public function query($query, array $params = array());

    /**
     * Find one Model by primary key value
     *
     * @param string $modelClassName
     * @param mixed $primaryKeyValue
     * @return \Modelight\Model
     * @throws \Modelight\Exception
     */
    public function find($modelClassName, $primaryKeyValue);

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
    public function findAll($modelClassName, $limit = null, $offset = null, array $sortBy = array());

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
    public function findBy($modelClassName, array $criterias, $limit = null, $offset = null, array $sortBy = array());

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
    public function findOneBy($modelClassName, array $criterias, $limit = null, $offset = null, array $sortBy = array());

    /**
     * Save Model
     *
     * @param \Modelight\Model $model
     * @return \Modelight\Model
     */
    public function save(\Modelight\Model $model);

    /**
     * Insert Model
     *
     * @param \Modelight\Model $model
     * @return \Modelight\Model
     */
    public function insert(\Modelight\Model $model);

    /**
     * Update Model
     *
     * @param \Modelight\Model $model
     * @return \Modelight\Model
     */
    public function update(\Modelight\Model $model);

    /**
     * Delete Model
     *
     * @param \Modelight\Model $model
     * @return \Modelight\Model
     */
    public function delete(\Modelight\Model $model);
}
