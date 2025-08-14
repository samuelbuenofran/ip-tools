<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Test - IP Tools Suite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/themes.css" rel="stylesheet">
    <link href="assets/navbar-fixes.css" rel="stylesheet">
    <style>
        .test-section {
            margin: 2rem 0;
            padding: 2rem;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            background: #f8f9fa;
        }
        .demo-dropdown {
            position: relative;
            display: inline-block;
        }
        .welcome-card {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: 0 8px 32px rgba(0, 123, 255, 0.3);
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navigation with fixes applied -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="assets/iptoolssuite-logo.png" alt="IP Tools Suite Logo" height="40" class="me-2">
                IP Tools Suite
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-map-pin"></i> Geolocation
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-chart-line"></i> Logs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-mobile-screen-button"></i> Phone Tracker
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-gauge-high"></i> Speed Test
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user"></i> Admin User
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">
                                <i class="fa-solid fa-tachometer-alt"></i> Dashboard
                            </a></li>
                            <li><a class="dropdown-item" href="#">
                                <i class="fa-solid fa-user-edit"></i> Profile
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">
                                <i class="fa-solid fa-sign-out-alt"></i> Logout
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center mb-5">
            <i class="fa-solid fa-check-circle text-success"></i> Navbar Fixes Test Page
        </h1>
        
        <div class="alert alert-success">
            <i class="fa-solid fa-info-circle"></i>
            <strong>Navbar Issues Fixed!</strong> This page demonstrates the improvements made to the navbar, dropdown menu, and welcome text visibility.
        </div>

        <!-- Welcome Message Test -->
        <div class="welcome-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="text-white fw-bold">
                        <i class="fa-solid fa-tachometer-alt"></i> Bem-vindo ao IP Tools Suite
                    </h3>
                    <p class="mb-0 text-white fw-medium">
                        Seu kit completo de ferramentas para rastreamento de IP e análise de rede.
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="text-white">
                        <small class="d-block fw-bold text-white">Bem-vindo, Admin User!</small>
                        <a href="#" class="btn btn-light btn-sm">
                            <i class="fa-solid fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm">
                            <i class="fa-solid fa-sign-out-alt"></i> Sair
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Test Sections -->
        <div class="test-section">
            <h3><i class="fa-solid fa-list-check text-primary"></i> What Was Fixed</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-success">
                                <i class="fa-solid fa-check"></i> Dropdown Transparency
                            </h5>
                            <p class="card-text">
                                The dropdown menu now has proper background opacity (98%) with backdrop blur for better visibility.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-success">
                                <i class="fa-solid fa-check"></i> Welcome Text Visibility
                            </h5>
                            <p class="card-text">
                                "Bem-vindo" text now has enhanced contrast with bold font weight and text shadows.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-success">
                                <i class="fa-solid fa-check"></i> Navbar Font Colors
                            </h5>
                            <p class="card-text">
                                Navbar text now has proper contrast with text shadows and improved visibility.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="test-section">
            <h3><i class="fa-solid fa-cog text-warning"></i> Technical Improvements</h3>
            <ul class="list-group">
                <li class="list-group-item">
                    <i class="fa-solid fa-palette text-primary"></i>
                    <strong>Enhanced Background:</strong> Navbar now uses rgba(0, 123, 255, 0.95) with backdrop-filter blur
                </li>
                <li class="list-group-item">
                    <i class="fa-solid fa-eye text-success"></i>
                    <strong>Better Contrast:</strong> All navbar text now has text shadows for improved readability
                </li>
                <li class="list-group-item">
                    <i class="fa-solid fa-window-maximize text-info"></i>
                    <strong>Dropdown Fixes:</strong> Dropdown menu has 98% white background with blur effects
                </li>
                <li class="list-group-item">
                    <i class="fa-solid fa-mobile-alt text-warning"></i>
                    <strong>Mobile Responsive:</strong> Enhanced mobile navigation with better visibility
                </li>
                <li class="list-group-item">
                    <i class="fa-solid fa-magic text-danger"></i>
                    <strong>Smooth Animations:</strong> Added hover effects and smooth transitions
                </li>
            </ul>
        </div>

        <div class="test-section">
            <h3><i class="fa-solid fa-code text-secondary"></i> CSS Classes Added</h3>
            <div class="row">
                <div class="col-md-6">
                    <h5>Navbar Enhancements:</h5>
                    <ul>
                        <li><code>.navbar</code> - Enhanced background with blur</li>
                        <li><code>.navbar-brand</code> - Improved logo styling</li>
                        <li><code>.nav-link</code> - Better text visibility</li>
                        <li><code>.dropdown-toggle</code> - Enhanced arrow styling</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5>Dropdown Improvements:</h5>
                    <ul>
                        <li><code>.dropdown-menu</code> - Fixed transparency</li>
                        <li><code>.dropdown-item</code> - Better contrast</li>
                        <li><code>.dropdown-divider</code> - Improved borders</li>
                        <li><code>.dropdown-item:hover</code> - Enhanced hover effects</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Interactive Test -->
        <div class="test-section">
            <h3><i class="fa-solid fa-mouse-pointer text-primary"></i> Interactive Test</h3>
            <p>Try clicking on the username "Admin User" in the top-right corner to see the improved dropdown menu!</p>
            
            <div class="demo-dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-cog"></i> Test Dropdown
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-star"></i> Test Item 1</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-heart"></i> Test Item 2</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-check"></i> Test Item 3</a></li>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
