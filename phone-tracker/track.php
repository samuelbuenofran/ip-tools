<?php
require_once('../config.php');
$db = connectDB();

// Get tracking code from URL
$code = $_GET['code'] ?? '';

if (empty($code)) {
    die('Invalid tracking code');
}

// Get tracking information from database
$stmt = $db->prepare("SELECT * FROM phone_tracking WHERE tracking_code = ?");
$stmt->execute([$code]);
$tracking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tracking) {
    die('Tracking link not found');
}

// Get user information
$ip_address = $_SERVER['HTTP_CLIENT_IP'] 
    ?? $_SERVER['HTTP_X_FORWARDED_FOR'] 
    ?? $_SERVER['REMOTE_ADDR'] 
    ?? 'UNKNOWN';

$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$referrer = $_SERVER['HTTP_REFERER'] ?? '';
$device_type = preg_match('/mobile/i', $user_agent) ? 'Mobile' : 'Desktop';

// Get geolocation data
$geo_data = null;
try {
    $geo_url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$latitude}&lon={$longitude}&zoom=18&addressdetails=1";
    $geo_response = @file_get_contents($geo_url);
    
    if ($geo_response) {
        $geo_data = json_decode($geo_response, true);
    }
} catch (Exception $e) {
    // Continue without geocoding data
}

// Extract location details
$country = $geo_data['address']['country'] ?? 'Unknown';
$city = $geo_data['address']['city'] ?? $geo_data['address']['town'] ?? 'Unknown';

// Record the click
$stmt = $db->prepare("
    INSERT INTO phone_clicks (
        tracking_code, ip_address, user_agent, referrer, 
        country, city, device_type, timestamp
    ) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
");
$stmt->execute([
    $code, $ip_address, $user_agent, $referrer, 
    $country, $city, $device_type
]);

// Update tracking status
$db->prepare("UPDATE phone_tracking SET status = 'clicked' WHERE tracking_code = ?")->execute([$code]);

// Redirect to original URL
header("Location: " . $tracking['original_url']);
exit;
?> 