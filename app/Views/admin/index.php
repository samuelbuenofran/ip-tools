<?php
// Admin Dashboard Index View
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard' ?></title>
    <link rel="icon" type="image/svg+xml" href="<?= $view->asset('favico.svg') ?>">
    <link rel="alternate icon" href="<?= $view->asset('favico.svg') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .admin-card {
            border-left: 4px solid;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .admin-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .admin-card.privacy { border-left-color: #17a2b8; }
        .admin-card.testing { border-left-color: #28a745; }
        .admin-card.system { border-left-color: #ffc107; }
        .admin-card.security { border-left-color: #dc3545; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fa-solid fa-shield-alt"></i> Admin Panel
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fa-solid fa-user-shield"></i> <?= htmlspecialchars($user['username']) ?> (<?= ucfirst($user['role']) ?>)
                </span>
                <a class="btn btn-outline-light btn-sm" href="<?= $view->url('dashboard') ?>">
                    <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4">
                    <i class="fa-solid fa-shield-alt text-primary"></i> Admin Dashboard
                </h1>
                <p class="text-center text-muted mb-5">
                    Welcome to the administrative control panel. Manage your IP Tools Suite configuration and monitor system health.
                </p>
            </div>
        </div>

        <!-- Admin Tools Grid -->
        <div class="row g-4">
            <!-- Privacy Settings -->
            <div class="col-md-6 col-lg-4">
                <div class="card admin-card privacy h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fa-solid fa-user-secret fa-3x text-info"></i>
                        </div>
                        <h5 class="card-title">Privacy Settings</h5>
                        <p class="card-text text-muted">
                            Configure location tracking messages, stealth mode, and privacy controls for your tracking system.
                        </p>
                        <a href="<?= $view->url('admin/privacy_settings') ?>" class="btn btn-info">
                            <i class="fa-solid fa-cog"></i> Configure Privacy
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Test Dashboard -->
            <div class="col-md-6 col-lg-4">
                <div class="card admin-card testing h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fa-solid fa-vial fa-3x text-success"></i>
                        </div>
                        <h5 class="card-title">System Test Dashboard</h5>
                        <p class="card-text text-muted">
                            Comprehensive testing and monitoring tools for database, Google Maps API, tracking system, and more.
                        </p>
                        <a href="<?= $view->url('admin/test_dashboard') ?>" class="btn btn-success">
                            <i class="fa-solid fa-tools"></i> Open Test Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Monitoring -->
            <div class="col-md-6 col-lg-4">
                <div class="card admin-card system h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fa-solid fa-chart-line fa-3x text-warning"></i>
                        </div>
                        <h5 class="card-title">System Monitoring</h5>
                        <p class="card-text text-muted">
                            Monitor system performance, database health, and application statistics in real-time.
                        </p>
                        <a href="<?= $view->url('admin/test_dashboard') ?>" class="btn btn-warning">
                            <i class="fa-solid fa-tachometer-alt"></i> View Monitoring
                        </a>
                    </div>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="col-md-6 col-lg-4">
                <div class="card admin-card security h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fa-solid fa-lock fa-3x text-danger"></i>
                        </div>
                        <h5 class="card-title">Security Settings</h5>
                        <p class="card-text text-muted">
                            Manage user permissions, access controls, and security configurations for your application.
                        </p>
                        <button class="btn btn-danger" disabled>
                            <i class="fa-solid fa-lock"></i> Coming Soon
                        </button>
                    </div>
                </div>
            </div>

            <!-- Database Management -->
            <div class="col-md-6 col-lg-4">
                <div class="card admin-card system h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fa-solid fa-database fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title">Database Management</h5>
                        <p class="card-text text-muted">
                            View database statistics, table status, and perform database maintenance operations.
                        </p>
                        <a href="<?= $view->url('admin/test_dashboard') ?>" class="btn btn-primary">
                            <i class="fa-solid fa-database"></i> Database Status
                        </a>
                    </div>
                </div>
            </div>

            <!-- API Management -->
            <div class="col-md-6 col-lg-4">
                <div class="card admin-card testing h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fa-solid fa-code fa-3x text-secondary"></i>
                        </div>
                        <h5 class="card-title">API Management</h5>
                        <p class="card-text text-muted">
                            Test and configure external APIs including Google Maps, geolocation services, and more.
                        </p>
                        <a href="<?= $view->url('admin/test_dashboard') ?>" class="btn btn-secondary">
                            <i class="fa-solid fa-code"></i> Test APIs
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-3">
                    <i class="fa-solid fa-chart-bar text-primary"></i> Quick System Overview
                </h3>
                <div class="card">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <h4 class="text-primary">
                                    <i class="fa-solid fa-link"></i>
                                </h4>
                                <p class="mb-0">Tracking Links</p>
                                <small class="text-muted">Manage and monitor</small>
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-success">
                                    <i class="fa-solid fa-users"></i>
                                </h4>
                                <p class="mb-0">User Management</p>
                                <small class="text-muted">Access control</small>
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-warning">
                                    <i class="fa-solid fa-map-marker-alt"></i>
                                </h4>
                                <p class="mb-0">Location Data</p>
                                <small class="text-muted">Geolocation tracking</small>
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-info">
                                    <i class="fa-solid fa-cog"></i>
                                </h4>
                                <p class="mb-0">System Config</p>
                                <small class="text-muted">Settings & preferences</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row mt-4">
            <div class="col-12">
                <h3 class="mb-3">
                    <i class="fa-solid fa-history text-secondary"></i> Recent Admin Activity
                </h3>
                <div class="card">
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fa-solid fa-user-shield text-primary me-2"></i>
                                    <strong>Admin Login</strong>
                                    <small class="text-muted ms-2"><?= htmlspecialchars($user['username']) ?> logged in</small>
                                </div>
                                <span class="badge bg-primary">Just now</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fa-solid fa-database text-success me-2"></i>
                                    <strong>Database Check</strong>
                                    <small class="text-muted ms-2">System health verified</small>
                                </div>
                                <span class="badge bg-success">System</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fa-solid fa-shield-alt text-warning me-2"></i>
                                    <strong>Security Status</strong>
                                    <small class="text-muted ms-2">All systems operational</small>
                                </div>
                                <span class="badge bg-warning">Security</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
