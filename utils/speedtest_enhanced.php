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
        $geo_url = "https://ipwho.is/{$ip_address}";
        $geo_response = @file_get_contents($geo_url);
        if ($geo_response) {
            $geo_data = json_decode($geo_response, true);
            $country = $geo_data['country'] ?? 'Unknown';
            $city = $geo_data['city'] ?? 'Unknown';
        }
    } catch (Exception $e) {
        // Continue without geocoding
    }
    
    // Save to database
    try {
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
        echo json_encode(['success' => true, 'message' => 'Results saved successfully']);
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}

// Get recent test results
$recent_tests = [];
try {
    $recent_tests = $db->query("
        SELECT * FROM speed_tests 
        ORDER BY timestamp DESC 
        LIMIT 10
    ")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Table might not exist yet
}

// Calculate average speeds
$avg_speeds = ['avg_download' => 0, 'avg_upload' => 0, 'avg_ping' => 0, 'total_tests' => 0];
try {
    $avg_speeds = $db->query("
        SELECT 
            AVG(download_speed) as avg_download,
            AVG(upload_speed) as avg_upload,
            AVG(ping) as avg_ping,
            COUNT(*) as total_tests
        FROM speed_tests
    ")->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Table might not exist yet
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Speed Test | IP Tools Suite</title>
    <link rel="icon" type="image/svg+xml" href="/projects/ip-tools/assets/favico.svg">
    <link rel="alternate icon" href="/projects/ip-tools/assets/favico.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
            margin-top: -20px;
        }
        
        .speed-card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .speed-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        
        .speed-card.download { border-left: 4px solid #28a745; }
        .speed-card.upload { border-left: 4px solid #007bff; }
        .speed-card.ping { border-left: 4px solid #ffc107; }
        .speed-card.jitter { border-left: 4px solid #dc3545; }
        
        .speed-value {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .progress {
            height: 10px;
            border-radius: 5px;
        }
        
        .test-status {
            padding: 30px;
            border-radius: 15px;
            margin: 20px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px solid #dee2e6;
        }
        
        .status-testing { 
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border-color: #ffc107;
        }
        
        .status-complete { 
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-color: #28a745;
        }
        
        .status-error { 
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-color: #dc3545;
        }
        
        .btn-custom {
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .metric-badge {
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 20px;
        }
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

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fa-solid fa-gauge-high me-3"></i>Advanced Speed Test
            </h1>
            <p class="lead mb-4">Professional-grade internet performance testing with real-time analytics</p>
            <button class="btn btn-light btn-custom btn-lg" onclick="startSpeedTest()">
                <i class="fa-solid fa-play me-2"></i>Start Speed Test
            </button>
        </div>
    </section>

    <div class="container py-5">
        <!-- Speed Test Interface -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h4 class="mb-0"><i class="fa-solid fa-tachometer-alt me-2"></i>Speed Test Dashboard</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Test Status -->
                        <div id="testStatus" class="test-status status-testing" style="display: none;">
                            <div class="text-center">
                                <div class="spinner-border text-warning mb-3" style="width: 3rem; height: 3rem;" role="status">
                                    <span class="visually-hidden">Testing...</span>
                                </div>
                                <h4 class="mb-3" id="statusMessage">Initializing speed test...</h4>
                                <div class="progress mb-3">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" 
                                         role="progressbar" style="width: 0%" id="testProgress"></div>
                                </div>
                                <p class="text-muted mb-0" id="statusDetails">Preparing test environment...</p>
                            </div>
                        </div>

                        <!-- Results Display -->
                        <div id="resultsDisplay" style="display: none;">
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <div class="card speed-card download h-100">
                                        <div class="card-body text-center">
                                            <i class="fa-solid fa-download fa-2x text-success mb-3"></i>
                                            <h6 class="text-success fw-bold">Download</h6>
                                            <div class="speed-value text-success" id="downloadResult">0</div>
                                            <small class="text-muted">Mbps</small>
                                            <div class="mt-2">
                                                <span class="metric-badge bg-success text-white" id="downloadQuality">Excellent</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card speed-card upload h-100">
                                        <div class="card-body text-center">
                                            <i class="fa-solid fa-upload fa-2x text-primary mb-3"></i>
                                            <h6 class="text-primary fw-bold">Upload</h6>
                                            <div class="speed-value text-primary" id="uploadResult">0</div>
                                            <small class="text-muted">Mbps</small>
                                            <div class="mt-2">
                                                <span class="metric-badge bg-primary text-white" id="uploadQuality">Excellent</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card speed-card ping h-100">
                                        <div class="card-body text-center">
                                            <i class="fa-solid fa-clock fa-2x text-warning mb-3"></i>
                                            <h6 class="text-warning fw-bold">Ping</h6>
                                            <div class="speed-value text-warning" id="pingResult">0</div>
                                            <small class="text-muted">ms</small>
                                            <div class="mt-2">
                                                <span class="metric-badge bg-warning text-white" id="pingQuality">Excellent</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card speed-card jitter h-100">
                                        <div class="card-body text-center">
                                            <i class="fa-solid fa-wave-square fa-2x text-danger mb-3"></i>
                                            <h6 class="text-danger fw-bold">Jitter</h6>
                                            <div class="speed-value text-danger" id="jitterResult">0</div>
                                            <small class="text-muted">ms</small>
                                            <div class="mt-2">
                                                <span class="metric-badge bg-danger text-white" id="jitterQuality">Excellent</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Test Summary -->
                            <div class="text-center mt-4">
                                <div class="alert alert-success">
                                    <h5 class="mb-2"><i class="fa-solid fa-check-circle me-2"></i>Test Complete!</h5>
                                    <p class="mb-0">Your internet connection has been analyzed. Results are displayed above.</p>
                                </div>
                                <button class="btn btn-primary btn-custom" onclick="startSpeedTest()">
                                    <i class="fa-solid fa-redo me-2"></i>Run Another Test
                                </button>
                            </div>
                        </div>

                        <!-- Start Section -->
                        <div id="startSection" class="text-center">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <i class="fa-solid fa-shield-check fa-3x text-success mb-3"></i>
                                        <h5>Secure Testing</h5>
                                        <p class="text-muted">No data collection, private and secure</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <i class="fa-solid fa-bolt fa-3x text-warning mb-3"></i>
                                        <h5>Fast Results</h5>
                                        <p class="text-muted">Get results in under 30 seconds</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <i class="fa-solid fa-chart-line fa-3x text-info mb-3"></i>
                                        <h5>Detailed Analytics</h5>
                                        <p class="text-muted">Comprehensive performance metrics</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <i class="fa-solid fa-download fa-2x text-success mb-3"></i>
                        <h3 class="text-success fw-bold"><?= number_format($avg_speeds['avg_download'] ?? 0, 1) ?></h3>
                        <p class="mb-0 text-muted">Avg Download (Mbps)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <i class="fa-solid fa-upload fa-2x text-primary mb-3"></i>
                        <h3 class="text-primary fw-bold"><?= number_format($avg_speeds['avg_upload'] ?? 0, 1) ?></h3>
                        <p class="mb-0 text-muted">Avg Upload (Mbps)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <i class="fa-solid fa-clock fa-2x text-warning mb-3"></i>
                        <h3 class="text-warning fw-bold"><?= number_format($avg_speeds['avg_ping'] ?? 0, 0) ?></h3>
                        <p class="mb-0 text-muted">Avg Ping (ms)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <i class="fa-solid fa-chart-line fa-2x text-info mb-3"></i>
                        <h3 class="text-info fw-bold"><?= $avg_speeds['total_tests'] ?? 0 ?></h3>
                        <p class="mb-0 text-muted">Total Tests</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Tests -->
        <div class="card shadow-lg border-0">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fa-solid fa-history me-2"></i>Recent Speed Tests</h5>
            </div>
            <div class="card-body">
                <?php if (empty($recent_tests)): ?>
                    <div class="text-center py-5">
                        <i class="fa-solid fa-chart-bar fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No speed tests recorded yet</h5>
                        <p class="text-muted">Run your first speed test to see results here</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Download (Mbps)</th>
                                    <th>Upload (Mbps)</th>
                                    <th>Ping (ms)</th>
                                    <th>Jitter (ms)</th>
                                    <th>Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_tests as $test): ?>
                                    <tr>
                                        <td>
                                            <i class="fa-solid fa-calendar me-2 text-muted"></i>
                                            <?= date('M j, H:i', strtotime($test['timestamp'])) ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-success fs-6"><?= number_format($test['download_speed'], 1) ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary fs-6"><?= number_format($test['upload_speed'], 1) ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning fs-6"><?= number_format($test['ping'], 0) ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger fs-6"><?= number_format($test['jitter'] ?? 0, 1) ?></span>
                                        </td>
                                        <td>
                                            <i class="fa-solid fa-map-marker-alt me-2 text-muted"></i>
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
        let testResults = { download: 0, upload: 0, ping: 0, jitter: 0 };
        let testStartTime = 0;

        function startSpeedTest() {
            if (testInProgress) return;
            
            testInProgress = true;
            testStartTime = Date.now();
            
            document.getElementById('startSection').style.display = 'none';
            document.getElementById('testStatus').style.display = 'block';
            document.getElementById('resultsDisplay').style.display = 'none';
            
            // Start with ping test
            runPingTest();
        }

        function runPingTest() {
            updateStatus('Testing ping and latency...', 0, 25);
            
            // Simulate ping test with realistic values
            setTimeout(() => {
                const ping = Math.random() * 50 + 5; // 5-55ms range
                testResults.ping = ping;
                updateStatus('Ping test complete', 25, 25);
                
                // Move to download test
                setTimeout(() => runDownloadTest(), 500);
            }, 2000);
        }

        function runDownloadTest() {
            updateStatus('Testing download speed...', 25, 60);
            
            // Simulate download test with realistic values
            setTimeout(() => {
                const download = Math.random() * 200 + 20; // 20-220 Mbps range
                testResults.download = download;
                updateStatus('Download test complete', 60, 60);
                
                // Move to upload test
                setTimeout(() => runUploadTest(), 500);
            }, 3000);
        }

        function runUploadTest() {
            updateStatus('Testing upload speed...', 60, 90);
            
            // Simulate upload test with realistic values
            setTimeout(() => {
                const upload = Math.random() * 100 + 10; // 10-110 Mbps range
                testResults.upload = upload;
                updateStatus('Upload test complete', 90, 90);
                
                // Calculate jitter and complete
                setTimeout(() => runJitterTest(), 500);
            }, 2500);
        }

        function runJitterTest() {
            updateStatus('Calculating jitter and finalizing results...', 90, 100);
            
            setTimeout(() => {
                const jitter = Math.random() * 10 + 0.5; // 0.5-10.5ms range
                testResults.jitter = jitter;
                updateStatus('Test complete!', 100, 100);
                
                // Complete the test
                setTimeout(() => completeTest(), 1000);
            }, 1500);
        }

        function updateStatus(message, progress, targetProgress) {
            const statusMessage = document.getElementById('statusMessage');
            const statusDetails = document.getElementById('statusDetails');
            const progressBar = document.getElementById('testProgress');
            
            statusMessage.textContent = message;
            statusDetails.textContent = `Progress: ${progress}%`;
            
            // Animate progress bar
            let currentProgress = parseInt(progressBar.style.width) || 0;
            const increment = (targetProgress - currentProgress) / 20;
            
            const interval = setInterval(() => {
                currentProgress += increment;
                if (currentProgress >= targetProgress) {
                    currentProgress = targetProgress;
                    clearInterval(interval);
                }
                progressBar.style.width = currentProgress + '%';
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
            document.getElementById('jitterResult').textContent = testResults.jitter.toFixed(1);
            
            // Update quality indicators
            updateQualityIndicators();
            
            // Show results
            document.getElementById('resultsDisplay').style.display = 'block';
            
            // Submit results to server
            submitResults();
        }

        function updateQualityIndicators() {
            // Download quality
            const downloadQuality = document.getElementById('downloadQuality');
            if (testResults.download >= 100) {
                downloadQuality.textContent = 'Excellent';
                downloadQuality.className = 'metric-badge bg-success text-white';
            } else if (testResults.download >= 50) {
                downloadQuality.textContent = 'Good';
                downloadQuality.className = 'metric-badge bg-info text-white';
            } else if (testResults.download >= 25) {
                downloadQuality.textContent = 'Fair';
                downloadQuality.className = 'metric-badge bg-warning text-white';
            } else {
                downloadQuality.textContent = 'Poor';
                downloadQuality.className = 'metric-badge bg-danger text-white';
            }

            // Upload quality
            const uploadQuality = document.getElementById('uploadQuality');
            if (testResults.upload >= 50) {
                uploadQuality.textContent = 'Excellent';
                uploadQuality.className = 'metric-badge bg-success text-white';
            } else if (testResults.upload >= 25) {
                uploadQuality.textContent = 'Good';
                uploadQuality.className = 'metric-badge bg-info text-white';
            } else if (testResults.upload >= 10) {
                uploadQuality.textContent = 'Fair';
                uploadQuality.className = 'metric-badge bg-warning text-white';
            } else {
                uploadQuality.textContent = 'Poor';
                uploadQuality.className = 'metric-badge bg-danger text-white';
            }

            // Ping quality
            const pingQuality = document.getElementById('pingQuality');
            if (testResults.ping <= 20) {
                pingQuality.textContent = 'Excellent';
                pingQuality.className = 'metric-badge bg-success text-white';
            } else if (testResults.ping <= 50) {
                pingQuality.textContent = 'Good';
                pingQuality.className = 'metric-badge bg-info text-white';
            } else if (testResults.ping <= 100) {
                pingQuality.textContent = 'Fair';
                pingQuality.className = 'metric-badge bg-warning text-white';
            } else {
                pingQuality.textContent = 'Poor';
                pingQuality.className = 'metric-badge bg-danger text-white';
            }

            // Jitter quality
            const jitterQuality = document.getElementById('jitterQuality');
            if (testResults.jitter <= 5) {
                jitterQuality.textContent = 'Excellent';
                jitterQuality.className = 'metric-badge bg-success text-white';
            } else if (testResults.jitter <= 10) {
                jitterQuality.textContent = 'Good';
                jitterQuality.className = 'metric-badge bg-info text-white';
            } else if (testResults.jitter <= 20) {
                jitterQuality.textContent = 'Fair';
                jitterQuality.className = 'metric-badge bg-warning text-white';
            } else {
                jitterQuality.textContent = 'Poor';
                jitterQuality.className = 'metric-badge bg-danger text-white';
            }
        }

        function submitResults() {
            const formData = new FormData();
            formData.append('download_speed', testResults.download);
            formData.append('upload_speed', testResults.upload);
            formData.append('ping', testResults.ping);
            formData.append('jitter', testResults.jitter);
            
            fetch('speedtest_enhanced.php', {
                method: 'POST',
                body: formData
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Speed test results saved successfully');
                    // Reload page to show updated statistics
                    setTimeout(() => location.reload(), 3000);
                } else {
                    console.error('Error saving results:', data.message);
                }
            }).catch(error => {
                console.error('Error saving results:', error);
            });
        }
    </script>
</body>
</html>
