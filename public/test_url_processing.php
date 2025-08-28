<?php
// Force error display for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>URL Processing and Router Dispatch Test</h1>";

try {
    echo "<h2>Step 1: Load All Required Components</h2>";
    
    // Load all the same files as main index.php
    require_once __DIR__ . '/../app/Config/App.php';
    require_once __DIR__ . '/../app/Config/Database.php';
    require_once __DIR__ . '/../app/Core/Router.php';
    require_once __DIR__ . '/../app/Core/Controller.php';
    require_once __DIR__ . '/../app/Core/View.php';
    
    // Load models
    require_once __DIR__ . '/../app/Models/GeoLink.php';
    require_once __DIR__ . '/../app/Models/GeoLog.php';
    require_once __DIR__ . '/../app/Models/User.php';
    require_once __DIR__ . '/../app/Models/SpeedTest.php';
    
    // Load controllers
    require_once __DIR__ . '/../app/Controllers/HomeController.php';
    require_once __DIR__ . '/../app/Controllers/DashboardController.php';
    require_once __DIR__ . '/../app/Controllers/GeologgerController.php';
    require_once __DIR__ . '/../app/Controllers/PhoneTrackerController.php';
    require_once __DIR__ . '/../app/Controllers/SpeedTestController.php';
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    require_once __DIR__ . '/../app/Controllers/AuthController.php';
    require_once __DIR__ . '/../app/Controllers/DebugController.php';
    
    echo "✓ All files loaded successfully<br>";
    
    echo "<h2>Step 2: Initialize Application</h2>";
    App\Config\App::init();
    echo "✓ App::init() completed<br>";
    
    echo "<h2>Step 3: Create Router and Add Routes</h2>";
    $router = new App\Core\Router();
    echo "✓ Router created<br>";
    
    // Add the same routes as main index.php
    $router->add('', ['controller' => 'HomeController', 'action' => 'index']);
    $router->add('home', ['controller' => 'HomeController', 'action' => 'index']);
    $router->add('dashboard', ['controller' => 'DashboardController', 'action' => 'index']);
    $router->add('about', ['controller' => 'HomeController', 'action' => 'about']);
    $router->add('contact', ['controller' => 'HomeController', 'action' => 'contact']);
    $router->add('privacy', ['controller' => 'HomeController', 'action' => 'privacy']);
    $router->add('support', ['controller' => 'HomeController', 'action' => 'support']);
    
    echo "✓ Routes added successfully<br>";
    
    echo "<h2>Step 4: Test URL Processing</h2>";
    
    // Simulate the exact URL processing from main index.php
    $url = $_SERVER['REQUEST_URI'] ?? '';
    echo "Original REQUEST_URI: " . ($url ?: 'NOT SET') . "<br>";
    
    if (empty($url)) {
        $url = $_SERVER['PATH_INFO'] ?? '';
        echo "PATH_INFO: " . ($url ?: 'NOT SET') . "<br>";
        if (empty($url)) {
            $url = $_SERVER['ORIG_PATH_INFO'] ?? '';
            echo "ORIG_PATH_INFO: " . ($url ?: 'NOT SET') . "<br>";
        }
    }
    
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $basePath = dirname($scriptName);
    echo "Script Name: " . $scriptName . "<br>";
    echo "Base Path: " . $basePath . "<br>";
    
    // Remove the base path from the URL
    if ($basePath !== '/' && $basePath !== '.') {
        $url = str_replace($basePath, '', $url);
    }
    
    // Remove any leading/trailing slashes
    $url = trim($url, '/');
    echo "Final processed URL: " . ($url ?: 'EMPTY') . "<br>";
    
    echo "<h2>Step 5: Test Router Dispatch</h2>";
    
    // Test with empty URL (homepage)
    try {
        echo "Testing dispatch with URL: '" . ($url ?: 'EMPTY') . "'<br>";
        $result = $router->dispatch($url);
        echo "✓ Router dispatch successful!<br>";
        echo "Result: " . $result . "<br>";
    } catch (Exception $e) {
        echo "✗ Router dispatch failed: " . $e->getMessage() . "<br>";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    } catch (Error $e) {
        echo "✗ Router dispatch failed with Error: " . $e->getMessage() . "<br>";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    }
    
    echo "<h2>Test Complete!</h2>";
    
} catch (Exception $e) {
    echo "✗ Main test failed: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
} catch (Error $e) {
    echo "✗ Main test failed with Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
}
?>
