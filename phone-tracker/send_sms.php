<?php
require_once('../config.php');
$db = connectDB();

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone_number = trim($_POST['phone_number']);
    $message_text = trim($_POST['message_text']);
    $link_url = trim($_POST['link_url']);
    
    // Validate phone number (basic validation)
    if (empty($phone_number)) {
        $error = "Please enter a phone number.";
    } elseif (!preg_match('/^\+?[1-9]\d{1,14}$/', preg_replace('/[^0-9+]/', '', $phone_number))) {
        $error = "Please enter a valid phone number.";
    } elseif (empty($message_text)) {
        $error = "Please enter a message.";
    } elseif (empty($link_url)) {
        $error = "Please enter a URL to track.";
    } else {
        // Generate tracking code
        $tracking_code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
        
        // Create tracking link
        $tracking_link = "https://keizai-tech.com/projects/ip-tools/phone-tracker/track.php?code=" . $tracking_code;
        
        // Store in database
        $stmt = $db->prepare("INSERT INTO phone_tracking (phone_number, message_text, original_url, tracking_code, tracking_link, status) VALUES (?, ?, ?, ?, ?, 'pending')");
        $stmt->execute([$phone_number, $message_text, $link_url, $tracking_code, $tracking_link]);
        
        $message = "SMS tracking link created successfully!";
    }
}

// Get recent tracking history
$recent_tracks = $db->query("
    SELECT pt.*, COUNT(pc.id) as click_count 
    FROM phone_tracking pt 
    LEFT JOIN phone_clicks pc ON pt.tracking_code = pc.tracking_code 
    GROUP BY pt.id 
    ORDER BY pt.created_at DESC 
    LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Tracker | SMS Link Tracking</title>
    <link rel="icon" type="image/svg+xml" href="/projects/ip-tools/assets/favico.svg">
    <link rel="alternate icon" href="/projects/ip-tools/assets/favico.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .tracking-card {
            border-left: 4px solid #007bff;
        }
        .tracking-card.clicked {
            border-left-color: #28a745;
        }
        .phone-number {
            font-family: monospace;
            font-weight: bold;
        }
        .status-badge {
            font-size: 0.8rem;
        }
    </style>
</head>
<body class="bg-light">
    <?php include('../header.php'); ?>

    <div class="container py-4">
        <h2 class="mb-4 text-center">
            <i class="fa-solid fa-mobile-screen-button text-primary"></i> Phone Tracker
        </h2>
        
        <div class="row">
            <!-- SMS Form -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fa-solid fa-paper-plane"></i> Send SMS with Tracking</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                        
                        <?php if ($message): ?>
                            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">
                                    <i class="fa-solid fa-phone"></i> Phone Number
                                </label>
                                <input type="tel" class="form-control" id="phone_number" name="phone_number" 
                                       placeholder="+1234567890" required>
                                <div class="form-text">Include country code (e.g., +1 for US)</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="message_text" class="form-label">
                                    <i class="fa-solid fa-comment"></i> Message
                                </label>
                                <textarea class="form-control" id="message_text" name="message_text" rows="3" 
                                          placeholder="Check out this amazing link!" required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="link_url" class="form-label">
                                    <i class="fa-solid fa-link"></i> URL to Track
                                </label>
                                <input type="url" class="form-control" id="link_url" name="link_url" 
                                       placeholder="https://example.com" required>
                                <div class="form-text">This URL will be replaced with a tracking link</div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa-solid fa-paper-plane"></i> Send SMS with Tracking
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Recent Tracking -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fa-solid fa-history"></i> Recent Tracking</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($recent_tracks)): ?>
                            <p class="text-muted text-center">No tracking history yet.</p>
                        <?php else: ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($recent_tracks as $track): ?>
                                    <div class="list-group-item tracking-card <?= $track['click_count'] > 0 ? 'clicked' : '' ?>">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="phone-number"><?= htmlspecialchars($track['phone_number']) ?></div>
                                                <div class="text-muted small"><?= htmlspecialchars($track['message_text']) ?></div>
                                                <div class="text-muted small">
                                                    <i class="fa-solid fa-link"></i> 
                                                    <?= htmlspecialchars(substr($track['original_url'], 0, 50)) ?>...
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-<?= $track['click_count'] > 0 ? 'success' : 'secondary' ?> status-badge">
                                                    <?= $track['click_count'] ?> clicks
                                                </span>
                                                <div class="text-muted small">
                                                    <?= date('M j, H:i', strtotime($track['created_at'])) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- View All Tracking -->
        <div class="text-center mt-4">
            <a href="tracking_logs.php" class="btn btn-outline-primary">
                <i class="fa-solid fa-chart-bar"></i> View All Tracking Logs
            </a>
        </div>
    </div>

    <?php include('../footer.php'); ?>

    <script>
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
