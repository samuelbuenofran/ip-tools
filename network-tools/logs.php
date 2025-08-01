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
  <h2 class="mb-4 text-center">
    <i class="fa-solid fa-list-check text-primary"></i> <span data-translate="visitor_log_dashboard">Visitor Log Dashboard</span>
  </h2>

  <!-- 📈 Stats Cards -->
  <div class="row g-4 text-center mb-4">
    <div class="col-md-4">
      <div class="card p-3 border-primary">
        <h5><i class="fa-solid fa-mouse-pointer text-primary"></i> <span data-translate="total_clicks">Total Clicks</span></h5>
        <h3><?= $totalClicks ?></h3>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-3 border-success">
        <h5><i class="fa-solid fa-link text-success"></i> <span data-translate="active_links">Active Links</span></h5>
        <h3><?= $activeLinks ?></h3>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-3 border-info">
        <h5><i class="fa-solid fa-user-check text-info"></i> <span data-translate="unique_visitors">Unique Visitors</span></h5>
        <h3><?= $uniqueIPs ?></h3>
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
</div>

<!-- 🌐 Google Maps Script -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5gMYj7gqRiwNlE6BxyLAdG9IMCCJZsrs&libraries=visualization">
</script>

<script>
  const heatmapData = <?= json_encode($positions, JSON_NUMERIC_CHECK) ?>;

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
      console.log("✅ Heatmap rendered:", heatmapData);
    } else {
      console.warn("⚠️ No heatmap points available.");
    }
  }

  window.onload = initMap;
</script>

<?php include('../footer.php'); ?>
