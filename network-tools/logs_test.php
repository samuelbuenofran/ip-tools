<?php
// 🚫 Cache prevention
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

require_once('../config.php');
$db = connectDB();

  // 🧠 Fetch logs + link metadata with enhanced precise location data
  $logs = $db->query("
    SELECT g.*, l.original_url,
           CASE 
             WHEN g.location_type = 'GPS' THEN CONCAT('GPS (', g.accuracy, 'm)')
             ELSE 'IP-based'
           END as location_source,
           CASE
             WHEN g.house_number IS NOT NULL AND g.street IS NOT NULL 
             THEN CONCAT(g.house_number, ' ', g.street)
             WHEN g.street IS NOT NULL THEN g.street
             ELSE g.address
           END as precise_address
    FROM geo_logs g
    JOIN geo_links l ON g.link_id = l.id
    ORDER BY g.timestamp DESC;
  ")->fetchAll(PDO::FETCH_ASSOC);

// 📊 Stats
$totalClicks = $db->query("SELECT COUNT(*) FROM geo_logs")->fetchColumn();
$activeLinks = $db->query("SELECT COUNT(*) FROM geo_links WHERE expires_at IS NULL OR expires_at > NOW()")->fetchColumn();
$uniqueIPs   = $db->query("SELECT COUNT(DISTINCT ip_address) FROM geo_logs")->fetchColumn();
$gpsTracking = $db->query("SELECT COUNT(*) FROM geo_logs WHERE location_type = 'GPS' AND latitude IS NOT NULL AND longitude IS NOT NULL")->fetchColumn();

// 🔥 Filtered heatmap coordinates
$positions = [];
foreach ($logs as $log) {
  if (
    isset($log['latitude'], $log['longitude']) &&
    $log['latitude'] > -40 && $log['latitude'] < 10 &&
    $log['longitude'] > -80 && $log['longitude'] < -30
  ) {
    $positions[] = [
      'lat' => (float)$log['latitude'],
      'lng' => (float)$log['longitude']
    ];
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Logs Dashboard - Test Version</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .status-card { border-left: 4px solid; }
        .status-card.success { border-left-color: #28a745; }
        .status-card.warning { border-left-color: #ffc107; }
        .status-card.danger { border-left-color: #dc3545; }
        .status-card.info { border-left-color: #17a2b8; }
        .test-result { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .test-success { background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .test-error { background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .test-warning { background-color: #fff3cd; border: 1px solid #ffeaa7; color: #856404; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-4">
        <h2 class="mb-4 text-center">
            <i class="fa-solid fa-list-check text-primary"></i> Visitor Log Dashboard - TEST VERSION
        </h2>

        <!-- 📈 Stats Cards -->
        <div class="row g-4 text-center mb-4">
            <div class="col-md-3">
                <div class="card p-3 border-primary">
                    <h5><i class="fa-solid fa-mouse-pointer text-primary"></i> Total Clicks</h5>
                    <h3><?= $totalClicks ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 border-success">
                    <h5><i class="fa-solid fa-link text-success"></i> Active Links</h5>
                    <h3><?= $activeLinks ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 border-info">
                    <h5><i class="fa-solid fa-user-check text-info"></i> Unique Visitors</h5>
                    <h3><?= $uniqueIPs ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 border-warning">
                    <h5><i class="fa-solid fa-map-marker-alt text-warning"></i> GPS Tracking</h5>
                    <h3><?= $gpsTracking ?></h3>
                </div>
            </div>
        </div>

        <!-- 🗺️ Heatmap -->
        <h4 class="mt-5">
            <i class="fa-solid fa-map-location-dot"></i> Click Heatmap
        </h4>
        <div id="map" style="width:100%; height:500px;" class="border rounded shadow-sm mb-5"></div>
        
        <!-- Map Error Display -->
        <div id="mapError" class="alert alert-warning" style="display: none;">
            <i class="fa-solid fa-exclamation-triangle"></i>
            <strong>Map Loading Issue:</strong> <span id="errorMessage"></span>
        </div>

        <!-- Debug Information -->
        <div class="card mt-3">
            <div class="card-header">
                <h5><i class="fa-solid fa-bug"></i> Debug Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Heatmap Data:</h6>
                        <pre><?= json_encode($positions, JSON_PRETTY_PRINT) ?></pre>
                    </div>
                    <div class="col-md-6">
                        <h6>Console Logs:</h6>
                        <div id="consoleOutput" class="bg-dark text-light p-3 rounded" style="height: 200px; overflow-y: auto; font-family: monospace; font-size: 12px;">
                            <div>Console output will appear here...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Maps Script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5gMYj7gqRiwNlE6BxyLAdG9IMCCJZsrs&libraries=visualization" async defer></script>

    <script>
        // Console logging function
        function logToConsole(message, type = 'info') {
            const consoleOutput = document.getElementById('consoleOutput');
            const timestamp = new Date().toLocaleTimeString();
            const color = type === 'error' ? '#ff6b6b' : type === 'success' ? '#51cf66' : type === 'warning' ? '#ffd43b' : '#74c0fc';
            
            consoleOutput.innerHTML += `<div style="color: ${color}">[${timestamp}] ${message}</div>`;
            consoleOutput.scrollTop = consoleOutput.scrollHeight;
            
            // Also log to browser console
            console.log(`[${type.toUpperCase()}] ${message}`);
        }

        const heatmapData = <?= json_encode($positions, JSON_NUMERIC_CHECK) ?>;
        let map = null;
        let heatmap = null;

        logToConsole('Script loaded, starting initialization...', 'info');

        function showMapError(message) {
            logToConsole(`ERROR: ${message}`, 'error');
            const errorDiv = document.getElementById('mapError');
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.textContent = message;
            errorDiv.style.display = 'block';
        }

        function initMap() {
            logToConsole('🗺️ Starting map initialization...', 'info');
            
            try {
                // Check if Google Maps loaded successfully
                if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
                    throw new Error('Google Maps failed to load');
                }

                logToConsole('✅ Google Maps API is available', 'success');

                // Check if map container exists
                const mapContainer = document.getElementById("map");
                if (!mapContainer) {
                    throw new Error('Map container element not found');
                }
                
                logToConsole('📍 Creating Google Maps instance...', 'info');
                
                // Create the map
                map = new google.maps.Map(mapContainer, {
                    zoom: 4,
                    center: { lat: -15.78, lng: -47.93 }, // Center over Brazil
                    mapTypeId: "roadmap",
                    mapTypeControl: true,
                    streetViewControl: false,
                    fullscreenControl: true
                });

                logToConsole('✅ Map created successfully', 'success');

                // Add heatmap if we have data
                if (Array.isArray(heatmapData) && heatmapData.length > 0) {
                    try {
                        logToConsole(`🔥 Creating heatmap with ${heatmapData.length} points...`, 'info');
                        
                        heatmap = new google.maps.visualization.HeatmapLayer({
                            data: heatmapData.map(p => new google.maps.LatLng(p.lat, p.lng)),
                            radius: 20,
                            opacity: 0.8
                        });
                        heatmap.setMap(map);
                        
                        logToConsole(`✅ Heatmap rendered successfully with ${heatmapData.length} points`, 'success');
                        
                        // Hide any error messages
                        document.getElementById('mapError').style.display = 'none';
                    } catch (heatmapError) {
                        logToConsole(`❌ Heatmap error: ${heatmapError.message}`, 'error');
                        showMapError("Heatmap visualization failed: " + heatmapError.message);
                    }
                } else {
                    logToConsole('⚠️ No heatmap data available', 'warning');
                    showMapError("No location data available for heatmap visualization");
                }

            } catch (error) {
                logToConsole(`❌ Map initialization error: ${error.message}`, 'error');
                showMapError("Failed to initialize Google Maps: " + error.message);
            }
        }

        // Wait for both DOM and Google Maps to be ready
        function waitForGoogleMaps() {
            logToConsole('🔍 Checking Google Maps availability...', 'info');
            logToConsole(`Google object: ${typeof google}`, 'info');
            logToConsole(`Google.maps object: ${typeof google?.maps}`, 'info');
            
            if (typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
                logToConsole('✅ Google Maps is ready, initializing map...', 'success');
                initMap();
            } else {
                logToConsole('⏳ Google Maps not ready yet, waiting...', 'warning');
                setTimeout(waitForGoogleMaps, 100);
            }
        }

        // Global error handler
        window.addEventListener('error', function(event) {
            logToConsole(`🚨 JavaScript Error: ${event.message}`, 'error');
            logToConsole(`File: ${event.filename}, Line: ${event.lineno}`, 'error');
            showMapError('JavaScript error: ' + event.message);
        });

        // Handle unhandled promise rejections
        window.addEventListener('unhandledrejection', function(event) {
            logToConsole(`🚨 Unhandled Promise Rejection: ${event.reason}`, 'error');
            showMapError('Promise error: ' + event.reason);
        });

        // Start waiting for Google Maps to load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                logToConsole('📄 DOM loaded, starting Google Maps check...', 'info');
                waitForGoogleMaps();
            });
        } else {
            logToConsole('📄 DOM already loaded, starting Google Maps check...', 'info');
            waitForGoogleMaps();
        }

        // Fallback timeout
        setTimeout(function() {
            if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
                logToConsole('⏰ Timeout reached - Google Maps failed to load', 'error');
                showMapError("Google Maps failed to load within timeout period. Please check your internet connection and try again.");
            }
        }, 15000); // 15 second timeout
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
