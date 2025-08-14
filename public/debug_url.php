<?php
// Debug script to see the actual REQUEST_URI
echo "<h1>URL Debug Information</h1>";
echo "<h2>REQUEST_URI:</h2>";
echo "<pre>" . htmlspecialchars($_SERVER['REQUEST_URI'] ?? 'NOT SET') . "</pre>";

echo "<h2>SCRIPT_NAME:</h2>";
echo "<pre>" . htmlspecialchars($_SERVER['SCRIPT_NAME'] ?? 'NOT SET') . "</pre>";

echo "<h2>PHP_SELF:</h2>";
echo "<pre>" . htmlspecialchars($_SERVER['PHP_SELF'] ?? 'NOT SET') . "</pre>";

echo "<h2>DOCUMENT_ROOT:</h2>";
echo "<pre>" . htmlspecialchars($_SERVER['DOCUMENT_ROOT'] ?? 'NOT SET') . "</pre>";

echo "<h2>HTTP_HOST:</h2>";
echo "<pre>" . htmlspecialchars($_SERVER['HTTP_HOST'] ?? 'NOT SET') . "</pre>";

echo "<h2>HTTPS:</h2>";
echo "<pre>" . htmlspecialchars($_SERVER['HTTPS'] ?? 'NOT SET') . "</pre>";

echo "<h2>All SERVER variables:</h2>";
echo "<pre>";
foreach ($_SERVER as $key => $value) {
    if (strpos($key, 'HTTP_') === 0 || in_array($key, ['REQUEST_URI', 'SCRIPT_NAME', 'PHP_SELF', 'DOCUMENT_ROOT', 'HTTP_HOST', 'HTTPS'])) {
        echo htmlspecialchars($key) . ": " . htmlspecialchars($value) . "\n";
    }
}
echo "</pre>";
?>
