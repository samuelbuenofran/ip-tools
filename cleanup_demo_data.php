<?php
require_once('config.php');

echo "<h2>🧹 Cleanup Demo Data</h2>";
echo "<p>This script will clean up any demo/test data and fix database inconsistencies.</p>";

try {
    $db = connectDB();
    
    // Check current state
    echo "<h3>📊 Current Database State:</h3>";
    
    $stmt = $db->query("SELECT COUNT(*) as count FROM geo_links");
    $totalLinks = $stmt->fetch()['count'];
    
    $stmt = $db->query("SELECT COUNT(*) as count FROM geo_logs");
    $totalLogs = $stmt->fetch()['count'];
    
    $stmt = $db->query("SELECT SUM(click_count) as total FROM geo_links");
    $totalClicks = $stmt->fetch()['total'] ?? 0;
    
    echo "<p><strong>Total Tracking Links:</strong> {$totalLinks}</p>";
    echo "<p><strong>Total Log Entries:</strong> {$totalLogs}</p>";
    echo "<p><strong>Total Clicks (Database):</strong> {$totalClicks}</p>";
    
    // Fix click counts first
    echo "<h3>🔧 Step 1: Fix Click Counts</h3>";
    
    $stmt = $db->query("SELECT id, short_code, click_count FROM geo_links");
    $links = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $fixedCount = 0;
    foreach ($links as $link) {
        // Count actual logs for this link
        $logStmt = $db->prepare("SELECT COUNT(*) as count FROM geo_logs WHERE link_id = ?");
        $logStmt->execute([$link['id']]);
        $actualLogs = $logStmt->fetch()['count'];
        
        if ($link['click_count'] != $actualLogs) {
            $updateStmt = $db->prepare("UPDATE geo_links SET click_count = ? WHERE id = ?");
            $updateStmt->execute([$actualLogs, $link['id']]);
            $fixedCount++;
            echo "<p>✅ Fixed Link ID {$link['id']} ({$link['short_code']}): {$link['click_count']} → {$actualLogs}</p>";
        }
    }
    
    if ($fixedCount > 0) {
        echo "<p style='color: green;'><strong>Fixed {$fixedCount} click count(s)!</strong></p>";
    } else {
        echo "<p style='color: green;'><strong>All click counts are already correct!</strong></p>";
    }
    
    // Clean up any orphaned logs
    echo "<h3>🧹 Step 2: Clean Orphaned Data</h3>";
    
    $stmt = $db->query("SELECT COUNT(*) as count FROM geo_logs gl LEFT JOIN geo_links gl2 ON gl.link_id = gl2.id WHERE gl2.id IS NULL");
    $orphanedLogs = $stmt->fetch()['count'];
    
    if ($orphanedLogs > 0) {
        echo "<p>Found {$orphanedLogs} orphaned log entries (no matching link)</p>";
        
        if (isset($_GET['cleanup']) && $_GET['cleanup'] === 'yes') {
            $db->query("DELETE FROM geo_logs WHERE link_id NOT IN (SELECT id FROM geo_links)");
            echo "<p style='color: green;'>✅ Cleaned up orphaned logs!</p>";
        } else {
            echo "<p><a href='?cleanup=yes' class='btn btn-warning'>Clean Up Orphaned Data</a></p>";
        }
    } else {
        echo "<p style='color: green;'>✅ No orphaned data found!</p>";
    }
    
    // Show final state
    echo "<h3>📈 Final Database State:</h3>";
    
    $stmt = $db->query("SELECT COUNT(*) as count FROM geo_links");
    $finalLinks = $stmt->fetch()['count'];
    
    $stmt = $db->query("SELECT COUNT(*) as count FROM geo_logs");
    $finalLogs = $stmt->fetch()['count'];
    
    $stmt = $db->query("SELECT SUM(click_count) as total FROM geo_links");
    $finalClicks = $stmt->fetch()['total'] ?? 0;
    
    echo "<p><strong>Total Tracking Links:</strong> {$finalLinks}</p>";
    echo "<p><strong>Total Log Entries:</strong> {$finalLogs}</p>";
    echo "<p><strong>Total Clicks (Fixed):</strong> {$finalClicks}</p>";
    
    // Navigation
    echo "<h3>🔗 Navigation:</h3>";
    echo "<p><a href='geologger/logs.php' class='btn btn-success'>View Dashboard</a></p>";
    echo "<p><a href='check_links_vs_logs.php' class='btn btn-info'>Check Links vs Logs</a></p>";
    echo "<p><a href='fix_click_counts.php' class='btn btn-warning'>Fix Click Counts Only</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>Database connection failed. Please check your config.php file.</strong></p>";
}
?>
