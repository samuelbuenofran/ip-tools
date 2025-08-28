<?php
// Force error display for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Deep App Testing</h1>";

echo "<h2>Step 1: Loading App</h2>";
require_once __DIR__ . '/../app/Config/App.php';
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/Controller.php';
require_once __DIR__ . '/../app/Core/View.php';
require_once __DIR__ . '/../app/Config/Database.php';
require_once __DIR__ . '/../app/Controllers/HomeController.php';

use App\Config\App;
use App\Core\Router;
use App\Core\Controller;
use App\Core\View;
use App\Config\Database;
use App\Controllers\HomeController;

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
        
        // Test adding a simple route
        $router->addRoute('test', 'GET', function() {
            return 'Test route works!';
        });
        echo "✓ Route added successfully<br>";
        
        // Test route matching
        $result = $router->dispatch('test', 'GET');
        echo "✓ Route dispatch test: " . $result . "<br>";
        
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
        use App\Config\Database;
        
        $db = new Database();
        echo "✓ Database class loaded<br>";
        
        // Try to get connection
        $pdo = $db->getConnection();
        if ($pdo) {
            echo "✓ Database connection successful<br>";
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
    
    echo "<h2>Step 5: Testing Controller Loading</h2>";
    try {
        // Test loading a specific controller
        $controllerFile = __DIR__ . '/../app/Controllers/HomeController.php';
        echo "HomeController exists: " . (file_exists($controllerFile) ? 'YES' : 'NO') . "<br>";
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            use App\Controllers\HomeController;
            
            if (class_exists('App\Controllers\HomeController')) {
                echo "✓ HomeController class loaded<br>";
                
                // Try to instantiate
                $controller = new HomeController();
                echo "✓ HomeController instantiated<br>";
                
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
    
} catch (Exception $e) {
    echo "✗ Main test failed: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
} catch (Error $e) {
    echo "✗ Main test failed with Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
}
?>
