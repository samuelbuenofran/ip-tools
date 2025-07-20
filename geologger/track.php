<?php
require_once('../config.php');
$db = connectDB();

// ✅ Sanitize tracking code
$code = isset($_GET['code']) ? trim($_GET['code']) : '';
if ($code === '') {
  die("❌ Invalid tracking code.");
}

// ✅ Fetch link metadata
$stmt = $db->prepare("
  SELECT id, original_url, expires_at, click_limit, click_count
  FROM geo_links
  WHERE short_code = ?
  LIMIT 1
");
$stmt->execute([$code]);
$link = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$link) {
  die("❌ Tracking link not found.");
}

// ✅ Expiration & limit logic
$expired   = $link['expires_at'] && strtotime($link['expires_at']) < time();
$maxClicks = $link['click_limit'] && $link['click_count'] >= $link['click_limit'];

if ($expired || $maxClicks) {
  $reason = $expired ? 'expired' : 'limit_reached';
  $db->prepare("INSERT INTO geo_alerts (link_id, reason, timestamp) VALUES (?, ?, NOW())")
     ->execute([$link['id'], $reason]);
  header("Location: expired.php");
  exit;
}

// ✅ Capture visitor info
$ip         = $_SERVER['REMOTE_ADDR'];
$userAgent  = $_SERVER['HTTP_USER_AGENT'] ?? '';
$referrer   = $_SERVER['HTTP_REFERER'] ?? '';
$deviceType = preg_match('/mobile|android|iphone|tablet/i', $userAgent) ? 'Mobile' : 'Desktop';

// ✅ Fetch geolocation
$geo = @json_decode(file_get_contents("http://ip-api.com/json/$ip"), true);
$country   = $geo['country'] ?? null;
$city      = $geo['city'] ?? null;
$latitude  = $geo['lat'] ?? null;
$longitude = $geo['lon'] ?? null;

// ✅ Insert into geo_logs
$stmt = $db->prepare("
  INSERT INTO geo_logs
  (ip_address, user_agent, referrer, country, city, latitude, longitude, link_id, device_type, timestamp)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
");
$stmt->execute([
  $ip, $userAgent, $referrer,
  $country, $city, $latitude, $longitude,
  $link['id'], $deviceType
]);

// ✅ Update click count
$db->prepare("UPDATE geo_links SET click_count = click_count + 1 WHERE id = ?")->execute([$link['id']]);

// ✅ Redirect to original destination
header("Location: " . $link['original_url']);
exit;
?>
