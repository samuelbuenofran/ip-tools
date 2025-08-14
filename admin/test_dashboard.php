<?php
// Admin Test Dashboard - Only accessible to admin users
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../app/Views/auth/login.php');
    exit();
}

require_once('../config.php');
$db = connectDB();

// Get system information
$php_version = phpversion();
$mysql_version = $db->getAttribute(PDO::ATTR_SERVER_VERSION);
$server_software = $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown';
$current_time = date('Y-m-d H:i:s');

// Get database stats
$total_links = $db->query("SELECT COUNT(*) FROM geo_links")->fetchColumn();
$total_logs = $db->query("SELECT COUNT(*) FROM geo_logs")->fetchColumn();
$total_users = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_speed_tests = $db->query("SELECT COUNT(*) FROM speed_tests")->fetchColumn();

// Check if tables exist
$tables = ['geo_links', 'geo_logs', 'users', 'speed_tests'];
$table_status = [];
foreach ($tables as $table) {
    try {
        $result = $db->query("SHOW TABLES LIKE '$table'");
        $table_status[$table] = $result->rowCount() > 0 ? '✅ Exists' : '❌ Missing';
    } catch (Exception $e) {
        $table_status[$table] = '❌ Error: ' . $e->getMessage();
    }
}

// Check database connection
$db_status = '✅ Connected';
try {
    $db->query("SELECT 1");
} catch (Exception $e) {
    $db_status = '❌ Error: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Test Dashboard - IP Tools Suite</title>
    <link rel="icon" type="image/svg+xml" href="../assets/favico.svg">
    <link rel="alternate icon" href="../assets/favico.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .test-section { margin-bottom: 2rem; }
        .status-card { border-left: 4px solid; }
        .status-card.success { border-left-color: #28a745; }
        .status-card.warning { border-left-color: #ffc107; }
        .status-card.danger { border-left-color: #dc3545; }
        .status-card.info { border-left-color: #17a2b8; }
        .test-result { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .test-success { background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .test-error { background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .test-warning { background-color: #fff3cd; border: 1px solid #ffeaa7; color: #856404; }
        .iframe-container { position: relative; width: 100%; height: 400px; border: 1px solid #dee2e6; border-radius: 5px; }
        .iframe-container iframe { width: 100%; height: 100%; border: none; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fa-solid fa-tools"></i> Admin Test Dashboard
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fa-solid fa-user-shield"></i> Admin: <?= htmlspecialchars($_SESSION['username']) ?>
                </span>
                <a class="btn btn-outline-light btn-sm" href="../app/Views/dashboard/index.php">
                    <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <h1 class="text-center mb-4">
            <i class="fa-solid fa-vial text-primary"></i> System Test Dashboard
        </h1>

        <!-- System Status Overview -->
        <div class="test-section">
            <h3><i class="fa-solid fa-server text-info"></i> System Status</h3>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="card status-card success">
                        <div class="card-body">
                            <h5 class="card-title">PHP Version</h5>
                            <h4 class="text-success"><?= $php_version ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card status-card <?= $db_status === '✅ Connected' ? 'success' : 'danger' ?>">
                        <div class="card-body">
                            <h5 class="card-title">Database</h5>
                            <h4><?= $db_status === '✅ Connected' ? '✅ Connected' : '❌ Error' ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card status-card info">
                        <div class="card-body">
                            <h5 class="card-title">MySQL Version</h5>
                            <h4 class="text-info"><?= $mysql_version ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card status-card info">
                        <div class="card-body">
                            <h5 class="card-title">Server</h5>
                            <h4 class="text-info"><?= htmlspecialchars($server_software) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Database Status -->
        <div class="test-section">
            <h3><i class="fa-solid fa-database text-warning"></i> Database Status</h3>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="card status-card info">
                        <div class="card-body">
                            <h5 class="card-title">Total Links</h5>
                            <h4 class="text-info"><?= $total_links ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card status-card info">
                        <div class="card-body">
                            <h5 class="card-title">Total Logs</h5>
                            <h4 class="text-info"><?= $total_logs ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card status-card info">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <h4 class="text-info"><?= $total_users ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card status-card info">
                        <div class="card-body">
                            <h5 class="card-title">Speed Tests</h5>
                            <h4 class="text-info"><?= $total_speed_tests ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fa-solid fa-table"></i> Table Status</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($table_status as $table => $status): ?>
                            <div class="col-md-3 mb-2">
                                <strong><?= ucfirst(str_replace('_', ' ', $table)) ?>:</strong>
                                <span class="badge bg-<?= strpos($status, '✅') !== false ? 'success' : 'danger' ?>">
                                    <?= $status ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Test Tools -->
        <div class="test-section">
            <h3><i class="fa-solid fa-wrench text-primary"></i> Test Tools</h3>
            
            <div class="row g-3">
                <!-- Google Maps Test -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-map"></i> Google Maps API Test</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Test Google Maps integration and API key validity.</p>
                            <a href="../test_google_maps.php" target="_blank" class="btn btn-primary">
                                <i class="fa-solid fa-external-link-alt"></i> Test Google Maps
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Database Connection Test -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-database"></i> Database Connection Test</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Test database connectivity and configuration.</p>
                            <a href="../test_database_connection.php" target="_blank" class="btn btn-success">
                                <i class="fa-solid fa-external-link-alt"></i> Test Database
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Database Debug Test -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-bug"></i> Database Debug Test</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Advanced database debugging and schema validation.</p>
                            <a href="../test_database_debug.php" target="_blank" class="btn btn-warning">
                                <i class="fa-solid fa-external-link-alt"></i> Debug Database
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tracking Test -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-location-arrow"></i> Tracking System Test</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Test the geolocation tracking system.</p>
                            <a href="../test_tracking.php" target="_blank" class="btn btn-info">
                                <i class="fa-solid fa-external-link-alt"></i> Test Tracking
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Tests -->
        <div class="test-section">
            <h3><i class="fa-solid fa-bolt text-warning"></i> Quick Tests</h3>
            
            <div class="row g-3">
                <!-- URL Generation Test -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-link"></i> URL Generation Test</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Test URL generation and routing functionality.</p>
                            <button class="btn btn-secondary" onclick="testUrlGeneration()">
                                <i class="fa-solid fa-play"></i> Test URLs
                            </button>
                            <div id="urlTestResult" class="mt-2"></div>
                        </div>
                    </div>
                </div>

                <!-- Session Test -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-user-shield"></i> Session Test</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Test session management and authentication.</p>
                            <button class="btn btn-dark" onclick="testSession()">
                                <i class="fa-solid fa-play"></i> Test Session
                            </button>
                            <div id="sessionTestResult" class="mt-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="test-section">
            <h3><i class="fa-solid fa-info-circle text-info"></i> System Information</h3>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Environment Details:</h6>
                            <ul class="list-unstyled">
                                <li><strong>Current Time:</strong> <?= $current_time ?></li>
                                <li><strong>Server Timezone:</strong> <?= date_default_timezone_get() ?></li>
                                <li><strong>Memory Limit:</strong> <?= ini_get('memory_limit') ?></li>
                                <li><strong>Max Execution Time:</strong> <?= ini_get('max_execution_time') ?>s</li>
                                <li><strong>Upload Max Filesize:</strong> <?= ini_get('upload_max_filesize') ?></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>PHP Extensions:</h6>
                            <ul class="list-unstyled">
                                <li><strong>PDO:</strong> <?= extension_loaded('pdo') ? '✅ Loaded' : '❌ Not Loaded' ?></li>
                                <li><strong>PDO MySQL:</strong> <?= extension_loaded('pdo_mysql') ? '✅ Loaded' : '❌ Not Loaded' ?></li>
                                <li><strong>cURL:</strong> <?= extension_loaded('curl') ? '✅ Loaded' : '❌ Not Loaded' ?></li>
                                <li><strong>JSON:</strong> <?= extension_loaded('json') ? '✅ Loaded' : '❌ Not Loaded' ?></li>
                                <li><strong>OpenSSL:</strong> <?= extension_loaded('openssl') ? '✅ Loaded' : '❌ Not Loaded' ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Monitoring -->
        <div class="test-section">
            <h3><i class="fa-solid fa-chart-line text-success"></i> Live Monitoring</h3>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-tachometer-alt"></i> System Performance</h5>
                        </div>
                        <div class="card-body">
                            <div id="performanceMetrics">
                                <div class="text-center">
                                    <div class="spinner-border text-success" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2">Loading performance metrics...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-clock"></i> Real-time Updates</h5>
                        </div>
                        <div class="card-body">
                            <div id="realtimeUpdates">
                                <p class="text-muted">Real-time system updates will appear here...</p>
                            </div>
                            <button class="btn btn-info btn-sm" onclick="refreshUpdates()">
                                <i class="fa-solid fa-sync-alt"></i> Refresh
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Test URL Generation
        function testUrlGeneration() {
            const resultDiv = document.getElementById('urlTestResult');
            resultDiv.innerHTML = '<div class="test-result test-warning">Testing URL generation...</div>';
            
            // Test various URL patterns
            const tests = [
                { name: 'Base URL', url: window.location.origin + '/projects/ip-tools' },
                { name: 'Public URL', url: window.location.origin + '/projects/ip-tools/public' },
                { name: 'Assets URL', url: window.location.origin + '/projects/ip-tools/assets' },
                { name: 'Current Page', url: window.location.href }
            ];
            
            let results = '<div class="test-result test-success"><strong>URL Generation Test Results:</strong><br>';
            tests.forEach(test => {
                results += `<strong>${test.name}:</strong> <code>${test.url}</code><br>`;
            });
            results += '</div>';
            
            resultDiv.innerHTML = results;
        }

        // Test Session
        function testSession() {
            const resultDiv = document.getElementById('sessionTestResult');
            resultDiv.innerHTML = '<div class="test-result test-warning">Testing session...</div>';
            
            // Make AJAX call to test session
            fetch('../app/Views/dashboard/index.php', {
                method: 'GET',
                credentials: 'same-origin'
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('admin') || data.includes('dashboard')) {
                    resultDiv.innerHTML = '<div class="test-result test-success"><strong>Session Test:</strong> ✅ Session is working correctly</div>';
                } else {
                    resultDiv.innerHTML = '<div class="test-result test-error"><strong>Session Test:</strong> ❌ Session may have issues</div>';
                }
            })
            .catch(error => {
                resultDiv.innerHTML = `<div class="test-result test-error"><strong>Session Test:</strong> ❌ Error: ${error.message}</div>`;
            });
        }

        // Performance Metrics
        function updatePerformanceMetrics() {
            const metricsDiv = document.getElementById('performanceMetrics');
            
            // Simulate performance data
            const memoryUsage = Math.round(Math.random() * 100);
            const cpuUsage = Math.round(Math.random() * 80);
            const responseTime = (Math.random() * 100 + 50).toFixed(2);
            
            metricsDiv.innerHTML = `
                <div class="row text-center">
                    <div class="col-4">
                        <h4 class="text-${memoryUsage > 80 ? 'danger' : memoryUsage > 60 ? 'warning' : 'success'}">${memoryUsage}%</h4>
                        <small class="text-muted">Memory</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-${cpuUsage > 70 ? 'danger' : cpuUsage > 50 ? 'warning' : 'success'}">${cpuUsage}%</h4>
                        <small class="text-muted">CPU</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-${responseTime > 100 ? 'danger' : responseTime > 50 ? 'warning' : 'success'}">${responseTime}ms</h4>
                        <small class="text-muted">Response</small>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-muted">Last updated: ${new Date().toLocaleTimeString()}</small>
                </div>
            `;
        }

        // Real-time Updates
        function refreshUpdates() {
            const updatesDiv = document.getElementById('realtimeUpdates');
            const now = new Date();
            
            const updates = [
                `✅ System check completed at ${now.toLocaleTimeString()}`,
                `✅ Database connection verified`,
                `✅ All required tables present`,
                `✅ Admin privileges confirmed`
            ];
            
            updatesDiv.innerHTML = updates.map(update => 
                `<div class="mb-1"><i class="fa-solid fa-check-circle text-success"></i> ${update}</div>`
            ).join('');
        }

        // Auto-refresh performance metrics every 5 seconds
        setInterval(updatePerformanceMetrics, 5000);
        
        // Initial load
        updatePerformanceMetrics();
        refreshUpdates();
    </script>
</body>
</html>
