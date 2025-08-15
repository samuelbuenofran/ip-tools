<?php
require_once('../config.php');
$db = connectDB();

// Fetch log data with associated links
$stmt = $db->query("
  SELECT g.id, g.ip_address, g.user_agent, g.referrer, g.country, g.city,
         g.device_type, g.timestamp, l.short_code, l.original_url
  FROM geo_logs g
  JOIN geo_links l ON g.link_id = l.id
  ORDER BY g.timestamp DESC
");
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare heatmap positions
$positions = [];
foreach ($logs as $log) {
  $geo = @json_decode(file_get_contents("http://ip-api.com/json/{$log['ip_address']}"), true);
  if (!empty($geo['lat']) && !empty($geo['lon'])) {
    $positions[] = ['lat' => $geo['lat'], 'lng' => $geo['lon']];
  }
}
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
    <h2 class="mb-4 text-center"><i class="fa-solid fa-list-check text-primary"></i> Visitor Log Dashboard</h2>

    <h4 class="mb-3"><i class="fa-solid fa-map-location-dot"></i> Visitor Heatmap</h4>
    <div id="map" class="map-container rounded border"></div>

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
        
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 2,
          center: { lat: 0, lng: 0 },
          mapTypeId: "roadmap"
        });
        
        console.log('Map created successfully');

        if (heatmapData && heatmapData.length > 0) {
          const heatmap = new google.maps.visualization.HeatmapLayer({
            data: heatmapData.map(loc => new google.maps.LatLng(loc.lat, loc.lng)),
            radius: 20
          });
          heatmap.setMap(map);
          console.log('Heatmap created successfully with', heatmapData.length, 'points');
        } else {
          console.warn('No heatmap data available');
        }
      } catch (error) {
        console.error('Error initializing map:', error);
        document.getElementById('map').innerHTML = '<div style="padding: 20px; text-align: center; color: red;">Error loading map: ' + error.message + '</div>';
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

    // Theme system is now handled by theme-switcher.js
    // The old theme toggle has been replaced with a comprehensive theme selector
  </script>
</body>
</html>
