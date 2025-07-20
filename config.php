<?php
// config.php

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'techeletric_ip_tools');
define('DB_USER', 'techeletric_ip_tools');
define('DB_PASS', 'zsP2rDZDaTea2YEhegmH');

// PDO connection function
function connectDB() {
    try {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
            DB_USER,
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        return $pdo;
    } catch (PDOException $e) {
        die("?? DB Connection Failed: " . $e->getMessage());
    }
}
?>
