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

            $stmt = $db->prepare("INSERT INTO geo_links (original_url, short_code) VALUES (?, ?)");
            $stmt->execute([$original_url, $short_code]);

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
    <h2 class="mb-4" data-translate="create_tracking_link"><i class="fa-solid fa-map-pin text-primary"></i> Geolocation Tracker</h2>

    <form method="POST" class="mb-4">
      <div class="input-group mb-3 justify-content-center">
        <input type="text" name="original_url" class="form-control w-50" data-translate-placeholder="enter_url_placeholder" placeholder="e.g. https://example.com" required>
        <button type="submit" class="btn btn-success" data-translate="generate_link">Generate Link</button>
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
  </div>

  <?php include('../footer.php'); ?>

  <script>
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
