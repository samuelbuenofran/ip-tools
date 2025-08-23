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

// Get IP
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

// Geolocation API (adjust to your provider)
$geo = @json_decode(@file_get_contents("https://ipwho.is/{$ip}"), true);

// Insert log
$insertStmt = $db->prepare("
  INSERT INTO geo_logs (ip_address, user_agent, referrer, country, city, latitude, longitude, accuracy, location_type, link_id, device_type, timestamp)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
");

$insertStmt->execute([
  $ip,
  $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown Agent',
  $referrerLabel,
  $geo['country'] ?? null,
  $geo['city'] ?? null,
  $geo['latitude'] ?? null,
  $geo['longitude'] ?? null,
  $geo['accuracy'] ?? null,
  'IP', // Default to IP-based location
  $link['id'],
  preg_match('/mobile/i', $_SERVER['HTTP_USER_AGENT']) ? 'Mobile' : 'Desktop'
]);

// Update click count
$db->prepare("UPDATE geo_links SET click_count = click_count + 1 WHERE id = ?")->execute([$link['id']]);

// Write debug log
$logPath = __DIR__ . '/geo_debug.log';
file_put_contents($logPath, json_encode([
  'ip' => $ip,
  'lat' => $geo['latitude'] ?? 'null',
  'lon' => $geo['longitude'] ?? 'null',
  'referrer' => $referrerLabel,
  'status' => $geo['success'] ?? 'unknown'
]) . PHP_EOL, FILE_APPEND);

// Redirect to destination
header("Location: " . $link['original_url']);
exit;

?>
