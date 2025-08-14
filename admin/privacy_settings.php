<?php
require_once('../config.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $show_location_messages = isset($_POST['show_location_messages']) ? 'true' : 'false';
    $show_tracking_ui = isset($_POST['show_tracking_ui']) ? 'true' : 'false';
    
    // Update config file
    $config_content = "<?php
// config.php

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'techeletric_ip_tools');
define('DB_USER', 'techeletric_ip_tools');
define('DB_PASS', 'zsP2rDZDaTea2YEhegmH');

// Privacy and Security Settings
define('SHOW_LOCATION_MESSAGES', $show_location_messages); // Set to false to hide location tracking messages
define('SHOW_TRACKING_UI', $show_tracking_ui); // Set to false to hide all tracking-related UI elements

// PDO connection function
function connectDB() {
    try {
        \$pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
            DB_USER,
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        return \$pdo;
    } catch (PDOException \$e) {
        die('❌ DB Connection Failed: ' . \$e->getMessage());
    }
}
?>";
    
    file_put_contents('../config.php', $config_content);
    $success_message = "Privacy settings updated successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Settings - Admin Panel</title>
    <link rel="icon" type="image/svg+xml" href="/projects/ip-tools/assets/favico.svg">
    <link rel="alternate icon" href="/projects/ip-tools/assets/favico.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white text-center">
                        <h4><i class="fa-solid fa-shield-halved"></i> Privacy & Security Settings</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success_message)): ?>
                            <div class="alert alert-success">
                                <i class="fa-solid fa-check-circle"></i> <?= $success_message ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-4">
                                <h5><i class="fa-solid fa-eye-slash"></i> User Interface Privacy</h5>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="show_location_messages" name="show_location_messages" 
                                           <?= SHOW_LOCATION_MESSAGES ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="show_location_messages">
                                        <strong>Show Location Tracking Messages</strong>
                                    </label>
                                    <div class="form-text">
                                        When disabled, users won't see messages about location tracking. 
                                        <span class="text-danger">Recommended for stealth operations.</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="show_tracking_ui" name="show_tracking_ui" 
                                           <?= SHOW_TRACKING_UI ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="show_tracking_ui">
                                        <strong>Show Tracking UI Elements</strong>
                                    </label>
                                    <div class="form-text">
                                        When disabled, all tracking-related UI elements are hidden.
                                        <span class="text-danger">Maximum stealth mode.</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="enable_stealth_redirect" name="enable_stealth_redirect" 
                                           <?= !SHOW_LOCATION_MESSAGES ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="enable_stealth_redirect">
                                        <strong>Enable Stealth Redirect</strong>
                                    </label>
                                    <div class="form-text">
                                        When enabled, users are redirected immediately without seeing any tracking page.
                                        <span class="text-danger">Maximum invisibility - users won't know they were tracked.</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info">
                                <h6><i class="fa-solid fa-info-circle"></i> Privacy Modes:</h6>
                                <ul class="mb-0">
                                    <li><strong>Normal Mode:</strong> Users see location tracking messages and UI</li>
                                    <li><strong>Stealth Mode:</strong> Location messages hidden, tracking still works</li>
                                    <li><strong>Maximum Stealth:</strong> All tracking UI hidden, completely invisible</li>
                                    <li><strong>Ultimate Stealth:</strong> Immediate redirect - users never see tracking page</li>
                                </ul>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-save"></i> Save Privacy Settings
                                </button>
                                <a href="/projects/ip-tools/index.php" class="btn btn-secondary">
                                    <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 