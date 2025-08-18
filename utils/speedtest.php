<?php
require_once('../config.php');
$db = connectDB();

// Handle speed test results submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $download_speed = $_POST['download_speed'] ?? 0;
    $upload_speed = $_POST['upload_speed'] ?? 0;
    $ping = $_POST['ping'] ?? 0;
    $jitter = $_POST['jitter'] ?? 0;
    $ip_address = $_SERVER['HTTP_CLIENT_IP'] 
        ?? $_SERVER['HTTP_X_FORWARDED_FOR'] 
        ?? $_SERVER['REMOTE_ADDR'] 
        ?? 'UNKNOWN';
    
    // Get location data
    $country = 'Unknown';
    $city = 'Unknown';
    try {
        $geo_url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$latitude}&lon={$longitude}&zoom=18&addressdetails=1";
        $geo_response = @file_get_contents($geo_url);
        if ($geo_response) {
            $geo_data = json_decode($geo_response, true);
            $country = $geo_data['address']['country'] ?? 'Unknown';
            $city = $geo_data['address']['city'] ?? $geo_data['address']['town'] ?? 'Unknown';
        }
    } catch (Exception $e) {
        // Continue without geocoding
    }
    
    // Save to database
    $stmt = $db->prepare("
        INSERT INTO speed_tests (
            ip_address, download_speed, upload_speed, ping, jitter,
            country, city, user_agent, timestamp
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    $stmt->execute([
        $ip_address, $download_speed, $upload_speed, $ping, $jitter,
        $country, $city, $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
    ]);
}

// Get recent test results
$recent_tests = $db->query("
    SELECT * FROM speed_tests 
    ORDER BY timestamp DESC 
    LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);

// Calculate average speeds
$avg_speeds = $db->query("
    SELECT 
        AVG(download_speed) as avg_download,
        AVG(upload_speed) as avg_upload,
        AVG(ping) as avg_ping,
        COUNT(*) as total_tests
    FROM speed_tests
")->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speed Test | Internet Performance</title>
    <link rel="icon" type="image/svg+xml" href="/projects/ip-tools/assets/favico.svg">
    <link rel="alternate icon" href="/projects/ip-tools/assets/favico.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .speed-card {
            border-left: 4px solid;
            transition: transform 0.2s;
        }
        .speed-card:hover {
            transform: translateY(-2px);
        }
        .speed-card.download { border-left-color: #28a745; }
        .speed-card.upload { border-left-color: #007bff; }
        .speed-card.ping { border-left-color: #ffc107; }
        .speed-value {
            font-size: 2rem;
            font-weight: bold;
        }
        .progress {
            height: 8px;
        }
        .test-status {
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .status-testing { background-color: #fff3cd; border: 1px solid #ffeaa7; }
        .status-complete { background-color: #d4edda; border: 1px solid #c3e6cb; }
        .status-error { background-color: #f8d7da; border: 1px solid #f5c6cb; }
    </style>
</head>
<body class="bg-light">
    <?php include('../header.php'); ?>
    
    <!-- DEMO MODE NOTICE -->
    <div class="container py-4">
        <div class="alert alert-warning text-center mb-4">
            <i class="fa-solid fa-triangle-exclamation fa-2x mb-2"></i>
            <h4>🚧 Demo Mode - Standalone Version</h4>
            <p class="mb-2">This is the standalone demo version of the application.</p>
            <p class="mb-0">
                <strong>For production use, please use the MVC version:</strong><br>
                <a href="/projects/ip-tools/public/" class="btn btn-primary mt-2">
                    <i class="fa-solid fa-external-link-alt"></i> Go to Production App
                </a>
            </p>
        </div>
    </div>

    <div class="container py-4">
        <h2 class="mb-4 text-center">
            <i class="fa-solid fa-gauge-high text-primary"></i> Internet Speed Test
        </h2>

        <!-- Speed Test Interface -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0"><i class="fa-solid fa-play-circle"></i> Start Speed Test</h5>
                    </div>
                    <div class="card-body text-center">
                        
                        <!-- Test Status -->
                        <div id="testStatus" class="test-status status-testing" style="display: none;">
                            <div class="text-center">
                                <div class="spinner-border text-warning" role="status">
                                    <span class="visually-hidden">Testing...</span>
                                </div>
                                <h5 class="mt-3" id="statusMessage">Initializing speed test...</h5>
                                <div class="progress mt-3">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                         role="progressbar" style="width: 0%" id="testProgress"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Results Display -->
                        <div id="resultsDisplay" style="display: none;">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="card speed-card download">
                                        <div class="card-body text-center">
                                            <h6 class="text-success"><i class="fa-solid fa-download"></i> Download</h6>
                                            <div class="speed-value text-success" id="downloadResult">0</div>
                                            <small class="text-muted">Mbps</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card speed-card upload">
                                        <div class="card-body text-center">
                                            <h6 class="text-primary"><i class="fa-solid fa-upload"></i> Upload</h6>
                                            <div class="speed-value text-primary" id="uploadResult">0</div>
                                            <small class="text-muted">Mbps</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card speed-card ping">
                                        <div class="card-body text-center">
                                            <h6 class="text-warning"><i class="fa-solid fa-clock"></i> Ping</h6>
                                            <div class="speed-value text-warning" id="pingResult">0</div>
                                            <small class="text-muted">ms</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Start Button -->
                        <div id="startSection">
                            <p class="text-muted mb-4">Test your internet connection speed with our advanced speed test tool.</p>
                            <button class="btn btn-primary btn-lg" onclick="startSpeedTest()">
                                <i class="fa-solid fa-play"></i> Start Speed Test
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row g-4 mt-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="text-success"><?= number_format($avg_speeds['avg_download'] ?? 0, 1) ?></h3>
                        <p class="mb-0"><i class="fa-solid fa-download text-success"></i> Avg Download (Mbps)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="text-primary"><?= number_format($avg_speeds['avg_upload'] ?? 0, 1) ?></h3>
                        <p class="mb-0"><i class="fa-solid fa-upload text-primary"></i> Avg Upload (Mbps)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="text-warning"><?= number_format($avg_speeds['avg_ping'] ?? 0, 0) ?></h3>
                        <p class="mb-0"><i class="fa-solid fa-clock text-warning"></i> Avg Ping (ms)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="text-info"><?= $avg_speeds['total_tests'] ?? 0 ?></h3>
                        <p class="mb-0"><i class="fa-solid fa-chart-line text-info"></i> Total Tests</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Tests -->
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fa-solid fa-history"></i> Recent Speed Tests</h5>
            </div>
            <div class="card-body">
                <?php if (empty($recent_tests)): ?>
                    <p class="text-muted text-center">No speed tests recorded yet.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Download (Mbps)</th>
                                    <th>Upload (Mbps)</th>
                                    <th>Ping (ms)</th>
                                    <th>Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_tests as $test): ?>
                                    <tr>
                                        <td><?= date('M j, H:i', strtotime($test['timestamp'])) ?></td>
                                        <td>
                                            <span class="badge bg-success"><?= number_format($test['download_speed'], 1) ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"><?= number_format($test['upload_speed'], 1) ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning"><?= number_format($test['ping'], 0) ?></span>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($test['city']) ?>, <?= htmlspecialchars($test['country']) ?>
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
        let testInProgress = false;
        let testResults = { download: 0, upload: 0, ping: 0 };

        function startSpeedTest() {
            if (testInProgress) return;
            
            testInProgress = true;
            document.getElementById('startSection').style.display = 'none';
            document.getElementById('testStatus').style.display = 'block';
            document.getElementById('resultsDisplay').style.display = 'none';
            
            // Simulate speed test phases
            runTestPhase('ping', 'Testing ping...', 0, 100, 2000);
        }

        function runTestPhase(phase, message, start, end, duration) {
            const statusMessage = document.getElementById('statusMessage');
            const progressBar = document.getElementById('testProgress');
            
            statusMessage.textContent = message;
            
            let progress = start;
            const increment = (end - start) / (duration / 50);
            
            const interval = setInterval(() => {
                progress += increment;
                progressBar.style.width = Math.min(progress, end) + '%';
                
                if (progress >= end) {
                    clearInterval(interval);
                    
                    // Simulate test result
                    const result = Math.random() * 100 + 10; // 10-110 range
                    testResults[phase] = result;
                    
                    // Move to next phase or complete
                    if (phase === 'ping') {
                        runTestPhase('download', 'Testing download speed...', 100, 200, 3000);
                    } else if (phase === 'download') {
                        runTestPhase('upload', 'Testing upload speed...', 200, 300, 2500);
                    } else {
                        completeTest();
                    }
                }
            }, 50);
        }

        function completeTest() {
            testInProgress = false;
            
            // Hide test status
            document.getElementById('testStatus').style.display = 'none';
            
            // Show results
            document.getElementById('downloadResult').textContent = testResults.download.toFixed(1);
            document.getElementById('uploadResult').textContent = testResults.upload.toFixed(1);
            document.getElementById('pingResult').textContent = testResults.ping.toFixed(0);
            document.getElementById('resultsDisplay').style.display = 'block';
            
            // Show start section again
            document.getElementById('startSection').style.display = 'block';
            
            // Submit results to server
            submitResults();
        }

        function submitResults() {
            const formData = new FormData();
            formData.append('download_speed', testResults.download);
            formData.append('upload_speed', testResults.upload);
            formData.append('ping', testResults.ping);
            formData.append('jitter', Math.random() * 5 + 1); // Random jitter
            
            fetch('save_speed_test.php', {
                method: 'POST',
                body: formData
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Speed test results saved');
                    // Reload page to show updated statistics
                    setTimeout(() => location.reload(), 2000);
                }
            }).catch(error => {
                console.error('Error saving results:', error);
            });
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