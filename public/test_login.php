<?php
// Test login functionality
require_once __DIR__ . '/../app/Config/App.php';
require_once __DIR__ . '/../app/Config/Database.php';
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/Controller.php';
require_once __DIR__ . '/../app/Core/View.php';
require_once __DIR__ . '/../app/Models/User.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';

use App\Config\App;
use App\Core\Router;
use App\Controllers\AuthController;

// Initialize the application
App::init();

echo "<h1>Login Test</h1>";

// Test 1: Check if AuthController can be instantiated
try {
    $authController = new AuthController();
    echo "<p style='color: green;'>✓ AuthController instantiated successfully</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ AuthController instantiation failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Test 2: Check if login method exists
try {
    if (method_exists($authController, 'login')) {
        echo "<p style='color: green;'>✓ Login method exists</p>";
    } else {
        echo "<p style='color: red;'>✗ Login method does not exist</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error checking login method: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Test 3: Check if login view file exists
$loginViewFile = __DIR__ . '/../app/Views/auth/login.php';
if (file_exists($loginViewFile)) {
    echo "<p style='color: green;'>✓ Login view file exists</p>";
} else {
    echo "<p style='color: red;'>✗ Login view file does not exist at: " . htmlspecialchars($loginViewFile) . "</p>";
}

// Test 4: Test router with auth/login route
try {
    $router = new Router();
    $router->add('auth/login', ['controller' => 'AuthController', 'action' => 'login']);
    
    if ($router->match('auth/login')) {
        echo "<p style='color: green;'>✓ Router matches auth/login route</p>";
        $params = $router->getParams();
        echo "<p><strong>Route Parameters:</strong> " . htmlspecialchars(json_encode($params)) . "</p>";
    } else {
        echo "<p style='color: red;'>✗ Router does not match auth/login route</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Router test failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<h2>Test Links:</h2>";
echo "<p><a href='auth/login'>Test Login Page</a></p>";
echo "<p><a href=''>Test Home Page</a></p>";
?>

