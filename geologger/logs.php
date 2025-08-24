<?php
require_once('../config.php');
$db = connectDB();

// Fetch log data with associated links and coordinates
$stmt = $db->query("
  SELECT g.id, g.ip_address, g.user_agent, g.referrer, g.country, g.city,
         g.device_type, g.timestamp, g.latitude, g.longitude, 
         COALESCE(g.accuracy, 0) as accuracy,
         COALESCE(l.short_code, 'Unknown') as short_code, 
         COALESCE(l.original_url, 'N/A') as original_url
  FROM geo_logs g
  LEFT JOIN geo_links l ON g.link_id = l.id
  ORDER BY g.timestamp DESC
");
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare heatmap positions from existing database data
$positions = [];
$validPositions = 0;
$totalLogs = count($logs);

foreach ($logs as $log) {
  // Use existing coordinates from database if available
  if (!empty($log['latitude']) && !empty($log['longitude']) && 
      is_numeric($log['latitude']) && is_numeric($log['longitude'])) {
    $positions[] = [
      'lat' => (float)$log['latitude'], 
      'lng' => (float)$log['longitude'],
      'accuracy' => $log['accuracy'] ?? null,
      'city' => $log['city'] ?? 'Unknown',
      'country' => $log['country'] ?? 'Unknown'
    ];
    $validPositions++;
  }
}

// Log heatmap data preparation
error_log("Heatmap: $validPositions valid positions out of $totalLogs total logs");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Visitor Logs | Geolocation Tracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5gMYj7gqRiwNlE6BxyLAdG9IMCCJZsrs&libraries=visualization"></script>

  <style>
    .search-bar {
      max-width: 400px;
      margin: 0 auto 20px;
    }
    .table th { font-size: 0.95rem; }
    .table td { font-size: 0.9rem; vertical-align: middle; }
    .map-container {
      width: 100%;
      height: 500px;
      margin-bottom: 40px;
    }
  </style>
</head>
<body class="bg-light">
  <?php include('../header.php'); ?>

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

    <h2 class="mb-4 text-center"><i class="fa-solid fa-list-check text-primary"></i> Visitor Log Dashboard</h2>

    <h4 class="mb-3">
      <i class="fa-solid fa-map-location-dot"></i> Visitor Heatmap
      <span class="badge bg-info ms-2" id="heatmapCount"><?= count($positions) ?> locations</span>
    </h4>
    
    <?php if (!empty($positions)): ?>
    <div class="row mb-3">
      <div class="col-md-6">
        <div class="d-flex align-items-center">
          <label class="me-2"><strong>Heatmap Radius:</strong></label>
          <input type="range" class="form-range" id="radiusSlider" min="10" max="50" value="25" style="width: 150px;">
          <span class="ms-2" id="radiusValue">25</span>
        </div>
      </div>
      <div class="col-md-6">
        <div class="d-flex align-items-center">
          <label class="me-2"><strong>Opacity:</strong></label>
          <input type="range" class="form-range" id="opacitySlider" min="0.1" max="1" step="0.1" value="0.8" style="width: 150px;">
          <span class="ms-2" id="opacityValue">0.8</span>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <div id="map" class="map-container rounded border">
      <?php if (empty($positions)): ?>
        <div class="d-flex align-items-center justify-content-center h-100">
          <div class="text-center text-muted">
            <i class="fa-solid fa-map-marked-alt fa-3x mb-3"></i>
            <h5>No location data available</h5>
            <p>Tracking links need to be clicked to generate heatmap data.</p>
            <a href="create.php" class="btn btn-primary">
              <i class="fa-solid fa-plus"></i> Create Tracking Link
            </a>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <input type="search" class="form-control search-bar" id="searchInput" onkeyup="filterLogs()" placeholder="?? Filter by IP, link, country...">

    <div class="table-responsive mt-3">
      <table class="table table-bordered table-striped shadow-sm">
        <thead class="table-primary text-center">
          <tr>
            <th>ID</th>
            <th>Short Code</th>
            <th>IP Address</th>
            <th>Country</th>
            <th>City</th>
            <th>Device</th>
            <th>Timestamp</th>
            <th>Referrer</th>
            <th>Original URL</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php foreach ($logs as $log): ?>
            <tr>
              <td><?= $log['id'] ?></td>
              <td><?= $log['short_code'] ?></td>
              <td><?= $log['ip_address'] ?></td>
              <td><?= $log['country'] ?></td>
              <td><?= $log['city'] ?></td>
              <td><?= $log['device_type'] ?></td>
              <td><?= date('Y-m-d H:i:s', strtotime($log['timestamp'])) ?></td>
              <td><?= htmlspecialchars($log['referrer']) ?></td>
              <td><a href="<?= htmlspecialchars($log['original_url']) ?>" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> Visit</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php include('../footer.php'); ?>

  <script>
    const heatmapData = <?= json_encode($positions) ?>;

    function initMap() {
      try {
        console.log('Initializing Google Maps...');
        console.log('Heatmap data:', heatmapData);
        console.log('Heatmap data length:', heatmapData ? heatmapData.length : 'null');
        console.log('Map container element:', document.getElementById("map"));
        
        // Set initial map center based on data
        let center = { lat: 0, lng: 0 };
        let zoom = 2;
        
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: zoom,
          center: center,
          mapTypeId: "roadmap",
          mapTypeControl: true,
          streetViewControl: true,
          fullscreenControl: true
        });
        
        if (heatmapData && heatmapData.length > 0) {
          // Calculate center based on data
          const bounds = new google.maps.LatLngBounds();
          heatmapData.forEach(loc => {
            bounds.extend(new google.maps.LatLng(loc.lat, loc.lng));
          });
          
          center = bounds.getCenter();
          map.fitBounds(bounds);
          zoom = 3; // Adjust zoom based on data spread
        }
        
        // Store references for controls
        mapInstance = map;
        
        console.log('Map created successfully');

        if (heatmapData && heatmapData.length > 0) {
          // Create heatmap
          const heatmap = new google.maps.visualization.HeatmapLayer({
            data: heatmapData.map(loc => new google.maps.LatLng(loc.lat, loc.lng)),
            radius: 25,
            opacity: 0.8,
            dissipating: true
          });
          heatmap.setMap(map);
          
          // Store reference for controls
          heatmapLayer = heatmap;
          
          // Add markers for individual points with info windows
          heatmapData.forEach((loc, index) => {
            const marker = new google.maps.Marker({
              position: new google.maps.LatLng(loc.lat, loc.lng),
              map: map,
              title: `${loc.city}, ${loc.country}`,
              icon: {
                url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                  <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="10" cy="10" r="8" fill="#ff4444" stroke="#ffffff" stroke-width="2"/>
                  </svg>
                `),
                scaledSize: new google.maps.Size(20, 20)
              }
            });
            
            // Info window for each marker
            const infoWindow = new google.maps.InfoWindow({
              content: `
                <div style="padding: 10px; min-width: 200px;">
                  <h6><i class="fa-solid fa-map-marker-alt"></i> Location Details</h6>
                  <p><strong>City:</strong> ${loc.city || 'Unknown'}</p>
                  <p><strong>Country:</strong> ${loc.country || 'Unknown'}</p>
                  ${loc.accuracy ? `<p><strong>Accuracy:</strong> ${loc.accuracy}m</p>` : ''}
                  <p><strong>Coordinates:</strong> ${loc.lat.toFixed(6)}, ${loc.lng.toFixed(6)}</p>
                </div>
              `
            });
            
            marker.addListener('click', () => {
              infoWindow.open(map, marker);
            });
          });
          
          console.log('Heatmap created successfully with', heatmapData.length, 'points');
          
          // Update the count badge
          const countBadge = document.getElementById('heatmapCount');
          if (countBadge) {
            countBadge.textContent = `${heatmapData.length} locations`;
            countBadge.className = 'badge bg-success ms-2';
          }
          
          // Setup heatmap controls
          setupHeatmapControls();
        } else {
          console.warn('No heatmap data available');
          // Update the count badge
          const countBadge = document.getElementById('heatmapCount');
          if (countBadge) {
            countBadge.textContent = '0 locations';
            countBadge.className = 'badge bg-warning ms-2';
          }
        }
      } catch (error) {
        console.error('Error initializing map:', error);
        document.getElementById('map').innerHTML = `
          <div style="padding: 20px; text-align: center; color: red;">
            <i class="fa-solid fa-exclamation-triangle fa-2x mb-2"></i>
            <h5>Error loading map</h5>
            <p>${error.message}</p>
            <button onclick="location.reload()" class="btn btn-primary mt-2">
              <i class="fa-solid fa-redo"></i> Reload Page
            </button>
          </div>
        `;
      }
    }

    let heatmapLayer = null;
    let mapInstance = null;

    window.onload = initMap;

    function filterLogs() {
      const query = document.getElementById("searchInput").value.toLowerCase();
      const rows = document.querySelectorAll("tbody tr");
      rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(query) ? "" : "none";
      });
    }

    // Heatmap controls
    function setupHeatmapControls() {
      const radiusSlider = document.getElementById('radiusSlider');
      const opacitySlider = document.getElementById('opacitySlider');
      const radiusValue = document.getElementById('radiusValue');
      const opacityValue = document.getElementById('opacityValue');

      if (radiusSlider && heatmapLayer) {
        radiusSlider.addEventListener('input', function() {
          const value = this.value;
          radiusValue.textContent = value;
          heatmapLayer.setOptions({ radius: parseInt(value) });
        });
      }

      if (opacitySlider && heatmapLayer) {
        opacitySlider.addEventListener('input', function() {
          const value = parseFloat(this.value);
          opacityValue.textContent = value;
          heatmapLayer.setOptions({ opacity: value });
        });
      }
    }

    // Theme system is now handled by theme-switcher.js
    // The old theme toggle has been replaced with a comprehensive theme selector
  </script>
</body>
</html>
