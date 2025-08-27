<?php
echo "<h1>Simple Test</h1>";
echo "<p>PHP is working!</p>";
echo "<p>Time: " . date('Y-m-d H:i:s') . "</p>";

// Test basic includes
echo "<h2>Testing Basic Includes</h2>";
try {
    require_once __DIR__ . '/app/Config/App.php';
    echo "<p>✓ App.php loaded successfully</p>";
    
    if (class_exists('App\Config\App')) {
        echo "<p>✓ App class exists</p>";
        echo "<p>✓ App name: " . App\Config\App::APP_NAME . "</p>";
        echo "<p>✓ Debug mode: " . (App\Config\App::DEBUG_MODE ? 'ON' : 'OFF') . "</p>";
    } else {
        echo "<p>✗ App class not found</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error loading App.php: " . $e->getMessage() . "</p>";
}

// Test database connection
echo "<h2>Testing Database Connection</h2>";
try {
    require_once __DIR__ . '/app/Config/Database.php';
    echo "<p>✓ Database.php loaded successfully</p>";
    
    if (class_exists('App\Config\Database')) {
        echo "<p>✓ Database class exists</p>";
        $db = App\Config\Database::getInstance();
        echo "<p>✓ Database instance created</p>";
        
        $connection = $db->getConnection();
        echo "<p>✓ Database connection successful</p>";
    } else {
        echo "<p>✗ Database class not found</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error with database: " . $e->getMessage() . "</p>";
}

echo "<h2>Test Complete</h2>";
echo "<p>If you see this, basic functionality is working.</p>";
?>
