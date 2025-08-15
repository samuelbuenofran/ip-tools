<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Dropdown Fix Test - IP Tools Suite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/dropdown-simple-fix.css" rel="stylesheet">
    <style>
        .test-section {
            margin: 2rem 0;
            padding: 2rem;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            background: #f8f9fa;
        }
        .overlapping-element {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 1rem;
            border-radius: 10px;
            margin: 1rem 0;
            position: relative;
            z-index: 1;
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
    <!-- Navigation with simple fixes applied -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fa-solid fa-tools"></i> IP Tools Suite
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
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user"></i> admin
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
            <i class="fa-solid fa-check-circle text-success"></i> Simple Dropdown Fix Test
        </h1>
        
        <div class="alert alert-success">
            <i class="fa-solid fa-info-circle"></i>
            <strong>Simple Dropdown Fix Applied!</strong> This page uses a simplified approach with maximum z-index (999999).
        </div>

        <!-- Multiple Overlapping Elements Test -->
        <div class="test-section">
            <h3><i class="fa-solid fa-exclamation-triangle text-warning"></i> Overlapping Elements Test</h3>
            <p>These elements should NOT cover the dropdown menu anymore.</p>
            
            <!-- Blue overlapping element (same as the problematic one) -->
            <div class="overlapping-element">
                <h5><i class="fa-solid fa-shield-alt"></i> Blue Admin Panel Section</h5>
                <p>This blue section was previously covering the dropdown menu. Now it should stay below it.</p>
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-warning">
                            <i class="fa-solid fa-shield-alt"></i> Admin Panel
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-light">
                            <i class="fa-solid fa-user"></i> Perfil
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Another blue element -->
            <div class="overlapping-element">
                <h5><i class="fa-solid fa-cog"></i> Settings Section</h5>
                <p>Another potentially overlapping element to test the z-index fix.</p>
                <button class="btn btn-info">
                    <i class="fa-solid fa-cog"></i> Settings
                </button>
            </div>
        </div>

        <!-- Welcome Message Test (Same as the problematic one) -->
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
                        <small class="d-block fw-bold text-white">Bem-vindo, admin!</small>
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

        <!-- Test Instructions -->
        <div class="test-section">
            <h3><i class="fa-solid fa-mouse-pointer text-primary"></i> Test Instructions</h3>
            <ol>
                <li><strong>Click on "admin"</strong> in the top-right corner of the navbar</li>
                <li><strong>Check the dropdown:</strong> It should appear and be fully visible</li>
                <li><strong>Verify no overlap:</strong> The blue sections should NOT cover the dropdown</li>
                <li><strong>Check text readability:</strong> White text on blue background should be perfect</li>
                <li><strong>Check console:</strong> Look for "Simple Dropdown Fix loaded" message</li>
            </ol>
            
            <div class="alert alert-info">
                <i class="fa-solid fa-lightbulb"></i>
                <strong>Debugging:</strong> Open browser console (F12) and look for "Simple Dropdown Fix loaded" and "Simple Dropdown Fix applied successfully".
            </div>
        </div>

        <!-- Force Test Button -->
        <div class="test-section">
            <h3><i class="fa-solid fa-bolt text-warning"></i> Force Test</h3>
            <p>If the dropdown still doesn't work, click this button to force apply all fixes:</p>
            <button class="btn btn-warning btn-lg" onclick="forceAllFixes()">
                <i class="fa-solid fa-bolt"></i> Force Apply All Fixes
            </button>
            <div id="forceTestResult" class="mt-3"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/dropdown-simple-fix.js"></script>
    <script>
        // Force test function
        function forceAllFixes() {
            const resultDiv = document.getElementById('forceTestResult');
            resultDiv.innerHTML = '<div class="alert alert-info">Applying all fixes...</div>';
            
            // Force dropdown styles
            const dropdowns = document.querySelectorAll('.dropdown');
            let fixedCount = 0;
            
            dropdowns.forEach(dropdown => {
                const dropdownMenu = dropdown.querySelector('.dropdown-menu');
                if (dropdownMenu) {
                    // Force maximum z-index
                    dropdownMenu.style.zIndex = '999999';
                    dropdownMenu.style.position = 'absolute';
                    dropdownMenu.style.background = '#007bff';
                    dropdownMenu.style.border = '2px solid #ffffff';
                    dropdownMenu.style.borderRadius = '8px';
                    dropdownMenu.style.boxShadow = '0 10px 40px rgba(0, 0, 0, 0.3)';
                    dropdownMenu.style.minWidth = '200px';
                    
                    // Force dropdown items
                    const dropdownItems = dropdownMenu.querySelectorAll('.dropdown-item');
                    dropdownItems.forEach(item => {
                        item.style.background = '#007bff';
                        item.style.color = '#ffffff';
                        item.style.fontWeight = '600';
                        item.style.textShadow = '0 1px 2px rgba(0, 0, 0, 0.5)';
                    });
                    
                    fixedCount++;
                }
            });
            
            // Force all other elements to stay below
            const allElements = document.querySelectorAll('.container, .row, .col, [class*="col-"], .card, .btn, .alert, .bg-primary, .welcome-card, .overlapping-element');
            allElements.forEach(el => {
                el.style.position = 'relative';
                el.style.zIndex = '1';
            });
            
            resultDiv.innerHTML = `<div class="alert alert-success">✅ Fixed ${fixedCount} dropdown(s) and forced all elements to z-index: 1</div>`;
            
            // Test dropdown
            setTimeout(() => {
                const dropdownToggle = document.querySelector('.dropdown-toggle');
                if (dropdownToggle) {
                    dropdownToggle.click();
                    setTimeout(() => {
                        resultDiv.innerHTML += '<div class="alert alert-info">🔍 Dropdown should now be visible above all elements</div>';
                    }, 100);
                }
            }, 500);
        }
        
        // Log when page loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Simple Dropdown Test page loaded');
        });
    </script>
</body>
</html>
