<?php
echo "<h1>Basic PHP Test</h1>";
echo "<p>✓ PHP is working</p>";

echo "<h2>PHP Version:</h2>";
echo "<p>" . phpversion() . "</p>";

echo "<h2>Error Reporting:</h2>";
echo "<p>Current error_reporting: " . error_reporting() . "</p>";
echo "<p>Display errors: " . ini_get('display_errors') . "</p>";

echo "<h2>Session Status:</h2>";
echo "<p>session_status(): " . session_status() . "</p>";

echo "<h2>Testing File Loading:</h2>";
try {
    $appFile = __DIR__ . '/../app/Config/App.php';
    echo "<p>App file exists: " . (file_exists($appFile) ? 'YES' : 'NO') . "</p>";
    echo "<p>App file path: " . $appFile . "</p>";
    
    if (file_exists($appFile)) {
        echo "<p>✓ App.php file found</p>";
        
        // Try to include it
        require_once $appFile;
        echo "<p>✓ App.php included successfully</p>";
        
        // Check if class exists
        if (class_exists('App\Config\App')) {
            echo "<p>✓ App class exists</p>";
            
            // Try to call init
            try {
                App\Config\App::init();
                echo "<p>✓ App::init() completed successfully</p>";
            } catch (Exception $e) {
                echo "<p>✗ App::init() Exception: " . $e->getMessage() . "</p>";
            } catch (Error $e) {
                echo "<p>✗ App::init() Error: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p>✗ App class does not exist after including</p>";
        }
    } else {
        echo "<p>✗ App.php file not found</p>";
    }
    
} catch (Exception $e) {
    echo "<p>✗ Exception: " . $e->getMessage() . "</p>";
} catch (Error $e) {
    echo "<p>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<h2>Memory Usage:</h2>";
echo "<p>Memory limit: " . ini_get('memory_limit') . "</p>";
echo "<p>Current memory usage: " . memory_get_usage(true) . " bytes</p>";

echo "<h2>Test Complete</h2>";
?>
