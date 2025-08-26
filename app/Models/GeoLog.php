<?php
namespace App\Models;

use App\Config\Database;
use App\Config\App;

class GeoLog {
    private $db;
    
    public function __construct() {
        try {
            $this->db = Database::getInstance();
        } catch (\Exception $e) {
            // Handle database connection error gracefully
            $this->db = null;
        }
    }
    
    /**
     * Check if database is available
     */
    public function isConnected() {
        return $this->db && $this->db->isConnected();
    }
    
    public function create($data) {
        $sql = "INSERT INTO geo_logs (
                    link_id, ip_address, user_agent, referrer, 
                    latitude, longitude, accuracy, country, city, address,
                    street, house_number, postcode, state,
                    device_type, timestamp, location_type
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->query($sql, [
            $data['link_id'],
            $data['ip_address'],
            $data['user_agent'],
            $data['referrer'],
            $data['latitude'] ?? null,
            $data['longitude'] ?? null,
            $data['accuracy'] ?? null,
            $data['country'] ?? null,
            $data['city'] ?? null,
            $data['address'] ?? null,
            $data['street'] ?? null,
            $data['house_number'] ?? null,
            $data['postcode'] ?? null,
            $data['state'] ?? null,
            $data['device_type'] ?? null,
            $data['timestamp'] ?? date('Y-m-d H:i:s'),
            $data['location_type'] ?? 'IP'
        ]);
        
        return $this->db->lastInsertId();
    }
    
    public function update($id, $data) {
        $sql = "UPDATE geo_logs SET 
                latitude = ?, longitude = ?, accuracy = ?, location_type = ?,
                address = ?, street = ?, house_number = ?, city = ?,
                state = ?, country = ?, postcode = ?
                WHERE id = ?";
        
        return $this->db->query($sql, [
            $data['latitude'] ?? null,
            $data['longitude'] ?? null,
            $data['accuracy'] ?? null,
            $data['location_type'] ?? 'GPS',
            $data['address'] ?? null,
            $data['street'] ?? null,
            $data['house_number'] ?? null,
            $data['city'] ?? null,
            $data['state'] ?? null,
            $data['country'] ?? null,
            $data['postcode'] ?? null,
            $id
        ]);
    }
    
    public function findById($id) {
        $sql = "SELECT g.*, l.original_url, l.short_code 
                FROM geo_logs g 
                JOIN geo_links l ON g.link_id = l.id 
                WHERE g.id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->fetch();
    }
    
    public function getAll($limit = null, $offset = 0) {
        $sql = "SELECT g.*, l.original_url, l.short_code,
                       CASE 
                         WHEN g.location_type = 'GPS' THEN CONCAT('GPS (', g.accuracy, 'm)')
                         ELSE 'IP-based'
                       END as location_source,
                       CASE
                         WHEN g.house_number IS NOT NULL AND g.street IS NOT NULL 
                         THEN CONCAT(g.house_number, ' ', g.street)
                         WHEN g.street IS NOT NULL THEN g.street
                         ELSE g.address
                       END as precise_address
                FROM geo_logs g
                JOIN geo_links l ON g.link_id = l.id
                ORDER BY g.timestamp DESC";
        
        if ($limit) {
            $sql .= " LIMIT $limit OFFSET $offset";
        }
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getByLinkId($linkId, $limit = null) {
        $sql = "SELECT * FROM geo_logs WHERE link_id = ? ORDER BY timestamp DESC";
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        $stmt = $this->db->query($sql, [$linkId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get total number of clicks
     */
    public function getTotalClicks() {
        if (!$this->isConnected()) {
            return 0;
        }
        
        $sql = "SELECT COUNT(*) as total FROM geo_logs";
        $stmt = $this->db->query($sql);
        return $stmt->fetchColumn();
    }
    
    /**
     * Get number of unique visitors
     */
    public function getUniqueVisitors() {
        if (!$this->isConnected()) {
            return 0;
        }
        
        $sql = "SELECT COUNT(DISTINCT ip_address) as unique_visitors FROM geo_logs";
        $stmt = $this->db->query($sql);
        return $stmt->fetchColumn();
    }
    
    /**
     * Get GPS tracking count
     */
    public function getGPSTrackingCount() {
        if (!$this->isConnected()) {
            return 0;
        }
        
        $sql = "SELECT COUNT(*) as gps FROM geo_logs WHERE location_type = 'GPS'";
        $stmt = $this->db->query($sql);
        return $stmt->fetchColumn();
    }
    
    public function getStats() {
        $sql = "SELECT 
                COUNT(*) as total_clicks,
                COUNT(DISTINCT ip_address) as unique_visitors,
                COUNT(CASE WHEN location_type = 'GPS' THEN 1 END) as gps_clicks,
                COUNT(CASE WHEN location_type = 'IP' THEN 1 END) as ip_clicks
                FROM geo_logs";
        
        $stmt = $this->db->query($sql);
        $stats = $stmt->fetch();
        
        // Get active links count
        $activeLinksSql = "SELECT COUNT(*) as active_links FROM geo_links WHERE expires_at IS NULL OR expires_at > NOW()";
        $activeLinksStmt = $this->db->query($activeLinksSql);
        $activeLinks = $activeLinksStmt->fetch();
        
        // Merge the stats
        $stats['active_links'] = $activeLinks['active_links'] ?? 0;
        
        return $stats;
    }
    
    public function getHeatmapData() {
        $sql = "SELECT latitude, longitude, accuracy, city, country
                FROM geo_logs 
                WHERE latitude IS NOT NULL 
                AND longitude IS NOT NULL
                AND latitude BETWEEN -90 AND 90
                AND longitude BETWEEN -180 AND 180";
        
        $stmt = $this->db->query($sql);
        $results = $stmt->fetchAll();
        
        // Transform the data to match the expected format
        $heatmapData = [];
        foreach ($results as $row) {
            $heatmapData[] = [
                'lat' => (float)$row['latitude'],
                'lng' => (float)$row['longitude'],
                'accuracy' => $row['accuracy'] ?? null,
                'city' => $row['city'] ?? 'Unknown',
                'country' => $row['country'] ?? 'Unknown'
            ];
        }
        
        return $heatmapData;
    }
    
    public function getLocationStats() {
        $sql = "SELECT 
                country, city, COUNT(*) as clicks
                FROM geo_logs 
                WHERE country IS NOT NULL 
                GROUP BY country, city 
                ORDER BY clicks DESC 
                LIMIT 10";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getDeviceStats() {
        $sql = "SELECT 
                device_type, COUNT(*) as clicks
                FROM geo_logs 
                WHERE device_type IS NOT NULL 
                GROUP BY device_type 
                ORDER BY clicks DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getRecentActivity($limit = 10) {
        if (!$this->isConnected()) {
            return [];
        }
        
        $sql = "SELECT g.*, l.original_url, l.short_code
                FROM geo_logs g
                JOIN geo_links l ON g.link_id = l.id
                ORDER BY g.timestamp DESC
                LIMIT ?";
        
        $stmt = $this->db->query($sql, [$limit]);
        return $stmt->fetchAll();
    }
    
    public function deleteOldLogs($days = 30) {
        $sql = "DELETE FROM geo_logs WHERE timestamp < DATE_SUB(NOW(), INTERVAL ? DAY)";
        return $this->db->query($sql, [$days]);
    }
} 