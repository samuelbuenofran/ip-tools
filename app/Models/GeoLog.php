<?php
namespace App\Models;

use App\Config\Database;
use App\Config\App;

class GeoLog {
    private $db;
    
    public function __construct() {
        // Use the MVC Database class instead of the old connectDB function
        $this->db = Database::getInstance();
    }
    
    /**
     * Check if database is available
     */
    public function isConnected() {
        return $this->db->isConnected();
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
        
        $stmt = $this->db->query($sql, [
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
        return $stmt->rowCount() > 0;
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
                LEFT JOIN geo_links l ON g.link_id = l.id
                ORDER BY g.timestamp DESC";
        
        if ($limit) {
            $sql .= " LIMIT $limit OFFSET $offset";
        }
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getByLinkId($linkId) {
        $sql = "SELECT * FROM geo_logs WHERE link_id = ? ORDER BY timestamp DESC";
        $stmt = $this->db->query($sql, [$linkId]);
        return $stmt->fetchAll();
    }
    
    public function getByIpAddress($ip) {
        $sql = "SELECT * FROM geo_logs WHERE ip_address = ? ORDER BY timestamp DESC";
        $stmt = $this->db->query($sql, [$ip]);
        return $stmt->fetchAll();
    }
    
    public function getByCountry($country) {
        $sql = "SELECT * FROM geo_logs WHERE country = ? ORDER BY timestamp DESC";
        $stmt = $this->db->query($sql, [$country]);
        return $stmt->fetchAll();
    }
    
    public function getByCity($city) {
        $sql = "SELECT * FROM geo_logs WHERE city = ? ORDER BY timestamp DESC";
        $stmt = $this->db->query($sql, [$city]);
        return $stmt->fetchAll();
    }
    
    public function getByDeviceType($deviceType) {
        $sql = "SELECT * FROM geo_logs WHERE device_type = ? ORDER BY timestamp DESC";
        $stmt = $this->db->query($sql, [$deviceType]);
        return $stmt->fetchAll();
    }
    
    public function getByDateRange($startDate, $endDate) {
        $sql = "SELECT * FROM geo_logs 
                WHERE timestamp BETWEEN ? AND ? 
                ORDER BY timestamp DESC";
        $stmt = $this->db->query($sql, [$startDate, $endDate]);
        return $stmt->fetchAll();
    }
    
    public function getByLocationType($locationType) {
        $sql = "SELECT * FROM geo_logs WHERE location_type = ? ORDER BY timestamp DESC";
        $stmt = $this->db->query($sql, [$locationType]);
        return $stmt->fetchAll();
    }
    
    public function getWithCoordinates() {
        $sql = "SELECT * FROM geo_logs 
                WHERE latitude IS NOT NULL AND longitude IS NOT NULL 
                ORDER BY timestamp DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getHeatmapData() {
        $sql = "SELECT latitude, longitude, accuracy, city, country 
                FROM geo_logs 
                WHERE latitude IS NOT NULL AND longitude IS NOT NULL 
                AND latitude != 0 AND longitude != 0";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getStats() {
        $sql = "SELECT 
                COUNT(*) as total_logs,
                COUNT(DISTINCT ip_address) as unique_visitors,
                COUNT(DISTINCT country) as countries_visited,
                COUNT(DISTINCT city) as cities_visited,
                COUNT(CASE WHEN location_type = 'GPS' THEN 1 END) as gps_locations,
                COUNT(CASE WHEN location_type = 'IP' THEN 1 END) as ip_locations
                FROM geo_logs";
        $stmt = $this->db->query($sql);
        return $stmt->fetch();
    }
    
    public function getCountryStats() {
        $sql = "SELECT country, COUNT(*) as visits 
                FROM geo_logs 
                WHERE country IS NOT NULL 
                GROUP BY country 
                ORDER BY visits DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getCityStats() {
        $sql = "SELECT city, country, COUNT(*) as visits 
                FROM geo_logs 
                WHERE city IS NOT NULL 
                GROUP BY city, country 
                ORDER BY visits DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getDeviceStats() {
        $sql = "SELECT device_type, COUNT(*) as visits 
                FROM geo_logs 
                WHERE device_type IS NOT NULL 
                GROUP BY device_type 
                ORDER BY visits DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getRecentActivity($limit = 10) {
        // Ensure limit is a positive integer
        $limit = max(1, (int)$limit);
        
        $sql = "SELECT g.*, l.original_url, l.short_code 
                FROM geo_logs g 
                LEFT JOIN geo_links l ON g.link_id = l.id 
                ORDER BY g.timestamp DESC 
                LIMIT " . $limit;
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function search($query) {
        $sql = "SELECT g.*, l.original_url, l.short_code 
                FROM geo_logs g 
                LEFT JOIN geo_links l ON g.link_id = l.id 
                WHERE g.ip_address LIKE ? 
                   OR g.country LIKE ? 
                   OR g.city LIKE ? 
                   OR l.short_code LIKE ?
                ORDER BY g.timestamp DESC";
        $searchTerm = "%{$query}%";
        $stmt = $this->db->query($sql, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    public function delete($id) {
        $sql = "DELETE FROM geo_logs WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->rowCount() > 0;
    }
    
    public function deleteByLinkId($linkId) {
        $sql = "DELETE FROM geo_logs WHERE link_id = ?";
        $stmt = $this->db->query($sql, [$linkId]);
        return $stmt->rowCount();
    }
    
    public function cleanupOldLogs($daysOld = 30) {
        $sql = "DELETE FROM geo_logs WHERE timestamp < DATE_SUB(NOW(), INTERVAL ? DAY)";
        $stmt = $this->db->query($sql, [$daysOld]);
        return $stmt->rowCount();
    }
    
    public function getTotalLogs() {
        $sql = "SELECT COUNT(*) as total FROM geo_logs";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result ? $result['total'] : 0;
    }
    
    public function getUniqueVisitors() {
        $sql = "SELECT COUNT(DISTINCT ip_address) as total FROM geo_logs";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result ? $result['total'] : 0;
    }
    
    /**
     * Get total number of clicks (alias for getTotalLogs)
     */
    public function getTotalClicks() {
        return $this->getTotalLogs();
    }
    
    /**
     * Get GPS tracking count
     */
    public function getGPSTrackingCount() {
        $sql = "SELECT COUNT(*) as gps FROM geo_logs WHERE location_type = 'GPS'";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result ? $result['gps'] : 0;
    }
} 