<?php
// Simple Demo Mode Test
echo "<h1>Demo Mode Test</h1>";

// Test 1: Check if autoloader exists
echo "<h2>Test 1: Autoloader</h2>";
$autoloadPath = __DIR__ . '/../autoload.php';
if (file_exists($autoloadPath)) {
    echo "✅ Autoloader file exists<br>";
    require_once $autoloadPath;
    echo "✅ Autoloader loaded successfully<br>";
} else {
    echo "❌ Autoloader file not found at: $autoloadPath<br>";
}

// Test 2: Check MVC classes
echo "<h2>Test 2: MVC Classes</h2>";
if (class_exists('App\Config\App')) {
    echo "✅ App class exists<br>";
} else {
    echo "❌ App class not found<br>";
}

if (class_exists('App\Config\Database')) {
    echo "✅ Database class exists<br>";
} else {
    echo "❌ Database class not found<br>";
}

// Test 3: Database connection
echo "<h2>Test 3: Database Connection</h2>";
try {
    $db = App\Config\Database::getInstance();
    if ($db->isConnected()) {
        echo "✅ Database connected successfully<br>";
    } else {
        echo "⚠️ Database not connected - Demo mode available<br>";
    }
} catch (Exception $e) {
    echo "❌ Database Error: " . $e->getMessage() . "<br>";
}

echo "<h2>Demo Mode Instructions</h2>";
echo "<p>To use the application in demo mode:</p>";
echo "<ol>";
echo "<li>Go to <a href='index.php'>Main Application</a></li>";
echo "<li>Click 'Login' in the navigation</li>";
echo "<li>Use username: <strong>admin</strong> and password: <strong>admin123</strong></li>";
echo "<li>You'll see demo data instead of real database data</li>";
echo "</ol>";

echo "<p><a href='index.php'>Go to Main Application</a></p>";
?> 