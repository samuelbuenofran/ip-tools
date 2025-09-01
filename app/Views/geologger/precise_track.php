<?php /* Layout is handled automatically by the View class */ ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h4><i class="fa-solid fa-map-pin text-primary"></i> Location Tracking</h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fa-solid fa-location-dot fa-3x text-primary mb-3"></i>
                        <h5>Preparing to redirect...</h5>
                        <p class="text-muted">We're gathering location data before redirecting you to your destination.</p>
                    </div>
                    
                    <div class="progress mb-4" style="height: 6px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                             role="progressbar" style="width: 0%" id="progressBar"></div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fa-solid fa-info-circle"></i>
                        <strong>Destination:</strong> <?= htmlspecialchars($link['original_url']) ?>
                    </div>
                    
                    <div class="mt-4">
                        <button class="btn btn-primary" onclick="skipTracking()">
                            <i class="fa-solid fa-forward"></i> Skip & Continue
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Track location and redirect
let progress = 0;
const progressBar = document.getElementById('progressBar');

// Simulate progress
const progressInterval = setInterval(() => {
    progress += 10;
    progressBar.style.width = progress + '%';
    
    if (progress >= 100) {
        clearInterval(progressInterval);
        redirectToDestination();
    }
}, 200);

// Get user's location
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        function(position) {
            // Send location data to server
            sendLocationData(position.coords.latitude, position.coords.longitude);
        },
        function(error) {
            console.log('Geolocation error:', error);
            // Continue without location data
        }
    );
} else {
    console.log('Geolocation not supported');
}

function sendLocationData(lat, lng) {
    fetch('<?= $view->url('geologger/save_precise_location') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            code: '<?= $code ?>',
            latitude: lat,
            longitude: lng,
            csrf_token: '<?= $_SESSION['csrf_token'] ?? '' ?>'
        })
    }).catch(error => {
        console.log('Error sending location data:', error);
    });
}

function redirectToDestination() {
    window.location.href = '<?= htmlspecialchars($link['original_url']) ?>';
}

function skipTracking() {
    clearInterval(progressInterval);
    redirectToDestination();
}

// Auto-redirect after 5 seconds if user doesn't interact
setTimeout(() => {
    if (progress < 100) {
        clearInterval(progressInterval);
        redirectToDestination();
    }
}, 5000);
</script>
