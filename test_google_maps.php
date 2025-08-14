<?php
// Test script to diagnose Google Maps API issues
require_once 'config.php';

$api_key = 'AIzaSyC5gMYj7gqRiwNlE6BxyLAdG9IMCCJZsrs';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Maps API Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #map { width: 100%; height: 400px; border: 1px solid #ccc; }
        .status { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .success { background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .error { background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .warning { background-color: #fff3cd; border: 1px solid #ffeaa7; color: #856404; }
    </style>
</head>
<body class="container py-4">
    <h1>Google Maps API Test</h1>
    
    <div class="row">
        <div class="col-md-6">
            <h3>API Key Information</h3>
            <div class="card">
                <div class="card-body">
                    <p><strong>API Key:</strong> <?= substr($api_key, 0, 20) ?>...</p>
                    <p><strong>Length:</strong> <?= strlen($api_key) ?> characters</p>
                    <p><strong>Format:</strong> <?= preg_match('/^AIza[0-9A-Za-z_-]{35}$/', $api_key) ? 'Valid' : 'Invalid' ?></p>
                </div>
            </div>
            
            <h3>Test Results</h3>
            <div id="status"></div>
        </div>
        
        <div class="col-md-6">
            <h3>Map Display</h3>
            <div id="map"></div>
        </div>
    </div>

    <script>
        let statusDiv = document.getElementById('status');
        
        function showStatus(message, type) {
            statusDiv.innerHTML = `<div class="status ${type}">${message}</div>`;
        }
        
        function testGoogleMaps() {
            showStatus('Testing Google Maps API...', 'warning');
            
            // Test 1: Check if Google Maps loads
            if (typeof google === 'undefined') {
                showStatus('❌ Google Maps failed to load. Check your internet connection.', 'error');
                return;
            }
            
            if (typeof google.maps === 'undefined') {
                showStatus('❌ Google Maps API failed to initialize.', 'error');
                return;
            }
            
            showStatus('✅ Google Maps loaded successfully!', 'success');
            
            // Test 2: Try to create a map
            try {
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 8,
                    center: { lat: -23.5505, lng: -46.6333 }, // São Paulo
                    mapTypeId: "roadmap"
                });
                
                showStatus('✅ Map created successfully! Google Maps API is working.', 'success');
                
                // Test 3: Add a marker
                const marker = new google.maps.Marker({
                    position: { lat: -23.5505, lng: -46.6333 },
                    map: map,
                    title: "São Paulo, Brazil"
                });
                
                showStatus('✅ Marker added successfully! All Google Maps features are working.', 'success');
                
            } catch (error) {
                showStatus(`❌ Error creating map: ${error.message}`, 'error');
            }
        }
        
        // Handle Google Maps loading errors
        window.gm_authFailure = function() {
            showStatus('❌ Google Maps authentication failed. Your API key may be invalid or restricted.', 'error');
        };
        
        // Test when page loads
        window.onload = function() {
            setTimeout(testGoogleMaps, 2000); // Wait 2 seconds for Google Maps to load
        };
    </script>
    
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=<?= $api_key ?>&callback=testGoogleMaps" async defer>
    </script>
</body>
</html>
