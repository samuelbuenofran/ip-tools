<?php
// Simple database connection test
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Connection Test</h1>";

// Test different connection scenarios
$test_configs = [
    [
        'name' => 'Current Application Config',
        'host' => 'localhost',
        'dbname' => 'techeletric_ip_tools',
        'username' => 'techeletric_ip_tools',
        'password' => 'zsP2rDZDaTea2YEhegmH'
    ],
    [
        'name' => 'Root Connection (No Database)',
        'host' => 'localhost',
        'dbname' => '',
        'username' => 'root',
        'password' => ''
    ],
    [
        'name' => 'Root Connection (No Password)',
        'host' => 'localhost',
        'dbname' => 'techeletric_ip_tools',
        'username' => 'root',
        'password' => ''
    ]
];

foreach ($test_configs as $config) {
    echo "<h2>Testing: {$config['name']}</h2>";
    
    try {
        $dsn = "mysql:host={$config['host']}";
        if (!empty($config['dbname'])) {
            $dsn .= ";dbname={$config['dbname']}";
        }
        
        $pdo = new PDO($dsn, $config['username'], $config['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "✅ Connection successful<br>";
        
        // Test a simple query
        $stmt = $pdo->query("SELECT VERSION() as version");
        $result = $stmt->fetch();
        echo "MySQL Version: {$result['version']}<br>";
        
        // If we're connected to the application database, check tables
        if (!empty($config['dbname']) && $config['dbname'] === 'techeletric_ip_tools') {
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo "Tables found: " . implode(', ', $tables) . "<br>";
        }
        
    } catch (PDOException $e) {
        echo "❌ Connection failed: " . $e->getMessage() . "<br>";
    }
    
    echo "<hr>";
}

echo "<h2>Next Steps</h2>";
echo "<p>Based on the results above:</p>";
echo "<ul>";
echo "<li>If 'Root Connection (No Database)' works, you can run <a href='setup_database.php'>setup_database.php</a></li>";
echo "<li>If 'Root Connection (No Password)' works, update the database config to use root</li>";
echo "<li>If all fail, check if MySQL is running and accessible</li>";
echo "</ul>";
?> 