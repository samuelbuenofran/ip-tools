<?php
namespace App\Models;

use App\Config\Database;
use App\Config\App;

class GeoLink {
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
        if (!$this->isConnected()) {
            return false;
        }
        
        $sql = "INSERT INTO geo_links (original_url, short_code, expires_at, created_at) 
                VALUES (?, ?, ?, NOW())";
        
        $stmt = $this->db->query($sql, [
            $data['original_url'],
            $data['short_code'],
            $data['expires_at'] ?? null
        ]);
        
        return $this->db->lastInsertId();
    }
    
    public function findByCode($code) {
        $sql = "SELECT * FROM geo_links WHERE short_code = ?";
        $stmt = $this->db->query($sql, [$code]);
        return $stmt->fetch();
    }
    
    public function findByShortCode($shortCode) {
        $sql = "SELECT * FROM geo_links WHERE short_code = ?";
        $stmt = $this->db->query($sql, [$shortCode]);
        return $stmt->fetch();
    }
    
    public function findById($id) {
        $sql = "SELECT * FROM geo_links WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->fetch();
    }
    
    public function getAll($limit = null, $offset = 0) {
        $sql = "SELECT * FROM geo_links ORDER BY created_at DESC";
        if ($limit) {
            $sql .= " LIMIT $limit OFFSET $offset";
        }
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getActive() {
        $sql = "SELECT * FROM geo_links 
                WHERE expires_at IS NULL OR expires_at > NOW() 
                ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function update($id, $data) {
        $sql = "UPDATE geo_links SET 
                original_url = ?, 
                expires_at = ?, 
                updated_at = NOW() 
                WHERE id = ?";
        
        $stmt = $this->db->query($sql, [
            $data['original_url'],
            $data['expires_at'] ?? null,
            $id
        ]);
        return $stmt->rowCount() > 0;
    }
    
    public function delete($id) {
        $sql = "DELETE FROM geo_links WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->rowCount() > 0;
    }
    
    public function incrementClickCount($id) {
        $sql = "UPDATE geo_links SET click_count = click_count + 1 WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->rowCount() > 0;
    }
    
    public function getClickCount($id) {
        $sql = "SELECT click_count FROM geo_links WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        $result = $stmt->fetch();
        return $result ? $result['click_count'] : 0;
    }
    
    public function getTotalClicks() {
        $sql = "SELECT SUM(click_count) as total FROM geo_links";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result ? $result['total'] : 0;
    }
    
    public function getTotalLinks() {
        $sql = "SELECT COUNT(*) as total FROM geo_links";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result ? $result['total'] : 0;
    }
    
    public function search($query) {
        $sql = "SELECT * FROM geo_links 
                WHERE original_url LIKE ? OR short_code LIKE ? 
                ORDER BY created_at DESC";
        $searchTerm = "%{$query}%";
        $stmt = $this->db->query($sql, [$searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    public function getRecent($limit = 10) {
        $sql = "SELECT * FROM geo_links ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->db->query($sql, [$limit]);
        return $stmt->fetchAll();
    }
    
    public function getExpired() {
        $sql = "SELECT * FROM geo_links 
                WHERE expires_at IS NOT NULL AND expires_at < NOW() 
                ORDER BY expires_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function cleanupExpired() {
        $sql = "DELETE FROM geo_links 
                WHERE expires_at IS NOT NULL AND expires_at < NOW()";
        $stmt = $this->db->query($sql);
        return $stmt->rowCount();
    }
    
    /**
     * Get number of active links
     */
    public function getActiveLinks() {
        $sql = "SELECT COUNT(*) as active FROM geo_links WHERE expires_at IS NULL OR expires_at > NOW()";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result ? $result['active'] : 0;
    }
    
    /**
     * Get number of expired links
     */
    public function getExpiredLinks() {
        $sql = "SELECT COUNT(*) as expired FROM geo_links WHERE expires_at IS NOT NULL AND expires_at <= NOW()";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result ? $result['expired'] : 0;
    }
    
    /**
     * Get comprehensive stats
     */
    public function getStats() {
        $sql = "SELECT 
                COUNT(*) as total_links,
                COUNT(CASE WHEN expires_at IS NULL OR expires_at > NOW() THEN 1 END) as active_links,
                COUNT(CASE WHEN expires_at IS NOT NULL AND expires_at <= NOW() THEN 1 END) as expired_links
                FROM geo_links";
        $stmt = $this->db->query($sql);
        return $stmt->fetch();
    }
    
    /**
     * Generate a unique short code
     */
    public function generateShortCode($length = 8) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $code = '';
        
        do {
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $characters[rand(0, strlen($characters) - 1)];
            }
        } while ($this->findByCode($code));
        
        return $code;
    }
    
    /**
     * Get tracking URL for a code
     */
    public function getTrackingUrl($code) {
        return App::getBaseUrl() . '/geologger/precise_track.php?code=' . $code;
    }
    
    /**
     * Get QR code URL for a code
     */
    public function getQRCodeUrl($code) {
        $trackingUrl = $this->getTrackingUrl($code);
        return 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($trackingUrl);
    }
} 