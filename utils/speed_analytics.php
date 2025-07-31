<?php
require_once('../config.php');
$db = connectDB();

// Get comprehensive statistics
$stats = $db->query("
    SELECT 
        COUNT(*) as total_tests,
        AVG(download_speed) as avg_download,
        AVG(upload_speed) as avg_upload,
        AVG(ping) as avg_ping,
        MAX(download_speed) as max_download,
        MAX(upload_speed) as max_upload,
        MIN(ping) as min_ping,
        STDDEV(download_speed) as download_stddev,
        STDDEV(upload_speed) as upload_stddev,
        STDDEV(ping) as ping_stddev
    FROM speed_tests
")->fetch(PDO::FETCH_ASSOC);

// Get speed distribution data
$download_ranges = $db->query("
    SELECT 
        CASE 
            WHEN download_speed < 25 THEN '0-25 Mbps'
            WHEN download_speed < 50 THEN '25-50 Mbps'
            WHEN download_speed < 100 THEN '50-100 Mbps'
            WHEN download_speed < 200 THEN '100-200 Mbps'
            ELSE '200+ Mbps'
        END as range,
        COUNT(*) as count
    FROM speed_tests 
    GROUP BY range
    ORDER BY MIN(download_speed)
")->fetchAll(PDO::FETCH_ASSOC);

// Get recent tests with details
$recent_tests = $db->query("
    SELECT * FROM speed_tests 
    ORDER BY timestamp DESC 
    LIMIT 50
")->fetchAll(PDO::FETCH_ASSOC);

// Get top locations
$top_locations = $db->query("
    SELECT 
        CONCAT(city, ', ', country) as location,
        COUNT(*) as test_count,
        AVG(download_speed) as avg_download,
        AVG(upload_speed) as avg_upload,
        AVG(ping) as avg_ping
    FROM speed_tests 
    WHERE country != 'Unknown'
    GROUP BY city, country 
    HAVING test_count > 1
    ORDER BY test_count DESC 
    LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speed Test Analytics | Detailed Statistics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stats-card {
            border-left: 4px solid;
            transition: transform 0.2s;
        }
        .stats-card:hover {
            transform: translateY(-2px);
        }
        .stats-card.download { border-left-color: #28a745; }
        .stats-card.upload { border-left-color: #007bff; }
        .stats-card.ping { border-left-color: #ffc107; }
        .stats-card.tests { border-left-color: #17a2b8; }
        .chart-container {
            position: relative;
            height: 300px;
            margin: 20px 0;
        }
        .speed-grade {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .grade-excellent { color: #28a745; }
        .grade-good { color: #17a2b8; }
        .grade-fair { color: #ffc107; }
        .grade-poor { color: #dc3545; }
    </style>
</head>
<body class="bg-light">
    <?php include('../header.php'); ?>

    <div class="container py-4">
        <h2 class="mb-4 text-center">
            <i class="fa-solid fa-chart-line text-primary"></i> Speed Test Analytics
        </h2>

        <!-- Key Statistics -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stats-card download">
                    <div class="card-body text-center">
                        <h3 class="text-success"><?= number_format($stats['avg_download'] ?? 0, 1) ?></h3>
                        <p class="mb-0"><i class="fa-solid fa-download text-success"></i> Avg Download</p>
                        <small class="text-muted">Mbps</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card upload">
                    <div class="card-body text-center">
                        <h3 class="text-primary"><?= number_format($stats['avg_upload'] ?? 0, 1) ?></h3>
                        <p class="mb-0"><i class="fa-solid fa-upload text-primary"></i> Avg Upload</p>
                        <small class="text-muted">Mbps</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card ping">
                    <div class="card-body text-center">
                        <h3 class="text-warning"><?= number_format($stats['avg_ping'] ?? 0, 0) ?></h3>
                        <p class="mb-0"><i class="fa-solid fa-clock text-warning"></i> Avg Ping</p>
                        <small class="text-muted">ms</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card tests">
                    <div class="card-body text-center">
                        <h3 class="text-info"><?= $stats['total_tests'] ?? 0 ?></h3>
                        <p class="mb-0"><i class="fa-solid fa-chart-line text-info"></i> Total Tests</p>
                        <small class="text-muted">performed</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fa-solid fa-chart-bar"></i> Download Speed Distribution</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="downloadChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fa-solid fa-chart-line"></i> Speed Trends</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="trendsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Statistics -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0"><i class="fa-solid fa-trophy"></i> Speed Records</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <h4 class="text-success"><?= number_format($stats['max_download'] ?? 0, 1) ?></h4>
                                <p class="mb-0">Fastest Download</p>
                                <small class="text-muted">Mbps</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-primary"><?= number_format($stats['max_upload'] ?? 0, 1) ?></h4>
                                <p class="mb-0">Fastest Upload</p>
                                <small class="text-muted">Mbps</small>
                            </div>
                        </div>
                        <hr>
                        <div class="row text-center">
                            <div class="col-6">
                                <h4 class="text-warning"><?= number_format($stats['min_ping'] ?? 0, 0) ?></h4>
                                <p class="mb-0">Lowest Ping</p>
                                <small class="text-muted">ms</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-info"><?= number_format($stats['total_tests'] ?? 0, 0) ?></h4>
                                <p class="mb-0">Total Tests</p>
                                <small class="text-muted">performed</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fa-solid fa-globe"></i> Top Locations</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($top_locations)): ?>
                            <p class="text-muted text-center">No location data available.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Location</th>
                                            <th>Tests</th>
                                            <th>Avg Download</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($top_locations as $location): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($location['location']) ?></td>
                                                <td><span class="badge bg-secondary"><?= $location['test_count'] ?></span></td>
                                                <td><span class="badge bg-success"><?= number_format($location['avg_download'], 1) ?> Mbps</span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Tests Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
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
                                    <th>Download</th>
                                    <th>Upload</th>
                                    <th>Ping</th>
                                    <th>Location</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_tests as $test): ?>
                                    <tr>
                                        <td><?= date('M j, H:i', strtotime($test['timestamp'])) ?></td>
                                        <td>
                                            <span class="badge bg-success"><?= number_format($test['download_speed'], 1) ?> Mbps</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"><?= number_format($test['upload_speed'], 1) ?> Mbps</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning"><?= number_format($test['ping'], 0) ?> ms</span>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($test['city']) ?>, <?= htmlspecialchars($test['country']) ?>
                                        </td>
                                        <td>
                                            <?php
                                            $grade = '';
                                            $gradeClass = '';
                                            if ($test['download_speed'] >= 100) {
                                                $grade = 'A+';
                                                $gradeClass = 'grade-excellent';
                                            } elseif ($test['download_speed'] >= 50) {
                                                $grade = 'A';
                                                $gradeClass = 'grade-excellent';
                                            } elseif ($test['download_speed'] >= 25) {
                                                $grade = 'B';
                                                $gradeClass = 'grade-good';
                                            } elseif ($test['download_speed'] >= 10) {
                                                $grade = 'C';
                                                $gradeClass = 'grade-fair';
                                            } else {
                                                $grade = 'D';
                                                $gradeClass = 'grade-poor';
                                            }
                                            ?>
                                            <span class="speed-grade <?= $gradeClass ?>"><?= $grade ?></span>
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
        // Download Speed Distribution Chart
        const downloadCtx = document.getElementById('downloadChart').getContext('2d');
        new Chart(downloadCtx, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode(array_column($download_ranges, 'range')) ?>,
                datasets: [{
                    data: <?= json_encode(array_column($download_ranges, 'count')) ?>,
                    backgroundColor: ['#28a745', '#17a2b8', '#ffc107', '#fd7e14', '#dc3545'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Speed Trends Chart
        const trendsCtx = document.getElementById('trendsChart').getContext('2d');
        const recentData = <?= json_encode(array_slice($recent_tests, 0, 10)) ?>;
        const labels = recentData.map(test => new Date(test.timestamp).toLocaleDateString()).reverse();
        const downloadData = recentData.map(test => test.download_speed).reverse();
        const uploadData = recentData.map(test => test.upload_speed).reverse();

        new Chart(trendsCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Download Speed (Mbps)',
                    data: downloadData,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.4
                }, {
                    label: 'Upload Speed (Mbps)',
                    data: uploadData,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });

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