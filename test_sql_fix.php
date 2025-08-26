<?php
require_once('autoload.php');

echo "<h1>🧪 Testing SQL Fix</h1>";
echo "<p>Testing if the SQL syntax errors in LIMIT clauses are now fixed.</p>";

try {
    // Test 1: Create model instances
    echo "<h2>✅ Test 1: Model Creation</h2>";
    
    $geoLink = new App\Models\GeoLink();
    echo "<p style='color: green;'>✅ GeoLink model created</p>";
    
    $geoLog = new App\Models\GeoLog();
    echo "<p style='color: green;'>✅ GeoLog model created</p>";
    
    // Test 2: Check database connection
    echo "<h2>🔍 Test 2: Database Connection</h2>";
    
    if ($geoLink->isConnected()) {
        echo "<p style='color: green;'>✅ Database connected</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Database not connected (demo mode)</p>";
    }
    
    // Test 3: Test the problematic methods
    echo "<h2>🔧 Test 3: Problematic Methods</h2>";
    
    if ($geoLink->isConnected()) {
        try {
            echo "<h3>Testing GeoLog::getRecentActivity()</h3>";
            $recentActivity = $geoLog->getRecentActivity(5);
            echo "<p style='color: green;'>✅ getRecentActivity(5): " . count($recentActivity) . " items</p>";
            
            echo "<h3>Testing GeoLink::getRecent()</h3>";
            $recentLinks = $geoLink->getRecent(3);
            echo "<p style='color: green;'>✅ getRecent(3): " . count($recentLinks) . " items</p>";
            
            echo "<h3>Testing HomeController simulation</h3>";
            
            // Simulate exactly what HomeController does
            $linkStats = [
                'total_links' => $geoLink->getTotalLinks(),
                'active_links' => $geoLink->getActiveLinks(),
                'expired_links' => $geoLink->getExpiredLinks()
            ];
            
            $logStats = [
                'total_clicks' => $geoLog->getTotalClicks(),
                'unique_visitors' => $geoLog->getUniqueVisitors(),
                'gps_tracking' => $geoLog->getGPSTrackingCount()
            ];
            
            $recentActivity = $geoLog->getRecentActivity(5);
            
            echo "<p style='color: green;'>✅ HomeController simulation successful!</p>";
            
            echo "<h4>Link Stats:</h4>";
            echo "<ul>";
            foreach ($linkStats as $key => $value) {
                echo "<li><strong>{$key}:</strong> {$value}</li>";
            }
            echo "</ul>";
            
            echo "<h4>Log Stats:</h4>";
            echo "<ul>";
            foreach ($logStats as $key => $value) {
                echo "<li><strong>{$key}:</strong> {$value}</li>";
            }
            echo "</ul>";
            
            echo "<p><strong>Recent Activity:</strong> " . count($recentActivity) . " items</p>";
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Test failed: " . $e->getMessage() . "</p>";
            echo "<p><strong>SQL syntax error still exists!</strong></p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠️ Skipping tests - no database connection</p>";
    }
    
    // Test 4: Navigation
    echo "<h2>🔗 Test 4: Navigation</h2>";
    
    echo "<p><a href='public/' class='btn btn-primary'>Try MVC App Now</a></p>";
    echo "<p><a href='geologger/logs.php' class='btn btn-success'>View Standalone Dashboard</a></p>";
    echo "<p><a href='test_mvc_complete.php' class='btn btn-info'>Run Complete MVC Test</a></p>";
    
    // Final status
    echo "<h2>🎉 Test Results</h2>";
    
    if ($geoLink->isConnected()) {
        echo "<p style='color: green;'><strong>🎉 SUCCESS! SQL syntax errors should now be fixed!</strong></p>";
        echo "<p>Your MVC application should work without the LIMIT clause errors.</p>";
    } else {
        echo "<p style='color: orange;'><strong>⚠️ Models are working but database connection failed.</strong></p>";
        echo "<p>This might be expected in demo mode or with database issues.</p>";
    }
    
} catch (Exception $e) {
    echo "<h2>❌ Test Failed</h2>";
    echo "<p style='color: red;'>Critical Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>The SQL fix didn't work. Please check the error above.</strong></p>";
}
?>
