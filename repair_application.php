<?php
require_once('config.php');

echo "<h1>🔧 Application Repair Script</h1>";
echo "<p>This script will repair any issues caused by Cursor corruption and restore your application to working order.</p>";

try {
    $db = connectDB();
    
    // Step 1: Check database connection
    echo "<h2>✅ Step 1: Database Connection</h2>";
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
    
    // Step 2: Check table structure
    echo "<h2>🔍 Step 2: Database Table Structure</h2>";
    
    $tables = ['geo_links', 'geo_logs', 'users', 'speed_tests', 'phone_tracking'];
    $tableStatus = [];
    
    foreach ($tables as $table) {
        try {
            $stmt = $db->query("SHOW TABLES LIKE '$table'");
            if ($stmt->rowCount() > 0) {
                $tableStatus[$table] = 'EXISTS';
                echo "<p>✅ Table '$table' exists</p>";
            } else {
                $tableStatus[$table] = 'MISSING';
                echo "<p style='color: red;'>❌ Table '$table' is missing</p>";
            }
        } catch (Exception $e) {
            $tableStatus[$table] = 'ERROR';
            echo "<p style='color: red;'>❌ Error checking table '$table': " . $e->getMessage() . "</p>";
        }
    }
    
    // Step 3: Fix click counts
    echo "<h2>🔧 Step 3: Fix Click Counts</h2>";
    
    if ($tableStatus['geo_links'] === 'EXISTS' && $tableStatus['geo_logs'] === 'EXISTS') {
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
            echo "<p style='color: green;'><strong>All click counts are correct!</strong></p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠️ Skipping click count fix - required tables missing</p>";
    }
    
    // Step 4: Clean orphaned data
    echo "<h2>🧹 Step 4: Clean Orphaned Data</h2>";
    
    if ($tableStatus['geo_logs'] === 'EXISTS' && $tableStatus['geo_links'] === 'EXISTS') {
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
    }
    
    // Step 5: Check file integrity
    echo "<h2>📁 Step 5: Check File Integrity</h2>";
    
    $criticalFiles = [
        'config.php',
        'geologger/track.php',
        'geologger/logs.php',
        'geologger/create.php',
        'header.php',
        'footer.php'
    ];
    
    $fileIssues = 0;
    foreach ($criticalFiles as $file) {
        if (file_exists($file)) {
            $content = file_get_contents($file);
            if (strlen($content) < 100) { // File too small, probably corrupted
                echo "<p style='color: red;'>❌ File '$file' appears corrupted (too small)</p>";
                $fileIssues++;
            } else {
                echo "<p style='color: green;'>✅ File '$file' appears intact</p>";
            }
        } else {
            echo "<p style='color: red;'>❌ File '$file' is missing</p>";
            $fileIssues++;
        }
    }
    
    if ($fileIssues === 0) {
        echo "<p style='color: green;'><strong>All critical files are intact!</strong></p>";
    } else {
        echo "<p style='color: orange;'><strong>Found {$fileIssues} file issue(s) that need attention</strong></p>";
    }
    
    // Step 6: Final status
    echo "<h2>📊 Final Status Report</h2>";
    
    if ($tableStatus['geo_links'] === 'EXISTS') {
        $stmt = $db->query("SELECT COUNT(*) as count FROM geo_links");
        $totalLinks = $stmt->fetch()['count'];
        
        $stmt = $db->query("SELECT SUM(click_count) as total FROM geo_links");
        $totalClicks = $stmt->fetch()['total'] ?? 0;
        
        echo "<p><strong>Total Tracking Links:</strong> {$totalLinks}</p>";
        echo "<p><strong>Total Clicks (Fixed):</strong> {$totalClicks}</p>";
    }
    
    if ($tableStatus['geo_logs'] === 'EXISTS') {
        $stmt = $db->query("SELECT COUNT(*) as count FROM geo_logs");
        $totalLogs = $stmt->fetch()['count'];
        echo "<p><strong>Total Log Entries:</strong> {$totalLogs}</p>";
    }
    
    // Step 7: Navigation and next steps
    echo "<h2>🔗 Next Steps</h2>";
    
    if ($fileIssues === 0 && !in_array('MISSING', $tableStatus)) {
        echo "<p style='color: green;'><strong>🎉 Your application has been repaired and is ready to use!</strong></p>";
        echo "<p><a href='geologger/logs.php' class='btn btn-success'>View Dashboard</a></p>";
        echo "<p><a href='geologger/create.php' class='btn btn-primary'>Create Tracking Link</a></p>";
    } else {
        echo "<p style='color: orange;'><strong>⚠️ Some issues remain. Please review the report above.</strong></p>";
    }
    
    echo "<p><a href='check_links_vs_logs.php' class='btn btn-info'>Check Links vs Logs</a></p>";
    echo "<p><a href='cleanup_demo_data.php' class='btn btn-warning'>Cleanup Demo Data</a></p>";
    
} catch (Exception $e) {
    echo "<h2>❌ Critical Error</h2>";
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>Your application has a critical issue that needs immediate attention.</strong></p>";
    echo "<p>Please check:</p>";
    echo "<ul>";
    echo "<li>Database connection settings in config.php</li>";
    echo "<li>Database server status</li>";
    echo "<li>File permissions</li>";
    echo "</ul>";
}
?>
