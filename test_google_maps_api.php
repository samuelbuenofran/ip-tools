<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Maps API Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .test-section { margin: 20px 0; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .success { background-color: #d4edda; border-color: #c3e6cb; }
        .error { background-color: #f8d7da; border-color: #f5c6cb; }
        #map { width: 100%; height: 400px; border: 1px solid #ccc; margin: 20px 0; }
        .log { background: #f8f9fa; padding: 10px; border-radius: 4px; margin: 10px 0; font-family: monospace; }
    </style>
</head>
<body>
    <h1>🔍 Google Maps API Test</h1>
    
    <div class="test-section">
        <h3>1. API Key Status</h3>
        <p><strong>Your API Key:</strong> AIzaSyC5gMYj7gqRiwNlE6BxyLAdG9IMCCJZsrs</p>
        <p><strong>Key Length:</strong> <span id="keyLength"></span></p>
        <p><strong>Key Format:</strong> <span id="keyFormat"></span></p>
    </div>

    <div class="test-section">
        <h3>2. Map Loading Test</h3>
        <div id="map"></div>
        <div id="mapStatus" class="log">Waiting for map to load...</div>
    </div>

    <div class="test-section">
        <h3>3. Console Logs</h3>
        <div id="consoleLogs" class="log">Check browser console for detailed logs...</div>
    </div>

    <div class="test-section">
        <h3>4. Common Issues & Solutions</h3>
        <ul>
            <li><strong>API Key Invalid:</strong> Check if the key is active in Google Cloud Console</li>
            <li><strong>Billing Not Enabled:</strong> Google Maps API requires billing to be enabled</li>
            <li><strong>API Not Enabled:</strong> Make sure Maps JavaScript API and Visualization API are enabled</li>
            <li><strong>Domain Restrictions:</strong> Check if your domain is allowed in the API key settings</li>
            <li><strong>Quota Exceeded:</strong> Check if you've exceeded your daily quota</li>
        </ul>
    </div>

    <script>
        // Test 1: Check API key format
        const apiKey = 'AIzaSyC5gMYj7gqRiwNlE6BxyLAdG9MiCCJZsrs';
        document.getElementById('keyLength').textContent = apiKey.length + ' characters';
        document.getElementById('keyFormat').textContent = apiKey.startsWith('AIza') ? '✅ Valid format' : '❌ Invalid format';

        // Test 2: Load Google Maps
        let mapLoadAttempts = 0;
        const maxAttempts = 3;

        function loadGoogleMaps() {
            mapLoadAttempts++;
            console.log(`Attempt ${mapLoadAttempts} to load Google Maps...`);
            
            const script = document.createElement('script');
            script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=visualization&callback=initMap`;
            script.async = true;
            script.defer = true;
            
            script.onerror = function() {
                console.error('Failed to load Google Maps script');
                document.getElementById('mapStatus').innerHTML = '❌ Failed to load Google Maps script';
                document.getElementById('mapStatus').className = 'log error';
                
                if (mapLoadAttempts < maxAttempts) {
                    setTimeout(loadGoogleMaps, 2000);
                }
            };
            
            document.head.appendChild(script);
        }

        function initMap() {
            try {
                console.log('Google Maps loaded successfully!');
                document.getElementById('mapStatus').innerHTML = '✅ Google Maps loaded successfully!';
                document.getElementById('mapStatus').className = 'log success';
                
                // Create a simple map
                const map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 2,
                    center: { lat: 0, lng: 0 },
                    mapTypeId: 'roadmap'
                });
                
                // Test heatmap functionality
                if (google.maps.visualization) {
                    console.log('✅ Visualization library loaded');
                    const heatmap = new google.maps.visualization.HeatmapLayer({
                        data: [
                            new google.maps.LatLng(37.7749, -122.4194), // San Francisco
                            new google.maps.LatLng(40.7128, -74.0060), // New York
                            new google.maps.LatLng(51.5074, -0.1278)  // London
                        ],
                        radius: 20
                    });
                    heatmap.setMap(map);
                    console.log('✅ Heatmap created successfully');
                } else {
                    console.warn('⚠️ Visualization library not available');
                }
                
            } catch (error) {
                console.error('Error initializing map:', error);
                document.getElementById('mapStatus').innerHTML = '❌ Error initializing map: ' + error.message;
                document.getElementById('mapStatus').className = 'log error';
            }
        }

        // Start loading
        loadGoogleMaps();

        // Monitor console for errors
        const originalError = console.error;
        console.error = function(...args) {
            originalError.apply(console, args);
            const logsDiv = document.getElementById('consoleLogs');
            logsDiv.innerHTML += '<br>❌ ' + args.join(' ');
        };

        const originalWarn = console.warn;
        console.warn = function(...args) {
            originalWarn.apply(console, args);
            const logsDiv = document.getElementById('consoleLogs');
            logsDiv.innerHTML += '<br>⚠️ ' + args.join(' ');
        };

        const originalLog = console.log;
        console.log = function(...args) {
            originalLog.apply(console, args);
            const logsDiv = document.getElementById('consoleLogs');
            logsDiv.innerHTML += '<br>ℹ️ ' + args.join(' ');
        };
    </script>
</body>
</html>
