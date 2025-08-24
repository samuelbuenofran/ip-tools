<?php
require_once('config.php');

echo "<h2>🔍 Heatmap Data Diagnostic</h2>";

try {
    $db = connectDB();
    
    // Check table structure
    echo "<h3>📋 Table Structure:</h3>";
    $stmt = $db->query("DESCRIBE geo_logs");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th>Column</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    foreach ($columns as $col) {
        echo "<tr>";
        echo "<td>{$col['Field']}</td>";
        echo "<td>{$col['Type']}</td>";
        echo "<td>{$col['Null']}</td>";
        echo "<td>{$col['Key']}</td>";
        echo "<td>{$col['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Check total records
    echo "<h3>📊 Data Counts:</h3>";
    $stmt = $db->query("SELECT COUNT(*) as total FROM geo_logs");
    $total = $stmt->fetch()['total'];
    echo "<p><strong>Total geo_logs records:</strong> {$total}</p>";
    
    // Check records with coordinates
    $stmt = $db->query("SELECT COUNT(*) as total FROM geo_logs WHERE latitude IS NOT NULL AND longitude IS NOT NULL");
    $withCoords = $stmt->fetch()['total'];
    echo "<p><strong>Records with coordinates:</strong> {$withCoords}</p>";
    
    // Check records with accuracy
    $stmt = $db->query("SELECT COUNT(*) as total FROM geo_logs WHERE accuracy IS NOT NULL");
    $withAccuracy = $stmt->fetch()['total'];
    echo "<p><strong>Records with accuracy:</strong> {$withAccuracy}</p>";
    
    // Check records with location_type
    $stmt = $db->query("SELECT COUNT(*) as total FROM geo_logs WHERE location_type IS NOT NULL");
    $withLocationType = $stmt->fetch()['total'];
    echo "<p><strong>Records with location_type:</strong> {$withLocationType}</p>";
    
    // Check records with link_id
    $stmt = $db->query("SELECT COUNT(*) as total FROM geo_logs WHERE link_id IS NOT NULL");
    $withLinkId = $stmt->fetch()['total'];
    echo "<p><strong>Records with link_id:</strong> {$withLinkId}</p>";
    
    // Show sample data
    if ($total > 0) {
        echo "<h3>🔍 Sample Data:</h3>";
        $stmt = $db->query("SELECT * FROM geo_logs ORDER BY timestamp DESC LIMIT 5");
        $samples = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0; font-size: 12px;'>";
        if (!empty($samples)) {
            echo "<tr>";
            foreach (array_keys($samples[0]) as $header) {
                echo "<th>{$header}</th>";
            }
            echo "</tr>";
            
            foreach ($samples as $row) {
                echo "<tr>";
                foreach ($row as $value) {
                    $displayValue = $value === null ? '<em>NULL</em>' : htmlspecialchars($value);
                    echo "<td>{$displayValue}</td>";
                }
                echo "</tr>";
            }
        }
        echo "</table>";
    }
    
    // Check if there are any geo_links
    echo "<h3>🔗 Tracking Links:</h3>";
    $stmt = $db->query("SELECT COUNT(*) as total FROM geo_links");
    $totalLinks = $stmt->fetch()['total'];
    echo "<p><strong>Total tracking links:</strong> {$totalLinks}</p>";
    
    if ($totalLinks > 0) {
        $stmt = $db->query("SELECT * FROM geo_links ORDER BY created_at DESC LIMIT 3");
        $links = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0; font-size: 12px;'>";
        if (!empty($links)) {
            echo "<tr>";
            foreach (array_keys($links[0]) as $header) {
                echo "<th>{$header}</th>";
            }
            echo "</tr>";
            
            foreach ($links as $row) {
                echo "<tr>";
                foreach ($row as $value) {
                    $displayValue = $value === null ? '<em>NULL</em>' : htmlspecialchars($value);
                    echo "<td>{$displayValue}</td>";
                }
                echo "</tr>";
            }
        }
        echo "</table>";
    }
    
    // Test the JOIN query that's failing
    echo "<h3>🔗 JOIN Query Test:</h3>";
    try {
        $stmt = $db->query("
            SELECT COUNT(*) as total 
            FROM geo_logs g 
            JOIN geo_links l ON g.link_id = l.id
        ");
        $joinCount = $stmt->fetch()['total'];
        echo "<p><strong>JOIN query result:</strong> {$joinCount} records</p>";
        
        if ($joinCount == 0) {
            echo "<p style='color: red;'><strong>🚨 PROBLEM FOUND!</strong> The JOIN query returns 0 records!</p>";
            echo "<p>This means either:</p>";
            echo "<ul>";
            echo "<li>geo_logs.link_id values don't match geo_links.id values</li>";
            echo "<li>geo_links table is empty</li>";
            echo "<li>geo_logs.link_id values are NULL</li>";
            echo "</ul>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'><strong>🚨 JOIN Query Error:</strong> " . $e->getMessage() . "</p>";
    }
    
    // Test LEFT JOIN to see all geo_logs
    echo "<h3>🔍 LEFT JOIN Test (Shows All geo_logs):</h3>";
    try {
        $stmt = $db->query("
            SELECT g.id, g.latitude, g.longitude, g.link_id, l.short_code
            FROM geo_logs g 
            LEFT JOIN geo_links l ON g.link_id = l.id
            ORDER BY g.timestamp DESC 
            LIMIT 10
        ");
        $leftJoinResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0; font-size: 12px;'>";
        echo "<tr><th>ID</th><th>Latitude</th><th>Longitude</th><th>Link ID</th><th>Short Code</th></tr>";
        foreach ($leftJoinResults as $row) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>" . ($row['latitude'] ?? '<em>NULL</em>') . "</td>";
            echo "<td>" . ($row['longitude'] ?? '<em>NULL</em>') . "</td>";
            echo "<td>" . ($row['link_id'] ?? '<em>NULL</em>') . "</td>";
            echo "<td>" . ($row['short_code'] ?? '<em>NULL</em>') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } catch (Exception $e) {
        echo "<p style='color: red;'><strong>🚨 LEFT JOIN Query Error:</strong> " . $e->getMessage() . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>❌ Error:</strong> " . $e->getMessage() . "</p>";
}

echo "<p><strong>Run this script and tell me exactly what you see!</strong></p>";
?>
