<?php
// Debug script to identify the specific error
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Error Debug Script</h1>";

// Test 1: Check if we can load the basic classes
echo "<h2>Test 1: Basic Class Loading</h2>";
try {
    require_once '../app/Config/App.php';
    echo "✅ App.php loaded<br>";
} catch (Exception $e) {
    echo "❌ App.php failed: " . $e->getMessage() . "<br>";
}

try {
    require_once '../app/Config/Database.php';
    echo "✅ Database.php loaded<br>";
} catch (Exception $e) {
    echo "❌ Database.php failed: " . $e->getMessage() . "<br>";
}

try {
    require_once '../app/Core/Controller.php';
    echo "✅ Controller.php loaded<br>";
} catch (Exception $e) {
    echo "❌ Controller.php failed: " . $e->getMessage() . "<br>";
}

try {
    require_once '../app/Core/View.php';
    echo "✅ View.php loaded<br>";
} catch (Exception $e) {
    echo "❌ View.php failed: " . $e->getMessage() . "<br>";
}

// Test 2: Check if we can create instances
echo "<h2>Test 2: Instance Creation</h2>";
try {
    $app = new App\Config\App();
    echo "✅ App instance created<br>";
} catch (Exception $e) {
    echo "❌ App instance failed: " . $e->getMessage() . "<br>";
}

try {
    $db = App\Config\Database::getInstance();
    echo "✅ Database instance created<br>";
} catch (Exception $e) {
    echo "❌ Database instance failed: " . $e->getMessage() . "<br>";
}

// Test 3: Check database connection
echo "<h2>Test 3: Database Connection</h2>";
try {
    $db = App\Config\Database::getInstance();
    $connection = $db->getConnection();
    echo "✅ Database connection successful<br>";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}

// Test 4: Check if users table exists
echo "<h2>Test 4: Users Table</h2>";
try {
    $db = App\Config\Database::getInstance();
    $connection = $db->getConnection();
    
    $stmt = $connection->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Users table exists<br>";
        
        // Check table structure
        $stmt = $connection->query("DESCRIBE users");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "Users table columns: " . implode(', ', $columns) . "<br>";
    } else {
        echo "❌ Users table does not exist<br>";
    }
} catch (Exception $e) {
    echo "❌ Users table check failed: " . $e->getMessage() . "<br>";
}

// Test 5: Check User model
echo "<h2>Test 5: User Model</h2>";
try {
    require_once '../app/Models/User.php';
    $userModel = new App\Models\User();
    echo "✅ User model created<br>";
} catch (Exception $e) {
    echo "❌ User model failed: " . $e->getMessage() . "<br>";
}

// Test 6: Check AuthController
echo "<h2>Test 6: AuthController</h2>";
try {
    require_once '../app/Controllers/AuthController.php';
    $authController = new App\Controllers\AuthController();
    echo "✅ AuthController created<br>";
} catch (Exception $e) {
    echo "❌ AuthController failed: " . $e->getMessage() . "<br>";
}

// Test 7: Check view files
echo "<h2>Test 7: View Files</h2>";
$viewFiles = [
    '../app/Views/auth/login.php',
    '../app/Views/auth/register.php',
    '../app/Views/auth/profile.php',
    '../app/Views/layouts/default.php'
];

foreach ($viewFiles as $file) {
    if (file_exists($file)) {
        echo "✅ $file exists<br>";
    } else {
        echo "❌ $file missing<br>";
    }
}

// Test 8: Check if we can render a simple view
echo "<h2>Test 8: Simple View Render</h2>";
try {
    $view = new App\Core\View();
    echo "✅ View instance created<br>";
    
    // Try to render a simple view
    $view->setLayout(null); // No layout for testing
    $view->render('auth/login', ['title' => 'Test']);
    echo "✅ View render successful<br>";
} catch (Exception $e) {
    echo "❌ View render failed: " . $e->getMessage() . "<br>";
    echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<h2>Debug Complete</h2>";
echo "<p>Check the output above to identify the specific error.</p>";
?> 