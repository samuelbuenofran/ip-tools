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
                        <div class="col-md-3">
                            <div class="card p-3 border-primary">
                                <h5><i class="fa-solid fa-mouse-pointer text-primary"></i> Total Clicks</h5>
                                <h3><?= $stats['total_clicks'] ?? 0 ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-3 border-success">
                                <h5><i class="fa-solid fa-link text-success"></i> Active Links</h5>
                                <h3><?= $stats['active_links'] ?? 0 ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-3 border-info">
                                <h5><i class="fa-solid fa-user-check text-info"></i> Unique Visitors</h5>
                                <h3><?= $stats['unique_visitors'] ?? 0 ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-3 border-warning">
                                <h5><i class="fa-solid fa-map-marker-alt text-warning"></i> GPS Tracking</h5>
                                <h3><?= $stats['gps_tracking'] ?? 0 ?></h3>
                            </div>
                        </div>
                    </div>

                    <!-- Heatmap -->
                    <h5 class="mb-3"><i class="fa-solid fa-map-location-dot"></i> Visitor Heatmap</h5>
                    <div id="map" style="width:100%; height:500px;" class="border rounded shadow-sm mb-4"></div>

                    <!-- Search and Filter -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="search" class="form-control" id="searchInput" 
                                   placeholder="🔍 Filter by IP, location, device...">
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="<?= $this->url('geologger/create') ?>" class="btn btn-primary">
                                <i class="fa-solid fa-plus"></i> Create New Link
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
                                    <td><?= $log['device_type'] ?? '-' ?></td>
                                    <td><?= $this->formatDate($log['timestamp']) ?></td>
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
                    <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
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
<script src="https://maps.googleapis.com/maps/api/js?key=<?= App::GOOGLE_MAPS_API_KEY ?>&libraries=visualization"></script>

<script>
const heatmapData = <?= json_encode($heatmapData, JSON_NUMERIC_CHECK) ?>;

function initMap() {
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 4,
        center: { lat: -15.78, lng: -47.93 }, // Center over Brazil
        mapTypeId: "roadmap"
    });

    if (Array.isArray(heatmapData) && heatmapData.length > 0) {
        const heatmap = new google.maps.visualization.HeatmapLayer({
            data: heatmapData.map(p => new google.maps.LatLng(p.lat, p.lng)),
            radius: 20
        });
        heatmap.setMap(map);
        console.log("✅ Heatmap rendered:", heatmapData.length, "points");
    } else {
        console.warn("⚠️ No heatmap points available.");
    }
}

window.onload = initMap;

function filterLogs() {
    const query = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("tbody tr");
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(query) ? "" : "none";
    });
}

document.getElementById("searchInput").addEventListener("keyup", filterLogs);
</script> 