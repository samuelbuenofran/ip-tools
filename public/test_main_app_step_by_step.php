<?php
echo "<h1>Main Application Step-by-Step Test</h1>";
echo "<p>Testing the exact flow from main index.php...</p>";

// Step 1: Start output buffer (like main app)
echo "<h2>Step 1: Start Output Buffer</h2>";
ob_start();
echo "<p>✓ Output buffer started</p>";

// Step 2: Load all files (exactly like main app)
echo "<h2>Step 2: Load All Files</h2>";
try {
    require_once __DIR__ . '/../app/Config/App.php';
    echo "<p>✓ App.php loaded</p>";
    
    require_once __DIR__ . '/../app/Config/Database.php';
    echo "<p>✓ Database.php loaded</p>";
    
    require_once __DIR__ . '/../app/Core/Router.php';
    echo "<p>✓ Router.php loaded</p>";
    
    require_once __DIR__ . '/../app/Core/Controller.php';
    echo "<p>✓ Controller.php loaded</p>";
    
    require_once __DIR__ . '/../app/Core/View.php';
    echo "<p>✓ View.php loaded</p>";
    
    require_once __DIR__ . '/../app/Models/GeoLink.php';
    require_once __DIR__ . '/../app/Models/GeoLog.php';
    require_once __DIR__ . '/../app/Models/User.php';
    require_once __DIR__ . '/../app/Models/SpeedTest.php';
    echo "<p>✓ All models loaded</p>";
    
    require_once __DIR__ . '/../app/Controllers/HomeController.php';
    require_once __DIR__ . '/../app/Controllers/DashboardController.php';
    require_once __DIR__ . '/../app/Controllers/GeologgerController.php';
    require_once __DIR__ . '/../app/Controllers/PhoneTrackerController.php';
    require_once __DIR__ . '/../app/Controllers/SpeedTestController.php';
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    require_once __DIR__ . '/../app/Controllers/AuthController.php';
    require_once __DIR__ . '/../app/Controllers/DebugController.php';
    echo "<p>✓ All controllers loaded</p>";
    
    echo "<p>✓ All files loaded successfully</p>";
    
} catch (Exception $e) {
    echo "<p>✗ Error loading files: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    exit;
}

// Step 3: Set up use statements (like main app)
echo "<h2>Step 3: Set Up Use Statements</h2>";
use App\Config\App;
use App\Core\Router;
echo "<p>✓ Use statements set up</p>";

// Step 4: Initialize App (this is where it might fail)
echo "<h2>Step 4: Initialize App</h2>";
try {
    App::init();
    echo "<p>✓ App initialized successfully</p>";
} catch (Exception $e) {
    echo "<p>✗ App::init() failed: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    echo "<p>This is likely the source of your 500 error!</p>";
    exit;
}

// Step 5: Create Router
echo "<h2>Step 5: Create Router</h2>";
try {
    $router = new Router();
    echo "<p>✓ Router created successfully</p>";
} catch (Exception $e) {
    echo "<p>✗ Router creation failed: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    exit;
}

// Step 6: Add routes (like main app)
echo "<h2>Step 6: Add Routes</h2>";
try {
    $router->add('', ['controller' => 'HomeController', 'action' => 'index']);
    $router->add('home', ['controller' => 'HomeController', 'action' => 'index']);
    $router->add('dashboard', ['controller' => 'DashboardController', 'action' => 'index']);
    echo "<p>✓ Basic routes added</p>";
    
    // Add a few more routes
    $router->add('about', ['controller' => 'HomeController', 'action' => 'about']);
    $router->add('contact', ['controller' => 'HomeController', 'action' => 'contact']);
    echo "<p>✓ Additional routes added</p>";
    
} catch (Exception $e) {
    echo "<p>✗ Error adding routes: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    exit;
}

// Step 7: Process URL (like main app)
echo "<h2>Step 7: Process URL</h2>";
try {
    $url = $_SERVER['REQUEST_URI'] ?? '';
    echo "<p>Original REQUEST_URI: '$url'</p>";
    
    if (empty($url)) {
        $url = $_SERVER['PATH_INFO'] ?? '';
        if (empty($url)) {
            $url = $_SERVER['ORIG_PATH_INFO'] ?? '';
        }
    }
    
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $basePath = dirname($scriptName);
    echo "<p>Script Name: '$scriptName'</p>";
    echo "<p>Base Path: '$basePath'</p>";
    
    if ($basePath !== '/' && $basePath !== '.') {
        $url = str_replace($basePath, '', $url);
    }
    
    $url = trim($url, '/');
    echo "<p>Processed URL: '$url'</p>";
    
    echo "<p>✓ URL processing completed</p>";
    
} catch (Exception $e) {
    echo "<p>✗ Error processing URL: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    exit;
}

// Step 8: Test route matching
echo "<h2>Step 8: Test Route Matching</h2>";
try {
    if ($router->match($url)) {
        echo "<p>✓ Route matched successfully</p>";
        $params = $router->getParams();
        echo "<p>✓ Controller: " . $params['controller'] . "</p>";
        echo "<p>✓ Action: " . $params['action'] . "</p>";
    } else {
        echo "<p>⚠ No route matched for '$url'</p>";
        echo "<p>Available routes:</p>";
        $routes = $router->getRoutes();
        foreach ($routes as $route => $params) {
            echo "<p>- $route → " . $params['controller'] . "::" . $params['action'] . "</p>";
        }
    }
} catch (Exception $e) {
    echo "<p>✗ Error matching route: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    exit;
}

// Step 9: Test router dispatch (this is where it might fail)
echo "<h2>Step 9: Test Router Dispatch</h2>";
try {
    $router->dispatch($url);
    echo "<p>✓ Router dispatch completed successfully</p>";
    echo "<p>This means the main application should work!</p>";
} catch (Exception $e) {
    echo "<p>✗ Router dispatch failed: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    echo "<p>This is likely the source of your 500 error!</p>";
}

echo "<h2>Test Complete</h2>";
echo "<p>Check above to see exactly where the failure occurs.</p>";
echo "<p><a href='index.php'>Try Main Application</a></p>";
?>
