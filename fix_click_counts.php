<?php
require_once('config.php');

echo "<h2>🔧 Fix Click Counts</h2>";

try {
    $db = connectDB();
    
    // Get all links
    $stmt = $db->query("SELECT id, short_code, original_url FROM geo_links");
    $links = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>📊 Current Click Counts vs Actual Logs:</h3>";
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0; font-size: 12px;'>";
    echo "<tr><th>Link ID</th><th>Short Code</th><th>Current Click Count</th><th>Actual Logs</th><th>Status</th></tr>";
    
    $totalFixed = 0;
    
    foreach ($links as $link) {
        // Count actual logs for this link
        $logStmt = $db->prepare("SELECT COUNT(*) as count FROM geo_logs WHERE link_id = ?");
        $logStmt->execute([$link['id']]);
        $actualLogs = $logStmt->fetch()['count'];
        
        // Get current click count
        $clickStmt = $db->prepare("SELECT click_count FROM geo_links WHERE id = ?");
        $clickStmt->execute([$link['id']]);
        $currentCount = $clickStmt->fetch()['click_count'];
        
        $status = 'OK';
        $needsFix = false;
        
        if ($currentCount != $actualLogs) {
            $status = 'NEEDS FIX';
            $needsFix = true;
        }
        
        echo "<tr>";
        echo "<td>{$link['id']}</td>";
        echo "<td>{$link['short_code']}</td>";
        echo "<td>{$currentCount}</td>";
        echo "<td>{$actualLogs}</td>";
        echo "<td style='color: " . ($needsFix ? 'red' : 'green') . ";'>{$status}</td>";
        echo "</tr>";
        
        // Fix if needed
        if ($needsFix) {
            $updateStmt = $db->prepare("UPDATE geo_links SET click_count = ? WHERE id = ?");
            $updateStmt->execute([$actualLogs, $link['id']]);
            $totalFixed++;
        }
    }
    echo "</table>";
    
    if ($totalFixed > 0) {
        echo "<p style='color: green;'>✅ Fixed {$totalFixed} click count(s)!</p>";
    } else {
        echo "<p style='color: green;'>✅ All click counts are correct!</p>";
    }
    
    // Show updated summary
    echo "<h3>📈 Updated Summary:</h3>";
    $stmt = $db->query("SELECT COUNT(*) as total FROM geo_links");
    $totalLinks = $stmt->fetch()['total'];
    
    $stmt = $db->query("SELECT SUM(click_count) as total FROM geo_links");
    $totalClicks = $stmt->fetch()['total'] ?? 0;
    
    $stmt = $db->query("SELECT COUNT(*) as total FROM geo_logs");
    $totalLogs = $stmt->fetch()['total'];
    
    echo "<p><strong>Total Tracking Links:</strong> {$totalLinks}</p>";
    echo "<p><strong>Total Clicks (Updated):</strong> {$totalClicks}</p>";
    echo "<p><strong>Total Log Entries:</strong> {$totalLogs}</p>";
    
    echo "<p><a href='geologger/logs.php' class='btn btn-success'>View Updated Dashboard</a></p>";
    echo "<p><a href='check_links_vs_logs.php' class='btn btn-info'>Check Links vs Logs Again</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>
