<?php

namespace App\Models;

use PDO;
use App\Config\Database;

class User {
    private $db;
    
    public function __construct() {
        try {
            $this->db = Database::getInstance()->getConnection();
        } catch (\Exception $e) {
            // Handle database connection error gracefully
            $this->db = null;
        }
    }
    
    /**
     * Check if database is available
     */
    public function isConnected() {
        return $this->db !== null;
    }
    
    /**
     * Create a new user
     */
    public function create($data) {
        $sql = "INSERT INTO users (username, email, password, first_name, last_name, role) 
                VALUES (:username, :email, :password, :first_name, :last_name, :role)";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'role' => $data['role'] ?? 'user'
        ]);
    }
    
    /**
     * Find user by username or email
     */
    public function findByUsernameOrEmail($identifier) {
        $sql = "SELECT * FROM users WHERE username = :identifier OR email = :identifier";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['identifier' => $identifier]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Find user by ID
     */
    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Update user's last login
     */
    public function updateLastLogin($userId) {
        $sql = "UPDATE users SET last_login = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $userId]);
    }
    
    /**
     * Get user statistics
     */
    public function getUserStats($userId) {
        // Get total links created by user
        $linksSql = "SELECT COUNT(*) as total_links FROM geo_links WHERE user_id = :user_id";
        $linksStmt = $this->db->prepare($linksSql);
        $linksStmt->execute(['user_id' => $userId]);
        $totalLinks = $linksStmt->fetchColumn();
        
        // Get total clicks on user's links
        $clicksSql = "SELECT COUNT(*) as total_clicks FROM geo_logs gl 
                      JOIN geo_links glk ON gl.link_id = glk.id 
                      WHERE glk.user_id = :user_id";
        $clicksStmt = $this->db->prepare($clicksSql);
        $clicksStmt->execute(['user_id' => $userId]);
        $totalClicks = $clicksStmt->fetchColumn();
        
        // Get unique visitors
        $visitorsSql = "SELECT COUNT(DISTINCT gl.ip_address) as unique_visitors 
                       FROM geo_logs gl 
                       JOIN geo_links glk ON gl.link_id = glk.id 
                       WHERE glk.user_id = :user_id";
        $visitorsStmt = $this->db->prepare($visitorsSql);
        $visitorsStmt->execute(['user_id' => $userId]);
        $uniqueVisitors = $visitorsStmt->fetchColumn();
        
        // Get GPS tracking count
        $gpsSql = "SELECT COUNT(*) as gps_tracking FROM geo_logs gl 
                   JOIN geo_links glk ON gl.link_id = glk.id 
                   WHERE glk.user_id = :user_id AND gl.location_type = 'GPS'";
        $gpsStmt = $this->db->prepare($gpsSql);
        $gpsStmt->execute(['user_id' => $userId]);
        $gpsTracking = $gpsStmt->fetchColumn();
        
        return [
            'total_links' => $totalLinks,
            'total_clicks' => $totalClicks,
            'unique_visitors' => $uniqueVisitors,
            'gps_tracking' => $gpsTracking
        ];
    }
    
    /**
     * Get user's recent activity
     */
    public function getRecentActivity($userId, $limit = 10) {
        $sql = "SELECT gl.*, glk.original_url, glk.short_code 
                FROM geo_logs gl 
                JOIN geo_links glk ON gl.link_id = glk.id 
                WHERE glk.user_id = :user_id 
                ORDER BY gl.timestamp DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get user's links
     */
    public function getUserLinks($userId) {
        $sql = "SELECT * FROM geo_links WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Create a new link for user
     */
    public function createLink($userId, $data) {
        $sql = "INSERT INTO geo_links (user_id, original_url, short_code, expires_at) 
                VALUES (:user_id, :original_url, :short_code, :expires_at)";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'user_id' => $userId,
            'original_url' => $data['original_url'],
            'short_code' => $data['short_code'],
            'expires_at' => $data['expires_at'] ?? null
        ]);
    }
    
    /**
     * Check if username exists
     */
    public function usernameExists($username) {
        $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['username' => $username]);
        
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Check if email exists
     */
    public function emailExists($email) {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Update user profile
     */
    public function updateProfile($userId, $data) {
        $sql = "UPDATE users SET 
                first_name = :first_name, 
                last_name = :last_name, 
                email = :email 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'id' => $userId
        ]);
    }
    
    /**
     * Change user password
     */
    public function changePassword($userId, $newPassword) {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'id' => $userId
        ]);
    }
} 