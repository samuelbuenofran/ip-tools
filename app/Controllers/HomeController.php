<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\GeoLink;
use App\Models\GeoLog;
use App\Config\App;

class HomeController extends Controller {
    private $geoLink;
    private $geoLog;
    
    public function __construct($params = []) {
        parent::__construct($params);
        try {
            $this->geoLink = new GeoLink();
            $this->geoLog = new GeoLog();
        } catch (Exception $e) {
            // Handle database connection error gracefully
            error_log("Database connection failed in HomeController: " . $e->getMessage());
            $this->geoLink = null;
            $this->geoLog = null;
        }
    }
    
    public function index() {
        // Try to get real data from database
        if ($this->geoLink && $this->geoLog) {
            try {
                $linkStats = [
                    'total_links' => $this->geoLink->getTotalLinks(),
                    'active_links' => $this->geoLink->getActiveLinks(),
                    'expired_links' => $this->geoLink->getExpiredLinks()
                ];
                
                $logStats = [
                    'total_clicks' => $this->geoLog->getTotalClicks(),
                    'unique_visitors' => $this->geoLog->getUniqueVisitors(),
                    'gps_tracking' => $this->geoLog->getGPSTrackingCount()
                ];
                
                $recentActivity = $this->geoLog->getRecentActivity(5);
            } catch (Exception $e) {
                error_log("Error fetching data in HomeController: " . $e->getMessage());
                // Fall back to zero values
                $linkStats = [
                    'total_links' => 0,
                    'active_links' => 0,
                    'expired_links' => 0
                ];
                
                $logStats = [
                    'total_clicks' => 0,
                    'unique_visitors' => 0,
                    'gps_tracking' => 0
                ];
                
                $recentActivity = [];
            }
        } else {
            // Database not available, use zero values
            $linkStats = [
                'total_links' => 0,
                'active_links' => 0,
                'expired_links' => 0
            ];
            
            $logStats = [
                'total_clicks' => 0,
                'unique_visitors' => 0,
                'gps_tracking' => 0
            ];
            
            $recentActivity = [];
        }
        
        $data = [
            'title' => 'Dashboard - ' . App::APP_NAME,
            'linkStats' => $linkStats,
            'logStats' => $logStats,
            'recentActivity' => $recentActivity,
            'csrf_token' => $this->generateCSRFToken()
        ];
        
        return $this->render('home/index', $data);
    }
    
    public function about() {
        $data = [
            'title' => 'About - ' . App::APP_NAME
        ];
        
        return $this->render('home/about', $data);
    }
    
    public function contact() {
        if ($this->isPost()) {
            $this->validateCSRF();
            
            $name = $this->sanitizeInput($this->getPost('name'));
            $email = $this->sanitizeInput($this->getPost('email'));
            $message = $this->sanitizeInput($this->getPost('message'));
            
            $errors = $this->validateRequired([
                'name' => $name,
                'email' => $email,
                'message' => $message
            ], ['name', 'email', 'message']);
            
            if (empty($errors)) {
                // Here you would typically send an email
                // For now, we'll just log it
                $this->logError('Contact form submission', [
                    'name' => $name,
                    'email' => $email,
                    'message' => $message
                ]);
                
                $_SESSION['success_message'] = 'Thank you for your message. We will get back to you soon!';
                $this->redirect('/contact');
            } else {
                $_SESSION['error_message'] = implode(', ', $errors);
                $_SESSION['form_data'] = [
                    'name' => $name,
                    'email' => $email,
                    'message' => $message
                ];
                $this->redirect('/contact');
            }
        }
        
        $data = [
            'title' => 'Contact - ' . App::APP_NAME,
            'csrf_token' => $this->generateCSRFToken(),
            'form_data' => $_SESSION['form_data'] ?? [],
            'error_message' => $_SESSION['error_message'] ?? null,
            'success_message' => $_SESSION['success_message'] ?? null
        ];
        
        // Clear session messages
        unset($_SESSION['form_data'], $_SESSION['error_message'], $_SESSION['success_message']);
        
        return $this->render('home/contact', $data);
    }
    
    public function privacy() {
        $data = [
            'title' => 'Privacy Policy - ' . App::APP_NAME
        ];
        
        return $this->render('home/privacy', $data);
    }
    
    public function support() {
        $data = [
            'title' => 'Support - ' . App::APP_NAME
        ];
        
        return $this->render('home/support', $data);
    }
} 