<?php
echo "<h1>File Loading Test</h1>";
echo "<p>Testing each file individually to find the problem...</p>";

// Test each file one by one
$files = [
    'app/Config/App.php',
    'app/Config/Database.php',
    'app/Core/Router.php',
    'app/Core/Controller.php',
    'app/Core/View.php',
    'app/Models/GeoLink.php',
    'app/Models/GeoLog.php',
    'app/Models/User.php',
    'app/Models/SpeedTest.php',
    'app/Controllers/HomeController.php',
    'app/Controllers/DashboardController.php',
    'app/Controllers/GeologgerController.php',
    'app/Controllers/PhoneTrackerController.php',
    'app/Controllers/SpeedTestController.php',
    'app/Controllers/AdminController.php',
    'app/Controllers/AuthController.php',
    'app/Controllers/DebugController.php'
];

foreach ($files as $file) {
    echo "<h3>Testing: $file</h3>";
    
    try {
        // Check if file exists
        $fullPath = __DIR__ . '/../' . $file;
        if (file_exists($fullPath)) {
            echo "<p>✓ File exists</p>";
            
            // Check file permissions
            $perms = fileperms($fullPath);
            echo "<p>Permissions: " . substr(sprintf('%o', $perms), -4) . "</p>";
            
            // Check if file is readable
            if (is_readable($fullPath)) {
                echo "<p>✓ File is readable</p>";
                
                // Try to include the file
                try {
                    require_once $fullPath;
                    echo "<p>✓ File loaded successfully</p>";
                    
                    // Try to get class name from file
                    $className = '';
                    if (strpos($file, 'Controllers/') !== false) {
                        $className = 'App\Controllers\\' . basename($file, '.php');
                    } elseif (strpos($file, 'Models/') !== false) {
                        $className = 'App\Models\\' . basename($file, '.php');
                    } elseif (strpos($file, 'Core/') !== false) {
                        $className = 'App\Core\\' . basename($file, '.php');
                    } elseif (strpos($file, 'Config/') !== false) {
                        $className = 'App\Config\\' . basename($file, '.php');
                    }
                    
                    if ($className && class_exists($className)) {
                        echo "<p>✓ Class '$className' exists</p>";
                    } else {
                        echo "<p>⚠ Class '$className' not found (might be a config file)</p>";
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
                
            } else {
                echo "<p>✗ File is not readable</p>";
            }
            
        } else {
            echo "<p>✗ File does not exist</p>";
        }
        
    } catch (Exception $e) {
        echo "<p>✗ Unexpected error: " . $e->getMessage() . "</p>";
    }
    
    echo "<hr>";
}

echo "<h2>Test Complete</h2>";
echo "<p>Check above to see which file is causing the problem.</p>";
echo "<p><a href='index.php'>Try Main Application</a></p>";
?>
