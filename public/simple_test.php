<?php
echo "<h1>Simple Test</h1>";

// Test 1: Basic PHP
echo "<h2>Test 1: Basic PHP</h2>";
echo "<p style='color: green;'>✅ PHP is working!</p>";

// Test 2: Check if files exist
echo "<h2>Test 2: File Existence</h2>";
$files = [
    '../app/Core/Router.php',
    '../app/Core/Controller.php',
    '../app/Core/View.php',
    '../app/Config/App.php',
    '../app/Config/Database.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✅ " . basename($file) . " exists</p>";
    } else {
        echo "<p style='color: red;'>❌ " . basename($file) . " missing</p>";
    }
}

// Test 3: Try to include Router directly
echo "<h2>Test 3: Direct Include</h2>";
try {
    require_once '../app/Core/Router.php';
    echo "<p style='color: green;'>✅ Router.php included successfully!</p>";
    
    if (class_exists('App\\Core\\Router')) {
        echo "<p style='color: green;'>✅ Router class exists!</p>";
        $router = new App\Core\Router();
        echo "<p style='color: green;'>✅ Router instantiated!</p>";
    } else {
        echo "<p style='color: red;'>❌ Router class not found after include!</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error including Router: " . $e->getMessage() . "</p>";
}

// Test 4: Check file contents
echo "<h2>Test 4: File Contents</h2>";
$routerContent = file_get_contents('../app/Core/Router.php');
echo "<p>Router.php first 100 chars: " . htmlspecialchars(substr($routerContent, 0, 100)) . "</p>";

echo "<hr>";
echo "<p><a href='index.php'>Try Main App</a></p>";
?> 