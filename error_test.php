<?php
// Force error display
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

echo "<h1>Error Test</h1>";
echo "<p>This will show any PHP errors that occur.</p>";

// Test 1: Basic functionality
echo "<h2>Test 1: Basic PHP ✓</h2>";
echo "<p>PHP is working</p>";

// Test 2: Try to trigger an error
echo "<h2>Test 2: Error Triggering</h2>";
try {
    // This should trigger a notice
    $undefined_variable;
    echo "<p>✓ No errors triggered</p>";
} catch (Exception $e) {
    echo "<p>⚠ Exception caught: " . $e->getMessage() . "</p>";
}

// Test 3: Check error reporting settings
echo "<h2>Test 3: Error Reporting Settings</h2>";
echo "<p>Error reporting: " . error_reporting() . "</p>";
echo "<p>Display errors: " . ini_get('display_errors') . "</p>";
echo "<p>Display startup errors: " . ini_get('display_startup_errors') . "</p>";

// Test 4: Check memory and execution limits
echo "<h2>Test 4: Server Limits</h2>";
echo "<p>Memory limit: " . ini_get('memory_limit') . "</p>";
echo "<p>Max execution time: " . ini_get('max_execution_time') . "</p>";
echo "<p>Max input time: " . ini_get('max_input_time') . "</p>";
echo "<p>Post max size: " . ini_get('post_max_size') . "</p>";
echo "<p>Upload max filesize: " . ini_get('upload_max_filesize') . "</p>";

// Test 5: Check if we can create a simple class
echo "<h2>Test 5: Class Creation</h2>";
try {
    class SimpleTest {
        public function hello() {
            return "Hello World";
        }
    }
    
    $test = new SimpleTest();
    echo "<p>✓ Class created and instantiated: " . $test->hello() . "</p>";
} catch (Exception $e) {
    echo "<p>✗ Error creating class: " . $e->getMessage() . "</p>";
}

echo "<h2>Test Complete</h2>";
echo "<p>If you see this, basic PHP functionality is working.</p>";
?>
