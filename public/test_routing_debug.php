<?php
// Simple routing debug test
echo "<h1>Routing Debug Test</h1>";

echo "<h2>Server Variables:</h2>";
echo "<pre>";
echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'NOT SET') . "\n";
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'NOT SET') . "\n";
echo "PATH_INFO: " . ($_SERVER['PATH_INFO'] ?? 'NOT SET') . "\n";
echo "ORIG_PATH_INFO: " . ($_SERVER['ORIG_PATH_INFO'] ?? 'NOT SET') . "\n";
echo "QUERY_STRING: " . ($_SERVER['QUERY_STRING'] ?? 'NOT SET') . "\n";
echo "</pre>";

echo "<h2>URL Processing Test:</h2>";
$url = $_SERVER['REQUEST_URI'] ?? '';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$basePath = dirname($scriptName);

echo "<p>Original URL: $url</p>";
echo "<p>Script Name: $scriptName</p>";
echo "<p>Base Path: $basePath</p>";

// Test the URL processing logic
if (strpos($url, '/projects/ip-tools/public/') === 0) {
    $processedUrl = str_replace('/projects/ip-tools/public/', '', $url);
    echo "<p>Processed URL (public): $processedUrl</p>";
} elseif (strpos($url, '/projects/ip-tools/') === 0) {
    $processedUrl = str_replace('/projects/ip-tools/', '', $url);
    echo "<p>Processed URL (root): $processedUrl</p>";
} elseif ($basePath !== '/' && $basePath !== '.') {
    $processedUrl = str_replace($basePath, '', $url);
    echo "<p>Processed URL (basePath): $processedUrl</p>";
} else {
    echo "<p>Processed URL (no change): $url</p>";
}

echo "<h2>Test Links:</h2>";
echo "<p><a href='/projects/ip-tools/public/auth/login'>Test: /projects/ip-tools/public/auth/login</a></p>";
echo "<p><a href='/projects/ip-tools/auth/login'>Test: /projects/ip-tools/auth/login</a></p>";
echo "<p><a href='/projects/ip-tools/public/'>Go to public index</a></p>";
echo "<p><a href='/projects/ip-tools/'>Go to root</a></p>";
?>
