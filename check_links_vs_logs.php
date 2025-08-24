<?php
require_once('config.php');

echo "<h2>🔍 Links vs Logs Analysis</h2>";

try {
    $db = connectDB();
    
    // Check geo_links table
    echo "<h3>📋 Tracking Links (geo_links):</h3>";
    $stmt = $db->query("SELECT * FROM geo_links ORDER BY created_at DESC");
    $links = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0; font-size: 12px;'>";
    echo "<tr><th>ID</th><th>Short Code</th><th>Original URL</th><th>Created</th><th>Expires</th><th>Click Count</th><th>Status</th></tr>";
    
    foreach ($links as $link) {
        $status = 'Active';
        if ($link['expires_at'] && strtotime($link['expires_at']) < time()) {
            $status = 'Expired';
        }
        if ($link['click_limit'] > 0 && $link['click_count'] >= $link['click_limit']) {
            $status = 'Limit Reached';
        }
        
        echo "<tr>";
        echo "<td>{$link['id']}</td>";
        echo "<td>{$link['short_code']}</td>";
        echo "<td>" . htmlspecialchars($link['original_url']) . "</td>";
        echo "<td>{$link['created_at']}</td>";
        echo "<td>" . ($link['expires_at'] ?? 'Never') . "</td>";
        echo "<td>{$link['click_count']}</td>";
        echo "<td style='color: " . ($status === 'Active' ? 'green' : 'red') . ";'>{$status}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Check geo_logs table
    echo "<h3>📊 Tracking Logs (geo_logs):</h3>";
    $stmt = $db->query("SELECT * FROM geo_logs ORDER BY timestamp DESC");
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0; font-size: 12px;'>";
    echo "<tr><th>ID</th><th>Link ID</th><th>Short Code</th><th>IP Address</th><th>City</th><th>Country</th><th>Timestamp</th></tr>";
    
    foreach ($logs as $log) {
        // Get the short_code from geo_links
        $shortCode = 'Unknown';
        if ($log['link_id']) {
            $linkStmt = $db->prepare("SELECT short_code FROM geo_links WHERE id = ?");
            $linkStmt->execute([$log['link_id']]);
            $linkData = $linkStmt->fetch();
            if ($linkData) {
                $shortCode = $linkData['short_code'];
            }
        }
        
        echo "<tr>";
        echo "<td>{$log['id']}</td>";
        echo "<td>{$log['link_id']}</td>";
        echo "<td>{$shortCode}</td>";
        echo "<td>{$log['ip_address']}</td>";
        echo "<td>{$log['city']}</td>";
        echo "<td>{$log['country']}</td>";
        echo "<td>{$log['timestamp']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Summary
    echo "<h3>📈 Summary:</h3>";
    echo "<p><strong>Total Tracking Links:</strong> " . count($links) . "</p>";
    echo "<p><strong>Total Log Entries:</strong> " . count($logs) . "</p>";
    
    // Check which links have been clicked
    $clickedLinks = [];
    foreach ($logs as $log) {
        if ($log['link_id']) {
            $clickedLinks[] = $log['link_id'];
        }
    }
    $clickedLinks = array_unique($clickedLinks);
    
    echo "<p><strong>Links That Have Been Clicked:</strong> " . count($clickedLinks) . "</p>";
    echo "<p><strong>Links Never Clicked:</strong> " . (count($links) - count($clickedLinks)) . "</p>";
    
    // Show unclicked links
    if (count($clickedLinks) < count($links)) {
        echo "<h3>🔗 Unclicked Links:</h3>";
        echo "<ul>";
        foreach ($links as $link) {
            if (!in_array($link['id'], $clickedLinks)) {
                echo "<li><strong>{$link['short_code']}</strong> → {$link['original_url']} (Created: {$link['created_at']})</li>";
            }
        }
        echo "</ul>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>
