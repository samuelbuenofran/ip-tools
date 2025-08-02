<?php
namespace App\Models;

use App\Config\Database;
use App\Config\App;

class GeoLink {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function create($data) {
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
        
        return $this->db->query($sql, [
            $data['original_url'],
            $data['expires_at'] ?? null,
            $id
        ]);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM geo_links WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }
    
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
    
    public function getStats() {
        $sql = "SELECT 
                COUNT(*) as total_links,
                COUNT(CASE WHEN expires_at IS NULL OR expires_at > NOW() THEN 1 END) as active_links,
                COUNT(CASE WHEN expires_at IS NOT NULL AND expires_at <= NOW() THEN 1 END) as expired_links
                FROM geo_links";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetch();
    }
    
    public function getTrackingUrl($code) {
        return App::getBaseUrl() . '/geologger/precise_track.php?code=' . $code;
    }
    
    public function getQRCodeUrl($code) {
        $trackingUrl = $this->getTrackingUrl($code);
        return App::QR_CODE_API . '?size=200x200&data=' . urlencode($trackingUrl);
    }
} 