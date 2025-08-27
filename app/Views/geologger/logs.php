<?php
// Ensure all required variables are set with defaults
$stats = $stats ?? [];
$logs = $logs ?? [];
$heatmapData = $heatmapData ?? [];
$pagination = $pagination ?? [];

// Set default values for stats
$stats = array_merge([
    'total_clicks' => 0,
    'active_links' => 0,
    'unique_visitors' => 0,
    'gps_clicks' => 0
], $stats);
?>
<style>
    .device-icon {
        vertical-align: middle;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        transition: transform 0.2s ease;
    }
    
    .device-icon:hover {
        transform: scale(1.1);
    }
    
    .device-label {
        font-size: 0.85rem;
        color: #6c757d;
        margin-left: 0.5rem;
    }
    
    .device-display {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .device-stats-card .d-flex > div {
        text-align: center;
        min-width: 60px;
    }
    
    .device-stats-card .d-flex > div small {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa-solid fa-chart-line"></i> Visitor Logs Dashboard</h4>
                </div>
                <div class="card-body">
                    <!-- Statistics Cards -->
                    <div class="row g-4 text-center mb-4">
                        <div class="col-md-2">
                            <div class="card p-3 border-primary">
                                <h5><i class="fa-solid fa-mouse-pointer text-primary"></i> Total Clicks</h5>
                                <h3><?= $stats['total_clicks'] ?? 0 ?></h3>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card p-3 border-success">
                                <h5><i class="fa-solid fa-link text-success"></i> Active Links</h5>
                                <h3><?= $stats['active_links'] ?? 0 ?></h3>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card p-3 border-info">
                                <h5><i class="fa-solid fa-user-check text-info"></i> Unique Visitors</h5>
                                <h3><?= $stats['unique_visitors'] ?? 0 ?></h3>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card p-3 border-warning">
                                <h5><i class="fa-solid fa-map-marker-alt text-warning"></i> GPS Tracking</h5>
                                <h3><?= $stats['gps_clicks'] ?? 0 ?></h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-3 border-info device-stats-card">
                                <h5><i class="fa-solid fa-mobile-alt text-info"></i> Device Types</h5>
                                <?php 
                                // Simple device counting without DeviceHelper for now
                                $deviceStats = ['mobile' => 0, 'desktop' => 0, 'tablet' => 0];
                                foreach ($logs as $log) {
                                    $userAgent = strtolower($log['user_agent'] ?? '');
                                    if (stripos($userAgent, 'mobile') !== false || stripos($userAgent, 'android') !== false || stripos($userAgent, 'iphone') !== false) {
                                        $deviceStats['mobile']++;
                                    } elseif (stripos($userAgent, 'windows') !== false || stripos($userAgent, 'macintosh') !== false || stripos($userAgent, 'linux') !== false) {
                                        $deviceStats['desktop']++;
                                    } else {
                                        $deviceStats['tablet']++;
                                    }
                                }
                                ?>
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="me-3">
                                        <i class="fa-solid fa-mobile-alt text-primary" style="font-size: 24px;"></i>
                                        <small class="d-block"><?= $deviceStats['mobile'] ?></small>
                                    </div>
                                    <div class="me-3">
                                        <i class="fa-solid fa-desktop text-success" style="font-size: 24px;"></i>
                                        <small class="d-block"><?= $deviceStats['desktop'] ?></small>
                                    </div>
                                    <div>
                                        <i class="fa-solid fa-tablet-alt text-info" style="font-size: 24px;"></i>
                                        <small class="d-block"><?= $deviceStats['tablet'] ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Heatmap -->
                    <h5 class="mb-3">
                        <i class="fa-solid fa-map-location-dot"></i> Visitor Heatmap
                        <span class="badge bg-info ms-2" id="heatmapCount"><?= count($heatmapData) ?> locations</span>
                    </h5>
                    
                    <?php if (!empty($heatmapData)): ?>
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
                    
                    <div id="map" style="width:100%; height:500px;" class="border rounded shadow-sm mb-4">
                        <?php if (empty($heatmapData)): ?>
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <div class="text-center text-muted">
                                    <i class="fa-solid fa-map-marked-alt fa-3x mb-3"></i>
                                    <h5>No location data available</h5>
                                    <p>Tracking links need to be clicked to generate heatmap data.</p>
                                    <a href="<?= $view->url('geologger/create') ?>" class="btn btn-primary">
                                        <i class="fa-solid fa-plus"></i> Create Tracking Link
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Search and Filter -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="search" class="form-control" id="searchInput" 
                                   placeholder="🔍 Filter by IP, location, device...">
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="<?= $view->url('geologger/create') ?>" class="btn btn-primary">
                                <i class="fa-solid fa-plus"></i> Create New Link
                            </a>
                            <a href="<?= $view->url('geologger/my-links') ?>" class="btn btn-info ms-2">
                                <i class="fa-solid fa-link"></i> Ver Meus Links
                            </a>
                        </div>
                    </div>

                    <!-- Logs Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>ID</th>
                                    <th>Short Code</th>
                                    <th>IP Address</th>
                                    <th>Location Source</th>
                                    <th>Accuracy</th>
                                    <th>Precise Address</th>
                                    <th>City</th>
                                    <th>Country</th>
                                    <th>Device</th>
                                    <th>Timestamp</th>
                                    <th>Original URL</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php foreach ($logs as $log): ?>
                                <tr>
                                    <td><?= $log['id'] ?></td>
                                    <td><code><?= $log['short_code'] ?></code></td>
                                    <td><?= $log['ip_address'] ?></td>
                                    <td>
                                        <span class="badge bg-<?= $log['location_type'] === 'GPS' ? 'success' : 'secondary' ?>">
                                            <?= $log['location_source'] ?>
                                        </span>
                                    </td>
                                    <td><?= $log['accuracy'] ? $log['accuracy'] . 'm' : '-' ?></td>
                                    <td><?= htmlspecialchars($log['precise_address'] ?? '-') ?></td>
                                    <td><?= $log['city'] ?? '-' ?></td>
                                    <td><?= $log['country'] ?? '-' ?></td>
                                    <td>
                                        <?php 
                                        // Simple device display without DeviceHelper for now
                                        $userAgent = $log['user_agent'] ?? '';
                                        if (stripos($userAgent, 'mobile') !== false || stripos($userAgent, 'android') !== false || stripos($userAgent, 'iphone') !== false) {
                                            echo '<i class="fa-solid fa-mobile-alt text-primary me-2"></i> Mobile';
                                        } elseif (stripos($userAgent, 'windows') !== false || stripos($userAgent, 'macintosh') !== false || stripos($userAgent, 'linux') !== false) {
                                            echo '<i class="fa-solid fa-desktop text-success me-2"></i> Desktop';
                                        } else {
                                            echo '<i class="fa-solid fa-question-circle text-muted me-2"></i> Unknown';
                                        }
                                        ?>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($log['timestamp'])) ?></td>
                                    <td>
                                        <a href="<?= htmlspecialchars($log['original_url']) ?>" target="_blank" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-external-link-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if (isset($pagination) && isset($pagination['total_pages']) && $pagination['total_pages'] > 1): ?>
                    <nav aria-label="Logs pagination">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                            <li class="page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Google Maps Script -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5gMYj7gqRiwNlE6BxyLAdG9IMCCJZsrs&libraries=visualization"></script>

<script>
const heatmapData = <?= json_encode($heatmapData, JSON_NUMERIC_CHECK) ?>;

function initMap() {
    try {
        console.log('Initializing Google Maps...');
        console.log('Heatmap data:', heatmapData);
        console.log('Heatmap data length:', heatmapData ? heatmapData.length : 'null');
        console.log('Map container element:', document.getElementById("map"));
        
        // Debug: Show the structure of the first few items
        if (heatmapData && heatmapData.length > 0) {
            console.log('First 3 heatmap items:', heatmapData.slice(0, 3));
            console.log('Sample item structure:', Object.keys(heatmapData[0]));
        }
        
        // Set initial map center based on data
        let center = { lat: -15.78, lng: -47.93 }; // Default to Brazil
        let zoom = 4;
        
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: zoom,
            center: center,
            mapTypeId: "roadmap",
            mapTypeControl: true,
            streetViewControl: true,
            fullscreenControl: true
        });
        
        if (heatmapData && heatmapData.length > 0) {
            // Validate heatmap data structure
            const validData = heatmapData.filter(loc => {
                return loc && typeof loc.lat === 'number' && typeof loc.lng === 'number' && 
                       !isNaN(loc.lat) && !isNaN(loc.lng) && 
                       loc.lat !== 0 && loc.lng !== 0;
            });
            
            if (validData.length === 0) {
                console.warn('No valid coordinate data found in heatmap data');
                document.getElementById('map').innerHTML = `
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="text-center text-muted">
                            <i class="fa-solid fa-map-marked-alt fa-3x mb-3"></i>
                            <h5>No valid location data available</h5>
                            <p>All coordinates in the database are invalid or missing.</p>
                            <a href="<?= $view->url('geologger/create') ?>" class="btn btn-primary">
                                <i class="fa-solid fa-plus"></i> Create Tracking Link
                            </a>
                        </div>
                    </div>
                `;
                return;
            }
            
            // Calculate center based on valid data
            const bounds = new google.maps.LatLngBounds();
            validData.forEach(loc => {
                bounds.extend(new google.maps.LatLng(loc.lat, loc.lng));
            });
            
            center = bounds.getCenter();
            map.fitBounds(bounds);
            zoom = 3; // Adjust zoom based on data spread
            
            // Create heatmap with valid data
            const heatmap = new google.maps.visualization.HeatmapLayer({
                data: validData.map(loc => new google.maps.LatLng(loc.lat, loc.lng)),
                radius: 25,
                opacity: 0.8,
                dissipating: true
            });
            heatmap.setMap(map);
            
            // Store reference for controls
            heatmapLayer = heatmap;
            
            // Add markers for individual points with info windows
            validData.forEach((loc, index) => {
                const marker = new google.maps.Marker({
                    position: new google.maps.LatLng(loc.lat, loc.lng),
                    map: map,
                    title: `${loc.city || 'Unknown'}, ${loc.country || 'Unknown'}`,
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
            
            console.log('Heatmap created successfully with', validData.length, 'valid points');
            
            // Update the count badge
            const countBadge = document.getElementById('heatmapCount');
            if (countBadge) {
                countBadge.textContent = `${validData.length} locations`;
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

document.getElementById("searchInput").addEventListener("keyup", filterLogs);
</script> 