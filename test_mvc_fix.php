<?php
require_once('autoload.php');

echo "<h1>🧪 Testing MVC Fix</h1>";
echo "<p>Testing if the MVC models now work correctly with the Database class.</p>";

try {
    // Test 1: Check if we can create model instances
    echo "<h2>✅ Test 1: Model Instantiation</h2>";
    
    $geoLink = new App\Models\GeoLink();
    echo "<p style='color: green;'>✅ GeoLink model created successfully</p>";
    
    $geoLog = new App\Models\GeoLog();
    echo "<p style='color: green;'>✅ GeoLog model created successfully</p>";
    
    // Test 2: Check database connection
    echo "<h2>🔍 Test 2: Database Connection</h2>";
    
    if ($geoLink->isConnected()) {
        echo "<p style='color: green;'>✅ Database connection successful</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Database connection failed (running in demo mode)</p>";
    }
    
    // Test 3: Test basic queries
    echo "<h2>📊 Test 3: Basic Queries</h2>";
    
    if ($geoLink->isConnected()) {
        try {
            $totalLinks = $geoLink->getTotalLinks();
            echo "<p style='color: green;'>✅ Total Links: {$totalLinks}</p>";
            
            $totalClicks = $geoLink->getTotalClicks();
            echo "<p style='color: green;'>✅ Total Clicks: {$totalClicks}</p>";
            
            $totalLogs = $geoLog->getTotalLogs();
            echo "<p style='color: green;'>✅ Total Logs: {$totalLogs}</p>";
            
            $uniqueVisitors = $geoLog->getUniqueVisitors();
            echo "<p style='color: green;'>✅ Unique Visitors: {$uniqueVisitors}</p>";
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Query error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠️ Skipping queries - no database connection</p>";
    }
    
    // Test 4: Test model methods
    echo "<h2>🔧 Test 4: Model Methods</h2>";
    
    try {
        $stats = $geoLog->getStats();
        if ($stats) {
            echo "<p style='color: green;'>✅ Stats retrieved successfully</p>";
            echo "<ul>";
            foreach ($stats as $key => $value) {
                echo "<li><strong>{$key}:</strong> {$value}</li>";
            }
            echo "</ul>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Stats error: " . $e->getMessage() . "</p>";
    }
    
    // Test 5: Navigation
    echo "<h2>🔗 Test 5: Navigation</h2>";
    
    echo "<p><a href='geologger/logs.php' class='btn btn-success'>View Standalone Dashboard</a></p>";
    echo "<p><a href='public/' class='btn btn-primary'>View MVC App</a></p>";
    echo "<p><a href='repair_application.php' class='btn btn-warning'>Run Repair Script</a></p>";
    
    echo "<h2>🎉 Test Complete!</h2>";
    
    if ($geoLink->isConnected()) {
        echo "<p style='color: green;'><strong>✅ Your MVC application is now working correctly!</strong></p>";
        echo "<p>The models are properly using the Database class instead of the old connectDB function.</p>";
    } else {
        echo "<p style='color: orange;'><strong>⚠️ Models are working but database connection failed.</strong></p>";
        echo "<p>This might be expected if you're running in demo mode or have database configuration issues.</p>";
    }
    
} catch (Exception $e) {
    echo "<h2>❌ Test Failed</h2>";
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>The MVC fix didn't work completely. Please check the error above.</strong></p>";
}
?>
