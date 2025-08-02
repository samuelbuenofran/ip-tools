<div class="container">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3><i class="fa-solid fa-tachometer-alt"></i> Welcome to IP Tools Suite</h3>
                            <p class="mb-0">Your comprehensive toolkit for IP tracking and network analysis.</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="<?= $this->url('auth/login') ?>" class="btn btn-light">
                                <i class="fa-solid fa-sign-in-alt"></i> Login
                            </a>
                            <a href="<?= $this->url('auth/register') ?>" class="btn btn-outline-light">
                                <i class="fa-solid fa-user-plus"></i> Register
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <i class="fa-solid fa-mouse-pointer text-primary fa-2x mb-2"></i>
                    <h4><?= $logStats['total_clicks'] ?? 0 ?></h4>
                    <p class="card-text">Total Clicks</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <i class="fa-solid fa-link text-success fa-2x mb-2"></i>
                    <h4><?= $linkStats['active_links'] ?? 0 ?></h4>
                    <p class="card-text">Active Links</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-info">
                <div class="card-body">
                    <i class="fa-solid fa-user-check text-info fa-2x mb-2"></i>
                    <h4><?= $logStats['unique_visitors'] ?? 0 ?></h4>
                    <p class="card-text">Unique Visitors</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <i class="fa-solid fa-map-marker-alt text-warning fa-2x mb-2"></i>
                    <h4><?= $logStats['gps_tracking'] ?? 0 ?></h4>
                    <p class="card-text">GPS Tracking</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa-solid fa-bolt"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="<?= $this->url('geologger/create') ?>" class="btn btn-primary w-100">
                                <i class="fa-solid fa-plus"></i> Create Tracking Link
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= $this->url('geologger/logs') ?>" class="btn btn-info w-100">
                                <i class="fa-solid fa-chart-line"></i> View Logs
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= $this->url('phone-tracker/send_sms') ?>" class="btn btn-success w-100">
                                <i class="fa-solid fa-mobile-screen-button"></i> Phone Tracker
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= $this->url('utils/speedtest') ?>" class="btn btn-warning w-100">
                                <i class="fa-solid fa-gauge-high"></i> Speed Test
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa-solid fa-clock"></i> Recent Activity</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentActivity)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recentActivity as $log): ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?= $log['ip_address'] ?></strong>
                                            <br>
                                            <small class="text-muted">
                                                <?= $log['city'] ?? 'Unknown' ?>, <?= $log['country'] ?? 'Unknown' ?>
                                            </small>
                                        </div>
                                        <small class="text-muted">
                                            <?= date('M d, H:i', strtotime($log['timestamp'])) ?>
                                        </small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No recent activity.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa-solid fa-info-circle"></i> About IP Tools Suite</h5>
                </div>
                <div class="card-body">
                    <p>IP Tools Suite is a comprehensive toolkit for IP tracking, geolocation analysis, and network monitoring.</p>
                    <ul>
                        <li><strong>Geolocation Tracking:</strong> Create tracking links and monitor visitor locations</li>
                        <li><strong>Phone Tracking:</strong> SMS-based location tracking system</li>
                        <li><strong>Speed Testing:</strong> Internet connection speed analysis</li>
                        <li><strong>Analytics:</strong> Detailed visitor logs and statistics</li>
                    </ul>
                    <a href="<?= $this->url('about') ?>" class="btn btn-outline-primary">
                        <i class="fa-solid fa-info-circle"></i> Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> 