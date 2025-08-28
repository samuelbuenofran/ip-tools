<?php
// Force error display for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Deep App Testing (Simple Version)</h1>";

echo "<h2>Step 1: Loading App</h2>";
require_once __DIR__ . '/../app/Config/App.php';
App\Config\App::init();
echo "✓ App::init() completed<br>";

echo "<h2>Step 2: Loading Core Classes</h2>";

// Test Router
echo "Testing Router...<br>";
require_once __DIR__ . '/../app/Core/Router.php';
echo "✓ Router class loaded<br>";

// Test Controller
echo "Testing Controller...<br>";
require_once __DIR__ . '/../app/Core/Controller.php';
echo "✓ Controller class loaded<br>";

// Test View
echo "Testing View...<br>";
require_once __DIR__ . '/../app/Core/View.php';
echo "✓ View class loaded<br>";

echo "<h2>Step 3: Testing Router Creation</h2>";
try {
    $router = new App\Core\Router();
    echo "✓ Router instantiated successfully<br>";
    
    // Test adding a simple route
    $router->add('test', ['controller' => 'TestController', 'action' => 'index']);
    echo "✓ Route added successfully<br>";
    
    // Test route matching
    try {
        $result = $router->dispatch('test');
        echo "✓ Route dispatch test: " . $result . "<br>";
    } catch (Exception $e) {
        echo "⚠ Route dispatch test: " . $e->getMessage() . "<br>";
    }
    
} catch (Exception $e) {
    echo "✗ Router test failed: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
} catch (Error $e) {
    echo "✗ Router test failed with Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
}

echo "<h2>Step 4: Testing Database Connection</h2>";
try {
    require_once __DIR__ . '/../app/Config/Database.php';
    
    $db = App\Config\Database::getInstance();
    echo "✓ Database class loaded<br>";
    
    // Try to get connection
    if ($db->isConnected()) {
        echo "✓ Database connection successful<br>";
        try {
            $pdo = $db->getConnection();
            echo "✓ PDO connection obtained<br>";
        } catch (Exception $e) {
            echo "⚠ PDO connection failed: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "⚠ Database not connected (demo mode)<br>";
    }
    
} catch (Exception $e) {
    echo "✗ Database test failed: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
} catch (Error $e) {
    echo "✗ Database test failed with Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
}

echo "<h2>Step 5: Testing Controller Loading</h2>";
try {
    // Test loading a specific controller
    $controllerFile = __DIR__ . '/../app/Controllers/HomeController.php';
    echo "HomeController exists: " . (file_exists($controllerFile) ? 'YES' : 'NO') . "<br>";
    
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        
        if (class_exists('App\Controllers\HomeController')) {
            echo "✓ HomeController class loaded<br>";
            
            // Check if required models exist and load them
            $geoLinkFile = __DIR__ . '/../app/Models/GeoLink.php';
            $geoLogFile = __DIR__ . '/../app/Models/GeoLog.php';
            
            echo "GeoLink model exists: " . (file_exists($geoLinkFile) ? 'YES' : 'NO') . "<br>";
            echo "GeoLog model exists: " . (file_exists($geoLogFile) ? 'YES' : 'NO') . "<br>";
            
            if (file_exists($geoLinkFile) && file_exists($geoLogFile)) {
                require_once $geoLinkFile;
                require_once $geoLogFile;
                echo "✓ Both models loaded<br>";
                
                // Try to instantiate controller
                try {
                    $controller = new App\Controllers\HomeController();
                    echo "✓ HomeController instantiated<br>";
                } catch (Exception $e) {
                    echo "⚠ HomeController instantiation failed: " . $e->getMessage() . "<br>";
                } catch (Error $e) {
                    echo "⚠ HomeController instantiation failed with Error: " . $e->getMessage() . "<br>";
                }
            } else {
                echo "✗ Required model files not found<br>";
            }
            
        } else {
            echo "✗ HomeController class not found after loading<br>";
        }
    }
    
} catch (Exception $e) {
    echo "✗ Controller test failed: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
} catch (Error $e) {
    echo "✗ Controller test failed with Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
}

echo "<h2>Test Complete!</h2>";
?>
