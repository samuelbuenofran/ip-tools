<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theme Demo - IP Tools Suite</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/themes.css">
    <link rel="stylesheet" href="assets/unified-styles.css">
    
    <style>
        .theme-preview {
            border: 2px solid var(--border-color);
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            transition: all 0.3s ease;
            background: var(--bg-primary);
        }
        
        .theme-preview:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
        
        .color-palette {
            display: flex;
            gap: 10px;
            margin: 15px 0;
            flex-wrap: wrap;
        }
        
        .color-swatch {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        
        .feature-showcase {
            background: var(--bg-secondary);
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
            border: 1px solid var(--border-color);
        }
        
        .glass-effect-demo {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            margin: 30px 0;
            text-align: center;
            color: white;
        }
        

    </style>
</head>
<body data-theme="macos-aqua">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="assets/iptoolssuite-logo.png" alt="IP Tools Suite" height="40">
                IP Tools Suite
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php">Home</a>
                <a class="nav-link" href="geologger/">GeoLogger</a>
                <a class="nav-link" href="speed-test/">Speed Test</a>
                <a class="nav-link" href="phone-tracker/">Phone Tracker</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-5">
                    <i class="fa-solid fa-palette me-3"></i>
                    Theme Showcase
                </h1>
                <p class="text-center lead mb-5">
                    Explore our collection of beautiful themes designed for comfort and style
                </p>
            </div>
        </div>

        <!-- Theme Previews -->
        <div class="row">
            <!-- macOS Aqua Theme -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="theme-preview" data-theme="macos-aqua">
                    <h4><i class="fa-solid fa-apple-whole me-2"></i>macOS Aqua</h4>
                    <p class="text-muted">Classic macOS X Leopard Aqua theme with clean lines and familiar aesthetics.</p>
                    <div class="color-palette">
                        <div class="color-swatch" style="background: #0066cc;">P</div>
                        <div class="color-swatch" style="background: #f0f0f0; color: #333;">S</div>
                        <div class="color-swatch" style="background: #28a745;">S</div>
                        <div class="color-swatch" style="background: #dc3545;">D</div>
                    </div>
                    <button class="btn btn-primary btn-sm w-100" onclick="switchTheme('macos-aqua')">
                        Apply Theme
                    </button>
                </div>
            </div>

            <!-- Dim Theme -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="theme-preview" data-theme="dim">
                    <h4><i class="fa-solid fa-moon me-2"></i>Dim</h4>
                    <p class="text-muted">Soft, dimmed palette designed to reduce eye strain during extended use.</p>
                    <div class="color-palette">
                        <div class="color-swatch" style="background: #5a6acf;">P</div>
                        <div class="color-swatch" style="background: #e9ecef; color: #333;">S</div>
                        <div class="color-swatch" style="background: #4caf50;">S</div>
                        <div class="color-swatch" style="background: #f44336;">D</div>
                    </div>
                    <button class="btn btn-primary btn-sm w-100" onclick="switchTheme('dim')">
                        Apply Theme
                    </button>
                </div>
            </div>

            <!-- Dark Dim Theme -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="theme-preview" data-theme="dark-dim">
                    <h4><i class="fa-solid fa-moon me-2"></i>Dark Dim</h4>
                    <p class="text-muted">Dark theme with carefully dimmed colors for comfortable night-time viewing.</p>
                    <div class="color-palette">
                        <div class="color-swatch" style="background: #4a9eff;">P</div>
                        <div class="color-swatch" style="background: #2d2d2d; color: #fff;">S</div>
                        <div class="color-swatch" style="background: #28a745;">S</div>
                        <div class="color-swatch" style="background: #dc3545;">D</div>
                    </div>
                    <button class="btn btn-primary btn-sm w-100" onclick="switchTheme('dark-dim')">
                        Apply Theme
                    </button>
                </div>
            </div>

            <!-- Liquid Glass Theme -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="theme-preview" data-theme="liquid-glass">
                    <h4><i class="fa-solid fa-droplet me-2"></i>Liquid Glass</h4>
                    <p class="text-muted">Modern glassmorphism with liquid animations and translucent effects.</p>
                    <div class="color-palette">
                        <div class="color-swatch" style="background: #00d4ff;">P</div>
                        <div class="color-swatch" style="background: #7b68ee;">S</div>
                        <div class="color-swatch" style="background: #00ff88;">S</div>
                        <div class="color-swatch" style="background: #ff4757;">D</div>
                    </div>
                    <button class="btn btn-primary btn-sm w-100" onclick="switchTheme('liquid-glass')">
                        Apply Theme
                    </button>
                </div>
            </div>
        </div>

        <!-- Feature Showcase -->
        <div class="feature-showcase">
            <h3 class="text-center mb-4">
                <i class="fa-solid fa-star me-2"></i>
                Theme Features
            </h3>
            <div class="row">
                <div class="col-md-4 text-center mb-3">
                    <i class="fa-solid fa-eye fa-3x text-primary mb-3"></i>
                    <h5>Eye Comfort</h5>
                    <p>Carefully designed color palettes to reduce eye strain during extended use.</p>
                </div>
                <div class="col-md-4 text-center mb-3">
                    <i class="fa-solid fa-palette fa-3x text-primary mb-3"></i>
                    <h5>Multiple Themes</h5>
                    <p>Choose from classic, dimmed, dark, and modern glassmorphism themes.</p>
                </div>
                <div class="col-md-4 text-center mb-3">
                    <i class="fa-solid fa-mobile-screen fa-3x text-primary mb-3"></i>
                    <h5>Responsive Design</h5>
                    <p>All themes are fully responsive and work perfectly on all devices.</p>
                </div>
            </div>
        </div>

        <!-- Liquid Glass Demo -->
        <div class="glass-effect-demo" id="liquidGlassDemo" style="display: none;">
            <h2><i class="fa-solid fa-droplet me-3"></i>Frosted Glass Effect</h2>
            <p class="lead">Experience the modern glassmorphism design with translucent frosted glass elements</p>
            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <div class="card" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.12);">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-eye fa-2x mb-3"></i>
                            <h5>Frosted Glass</h5>
                            <p>Translucent backgrounds with subtle backdrop blur effects</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.12);">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-layer-group fa-2x mb-3"></i>
                            <h5>Layered Depth</h5>
                            <p>Multiple translucent layers create visual depth</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.12);">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-palette fa-2x mb-3"></i>
                            <h5>Subtle Transparency</h5>
                            <p>Carefully balanced opacity for elegant glass effects</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Component Examples -->
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fa-solid fa-list me-2"></i>Form Components</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label for="exampleInput" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="exampleInput" placeholder="Enter email">
                            </div>
                            <div class="mb-3">
                                <label for="exampleSelect" class="form-label">Select option</label>
                                <select class="form-select" id="exampleSelect">
                                    <option>Option 1</option>
                                    <option>Option 2</option>
                                    <option>Option 3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="exampleTextarea" class="form-label">Message</label>
                                <textarea class="form-control" id="exampleTextarea" rows="3" placeholder="Enter your message"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-outline-secondary">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fa-solid fa-table me-2"></i>Data Display</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>John Doe</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">Edit</button>
                                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jane Smith</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">Edit</button>
                                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts Demo -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    <i class="fa-solid fa-check-circle me-2"></i>
                    <strong>Success!</strong> This is a success alert with the current theme styling.
                </div>
                <div class="alert alert-info" role="alert">
                    <i class="fa-solid fa-info-circle me-2"></i>
                    <strong>Info!</strong> This is an info alert with the current theme styling.
                </div>
                <div class="alert alert-warning" role="alert">
                    <i class="fa-solid fa-exclamation-triangle me-2"></i>
                    <strong>Warning!</strong> This is a warning alert with the current theme styling.
                </div>
                <div class="alert alert-danger" role="alert">
                    <i class="fa-solid fa-times-circle me-2"></i>
                    <strong>Error!</strong> This is a danger alert with the current theme styling.
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">
                <img src="assets/iptoolssuite-logo.png" alt="IP Tools Suite" height="30" class="me-2">
                IP Tools Suite - Professional IP and Network Tools
            </p>
            <small class="text-muted">© 2024 IP Tools Suite. All rights reserved.</small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Theme Switcher -->
    <script src="assets/theme-switcher.js"></script>
    
    <script>
        function switchTheme(themeId) {
            if (window.themeSwitcher) {
                window.themeSwitcher.switchTheme(themeId);
            }
            
            // Show/hide liquid glass demo
            const liquidDemo = document.getElementById('liquidGlassDemo');
            if (themeId === 'liquid-glass') {
                liquidDemo.style.display = 'block';
            } else {
                liquidDemo.style.display = 'none';
            }
        }
        
        // Initialize theme switcher
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for theme switcher to initialize
            setTimeout(() => {
                if (window.themeSwitcher) {
                    // Show liquid glass demo if that theme is active
                    const currentTheme = window.themeSwitcher.getCurrentTheme();
                    if (currentTheme && currentTheme.id === 'liquid-glass') {
                        document.getElementById('liquidGlassDemo').style.display = 'block';
                    }
                }
            }, 500);
        });
    </script>
</body>
</html> 