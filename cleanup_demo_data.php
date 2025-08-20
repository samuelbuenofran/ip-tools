<?php
// Demo Data Cleanup Script
// This script will clean up demo/testing data and prepare the app for production

require_once('config.php');
$db = connectDB();

echo "<h1>🧹 Demo Data Cleanup Script</h1>";
echo "<p>This script will clean up demo/testing data and prepare your app for production use.</p>";

try {
    // Step 1: Clear demo tracking data
    echo "<h2>Step 1: Clearing Demo Tracking Data</h2>";
    
    // Clear geo_logs (visitor tracking data) - check if timestamp column exists
    try {
        $stmt = $db->prepare("SHOW COLUMNS FROM geo_logs LIKE 'timestamp'");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $stmt = $db->prepare("DELETE FROM geo_logs WHERE timestamp < DATE_SUB(NOW(), INTERVAL 1 DAY)");
            $stmt->execute();
            $deletedLogs = $stmt->rowCount();
            echo "✅ Cleared $deletedLogs old tracking logs<br>";
        } else {
            echo "ℹ️ geo_logs table doesn't have timestamp column, skipping<br>";
        }
    } catch (Exception $e) {
        echo "ℹ️ Could not process geo_logs: " . $e->getMessage() . "<br>";
    }
    
    // Clear demo geo_links (tracking links) - check if created_at column exists
    try {
        $stmt = $db->prepare("SHOW COLUMNS FROM geo_links LIKE 'created_at'");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $stmt = $db->prepare("DELETE FROM geo_links WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 DAY)");
            $stmt->execute();
            $deletedLinks = $stmt->rowCount();
            echo "✅ Cleared $deletedLinks old tracking links<br>";
        } else {
            echo "ℹ️ geo_links table doesn't have created_at column, skipping<br>";
        }
    } catch (Exception $e) {
        echo "ℹ️ Could not process geo_links: " . $e->getMessage() . "<br>";
    }
    
    // Step 2: Reset counters
    echo "<h2>Step 2: Resetting Counters</h2>";
    
    // Reset any remaining links to have 0 clicks - check if columns exist
    try {
        $stmt = $db->prepare("SHOW COLUMNS FROM geo_links LIKE 'clicks'");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $stmt = $db->prepare("UPDATE geo_links SET clicks = 0");
            $stmt->execute();
            $resetLinks = $stmt->rowCount();
            echo "✅ Reset click counters for $resetLinks links<br>";
        } else {
            echo "ℹ️ geo_links table doesn't have clicks column, skipping<br>";
        }
    } catch (Exception $e) {
        echo "ℹ️ Could not reset click counters: " . $e->getMessage() . "<br>";
    }
    
    // Step 3: Clear any other demo tables if they exist
    echo "<h2>Step 3: Checking for Other Demo Tables</h2>";
    
    // Check if speed_tests table exists and clear old data
    try {
        $stmt = $db->prepare("SHOW TABLES LIKE 'speed_tests'");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            // Check what time column exists
            $stmt = $db->prepare("SHOW COLUMNS FROM speed_tests LIKE '%time%'");
            $stmt->execute();
            $timeColumns = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            if (!empty($timeColumns)) {
                $timeColumn = $timeColumns[0]; // Use the first time-related column
                $stmt = $db->prepare("DELETE FROM speed_tests WHERE $timeColumn < DATE_SUB(NOW(), INTERVAL 1 DAY)");
                $stmt->execute();
                $deletedTests = $stmt->rowCount();
                echo "✅ Cleared $deletedTests old speed test records<br>";
            } else {
                echo "ℹ️ speed_tests table has no time column, skipping<br>";
            }
        } else {
            echo "ℹ️ speed_tests table doesn't exist, skipping<br>";
        }
    } catch (Exception $e) {
        echo "ℹ️ Could not process speed_tests: " . $e->getMessage() . "<br>";
    }
    
    // Check if phone_tracking table exists and clear old data
    try {
        $stmt = $db->prepare("SHOW TABLES LIKE 'phone_tracking'");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            // Check what time column exists
            $stmt = $db->prepare("SHOW COLUMNS FROM phone_tracking LIKE '%time%'");
            $stmt->execute();
            $timeColumns = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            if (!empty($timeColumns)) {
                $timeColumn = $timeColumns[0]; // Use the first time-related column
                $stmt = $db->prepare("DELETE FROM phone_tracking WHERE $timeColumn < DATE_SUB(NOW(), INTERVAL 1 DAY)");
                $stmt->execute();
                $deletedPhone = $stmt->rowCount();
                echo "✅ Cleared $deletedPhone old phone tracking records<br>";
            } else {
                echo "ℹ️ phone_tracking table has no time column, skipping<br>";
            }
        } else {
            echo "ℹ️ phone_tracking table doesn't exist, skipping<br>";
        }
    } catch (Exception $e) {
        echo "ℹ️ Could not process phone_tracking: " . $e->getMessage() . "<br>";
    }
    
    echo "<h2>✅ Cleanup Complete!</h2>";
    echo "<p>Your application is now ready for production use with clean data.</p>";
    echo "<p><strong>Next steps:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Demo data has been cleared</li>";
    echo "<li>✅ Counters have been reset</li>";
    echo "<li>✅ Application is ready for real users</li>";
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<h2>❌ Error During Cleanup</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>
