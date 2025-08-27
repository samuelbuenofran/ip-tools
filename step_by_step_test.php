<?php
echo "<h1>Step-by-Step Test</h1>";
echo "<p>This will test each component individually to find the issue.</p>";

// Step 1: Basic PHP
echo "<h2>Step 1: Basic PHP ✓</h2>";
echo "<p>PHP is working</p>";

// Step 2: File existence
echo "<h2>Step 2: File Existence ✓</h2>";
$files = [
    'app/Config/App.php',
    'app/Config/Database.php',
    'app/Core/Router.php',
    'app/Core/Controller.php',
    'app/Core/View.php'
];

foreach ($files as $file) {
    if (file_exists(__DIR__ . '/' . $file)) {
        echo "<p>✓ $file exists</p>";
    } else {
        echo "<p>✗ $file NOT FOUND</p>";
    }
}

// Step 3: Load App class
echo "<h2>Step 3: Load App Class</h2>";
try {
    require_once __DIR__ . '/app/Config/App.php';
    echo "<p>✓ App.php loaded</p>";
    
    if (class_exists('App\Config\App')) {
        echo "<p>✓ App class exists</p>";
        echo "<p>✓ App name: " . App\Config\App::APP_NAME . "</p>";
    } else {
        echo "<p>✗ App class not found</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error loading App: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
}

// Step 4: Initialize App
echo "<h2>Step 4: Initialize App</h2>";
try {
    if (class_exists('App\Config\App')) {
        App\Config\App::init();
        echo "<p>✓ App initialized</p>";
    } else {
        echo "<p>⚠ App class not available</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error initializing App: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
}

// Step 5: Load Database class
echo "<h2>Step 5: Load Database Class</h2>";
try {
    require_once __DIR__ . '/app/Config/Database.php';
    echo "<p>✓ Database.php loaded</p>";
    
    if (class_exists('App\Config\Database')) {
        echo "<p>✓ Database class exists</p>";
    } else {
        echo "<p>✗ Database class not found</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error loading Database: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
}

// Step 6: Create Database instance
echo "<h2>Step 6: Create Database Instance</h2>";
try {
    if (class_exists('App\Config\Database')) {
        $db = App\Config\Database::getInstance();
        echo "<p>✓ Database instance created</p>";
        
        if ($db->isConnected()) {
            echo "<p>✓ Database connected</p>";
        } else {
            echo "<p>⚠ Database not connected (demo mode)</p>";
        }
    } else {
        echo "<p>⚠ Database class not available</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error creating database instance: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
}

// Step 7: Load Router class
echo "<h2>Step 7: Load Router Class</h2>";
try {
    require_once __DIR__ . '/app/Core/Router.php';
    echo "<p>✓ Router.php loaded</p>";
    
    if (class_exists('App\Core\Router')) {
        echo "<p>✓ Router class exists</p>";
    } else {
        echo "<p>✗ Router class not found</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error loading Router: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
}

// Step 8: Create Router instance
echo "<h2>Step 8: Create Router Instance</h2>";
try {
    if (class_exists('App\Core\Router')) {
        $router = new App\Core\Router();
        echo "<p>✓ Router instance created</p>";
    } else {
        echo "<p>⚠ Router class not available</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error creating router instance: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
}

// Step 9: Load Controller class
echo "<h2>Step 9: Load Controller Class</h2>";
try {
    require_once __DIR__ . '/app/Core/Controller.php';
    echo "<p>✓ Controller.php loaded</p>";
    
    if (class_exists('App\Core\Controller')) {
        echo "<p>✓ Controller class exists</p>";
    } else {
        echo "<p>✗ Controller class not found</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error loading Controller: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
}

// Step 10: Load View class
echo "<h2>Step 10: Load View Class</h2>";
try {
    require_once __DIR__ . '/app/Core/View.php';
    echo "<p>✓ View.php loaded</p>";
    
    if (class_exists('App\Core\View')) {
        echo "<p>✓ View class exists</p>";
    } else {
        echo "<p>✗ View class not found</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error loading View: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
}

// Step 11: Test Controller instantiation
echo "<h2>Step 11: Test Controller Instantiation</h2>";
try {
    if (class_exists('App\Core\Controller') && class_exists('App\Core\View')) {
        // Create a simple test controller
        class TestController extends App\Core\Controller {
            public function test() {
                return "Controller test successful";
            }
        }
        
        $testController = new TestController();
        echo "<p>✓ Test controller created</p>";
        
        $result = $testController->test();
        echo "<p>✓ Controller method executed: $result</p>";
    } else {
        echo "<p>⚠ Required classes not available</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error with controller: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
}

echo "<h2>Test Complete</h2>";
echo "<p>Check the steps above to see where the failure occurs.</p>";
?>
