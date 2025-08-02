<?php
namespace App\Config;

class Database {
    private static $instance = null;
    private $connection;
    
    private $host = 'localhost';
    private $dbname = 'techeletric_ip_tools';
    private $username = 'techeletric_ip_tools';
    private $password = 'zsP2rDZDaTea2YEhegmH';
    
    private function __construct() {
        try {
            $this->connection = new \PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->username,
                $this->password,
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
        } catch (\PDOException $e) {
            throw new \Exception("Database connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }
} 