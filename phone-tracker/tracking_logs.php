<?php
require_once('../config.php');
$db = connectDB();

// Get tracking statistics
$total_sent = $db->query("SELECT COUNT(*) FROM phone_tracking")->fetchColumn();
$total_clicks = $db->query("SELECT COUNT(*) FROM phone_clicks")->fetchColumn();
$unique_phones = $db->query("SELECT COUNT(DISTINCT phone_number) FROM phone_tracking")->fetchColumn();

// Get all tracking data with click counts
$tracking_data = $db->query("
    SELECT pt.*, COUNT(pc.id) as click_count,
           MIN(pc.timestamp) as first_click,
           MAX(pc.timestamp) as last_click
    FROM phone_tracking pt 
    LEFT JOIN phone_clicks pc ON pt.tracking_code = pc.tracking_code 
    GROUP BY pt.id 
    ORDER BY pt.created_at DESC
")->fetchAll(PDO::FETCH_ASSOC);

// Get recent clicks
$recent_clicks = $db->query("
    SELECT pc.*, pt.phone_number, pt.message_text, pt.original_url
    FROM phone_clicks pc
    JOIN phone_tracking pt ON pc.tracking_code = pt.tracking_code
    ORDER BY pc.timestamp DESC
    LIMIT 20
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Tracking Logs | SMS Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .stats-card {
            border-left: 4px solid;
        }
        .stats-card.primary { border-left-color: #007bff; }
        .stats-card.success { border-left-color: #28a745; }
        .stats-card.info { border-left-color: #17a2b8; }
        .click-row:hover {
            background-color: #f8f9fa;
        }
        .phone-number {
            font-family: monospace;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-light">
    <?php include('../header.php'); ?>

    <div class="container py-4">
        <h2 class="mb-4 text-center">
            <i class="fa-solid fa-chart-line text-primary"></i> Phone Tracking Analytics
        </h2>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card stats-card primary">
                    <div class="card-body text-center">
                        <h3 class="text-primary"><?= $total_sent ?></h3>
                        <p class="mb-0"><i class="fa-solid fa-paper-plane"></i> SMS Sent</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stats-card success">
                    <div class="card-body text-center">
                        <h3 class="text-success"><?= $total_clicks ?></h3>
                        <p class="mb-0"><i class="fa-solid fa-mouse-pointer"></i> Total Clicks</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stats-card info">
                    <div class="card-body text-center">
                        <h3 class="text-info"><?= $unique_phones ?></h3>
                        <p class="mb-0"><i class="fa-solid fa-phone"></i> Unique Phones</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tracking Data Table -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fa-solid fa-list"></i> All Tracking Links</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Phone Number</th>
                                <th>Message</th>
                                <th>Original URL</th>
                                <th>Tracking Code</th>
                                <th>Clicks</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tracking_data as $track): ?>
                                <tr class="click-row">
                                    <td>
                                        <span class="phone-number"><?= htmlspecialchars($track['phone_number']) ?></span>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;" title="<?= htmlspecialchars($track['message_text']) ?>">
                                            <?= htmlspecialchars($track['message_text']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;" title="<?= htmlspecialchars($track['original_url']) ?>">
                                            <a href="<?= htmlspecialchars($track['original_url']) ?>" target="_blank">
                                                <?= htmlspecialchars($track['original_url']) ?>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <code><?= $track['tracking_code'] ?></code>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $track['click_count'] > 0 ? 'success' : 'secondary' ?>">
                                            <?= $track['click_count'] ?> clicks
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $track['status'] === 'clicked' ? 'success' : 'warning' ?>">
                                            <?= ucfirst($track['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?= date('M j, Y H:i', strtotime($track['created_at'])) ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" onclick="copyTrackingLink('<?= $track['tracking_link'] ?>')">
                                            <i class="fa-solid fa-copy"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Clicks -->
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fa-solid fa-clock"></i> Recent Clicks</h5>
            </div>
            <div class="card-body">
                <?php if (empty($recent_clicks)): ?>
                    <p class="text-muted text-center">No clicks recorded yet.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Phone</th>
                                    <th>IP Address</th>
                                    <th>Location</th>
                                    <th>Device</th>
                                    <th>Clicked At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_clicks as $click): ?>
                                    <tr>
                                        <td>
                                            <span class="phone-number"><?= htmlspecialchars($click['phone_number']) ?></span>
                                        </td>
                                        <td>
                                            <code><?= htmlspecialchars($click['ip_address']) ?></code>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($click['city']) ?>, <?= htmlspecialchars($click['country']) ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?= $click['device_type'] === 'Mobile' ? 'primary' : 'secondary' ?>">
                                                <?= $click['device_type'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= date('M j, H:i', strtotime($click['timestamp'])) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include('../footer.php'); ?>

    <script>
        function copyTrackingLink(link) {
            navigator.clipboard.writeText(link);
            alert("✅ Tracking link copied to clipboard!");
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