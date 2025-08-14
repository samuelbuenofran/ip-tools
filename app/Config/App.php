<?php
namespace App\Config;

class App {
    // Application settings
    const APP_NAME = 'IP Tools Suite';
    const APP_VERSION = '2.0.0';
    const BASE_URL = 'https://keizai-tech.com/projects/ip-tools';
    
    // Privacy and Security Settings
    const SHOW_LOCATION_MESSAGES = false;
    const SHOW_TRACKING_UI = false;
    
    // Google Maps API Key
    const GOOGLE_MAPS_API_KEY = 'AIzaSyC5gMYj7gqRiwNlE6BxyLAdG9IMCCJZsrs';
    
    // Geolocation APIs
    const IP_API_URL = 'http://ip-api.com/json/';
    const NOMINATIM_URL = 'https://nominatim.openstreetmap.org/reverse';
    const IPWHO_URL = 'https://ipwho.is/';
    
    // QR Code API
    const QR_CODE_API = 'https://api.qrserver.com/v1/create-qr-code/';
    
    // File paths
    const ASSETS_PATH = '/assets/';
    const QR_CODES_PATH = '/assets/qrcodes/';
    
    // Session settings
    const SESSION_NAME = 'ip_tools_session';
    const SESSION_LIFETIME = 3600; // 1 hour
    
    // Cache settings
    const CACHE_ENABLED = true;
    const CACHE_DURATION = 300; // 5 minutes
    
    // Error reporting
    const DEBUG_MODE = true;
    
    public static function init() {
        // Set error reporting
        if (self::DEBUG_MODE) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        } else {
            error_reporting(0);
            ini_set('display_errors', 0);
        }
        
        // Start session only if headers haven't been sent
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            session_name(self::SESSION_NAME);
            session_set_cookie_params(self::SESSION_LIFETIME);
            session_start();
        }
        
        // Set timezone
        date_default_timezone_set('America/Sao_Paulo');
        
        // Set character encoding
        ini_set('default_charset', 'UTF-8');
    }
    
    public static function getBaseUrl() {
        // Detect if we're in a local environment
        $host = $_SERVER['HTTP_HOST'] ?? '';
        if (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false) {
            return 'http://' . $host . '/projects/ip-tools/public';
        }
        return self::BASE_URL;
    }
    
    public static function getAssetUrl($path) {
        return self::BASE_URL . self::ASSETS_PATH . ltrim($path, '/');
    }
    
    public static function redirect($path) {
        header("Location: " . self::BASE_URL . $path);
        exit();
    }
    
    public static function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    
    public static function getClientIP() {
        $ipKeys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
        
        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
} 