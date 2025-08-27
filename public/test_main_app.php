<?php
echo "<h1>Main Application Simulation Test</h1>";
echo "<p>This test simulates exactly what the main index.php does...</p>";

// Step 1: Load all required files
echo "<h2>Step 1: Load All Required Files</h2>";
try {
    require_once __DIR__ . '/../app/Config/App.php';
    require_once __DIR__ . '/../app/Config/Database.php';
    require_once __DIR__ . '/../app/Core/Router.php';
    require_once __DIR__ . '/../app/Core/Controller.php';
    require_once __DIR__ . '/../app/Core/View.php';
    require_once __DIR__ . '/../app/Models/GeoLink.php';
    require_once __DIR__ . '/../app/Models/GeoLog.php';
    require_once __DIR__ . '/../app/Models/User.php';
    require_once __DIR__ . '/../app/Models/SpeedTest.php';
    require_once __DIR__ . '/../app/Controllers/HomeController.php';
    require_once __DIR__ . '/../app/Controllers/DashboardController.php';
    require_once __DIR__ . '/../app/Controllers/GeologgerController.php';
    require_once __DIR__ . '/../app/Controllers/PhoneTrackerController.php';
    require_once __DIR__ . '/../app/Controllers/SpeedTestController.php';
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    require_once __DIR__ . '/../app/Controllers/AuthController.php';
    require_once __DIR__ . '/../app/Controllers/DebugController.php';
    
    echo "<p>✓ All files loaded successfully</p>";
} catch (Exception $e) {
    echo "<p>✗ Error loading files: " . $e->getMessage() . "</p>";
    exit;
}

// Step 2: Initialize App
echo "<h2>Step 2: Initialize App</h2>";
try {
    App\Config\App::init();
    echo "<p>✓ App initialized</p>";
} catch (Exception $e) {
    echo "<p>✗ Error initializing App: " . $e->getMessage() . "</p>";
    exit;
}

// Step 3: Create Router
echo "<h2>Step 3: Create Router</h2>";
try {
    $router = new App\Core\Router();
    echo "<p>✓ Router created</p>";
} catch (Exception $e) {
    echo "<p>✗ Error creating router: " . $e->getMessage() . "</p>";
    exit;
}

// Step 4: Add all routes (exactly like main index.php)
echo "<h2>Step 4: Add All Routes</h2>";
try {
    // Define routes exactly like main index.php
    $router->add('', ['controller' => 'HomeController', 'action' => 'index']);
    $router->add('home', ['controller' => 'HomeController', 'action' => 'index']);
    $router->add('dashboard', ['controller' => 'DashboardController', 'action' => 'index']);
    $router->add('about', ['controller' => 'HomeController', 'action' => 'about']);
    $router->add('contact', ['controller' => 'HomeController', 'action' => 'contact']);
    $router->add('privacy', ['controller' => 'HomeController', 'action' => 'privacy']);
    $router->add('support', ['controller' => 'HomeController', 'action' => 'support']);
    
    echo "<p>✓ Basic routes added</p>";
    
    // Add more routes
    $router->add('geologger/create', ['controller' => 'GeologgerController', 'action' => 'create']);
    $router->add('geologger/logs', ['controller' => 'GeologgerController', 'action' => 'logs']);
    $router->add('auth/login', ['controller' => 'AuthController', 'action' => 'login']);
    
    echo "<p>✓ Additional routes added</p>";
} catch (Exception $e) {
    echo "<p>✗ Error adding routes: " . $e->getMessage() . "</p>";
    exit;
}

// Step 5: Simulate URL processing (exactly like main index.php)
echo "<h2>Step 5: Simulate URL Processing</h2>";
try {
    // Simulate the exact URL processing from main index.php
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
    exit;
}

// Step 6: Test route matching
echo "<h2>Step 6: Test Route Matching</h2>";
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
    exit;
}

// Step 7: Test controller instantiation (if route matched)
echo "<h2>Step 7: Test Controller Instantiation</h2>";
if ($router->match($url)) {
    try {
        $params = $router->getParams();
        $controller = $params['controller'];
        $controllerClass = 'App\Controllers\\' . $controller;
        
        echo "<p>Attempting to create: $controllerClass</p>";
        
        if (class_exists($controllerClass)) {
            echo "<p>✓ Controller class exists</p>";
            
            $controllerObject = new $controllerClass($params);
            echo "<p>✓ Controller instance created</p>";
            
            $action = $params['action'];
            if (method_exists($controllerObject, $action)) {
                echo "<p>✓ Action method exists</p>";
                echo "<p>✓ Ready to dispatch!</p>";
            } else {
                echo "<p>✗ Action method '$action' not found</p>";
            }
        } else {
            echo "<p>✗ Controller class '$controllerClass' not found</p>";
        }
    } catch (Exception $e) {
        echo "<p>✗ Error with controller: " . $e->getMessage() . "</p>";
        echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    }
} else {
    echo "<p>⚠ Skipping controller test (no route matched)</p>";
}

echo "<h2>Test Complete</h2>";
echo "<p>This shows exactly what the main application is doing.</p>";
echo "<p><a href='index.php'>Try Main Application Again</a></p>";
?>
