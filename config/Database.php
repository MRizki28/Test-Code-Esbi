<?php

namespace Config;

use Dotenv\Dotenv;
use PDO;

class Database
{
    protected $pdo;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $DB_HOST = $_ENV['DB_HOST'];
        $DB_PORT = $_ENV['DB_PORT'];
        $DB_DATABASE = $_ENV['DB_DATABASE'];
        $DB_USERNAME = $_ENV['DB_USERNAME'];
        $DB_PASSWORD = $_ENV['DB_PASSWORD'];

        $dataSourceName = "mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_DATABASE";

        try {
            $this->pdo = new PDO($dataSourceName, $DB_USERNAME, $DB_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Failed connect to database: " . $e->getMessage();
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
