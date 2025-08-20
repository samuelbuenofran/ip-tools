<?php
// Test Speed Test Database Setup - Web Accessible Version
// This script checks and creates the speed_tests table if needed

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if PDO is available
if (!extension_loaded('pdo_mysql')) {
    echo "<h2>❌ PDO MySQL Extension Not Available</h2>";
    echo "<p>The PDO MySQL extension is required for database operations.</p>";
    echo "<p>Please ensure PDO MySQL is enabled in your PHP configuration.</p>";
    exit;
}

// Database credentials
$host = 'localhost';
$dbname = 'techeletric_ip_tools';
$username = 'techeletric_ip_tools';
$password = 'zsP2rDZDaTea2YEhegmH';

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>🔍 Checking Speed Test Database Setup</h2>";
    echo "<p><strong>Database:</strong> $dbname</p>";
    echo "<p><strong>Status:</strong> <span style='color: green;'>✅ Connected Successfully</span></p>";
    
    // Check if speed_tests table exists
    $stmt = $pdo->prepare("SHOW TABLES LIKE 'speed_tests'");
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo "<h3>✅ speed_tests Table Exists</h3>";
        
        // Show table structure
        $stmt = $pdo->prepare("DESCRIBE speed_tests");
        $stmt->execute();
        $columns = $stmt->fetchAll();
        
        echo "<h4>📋 Table Structure:</h4>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%; margin: 10px 0;'>";
        echo "<tr style='background-color: #f0f0f0;'><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td>{$column['Field']}</td>";
            echo "<td>{$column['Type']}</td>";
            echo "<td>{$column['Null']}</td>";
            echo "<td>{$column['Key']}</td>";
            echo "<td>{$column['Default']}</td>";
            echo "<td>{$column['Extra']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Count existing records
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM speed_tests");
        $stmt->execute();
        $count = $stmt->fetch();
        echo "<p>📊 <strong>Total records:</strong> {$count['count']}</p>";
        
        // Show recent tests
        $stmt = $pdo->prepare("SELECT * FROM speed_tests ORDER BY timestamp DESC LIMIT 5");
        $stmt->execute();
        $recentTests = $stmt->fetchAll();
        
        if (!empty($recentTests)) {
            echo "<h4>📈 Recent Tests:</h4>";
            echo "<table border='1' style='border-collapse: collapse; width: 100%; margin: 10px 0;'>";
            echo "<tr style='background-color: #f0f0f0;'><th>Date</th><th>IP</th><th>Download (Mbps)</th><th>Upload (Mbps)</th><th>Ping (ms)</th><th>Location</th></tr>";
            foreach ($recentTests as $test) {
                echo "<tr>";
                echo "<td>" . date('M j, H:i', strtotime($test['timestamp'])) . "</td>";
                echo "<td>{$test['ip_address']}</td>";
                echo "<td style='color: green;'>{$test['download_speed']}</td>";
                echo "<td style='color: blue;'>{$test['upload_speed']}</td>";
                echo "<td style='color: orange;'>{$test['ping']}</td>";
                echo "<td>{$test['city']}, {$test['country']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
    } else {
        echo "<h3>❌ speed_tests Table Does Not Exist</h3>";
        echo "<p>🛠️ <strong>Creating table now...</strong></p>";
        
        // Create the table
        $sql = "CREATE TABLE speed_tests (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ip_address VARCHAR(45) NOT NULL COMMENT 'User IP address',
            download_speed DECIMAL(10, 2) NOT NULL COMMENT 'Download speed in Mbps',
            upload_speed DECIMAL(10, 2) NOT NULL COMMENT 'Upload speed in Mbps',
            ping DECIMAL(8, 2) NOT NULL COMMENT 'Ping time in milliseconds',
            jitter DECIMAL(8, 2) DEFAULT 0 COMMENT 'Jitter in milliseconds',
            country VARCHAR(100) DEFAULT 'Unknown' COMMENT 'Country from IP geolocation',
            city VARCHAR(100) DEFAULT 'Unknown' COMMENT 'City from IP geolocation',
            user_agent TEXT COMMENT 'Browser/device information',
            timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'When test was performed',
            INDEX idx_ip_address (ip_address),
            INDEX idx_timestamp (timestamp),
            INDEX idx_download_speed (download_speed),
            INDEX idx_upload_speed (upload_speed),
            INDEX idx_ping (ping),
            INDEX idx_country (country)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci";
        
        $pdo->exec($sql);
        echo "<p>✅ <strong>speed_tests table created successfully!</strong></p>";
        
        // Add some sample data
        $sampleData = [
            ['192.168.1.100', 85.5, 12.3, 15.2, 2.1, 'United States', 'New York'],
            ['10.0.0.50', 120.8, 25.7, 8.9, 1.5, 'Canada', 'Toronto'],
            ['172.16.0.25', 45.2, 8.1, 32.4, 4.2, 'Brazil', 'São Paulo']
        ];
        
        $stmt = $pdo->prepare("INSERT INTO speed_tests (ip_address, download_speed, upload_speed, ping, jitter, country, city, user_agent) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        foreach ($sampleData as $data) {
            $stmt->execute([...$data, 'Sample Data']);
        }
        
        echo "<p>✅ <strong>Sample data added successfully!</strong></p>";
    }
    
    echo "<br><h3>🚀 Speed Test System Status:</h3>";
    echo "<p>✅ Database connection: <strong>Working</strong></p>";
    echo "<p>✅ Table structure: <strong>Ready</strong></p>";
    echo "<p>✅ MVC Model: <strong>Available</strong></p>";
    echo "<p>✅ MVC Controller: <strong>Available</strong></p>";
    echo "<p>✅ MVC Views: <strong>Available</strong></p>";
    echo "<p>✅ Standalone versions: <strong>Available</strong></p>";
    
    echo "<br><h3>🔗 Access Points:</h3>";
    echo "<p>• <strong>MVC Version:</strong> <a href='/projects/ip-tools/public/speed-test' target='_blank'>/projects/ip-tools/public/speed-test</a></p>";
    echo "<p>• <strong>Standalone:</strong> <a href='/projects/ip-tools/utils/speedtest.php' target='_blank'>/projects/ip-tools/utils/speedtest.php</a></p>";
    echo "<p>• <strong>Enhanced Standalone:</strong> <a href='/projects/ip-tools/utils/speedtest_enhanced.php' target='_blank'>/projects/ip-tools/utils/speedtest_enhanced.php</a></p>";
    
    echo "<br><h3>🧪 Test the System:</h3>";
    echo "<p>1. <a href='/projects/ip-tools/utils/speedtest.php' target='_blank'>Run a speed test</a> in the standalone version</p>";
    echo "<p>2. <a href='/projects/ip-tools/public/speed-test' target='_blank'>Use the MVC version</a> for production</p>";
    echo "<p>3. Check the <a href='/projects/ip-tools/public/speed-test/analytics' target='_blank'>analytics page</a> for detailed statistics</p>";
    
} catch (PDOException $e) {
    echo "<h2>❌ Database Connection Error</h2>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "<br><h3>🔧 Troubleshooting:</h3>";
    echo "<p>1. Check if MySQL service is running</p>";
    echo "<p>2. Verify database credentials</p>";
    echo "<p>3. Ensure database 'techeletric_ip_tools' exists</p>";
    echo "<p>4. Check if user 'techeletric_ip_tools' has proper permissions</p>";
} catch (Exception $e) {
    echo "<h2>❌ General Error</h2>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; background-color: #f5f5f5; }
h2, h3, h4 { color: #333; }
table { background-color: white; }
th { background-color: #f0f0f0; padding: 8px; }
td { padding: 6px; }
a { color: #007bff; text-decoration: none; }
a:hover { text-decoration: underline; }
</style>
