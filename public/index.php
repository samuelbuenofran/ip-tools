<?php
// Prevent any output before session start
ob_start();

// Direct includes - bypass autoloader completely
require_once __DIR__ . '/../app/Config/App.php';
require_once __DIR__ . '/../app/Config/Database.php';
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/Controller.php';
require_once __DIR__ . '/../app/Core/View.php';

// Load models after core classes
require_once __DIR__ . '/../app/Models/GeoLink.php';
require_once __DIR__ . '/../app/Models/GeoLog.php';
require_once __DIR__ . '/../app/Models/User.php';
require_once __DIR__ . '/../app/Models/SpeedTest.php';

// Include all controllers
require_once __DIR__ . '/../app/Controllers/HomeController.php';
require_once __DIR__ . '/../app/Controllers/DashboardController.php';
require_once __DIR__ . '/../app/Controllers/GeologgerController.php';
require_once __DIR__ . '/../app/Controllers/PhoneTrackerController.php';
require_once __DIR__ . '/../app/Controllers/SpeedTestController.php';
require_once __DIR__ . '/../app/Controllers/AdminController.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/DebugController.php';

// Initialize application
use App\Config\App;
use App\Core\Router;

// Initialize the application
App::init();

// Create router instance
$router = new Router();

// Define routes
$router->add('', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('home', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('dashboard', ['controller' => 'DashboardController', 'action' => 'index']);
$router->add('about', ['controller' => 'HomeController', 'action' => 'about']);
$router->add('contact', ['controller' => 'HomeController', 'action' => 'contact']);
$router->add('privacy', ['controller' => 'HomeController', 'action' => 'privacy']);
$router->add('support', ['controller' => 'HomeController', 'action' => 'support']);

// Geologger routes
$router->add('geologger/create', ['controller' => 'GeologgerController', 'action' => 'create']);
$router->add('geologger/logs', ['controller' => 'GeologgerController', 'action' => 'logs']);
$router->add('geologger/my-links', ['controller' => 'GeologgerController', 'action' => 'myLinks']);
$router->add('geologger/precise_track', ['controller' => 'GeologgerController', 'action' => 'preciseTrack']);
$router->add('geologger/save_precise_location', ['controller' => 'GeologgerController', 'action' => 'savePreciseLocation']);

// Phone tracker routes
$router->add('phone-tracker/send_sms', ['controller' => 'PhoneTrackerController', 'action' => 'sendSms']);
$router->add('phone-tracker/track', ['controller' => 'PhoneTrackerController', 'action' => 'track']);
$router->add('phone-tracker/tracking_logs', ['controller' => 'PhoneTrackerController', 'action' => 'trackingLogs']);

// Speed test routes
$router->add('speed-test', ['controller' => 'SpeedTestController', 'action' => 'index']);
$router->add('speed-test/save', ['controller' => 'SpeedTestController', 'action' => 'save']);
$router->add('speed-test/analytics', ['controller' => 'SpeedTestController', 'action' => 'analytics']);
$router->add('speed-test/export', ['controller' => 'SpeedTestController', 'action' => 'export']);

// Admin routes
$router->add('admin', ['controller' => 'AdminController', 'action' => 'index']);
$router->add('admin/privacy_settings', ['controller' => 'AdminController', 'action' => 'privacySettings']);
$router->add('admin/test_dashboard', ['controller' => 'AdminController', 'action' => 'testDashboard']);

// Debug routes (admin only)
$router->add('debug', ['controller' => 'DebugController', 'action' => 'index']);
$router->add('debug/database', ['controller' => 'DebugController', 'action' => 'database']);
$router->add('debug/scripts', ['controller' => 'DebugController', 'action' => 'scripts']);
$router->add('debug/system', ['controller' => 'DebugController', 'action' => 'system']);

// Authentication routes
$router->add('auth/login', ['controller' => 'AuthController', 'action' => 'login']);
$router->add('auth/loginPost', ['controller' => 'AuthController', 'action' => 'loginPost']);
$router->add('auth/register', ['controller' => 'AuthController', 'action' => 'register']);
$router->add('auth/registerPost', ['controller' => 'AuthController', 'action' => 'registerPost']);
$router->add('auth/logout', ['controller' => 'AuthController', 'action' => 'logout']);
$router->add('auth/profile', ['controller' => 'AuthController', 'action' => 'profile']);
$router->add('auth/updateProfile', ['controller' => 'AuthController', 'action' => 'updateProfile']);
$router->add('auth/changePassword', ['controller' => 'AuthController', 'action' => 'changePassword']);

// Dashboard routes (require authentication)
$router->add('dashboard/createLink', ['controller' => 'DashboardController', 'action' => 'createLink']);
$router->add('dashboard/links', ['controller' => 'DashboardController', 'action' => 'links']);
$router->add('dashboard/logs', ['controller' => 'DashboardController', 'action' => 'logs']);
$router->add('dashboard/deleteLink', ['controller' => 'DashboardController', 'action' => 'deleteLink']);

// Get the URL path
$url = $_SERVER['REQUEST_URI'] ?? '';

// If REQUEST_URI is not set (like in CLI), try to get it from other sources
if (empty($url)) {
    $url = $_SERVER['PATH_INFO'] ?? '';
    if (empty($url)) {
        $url = $_SERVER['ORIG_PATH_INFO'] ?? '';
    }
}

// Simplify URL processing - just remove the base path
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$basePath = dirname($scriptName);

// Remove the base path from the URL
if ($basePath !== '/' && $basePath !== '.') {
    $url = str_replace($basePath, '', $url);
}

// Remove any leading/trailing slashes
$url = trim($url, '/');

// Debug information (remove this in production)
if (App::DEBUG_MODE) {
    error_log("Original REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'NOT SET'));
    error_log("Script Name: " . ($_SERVER['SCRIPT_NAME'] ?? 'NOT SET'));
    error_log("Base Path: " . $basePath);
    error_log("Processed URL: " . $url);
}

try {
    // Debug: Log the final URL being processed
    if (App::DEBUG_MODE) {
        error_log("Final URL to dispatch: " . $url);
    }
    
    // Dispatch the request
    $router->dispatch($url);
} catch (Exception $e) {
    // Handle errors
    if ($e->getCode() === 404) {
        http_response_code(404);
        echo '<h1>404 - Page Not Found</h1>';
        echo '<p>The page you are looking for could not be found.</p>';
        echo '<a href="/projects/ip-tools/public/">Go Home</a>';
    } else {
        http_response_code(500);
        if (App::DEBUG_MODE) {
            echo '<h1>500 - Internal Server Error</h1>';
            echo '<p>' . $e->getMessage() . '</p>';
            echo '<pre>' . $e->getTraceAsString() . '</pre>';
        } else {
            echo '<h1>500 - Internal Server Error</h1>';
            echo '<p>An error occurred. Please try again later.</p>';
        }
    }
}

// Flush output buffer
ob_end_flush();
?> 