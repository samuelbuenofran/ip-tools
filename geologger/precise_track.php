<?php
require_once('../config.php');
$db = connectDB();

// Get the tracking code from URL
$code = $_GET['code'] ?? '';

if (empty($code)) {
    die('Invalid tracking code');
}

// Get the original link from database
$stmt = $db->prepare("SELECT original_url FROM geo_links WHERE short_code = ?");
$stmt->execute([$code]);
$link = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$link) {
    die('Link not found');
}

$original_url = $link['original_url'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Precise Location Tracking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .location-status {
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .status-loading { background-color: #fff3cd; border: 1px solid #ffeaa7; }
        .status-success { background-color: #d4edda; border: 1px solid #c3e6cb; }
        .status-error { background-color: #f8d7da; border: 1px solid #f5c6cb; }
        .accuracy-info {
            font-size: 0.9rem;
            color: #666;
            margin-top: 10px;
        }
        .redirect-button {
            margin-top: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4><i class="fa-solid fa-map-marker-alt"></i> Precise Location Tracking</h4>
                    </div>
                    <div class="card-body">
                        
                        <!-- Location Status Display -->
                        <div id="locationStatus" class="location-status status-loading">
                            <div class="text-center">
                                <div class="spinner-border text-warning" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <h5 class="mt-3">Getting Your Precise Location...</h5>
                                <p class="text-muted">Please allow location access when prompted by your browser.</p>
                                <div class="mt-3">
                                    <button id="skipLocationBtn" class="btn btn-outline-secondary btn-sm" onclick="skipLocation()">
                                        <i class="fa-solid fa-forward"></i> Skip Location & Continue
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Location Details (Hidden initially) -->
                        <div id="locationDetails" style="display: none;">
                            <h5><i class="fa-solid fa-location-dot text-success"></i> Location Captured!</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Latitude:</strong> <span id="latitude"></span></p>
                                    <p><strong>Longitude:</strong> <span id="longitude"></span></p>
                                    <p><strong>Accuracy:</strong> <span id="accuracy"></span> meters</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Street Address:</strong> <span id="address"></span></p>
                                    <p><strong>City:</strong> <span id="city"></span></p>
                                    <p><strong>Country:</strong> <span id="country"></span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Redirect Button -->
                        <div class="text-center redirect-button">
                            <a id="redirectButton" href="<?= htmlspecialchars($original_url) ?>" 
                               class="btn btn-success btn-lg" style="display: none;">
                                <i class="fa-solid fa-external-link-alt"></i> Continue to Destination
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Store tracking code for AJAX call
        const trackingCode = '<?= $code ?>';
        const originalUrl = '<?= htmlspecialchars($original_url) ?>';
        
        // Debug logging
        console.log('Script loaded successfully');
        console.log('Tracking code:', trackingCode);
        console.log('Original URL:', originalUrl);

        function updateStatus(message, type) {
            console.log('Updating status:', message, type);
            const statusDiv = document.getElementById('locationStatus');
            if (statusDiv) {
                statusDiv.className = `location-status status-${type}`;
                statusDiv.innerHTML = `
                    <div class="text-center">
                        <h5><i class="fa-solid fa-${type === 'success' ? 'check-circle text-success' : 'exclamation-triangle text-danger'}"></i> ${message}</h5>
                    </div>
                `;
            }
        }

        function saveIPBasedLocation() {
            console.log('Saving IP-based location...');
            const formData = new FormData();
            formData.append('code', trackingCode);
            formData.append('ip_only', 'true');
            formData.append('timestamp', new Date().toISOString());

            console.log('Sending request to save_precise_location.php');
            fetch('save_precise_location.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Response received:', response);
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                if (data.success) {
                    console.log('IP-based location saved successfully');
                } else {
                    console.error('Failed to save IP-based location:', data.error);
                }
            })
            .catch(error => {
                console.error('Error saving IP-based location:', error);
            });
        }

        function skipLocation() {
            console.log('Skip location clicked');
            try {
                updateStatus('Location tracking skipped. Proceeding with IP-based tracking...', 'error');
                saveIPBasedLocation();
                
                const redirectElement = document.getElementById('redirectButton');
                const skipElement = document.getElementById('skipLocationBtn');
                
                if (redirectElement) redirectElement.style.display = 'inline-block';
                if (skipElement) skipElement.style.display = 'none';
                
                console.log('Skip location completed successfully');
            } catch (error) {
                console.error('Error in skipLocation:', error);
                // Force show redirect button even if there's an error
                const redirectElement = document.getElementById('redirectButton');
                if (redirectElement) redirectElement.style.display = 'inline-block';
            }
        }

        // Show button immediately after 2 seconds
        setTimeout(() => {
            console.log('Showing redirect button immediately');
            const redirectElement = document.getElementById('redirectButton');
            if (redirectElement) {
                redirectElement.style.display = 'inline-block';
                updateStatus('Proceeding with IP-based tracking...', 'error');
                saveIPBasedLocation();
            }
        }, 2000);

        // Try geolocation if available, but don't wait for it
        if (navigator.geolocation) {
            console.log('Attempting geolocation...');
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    console.log('Geolocation success:', position);
                    updateStatus('Precise location captured!', 'success');
                    
                    // Save GPS location
                    const formData = new FormData();
                    formData.append('code', trackingCode);
                    formData.append('latitude', position.coords.latitude);
                    formData.append('longitude', position.coords.longitude);
                    formData.append('accuracy', position.coords.accuracy);
                    formData.append('timestamp', new Date().toISOString());

                    fetch('save_precise_location.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('GPS location saved successfully');
                        }
                    })
                    .catch(error => {
                        console.error('Error saving GPS location:', error);
                    });
                },
                function(error) {
                    console.log('Geolocation failed:', error);
                    // Don't update status here, let the immediate fallback handle it
                },
                {
                    enableHighAccuracy: false,
                    timeout: 3000,
                    maximumAge: 30000
                }
            );
        } else {
            console.log('Geolocation not supported');
        }
    </script>
</body>
</html>