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

// 🔥 Filtered coordinates for map
$positions = [];
foreach ($logs as $log) {
  if (
    isset($log['latitude'], $log['longitude']) &&
    $log['latitude'] > -40 && $log['latitude'] < 10 &&
    $log['longitude'] > -80 && $log['longitude'] < -30
  ) {
    $positions[] = [
      'lat' => (float)$log['latitude'],
      'lng' => (float)$log['longitude'],
      'city' => $log['city'] ?? 'Unknown',
      'country' => $log['country'] ?? 'Unknown'
    ];
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Logs Dashboard - Simple Version</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="../assets/javafx-buttons.css" rel="stylesheet">
    <style>
        .status-card { border-left: 4px solid; }
        .status-card.success { border-left-color: #28a745; }
        .status-card.warning { border-left-color: #ffc107; }
        .status-card.danger { border-left-color: #dc3545; }
        .status-card.info { border-left-color: #17a2b8; }
        .map-container { 
            width: 100%; 
            height: 500px; 
            border: 1px solid #dee2e6; 
            border-radius: 5px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .map-placeholder {
            text-align: center;
            color: #6c757d;
        }
        .map-placeholder i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-4">
        <h2 class="mb-4 text-center">
            <i class="fa-solid fa-list-check text-primary"></i> Visitor Log Dashboard - Simple Version
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

        <!-- 🗺️ Location Map -->
        <h4 class="mt-5">
            <i class="fa-solid fa-map-location-dot"></i> Location Overview
        </h4>
        
        <div id="mapContainer" class="map-container mb-5">
            <div class="map-placeholder">
                <i class="fa-solid fa-map"></i>
                <h5>Location Data Available</h5>
                <p>Found <?= count($positions) ?> locations with coordinates</p>
                <button class="btn btn-primary btn-javafx" onclick="loadGoogleMaps()">
                    <i class="fa-solid fa-play"></i> Load Google Maps
                </button>
            </div>
        </div>

        <!-- 📍 Location List -->
        <?php if (!empty($positions)): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fa-solid fa-list"></i> Location Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach (array_slice($positions, 0, 8) as $index => $pos): ?>
                    <div class="col-md-3 mb-3">
                        <div class="card border-info">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-map-marker-alt text-info fa-2x mb-2"></i>
                                <h6>Location <?= $index + 1 ?></h6>
                                <small class="text-muted">
                                    <?= htmlspecialchars($pos['city']) ?>, <?= htmlspecialchars($pos['country']) ?>
                                </small>
                                <br>
                                <code class="small">
                                    <?= number_format($pos['lat'], 4) ?>, <?= number_format($pos['lng'], 4) ?>
                                </code>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php if (count($positions) > 8): ?>
                <div class="text-center mt-3">
                    <small class="text-muted">Showing 8 of <?= count($positions) ?> locations</small>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- 🧾 Visitor Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light text-center">
                    <tr>
                        <th>ID</th>
                        <th>IP Address</th>
                        <th>Location Source</th>
                        <th>Accuracy</th>
                        <th>Precise Address</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Device</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php foreach (array_slice($logs, 0, 20) as $log): ?>
                    <tr>
                        <td><?= $log['id'] ?></td>
                        <td><?= $log['ip_address'] ?></td>
                        <td><span class="badge bg-<?= $log['location_type'] === 'GPS' ? 'success' : 'secondary' ?>"><?= $log['location_source'] ?></span></td>
                        <td><?= $log['accuracy'] ? $log['accuracy'] . 'm' : '-' ?></td>
                        <td><?= htmlspecialchars($log['precise_address'] ?? '-') ?></td>
                        <td><?= $log['city'] ?? '-' ?></td>
                        <td><?= $log['country'] ?? '-' ?></td>
                        <td><?= $log['device_type'] ?? '-' ?></td>
                        <td><?= date('Y-m-d H:i:s', strtotime($log['timestamp'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (count($logs) > 20): ?>
            <div class="text-center mt-3">
                <small class="text-muted">Showing 20 of <?= count($logs) ?> total logs</small>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Simple Google Maps loader
        function loadGoogleMaps() {
            const mapContainer = document.getElementById('mapContainer');
            mapContainer.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading Google Maps...</p>
                </div>
            `;

            // Load Google Maps API dynamically
            const script = document.createElement('script');
            script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyC5gMYj7gqRiwNlE6BxyLAdG9IMCCJZsrs';
            script.async = true;
            script.defer = true;
            
            script.onload = function() {
                initializeMap();
            };
            
            script.onerror = function() {
                mapContainer.innerHTML = `
                    <div class="map-placeholder">
                        <i class="fa-solid fa-exclamation-triangle text-warning"></i>
                        <h5>Failed to Load Google Maps</h5>
                        <p>Please check your API key or try again later</p>
                        <button class="btn btn-outline-secondary" onclick="location.reload()">
                            <i class="fa-solid fa-refresh"></i> Reload Page
                        </button>
                    </div>
                `;
            };
            
            document.head.appendChild(script);
        }

        function initializeMap() {
            const mapContainer = document.getElementById('mapContainer');
            const positions = <?= json_encode($positions, JSON_NUMERIC_CHECK) ?>;
            
            try {
                // Create map
                const map = new google.maps.Map(mapContainer, {
                    zoom: 4,
                    center: { lat: -15.78, lng: -47.93 }, // Center over Brazil
                    mapTypeId: "roadmap",
                    mapTypeControl: true,
                    streetViewControl: false,
                    fullscreenControl: true
                });

                // Add markers
                if (positions.length > 0) {
                    positions.forEach((pos, index) => {
                        const marker = new google.maps.Marker({
                            position: { lat: pos.lat, lng: pos.lng },
                            map: map,
                            title: `${pos.city}, ${pos.country}`,
                            label: (index + 1).toString()
                        });
                    });
                }

                mapContainer.innerHTML = ''; // Clear loading message
                mapContainer.appendChild(map.getDiv());
                
            } catch (error) {
                mapContainer.innerHTML = `
                    <div class="map-placeholder">
                        <i class="fa-solid fa-exclamation-triangle text-danger"></i>
                        <h5>Map Error</h5>
                        <p>${error.message}</p>
                        <button class="btn btn-outline-secondary" onclick="location.reload()">
                            <i class="fa-solid fa-refresh"></i> Reload Page
                        </button>
                    </div>
                `;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/javafx-buttons.js"></script>
    <script>
        // Enhanced button functionality
        function loadGoogleMaps() {
            const button = event.target;
            const mapContainer = document.getElementById('mapContainer');
            
            // Set button to loading state
            setButtonLoading(button, true);
            
            mapContainer.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading Google Maps...</p>
                </div>
            `;

            // Load Google Maps API dynamically
            const script = document.createElement('script');
            script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyC5gMYj7gqRiwNlE6BxyLAdG9IMCCJZsrs';
            script.async = true;
            script.defer = true;
            
            script.onload = function() {
                setTimeout(() => {
                    initializeMap();
                    setButtonSuccess(button, 'Maps Loaded!');
                }, 500);
            };
            
            script.onerror = function() {
                mapContainer.innerHTML = `
                    <div class="map-placeholder">
                        <i class="fa-solid fa-exclamation-triangle text-warning"></i>
                        <h5>Failed to Load Google Maps</h5>
                        <p>Please check your API key or try again later</p>
                        <button class="btn btn-outline-secondary btn-javafx" onclick="location.reload()">
                            <i class="fa-solid fa-refresh"></i> Reload Page
                        </button>
                    </div>
                `;
                setButtonError(button, 'Failed to Load');
            };
            
            document.head.appendChild(script);
        }

        function initializeMap() {
            const mapContainer = document.getElementById('mapContainer');
            const positions = <?= json_encode($positions, JSON_NUMERIC_CHECK) ?>;
            
            try {
                // Create map
                const map = new google.maps.Map(mapContainer, {
                    zoom: 4,
                    center: { lat: -15.78, lng: -47.93 }, // Center over Brazil
                    mapTypeId: "roadmap",
                    mapTypeControl: true,
                    streetViewControl: false,
                    fullscreenControl: true
                });

                // Add markers
                if (positions.length > 0) {
                    positions.forEach((pos, index) => {
                        const marker = new google.maps.Marker({
                            position: { lat: pos.lat, lng: pos.lng },
                            map: map,
                            title: `${pos.city}, ${pos.country}`,
                            label: (index + 1).toString()
                        });
                    });
                }

                mapContainer.innerHTML = ''; // Clear loading message
                mapContainer.appendChild(map.getDiv());
                
            } catch (error) {
                mapContainer.innerHTML = `
                    <div class="map-placeholder">
                        <i class="fa-solid fa-exclamation-triangle text-danger"></i>
                        <h5>Map Error</h5>
                        <p>${error.message}</p>
                        <button class="btn btn-outline-secondary btn-javafx" onclick="location.reload()">
                            <i class="fa-solid fa-refresh"></i> Reload Page
                        </button>
                    </div>
                `;
            }
        }
    </script>
</body>
</html>
