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
