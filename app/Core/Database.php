<?php

namespace Core;

use PDO;

Trait Database
{
    protected function connect()
    {
        $cfg = require "../config/db.php";
        $driver = $cfg['default'];

        if(!array_key_exists($driver, $cfg['connections'] ?? [])) {
            throw new \Exception("DB configuration error");
        }

        $cfg = $cfg['connections'][$driver];

        $string = "mysql:hostname=".$cfg['host'].";dbname=".$cfg['db'];
        return new PDO($string, $cfg['user'], $cfg['pwd']);
    }

    public function query($query, $data = [])
    {

        $con = $this->connect();
        $stmt = $con->prepare($query);

        $check = $stmt->execute($data);
        if($check)
        {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            if(is_array($result) && count($result))
            {
                return $result;
            }
        }

        return false;
    }

    public function get_row($query, $data = [])
    {

        $con = $this->connect();
        $stmt = $con->prepare($query);

        $check = $stmt->execute($data);
        if($check)
        {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            if(is_array($result) && count($result))
            {
                return $result[0];
            }
        }

        return false;
    }

}


