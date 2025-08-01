<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\GeoLink;
use App\Models\GeoLog;
use App\Config\App;

class DashboardController extends Controller {
    private $geoLink;
    private $geoLog;
    
    public function __construct($params = []) {
        parent::__construct($params);
        $this->requireLogin(); // Require login for dashboard
        $this->geoLink = new GeoLink();
        $this->geoLog = new GeoLog();
    }
    
    public function index() {
        // Get user info
        $user = $this->getCurrentUser();
        
        // Get statistics
        $stats = $this->geoLog->getStats();
        $recentLogs = $this->geoLog->getRecentActivity(5);
        $recentLinks = $this->geoLink->getRecentLinks(5);
        
        $data = [
            'title' => 'Dashboard - ' . App::APP_NAME,
            'user' => $user,
            'stats' => $stats,
            'recent_logs' => $recentLogs,
            'recent_links' => $recentLinks,
            'csrf_token' => $this->generateCSRFToken()
        ];
        
        return $this->render('dashboard/index', $data);
    }
} 