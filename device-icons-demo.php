<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device Icons Demo - IP Tools Suite</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .device-icon {
            vertical-align: middle;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
            transition: transform 0.2s ease;
        }
        
        .device-icon:hover {
            transform: scale(1.1);
        }
        
        .device-label {
            font-size: 0.85rem;
            color: #6c757d;
            margin-left: 0.5rem;
        }
        
        .device-display {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .icon-showcase {
            padding: 2rem;
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            margin: 1rem 0;
            text-align: center;
        }
        
        .icon-showcase:hover {
            border-color: #007bff;
            background-color: rgba(0, 123, 255, 0.05);
        }
        
        .demo-section {
            margin: 3rem 0;
        }
        
        .demo-title {
            color: #495057;
            border-bottom: 2px solid #007bff;
            padding-bottom: 0.5rem;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-5">
                    <i class="fa-solid fa-mobile-alt text-primary me-3"></i>
                    Device Icons Demo
                </h1>
                
                <div class="alert alert-info">
                    <i class="fa-solid fa-info-circle me-2"></i>
                    This demo showcases the new device icons for tracking user devices in IP Tools Suite.
                </div>
                
                <!-- Device Icons Showcase -->
                <div class="demo-section">
                    <h2 class="demo-title">Device Icons Overview</h2>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="icon-showcase">
                                <h5>Mobile Device</h5>
                                <img src="assets/icons/phone.svg" alt="Mobile Device" class="device-icon" style="width: 64px; height: 64px;">
                                <p class="mt-2 text-muted">Phone icon for mobile devices</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="icon-showcase">
                                <h5>Desktop Computer</h5>
                                <img src="assets/icons/desktop-computer.svg" alt="Desktop Computer" class="device-icon" style="width: 64px; height: 64px;">
                                <p class="mt-2 text-muted">Computer icon for desktop devices</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="icon-showcase">
                                <h5>Error Stop</h5>
                                <img src="assets/icons/error-stop.svg" alt="Error Stop" class="device-icon" style="width: 64px; height: 64px;">
                                <p class="mt-2 text-muted">Error icon for error pages</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="icon-showcase">
                                <h5>Unknown Device</h5>
                                <i class="fa-solid fa-question-circle text-muted" style="font-size: 64px;"></i>
                                <p class="mt-2 text-muted">Fallback icon for unknown devices</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Device Detection Demo -->
                <div class="demo-section">
                    <h2 class="demo-title">Device Detection Demo</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fa-solid fa-code me-2"></i>
                                        Test User Agent
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="userAgent" class="form-label">User Agent String:</label>
                                        <textarea class="form-control" id="userAgent" rows="3" placeholder="Enter a user agent string to test device detection...">Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.2 Mobile/15E148 Safari/604.1</textarea>
                                    </div>
                                    <button class="btn btn-primary" onclick="detectDevice()">
                                        <i class="fa-solid fa-search me-2"></i>
                                        Detect Device
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fa-solid fa-info-circle me-2"></i>
                                        Detection Result
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div id="detectionResult" class="text-center">
                                        <p class="text-muted">Enter a user agent and click "Detect Device" to see the result.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Usage Examples -->
                <div class="demo-section">
                    <h2 class="demo-title">Usage Examples</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fa-solid fa-table me-2"></i>
                                        Table Display
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Device Type</th>
                                                <th>Icon</th>
                                                <th>Label</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Mobile</td>
                                                <td><img src="assets/icons/phone.svg" alt="Mobile" class="device-icon" style="width: 20px; height: 20px;"></td>
                                                <td>Mobile Device</td>
                                            </tr>
                                            <tr>
                                                <td>Desktop</td>
                                                <td><img src="assets/icons/desktop-computer.svg" alt="Desktop" class="device-icon" style="width: 20px; height: 20px;"></td>
                                                <td>Desktop Computer</td>
                                            </tr>
                                            <tr>
                                                <td>Tablet</td>
                                                <td><img src="assets/icons/phone.svg" alt="Tablet" class="device-icon" style="width: 20px; height: 20px;"></td>
                                                <td>Tablet Device</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fa-solid fa-chart-pie me-2"></i>
                                        Statistics Display
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-around text-center">
                                        <div>
                                            <img src="assets/icons/phone.svg" alt="Mobile" class="device-icon" style="width: 32px; height: 32px;">
                                            <div class="mt-2">
                                                <h4 class="text-primary">42</h4>
                                                <small class="text-muted">Mobile</small>
                                            </div>
                                        </div>
                                        <div>
                                            <img src="assets/icons/desktop-computer.svg" alt="Desktop" class="device-icon" style="width: 32px; height: 32px;">
                                            <div class="mt-2">
                                                <h4 class="text-success">28</h4>
                                                <small class="text-muted">Desktop</small>
                                            </div>
                                        </div>
                                        <div>
                                            <img src="assets/icons/phone.svg" alt="Tablet" class="device-icon" style="width: 32px; height: 32px;">
                                            <div class="mt-2">
                                                <h4 class="text-info">15</h4>
                                                <small class="text-muted">Tablet</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Implementation Notes -->
                <div class="demo-section">
                    <h2 class="demo-title">Implementation Notes</h2>
                    <div class="card">
                        <div class="card-body">
                            <h6>Features:</h6>
                            <ul>
                                <li><strong>Device Detection:</strong> Automatically detects device type from user agent strings</li>
                                <li><strong>Icon Display:</strong> Shows appropriate icons for mobile, desktop, and tablet devices</li>
                                <li><strong>Error Handling:</strong> Uses error-stop.svg for error pages</li>
                                <li><strong>Responsive Design:</strong> Icons scale appropriately for different screen sizes</li>
                                <li><strong>Accessibility:</strong> Includes alt text and titles for screen readers</li>
                            </ul>
                            
                            <h6>Usage:</h6>
                            <ul>
                                <li><strong>Tracking Logs:</strong> Device icons appear in the visitor logs table</li>
                                <li><strong>Statistics:</strong> Device breakdown shown in dashboard stats</li>
                                <li><strong>Error Pages:</strong> 404 and 500 errors use the error-stop icon</li>
                                <li><strong>Custom Sizes:</strong> Icons can be resized for different contexts</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function detectDevice() {
            const userAgent = document.getElementById('userAgent').value;
            const resultDiv = document.getElementById('detectionResult');
            
            if (!userAgent.trim()) {
                resultDiv.innerHTML = '<p class="text-warning">Please enter a user agent string.</p>';
                return;
            }
            
            // Simple device detection logic (same as PHP)
            const ua = userAgent.toLowerCase();
            let deviceType = 'unknown';
            let deviceLabel = 'Unknown Device';
            let iconPath = '';
            
            if (ua.includes('android') || ua.includes('iphone') || ua.includes('ipad') || ua.includes('ipod') || ua.includes('blackberry') || ua.includes('windows phone') || ua.includes('mobile') || ua.includes('tablet')) {
                deviceType = 'mobile';
                deviceLabel = 'Mobile Device';
                iconPath = 'assets/icons/phone.svg';
            } else if (ua.includes('windows') || ua.includes('macintosh') || ua.includes('linux') || ua.includes('ubuntu') || ua.includes('debian') || ua.includes('centos') || ua.includes('fedora')) {
                deviceType = 'desktop';
                deviceLabel = 'Desktop Computer';
                iconPath = 'assets/icons/desktop-computer.svg';
            }
            
            if (ua.includes('ipad') || ua.includes('android') && ua.includes('tablet')) {
                deviceType = 'tablet';
                deviceLabel = 'Tablet Device';
                iconPath = 'assets/icons/phone.svg';
            }
            
            let iconHtml = '';
            if (iconPath) {
                iconHtml = `<img src="${iconPath}" alt="${deviceLabel}" class="device-icon" style="width: 48px; height: 48px;">`;
            } else {
                iconHtml = '<i class="fa-solid fa-question-circle text-muted" style="font-size: 48px;"></i>';
            }
            
            resultDiv.innerHTML = `
                <div class="text-center">
                    ${iconHtml}
                    <h5 class="mt-3">${deviceLabel}</h5>
                    <p class="text-muted">Device Type: <strong>${deviceType}</strong></p>
                    <span class="badge bg-${deviceType === 'mobile' ? 'primary' : deviceType === 'desktop' ? 'success' : deviceType === 'tablet' ? 'info' : 'secondary'}">${deviceType.toUpperCase()}</span>
                </div>
            `;
        }
    </script>
</body>
</html>
