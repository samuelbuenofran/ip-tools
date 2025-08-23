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
    
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>Error:</strong> " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h3>🧪 Next Steps:</h3>";
echo "<p>1. <strong>If you see coordinates in the sample data:</strong> The issue is in the heatmap display code</p>";
echo "<p>2. <strong>If you see NO coordinates:</strong> The issue is in the tracking/insertion code</p>";
echo "<p>3. <strong>If you see errors:</strong> There's a database connection or permission issue</p>";
echo "<p><strong>Run this script and tell me what you see!</strong></p>";
?>
