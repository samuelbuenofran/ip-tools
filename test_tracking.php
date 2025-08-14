<?php
// Test tracking system
require_once('config.php');
$db = connectDB();

echo "<h1>Tracking System Test</h1>";

// Test 1: Check if config is loaded
echo "<h2>1. Configuration Test</h2>";
if (defined('SHOW_LOCATION_MESSAGES')) {
    echo "✅ SHOW_LOCATION_MESSAGES is defined: " . (SHOW_LOCATION_MESSAGES ? 'true' : 'false') . "<br>";
} else {
    echo "❌ SHOW_LOCATION_MESSAGES is NOT defined<br>";
}

// Test 2: Check database connection
echo "<h2>2. Database Connection Test</h2>";
try {
    if ($db->isConnected()) {
        echo "✅ Database connected successfully<br>";
    } else {
        echo "⚠️ Database connection status unclear<br>";
    }
} catch (Exception $e) {
    echo "❌ Database connection error: " . $e->getMessage() . "<br>";
}

// Test 3: Check geo_links table structure
echo "<h2>3. Database Table Structure Test</h2>";
try {
    $stmt = $db->query("DESCRIBE geo_links");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "✅ geo_links table columns:<br>";
    foreach ($columns as $column) {
        echo "&nbsp;&nbsp;• " . $column['Field'] . " (" . $column['Type'] . ")<br>";
    }
} catch (Exception $e) {
    echo "❌ Error checking geo_links table: " . $e->getMessage() . "<br>";
}

// Test 4: Check geo_logs table structure
echo "<h2>4. geo_logs Table Structure Test</h2>";
try {
    $stmt = $db->query("DESCRIBE geo_logs");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "✅ geo_logs table columns:<br>";
    foreach ($columns as $column) {
        echo "&nbsp;&nbsp;• " . $column['Field'] . " (" . $column['Type'] . ")<br>";
    }
} catch (Exception $e) {
    echo "❌ Error checking geo_logs table: " . $e->getMessage() . "<br>";
}

// Test 5: Check existing links
echo "<h2>5. Existing Links Test</h2>";
try {
    $stmt = $db->query("SELECT id, short_code, original_url FROM geo_links LIMIT 5");
    $links = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($links) > 0) {
        echo "✅ Found " . count($links) . " existing links:<br>";
        foreach ($links as $link) {
            echo "&nbsp;&nbsp;• Code: " . $link['short_code'] . " → " . $link['original_url'] . "<br>";
        }
    } else {
        echo "⚠️ No existing links found<br>";
    }
} catch (Exception $e) {
    echo "❌ Error checking existing links: " . $e->getMessage() . "<br>";
}

// Test 6: Test tracking link generation
echo "<h2>6. Tracking Link Test</h2>";
$test_code = "TEST123";
$test_url = "https://example.com";

echo "Test tracking link: <a href='geologger/precise_track.php?code=$test_code' target='_blank'>geologger/precise_track.php?code=$test_code</a><br>";
echo "This should redirect to: $test_url<br>";

echo "<hr>";
echo "<p><strong>Next steps:</strong></p>";
echo "<p>1. Run the database fix: <code>fix_database_simple.sql</code></p>";
echo "<p>2. Create a real tracking link from the geologger tool</p>";
echo "<p>3. Test the generated tracking link</p>";
echo "<p>4. Check the error logs for any tracking errors</p>";
?>
