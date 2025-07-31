<?php
// config.php

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'techeletric_ip_tools');
define('DB_USER', 'techeletric_ip_tools');
define('DB_PASS', 'zsP2rDZDaTea2YEhegmH');

// Privacy and Security Settings
define('SHOW_LOCATION_MESSAGES', false); // Set to false to hide location tracking messages
define('SHOW_TRACKING_UI', false); // Set to false to hide all tracking-related UI elements

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
        die("❌ DB Connection Failed: " . $e->getMessage());
    }
}
?>
