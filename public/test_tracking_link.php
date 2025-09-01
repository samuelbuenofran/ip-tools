<?php
// Force error display for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Tracking Link Generation Test</h1>";

echo "<h2>Step 1: Loading Required Classes</h2>";

// Load required classes
require_once __DIR__ . '/../app/Config/App.php';
require_once __DIR__ . '/../app/Config/Database.php';
require_once __DIR__ . '/../app/Models/GeoLink.php';

use App\Config\App;
use App\Models\GeoLink;

try {
    // Initialize app
    App::init();
    echo "✓ App::init() completed<br>";
    
    echo "<h2>Step 2: Testing GeoLink Model</h2>";
    
    try {
        $geoLink = new GeoLink();
        echo "✓ GeoLink model instantiated<br>";
        
        // Test generating a short code
        $shortCode = $geoLink->generateShortCode();
        echo "✓ Generated short code: " . $shortCode . "<br>";
        
        // Test tracking URL generation
        $trackingUrl = $geoLink->getTrackingUrl($shortCode);
        echo "✓ Generated tracking URL: " . $trackingUrl . "<br>";
        
        // Check if URL is correct format
        if (strpos($trackingUrl, 'precise_track.php') !== false) {
            echo "✗ URL still contains 'precise_track.php' (should be 'precise_track')<br>";
        } else {
            echo "✓ URL format is correct (no .php extension)<br>";
        }
        
        // Test QR code URL generation
        $qrCodeUrl = $geoLink->getQRCodeUrl($shortCode);
        echo "✓ Generated QR code URL: " . $qrCodeUrl . "<br>";
        
    } catch (Exception $e) {
        echo "✗ GeoLink model test failed: " . $e->getMessage() . "<br>";
    }
    
    echo "<h2>Step 3: Testing View File</h2>";
    
    $viewFile = __DIR__ . '/../app/Views/geologger/precise_track.php';
    if (file_exists($viewFile)) {
        echo "✓ precise_track.php view file exists<br>";
        
        // Check for proper redirect logic
        $content = file_get_contents($viewFile);
        if (strpos($content, 'redirectToDestination()') !== false) {
            echo "✓ View contains redirect logic<br>";
        } else {
            echo "✗ View missing redirect logic<br>";
        }
        
        if (strpos($content, 'window.location.href') !== false) {
            echo "✓ View contains JavaScript redirect<br>";
        } else {
            echo "✗ View missing JavaScript redirect<br>";
        }
        
    } else {
        echo "✗ precise_track.php view file not found<br>";
    }
    
    echo "<h2>Step 4: Testing Router Integration</h2>";
    
    try {
        require_once __DIR__ . '/../app/Core/Router.php';
        $router = new \App\Core\Router();
        echo "✓ Router instantiated<br>";
        
        // Test route matching
        if ($router->match('geologger/precise_track')) {
            echo "✓ 'geologger/precise_track' route matches<br>";
            $params = $router->getParams();
            echo "Route parameters: " . json_encode($params) . "<br>";
        } else {
            echo "✗ 'geologger/precise_track' route does not match<br>";
        }
        
    } catch (Exception $e) {
        echo "✗ Router integration test failed: " . $e->getMessage() . "<br>";
    }
    
    echo "<h2>Test Complete!</h2>";
    echo "<p>Tracking link generation test completed. Check results above.</p>";
    echo "<p><strong>Expected behavior:</strong> When someone clicks a tracking link, they should see a brief location tracking page, then be redirected to the original URL.</p>";
    
} catch (Exception $e) {
    echo "✗ Main test failed: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
} catch (Error $e) {
    echo "✗ Main test failed with Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
}
?>
