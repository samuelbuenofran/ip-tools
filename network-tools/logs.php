<?php
// 🚫 Cache prevention
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

require_once('../config.php');
include('../header.php');

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

<div class="container py-4">
  <!-- DEMO MODE NOTICE -->
  <div class="alert alert-warning text-center mb-4">
    <i class="fa-solid fa-triangle-exclamation fa-2x mb-2"></i>
    <h4>🚧 Demo Mode - Standalone Version</h4>
    <p class="mb-2">This is the standalone demo version of the application.</p>
    <p class="mb-0">
      <strong>For production use, please use the MVC version:</strong><br>
      <a href="/projects/ip-tools/public/" class="btn btn-primary mt-2">
        <i class="fa-solid fa-external-link-alt"></i> Go to Production App
      </a>
    </p>
  </div>

  <h2 class="mb-4 text-center">
    <i class="fa-solid fa-list-check text-primary"></i> <span data-translate="visitor_log_dashboard">Visitor Log Dashboard</span>
  </h2>

  <!-- 📈 Stats Cards -->
  <div class="row g-4 text-center mb-4">
    <div class="col-md-3">
      <div class="card p-3 border-primary">
        <h5><i class="fa-solid fa-mouse-pointer text-primary"></i> <span data-translate="total_clicks">Total Clicks</span></h5>
        <h3><?= $totalClicks ?></h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 border-success">
        <h5><i class="fa-solid fa-link text-success"></i> <span data-translate="active_links">Active Links</span></h5>
        <h3><?= $activeLinks ?></h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 border-info">
        <h5><i class="fa-solid fa-user-check text-info"></i> <span data-translate="unique_visitors">Unique Visitors</span></h5>
        <h3><?= $uniqueIPs ?></h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 border-warning">
        <h5><i class="fa-solid fa-map-marker-alt text-warning"></i> <span data-translate="gps_tracking">GPS Tracking</span></h5>
        <h3><?= $gpsTracking ?></h3>
      </div>
    </div>
  </div>

  <!-- 🧾 Visitor Table -->
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-light text-center">
        <tr>
          <th data-translate="id">ID</th>
          <th data-translate="ip_address">IP Address</th>
          <th data-translate="location_source">Location Source</th>
          <th data-translate="accuracy">Accuracy</th>
          <th data-translate="precise_address">Precise Address</th>
          <th data-translate="street">Street</th>
          <th data-translate="city">City</th>
          <th data-translate="state">State</th>
          <th data-translate="country">Country</th>
          <th data-translate="device">Device</th>
          <th data-translate="referrer">Referrer</th>
          <th data-translate="timestamp">Timestamp</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <?php foreach ($logs as $log): ?>
        <tr>
          <td><?= $log['id'] ?></td>
          <td><?= $log['ip_address'] ?></td>
          <td><span class="badge bg-<?= $log['location_type'] === 'GPS' ? 'success' : 'secondary' ?>"><?= $log['location_source'] ?></span></td>
          <td><?= $log['accuracy'] ? $log['accuracy'] . 'm' : '-' ?></td>
          <td><?= htmlspecialchars($log['precise_address'] ?? '-') ?></td>
          <td><?= htmlspecialchars($log['street'] ?? '-') ?></td>
          <td><?= $log['city'] ?? '-' ?></td>
          <td><?= $log['state'] ?? '-' ?></td>
          <td><?= $log['country'] ?? '-' ?></td>
          <td><?= $log['device_type'] ?? '-' ?></td>
          <td><?= htmlspecialchars($log['referrer']) ?></td>
          <td><?= date('Y-m-d H:i:s', strtotime($log['timestamp'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- 🗺️ Heatmap -->
  <h4 class="mt-5">
    <i class="fa-solid fa-map-location-dot"></i> <span data-translate="click_heatmap">Click Heatmap</span>
  </h4>
  <div id="map" style="width:100%; height:500px;" class="border rounded shadow-sm mb-5"></div>
  
  <!-- Map Error Display -->
  <div id="mapError" class="alert alert-warning" style="display: none;">
    <i class="fa-solid fa-exclamation-triangle"></i>
    <strong>Map Loading Issue:</strong> <span id="errorMessage"></span>
  </div>
</div>

<!-- 🌐 Google Maps Script -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5gMYj7gqRiwNlE6BxyLAdG9IMCCJZsrs" async defer>
</script>

<script>
  const heatmapData = <?= json_encode($positions, JSON_NUMERIC_CHECK) ?>;
  let map = null;
  let heatmap = null;

  // Wait for both DOM and Google Maps to be ready
  function initMap() {
    console.log('🗺️ Starting map initialization...');
    try {
      // Check if Google Maps loaded successfully
      if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
        throw new Error('Google Maps failed to load');
      }

      // Check if map container exists
      const mapContainer = document.getElementById("map");
      if (!mapContainer) {
        throw new Error('Map container element not found');
      }
      
      console.log('📍 Creating Google Maps instance...');
      // Create the map
      map = new google.maps.Map(mapContainer, {
        zoom: 4,
        center: { lat: -15.78, lng: -47.93 }, // Center over Brazil
        mapTypeId: "roadmap",
        mapTypeControl: true,
        streetViewControl: false,
        fullscreenControl: true
      });

      // Add markers for each location (replacing deprecated heatmap)
      if (Array.isArray(heatmapData) && heatmapData.length > 0) {
        try {
          console.log("📍 Adding markers for", heatmapData.length, "locations...");
          
          heatmapData.forEach((position, index) => {
            const marker = new google.maps.Marker({
              position: { lat: position.lat, lng: position.lng },
              map: map,
              title: `Location ${index + 1}`,
              icon: {
                url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                  <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="10" cy="10" r="8" fill="#ff4444" stroke="#ffffff" stroke-width="2"/>
                  </svg>
                `),
                scaledSize: new google.maps.Size(20, 20)
              }
            });
          });
          
          console.log("✅ Markers added successfully for", heatmapData.length, "locations");
          
          // Hide any error messages
          document.getElementById('mapError').style.display = 'none';
        } catch (markerError) {
          console.error("Marker error:", markerError);
          showMapError("Marker visualization failed: " + markerError.message);
        }
      } else {
        console.warn("⚠️ No location data available");
        showMapError("No location data available for visualization");
      }

    } catch (error) {
      console.error("Map initialization error:", error);
      showMapError("Failed to initialize Google Maps: " + error.message);
    }
  }

  function showMapError(message) {
    const errorDiv = document.getElementById('mapError');
    const errorMessage = document.getElementById('errorMessage');
    errorMessage.textContent = message;
    errorDiv.style.display = 'block';
  }

  // Handle Google Maps loading errors
  window.gm_authFailure = function() {
    showMapError("Google Maps authentication failed. Please check your API key.");
  };

  // Fallback if Google Maps doesn't load
  setTimeout(function() {
    if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
      showMapError("Google Maps failed to load. Please check your internet connection and try again.");
    }
  }, 10000); // 10 second timeout

  // Initialize map when both DOM and Google Maps are ready
  function waitForGoogleMaps() {
    console.log('🔍 Checking Google Maps availability...');
    console.log('Google object:', typeof google);
    console.log('Google.maps object:', typeof google?.maps);
    
    if (typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
      console.log('✅ Google Maps is ready, initializing map...');
      initMap();
    } else {
      console.log('⏳ Google Maps not ready yet, waiting...');
      setTimeout(waitForGoogleMaps, 100);
    }
  }

  // Start waiting for Google Maps to load
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', waitForGoogleMaps);
  } else {
    waitForGoogleMaps();
  }

  // Global error handler to catch any JavaScript errors
  window.addEventListener('error', function(event) {
    console.error('🚨 JavaScript Error:', event.error);
    console.error('Error details:', {
      message: event.message,
      filename: event.filename,
      lineno: event.lineno,
      colno: event.colno
    });
    showMapError('JavaScript error: ' + event.message);
  });

  // Handle unhandled promise rejections
  window.addEventListener('unhandledrejection', function(event) {
    console.error('🚨 Unhandled Promise Rejection:', event.reason);
    showMapError('Promise error: ' + event.reason);
  });
</script>

<?php include('../footer.php'); ?>
