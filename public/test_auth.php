<?php
// Test authentication system
echo "<h1>Authentication System Test</h1>";

// Test database connection
try {
    require_once '../app/Config/Database.php';
    $db = App\Config\Database::getInstance()->getConnection();
    echo "✅ Database connection successful<br>";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
    exit;
}

// Test User model
try {
    require_once '../app/Models/User.php';
    $userModel = new App\Models\User();
    echo "✅ User model loaded successfully<br>";
} catch (Exception $e) {
    echo "❌ User model failed: " . $e->getMessage() . "<br>";
    exit;
}

// Test if users table exists
try {
    $stmt = $db->query("SELECT COUNT(*) FROM users");
    $userCount = $stmt->fetchColumn();
    echo "✅ Users table exists with $userCount users<br>";
} catch (Exception $e) {
    echo "❌ Users table error: " . $e->getMessage() . "<br>";
    echo "Please run the users_table.sql script to create the users table.<br>";
}

// Test if geo_links table has user_id column
try {
    $stmt = $db->query("DESCRIBE geo_links");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    if (in_array('user_id', $columns)) {
        echo "✅ geo_links table has user_id column<br>";
    } else {
        echo "⚠️ geo_links table missing user_id column<br>";
    }
} catch (Exception $e) {
    echo "❌ geo_links table error: " . $e->getMessage() . "<br>";
}

// Test if geo_logs table has user_id column
try {
    $stmt = $db->query("DESCRIBE geo_logs");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    if (in_array('user_id', $columns)) {
        echo "✅ geo_logs table has user_id column<br>";
    } else {
        echo "⚠️ geo_logs table missing user_id column<br>";
    }
} catch (Exception $e) {
    echo "❌ geo_logs table error: " . $e->getMessage() . "<br>";
}

// Test admin user exists
try {
    $adminUser = $userModel->findByUsernameOrEmail('admin');
    if ($adminUser) {
        echo "✅ Admin user exists<br>";
        echo "Admin username: " . $adminUser['username'] . "<br>";
        echo "Admin email: " . $adminUser['email'] . "<br>";
        echo "Admin role: " . $adminUser['role'] . "<br>";
    } else {
        echo "⚠️ Admin user not found<br>";
    }
} catch (Exception $e) {
    echo "❌ Admin user test failed: " . $e->getMessage() . "<br>";
}

echo "<h2>Test Credentials</h2>";
echo "<p><strong>Username:</strong> admin</p>";
echo "<p><strong>Password:</strong> admin123</p>";
echo "<p><strong>Email:</strong> admin@keizai-tech.com</p>";

echo "<h2>Next Steps</h2>";
echo "<p>1. If all tests pass, you can access the login page at: <a href='auth/login'>Login</a></p>";
echo "<p>2. Register a new account at: <a href='auth/register'>Register</a></p>";
echo "<p>3. Access the dashboard at: <a href='dashboard'>Dashboard</a></p>";
?> 