<?php

namespace Modelight;

class Database extends \PDO
{
    /**
     * Database constructor
     * @param string $dsn
     * @param string $username
     * @param string $passwd
     * @param array $options
     */
    public function __construct($dsn, $username, $passwd, $options)
    {
        parent::__construct($dsn, $username, $passwd, $options);
    }
}
