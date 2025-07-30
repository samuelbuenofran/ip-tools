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
if (!isset($data['link_id'], $data['ip_address'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

$db = connectDB();

// Geolocation API (fallback to IP-based)
$geo = @json_decode(@file_get_contents("https://ipwho.is/{$data['ip_address']}"), true);

// Insert log
$insertStmt = $db->prepare("
  INSERT INTO geo_logs (
    ip_address, user_agent, referrer, country, city, 
    latitude, longitude, link_id, device_type, timestamp,
    location_source
  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'ip')
");

$insertStmt->execute([
    $data['ip_address'],
    $data['user_agent'] ?? null,
    $data['referrer'] ?? null,
    $geo['country'] ?? null,
    $geo['city'] ?? null,
    $geo['latitude'] ?? null,
    $geo['longitude'] ?? null,
    $data['link_id'],
    $data['device_type'] ?? null
]);

// Write debug log
$logPath = __DIR__ . '/geo_debug.log';
file_put_contents($logPath, json_encode([
    'type' => 'ip-fallback',
    'ip' => $data['ip_address'],
    'lat' => $geo['latitude'] ?? 'null',
    'lon' => $geo['longitude'] ?? 'null',
    'status' => $geo['success'] ?? 'unknown'
]) . PHP_EOL, FILE_APPEND);

// Return success
echo json_encode(['success' => true, 'message' => 'IP location saved']);