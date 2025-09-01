<?php
// Force error display for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>My Links Page Test</h1>";

echo "<h2>Step 1: Loading Required Classes</h2>";

// Load required classes
require_once __DIR__ . '/../app/Config/App.php';
require_once __DIR__ . '/../app/Config/Database.php';
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/Controller.php';
require_once __DIR__ . '/../app/Core/View.php';
require_once __DIR__ . '/../app/Models/GeoLink.php';
require_once __DIR__ . '/../app/Models/GeoLog.php';
require_once __DIR__ . '/../app/Controllers/GeologgerController.php';

use App\Config\App;
use App\Core\Router;
use App\Models\GeoLink;
use App\Controllers\GeologgerController;

try {
    // Initialize app
    App::init();
    echo "✓ App::init() completed<br>";
    
    echo "<h2>Step 2: Testing View File</h2>";
    
    $viewFile = __DIR__ . '/../app/Views/geologger/my_links.php';
    if (file_exists($viewFile)) {
        echo "✓ my_links.php view file exists<br>";
        
        // Check for problematic layout call
        $content = file_get_contents($viewFile);
        if (strpos($content, '$this->layout(') !== false) {
            echo "✗ Found problematic layout call<br>";
        } else {
            echo "✓ No problematic layout calls found<br>";
        }
        
        // Check for App::getBaseUrl calls
        if (strpos($content, 'App::getBaseUrl') !== false) {
            echo "✗ Found App::getBaseUrl calls (should use \$view->url())<br>";
        } else {
            echo "✓ No App::getBaseUrl calls found<br>";
        }
        
    } else {
        echo "✗ my_links.php view file not found<br>";
    }
    
    echo "<h2>Step 3: Testing GeologgerController</h2>";
    
    try {
        $controller = new GeologgerController();
        echo "✓ GeologgerController instantiated<br>";
        
        // Test if controller has required methods
        if (method_exists($controller, 'myLinks')) {
            echo "✓ myLinks() method exists<br>";
        } else {
            echo "✗ myLinks() method not found<br>";
        }
        
    } catch (Exception $e) {
        echo "✗ GeologgerController test failed: " . $e->getMessage() . "<br>";
    }
    
    echo "<h2>Step 4: Testing Router Integration</h2>";
    
    try {
        $router = new Router();
        echo "✓ Router instantiated<br>";
        
        // Test route matching
        if ($router->match('geologger/my-links')) {
            echo "✓ 'geologger/my-links' route matches<br>";
            $params = $router->getParams();
            echo "Route parameters: " . json_encode($params) . "<br>";
        } else {
            echo "✗ 'geologger/my-links' route does not match<br>";
        }
        
    } catch (Exception $e) {
        echo "✗ Router integration test failed: " . $e->getMessage() . "<br>";
    }
    
    echo "<h2>Test Complete!</h2>";
    echo "<p>My links page test completed. Check results above.</p>";
    echo "<p><a href='geologger/my-links' class='btn btn-primary'>Try My Links Page</a></p>";
    
} catch (Exception $e) {
    echo "✗ Main test failed: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
} catch (Error $e) {
    echo "✗ Main test failed with Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
}
?>
