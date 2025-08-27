<?php
echo "<h1>Individual Controller Loading Test</h1>";
echo "<p>Testing each controller individually to find the conflict...</p>";

// First, load the core files that controllers depend on
echo "<h2>Step 1: Load Core Dependencies</h2>";
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
    echo "<p>✓ Core dependencies loaded</p>";
} catch (Exception $e) {
    echo "<p>✗ Error loading core dependencies: " . $e->getMessage() . "</p>";
    exit;
}

// Now test each controller individually
echo "<h2>Step 2: Test Each Controller Individually</h2>";

$controllers = [
    'HomeController.php',
    'DashboardController.php',
    'GeologgerController.php',
    'PhoneTrackerController.php',
    'SpeedTestController.php',
    'AdminController.php',
    'AuthController.php',
    'DebugController.php'
];

foreach ($controllers as $controllerFile) {
    echo "<h3>Testing: $controllerFile</h3>";
    
    try {
        $fullPath = __DIR__ . '/../app/Controllers/' . $controllerFile;
        
        if (file_exists($fullPath)) {
            echo "<p>✓ File exists</p>";
            
            // Try to load this specific controller
            require_once $fullPath;
            echo "<p>✓ Controller loaded successfully</p>";
            
            // Try to get the class name
            $className = 'App\Controllers\\' . basename($controllerFile, '.php');
            
            if (class_exists($className)) {
                echo "<p>✓ Class '$className' exists</p>";
                
                // Try to create an instance (this will catch constructor errors)
                try {
                    $controller = new $className(['controller' => basename($controllerFile, '.php'), 'action' => 'index']);
                    echo "<p>✓ Controller instance created successfully</p>";
                } catch (Exception $e) {
                    echo "<p>⚠ Controller instance creation failed: " . $e->getMessage() . "</p>";
                    echo "<p>This might be expected for some controllers</p>";
                }
                
            } else {
                echo "<p>✗ Class '$className' not found after loading</p>";
            }
            
        } else {
            echo "<p>✗ File not found</p>";
        }
        
    } catch (ParseError $e) {
        echo "<p>✗ Parse Error: " . $e->getMessage() . "</p>";
        echo "<p>Line: " . $e->getLine() . "</p>";
    } catch (Error $e) {
        echo "<p>✗ Fatal Error: " . $e->getMessage() . "</p>";
        echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    } catch (Exception $e) {
        echo "<p>✗ Exception: " . $e->getMessage() . "</p>";
        echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    }
    
    echo "<hr>";
}

// Step 3: Test loading controllers in pairs to find conflicts
echo "<h2>Step 3: Test Loading Controllers in Pairs</h2>";
echo "<p>This will help identify which controllers conflict with each other...</p>";

$testPairs = [
    ['HomeController.php', 'DashboardController.php'],
    ['HomeController.php', 'GeologgerController.php'],
    ['HomeController.php', 'AuthController.php'],
    ['DashboardController.php', 'GeologgerController.php'],
    ['DashboardController.php', 'AuthController.php'],
    ['GeologgerController.php', 'AuthController.php']
];

foreach ($testPairs as $pair) {
    echo "<h3>Testing Pair: " . implode(' + ', $pair) . "</h3>";
    
    try {
        // Load the first controller
        require_once __DIR__ . '/../app/Controllers/' . $pair[0];
        echo "<p>✓ " . $pair[0] . " loaded</p>";
        
        // Try to load the second controller
        require_once __DIR__ . '/../app/Controllers/' . $pair[1];
        echo "<p>✓ " . $pair[1] . " loaded</p>";
        
        echo "<p>✓ Pair loaded successfully</p>";
        
    } catch (Exception $e) {
        echo "<p>✗ Conflict detected: " . $e->getMessage() . "</p>";
        echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    }
    
    echo "<hr>";
}

echo "<h2>Test Complete</h2>";
echo "<p>Check above to see which controller is causing the problem.</p>";
echo "<p><a href='index.php'>Try Main Application</a></p>";
?>
