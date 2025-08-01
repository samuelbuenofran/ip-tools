<div class="container">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="display-6 mb-3">
                        <i class="fa-solid fa-globe text-primary"></i> Welcome to IP Tools Suite
                    </h1>
                    <p class="lead text-muted">
                        Advanced geolocation tracking, phone monitoring, and network analytics platform
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="fa-solid fa-link text-primary fa-2x mb-3"></i>
                    <h3 class="card-title"><?= $linkStats['total_links'] ?? 0 ?></h3>
                    <p class="card-text text-muted">Total Tracking Links</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fa-solid fa-mouse-pointer text-success fa-2x mb-3"></i>
                    <h3 class="card-title"><?= $logStats['total_clicks'] ?? 0 ?></h3>
                    <p class="card-text text-muted">Total Clicks</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fa-solid fa-user-check text-info fa-2x mb-3"></i>
                    <h3 class="card-title"><?= $logStats['unique_visitors'] ?? 0 ?></h3>
                    <p class="card-text text-muted">Unique Visitors</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="fa-solid fa-map-marker-alt text-warning fa-2x mb-3"></i>
                    <h3 class="card-title"><?= $logStats['gps_clicks'] ?? 0 ?></h3>
                    <p class="card-text text-muted">GPS Tracking</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fa-solid fa-map-pin text-primary"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= $this->url('geologger/create') ?>" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Create Tracking Link
                        </a>
                        <a href="<?= $this->url('geologger/logs') ?>" class="btn btn-outline-primary">
                            <i class="fa-solid fa-chart-line"></i> View Analytics
                        </a>
                        <a href="<?= $this->url('phone-tracker/send_sms') ?>" class="btn btn-outline-success">
                            <i class="fa-solid fa-mobile-screen-button"></i> Phone Tracker
                        </a>
                        <a href="<?= $this->url('utils/speedtest') ?>" class="btn btn-outline-info">
                            <i class="fa-solid fa-gauge-high"></i> Speed Test
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fa-solid fa-clock text-warning"></i> Recent Activity
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentActivity)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recentActivity as $activity): ?>
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted">
                                                <i class="fa-solid fa-map-marker-alt"></i>
                                                <?= $this->escape($activity['ip_address']) ?>
                                            </small>
                                            <br>
                                            <small class="text-muted">
                                                <?= $this->formatDate($activity['timestamp']) ?>
                                            </small>
                                        </div>
                                        <span class="badge bg-<?= $activity['location_type'] === 'GPS' ? 'success' : 'secondary' ?>">
                                            <?= $activity['location_type'] ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center mb-0">
                            <i class="fa-solid fa-inbox fa-2x mb-2"></i><br>
                            No recent activity
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Grid -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fa-solid fa-map-marker-alt text-primary fa-3x mb-3"></i>
                    <h5 class="card-title">Precise Geolocation</h5>
                    <p class="card-text">
                        Track user locations with GPS accuracy down to street level. 
                        Perfect for marketing campaigns and user analytics.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fa-solid fa-mobile-screen-button text-success fa-3x mb-3"></i>
                    <h5 class="card-title">Phone Tracking</h5>
                    <p class="card-text">
                        Monitor mobile device interactions and track SMS link performance 
                        with detailed analytics and reporting.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fa-solid fa-gauge-high text-info fa-3x mb-3"></i>
                    <h5 class="card-title">Speed Testing</h5>
                    <p class="card-text">
                        Comprehensive internet speed testing with detailed metrics, 
                        historical data, and performance analytics.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div> 