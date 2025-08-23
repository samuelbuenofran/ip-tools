<?php
require_once('config.php');

// Page-specific variables for the layout
$page_title = 'Test Unified Layout - IP Tools Suite';
$page_description = 'Testing the unified layout system to ensure consistent styling across all pages.';

// Page-specific CSS
$page_css = '
<style>
    .test-section {
        background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
        color: white;
        padding: 60px 0;
        margin: 0;
        border-radius: 0;
    }
    
    .test-card {
        background: white;
        color: #333;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin: 20px 0;
    }
</style>
';

// Start output buffering to capture content
ob_start();
?>

<!-- Test Section -->
<section class="test-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold mb-4">
                    <i class="fa-solid fa-check-circle me-3"></i>
                    Unified Layout Test
                </h1>
                <p class="lead mb-4">
                    This page tests the unified layout system to ensure consistent styling across all pages.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Test Cards -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="test-card">
                    <h3><i class="fa-solid fa-palette me-2"></i>Consistent Styling</h3>
                    <p>All pages now use the same layout structure and CSS rules, ensuring uniform appearance.</p>
                    <ul>
                        <li>No more margin/padding inconsistencies</li>
                        <li>Unified navbar styling</li>
                        <li>Consistent spacing and layout</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="test-card">
                    <h3><i class="fa-solid fa-code me-2"></i>Technical Benefits</h3>
                    <p>The new system provides better maintainability and consistency.</p>
                    <ul>
                        <li>Single source of truth for layout</li>
                        <li>Easier to make global changes</li>
                        <li>Reduced code duplication</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12 text-center">
                <div class="test-card">
                    <h3><i class="fa-solid fa-link me-2"></i>Navigation Test</h3>
                    <p>Click the links below to test navigation consistency:</p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="/projects/ip-tools/" class="btn btn-primary">
                            <i class="fa-solid fa-home me-2"></i>Home
                        </a>
                        <a href="/projects/ip-tools/speed-test-info.php" class="btn btn-success">
                            <i class="fa-solid fa-gauge-high me-2"></i>Speed Test
                        </a>
                        <a href="/projects/ip-tools/geolocation-tracker-info.php" class="btn btn-info">
                            <i class="fa-solid fa-map-pin me-2"></i>Geolocation
                        </a>
                        <a href="/projects/ip-tools/phone-tracker-info.php" class="btn btn-warning">
                            <i class="fa-solid fa-mobile-screen-button me-2"></i>Phone Tracker
                        </a>
                        <a href="/projects/ip-tools/logs-dashboard-info.php" class="btn btn-secondary">
                            <i class="fa-solid fa-chart-line me-2"></i>Logs Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Get the buffered content
$content = ob_get_clean();

// Include the unified layout
include('app/Views/layouts/main.php');
?>
