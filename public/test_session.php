<?php
echo "<h1>Session Test</h1>";
echo "<p>Testing session functionality...</p>";

// Test 1: Check session status
echo "<h2>Step 1: Check Session Status</h2>";
echo "<p>Session status: " . session_status() . "</p>";
echo "<p>Session ID: " . (session_id() ?: 'None') . "</p>";
echo "<p>Session name: " . (session_name() ?: 'Default') . "</p>";

// Test 2: Try to start session
echo "<h2>Step 2: Try to Start Session</h2>";
try {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        echo "<p>✓ Session started successfully</p>";
    } else {
        echo "<p>⚠ Session already active</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error starting session: " . $e->getMessage() . "</p>";
}

// Test 3: Check session after start
echo "<h2>Step 3: Check Session After Start</h2>";
echo "<p>Session status: " . session_status() . "</p>";
echo "<p>Session ID: " . (session_id() ?: 'None') . "</p>";

// Test 4: Try to set session variables
echo "<h2>Step 4: Test Session Variables</h2>";
try {
    $_SESSION['test_var'] = 'test_value_' . time();
    echo "<p>✓ Session variable set: " . $_SESSION['test_var'] . "</p>";
} catch (Exception $e) {
    echo "<p>✗ Error setting session variable: " . $e->getMessage() . "</p>";
}

// Test 5: Check session directory permissions
echo "<h2>Step 5: Check Session Directory</h2>";
$sessionPath = session_save_path();
echo "<p>Session save path: $sessionPath</p>";

if (is_dir($sessionPath)) {
    echo "<p>✓ Session directory exists</p>";
    echo "<p>Directory permissions: " . substr(sprintf('%o', fileperms($sessionPath)), -4) . "</p>";
    echo "<p>Directory writable: " . (is_writable($sessionPath) ? 'Yes' : 'No') . "</p>";
} else {
    echo "<p>✗ Session directory not found</p>";
}

// Test 6: Check session configuration
echo "<h2>Step 6: Session Configuration</h2>";
echo "<p>Session cookie lifetime: " . ini_get('session.cookie_lifetime') . "</p>";
echo "<p>Session garbage collection: " . ini_get('session.gc_maxlifetime') . "</p>";
echo "<p>Session use cookies: " . ini_get('session.use_cookies') . "</p>";
echo "<p>Session use only cookies: " . ini_get('session.use_only_cookies') . "</p>";

// Test 7: Test App session initialization
echo "<h2>Step 7: Test App Session Initialization</h2>";
try {
    require_once __DIR__ . '/../app/Config/App.php';
    echo "<p>✓ App.php loaded</p>";
    
    if (class_exists('App\Config\App')) {
        echo "<p>✓ App class exists</p>";
        
        // Try to call init() which handles sessions
        App\Config\App::init();
        echo "<p>✓ App::init() completed</p>";
        
        // Check if session was started
        echo "<p>Session status after App::init(): " . session_status() . "</p>";
        echo "<p>Session name after App::init(): " . session_name() . "</p>";
    } else {
        echo "<p>✗ App class not found</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error with App session: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
}

echo "<h2>Test Complete</h2>";
echo "<p>Check the steps above for any session-related issues.</p>";
echo "<p><a href='index.php'>Try Main Application</a></p>";
?>
