<?php
// Memory-optimized version of the main application
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set memory limit
ini_set('memory_limit', '128M');

// Start memory tracking
$startMemory = memory_get_usage(true);

try {
    // Step 1: Load core files one by one
    require_once '../app/Config/App.php';
    require_once '../app/Config/Database.php';
    require_once '../app/Core/Router.php';
    require_once '../app/Core/Controller.php';
    require_once '../app/Core/View.php';
    
    // Step 2: Load models (only if needed)
    require_once '../app/Models/GeoLink.php';
    require_once '../app/Models/GeoLog.php';
    require_once '../app/Models/User.php';
    
    // Step 3: Load controllers (only if needed)
    require_once '../app/Controllers/HomeController.php';
    require_once '../app/Controllers/DashboardController.php';
    require_once '../app/Controllers/GeologgerController.php';
    require_once '../app/Controllers/PhoneTrackerController.php';
    require_once '../app/Controllers/SpeedTestController.php';
    require_once '../app/Controllers/AdminController.php';
    require_once '../app/Controllers/AuthController.php';
    
    // Step 4: Initialize application
    App\Config\App::init();
    
    // Step 5: Create router with minimal routes
    $router = new App\Core\Router();
    
    // Add only essential routes
    $router->add('', ['controller' => 'HomeController', 'action' => 'index']);
    $router->add('home', ['controller' => 'HomeController', 'action' => 'index']);
    $router->add('about', ['controller' => 'HomeController', 'action' => 'about']);
    $router->add('contact', ['controller' => 'HomeController', 'action' => 'contact']);
    $router->add('privacy', ['controller' => 'HomeController', 'action' => 'privacy']);
    $router->add('support', ['controller' => 'HomeController', 'action' => 'support']);
    
    // Auth routes
    $router->add('auth/login', ['controller' => 'AuthController', 'action' => 'login']);
    $router->add('auth/loginPost', ['controller' => 'AuthController', 'action' => 'loginPost']);
    $router->add('auth/logout', ['controller' => 'AuthController', 'action' => 'logout']);
    
    // Get URL
    $url = $_SERVER['REQUEST_URI'] ?? '';
    $url = str_replace('/projects/ip-tools/public/', '', $url);
    $url = trim($url, '/');
    
    // Step 6: Dispatch
    $router->dispatch($url);
    
} catch (Exception $e) {
    // Memory usage at error
    $errorMemory = memory_get_usage(true);
    
    // Handle errors
    if ($e->getCode() === 404) {
        http_response_code(404);
        echo '<h1>404 - Page Not Found</h1>';
        echo '<p>The page you are looking for could not be found.</p>';
        echo '<a href="/projects/ip-tools/public/">Go Home</a>';
    } else {
        http_response_code(500);
        echo '<h1>500 - Internal Server Error</h1>';
        echo '<p>Error: ' . $e->getMessage() . '</p>';
        echo '<p>Memory usage: ' . round($errorMemory / 1024 / 1024, 2) . ' MB</p>';
        echo '<p>Peak memory: ' . round(memory_get_peak_usage(true) / 1024 / 1024, 2) . ' MB</p>';
        echo '<a href="/projects/ip-tools/public/">Go Home</a>';
    }
}

// Final memory check
$endMemory = memory_get_usage(true);
$peakMemory = memory_get_peak_usage(true);

// Log memory usage (only in debug mode)
if (defined('App\Config\App::DEBUG_MODE') && App\Config\App::DEBUG_MODE) {
    error_log("Memory usage: " . round($endMemory / 1024 / 1024, 2) . " MB");
    error_log("Peak memory: " . round($peakMemory / 1024 / 1024, 2) . " MB");
}
?> 