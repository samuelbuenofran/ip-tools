<?php
// Very simple test - just basic functionality
echo "<h1>Simple Index Test</h1>";
echo "<p>Basic PHP is working</p>";

// Test 1: Basic PHP
echo "<h2>Test 1: Basic PHP</h2>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";
echo "<p>Current Time: " . date('Y-m-d H:i:s') . "</p>";

// Test 2: File includes
echo "<h2>Test 2: File Includes</h2>";
try {
    if (file_exists(__DIR__ . '/../app/Config/App.php')) {
        echo "<p>✓ App.php file exists</p>";
    } else {
        echo "<p>✗ App.php file not found</p>";
    }
    
    if (file_exists(__DIR__ . '/../app/Config/Database.php')) {
        echo "<p>✓ Database.php file exists</p>";
    } else {
        echo "<p>✗ Database.php file not found</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error checking files: " . $e->getMessage() . "</p>";
}

// Test 3: Class loading
echo "<h2>Test 3: Class Loading</h2>";
try {
    require_once __DIR__ . '/../app/Config/App.php';
    echo "<p>✓ App.php loaded</p>";
    
    if (class_exists('App\Config\App')) {
        echo "<p>✓ App class exists</p>";
        echo "<p>✓ App name: " . App\Config\App::APP_NAME . "</p>";
    } else {
        echo "<p>✗ App class not found</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error loading App class: " . $e->getMessage() . "</p>";
    echo "<p>Error details: " . $e->getFile() . ":" . $e->getLine() . "</p>";
}

// Test 4: Database connection
echo "<h2>Test 4: Database Connection</h2>";
try {
    require_once __DIR__ . '/../app/Config/Database.php';
    echo "<p>✓ Database.php loaded</p>";
    
    if (class_exists('App\Config\Database')) {
        echo "<p>✓ Database class exists</p>";
        $db = App\Config\Database::getInstance();
        echo "<p>✓ Database instance created</p>";
        
        if ($db->isConnected()) {
            echo "<p>✓ Database connected</p>";
        } else {
            echo "<p>⚠ Database not connected (running in demo mode)</p>";
        }
    } else {
        echo "<p>✗ Database class not found</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error with database: " . $e->getMessage() . "</p>";
    echo "<p>Error details: " . $e->getFile() . ":" . $e->getLine() . "</p>";
}

// Test 5: Router
echo "<h2>Test 5: Router</h2>";
try {
    require_once __DIR__ . '/../app/Core/Router.php';
    echo "<p>✓ Router.php loaded</p>";
    
    if (class_exists('App\Core\Router')) {
        echo "<p>✓ Router class exists</p>";
        $router = new App\Core\Router();
        echo "<p>✓ Router instance created</p>";
    } else {
        echo "<p>✗ Router class not found</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error with router: " . $e->getMessage() . "</p>";
    echo "<p>Error details: " . $e->getFile() . ":" . $e->getLine() . "</p>";
}

echo "<h2>Test Complete</h2>";
echo "<p>If you see this, the basic framework is working.</p>";
?> 