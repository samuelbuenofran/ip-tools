<?php
// Test logo accessibility
echo "<h1>Logo Test</h1>";
echo "<p>Testing if the logo is accessible:</p>";

$logoPath = "assets/iptoolssuite-logo.png";
if (file_exists($logoPath)) {
    echo "<p>✅ Logo file exists at: $logoPath</p>";
    echo "<img src='$logoPath' alt='IP Tools Suite Logo' height='100'>";
} else {
    echo "<p>❌ Logo file not found at: $logoPath</p>";
}

echo "<p>Current directory: " . getcwd() . "</p>";
echo "<p>Absolute logo path: " . realpath($logoPath) . "</p>";
?> 