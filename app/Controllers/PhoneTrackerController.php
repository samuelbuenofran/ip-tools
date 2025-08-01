<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Config\App;

class PhoneTrackerController extends Controller {
    
    public function __construct($params = []) {
        parent::__construct($params);
    }
    
    public function sendSms() {
        $data = [
            'title' => 'Phone Tracker - ' . App::APP_NAME,
            'csrf_token' => $this->generateCSRFToken()
        ];
        
        return $this->render('phone-tracker/send_sms', $data);
    }
    
    public function track() {
        // Handle SMS tracking clicks
        $code = $this->getGet('code');
        
        if (!$code) {
            $this->redirect('/phone-tracker/send_sms');
        }
        
        // Get tracking data
        $db = $this->db->getConnection();
        $stmt = $db->prepare("SELECT * FROM phone_tracking WHERE short_code = ?");
        $stmt->execute([$code]);
        $tracking = $stmt->fetch();
        
        if (!$tracking) {
            $this->redirect('/phone-tracker/send_sms');
        }
        
        // Record click
        $ip = App::getClientIP();
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $referrer = $_SERVER['HTTP_REFERER'] ?? '';
        
        $stmt = $db->prepare("
            INSERT INTO phone_clicks (tracking_id, ip_address, user_agent, referrer, clicked_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$tracking['id'], $ip, $userAgent, $referrer]);
        
        // Update tracking status
        $stmt = $db->prepare("
            UPDATE phone_tracking 
            SET status = 'clicked', last_clicked_at = NOW() 
            WHERE id = ?
        ");
        $stmt->execute([$tracking['id']]);
        
        // Redirect to original URL
        header("Location: " . $tracking['original_url']);
        exit();
    }
    
    public function trackingLogs() {
        $data = [
            'title' => 'Phone Tracking Logs - ' . App::APP_NAME,
            'csrf_token' => $this->generateCSRFToken()
        ];
        
        return $this->render('phone-tracker/tracking_logs', $data);
    }
} 