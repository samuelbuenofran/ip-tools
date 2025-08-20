<?php
/**
 * Speed Test Analytics View
 * Comprehensive performance analysis and reporting
 */
?>

<div class="container py-4">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h1 class="display-5 fw-bold text-primary">
                <i class="fa-solid fa-chart-line me-3"></i>Speed Test Analytics
            </h1>
            <p class="lead text-muted">Comprehensive analysis of your internet performance data</p>
        </div>
        <div class="col-auto">
            <div class="btn-group" role="group">
                <a href="<?= $view->url('speed-test/export') ?>?format=csv" class="btn btn-outline-primary">
                    <i class="fa-solid fa-download me-2"></i>Export CSV
                </a>
                <a href="<?= $view->url('speed-test/export') ?>?format=json" class="btn btn-outline-primary">
                    <i class="fa-solid fa-code me-2"></i>Export JSON
                </a>
            </div>
        </div>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <i class="fa-solid fa-exclamation-triangle me-2"></i>
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($analytics)): ?>
        <!-- Overall Statistics -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <i class="fa-solid fa-download fa-2x text-success mb-3"></i>
                        <h3 class="text-success fw-bold">
                            <?= number_format($analytics['overall']['avg_download'] ?? 0, 1) ?>
                        </h3>
                        <p class="mb-0 text-muted">Avg Download (Mbps)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <i class="fa-solid fa-upload fa-2x text-primary mb-3"></i>
                        <h3 class="text-primary fw-bold">
                            <?= number_format($analytics['overall']['avg_upload'] ?? 0, 1) ?>
                        </h3>
                        <p class="mb-0 text-muted">Avg Upload (Mbps)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <i class="fa-solid fa-clock fa-2x text-warning mb-3"></i>
                        <h3 class="text-warning fw-bold">
                            <?= number_format($analytics['overall']['avg_ping'] ?? 0, 0) ?>
                        </h3>
                        <p class="mb-0 text-muted">Avg Ping (ms)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <i class="fa-solid fa-chart-line fa-2x text-info mb-3"></i>
                        <h3 class="text-info fw-bold">
                            <?= $analytics['overall']['total_tests'] ?? 0 ?>
                        </h3>
                        <p class="mb-0 text-muted">Total Tests</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Speed Distribution -->
        <?php if (!empty($analytics['speed_distribution'])): ?>
        <div class="row g-4 mb-5">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fa-solid fa-chart-pie me-2"></i>Download Speed Distribution
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Speed Category</th>
                                        <th>Count</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total = array_sum(array_column($analytics['speed_distribution'], 'count'));
                                    foreach ($analytics['speed_distribution'] as $dist): 
                                        $percentage = $total > 0 ? ($dist['count'] / $total) * 100 : 0;
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($dist['speed_category']) ?></td>
                                        <td>
                                            <span class="badge bg-success"><?= $dist['count'] ?></span>
                                        </td>
                                        <td><?= number_format($percentage, 1) ?>%</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">
                            <i class="fa-solid fa-chart-bar me-2"></i>Ping Performance Categories
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Ping Category</th>
                                        <th>Count</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total = array_sum(array_column($analytics['performance_categories'], 'count'));
                                    foreach ($analytics['performance_categories'] as $perf): 
                                        $percentage = $total > 0 ? ($perf['count'] / $total) * 100 : 0;
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($perf['ping_category']) ?></td>
                                        <td>
                                            <span class="badge bg-warning"><?= $perf['count'] ?></span>
                                        </td>
                                        <td><?= number_format($percentage, 1) ?>%</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Location Statistics -->
        <?php if (!empty($analytics['location_stats'])): ?>
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fa-solid fa-globe me-2"></i>Location-Based Performance
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Location</th>
                                <th>Test Count</th>
                                <th>Avg Download (Mbps)</th>
                                <th>Avg Upload (Mbps)</th>
                                <th>Avg Ping (ms)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($analytics['location_stats'] as $location): ?>
                            <tr>
                                <td>
                                    <i class="fa-solid fa-map-marker-alt me-2 text-muted"></i>
                                    <?= htmlspecialchars($location['city']) ?>, <?= htmlspecialchars($location['country']) ?>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= $location['test_count'] ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-success"><?= number_format($location['avg_download'], 1) ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-primary"><?= number_format($location['avg_upload'], 1) ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-warning"><?= number_format($location['avg_ping'], 0) ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Time Trends -->
        <?php if (!empty($analytics['time_trends'])): ?>
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fa-solid fa-calendar-chart me-2"></i>Performance Trends (Last 30 Days)
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Test Count</th>
                                <th>Avg Download (Mbps)</th>
                                <th>Avg Upload (Mbps)</th>
                                <th>Avg Ping (ms)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($analytics['time_trends'], 0, 15) as $trend): ?>
                            <tr>
                                <td>
                                    <i class="fa-solid fa-calendar me-2 text-muted"></i>
                                    <?= date('M j, Y', strtotime($trend['test_date'])) ?>
                                </td>
                                <td>
                                    <span class="badge bg-primary"><?= $trend['test_count'] ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-success"><?= number_format($trend['avg_download'], 1) ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= number_format($trend['avg_upload'], 1) ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-warning"><?= number_format($trend['avg_ping'], 0) ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (count($analytics['time_trends']) > 15): ?>
                <div class="text-center mt-3">
                    <small class="text-muted">Showing last 15 days. Use export for complete data.</small>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

    <?php else: ?>
        <!-- No Data State -->
        <div class="text-center py-5">
            <i class="fa-solid fa-chart-bar fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No Analytics Data Available</h5>
            <p class="text-muted">Run some speed tests to see detailed analytics here.</p>
            <a href="<?= $view->url('speed-test/index') ?>" class="btn btn-primary">
                <i class="fa-solid fa-play me-2"></i>Run Speed Test
            </a>
        </div>
    <?php endif; ?>

    <!-- Back to Speed Test -->
    <div class="text-center mt-5">
        <a href="<?= $view->url('speed-test/index') ?>" class="btn btn-outline-primary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to Speed Test
        </a>
    </div>
</div> 