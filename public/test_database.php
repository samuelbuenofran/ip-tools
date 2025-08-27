<?php
echo "<h1>Database Connection Test</h1>";
echo "<p>Testing database connectivity...</p>";

// Test 1: Load Database class
echo "<h2>Step 1: Load Database Class</h2>";
try {
    require_once __DIR__ . '/../app/Config/Database.php';
    echo "<p>✓ Database.php loaded</p>";
} catch (Exception $e) {
    echo "<p>✗ Error loading Database: " . $e->getMessage() . "</p>";
    exit;
}

// Test 2: Check if class exists
echo "<h2>Step 2: Check Class Existence</h2>";
if (class_exists('App\Config\Database')) {
    echo "<p>✓ Database class exists</p>";
} else {
    echo "<p>✗ Database class not found</p>";
    exit;
}

// Test 3: Create Database instance
echo "<h2>Step 3: Create Database Instance</h2>";
try {
    $db = App\Config\Database::getInstance();
    echo "<p>✓ Database instance created</p>";
} catch (Exception $e) {
    echo "<p>✗ Error creating database instance: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    exit;
}

// Test 4: Check connection status
echo "<h2>Step 4: Check Connection Status</h2>";
try {
    if ($db->isConnected()) {
        echo "<p>✓ Database connected</p>";
    } else {
        echo "<p>⚠ Database not connected (running in demo mode)</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error checking connection: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    exit;
}

// Test 5: Try a simple query (if connected)
echo "<h2>Step 5: Test Simple Query</h2>";
if ($db->isConnected()) {
    try {
        $stmt = $db->query("SELECT 1 as test");
        $result = $stmt->fetch();
        echo "<p>✓ Simple query successful: " . $result['test'] . "</p>";
    } catch (Exception $e) {
        echo "<p>✗ Error executing query: " . $e->getMessage() . "</p>";
        echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    }
} else {
    echo "<p>⚠ Skipping query test (not connected)</p>";
}

// Test 6: Check memory usage
echo "<h2>Step 6: Memory Usage</h2>";
echo "<p>Current memory: " . round(memory_get_usage(true) / 1024 / 1024, 2) . " MB</p>";
echo "<p>Peak memory: " . round(memory_get_peak_usage(true) / 1024 / 1024, 2) . " MB</p>";

echo "<h2>Test Complete</h2>";
echo "<p>If all steps show ✓, the database connection is working.</p>";
echo "<p><a href='index.php'>Try Main Application</a></p>";
?>
