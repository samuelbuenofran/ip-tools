<?php
require_once('../config.php');

// Set JSON response header
header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

try {
    $db = connectDB();
    
    // Get POST data
    $download_speed = $_POST['download_speed'] ?? 0;
    $upload_speed = $_POST['upload_speed'] ?? 0;
    $ping = $_POST['ping'] ?? 0;
    $jitter = $_POST['jitter'] ?? 0;
    
    // Validate data
    if (!is_numeric($download_speed) || !is_numeric($upload_speed) || !is_numeric($ping)) {
        throw new Exception('Invalid speed test data');
    }
    
    // Get user information
    $ip_address = $_SERVER['HTTP_CLIENT_IP'] 
        ?? $_SERVER['HTTP_X_FORWARDED_FOR'] 
        ?? $_SERVER['REMOTE_ADDR'] 
        ?? 'UNKNOWN';
    
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    
    // Get location data using IP geolocation
    $country = 'Unknown';
    $city = 'Unknown';
    
    try {
        // Use a free IP geolocation service
        $geo_url = "https://ipapi.co/{$ip_address}/json/";
        $geo_response = @file_get_contents($geo_url);
        
        if ($geo_response) {
            $geo_data = json_decode($geo_response, true);
            if ($geo_data && !isset($geo_data['error'])) {
                $country = $geo_data['country_name'] ?? 'Unknown';
                $city = $geo_data['city'] ?? 'Unknown';
            }
        }
    } catch (Exception $e) {
        // Continue without geocoding
    }
    
    // Insert speed test results
    $stmt = $db->prepare("
        INSERT INTO speed_tests (
            ip_address, download_speed, upload_speed, ping, jitter,
            country, city, user_agent, timestamp
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    
    $stmt->execute([
        $ip_address,
        $download_speed,
        $upload_speed,
        $ping,
        $jitter,
        $country,
        $city,
        $user_agent
    ]);
    
    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Speed test results saved successfully',
        'data' => [
            'download_speed' => $download_speed,
            'upload_speed' => $upload_speed,
            'ping' => $ping,
            'jitter' => $jitter,
            'location' => "$city, $country"
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 