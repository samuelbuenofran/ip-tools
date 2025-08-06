<?php
// Simplified version to test for memory leaks and 500 errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>IP Tools Suite - Simple Test</h1>";

// Test 1: Basic includes
echo "<h2>Step 1: Loading Core Files</h2>";
try {
    require_once __DIR__ . '/../app/Config/App.php';
    echo "✅ App.php loaded<br>";
    
    require_once __DIR__ . '/../app/Config/Database.php';
    echo "✅ Database.php loaded<br>";
    
    require_once __DIR__ . '/../app/Core/Router.php';
    echo "✅ Router.php loaded<br>";
    
    require_once __DIR__ . '/../app/Core/Controller.php';
    echo "✅ Controller.php loaded<br>";
    
    require_once __DIR__ . '/../app/Core/View.php';
    echo "✅ View.php loaded<br>";
    
} catch (Exception $e) {
    echo "❌ Error loading files: " . $e->getMessage() . "<br>";
    exit;
}

// Test 2: Initialize App
echo "<h2>Step 2: Initialize Application</h2>";
try {
    App\Config\App::init();
    echo "✅ Application initialized<br>";
} catch (Exception $e) {
    echo "❌ App init error: " . $e->getMessage() . "<br>";
}

// Test 3: Database
echo "<h2>Step 3: Database Test</h2>";
try {
    $db = App\Config\Database::getInstance();
    if ($db->isConnected()) {
        echo "✅ Database connected<br>";
    } else {
        echo "⚠️ Database not connected - Demo mode available<br>";
    }
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

// Test 4: Router
echo "<h2>Step 4: Router Test</h2>";
try {
    $router = new App\Core\Router();
    echo "✅ Router created<br>";
} catch (Exception $e) {
    echo "❌ Router error: " . $e->getMessage() . "<br>";
}

// Test 5: Memory check
echo "<h2>Step 5: Memory Usage</h2>";
echo "Current memory: " . round(memory_get_usage(true) / 1024 / 1024, 2) . " MB<br>";
echo "Peak memory: " . round(memory_get_peak_usage(true) / 1024 / 1024, 2) . " MB<br>";

// Test 6: Simple routing test
echo "<h2>Step 6: Simple Routing Test</h2>";
try {
    $url = $_SERVER['REQUEST_URI'] ?? '';
    $url = str_replace('/projects/ip-tools/public/', '', $url);
    $url = trim($url, '/');
    
    echo "URL: '$url'<br>";
    
    // Add a simple route
    $router->add('test', ['controller' => 'HomeController', 'action' => 'index']);
    
    if ($url === 'test') {
        echo "✅ Route 'test' would be dispatched<br>";
    } else {
        echo "ℹ️ No matching route for '$url'<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Routing error: " . $e->getMessage() . "<br>";
}

echo "<h2>Test Complete</h2>";
echo "<p>If all steps show ✅, your application should work. If you see ❌, that's the issue.</p>";
echo "<p><a href='index.php'>Try Full Application</a></p>";
?> 