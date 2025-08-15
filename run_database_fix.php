<?php
require_once('config.php');

echo "<h1>🔧 Database Fix for Heatmap</h1>";
echo "<p>This will fix the missing columns that prevent your heatmap from working.</p>";

try {
    $db = connectDB();
    echo "✅ Database connection successful<br><br>";
    
    // Read and execute the SQL fix
    $sql_file = 'fix_heatmap_database.sql';
    if (file_exists($sql_file)) {
        $sql_content = file_get_contents($sql_file);
        
        // Split into individual statements
        $statements = array_filter(array_map('trim', explode(';', $sql_content)));
        
        echo "<h2>Executing Database Fixes:</h2>";
        
        foreach ($statements as $statement) {
            if (empty($statement) || strpos($statement, '--') === 0) {
                continue; // Skip comments and empty lines
            }
            
            try {
                if (strpos($statement, 'SELECT') === 0) {
                    // Handle SELECT statements specially
                    $stmt = $db->query($statement);
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    echo "<h3>Status Report:</h3>";
                    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
                    echo "<tr><th>Table</th><th>Total Records</th><th>Records with Data</th></tr>";
                    foreach ($results as $row) {
                        echo "<tr>";
                        echo "<td>{$row['table_name']}</td>";
                        echo "<td>{$row['total_records']}</td>";
                        echo "<td>" . ($row['records_with_clicks'] ?? $row['records_with_coordinates']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    // Execute other statements
                    $db->exec($statement);
                    echo "✅ Executed: " . substr($statement, 0, 50) . "...<br>";
                }
            } catch (Exception $e) {
                // Some statements might fail if columns already exist - that's okay
                if (strpos($e->getMessage(), 'Duplicate column name') !== false || 
                    strpos($e->getMessage(), 'Duplicate key name') !== false) {
                    echo "ℹ️ Column/Index already exists (this is fine)<br>";
                } else {
                    echo "⚠️ Statement failed: " . $e->getMessage() . "<br>";
                }
            }
        }
        
        echo "<br><h2>✅ Database Fix Complete!</h2>";
        
        // Test the heatmap query
        echo "<h3>Testing Heatmap Query:</h3>";
        try {
            $stmt = $db->query("
              SELECT g.id, g.ip_address, g.user_agent, g.referrer, g.country, g.city,
                     g.device_type, g.timestamp, g.latitude, g.longitude, g.accuracy,
                     l.short_code, l.original_url
              FROM geo_logs g
              JOIN geo_links l ON g.link_id = l.id
              ORDER BY g.timestamp DESC
            ");
            $test_logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "✅ Heatmap query successful: <strong>" . count($test_logs) . "</strong> results<br>";
            
            // Check for coordinates
            $valid_coords = 0;
            foreach ($test_logs as $log) {
                if (!empty($log['latitude']) && !empty($log['longitude']) && 
                    is_numeric($log['latitude']) && is_numeric($log['longitude'])) {
                    $valid_coords++;
                }
            }
            echo "📍 Valid coordinates found: <strong>$valid_coords</strong><br>";
            
            if ($valid_coords > 0) {
                echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 15px 0;'>";
                echo "🎉 <strong>Success!</strong> Your heatmap should now work with $valid_coords location points.";
                echo "</div>";
            } else {
                echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 15px 0;'>";
                echo "⚠️ <strong>No coordinates found.</strong> You need to create tracking links and click them to generate heatmap data.";
                echo "</div>";
            }
            
        } catch (Exception $e) {
            echo "❌ Heatmap query failed: " . $e->getMessage() . "<br>";
        }
        
    } else {
        echo "❌ SQL fix file not found: $sql_file<br>";
    }
    
} catch (Exception $e) {
    echo "<h2>❌ Error</h2>";
    echo "<p>Database fix failed: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>🔧 Next Steps</h2>";
echo "<ol>";
echo "<li><strong>Test your heatmap:</strong> <a href='geologger/logs.php'>View Logs</a></li>";
echo "<li><strong>Create tracking data:</strong> <a href='geologger/create.php'>Create Link</a></li>";
echo "<li><strong>If still no data:</strong> Create a tracking link and click it to generate coordinates</li>";
echo "</ol>";
?>
