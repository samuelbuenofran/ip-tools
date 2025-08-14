<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'IP Tools Suite' ?></title>
    <link rel="icon" type="image/svg+xml" href="<?= $view->asset('favico.svg') ?>">
    <link rel="alternate icon" href="<?= $view->asset('favico.svg') ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= $view->asset('themes.css') ?>" rel="stylesheet">
    <link href="<?= $view->asset('navbar-fixes.css') ?>" rel="stylesheet">
    <script src="<?= $view->asset('theme-switcher.js') ?>" defer></script>
    <script src="<?= $view->asset('translations.js') ?>" defer></script>
    
    <style>
        /* Additional custom styles for MVC */
        .navbar-brand {
            font-weight: 600;
        }
        .card {
            transition: var(--transition);
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }
        .btn {
            border-radius: var(--border-radius);
            transition: var(--transition);
        }
        .list-group-item {
            border-left: none;
            border-right: none;
            transition: var(--transition);
        }
        .list-group-item:first-child {
            border-top: none;
        }
        .list-group-item:last-child {
            border-bottom: none;
        }
        
        /* Fix text visibility issues */
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        .text-primary {
            color: var(--primary-color) !important;
        }
        .text-secondary {
            color: var(--text-secondary) !important;
        }
        .text-muted {
            color: var(--text-muted) !important;
        }
        .text-white {
            color: #ffffff !important;
        }
        .text-dark {
            color: var(--text-primary) !important;
        }
        .text-light {
            color: var(--light-color) !important;
        }
        
        /* Ensure proper contrast for cards */
        .card {
            color: var(--text-primary);
        }
        .card-header {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            border-bottom: var(--border-width) solid var(--border-color);
        }
        .card-body {
            color: var(--text-primary);
        }
        
        /* Fix button colors */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #ffffff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            color: #ffffff;
        }
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: #ffffff;
        }
        .btn-light {
            background-color: var(--light-color);
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        .btn-outline-light {
            color: #ffffff;
            border-color: #ffffff;
        }
        .btn-outline-light:hover {
            background-color: #ffffff;
            color: var(--text-primary);
        }
        
        /* Fix alert colors */
        .alert-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
            color: #ffffff;
        }
        .alert-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
            color: #ffffff;
        }
        
        /* Fix list group items */
        .list-group-item {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            border-color: var(--border-color);
        }
        .list-group-item strong {
            color: var(--text-primary);
        }
        .list-group-item small {
            color: var(--text-muted);
        }
        
        /* Fix navbar text visibility */
        .navbar-nav .nav-link {
            color: var(--text-secondary) !important;
        }
        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
        }
        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
        }
        
        /* Fix dropdown menu */
        .dropdown-menu {
            background-color: var(--bg-primary);
            border: var(--border-width) solid var(--border-color);
            box-shadow: var(--shadow);
        }
        .dropdown-item {
            color: var(--text-primary);
        }
        .dropdown-item:hover {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
        }
        .dropdown-divider {
            border-color: var(--border-color);
        }
        
        /* Fix footer text */
        footer {
            color: var(--text-primary) !important;
        }
        footer p, footer small, footer span {
            color: var(--text-primary) !important;
        }
        footer a {
            color: var(--primary-color) !important;
        }
        footer a:hover {
            color: var(--text-secondary) !important;
        }
        
        /* Ensure all text elements have proper contrast */
        h1, h2, h3, h4, h5, h6 {
            color: var(--text-primary) !important;
        }
        p {
            color: var(--text-primary) !important;
        }
        span {
            color: inherit;
        }
        strong, b {
            color: var(--text-primary) !important;
        }
        small {
            color: var(--text-muted) !important;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= $view->url('') ?>">
                <img src="<?= $view->asset('iptoolssuite-logo.png') ?>" alt="IP Tools Suite Logo" height="40" class="me-2">
                IP Tools Suite
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $view->url('') ?>">
                            <i class="fa-solid fa-home"></i> <span data-translate="nav_home">Início</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $view->url('geologger/create') ?>">
                            <i class="fa-solid fa-map-pin"></i> <span data-translate="nav_geologger">Rastreador de Localização</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $view->url('geologger/logs') ?>">
                            <i class="fa-solid fa-chart-line"></i> <span data-translate="nav_logs">Painel de Logs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $view->url('phone-tracker/send_sms') ?>">
                            <i class="fa-solid fa-mobile-screen-button"></i> <span data-translate="nav_phone_tracker">Rastreador de Telefone</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $view->url('utils/speedtest') ?>">
                            <i class="fa-solid fa-gauge-high"></i> <span data-translate="nav_speed_test">Teste de Velocidade</span>
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
                                <li><a class="dropdown-item" href="<?= $view->url('dashboard') ?>">
                                    <i class="fa-solid fa-tachometer-alt"></i> Dashboard
                                </a></li>
                                <li><a class="dropdown-item" href="<?= $view->url('auth/profile') ?>">
                                    <i class="fa-solid fa-user-edit"></i> Profile
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= $view->url('auth/logout') ?>">
                                    <i class="fa-solid fa-sign-out-alt"></i> Logout
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $view->url('auth/login') ?>">
                                <i class="fa-solid fa-sign-in-alt"></i> <span data-translate="login">Entrar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $view->url('auth/register') ?>">
                                <i class="fa-solid fa-user-plus"></i> <span data-translate="register">Registrar</span>
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
    <footer class="bg-secondary py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-2">
                        <img src="<?= $view->asset('iptoolssuite-logo.png') ?>" alt="IP Tools Suite Logo" height="30" class="me-2">
                        <h5 class="mb-0">IP Tools Suite</h5>
                    </div>
                    <p class="mb-0">Ferramentas avançadas de rastreamento de IP e análise de rede.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        <a href="<?= $view->url('about') ?>" class="text-decoration-none">Sobre</a> |
                        <a href="<?= $view->url('contact') ?>" class="text-decoration-none">Contato</a> |
                        <a href="<?= $view->url('privacy') ?>" class="text-decoration-none">Privacidade</a> |
                        <a href="<?= $view->url('support') ?>" class="text-decoration-none">Suporte</a>
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