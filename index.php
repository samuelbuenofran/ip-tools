<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>IP Tools Suite</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    .card:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      transform: scale(1.02);
      transition: 0.2s;
    }
    .icon {
      font-size: 2.5rem;
      color: #007bff;
      margin-bottom: 1rem;
    }
    .card-title {
      font-weight: bold;
    }
  </style>
</head>
<body class="bg-light">
  <?php include('header.php'); ?>

  <div class="container">
  <?php
// Database connection
$db = connectDB();

// Total clicks from geo_logs
$totalClicks = $db->query("SELECT COUNT(*) FROM geo_logs")->fetchColumn();

// Active links from geo_links
$activeLinks = $db->query("SELECT COUNT(*) FROM geo_links WHERE expires_at IS NULL OR expires_at > NOW()")->fetchColumn();

// Unique visitors by IP
$uniqueIPs = $db->query("SELECT COUNT(DISTINCT ip_address) FROM geo_logs")->fetchColumn();
?>
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

    <h2 class="text-center mb-4"><i class="fa-solid fa-toolbox"></i> Welcome to the IP Tools Suite</h2>
    <div class="row g-4">

      <div class="col-md-4">
        <a href="/projects/ip-tools/geologger/create.php" class="text-decoration-none">
          <div class="card p-4 text-center h-100">
            <div class="icon"><i class="fa-solid fa-map-pin"></i></div>
            <h5 class="card-title">Geolocation Tracker</h5>
            <p>Create location-aware links that log visitor activity.</p>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="/projects/ip-tools/network-tools/logs.php" class="text-decoration-none">
          <div class="card p-4 text-center h-100">
            <div class="icon"><i class="fa-solid fa-chart-bar"></i></div>
            <h5 class="card-title">Logs Dashboard</h5>
            <p>View logs and heatmaps of tracked clicks.</p>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="/projects/ip-tools/phone-tracker/send_sms.php" class="text-decoration-none">
          <div class="card p-4 text-center h-100">
            <div class="icon"><i class="fa-solid fa-mobile-screen-button"></i></div>
            <h5 class="card-title">Phone Tracker</h5>
            <p>Send SMS links and capture click activity.</p>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="/projects/ip-tools/network-tools/ipinfo.php" class="text-decoration-none">
          <div class="card p-4 text-center h-100">
            <div class="icon"><i class="fa-solid fa-globe"></i></div>
            <h5 class="card-title">IP Info Viewer</h5>
            <p>Look up details about any IP address instantly.</p>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="/projects/ip-tools/generators/card-gen.php" class="text-decoration-none">
          <div class="card p-4 text-center h-100">
            <div class="icon"><i class="fa-solid fa-credit-card"></i></div>
            <h5 class="card-title">Card Generator</h5>
            <p>Generate realistic mock credit cards for testing.</p>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="/projects/ip-tools/utils/speedtest.php" class="text-decoration-none">
          <div class="card p-4 text-center h-100">
            <div class="icon"><i class="fa-solid fa-gauge-high"></i></div>
            <h5 class="card-title">Speed Test</h5>
            <p>Measure your internet speed with quick diagnostics.</p>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="/projects/ip-tools/theme-demo.php" class="text-decoration-none">
          <div class="card p-4 text-center h-100">
            <div class="icon"><i class="fa-solid fa-palette"></i></div>
            <h5 class="card-title">Theme Demo</h5>
            <p>Explore the four different themes available in the suite.</p>
          </div>
        </a>
      </div>

    </div>
  </div>
	
  <?php include('footer.php'); ?>
  
  <script>
  // Theme system is now handled by theme-switcher.js
  // The old theme toggle has been replaced with a comprehensive theme selector
  </script>

  
</body>
</html>
