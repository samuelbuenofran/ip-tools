<?php
// Test routing functionality
require_once __DIR__ . '/../app/Config/App.php';
require_once __DIR__ . '/../app/Core/Router.php';

use App\Config\App;
use App\Core\Router;

// Initialize the application
App::init();

// Create router instance
$router = new Router();

// Define a test route
$router->add('test', ['controller' => 'TestController', 'action' => 'index']);

// Get the URL path
$url = $_SERVER['REQUEST_URI'] ?? '';

// Remove the base path from the URL
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$basePath = dirname($scriptName);
if ($basePath !== '/') {
    $url = str_replace($basePath, '', $url);
}

// Remove any leading/trailing slashes
$url = trim($url, '/');

echo "<h1>Routing Test</h1>";
echo "<h2>Debug Information:</h2>";
echo "<p><strong>Original REQUEST_URI:</strong> " . htmlspecialchars($_SERVER['REQUEST_URI'] ?? 'NOT SET') . "</p>";
echo "<p><strong>Script Name:</strong> " . htmlspecialchars($_SERVER['SCRIPT_NAME'] ?? 'NOT SET') . "</p>";
echo "<p><strong>Base Path:</strong> " . htmlspecialchars($basePath) . "</p>";
echo "<p><strong>Processed URL:</strong> " . htmlspecialchars($url) . "</p>";

echo "<h2>Available Routes:</h2>";
$routes = $router->getRoutes();
echo "<ul>";
foreach ($routes as $route => $params) {
    echo "<li><strong>" . htmlspecialchars($route) . "</strong> → " . htmlspecialchars(json_encode($params)) . "</li>";
}
echo "</ul>";

echo "<h2>Route Matching Test:</h2>";
if ($router->match($url)) {
    echo "<p style='color: green;'>✓ URL matches a route!</p>";
    $params = $router->getParams();
    echo "<p><strong>Matched Parameters:</strong> " . htmlspecialchars(json_encode($params)) . "</p>";
} else {
    echo "<p style='color: red;'>✗ URL does not match any route.</p>";
}

echo "<h2>Test Links:</h2>";
echo "<p><a href='test'>Test Route</a></p>";
echo "<p><a href='auth/login'>Login Route</a></p>";
echo "<p><a href=''>Home Route</a></p>";
?>
