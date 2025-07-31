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

        function updateStatus(message, type) {
            const statusDiv = document.getElementById('locationStatus');
            statusDiv.className = `location-status status-${type}`;
            statusDiv.innerHTML = `
                <div class="text-center">
                    <h5><i class="fa-solid fa-${type === 'success' ? 'check-circle text-success' : 'exclamation-triangle text-danger'}"></i> ${message}</h5>
                </div>
            `;
        }

        function showLocationDetails(location) {
            document.getElementById('latitude').textContent = location.latitude.toFixed(6);
            document.getElementById('longitude').textContent = location.longitude.toFixed(6);
            document.getElementById('accuracy').textContent = location.accuracy.toFixed(1);
            
            // Reverse geocoding to get address
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${location.latitude}&lon=${location.longitude}&zoom=18&addressdetails=1`)
                .then(response => response.json())
                .then(data => {
                    if (data.display_name) {
                        document.getElementById('address').textContent = data.display_name;
                        document.getElementById('city').textContent = data.address?.city || data.address?.town || 'Unknown';
                        document.getElementById('country').textContent = data.address?.country || 'Unknown';
                    }
                })
                .catch(error => {
                    console.error('Reverse geocoding failed:', error);
                    document.getElementById('address').textContent = 'Could not determine address';
                });

            document.getElementById('locationDetails').style.display = 'block';
            document.getElementById('redirectButton').style.display = 'inline-block';
        }

        function saveLocationToServer(location) {
            const formData = new FormData();
            formData.append('code', trackingCode);
            formData.append('latitude', location.latitude);
            formData.append('longitude', location.longitude);
            formData.append('accuracy', location.accuracy);
            formData.append('timestamp', new Date().toISOString());

            fetch('save_precise_location.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Location saved successfully');
                } else {
                    console.error('Failed to save location:', data.error);
                }
            })
            .catch(error => {
                console.error('Error saving location:', error);
            });
        }

        // Check if geolocation is supported
        if (!navigator.geolocation) {
            updateStatus('Geolocation is not supported by this browser.', 'error');
            return;
        }

        // Get precise location
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const location = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                    accuracy: position.coords.accuracy
                };

                // Show location details
                showLocationDetails(location);
                
                // Save to server
                saveLocationToServer(location);
                
                // Update status
                updateStatus('Precise location captured successfully!', 'success');
            },
            function(error) {
                let errorMessage = 'Unable to retrieve your location.';
                
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = 'Location access was denied. Please allow location access and try again.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = 'Location information is unavailable.';
                        break;
                    case error.TIMEOUT:
                        errorMessage = 'Location request timed out.';
                        break;
                }
                
                updateStatus(errorMessage, 'error');
                
                // Still show redirect button even if location failed
                document.getElementById('redirectButton').style.display = 'inline-block';
            },
            {
                enableHighAccuracy: true,  // Request highest accuracy
                timeout: 10000,           // 10 second timeout
                maximumAge: 300000        // Cache for 5 minutes
            }
        );
    </script>
</body>
</html>