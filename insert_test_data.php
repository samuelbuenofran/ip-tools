<?php
require_once('config.php');

echo "<h2>🧪 Insert Test Heatmap Data</h2>";

try {
    $db = connectDB();
    
    // Check if we have any geo_links to work with
    $stmt = $db->query("SELECT id FROM geo_links LIMIT 1");
    $link = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$link) {
        echo "<p style='color: red;'>❌ No tracking links found. Please create a tracking link first.</p>";
        echo "<p><a href='geologger/create.php' class='btn btn-primary'>Create Tracking Link</a></p>";
        exit;
    }
    
    $linkId = $link['id'];
    
    // Insert test data with coordinates
    $testData = [
        [
            'ip_address' => '192.168.1.100',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'referrer' => 'https://google.com',
            'country' => 'Brazil',
            'city' => 'São Paulo',
            'latitude' => -23.5505,
            'longitude' => -46.6333,
            'accuracy' => 100,
            'location_type' => 'IP',
            'link_id' => $linkId,
            'device_type' => 'Desktop'
        ],
        [
            'ip_address' => '192.168.1.101',
            'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X)',
            'referrer' => 'https://facebook.com',
            'country' => 'United States',
            'city' => 'New York',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'accuracy' => 150,
            'location_type' => 'IP',
            'link_id' => $linkId,
            'device_type' => 'Mobile'
        ],
        [
            'ip_address' => '192.168.1.102',
            'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
            'referrer' => 'https://twitter.com',
            'country' => 'United Kingdom',
            'city' => 'London',
            'latitude' => 51.5074,
            'longitude' => -0.1278,
            'accuracy' => 200,
            'location_type' => 'IP',
            'link_id' => $linkId,
            'device_type' => 'Desktop'
        ]
    ];
    
    $insertStmt = $db->prepare("
        INSERT INTO geo_logs (
            ip_address, user_agent, referrer, country, city, 
            latitude, longitude, accuracy, location_type, 
            link_id, device_type, timestamp
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW()
        )
    ");
    
    $inserted = 0;
    foreach ($testData as $data) {
        try {
            $insertStmt->execute([
                $data['ip_address'],
                $data['user_agent'],
                $data['referrer'],
                $data['country'],
                $data['city'],
                $data['latitude'],
                $data['longitude'],
                $data['accuracy'],
                $data['location_type'],
                $data['link_id'],
                $data['device_type']
            ]);
            $inserted++;
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Error inserting data: " . $e->getMessage() . "</p>";
        }
    }
    
    if ($inserted > 0) {
        echo "<p style='color: green;'>✅ Successfully inserted {$inserted} test records!</p>";
        
        // Verify the data
        $stmt = $db->query("SELECT COUNT(*) as total FROM geo_logs");
        $total = $stmt->fetch()['total'];
        echo "<p><strong>Total geo_logs records now:</strong> {$total}</p>";
        
        $stmt = $db->query("SELECT COUNT(*) as total FROM geo_logs WHERE latitude IS NOT NULL AND longitude IS NOT NULL");
        $withCoords = $stmt->fetch()['total'];
        echo "<p><strong>Records with coordinates:</strong> {$withCoords}</p>";
        
        echo "<p><a href='geologger/logs.php' class='btn btn-success'>View Heatmap</a></p>";
        echo "<p><a href='test_heatmap_data.php' class='btn btn-info'>Run Diagnostic Again</a></p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>
