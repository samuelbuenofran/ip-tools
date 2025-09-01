<?php
// Simple debug script to test URL generation
require_once __DIR__ . '/../app/Config/App.php';
require_once __DIR__ . '/../app/Models/GeoLink.php';

use App\Config\App;
use App\Models\GeoLink;

echo "<h1>URL Generation Debug</h1>";

echo "<h2>App::getBaseUrl()</h2>";
echo "Base URL: " . App::getBaseUrl() . "<br>";

echo "<h2>GeoLink URL Generation</h2>";
$geoLink = new GeoLink();
$testCode = 'TEST123';
$trackingUrl = $geoLink->getTrackingUrl($testCode);
echo "Generated tracking URL: " . $trackingUrl . "<br>";

echo "<h2>Expected vs Actual</h2>";
echo "Expected: " . App::getBaseUrl() . "/geologger/precise_track?code=" . $testCode . "<br>";
echo "Actual: " . $trackingUrl . "<br>";

if ($trackingUrl === App::getBaseUrl() . "/geologger/precise_track?code=" . $testCode) {
    echo "<span style='color: green;'>✓ URL generation is correct!</span><br>";
} else {
    echo "<span style='color: red;'>✗ URL generation is incorrect!</span><br>";
}

echo "<h2>Test the actual tracking link</h2>";
echo "<a href='" . $trackingUrl . "' target='_blank'>Click here to test the tracking link</a><br>";
echo "<p>This should show the location tracking page and then redirect to a test URL.</p>";
?>
