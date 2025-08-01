<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Config\App;

class SpeedTestController extends Controller {
    
    public function __construct($params = []) {
        parent::__construct($params);
    }
    
    public function index() {
        $data = [
            'title' => 'Speed Test - ' . App::APP_NAME,
            'csrf_token' => $this->generateCSRFToken()
        ];
        
        return $this->render('speed-test/index', $data);
    }
    
    public function save() {
        if (!$this->isPost()) {
            $this->renderJson(['success' => false, 'error' => 'Invalid request method']);
            return;
        }
        
        $downloadSpeed = $this->getPost('download_speed');
        $uploadSpeed = $this->getPost('upload_speed');
        $ping = $this->getPost('ping');
        $jitter = $this->getPost('jitter');
        
        if (!$downloadSpeed || !$uploadSpeed) {
            $this->renderJson(['success' => false, 'error' => 'Missing required data']);
            return;
        }
        
        try {
            $ip = App::getClientIP();
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
            
            // Get location data
            $geoData = @json_decode(file_get_contents(App::IP_API_URL . $ip), true);
            $country = $geoData['country'] ?? 'Unknown';
            $city = $geoData['city'] ?? 'Unknown';
            
            $db = $this->db->getConnection();
            $stmt = $db->prepare("
                INSERT INTO speed_tests (ip_address, user_agent, download_speed, upload_speed, ping, jitter, country, city, test_date)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            
            $stmt->execute([
                $ip,
                $userAgent,
                $downloadSpeed,
                $uploadSpeed,
                $ping,
                $jitter,
                $country,
                $city
            ]);
            
            $this->renderJson(['success' => true, 'message' => 'Speed test results saved']);
            
        } catch (\Exception $e) {
            $this->renderJson(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public function analytics() {
        $data = [
            'title' => 'Speed Test Analytics - ' . App::APP_NAME,
            'csrf_token' => $this->generateCSRFToken()
        ];
        
        return $this->render('speed-test/analytics', $data);
    }
} 