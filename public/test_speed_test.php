<?php
// Force error display for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Speed Test MVC Integration Test</h1>";

echo "<h2>Step 1: Loading Required Classes</h2>";

// Load required classes
require_once __DIR__ . '/../app/Config/App.php';
require_once __DIR__ . '/../app/Config/Database.php';
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/Controller.php';
require_once __DIR__ . '/../app/Core/View.php';
require_once __DIR__ . '/../app/Models/SpeedTest.php';
require_once __DIR__ . '/../app/Controllers/SpeedTestController.php';

use App\Config\App;
use App\Core\Router;
use App\Models\SpeedTest;
use App\Controllers\SpeedTestController;

try {
    // Initialize app
    App::init();
    echo "✓ App::init() completed<br>";
    
    echo "<h2>Step 2: Testing SpeedTest Model</h2>";
    
    try {
        $speedTestModel = new SpeedTest();
        echo "✓ SpeedTest model instantiated<br>";
        
        // Test getting recent tests
        try {
            $recentTests = $speedTestModel->getRecentTests(5);
            echo "✓ getRecentTests() method works<br>";
            echo "Recent tests count: " . count($recentTests) . "<br>";
        } catch (Exception $e) {
            echo "✗ getRecentTests() failed: " . $e->getMessage() . "<br>";
        }
        
        // Test getting average speeds
        try {
            $avgSpeeds = $speedTestModel->getAverageSpeeds();
            echo "✓ getAverageSpeeds() method works<br>";
            echo "Average download: " . ($avgSpeeds['avg_download'] ?? 0) . " Mbps<br>";
        } catch (Exception $e) {
            echo "✗ getAverageSpeeds() failed: " . $e->getMessage() . "<br>";
        }
        
    } catch (Exception $e) {
        echo "✗ SpeedTest model test failed: " . $e->getMessage() . "<br>";
    }
    
    echo "<h2>Step 3: Testing SpeedTestController</h2>";
    
    try {
        $controller = new SpeedTestController();
        echo "✓ SpeedTestController instantiated<br>";
        
        // Test if controller has required methods
        if (method_exists($controller, 'index')) {
            echo "✓ index() method exists<br>";
        }
        
        if (method_exists($controller, 'save')) {
            echo "✓ save() method exists<br>";
        }
        
        if (method_exists($controller, 'analytics')) {
            echo "✓ analytics() method exists<br>";
        }
        
    } catch (Exception $e) {
        echo "✗ SpeedTestController test failed: " . $e->getMessage() . "<br>";
    }
    
    echo "<h2>Step 4: Testing Router Integration</h2>";
    
    try {
        $router = new Router();
        echo "✓ Router instantiated<br>";
        
        // Add speed test routes
        $router->add('speed-test', ['controller' => 'SpeedTestController', 'action' => 'index']);
        $router->add('speed-test/save', ['controller' => 'SpeedTestController', 'action' => 'save']);
        $router->add('speed-test/analytics', ['controller' => 'SpeedTestController', 'action' => 'analytics']);
        
        echo "✓ Speed test routes added<br>";
        
        // Test route matching
        if ($router->match('speed-test')) {
            echo "✓ 'speed-test' route matches<br>";
            $params = $router->getParams();
            echo "Route parameters: " . json_encode($params) . "<br>";
        } else {
            echo "✗ 'speed-test' route does not match<br>";
        }
        
    } catch (Exception $e) {
        echo "✗ Router integration test failed: " . $e->getMessage() . "<br>";
    }
    
    echo "<h2>Step 5: Testing View Files</h2>";
    
    $viewFiles = [
        '../app/Views/speed-test/index.php',
        '../app/Views/speed-test/analytics.php'
    ];
    
    foreach ($viewFiles as $viewFile) {
        if (file_exists($viewFile)) {
            echo "✓ View file exists: " . basename($viewFile) . "<br>";
        } else {
            echo "✗ View file missing: " . basename($viewFile) . "<br>";
        }
    }
    
    echo "<h2>Test Complete!</h2>";
    echo "<p>Speed test integration test completed. Check results above.</p>";
    echo "<p><a href='speed-test' class='btn btn-primary'>Try Speed Test Page</a></p>";
    
} catch (Exception $e) {
    echo "✗ Main test failed: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
} catch (Error $e) {
    echo "✗ Main test failed with Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
}
?>
