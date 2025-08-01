<?php
echo "<h1>Autoloader Debug</h1>";

// Test 1: Check if autoloader is working
echo "<h2>Test 1: Autoloader Registration</h2>";
try {
    require_once '../autoload.php';
    echo "<p style='color: green;'>✅ Autoloader loaded successfully!</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Autoloader error: " . $e->getMessage() . "</p>";
}

// Test 2: Check if Router class can be found
echo "<h2>Test 2: Router Class Check</h2>";
$routerFile = '../app/Core/Router.php';
if (file_exists($routerFile)) {
    echo "<p style='color: green;'>✅ Router.php file exists at: $routerFile</p>";
    
    // Check file contents
    $content = file_get_contents($routerFile);
    if (strpos($content, 'namespace App\\Core') !== false) {
        echo "<p style='color: green;'>✅ Router.php has correct namespace!</p>";
    } else {
        echo "<p style='color: red;'>❌ Router.php namespace issue!</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Router.php file not found!</p>";
}

// Test 3: Try to load Router class
echo "<h2>Test 3: Router Class Loading</h2>";
try {
    if (class_exists('App\\Core\\Router')) {
        echo "<p style='color: green;'>✅ Router class exists!</p>";
        $router = new App\Core\Router();
        echo "<p style='color: green;'>✅ Router class instantiated successfully!</p>";
    } else {
        echo "<p style='color: red;'>❌ Router class not found!</p>";
        
        // Try manual include
        echo "<p>Trying manual include...</p>";
        require_once '../app/Core/Router.php';
        if (class_exists('App\\Core\\Router')) {
            echo "<p style='color: green;'>✅ Router class loaded manually!</p>";
        } else {
            echo "<p style='color: red;'>❌ Router class still not found after manual include!</p>";
        }
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Router class error: " . $e->getMessage() . "</p>";
}

// Test 4: Check all required files
echo "<h2>Test 4: Required Files Check</h2>";
$requiredFiles = [
    '../app/Config/App.php',
    '../app/Config/Database.php',
    '../app/Core/Controller.php',
    '../app/Core/View.php',
    '../app/Models/GeoLink.php',
    '../app/Models/GeoLog.php',
    '../app/Models/User.php'
];

foreach ($requiredFiles as $file) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✅ " . basename($file) . " exists</p>";
    } else {
        echo "<p style='color: red;'>❌ " . basename($file) . " missing</p>";
    }
}

// Test 5: Check namespace structure
echo "<h2>Test 5: Namespace Structure</h2>";
$namespaces = [
    'App\\Config\\App',
    'App\\Config\\Database',
    'App\\Core\\Router',
    'App\\Core\\Controller',
    'App\\Core\\View',
    'App\\Models\\GeoLink',
    'App\\Models\\GeoLog',
    'App\\Models\\User'
];

foreach ($namespaces as $namespace) {
    if (class_exists($namespace)) {
        echo "<p style='color: green;'>✅ $namespace class exists</p>";
    } else {
        echo "<p style='color: red;'>❌ $namespace class not found</p>";
    }
}

echo "<hr>";
echo "<p><a href='index.php'>Try Main Application Again</a></p>";
?> 