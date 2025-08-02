<?php
namespace App\Config;

class Database {
    private static $instance = null;
    private $connection;
    private $isConnected = false;
    
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
            $this->isConnected = true;
        } catch (\PDOException $e) {
            // Log the error but don't throw - allow demo mode
            error_log("Database connection failed: " . $e->getMessage());
            $this->isConnected = false;
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function isConnected() {
        return $this->isConnected;
    }
    
    public function getConnection() {
        if (!$this->isConnected) {
            throw new \Exception("Database connection failed. Running in demo mode.");
        }
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        if (!$this->isConnected) {
            throw new \Exception("Database connection failed. Running in demo mode.");
        }
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    public function lastInsertId() {
        if (!$this->isConnected) {
            throw new \Exception("Database connection failed. Running in demo mode.");
        }
        return $this->connection->lastInsertId();
    }
} 