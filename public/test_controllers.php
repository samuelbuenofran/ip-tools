<?php
echo "<h1>Controller Test</h1>";

// Test 1: Check if files exist
echo "<h2>Test 1: Controller Files</h2>";
$controllers = [
    '../app/Controllers/HomeController.php',
    '../app/Controllers/DashboardController.php',
    '../app/Controllers/GeologgerController.php',
    '../app/Controllers/PhoneTrackerController.php',
    '../app/Controllers/SpeedTestController.php',
    '../app/Controllers/AdminController.php',
    '../app/Controllers/AuthController.php'
];

foreach ($controllers as $controller) {
    if (file_exists($controller)) {
        echo "<p style='color: green;'>✅ " . basename($controller) . " exists</p>";
    } else {
        echo "<p style='color: red;'>❌ " . basename($controller) . " missing</p>";
    }
}

// Test 2: Try to include HomeController
echo "<h2>Test 2: HomeController Loading</h2>";
try {
    // Include dependencies first
    require_once '../app/Config/App.php';
    require_once '../app/Config/Database.php';
    require_once '../app/Core/Controller.php';
    require_once '../app/Core/View.php';
    require_once '../app/Models/GeoLink.php';
    require_once '../app/Models/GeoLog.php';
    
    // Now include HomeController
    require_once '../app/Controllers/HomeController.php';
    echo "<p style='color: green;'>✅ HomeController.php included successfully!</p>";
    
    if (class_exists('App\\Controllers\\HomeController')) {
        echo "<p style='color: green;'>✅ HomeController class exists!</p>";
        
        // Try to instantiate it
        $controller = new App\Controllers\HomeController();
        echo "<p style='color: green;'>✅ HomeController instantiated successfully!</p>";
        
        // Try to call the index method
        $result = $controller->index();
        echo "<p style='color: green;'>✅ HomeController->index() called successfully!</p>";
        
    } else {
        echo "<p style='color: red;'>❌ HomeController class not found after include!</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error with HomeController: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<hr>";
echo "<p><a href='index.php'>Try Main App</a></p>";
?> 