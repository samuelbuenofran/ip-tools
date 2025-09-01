<?php
// Force error display for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Deep App Testing (Fixed Version)</h1>";

echo "<h2>Step 1: Loading App</h2>";
require_once __DIR__ . '/../app/Config/App.php';
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/Controller.php';
require_once __DIR__ . '/../app/Core/View.php';
require_once __DIR__ . '/../app/Config/Database.php';

use App\Config\App;
use App\Core\Router;
use App\Core\Controller;
use App\Core\View;
use App\Config\Database;

try {
    App::init();
    echo "✓ App::init() completed<br>";
    
    echo "<h2>Step 2: Loading Core Classes</h2>";
    
    // Test Router
    echo "Testing Router...<br>";
    echo "✓ Router class loaded<br>";
    
    // Test Controller
    echo "Testing Controller...<br>";
    echo "✓ Controller class loaded<br>";
    
    // Test View
    echo "Testing View...<br>";
    echo "✓ View class loaded<br>";
    
    echo "<h2>Step 3: Testing Router Creation</h2>";
    try {
        $router = new Router();
        echo "✓ Router instantiated successfully<br>";
        
        // Test adding a simple route (using correct method)
        $router->add('test', ['controller' => 'TestController', 'action' => 'test']);
        echo "✓ Route added successfully<br>";
        
        // Test route matching (using correct dispatch method)
        if ($router->match('test')) {
            echo "✓ Route matching test: SUCCESS<br>";
            $params = $router->getParams();
            echo "✓ Route parameters: " . json_encode($params) . "<br>";
        } else {
            echo "✗ Route matching failed<br>";
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
        // Use the correct singleton pattern
        $db = Database::getInstance();
        echo "✓ Database instance retrieved<br>";
        
        // Try to get connection
        $pdo = $db->getConnection();
        if ($pdo) {
            echo "✓ Database connection successful<br>";
            
            // Test a simple query
            try {
                $stmt = $pdo->query("SELECT 1 as test");
                $result = $stmt->fetch();
                echo "✓ Database query test: " . $result['test'] . "<br>";
            } catch (Exception $e) {
                echo "✗ Database query failed: " . $e->getMessage() . "<br>";
            }
        } else {
            echo "✗ Database connection failed<br>";
        }
        
    } catch (Exception $e) {
        echo "✗ Database test failed: " . $e->getMessage() . "<br>";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    } catch (Error $e) {
        echo "✗ Database test failed with Error: " . $e->getMessage() . "<br>";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    }
    
    echo "<h2>Step 5: Testing Model Loading</h2>";
    try {
        // Load models first
        require_once __DIR__ . '/../app/Models/GeoLog.php';
        require_once __DIR__ . '/../app/Models/GeoLink.php';
        require_once __DIR__ . '/../app/Models/User.php';
        
        echo "✓ Models loaded successfully<br>";
        
        // Test if models can be instantiated
        if (class_exists('App\Models\GeoLog')) {
            echo "✓ GeoLog model class exists<br>";
        }
        
        if (class_exists('App\Models\GeoLink')) {
            echo "✓ GeoLink model class exists<br>";
        }
        
        if (class_exists('App\Models\User')) {
            echo "✓ User model class exists<br>";
        }
        
    } catch (Exception $e) {
        echo "✗ Model loading test failed: " . $e->getMessage() . "<br>";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    } catch (Error $e) {
        echo "✗ Model loading test failed with Error: " . $e->getMessage() . "<br>";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    }
    
    echo "<h2>Step 6: Testing Controller Loading</h2>";
    try {
        // Test loading a specific controller
        $controllerFile = __DIR__ . '/../app/Controllers/HomeController.php';
        echo "HomeController exists: " . (file_exists($controllerFile) ? 'YES' : 'NO') . "<br>";
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            
            if (class_exists('App\Controllers\HomeController')) {
                echo "✓ HomeController class loaded<br>";
                
                // Try to instantiate (now that models are loaded)
                try {
                    $controller = new App\Controllers\HomeController();
                    echo "✓ HomeController instantiated successfully<br>";
                    
                    // Test if controller has required methods
                    if (method_exists($controller, 'index')) {
                        echo "✓ HomeController::index() method exists<br>";
                    }
                    
                } catch (Exception $e) {
                    echo "✗ HomeController instantiation failed: " . $e->getMessage() . "<br>";
                    echo "This might be due to missing dependencies<br>";
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
    
    echo "<h2>Step 7: Testing URL Processing</h2>";
    try {
        // Simulate the main application's URL processing
        $url = 'dashboard'; // Test a protected route
        
        echo "Testing URL: '$url'<br>";
        
        // Check if this route requires authentication
        if (class_exists('App\Core\AuthMiddleware')) {
            require_once __DIR__ . '/../app/Core/AuthMiddleware.php';
            
            $requiresAuth = \App\Core\AuthMiddleware::requiresAuth($url);
            echo "Route '$url' requires auth: " . ($requiresAuth ? 'YES' : 'NO') . "<br>";
            
            if ($requiresAuth) {
                $isAuthenticated = \App\Core\AuthMiddleware::isAuthenticated();
                echo "User authenticated: " . ($isAuthenticated ? 'YES' : 'NO') . "<br>";
            }
        } else {
            echo "✗ AuthMiddleware not available<br>";
        }
        
    } catch (Exception $e) {
        echo "✗ URL processing test failed: " . $e->getMessage() . "<br>";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    } catch (Error $e) {
        echo "✗ URL processing test failed with Error: " . $e->getMessage() . "<br>";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    }
    
    echo "<h2>Test Complete!</h2>";
    echo "<p>All tests completed. Check the results above for any issues.</p>";
    
} catch (Exception $e) {
    echo "✗ Main test failed: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
} catch (Error $e) {
    echo "✗ Main test failed with Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
}
?>
