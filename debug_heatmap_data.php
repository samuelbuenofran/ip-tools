<?php
require_once('config.php');
$db = connectDB();

echo "<h2>Heatmap Data Debug</h2>";

// Check the raw data from geo_logs
echo "<h3>Raw geo_logs data with coordinates:</h3>";
$stmt = $db->query("
    SELECT id, latitude, longitude, accuracy, city, country, location_type, timestamp
    FROM geo_logs 
    WHERE latitude IS NOT NULL AND longitude IS NOT NULL 
    AND latitude != 0 AND longitude != 0
    LIMIT 10
");
$rawData = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($rawData);
echo "</pre>";

// Check the transformed data (what the model returns)
echo "<h3>Transformed heatmap data (lat/lng format):</h3>";
$stmt = $db->query("
    SELECT 
        latitude as lat, 
        longitude as lng, 
        accuracy, 
        city, 
        country 
    FROM geo_logs 
    WHERE latitude IS NOT NULL AND longitude IS NOT NULL 
    AND latitude != 0 AND longitude != 0
    LIMIT 10
");
$transformedData = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($transformedData);
echo "</pre>";

// Check JSON encoding
echo "<h3>JSON encoded data:</h3>";
$jsonData = json_encode($transformedData, JSON_NUMERIC_CHECK);
echo "<pre>" . htmlspecialchars($jsonData) . "</pre>";

// Check for any invalid coordinates
echo "<h3>Invalid coordinates check:</h3>";
$stmt = $db->query("
    SELECT id, latitude, longitude, city, country
    FROM geo_logs 
    WHERE (latitude IS NULL OR longitude IS NULL) 
    OR latitude = 0 OR longitude = 0
    OR latitude = '' OR longitude = ''
    LIMIT 10
");
$invalidData = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($invalidData);
echo "</pre>";

// Count total records
$stmt = $db->query("SELECT COUNT(*) as total FROM geo_logs");
$total = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $db->query("SELECT COUNT(*) as with_coords FROM geo_logs WHERE latitude IS NOT NULL AND longitude IS NOT NULL AND latitude != 0 AND longitude != 0");
$withCoords = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h3>Summary:</h3>";
echo "<p>Total geo_logs records: " . $total['total'] . "</p>";
echo "<p>Records with valid coordinates: " . $withCoords['with_coords'] . "</p>";
?>
