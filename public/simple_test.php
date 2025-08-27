<?php
echo "<h1>Simple PHP Test</h1>";
echo "<p>Testing basic PHP functionality...</p>";

// Test 1: Basic PHP
echo "<h2>Step 1: Basic PHP</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Current time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>✓ Basic PHP working</p>";

// Test 2: File system access
echo "<h2>Step 2: File System Access</h2>";
$currentDir = __DIR__;
echo "<p>Current directory: $currentDir</p>";
echo "<p>Parent directory: " . dirname($currentDir) . "</p>";
echo "<p>✓ File system access working</p>";

// Test 3: Check if app directory exists
echo "<h2>Step 3: Check App Directory</h2>";
$appDir = dirname($currentDir) . '/app';
if (is_dir($appDir)) {
    echo "<p>✓ App directory exists: $appDir</p>";
} else {
    echo "<p>✗ App directory not found: $appDir</p>";
}

// Test 4: Check specific files
echo "<h2>Step 4: Check Specific Files</h2>";
$files = [
    'app/Config/App.php',
    'app/Config/Database.php',
    'app/Core/Router.php',
    'app/Core/Controller.php',
    'app/Core/View.php'
];

foreach ($files as $file) {
    $fullPath = dirname($currentDir) . '/' . $file;
    if (file_exists($fullPath)) {
        echo "<p>✓ $file exists</p>";
    } else {
        echo "<p>✗ $file NOT FOUND</p>";
    }
}

// Test 5: Try to read a simple file
echo "<h2>Step 5: File Reading Test</h2>";
$testFile = dirname($currentDir) . '/app/Config/App.php';
if (file_exists($testFile)) {
    $content = file_get_contents($testFile);
    if ($content !== false) {
        echo "<p>✓ File reading working (read " . strlen($content) . " bytes)</p>";
    } else {
        echo "<p>✗ File reading failed</p>";
    }
} else {
    echo "<p>✗ Test file not found</p>";
}

// Test 6: Check .htaccess files
echo "<h2>Step 6: Check .htaccess Files</h2>";
$htaccessRoot = dirname($currentDir) . '/.htaccess';
$htaccessPublic = $currentDir . '/.htaccess';

if (file_exists($htaccessRoot)) {
    echo "<p>✓ Root .htaccess exists</p>";
    $content = file_get_contents($htaccessRoot);
    echo "<p>Root .htaccess content (first 200 chars):</p>";
    echo "<pre>" . htmlspecialchars(substr($content, 0, 200)) . "...</pre>";
}
else {
    echo "<p>✗ Root .htaccess not found</p>";
}

if (file_exists($htaccessPublic)) {
    echo "<p>✓ Public .htaccess exists</p>";
    $content = file_get_contents($htaccessPublic);
    echo "<p>Public .htaccess content (first 200 chars):</p>";
    echo "<pre>" . htmlspecialchars(substr($content, 0, 200)) . "...</pre>";
} else {
    echo "<p>✗ Public .htaccess not found</p>";
}

echo "<h2>Test Complete</h2>";
echo "<p>This shows basic PHP and file system functionality.</p>";
echo "<p><a href='index.php'>Try Main Application</a></p>";
?> 