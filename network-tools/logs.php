<?php
require_once('../config.php');
include('../header.php');

$db = connectDB();

// Fetch logs from database (now including latitude and longitude)
$logs = $db->query("SELECT * FROM geo_logs ORDER BY timestamp DESC")->fetchAll(PDO::FETCH_ASSOC);

// Dashboard stats
$totalClicks = $db->query("SELECT COUNT(*) FROM geo_logs")->fetchColumn();
$activeLinks = $db->query("SELECT COUNT(*) FROM geo_links WHERE expires_at IS NULL OR expires_at > NOW()")->fetchColumn();
$uniqueIPs   = $db->query("SELECT COUNT(DISTINCT ip_address) FROM geo_logs")->fetchColumn();

// Heatmap coordinates (use stored latitude/longitude)
$positions = [];
foreach ($logs as $log) {
  if (!empty($log['latitude']) && !empty($log['longitude'])) {
    $positions[] = ['lat' => (float)$log['latitude'], 'lng' => (float)$log['longitude']];
  }
}
?>
<div class="container py-4">
  <h2 class="mb-4 text-center"><i class="fa-solid fa-list-check text-primary"></i> Visitor Log Dashboard</h2>

  <!-- Stats overview -->
  <div class="row g-4 text-center mb-4">
    <div class="col-md-4">
      <div class="card p-3 border-primary">
        <h5><i class="fa-solid fa-mouse-pointer text-primary"></i> Total Clicks</h5>
        <h3><?= $totalClicks ?></h3>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-3 border-success">
        <h5><i class="fa-solid fa-link text-success"></i> Active Links</h5>
        <h3><?= $activeLinks ?></h3>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-3 border-info">
        <h5><i class="fa-solid fa-user-check text-info"></i> Unique Visitors</h5>
        <h3><?= $uniqueIPs ?></h3>
      </div>
    </div>
  </div>

  <!-- Visitor table -->
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-light text-center">
        <tr>
          <th>ID</th>
          <th>IP Address</th>
          <th>City</th>
          <th>Country</th>
          <th>Device</th>
          <th>Referrer</th>
          <th>Timestamp</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <?php foreach ($logs as $log): ?>
        <tr>
          <td><?= $log['id'] ?></td>
          <td><?= $log['ip_address'] ?></td>
          <td><?= $log['city'] ?? '-' ?></td>
          <td><?= $log['country'] ?? '-' ?></td>
          <td><?= $log['device_type'] ?? '-' ?></td>
          <td><?= htmlspecialchars($log['referrer']) ?></td>
          <td><?= date('Y-m-d H:i:s', strtotime($log['timestamp'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Heatmap -->
  <h4 class="mt-5"><i class="fa-solid fa-map-location-dot"></i> Click Heatmap</h4>
  <div id="map" style="width:100%; height:500px;" class="border rounded shadow-sm mb-5"></div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5gMYj7gqRiwNlE6BxyLAdG9IMCCJZsrs&libraries=visualization"></script>
<script>
  const heatmapData = <?= json_encode($positions) ?>;

  function initMap() {
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 2,
      center: { lat: 0, lng: 0 },
      mapTypeId: "roadmap"
    });

    if (heatmapData.length > 0) {
      const heatmap = new google.maps.visualization.HeatmapLayer({
        data: heatmapData.map(p => new google.maps.LatLng(p.lat, p.lng)),
        radius: 20
      });
      heatmap.setMap(map);
    }
  }

  window.onload = initMap;
</script>

<?php include('../footer.php'); ?>
