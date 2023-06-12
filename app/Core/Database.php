<?php

namespace Core;

use PDO;

/**
 * The Database trait provides methods for connecting to the database and executing queries.
 */
Trait Database
{
    /**
     * Establishes a database connection based on the configuration.
     *
     * @throws \Exception If there is a database configuration error.
     * @return PDO A PDO object representing the database connection.
     */
    protected function connect()
    {
        $cfg = require "../config/db.php";
        $driver = $cfg['default'];

        if (!array_key_exists($driver, $cfg['connections'] ?? [])) {
            throw new \Exception("DB configuration error");
        }

        $cfg = $cfg['connections'][$driver];

        $string = "mysql:hostname=" . $cfg['host'] . ";dbname=" . $cfg['db'];
        return new PDO($string, $cfg['user'], $cfg['pwd']);
    }

    /**
     * Executes a database query.
     *
     * @param string $query The SQL query to execute.
     * @param array $data An associative array of data to bind to the query parameters (default: []).
     * @return array|false An array of objects representing the query result, or false on failure.
     */
    public function query($query, $data = [])
    {
        $con = $this->connect();
        $stmt = $con->prepare($query);

        $check = $stmt->execute($data);
        if ($check) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            if (is_array($result) && count($result)) {
                return $result;
            }
        }

        return false;
    }

    /**
     * Executes a database query and returns the first row of the result.
     *
     * @param string $query The SQL query to execute.
     * @param array $data An associative array of data to bind to the query parameters (default: []).
     * @return object|false The first row of the query result as an object, or false on failure.
     */
    public function get_row($query, $data = [])
    {
        $con = $this->connect();
        $stmt = $con->prepare($query);

        $check = $stmt->execute($data);
        if ($check) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            if (is_array($result) && count($result)) {
                return $result[0];
            }
        }

        return false;
    }
}
