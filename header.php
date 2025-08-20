<?php
require_once('config.php');

// Language setting - English by default, Portuguese only in dev mode
$current_lang = 'en';
if ($DEV_MODE && $DEV_LANGUAGE === 'pt') {
    $current_lang = 'pt';
}
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="/projects/ip-tools/assets/themes.css" rel="stylesheet">
<link href="/projects/ip-tools/assets/navbar-fixes.css" rel="stylesheet">
<link href="/projects/ip-tools/assets/dropdown-simple-fix.css" rel="stylesheet">
<script src="/projects/ip-tools/assets/theme-switcher.js" defer></script>
<script src="/projects/ip-tools/assets/dropdown-simple-fix.js" defer></script>
<script src="/projects/ip-tools/assets/translations.js" defer></script>

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
        <li class="nav-item"><a class="nav-link" href="/projects/ip-tools/geologger/create.php" style="color: #ffffff !important;"><i class="fa-solid fa-map-pin"></i> <span data-translate="nav_geologger">Geolocation Tracker</span></a></li>
        <li class="nav-item"><a class="nav-link" href="/projects/ip-tools/network-tools/logs.php" style="color: #ffffff !important;"><i class="fa-solid fa-chart-line"></i> <span data-translate="nav_logs">Logs Dashboard</span></a></li>
        <li class="nav-item"><a class="nav-link" href="/projects/ip-tools/phone-tracker/send_sms.php" style="color: #ffffff !important;"><i class="fa-solid fa-mobile-screen-button"></i> <span data-translate="nav_phone_tracker">Phone Tracker</span></a></li>
        <li class="nav-item"><a class="nav-link" href="/projects/ip-tools/utils/speedtest.php" style="color: #ffffff !important;"><i class="fa-solid fa-gauge-high"></i> <span data-translate="nav_speed_test">Speed Test</span></a></li>
        <li class="nav-item"><a class="nav-link" href="/projects/ip-tools/settings.php" style="color: #ffffff !important;"><i class="fa-solid fa-cog"></i> <span data-translate="settings">Settings</span></a></li>
      </ul>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
