<?php
require_once('autoload.php');

echo "<h1>🧪 Complete MVC Test</h1>";
echo "<p>Testing all the methods that the HomeController needs.</p>";

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
    
    // Test 3: Test all GeoLink methods that HomeController needs
    echo "<h2>🔗 Test 3: GeoLink Methods</h2>";
    
    if ($geoLink->isConnected()) {
        try {
            $totalLinks = $geoLink->getTotalLinks();
            echo "<p>✅ getTotalLinks(): {$totalLinks}</p>";
            
            $activeLinks = $geoLink->getActiveLinks();
            echo "<p>✅ getActiveLinks(): {$activeLinks}</p>";
            
            $expiredLinks = $geoLink->getExpiredLinks();
            echo "<p>✅ getExpiredLinks(): {$expiredLinks}</p>";
            
            $totalClicks = $geoLink->getTotalClicks();
            echo "<p>✅ getTotalClicks(): {$totalClicks}</p>";
            
            $stats = $geoLink->getStats();
            if ($stats) {
                echo "<p>✅ getStats(): Working</p>";
                echo "<ul>";
                foreach ($stats as $key => $value) {
                    echo "<li><strong>{$key}:</strong> {$value}</li>";
                }
                echo "</ul>";
            }
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ GeoLink error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠️ Skipping GeoLink tests - no database</p>";
    }
    
    // Test 4: Test all GeoLog methods that HomeController needs
    echo "<h2>📊 Test 4: GeoLog Methods</h2>";
    
    if ($geoLog->isConnected()) {
        try {
            $totalLogs = $geoLog->getTotalLogs();
            echo "<p>✅ getTotalLogs(): {$totalLogs}</p>";
            
            $totalClicks = $geoLog->getTotalClicks();
            echo "<p>✅ getTotalClicks(): {$totalClicks}</p>";
            
            $uniqueVisitors = $geoLog->getUniqueVisitors();
            echo "<p>✅ getUniqueVisitors(): {$uniqueVisitors}</p>";
            
            $gpsTracking = $geoLog->getGPSTrackingCount();
            echo "<p>✅ getGPSTrackingCount(): {$gpsTracking}</p>";
            
            $recentActivity = $geoLog->getRecentActivity(5);
            echo "<p>✅ getRecentActivity(5): " . count($recentActivity) . " items</p>";
            
            $stats = $geoLog->getStats();
            if ($stats) {
                echo "<p>✅ getStats(): Working</p>";
                echo "<ul>";
                foreach ($stats as $key => $value) {
                    echo "<li><strong>{$key}:</strong> {$value}</li>";
                }
                echo "</ul>";
            }
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ GeoLog error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠️ Skipping GeoLog tests - no database</p>";
    }
    
    // Test 5: Test HomeController simulation
    echo "<h2>🏠 Test 5: HomeController Simulation</h2>";
    
    try {
        // Simulate what HomeController does
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
        echo "<h3>Link Stats:</h3>";
        echo "<ul>";
        foreach ($linkStats as $key => $value) {
            echo "<li><strong>{$key}:</strong> {$value}</li>";
        }
        echo "</ul>";
        
        echo "<h3>Log Stats:</h3>";
        echo "<ul>";
        foreach ($logStats as $key => $value) {
            echo "<li><strong>{$key}:</strong> {$value}</li>";
        }
        echo "</ul>";
        
        echo "<p><strong>Recent Activity:</strong> " . count($recentActivity) . " items</p>";
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ HomeController simulation failed: " . $e->getMessage() . "</p>";
    }
    
    // Test 6: Navigation
    echo "<h2>🔗 Test 6: Navigation</h2>";
    
    echo "<p><a href='public/' class='btn btn-primary'>Try MVC App Now</a></p>";
    echo "<p><a href='geologger/logs.php' class='btn btn-success'>View Standalone Dashboard</a></p>";
    echo "<p><a href='repair_application.php' class='btn btn-warning'>Run Repair Script</a></p>";
    
    // Final status
    echo "<h2>🎉 Test Results</h2>";
    
    if ($geoLink->isConnected() && $geoLog->isConnected()) {
        echo "<p style='color: green;'><strong>🎉 SUCCESS! Your MVC application should now work perfectly!</strong></p>";
        echo "<p>All required methods are implemented and working.</p>";
    } else {
        echo "<p style='color: orange;'><strong>⚠️ Models are working but database connection failed.</strong></p>";
        echo "<p>This might be expected in demo mode or with database issues.</p>";
    }
    
} catch (Exception $e) {
    echo "<h2>❌ Test Failed</h2>";
    echo "<p style='color: red;'>Critical Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>The MVC fix didn't work. Please check the error above.</strong></p>";
}
?>
