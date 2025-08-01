<?php
// Autoloader - Use development autoloader if vendor doesn't exist
if (file_exists('../vendor/autoload.php')) {
    require_once '../vendor/autoload.php';
} else {
    require_once '../autoload.php';
}

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
$router->add('geologger/precise_track', ['controller' => 'GeologgerController', 'action' => 'preciseTrack']);
$router->add('geologger/save_precise_location', ['controller' => 'GeologgerController', 'action' => 'savePreciseLocation']);

// Phone tracker routes
$router->add('phone-tracker/send_sms', ['controller' => 'PhoneTrackerController', 'action' => 'sendSms']);
$router->add('phone-tracker/track', ['controller' => 'PhoneTrackerController', 'action' => 'track']);
$router->add('phone-tracker/tracking_logs', ['controller' => 'PhoneTrackerController', 'action' => 'trackingLogs']);

// Speed test routes
$router->add('utils/speedtest', ['controller' => 'SpeedTestController', 'action' => 'index']);
$router->add('utils/save_speed_test', ['controller' => 'SpeedTestController', 'action' => 'save']);
$router->add('utils/speed_analytics', ['controller' => 'SpeedTestController', 'action' => 'analytics']);

// Admin routes
$router->add('admin/privacy_settings', ['controller' => 'AdminController', 'action' => 'privacySettings']);

// Authentication routes
$router->add('login', ['controller' => 'AuthController', 'action' => 'login']);
$router->add('register', ['controller' => 'AuthController', 'action' => 'register']);
$router->add('logout', ['controller' => 'AuthController', 'action' => 'logout']);
$router->add('profile', ['controller' => 'AuthController', 'action' => 'profile']);
$router->add('auth/login', ['controller' => 'AuthController', 'action' => 'login']);
$router->add('auth/register', ['controller' => 'AuthController', 'action' => 'register']);
$router->add('auth/logout', ['controller' => 'AuthController', 'action' => 'logout']);
$router->add('auth/profile', ['controller' => 'AuthController', 'action' => 'profile']);

// Get the URL path
$url = $_SERVER['REQUEST_URI'] ?? '';
$url = str_replace('/projects/ip-tools/public/', '', $url);
$url = trim($url, '/');

try {
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