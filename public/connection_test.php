<?php
// Database connection test
echo "<h1>Database Connection Test</h1>";

// Test 1: Basic PDO connection
echo "<h2>Test 1: Basic PDO Connection</h2>";
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=techeletric_ip_tools',
        'techeletric_ip_tools',
        'zsP2rDZDaTea2YEhegmH',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "<p style='color: green;'>✅ Basic PDO connection successful!</p>";
    
    // Test query
    $stmt = $pdo->query("SELECT COUNT(*) FROM geo_links");
    $count = $stmt->fetchColumn();
    echo "<p>✅ Database query successful! Found {$count} links.</p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ PDO Connection failed: " . $e->getMessage() . "</p>";
}

// Test 2: Check if users table exists
echo "<h2>Test 2: Check Users Table</h2>";
try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✅ Users table exists!</p>";
        
        // Check if admin user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = 'admin'");
        $stmt->execute();
        $admin = $stmt->fetch();
        
        if ($admin) {
            echo "<p style='color: green;'>✅ Admin user exists!</p>";
            echo "<p>Username: {$admin['username']}</p>";
            echo "<p>Email: {$admin['email']}</p>";
            echo "<p>Role: {$admin['role']}</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ Admin user not found. You may need to run the users_table.sql script.</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Users table does not exist!</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error checking users table: " . $e->getMessage() . "</p>";
}

// Test 3: MVC Structure
echo "<h2>Test 3: MVC Structure</h2>";
try {
    require_once '../autoload.php';
    echo "<p style='color: green;'>✅ Autoloader loaded successfully!</p>";
    
    // Test MVC classes
    if (class_exists('App\Config\App')) {
        echo "<p style='color: green;'>✅ App class exists!</p>";
    } else {
        echo "<p style='color: red;'>❌ App class not found!</p>";
    }
    
    if (class_exists('App\Config\Database')) {
        echo "<p style='color: green;'>✅ Database class exists!</p>";
    } else {
        echo "<p style='color: red;'>❌ Database class not found!</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ MVC Structure error: " . $e->getMessage() . "</p>";
}

echo "<h2>Test Complete</h2>";
echo "<p><a href='index.php'>Go to main application</a></p>";
?> 