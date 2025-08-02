<?php
// Test database connection from public directory
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Testing Database Connection</h1>";

// Test 1: Try to include config.php and use connectDB()
echo "<h2>Test 1: Using main config.php</h2>";
try {
    require_once '../config.php';
    $pdo = connectDB();
    echo "✅ Database connection successful using main config<br>";
    
    // Test a simple query
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM geo_links");
    $result = $stmt->fetch();
    echo "✅ Query successful: " . $result['count'] . " links found<br>";
    
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}

// Test 2: Try direct PDO connection
echo "<h2>Test 2: Direct PDO connection</h2>";
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=techeletric_ip_tools',
        'techeletric_ip_tools',
        'zsP2rDZDaTea2YEhegmH',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "✅ Direct PDO connection successful<br>";
    
    // Test a simple query
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM geo_links");
    $result = $stmt->fetch();
    echo "✅ Query successful: " . $result['count'] . " links found<br>";
    
} catch (Exception $e) {
    echo "❌ Direct PDO connection failed: " . $e->getMessage() . "<br>";
}

echo "<h2>Test Complete</h2>"; 