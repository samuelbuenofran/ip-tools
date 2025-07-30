<?php
require_once('../config.php');

// Only accept POST requests with JSON content
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get JSON data from request body
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validate required fields
if (!isset($data['link_id'], $data['latitude'], $data['longitude'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

$db = connectDB();

// Get country and city using reverse geocoding (optional)
$country = null;
$city = null;

// Try to get country/city info from coordinates using a free service
$geo_url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$data['latitude']}&lon={$data['longitude']}&zoom=18&addressdetails=1";
$geo_opts = [
    'http' => [
        'method' => 'GET',
        'header' => "User-Agent: IP-Tools-Geolocation/1.0\r\n"
    ]
];

$geo_context = stream_context_create($geo_opts);
$geo_data = @file_get_contents($geo_url, false, $geo_context);

if ($geo_data) {
    $geo_json = json_decode($geo_data, true);
    if (isset($geo_json['address'])) {
        $country = $geo_json['address']['country'] ?? null;
        $city = $geo_json['address']['city'] ?? $geo_json['address']['town'] ?? $geo_json['address']['village'] ?? null;
    }
}

// Insert log with precise coordinates
$insertStmt = $db->prepare("
  INSERT INTO geo_logs (
    ip_address, user_agent, referrer, country, city, 
    latitude, longitude, link_id, device_type, timestamp, 
    accuracy, location_source
  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, 'precise')
");

$insertStmt->execute([
    $data['ip_address'] ?? null,
    $data['user_agent'] ?? null,
    $data['referrer'] ?? null,
    $country,
    $city,
    $data['latitude'],
    $data['longitude'],
    $data['link_id'],
    $data['device_type'] ?? null,
    $data['accuracy'] ?? null
]);

// Write debug log
$logPath = __DIR__ . '/geo_debug.log';
file_put_contents($logPath, json_encode([
    'type' => 'precise',
    'ip' => $data['ip_address'] ?? 'unknown',
    'lat' => $data['latitude'],
    'lon' => $data['longitude'],
    'accuracy' => $data['accuracy'] ?? 'unknown',
    'timestamp' => date('Y-m-d H:i:s')
]) . PHP_EOL, FILE_APPEND);

// Return success
echo json_encode(['success' => true, 'message' => 'Location saved']);