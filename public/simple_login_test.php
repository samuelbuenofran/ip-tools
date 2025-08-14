<?php
// Simple login test
session_start();

echo "<h1>Simple Login Test</h1>";

// Test 1: Check if we can access the AuthController
try {
    require_once __DIR__ . '/../app/Config/App.php';
    require_once __DIR__ . '/../app/Config/Database.php';
    require_once __DIR__ . '/../app/Core/Controller.php';
    require_once __DIR__ . '/../app/Core/View.php';
    require_once __DIR__ . '/../app/Controllers/AuthController.php';

    // Initialize the application
    App\Config\App::init();
    
    echo "<p style='color: green;'>✓ Required files loaded successfully</p>";
    
    // Test 2: Try to create AuthController
    $auth = new App\Controllers\AuthController();
    echo "<p style='color: green;'>✓ AuthController created successfully</p>";
    
    // Test 3: Try to call login method
    try {
        $auth->login();
        echo "<p style='color: green;'>✓ Login method executed successfully</p>";
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠ Login method had an issue: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>Stack trace:</strong></p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

echo "<h2>Server Information:</h2>";
echo "<p><strong>HTTP_HOST:</strong> " . htmlspecialchars($_SERVER['HTTP_HOST'] ?? 'NOT SET') . "</p>";
echo "<p><strong>REQUEST_URI:</strong> " . htmlspecialchars($_SERVER['REQUEST_URI'] ?? 'NOT SET') . "</p>";
echo "<p><strong>SCRIPT_NAME:</strong> " . htmlspecialchars($_SERVER['SCRIPT_NAME'] ?? 'NOT SET') . "</p>";
echo "<p><strong>PHP_SELF:</strong> " . htmlspecialchars($_SERVER['PHP_SELF'] ?? 'NOT SET') . "</p>";

echo "<h2>Test Links:</h2>";
echo "<p><a href='index.php'>Main Index</a></p>";
echo "<p><a href='index.php/auth/login'>Login via Index</a></p>";
?>
