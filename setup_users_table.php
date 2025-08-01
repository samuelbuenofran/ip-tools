<?php
// Setup Users Table Script
echo "<h1>Setting up Users Table</h1>";

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=techeletric_ip_tools',
        'techeletric_ip_tools',
        'zsP2rDZDaTea2YEhegmH',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
    
    // Check if users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✅ Users table already exists!</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Users table does not exist. Creating it...</p>";
        
        // Create users table
        $sql = "
        CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(50) NOT NULL UNIQUE,
            `email` varchar(100) NOT NULL UNIQUE,
            `password_hash` varchar(255) NOT NULL,
            `role` enum('admin','user') NOT NULL DEFAULT 'user',
            `is_active` tinyint(1) NOT NULL DEFAULT '1',
            `last_login` timestamp NULL DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_username` (`username`),
            KEY `idx_email` (`email`),
            KEY `idx_role` (`role`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        
        $pdo->exec($sql);
        echo "<p style='color: green;'>✅ Users table created successfully!</p>";
        
        // Insert admin user
        $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $insertSql = "
        INSERT INTO `users` (`username`, `email`, `password_hash`, `role`, `is_active`) 
        VALUES ('admin', 'admin@keizai-tech.com', ?, 'admin', 1)
        ";
        
        $stmt = $pdo->prepare($insertSql);
        $stmt->execute([$adminPassword]);
        echo "<p style='color: green;'>✅ Admin user created successfully!</p>";
        echo "<p><strong>Admin Credentials:</strong></p>";
        echo "<p>Username: admin</p>";
        echo "<p>Password: admin123</p>";
        echo "<p>Email: admin@keizai-tech.com</p>";
    }
    
    // Verify admin user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = 'admin'");
    $stmt->execute();
    $admin = $stmt->fetch();
    
    if ($admin) {
        echo "<p style='color: green;'>✅ Admin user verified!</p>";
    } else {
        echo "<p style='color: red;'>❌ Admin user not found!</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='public/connection_test.php'>Run Connection Test</a></p>";
echo "<p><a href='public/index.php'>Go to Main Application</a></p>";
?> 