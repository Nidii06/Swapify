<?php

require_once __DIR__ . '/Config.php';

class Database
{
    private static $instance = null;
    private $connection = null;

    private function __construct()
    {
        $this->connect();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect()
    {
        if ($this->connection === null) {
            try {
                $host = Config::get('database.host');
                $dbname = Config::get('database.dbname');
                $username = Config::get('database.username');
                $password = Config::get('database.password');
                $charset = Config::get('database.charset', 'utf8mb4');

                $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";
                
                $this->connection = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]);
            } catch (PDOException $e) {
                error_log('Database connection failed: ' . $e->getMessage());
                throw new RuntimeException('Database connection failed. Please try again later.');
            }
        }
        return $this->connection;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function __clone()
    {
        throw new RuntimeException('Cannot clone singleton');
    }

    public function __wakeup()
    {
        throw new RuntimeException('Cannot unserialize singleton');
    }
}

