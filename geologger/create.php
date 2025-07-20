<?php
require_once('../config.php');
require_once('../libs/phpqrcode/qrlib.php');
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
        $short_code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);

        $stmt = $db->prepare("INSERT INTO geo_links (original_url, short_code) VALUES (?, ?)");
        $stmt->execute([$original_url, $short_code]);

        $tracking_link = "https://tech-eletric.com.br/ip-tools/geologger/track.php?code=" . $short_code;

        $qr_folder = '../assets/qrcodes/';
        if (!file_exists($qr_folder)) {
            mkdir($qr_folder, 0755, true);
        }

        $qr_filename = $qr_folder . $short_code . '.png';
        QRcode::png($tracking_link, $qr_filename, QR_ECLEVEL_L, 4);
        $qr_img_tag = "<img src='$qr_filename' alt='QR Code for $tracking_link' title='QR Code' class='img-fluid mt-3'>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Tracking Link</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light text-center">
  <?php include('../header.php'); ?>

  <div class="container py-4">
    <h2 class="mb-4"><i class="fa-solid fa-map-pin text-primary"></i> Geolocation Tracker</h2>

    <form method="POST" class="mb-4">
      <div class="input-group mb-3 justify-content-center">
        <input type="text" name="original_url" class="form-control w-50" placeholder="e.g. https://example.com" required>
        <button type="submit" class="btn btn-success">Generate Link</button>
      </div>
    </form>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php elseif ($tracking_link): ?>
      <div class="card p-4 shadow-sm">
        <h5><i class="fa-solid fa-link"></i> Link Generated:</h5>
        <p class="fw-bold text-break"><?= $tracking_link ?></p>
        <button class="btn btn-secondary mb-3" onclick="copyLink()">
          <i class="fa-solid fa-copy"></i> Copy to Clipboard
        </button>
        <h6><i class="fa-solid fa-qrcode"></i> QR Code:</h6>
        <?= $qr_img_tag ?>
      </div>
    <?php endif; ?>

    <a href="logs.php" class="btn btn-outline-primary mt-4">
      <i class="fa-solid fa-chart-bar"></i> View Tracking Logs
    </a>
  </div>

  <?php include('../footer.php'); ?>

  <script>
    function copyLink() {
      const link = document.querySelector('.fw-bold').textContent;
      navigator.clipboard.writeText(link);
      alert("✅ Link copied to clipboard!");
    }

    // Theme toggle logic
    const body = document.body;
    const btn = document.getElementById('toggleTheme');
    if (localStorage.getItem('theme') === 'dark') {
      body.classList.add('bg-dark', 'text-light');
    }
    btn?.addEventListener('click', () => {
      body.classList.toggle('bg-dark');
      body.classList.toggle('text-light');
      localStorage.setItem('theme', body.classList.contains('bg-dark') ? 'dark' : 'light');
    });
  </script>
</body>
</html>
