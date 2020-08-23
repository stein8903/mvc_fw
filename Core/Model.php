<?php

namespace Core;

use PDO;
use App\Config;

abstract class Model
{
    protected static function getDB()
    {
        static $db = null;
        if ($db === null) {
            $dsn = 'mysql:dbname=' . Config::DB_NAME . ';host=' . Config::DB_HOST;
            $user = Config::DB_USER;
            $pass = Config::DB_PASSWORD;
            try {
                $db = new PDO($dsn, $user, $pass);
            } catch (PDOException $e) {
                echo "接続失敗: " . $e->getMessage() . "\n";
                exit();
            }
        }

        return $db;
    }
}
