<?php
require_once('../config.php');

header('Content-Type: application/json');

try {
    $db = connectDB();
    
    // Get POST data
    $log_id = $_POST['log_id'] ?? null;
    $latitude = $_POST['latitude'] ?? null;
    $longitude = $_POST['longitude'] ?? null;
    $accuracy = $_POST['accuracy'] ?? null;
    $location_type = $_POST['location_type'] ?? 'GPS';
    
    if (!$log_id || !$latitude || !$longitude) {
        throw new Exception('Missing required parameters');
    }
    
    // Get detailed address using Nominatim
    $nominatim_url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$latitude}&lon={$longitude}&zoom=18&addressdetails=1&extratags=1";
    $address_data = @json_decode(file_get_contents($nominatim_url), true);
    
    $address = $address_data['display_name'] ?? '';
    $street = $address_data['address']['road'] ?? '';
    $house_number = $address_data['address']['house_number'] ?? '';
    $city = $address_data['address']['city'] ?? $address_data['address']['town'] ?? $address_data['address']['village'] ?? '';
    $state = $address_data['address']['state'] ?? '';
    $country = $address_data['address']['country'] ?? '';
    $postcode = $address_data['address']['postcode'] ?? '';
    
    // Update the log with GPS data
    $stmt = $db->prepare("
        UPDATE geo_logs 
        SET latitude = ?, longitude = ?, accuracy = ?, location_type = ?, 
            address = ?, street = ?, house_number = ?, city = ?, 
            state = ?, country = ?, postcode = ?
        WHERE id = ?
    ");
    
    $stmt->execute([
        $latitude,
        $longitude,
        $accuracy,
        $location_type,
        $address,
        $street,
        $house_number,
        $city,
        $state,
        $country,
        $postcode,
        $log_id
    ]);
    
    echo json_encode(['success' => true, 'message' => 'GPS location updated successfully']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 