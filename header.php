<?php
require_once('config.php');

// Language setting - Portuguese by default, English only in dev mode
$current_lang = 'pt';
if ($DEV_MODE && $DEV_LANGUAGE === 'en') {
    $current_lang = 'en';
}
?>
<!-- Unified styles for consistent layout across all pages -->
<link href="/projects/ip-tools/assets/unified-styles.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4" style="color: #ffffff !important;">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="/projects/ip-tools/index.php" style="color: #ffffff !important;">
      <img src="/projects/ip-tools/assets/iptoolssuite-logo.png" alt="IP Tools Suite Logo" height="40" class="me-2">
      IP Tools Suite
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
	

    <div class="collapse navbar-collapse" id="navbarNav">
		<ul class="navbar-nav ms-auto">
			<?php if ($DEV_MODE): ?>
			<li class="nav-item">
				<span class="navbar-text me-3" style="color: #ffffff !important;">
					<i class="fa-solid fa-code"></i> DEV: <?= strtoupper($current_lang) ?>
				</span>
			</li>
			<?php endif; ?>
        <li class="nav-item"><a class="nav-link" href="/projects/ip-tools/geolocation-tracker-info.php" style="color: #ffffff !important;"><i class="fa-solid fa-map-pin"></i> <span data-translate="nav_geologger">Geolocation Tracker</span></a></li>
        <li class="nav-item"><a class="nav-link" href="/projects/ip-tools/logs-dashboard-info.php" style="color: #ffffff !important;"><i class="fa-solid fa-chart-line"></i> <span data-translate="nav_logs">Logs Dashboard</span></a></li>
        <li class="nav-item"><a class="nav-link" href="/projects/ip-tools/phone-tracker-info.php" style="color: #ffffff !important;"><i class="fa-solid fa-mobile-screen-button"></i> <span data-translate="nav_phone_tracker">Phone Tracker</span></a></li>
        <li class="nav-item"><a class="nav-link" href="/projects/ip-tools/speed-test-info.php" style="color: #ffffff !important;"><i class="fa-solid fa-gauge-high"></i> <span data-translate="nav_speed_test">Speed Test</span></a></li>
        <li class="nav-item"><a class="nav-link" href="/projects/ip-tools/settings.php" style="color: #ffffff !important;"><i class="fa-solid fa-cog"></i> <span data-translate="settings">Settings</span></a></li>
      </ul>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
