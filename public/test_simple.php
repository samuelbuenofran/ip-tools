<?php
// Very simple test - just basic routing
echo "<h1>Simple Routing Test</h1>";
echo "<p>Testing basic framework components...</p>";

// Test 1: Basic includes
echo "<h2>Step 1: Load Core Files</h2>";
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
} catch (Exception $e) {
    echo "<p>✗ Error loading files: " . $e->getMessage() . "</p>";
    exit;
}

// Test 2: Initialize App
echo "<h2>Step 2: Initialize App</h2>";
try {
    App\Config\App::init();
    echo "<p>✓ App initialized</p>";
} catch (Exception $e) {
    echo "<p>✗ Error initializing App: " . $e->getMessage() . "</p>";
    exit;
}

// Test 3: Create Router
echo "<h2>Step 3: Create Router</h2>";
try {
    $router = new App\Core\Router();
    echo "<p>✓ Router created</p>";
} catch (Exception $e) {
    echo "<p>✗ Error creating router: " . $e->getMessage() . "</p>";
    exit;
}

// Test 4: Add a simple route
echo "<h2>Step 4: Add Simple Route</h2>";
try {
    $router->add('test', ['controller' => 'HomeController', 'action' => 'index']);
    echo "<p>✓ Route added</p>";
} catch (Exception $e) {
    echo "<p>✗ Error adding route: " . $e->getMessage() . "</p>";
    exit;
}

// Test 5: Test routing
echo "<h2>Step 5: Test Routing</h2>";
try {
    $url = 'test';
    echo "<p>Testing URL: '$url'</p>";
    
    if ($router->match($url)) {
        echo "<p>✓ Route matched</p>";
        $params = $router->getParams();
        echo "<p>✓ Controller: " . $params['controller'] . "</p>";
        echo "<p>✓ Action: " . $params['action'] . "</p>";
    } else {
        echo "<p>✗ Route not matched</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error testing routing: " . $e->getMessage() . "</p>";
    exit;
}

echo "<h2>Test Complete</h2>";
echo "<p>If all steps show ✓, the basic framework is working.</p>";
echo "<p><a href='index.php'>Try Main Application</a></p>";
?>
