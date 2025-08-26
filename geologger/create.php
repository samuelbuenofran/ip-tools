<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../config.php');
// require_once('../libs/phpqrcode/qrlib.php'); // Temporarily disabled due to compatibility issues
$db = connectDB();

$tracking_link = '';
$qr_img_tag = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $original_url = trim($_POST['original_url']);

    if (!preg_match('/^https?:\/\//i', $original_url)) {
        $original_url = 'https://' . $original_url;
        $original_url = trim($original_url);
    }

    if (!filter_var($original_url, FILTER_VALIDATE_URL)) {
        $error = "<i class='fa-solid fa-triangle-exclamation'></i> Please enter a valid URL.";
    } else {
        try {
            $short_code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);

            // Handle expiration settings
            $expires_at = null;
            if (!isset($_POST['no_expiration']) || $_POST['no_expiration'] != '1') {
                if (!empty($_POST['expires_at'])) {
                    $expires_at = $_POST['expires_at'];
                }
            }
            
            // Handle click limit
            $click_limit = null;
            if (!empty($_POST['click_limit']) && is_numeric($_POST['click_limit'])) {
                $click_limit = (int)$_POST['click_limit'];
            }

            $stmt = $db->prepare("INSERT INTO geo_links (original_url, short_code, expires_at, click_limit) VALUES (?, ?, ?, ?)");
            $stmt->execute([$original_url, $short_code, $expires_at, $click_limit]);

            $tracking_link = "https://keizai-tech.com/projects/ip-tools/geologger/precise_track.php?code=" . $short_code;
        } catch (Exception $e) {
            $error = "<i class='fa-solid fa-triangle-exclamation'></i> Database error: " . $e->getMessage();
        }

        // Generate QR code using online service
        $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($tracking_link);
        $qr_img_tag = "<img src='$qr_url' alt='QR Code for $tracking_link' title='QR Code' class='qr-code-img mt-3'>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Create Tracking Link</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/svg+xml" href="/projects/ip-tools/assets/favico.svg">
  <link rel="alternate icon" href="/projects/ip-tools/assets/favico.svg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    .qr-code-img {
      max-width: 300px;
      max-height: 300px;
      width: auto;
      height: auto;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 10px;
      background: white;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .qr-code-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 20px 0;
    }
    
    @media (max-width: 768px) {
      .qr-code-img {
        max-width: 250px;
        max-height: 250px;
      }
    }
  </style>
</head>
<body class="bg-light text-center">
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

    <h2 class="mb-4" data-translate="create_tracking_link"><i class="fa-solid fa-map-pin text-primary"></i> Geolocation Tracker</h2>

    <form method="POST" class="mb-4">
      <div class="input-group mb-3 justify-content-center">
        <input type="text" name="original_url" class="form-control w-50" data-translate-placeholder="enter_url_placeholder" placeholder="e.g. https://example.com" required>
        <button type="submit" class="btn btn-success" data-translate="generate_link">Generate Link</button>
      </div>
      
      <!-- New expiration options -->
      <div class="row justify-content-center mb-3">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h6 class="card-title"><i class="fa-solid fa-clock"></i> Expiration Settings</h6>
              
              <!-- Checkbox for no expiration -->
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="noExpiration" name="no_expiration" value="1">
                <label class="form-check-label" for="noExpiration">
                  <strong>Meu link não expira</strong> (My link doesn't expire)
                </label>
              </div>
              
              <!-- Date picker (hidden when no expiration is checked) -->
              <div id="expirationDateGroup" class="mb-3">
                <label for="expires_at" class="form-label">
                  <i class="fa-solid fa-calendar"></i> Expira em (Expires on):
                </label>
                <input type="datetime-local" class="form-control" id="expires_at" name="expires_at" 
                       min="<?= date('Y-m-d\TH:i') ?>" 
                       value="<?= date('Y-m-d\TH:i', strtotime('+30 days')) ?>">
                <div class="form-text">Deixe em branco para não expirar (Leave blank to never expire)</div>
              </div>
              
              <!-- Click limit -->
              <div class="mb-3">
                <label for="click_limit" class="form-label">
                  <i class="fa-solid fa-mouse-pointer"></i> Limite de cliques (Click limit):
                </label>
                <input type="number" class="form-control" id="click_limit" name="click_limit" 
                       min="1" max="10000" placeholder="Sem limite (No limit)">
                <div class="form-text">Deixe em branco para sem limite (Leave blank for no limit)</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php elseif ($tracking_link): ?>
      <div class="card p-4 shadow-sm">
        <h5 data-translate="link_generated"><i class="fa-solid fa-link"></i> Link Generated:</h5>
        <p class="fw-bold text-break"><?= $tracking_link ?></p>
        <button class="btn btn-secondary mb-3" onclick="copyLink()" data-translate="copy_to_clipboard">
          <i class="fa-solid fa-copy"></i> Copy to Clipboard
        </button>
        <button class="btn btn-info mb-3" onclick="downloadQR()" data-translate="download_qr">
          <i class="fa-solid fa-download"></i> Download QR Code
        </button>
        <h6 data-translate="qr_code"><i class="fa-solid fa-qrcode"></i> QR Code:</h6>
        <div class="qr-code-container">
          <?= $qr_img_tag ?>
        </div>
      </div>
    <?php endif; ?>

    <a href="/projects/ip-tools/network-tools/logs.php" class="btn btn-outline-primary mt-4" data-translate="tracking_logs">
      <i class="fa-solid fa-chart-bar"></i> View Tracking Logs
    </a>
    
    <a href="my_links.php" class="btn btn-outline-info mt-4 ms-2">
      <i class="fa-solid fa-link"></i> Ver Meus Links
    </a>
  </div>

  <?php include('../footer.php'); ?>

  <script>
    // Handle expiration checkbox
    document.addEventListener('DOMContentLoaded', function() {
        const noExpirationCheckbox = document.getElementById('noExpiration');
        const expirationDateGroup = document.getElementById('expirationDateGroup');
        
        if (noExpirationCheckbox && expirationDateGroup) {
            // Initial state
            updateExpirationVisibility();
            
            // Listen for changes
            noExpirationCheckbox.addEventListener('change', updateExpirationVisibility);
        }
        
        function updateExpirationVisibility() {
            if (noExpirationCheckbox.checked) {
                expirationDateGroup.style.display = 'none';
                // Clear the date value when hidden
                document.getElementById('expires_at').value = '';
            } else {
                expirationDateGroup.style.display = 'block';
                // Set default date if empty
                if (!document.getElementById('expires_at').value) {
                    const defaultDate = new Date();
                    defaultDate.setDate(defaultDate.getDate() + 30);
                    document.getElementById('expires_at').value = defaultDate.toISOString().slice(0, 16);
                }
            }
        }
    });
    
    function copyLink() {
      const link = document.querySelector('.fw-bold').textContent;
      navigator.clipboard.writeText(link);
      alert(getText('link_copied'));
    }
    
    function downloadQR() {
      const qrImg = document.querySelector('.qr-code-img');
      if (qrImg) {
        // Create a canvas to download the QR code
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = 200;
        canvas.height = 200;
        
        // Create a new image to avoid CORS issues
        const img = new Image();
        img.crossOrigin = 'anonymous';
        img.onload = function() {
          ctx.drawImage(img, 0, 0, 200, 200);
          canvas.toBlob(function(blob) {
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.download = 'tracking-qr-code.png';
            link.href = url;
            link.click();
            URL.revokeObjectURL(url);
          });
        };
        img.src = qrImg.src;
      }
    }

    // Theme system is now handled by theme-switcher.js
    // The old theme toggle has been replaced with a comprehensive theme selector
  </script>
</body>
</html>
