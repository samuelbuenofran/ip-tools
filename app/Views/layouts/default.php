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
    <link href="<?= $this->asset('style.css') ?>" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        
        .navbar-brand {
            font-weight: 600;
            font-size: 1.5rem;
        }
        
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.75rem;
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e9ecef;
            border-radius: 0.75rem 0.75rem 0 0 !important;
        }
        
        .btn {
            border-radius: 0.5rem;
            font-weight: 500;
        }
        
        .form-control, .form-select {
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        
        .table {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .alert {
            border-radius: 0.5rem;
            border: none;
        }
        
        .badge {
            font-weight: 500;
        }
        
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
        
        .theme-dark {
            background-color: #1a1a1a !important;
            color: #ffffff !important;
        }
        
        .theme-dark .card {
            background-color: #2d2d2d !important;
            color: #ffffff !important;
        }
        
        .theme-dark .navbar {
            background-color: #2d2d2d !important;
        }
        
        .theme-dark .table {
            color: #ffffff !important;
        }
        
        .theme-dark .form-control,
        .theme-dark .form-select {
            background-color: #3d3d3d !important;
            color: #ffffff !important;
            border-color: #4d4d4d !important;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?= $this->url() ?>">
                <i class="fa-solid fa-globe text-primary"></i> IP Tools Suite
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $this->isActive('') ?>" href="<?= $this->url() ?>">
                            <i class="fa-solid fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $this->isActive('geologger/create') ?>" href="<?= $this->url('geologger/create') ?>">
                            <i class="fa-solid fa-map-pin"></i> Geolocation Tracker
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $this->isActive('geologger/logs') ?>" href="<?= $this->url('geologger/logs') ?>">
                            <i class="fa-solid fa-chart-line"></i> Logs Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $this->isActive('phone-tracker') ?>" href="<?= $this->url('phone-tracker/send_sms') ?>">
                            <i class="fa-solid fa-mobile-screen-button"></i> Phone Tracker
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $this->isActive('utils/speedtest') ?>" href="<?= $this->url('utils/speedtest') ?>">
                            <i class="fa-solid fa-gauge-high"></i> Speed Test
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <button class="btn btn-outline-secondary btn-sm" id="themeToggle">
                            <i class="fa-solid fa-moon"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-top mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1">&copy; <?= date("Y") ?> Keizai Tech IP Tools Suite</p>
                    <small class="text-muted">
                        Version 2.0. Built with ❤️ in São Paulo. 
                        <a href="<?= $this->url('support') ?>" class="text-decoration-none">Support</a> |
                        <a href="<?= $this->url('privacy') ?>" class="text-decoration-none">Privacy</a>
                    </small>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">
                        <i class="fa-solid fa-shield-halved"></i> Secure & Private
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Theme Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const body = document.body;
            const icon = themeToggle.querySelector('i');
            
            // Check for saved theme preference
            const currentTheme = localStorage.getItem('theme');
            if (currentTheme === 'dark') {
                body.classList.add('theme-dark');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }
            
            themeToggle.addEventListener('click', function() {
                if (body.classList.contains('theme-dark')) {
                    body.classList.remove('theme-dark');
                    localStorage.setItem('theme', 'light');
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                } else {
                    body.classList.add('theme-dark');
                    localStorage.setItem('theme', 'dark');
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                }
            });
        });
    </script>
</body>
</html> 