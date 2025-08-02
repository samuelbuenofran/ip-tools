<?php
// Debug MVC application
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debugging MVC Application</h1>";

// Test 1: Check if autoloader works
echo "<h2>Test 1: Autoloader</h2>";
try {
    require_once '../autoload.php';
    echo "✅ Autoloader loaded successfully<br>";
} catch (Exception $e) {
    echo "❌ Autoloader failed: " . $e->getMessage() . "<br>";
    exit;
}

// Test 2: Check if App class works
echo "<h2>Test 2: App Class</h2>";
try {
    $app = new App\Config\App();
    echo "✅ App class loaded successfully<br>";
} catch (Exception $e) {
    echo "❌ App class failed: " . $e->getMessage() . "<br>";
    exit;
}

// Test 3: Check if Database class works
echo "<h2>Test 3: Database Class</h2>";
try {
    $db = App\Config\Database::getInstance();
    echo "✅ Database class loaded successfully<br>";
} catch (Exception $e) {
    echo "❌ Database class failed: " . $e->getMessage() . "<br>";
    exit;
}

// Test 4: Check if View class works
echo "<h2>Test 4: View Class</h2>";
try {
    $view = new App\Core\View();
    echo "✅ View class loaded successfully<br>";
} catch (Exception $e) {
    echo "❌ View class failed: " . $e->getMessage() . "<br>";
    exit;
}

// Test 5: Check if HomeController works
echo "<h2>Test 5: HomeController Class</h2>";
try {
    $controller = new App\Controllers\HomeController();
    echo "✅ HomeController class loaded successfully<br>";
} catch (Exception $e) {
    echo "❌ HomeController class failed: " . $e->getMessage() . "<br>";
    exit;
}

// Test 6: Check if models work
echo "<h2>Test 6: Models</h2>";
try {
    $geoLink = new App\Models\GeoLink();
    $geoLog = new App\Models\GeoLog();
    echo "✅ Models loaded successfully<br>";
} catch (Exception $e) {
    echo "❌ Models failed: " . $e->getMessage() . "<br>";
    exit;
}

// Test 7: Check view file path
echo "<h2>Test 7: View File Path</h2>";
$viewPath = '../app/Views/';
$viewFile = $viewPath . 'home/index.php';
$layoutFile = $viewPath . 'layouts/default.php';

echo "View path: $viewPath<br>";
echo "View file: $viewFile<br>";
echo "Layout file: $layoutFile<br>";
echo "View file exists: " . (file_exists($viewFile) ? 'YES' : 'NO') . "<br>";
echo "Layout file exists: " . (file_exists($layoutFile) ? 'YES' : 'NO') . "<br>";

// Test 8: Try to render a simple view
echo "<h2>Test 8: Simple View Render</h2>";
try {
    $view = new App\Core\View();
    $view->setLayout(null); // No layout for testing
    $view->render('home/index', ['title' => 'Test']);
    echo "✅ View render successful<br>";
} catch (Exception $e) {
    echo "❌ View render failed: " . $e->getMessage() . "<br>";
    echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<h2>Debug Complete</h2>"; 