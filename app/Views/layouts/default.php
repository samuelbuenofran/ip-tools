<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'IP Tools Suite' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="/projects/ip-tools/assets/style.css" rel="stylesheet">
    
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        .btn {
            border-radius: 0.375rem;
        }
        .list-group-item {
            border-left: none;
            border-right: none;
        }
        .list-group-item:first-child {
            border-top: none;
        }
        .list-group-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?= $this->url('') ?>">
                <i class="fa-solid fa-globe"></i> IP Tools Suite
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->url('') ?>">
                            <i class="fa-solid fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->url('geologger/create') ?>">
                            <i class="fa-solid fa-map-pin"></i> Geolocation Tracker
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->url('geologger/logs') ?>">
                            <i class="fa-solid fa-chart-line"></i> Logs Panel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->url('phone-tracker/send_sms') ?>">
                            <i class="fa-solid fa-mobile-screen-button"></i> Phone Tracker
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->url('utils/speedtest') ?>">
                            <i class="fa-solid fa-gauge-high"></i> Speed Test
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-user"></i> <?= $_SESSION['username'] ?? 'User' ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= $this->url('dashboard') ?>">
                                    <i class="fa-solid fa-tachometer-alt"></i> Dashboard
                                </a></li>
                                <li><a class="dropdown-item" href="<?= $this->url('auth/profile') ?>">
                                    <i class="fa-solid fa-user-edit"></i> Profile
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= $this->url('auth/logout') ?>">
                                    <i class="fa-solid fa-sign-out-alt"></i> Logout
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $this->url('auth/login') ?>">
                                <i class="fa-solid fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $this->url('auth/register') ?>">
                                <i class="fa-solid fa-user-plus"></i> Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fa-solid fa-check-circle"></i>
                    <?= $_SESSION['success_message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fa-solid fa-exclamation-triangle"></i>
                    <?= $_SESSION['error_message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fa-solid fa-globe"></i> IP Tools Suite</h5>
                    <p class="mb-0">Advanced IP tracking and network analysis tools.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        <a href="<?= $this->url('about') ?>" class="text-light text-decoration-none">About</a> |
                        <a href="<?= $this->url('contact') ?>" class="text-light text-decoration-none">Contact</a> |
                        <a href="<?= $this->url('privacy') ?>" class="text-light text-decoration-none">Privacy</a> |
                        <a href="<?= $this->url('support') ?>" class="text-light text-decoration-none">Support</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html> 