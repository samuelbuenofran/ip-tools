<?php
// Test Demo Mode functionality
require_once __DIR__ . '/../autoload.php';

echo "<h1>Demo Mode Test</h1>";

// Test 1: Check if MVC classes load
echo "<h2>Test 1: MVC Structure</h2>";
try {
    if (class_exists('App\Config\App')) {
        echo "✅ App class loaded<br>";
    } else {
        echo "❌ App class not found<br>";
    }
    
    if (class_exists('App\Config\Database')) {
        echo "✅ Database class loaded<br>";
    } else {
        echo "❌ Database class not found<br>";
    }
    
    if (class_exists('App\Controllers\AuthController')) {
        echo "✅ AuthController loaded<br>";
    } else {
        echo "❌ AuthController not found<br>";
    }
    
} catch (Exception $e) {
    echo "❌ MVC Error: " . $e->getMessage() . "<br>";
}

// Test 2: Check Database Connection
echo "<h2>Test 2: Database Connection</h2>";
try {
    $db = App\Config\Database::getInstance();
    if ($db->isConnected()) {
        echo "✅ Database connected successfully<br>";
    } else {
        echo "⚠️ Database not connected - Demo mode will be used<br>";
    }
} catch (Exception $e) {
    echo "❌ Database Error: " . $e->getMessage() . "<br>";
}

// Test 3: Test Demo Login
echo "<h2>Test 3: Demo Login</h2>";
echo "<p>You can login with these demo credentials:</p>";
echo "<ul>";
echo "<li><strong>Username:</strong> admin</li>";
echo "<li><strong>Password:</strong> admin123</li>";
echo "</ul>";

echo "<h2>How to Use Demo Mode</h2>";
echo "<ol>";
echo "<li>Go to <a href='index.php'>Main Application</a></li>";
echo "<li>Click 'Login' in the navigation</li>";
echo "<li>Use username: <strong>admin</strong> and password: <strong>admin123</strong></li>";
echo "<li>You'll see demo data instead of real database data</li>";
echo "<li>All features will work with sample data</li>";
echo "</ol>";

echo "<h2>Next Steps</h2>";
echo "<p>To fix the database connection:</p>";
echo "<ol>";
echo "<li>Check your DirectAdmin MySQL settings</li>";
echo "<li>Verify the database 'techeletric_ip_tools' exists</li>";
echo "<li>Verify the user 'techeletric_ip_tools' exists with correct password</li>";
echo "<li>Or update the database credentials in app/Config/Database.php</li>";
echo "</ol>";

echo "<p><a href='index.php'>Go to Main Application</a></p>";
?> 