<?php
// config.php

// Database configuration
$db_host = 'localhost';
$db_name = 'techeletric_ip_tools';
$db_user = 'techeletric_ip_tools';
$db_pass = 'your_password_here';

// Developer settings
$DEV_MODE = false; // Set to true for development features
$DEV_LANGUAGE = 'en'; // 'en' for English, 'pt' for Portuguese (only when DEV_MODE is true)

// Language helper function
function getTranslation($key, $default = '') {
    global $DEV_MODE, $DEV_LANGUAGE;
    
    // Always return English by default unless in dev mode with Portuguese
    if (!$DEV_MODE || $DEV_LANGUAGE !== 'pt') {
        return $default;
    }
    
    // Load Portuguese translations if available
    $pt_file = __DIR__ . '/languages/pt.php';
    if (file_exists($pt_file)) {
        include $pt_file;
        return $translations[$key] ?? $default;
    }
    
    return $default;
}

// Privacy and Security Settings
define('SHOW_LOCATION_MESSAGES', false); // Set to false to hide location tracking messages
define('SHOW_TRACKING_UI', false); // Set to false to hide all tracking-related UI elements

// PDO connection function
function connectDB() {
    global $db_host, $db_name, $db_user, $db_pass;
    try {
        $pdo = new PDO(
            'mysql:host=' . $db_host . ';dbname=' . $db_name,
            $db_user,
            $db_pass,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        return $pdo;
    } catch (PDOException $e) {
        die("❌ DB Connection Failed: " . $e->getMessage());
    }
}
?>
