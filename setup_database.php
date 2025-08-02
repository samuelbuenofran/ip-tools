<?php
// Database setup script
// This script will create the database, user, and tables if they don't exist

// Root database credentials (you'll need to provide these)
$root_host = 'localhost';
$root_user = 'root'; // Change this to your MySQL root username
$root_pass = ''; // Change this to your MySQL root password

// Application database credentials
$app_db_name = 'techeletric_ip_tools';
$app_user = 'techeletric_ip_tools';
$app_pass = 'zsP2rDZDaTea2YEhegmH';

echo "<h1>Database Setup Script</h1>";

try {
    // Connect as root to create database and user
    $pdo = new PDO("mysql:host=$root_host", $root_user, $root_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Step 1: Creating Database</h2>";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$app_db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ Database '$app_db_name' created or already exists<br>";
    
    echo "<h2>Step 2: Creating User</h2>";
    $pdo->exec("CREATE USER IF NOT EXISTS '$app_user'@'localhost' IDENTIFIED BY '$app_pass'");
    echo "✅ User '$app_user' created or already exists<br>";
    
    echo "<h2>Step 3: Granting Permissions</h2>";
    $pdo->exec("GRANT ALL PRIVILEGES ON `$app_db_name`.* TO '$app_user'@'localhost'");
    $pdo->exec("FLUSH PRIVILEGES");
    echo "✅ Permissions granted to user '$app_user'<br>";
    
    echo "<h2>Step 4: Testing Application Connection</h2>";
    // Test the application connection
    $app_pdo = new PDO("mysql:host=$root_host;dbname=$app_db_name", $app_user, $app_pass);
    $app_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Application database connection successful<br>";
    
    echo "<h2>Step 5: Creating Tables</h2>";
    
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(50) NOT NULL UNIQUE,
        `email` varchar(100) NOT NULL UNIQUE,
        `password` varchar(255) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `last_login` timestamp NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $app_pdo->exec($sql);
    echo "✅ Users table created<br>";
    
    // Create geo_links table
    $sql = "CREATE TABLE IF NOT EXISTS `geo_links` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) DEFAULT NULL,
        `short_code` varchar(10) NOT NULL UNIQUE,
        `original_url` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `expires_at` timestamp NULL,
        `clicks` int(11) DEFAULT 0,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`),
        CONSTRAINT `geo_links_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $app_pdo->exec($sql);
    echo "✅ Geo links table created<br>";
    
    // Create geo_logs table
    $sql = "CREATE TABLE IF NOT EXISTS `geo_logs` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) DEFAULT NULL,
        `link_id` int(11) DEFAULT NULL,
        `short_code` varchar(10) NOT NULL,
        `ip_address` varchar(45) NOT NULL,
        `user_agent` text,
        `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `country` varchar(100) DEFAULT NULL,
        `region` varchar(100) DEFAULT NULL,
        `city` varchar(100) DEFAULT NULL,
        `latitude` decimal(10,8) DEFAULT NULL,
        `longitude` decimal(11,8) DEFAULT NULL,
        `accuracy` decimal(10,2) DEFAULT NULL,
        `address` text DEFAULT NULL,
        `location_type` enum('IP','GPS') DEFAULT 'IP',
        `street` varchar(255) DEFAULT NULL,
        `house_number` varchar(20) DEFAULT NULL,
        `postcode` varchar(20) DEFAULT NULL,
        `state` varchar(100) DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`),
        KEY `link_id` (`link_id`),
        KEY `short_code` (`short_code`),
        CONSTRAINT `geo_logs_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
        CONSTRAINT `geo_logs_link_id_fk` FOREIGN KEY (`link_id`) REFERENCES `geo_links` (`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $app_pdo->exec($sql);
    echo "✅ Geo logs table created<br>";
    
    // Create admin user
    echo "<h2>Step 6: Creating Admin User</h2>";
    $admin_username = 'admin';
    $admin_email = 'admin@keizai-tech.com';
    $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
    
    // Check if admin user exists
    $stmt = $app_pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$admin_username, $admin_email]);
    
    if ($stmt->rowCount() == 0) {
        $stmt = $app_pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$admin_username, $admin_email, $admin_password]);
        echo "✅ Admin user created<br>";
        echo "Username: admin<br>";
        echo "Password: admin123<br>";
    } else {
        echo "✅ Admin user already exists<br>";
    }
    
    echo "<h2>Setup Complete!</h2>";
    echo "<p>Your database is now ready to use. You can:</p>";
    echo "<ul>";
    echo "<li><a href='public/'>Access the application</a></li>";
    echo "<li><a href='public/auth/login'>Login as admin</a></li>";
    echo "</ul>";
    
} catch (PDOException $e) {
    echo "<h2>Error</h2>";
    echo "<p>Database setup failed: " . $e->getMessage() . "</p>";
    echo "<p>Please check:</p>";
    echo "<ul>";
    echo "<li>MySQL server is running</li>";
    echo "<li>Root credentials are correct</li>";
    echo "<li>You have permission to create databases and users</li>";
    echo "</ul>";
}
?> 