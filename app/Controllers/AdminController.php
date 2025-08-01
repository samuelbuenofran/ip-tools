<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Config\App;

class AdminController extends Controller {
    
    public function __construct($params = []) {
        parent::__construct($params);
    }
    
    public function privacySettings() {
        if ($this->isPost()) {
            $this->validateCSRF();
            
            $showLocationMessages = $this->getPost('show_location_messages') ? 'true' : 'false';
            $showTrackingUI = $this->getPost('show_tracking_ui') ? 'true' : 'false';
            $enableStealthRedirect = $this->getPost('enable_stealth_redirect') ? 'true' : 'false';
            
            // Update config.php file
            $configFile = __DIR__ . '/../../config.php';
            $configContent = file_get_contents($configFile);
            
            // Update constants
            $configContent = preg_replace(
                "/define\('SHOW_LOCATION_MESSAGES',\s*(true|false)\);/",
                "define('SHOW_LOCATION_MESSAGES', $showLocationMessages);",
                $configContent
            );
            
            $configContent = preg_replace(
                "/define\('SHOW_TRACKING_UI',\s*(true|false)\);/",
                "define('SHOW_TRACKING_UI', $showTrackingUI);",
                $configContent
            );
            
            // Add stealth redirect setting if it doesn't exist
            if (!strpos($configContent, 'ENABLE_STEALTH_REDIRECT')) {
                $configContent = str_replace(
                    "define('SHOW_TRACKING_UI', $showTrackingUI);",
                    "define('SHOW_TRACKING_UI', $showTrackingUI);\ndefine('ENABLE_STEALTH_REDIRECT', $enableStealthRedirect);",
                    $configContent
                );
            } else {
                $configContent = preg_replace(
                    "/define\('ENABLE_STEALTH_REDIRECT',\s*(true|false)\);/",
                    "define('ENABLE_STEALTH_REDIRECT', $enableStealthRedirect);",
                    $configContent
                );
            }
            
            if (file_put_contents($configFile, $configContent)) {
                $_SESSION['success_message'] = 'Privacy settings updated successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to update privacy settings.';
            }
            
            $this->redirect('/admin/privacy_settings');
        }
        
        $data = [
            'title' => 'Privacy Settings - ' . App::APP_NAME,
            'csrf_token' => $this->generateCSRFToken(),
            'success_message' => $_SESSION['success_message'] ?? null,
            'error_message' => $_SESSION['error_message'] ?? null
        ];
        
        // Clear session messages
        unset($_SESSION['success_message'], $_SESSION['error_message']);
        
        return $this->render('admin/privacy_settings', $data);
    }
} 