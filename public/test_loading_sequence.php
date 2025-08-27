<?php
echo "<h1>Loading Sequence Test</h1>";
echo "<p>Testing the exact loading sequence from main index.php...</p>";

// Step 1: Load files in exact sequence
echo "<h2>Step 1: Load Files in Sequence</h2>";

try {
    echo "<p>Loading App.php...</p>";
    require_once __DIR__ . '/../app/Config/App.php';
    echo "<p>✓ App.php loaded</p>";
    
    echo "<p>Loading Database.php...</p>";
    require_once __DIR__ . '/../app/Config/Database.php';
    echo "<p>✓ Database.php loaded</p>";
    
    echo "<p>Loading Router.php...</p>";
    require_once __DIR__ . '/../app/Core/Router.php';
    echo "<p>✓ Router.php loaded</p>";
    
    echo "<p>Loading Controller.php...</p>";
    require_once __DIR__ . '/../app/Core/Controller.php';
    echo "<p>✓ Controller.php loaded</p>";
    
    echo "<p>Loading View.php...</p>";
    require_once __DIR__ . '/../app/Core/View.php';
    echo "<p>✓ View.php loaded</p>";
    
    echo "<p>Loading Models...</p>";
    require_once __DIR__ . '/../app/Models/GeoLink.php';
    require_once __DIR__ . '/../app/Models/GeoLog.php';
    require_once __DIR__ . '/../app/Models/User.php';
    require_once __DIR__ . '/../app/Models/SpeedTest.php';
    echo "<p>✓ All models loaded</p>";
    
    echo "<p>Loading Controllers...</p>";
    require_once __DIR__ . '/../app/Controllers/HomeController.php';
    require_once __DIR__ . '/../app/Controllers/DashboardController.php';
    require_once __DIR__ . '/../app/Controllers/GeologgerController.php';
    require_once __DIR__ . '/../app/Controllers/PhoneTrackerController.php';
    require_once __DIR__ . '/../app/Controllers/SpeedTestController.php';
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    require_once __DIR__ . '/../app/Controllers/AuthController.php';
    require_once __DIR__ . '/../app/Controllers/DebugController.php';
    echo "<p>✓ All controllers loaded</p>";
    
    echo "<p>✓ All files loaded successfully in sequence</p>";
    
} catch (Exception $e) {
    echo "<p>✗ Error during file loading: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    exit;
}

// Step 2: Initialize App
echo "<h2>Step 2: Initialize App</h2>";
try {
    App\Config\App::init();
    echo "<p>✓ App initialized</p>";
} catch (Exception $e) {
    echo "<p>✗ Error initializing App: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    exit;
}

// Step 3: Create Router
echo "<h2>Step 3: Create Router</h2>";
try {
    $router = new App\Core\Router();
    echo "<p>✓ Router created</p>";
} catch (Exception $e) {
    echo "<p>✗ Error creating router: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    exit;
}

// Step 4: Add routes (exactly like main index.php)
echo "<h2>Step 4: Add Routes</h2>";
try {
    // Add routes exactly as they appear in main index.php
    $router->add('', ['controller' => 'HomeController', 'action' => 'index']);
    echo "<p>✓ Route '' added</p>";
    
    $router->add('home', ['controller' => 'HomeController', 'action' => 'index']);
    echo "<p>✓ Route 'home' added</p>";
    
    $router->add('dashboard', ['controller' => 'DashboardController', 'action' => 'index']);
    echo "<p>✓ Route 'dashboard' added</p>";
    
    $router->add('about', ['controller' => 'HomeController', 'action' => 'about']);
    echo "<p>✓ Route 'about' added</p>";
    
    $router->add('contact', ['controller' => 'HomeController', 'action' => 'contact']);
    echo "<p>✓ Route 'contact' added</p>";
    
    $router->add('privacy', ['controller' => 'HomeController', 'action' => 'privacy']);
    echo "<p>✓ Route 'privacy' added</p>";
    
    $router->add('support', ['controller' => 'HomeController', 'action' => 'support']);
    echo "<p>✓ Route 'support' added</p>";
    
    echo "<p>✓ All basic routes added</p>";
    
} catch (Exception $e) {
    echo "<p>✗ Error adding routes: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    exit;
}

// Step 5: Test URL processing (exactly like main index.php)
echo "<h2>Step 5: Test URL Processing</h2>";
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
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
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
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
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
echo "<p>This shows exactly what the main application does step by step.</p>";
echo "<p><a href='index.php'>Try Main Application</a></p>";
?>
