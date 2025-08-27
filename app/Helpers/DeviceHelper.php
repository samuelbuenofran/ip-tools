<?php
namespace App\Helpers;

class DeviceHelper {
    
    /**
     * Detect device type from user agent string
     * 
     * @param string $userAgent
     * @return string
     */
    public static function detectDeviceType($userAgent) {
        if (empty($userAgent)) {
            return 'unknown';
        }
        
        $userAgent = strtolower($userAgent);
        
        // Mobile devices
        if (preg_match('/(android|iphone|ipad|ipod|blackberry|windows phone|mobile|tablet)/', $userAgent)) {
            return 'mobile';
        }
        
        // Desktop devices
        if (preg_match('/(windows|macintosh|linux|ubuntu|debian|centos|fedora)/', $userAgent)) {
            return 'desktop';
        }
        
        // Tablets (specific detection)
        if (preg_match('/(ipad|android.*tablet|tablet)/', $userAgent)) {
            return 'tablet';
        }
        
        return 'unknown';
    }
    
    /**
     * Get device icon HTML for display
     * 
     * @param string $deviceType
     * @param string $size CSS size (e.g., '16px', '24px', '2x')
     * @param string $class Additional CSS classes
     * @return string
     */
    public static function getDeviceIcon($deviceType, $size = '16px', $class = '') {
        $iconPath = '/projects/ip-tools/assets/icons/';
        $iconClass = trim('device-icon ' . $class);
        
        switch ($deviceType) {
            case 'mobile':
                return '<img src="' . $iconPath . 'phone.svg" alt="Mobile Device" class="' . $iconClass . '" style="width: ' . $size . '; height: ' . $size . ';" title="Mobile Device">';
                
            case 'desktop':
                return '<img src="' . $iconPath . 'desktop-computer.svg" alt="Desktop Computer" class="' . $iconClass . '" style="width: ' . $size . '; height: ' . $size . ';" title="Desktop Computer">';
                
            case 'tablet':
                return '<img src="' . $iconPath . 'phone.svg" alt="Tablet Device" class="' . $iconClass . '" style="width: ' . $size . '; height: ' . $size . ';" title="Tablet Device">';
                
            case 'unknown':
            default:
                return '<i class="fa-solid fa-question-circle text-muted" style="font-size: ' . $size . ';" title="Unknown Device"></i>';
        }
    }
    
    /**
     * Get device type label
     * 
     * @param string $deviceType
     * @return string
     */
    public static function getDeviceLabel($deviceType) {
        switch ($deviceType) {
            case 'mobile':
                return 'Mobile Device';
            case 'desktop':
                return 'Desktop Computer';
            case 'tablet':
                return 'Tablet Device';
            case 'unknown':
            default:
                return 'Unknown Device';
        }
    }
    
    /**
     * Get device icon with label for display
     * 
     * @param string $deviceType
     * @param string $size CSS size
     * @param string $class Additional CSS classes
     * @return string
     */
    public static function getDeviceIconWithLabel($deviceType, $size = '16px', $class = '') {
        $icon = self::getDeviceIcon($deviceType, $size, $class);
        $label = self::getDeviceLabel($deviceType);
        
        return '<span class="device-display" title="' . $label . '">' . $icon . ' <span class="device-label">' . $label . '</span></span>';
    }
    
    /**
     * Get device icon for table display
     * 
     * @param string $deviceType
     * @return string
     */
    public static function getDeviceIconForTable($deviceType) {
        return self::getDeviceIcon($deviceType, '20px', 'me-2');
    }
    
    /**
     * Get device icon for list display
     * 
     * @param string $deviceType
     * @return string
     */
    public static function getDeviceIconForList($deviceType) {
        return self::getDeviceIcon($deviceType, '18px', 'me-2');
    }
    
    /**
     * Get device icon for small display
     * 
     * @param string $deviceType
     * @return string
     */
    public static function getDeviceIconSmall($deviceType) {
        return self::getDeviceIcon($deviceType, '14px', 'me-1');
    }
    
    /**
     * Get device statistics from user agents
     * 
     * @param array $userAgents Array of user agent strings
     * @return array
     */
    public static function getDeviceStatistics($userAgents) {
        $stats = [
            'mobile' => 0,
            'desktop' => 0,
            'tablet' => 0,
            'unknown' => 0,
            'total' => count($userAgents)
        ];
        
        foreach ($userAgents as $userAgent) {
            $deviceType = self::detectDeviceType($userAgent);
            if (isset($stats[$deviceType])) {
                $stats[$deviceType]++;
            }
        }
        
        return $stats;
    }
    
    /**
     * Get device type color class for badges
     * 
     * @param string $deviceType
     * @return string
     */
    public static function getDeviceColorClass($deviceType) {
        switch ($deviceType) {
            case 'mobile':
                return 'bg-primary';
            case 'desktop':
                return 'bg-success';
            case 'tablet':
                return 'bg-info';
            case 'unknown':
            default:
                return 'bg-secondary';
        }
    }
    
    /**
     * Get device badge HTML
     * 
     * @param string $deviceType
     * @return string
     */
    public static function getDeviceBadge($deviceType) {
        $colorClass = self::getDeviceColorClass($deviceType);
        $label = self::getDeviceLabel($deviceType);
        $icon = self::getDeviceIcon($deviceType, '14px', 'me-1');
        
        return '<span class="badge ' . $colorClass . '">' . $icon . $label . '</span>';
    }
}
