<?php
// Error Diagnostic Script
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Error Diagnostic</h1>";

// Test 1: Basic PHP
echo "<h2>Test 1: Basic PHP</h2>";
echo "✅ PHP is working<br>";
echo "PHP Version: " . phpversion() . "<br>";

// Test 2: File permissions
echo "<h2>Test 2: File Permissions</h2>";
$files = [
    __DIR__ . '/../app/Config/App.php',
    __DIR__ . '/../app/Config/Database.php',
    __DIR__ . '/../app/Core/Router.php',
    __DIR__ . '/../app/Core/Controller.php',
    __DIR__ . '/../app/Core/View.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✅ " . basename($file) . " exists<br>";
        if (is_readable($file)) {
            echo "✅ " . basename($file) . " is readable<br>";
        } else {
            echo "❌ " . basename($file) . " is not readable<br>";
        }
    } else {
        echo "❌ " . basename($file) . " does not exist<br>";
    }
}

// Test 3: Include files
echo "<h2>Test 3: Include Files</h2>";
try {
    require_once __DIR__ . '/../app/Config/App.php';
    echo "✅ App.php loaded<br>";
} catch (Exception $e) {
    echo "❌ App.php error: " . $e->getMessage() . "<br>";
}

try {
    require_once __DIR__ . '/../app/Config/Database.php';
    echo "✅ Database.php loaded<br>";
} catch (Exception $e) {
    echo "❌ Database.php error: " . $e->getMessage() . "<br>";
}

try {
    require_once __DIR__ . '/../app/Core/Router.php';
    echo "✅ Router.php loaded<br>";
} catch (Exception $e) {
    echo "❌ Router.php error: " . $e->getMessage() . "<br>";
}

// Test 4: Database connection
echo "<h2>Test 4: Database Connection</h2>";
try {
    $db = App\Config\Database::getInstance();
    if ($db->isConnected()) {
        echo "✅ Database connected<br>";
    } else {
        echo "⚠️ Database not connected (demo mode available)<br>";
    }
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

// Test 5: Memory usage
echo "<h2>Test 5: Memory Usage</h2>";
echo "Memory usage: " . memory_get_usage(true) / 1024 / 1024 . " MB<br>";
echo "Memory peak: " . memory_get_peak_usage(true) / 1024 / 1024 . " MB<br>";

// Test 6: Server variables
echo "<h2>Test 6: Server Variables</h2>";
echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'not set') . "<br>";
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'not set') . "<br>";
echo "DOCUMENT_ROOT: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'not set') . "<br>";

echo "<h2>Test Complete</h2>";
echo "<p>If you see any ❌ errors above, those are likely causing your 500 error.</p>";
?> 