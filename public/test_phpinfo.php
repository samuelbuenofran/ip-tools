<?php
// Force error display for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "PHP Version: " . phpversion();
echo "<br>";
echo "PHP SAPI: " . php_sapi_name();
echo "<br>";
echo "Memory Limit: " . ini_get('memory_limit');
echo "<br>";
echo "Max Execution Time: " . ini_get('max_execution_time');
echo "<br>";
echo "Display Errors: " . ini_get('display_errors');
echo "<br>";
echo "Error Reporting: " . error_reporting();
echo "<br><br>";

echo "<h2>Now Testing App Loading:</h2>";
try {
    $appFile = __DIR__ . '/../app/Config/App.php';
    echo "App file exists: " . (file_exists($appFile) ? 'YES' : 'NO') . "<br>";
    echo "App file path: " . $appFile . "<br>";
    
    if (file_exists($appFile)) {
        echo "✓ App.php file found<br>";
        
        // Try to include it
        require_once $appFile;
        echo "✓ App.php included successfully<br>";
        
        // Check if class exists
        if (class_exists('App\Config\App')) {
            echo "✓ App class exists<br>";
            
            // Try to call init
            App\Config\App::init();
            echo "✓ App::init() completed successfully<br>";
        } else {
            echo "✗ App class does not exist after including<br>";
        }
    } else {
        echo "✗ App.php file not found<br>";
    }
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
} catch (Error $e) {
    echo "✗ Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
}
?>
