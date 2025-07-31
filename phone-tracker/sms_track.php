<?php

require_once('../config.php');

$db = connectDB();

// ?? Get code from query
$code = $_GET['code'] ?? '';
if ($code === '') {
  die('? Missing tracking code.');
}

// ?? Lookup SMS link entry
$stmt = $db->prepare("SELECT * FROM sms_links WHERE short_code = ?");
$stmt->execute([$code]);
$link = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$link) {
  die('? Invalid code.');
}

// ?? Stop double logging
if ($link['clicked']) {
  header("Location: " . $link['original_url']);
  exit;
}

// ?? IP detection
function getUserIP() {
  return $_SERVER['HTTP_CLIENT_IP']
    ?? $_SERVER['HTTP_X_FORWARDED_FOR']
    ?? $_SERVER['REMOTE_ADDR']
    ?? 'UNKNOWN';
}
$ip = getUserIP();

// ?? Geo IP lookup
$geo = @json_decode(@file_get_contents("https://ipwho.is/{$ip}"), true);

// ?? Device detection
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$deviceType = preg_match('/mobile/i', $userAgent) ? 'Mobile' : 'Desktop';

// ?? Referrer
$referrer = $_SERVER['HTTP_REFERER'] ?? 'Direct';

// ?? Update sms_links with log info
$updateStmt = $db->prepare("
  UPDATE sms_links
  SET clicked = 1,
      click_time = NOW(),
      ip_address = ?,
      country = ?,
      city = ?,
      device_type = ?,
      user_agent = ?,
      timestamp = NOW()
  WHERE id = ?
");

$updateStmt->execute([
  $ip,
  $geo['country'] ?? null,
  $geo['city'] ?? null,
  $deviceType,
  $userAgent,
  $link['id']
]);

// ?? Write debug log
$logPath = __DIR__ . '/sms_debug.log';
file_put_contents($logPath, json_encode([
  'code' => $code,
  'ip' => $ip,
  'country' => $geo['country'] ?? 'Unknown',
  'city' => $geo['city'] ?? 'Unknown',
  'device' => $deviceType,
  'referrer' => $referrer,
  'timestamp' => date('Y-m-d H:i:s')
]) . PHP_EOL, FILE_APPEND);

// ?? Redirect to destination
header("Location: " . $link['original_url']);
exit;

?>
