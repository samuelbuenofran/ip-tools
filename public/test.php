<?php
// Simple test to verify MVC structure
require_once '../autoload.php';

use App\Config\App;
use App\Config\Database;

// Initialize app
App::init();

echo "<h1>MVC Test</h1>";
echo "<p>✅ App initialized successfully</p>";

// Test database connection
try {
    $db = Database::getInstance();
    echo "<p>✅ Database connection successful</p>";
} catch (Exception $e) {
    echo "<p>❌ Database connection failed: " . $e->getMessage() . "</p>";
}

// Test autoloader
try {
    $router = new App\Core\Router();
    echo "<p>✅ Router loaded successfully</p>";
} catch (Exception $e) {
    echo "<p>❌ Router failed: " . $e->getMessage() . "</p>";
}

// Test controller
try {
    $controller = new App\Controllers\HomeController();
    echo "<p>✅ HomeController loaded successfully</p>";
} catch (Exception $e) {
    echo "<p>❌ HomeController failed: " . $e->getMessage() . "</p>";
}

echo "<p><strong>MVC Structure Test Complete</strong></p>";
?> 