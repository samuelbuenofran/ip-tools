<?php
// Test URL generation
require_once __DIR__ . '/../app/Config/App.php';
require_once __DIR__ . '/../app/Core/View.php';

use App\Config\App;
use App\Core\View;

// Initialize the application
App::init();

// Create a view instance
$view = new View();

echo "<h1>URL Generation Test</h1>";

echo "<h2>Base URL Test:</h2>";
echo "<p>App::getBaseUrl(): " . App::getBaseUrl() . "</p>";
echo "<p>App::BASE_URL constant: " . App::BASE_URL . "</p>";

echo "<h2>URL Generation Test:</h2>";
echo "<p>Empty path: " . $view->url('') . "</p>";
echo "<p>Auth login: " . $view->url('auth/login') . "</p>";
echo "<p>Auth register: " . $view->url('auth/register') . "</p>";
echo "<p>Dashboard: " . $view->url('dashboard') . "</p>";
echo "<p>Home: " . $view->url('home') . "</p>";

echo "<h2>Test Links:</h2>";
echo "<p><a href='" . $view->url('auth/login') . "'>Test Login Page</a></p>";
echo "<p><a href='" . $view->url('auth/register') . "'>Test Register Page</a></p>";
echo "<p><a href='" . $view->url('dashboard') . "'>Test Dashboard</a></p>";

echo "<h2>Expected URLs:</h2>";
echo "<p>Login should be: " . App::getBaseUrl() . "/auth/login</p>";
echo "<p>Register should be: " . App::getBaseUrl() . "/auth/register</p>";
?>
