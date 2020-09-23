<?php

namespace Core;

use PDO;
use Dotenv\Dotenv;

abstract class Model
{
    protected static function getDB()
    {
        static $db = null;
        if ($db === null) {
            $dotenv = Dotenv::createMutable(dirname(__DIR__));
            $dotenv->load();

            $dsn = 'mysql:dbname=' . $_ENV['DB_NAME'] . ';host=' . $_ENV['DB_HOST'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASSWORD'];
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
