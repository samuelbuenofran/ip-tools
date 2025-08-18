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
    
    // Clear geo_logs (visitor tracking data)
    $stmt = $db->prepare("DELETE FROM geo_logs WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 DAY)");
    $stmt->execute();
    $deletedLogs = $stmt->rowCount();
    echo "✅ Cleared $deletedLogs old tracking logs<br>";
    
    // Clear demo geo_links (tracking links)
    $stmt = $db->prepare("DELETE FROM geo_links WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 DAY)");
    $stmt->execute();
    $deletedLinks = $stmt->rowCount();
    echo "✅ Cleared $deletedLinks old tracking links<br>";
    
    // Step 2: Reset counters
    echo "<h2>Step 2: Resetting Counters</h2>";
    
    // Reset any remaining links to have 0 clicks
    $stmt = $db->prepare("UPDATE geo_links SET clicks = 0, click_count = 0");
    $stmt->execute();
    $resetLinks = $stmt->rowCount();
    echo "✅ Reset click counters for $resetLinks links<br>";
    
    // Step 3: Clear any other demo tables if they exist
    echo "<h2>Step 3: Checking for Other Demo Tables</h2>";
    
    // Check if speed_tests table exists and clear old data
    $stmt = $db->prepare("SHOW TABLES LIKE 'speed_tests'");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $stmt = $db->prepare("DELETE FROM speed_tests WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 DAY)");
        $stmt->execute();
        $deletedTests = $stmt->rowCount();
        echo "✅ Cleared $deletedTests old speed test records<br>";
    }
    
    // Check if phone_tracking table exists and clear old data
    $stmt = $db->prepare("SHOW TABLES LIKE 'phone_tracking'");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $stmt = $db->prepare("DELETE FROM phone_tracking WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 DAY)");
        $stmt->execute();
        $deletedPhone = $stmt->rowCount();
        echo "✅ Cleared $deletedPhone old phone tracking records<br>";
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
