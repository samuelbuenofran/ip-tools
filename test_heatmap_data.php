<?php
require_once('config.php');

echo "<h1>🔍 Heatmap Data Test</h1>";

try {
    $db = connectDB();
    echo "✅ Database connection successful<br><br>";
    
    // Check current data
    echo "<h2>Current Database Status:</h2>";
    
    // Count tracking links
    $stmt = $db->query("SELECT COUNT(*) as count FROM geo_links");
    $links_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "📊 Total tracking links: <strong>$links_count</strong><br>";
    
    // Count log entries
    $stmt = $db->query("SELECT COUNT(*) as count FROM geo_logs");
    $logs_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "📊 Total log entries: <strong>$logs_count</strong><br>";
    
    // Count entries with coordinates
    $stmt = $db->query("SELECT COUNT(*) as count FROM geo_logs WHERE latitude IS NOT NULL AND longitude IS NOT NULL");
    $coord_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "📍 Logs with coordinates: <strong>$coord_count</strong><br>";
    
    // Test the exact heatmap query
    echo "<h2>Testing Heatmap Query:</h2>";
    
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
        
        // Check for valid coordinates
        $valid_coords = 0;
        $sample_coords = [];
        foreach ($test_logs as $log) {
            if (!empty($log['latitude']) && !empty($log['longitude']) && 
                is_numeric($log['latitude']) && is_numeric($log['longitude'])) {
                $valid_coords++;
                if (count($sample_coords) < 3) {
                    $sample_coords[] = [
                        'lat' => (float)$log['latitude'],
                        'lng' => (float)$log['longitude'],
                        'city' => $log['city'] ?? 'Unknown',
                        'country' => $log['country'] ?? 'Unknown'
                    ];
                }
            }
        }
        echo "📍 Valid coordinates found: <strong>$valid_coords</strong><br>";
        
        if ($valid_coords > 0) {
            echo "<h3>Sample Coordinates:</h3>";
            echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
            echo "<tr><th>Latitude</th><th>Longitude</th><th>City</th><th>Country</th></tr>";
            foreach ($sample_coords as $coord) {
                echo "<tr>";
                echo "<td>{$coord['lat']}</td>";
                echo "<td>{$coord['lng']}</td>";
                echo "<td>{$coord['city']}</td>";
                echo "<td>{$coord['country']}</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 15px 0;'>";
            echo "🎉 <strong>Great news!</strong> You have $valid_coords coordinate points for your heatmap.";
            echo "</div>";
        } else {
            echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 15px 0;'>";
            echo "⚠️ <strong>No coordinates found.</strong> This means your heatmap won't show any data.";
            echo "</div>";
        }
        
    } catch (Exception $e) {
        echo "❌ Heatmap query failed: " . $e->getMessage() . "<br>";
    }
    
    // Check if we need to create test data
    if ($valid_coords == 0 && $links_count > 0) {
        echo "<h2>🔧 Creating Test Data:</h2>";
        echo "<p>Since you have tracking links but no coordinates, let's create some test data:</p>";
        
        // Get a sample link
        $stmt = $db->query("SELECT id, short_code FROM geo_links LIMIT 1");
        $link = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($link) {
            echo "<p>Found tracking link: <strong>{$link['short_code']}</strong></p>";
            echo "<p>To generate heatmap data:</p>";
            echo "<ol>";
            echo "<li>Go to: <a href='https://keizai-tech.com/projects/ip-tools/geologger/create.php'>Create Tracking Link</a></li>";
            echo "<li>Create a new link or use an existing one</li>";
            echo "<li>Click the tracking URL to generate coordinate data</li>";
            echo "<li>Return to <a href='https://keizai-tech.com/projects/ip-tools/geologger/logs.php'>View Logs</a> to see the heatmap</li>";
            echo "</ol>";
        }
    }
    
} catch (Exception $e) {
    echo "<h2>❌ Error</h2>";
    echo "<p>Test failed: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>🔧 Quick Actions</h2>";
echo "<p><a href='https://keizai-tech.com/projects/ip-tools/geologger/logs.php'>View Logs & Heatmap</a> | <a href='https://keizai-tech.com/projects/ip-tools/geologger/create.php'>Create Tracking Link</a></p>";
?>
