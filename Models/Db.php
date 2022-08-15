<?php

namespace Shop\Models;

use \PDO;

class Db
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charse=' . $_ENV['DB_CHARSET'];
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $this->conn = new PDO($dsn, $_ENV['DB_USER'],  $_ENV['DB_PASS'], $opt);
    }

    public static function getInstance(): Db
    {
        if (self::$instance == null) {
            self::$instance = new Db();
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->conn;
    }
}