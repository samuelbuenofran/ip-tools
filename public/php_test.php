<?php
echo "<h1>PHP Test</h1>";
echo "<p>✅ PHP is working!</p>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";

// Test PDO
if (extension_loaded('pdo')) {
    echo "<p>✅ PDO extension is loaded</p>";
} else {
    echo "<p>❌ PDO extension is NOT loaded</p>";
}

if (extension_loaded('pdo_mysql')) {
    echo "<p>✅ PDO MySQL extension is loaded</p>";
} else {
    echo "<p>❌ PDO MySQL extension is NOT loaded</p>";
}

// Test basic PDO connection
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=techeletric_ip_tools',
        'techeletric_ip_tools',
        'zsP2rDZDaTea2YEhegmH',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $e->getMessage() . "</p>";
}
?> 