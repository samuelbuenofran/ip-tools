<?php
echo "<h1>PHP Session Constants Test</h1>";

echo "<h2>Checking Session Constants:</h2>";
echo "<p>PHP_SESSION_NONE: " . (defined('PHP_SESSION_NONE') ? 'DEFINED' : 'NOT DEFINED') . "</p>";
echo "<p>PHP_SESSION_ACTIVE: " . (defined('PHP_SESSION_ACTIVE') ? 'DEFINED' : 'NOT DEFINED') . "</p>";
echo "<p>PHP_SESSION_DISABLED: " . (defined('PHP_SESSION_DISABLED') ? 'DEFINED' : 'NOT DEFINED') . "</p>";

echo "<h2>Current Session Status:</h2>";
echo "<p>session_status(): " . session_status() . "</p>";

echo "<h2>Headers Sent Check:</h2>";
echo "<p>headers_sent(): " . (headers_sent() ? 'YES' : 'NO') . "</p>";

echo "<h2>Testing App::init():</h2>";
require_once __DIR__ . '/../app/Config/App.php';
use App\Config\App;

try {
    echo "<p>✓ App class loaded</p>";
    
    App::init();
    echo "<p>✓ App::init() completed successfully</p>";
    
} catch (Exception $e) {
    echo "<p>✗ App::init() failed: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
} catch (Error $e) {
    echo "<p>✗ App::init() failed with Error: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
}
?>
