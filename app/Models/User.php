<?php
namespace App\Models;

use App\Config\Database;

class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function authenticate($username, $password) {
        $sql = "SELECT * FROM users WHERE (username = ? OR email = ?) AND is_active = 1";
        $stmt = $this->db->query($sql, [$username, $username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            // Update last login
            $this->updateLastLogin($user['id']);
            return $user;
        }
        
        return false;
    }
    
    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = ? AND is_active = 1";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->fetch();
    }
    
    public function findByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = ? AND is_active = 1";
        $stmt = $this->db->query($sql, [$username]);
        return $stmt->fetch();
    }
    
    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ? AND is_active = 1";
        $stmt = $this->db->query($sql, [$email]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $sql = "INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, ?)";
        
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $stmt = $this->db->query($sql, [
            $data['username'],
            $data['email'],
            $passwordHash,
            $data['role'] ?? 'user'
        ]);
        
        return $this->db->lastInsertId();
    }
    
    public function update($id, $data) {
        $sql = "UPDATE users SET username = ?, email = ?, role = ?, is_active = ? WHERE id = ?";
        
        return $this->db->query($sql, [
            $data['username'],
            $data['email'],
            $data['role'],
            $data['is_active'],
            $id
        ]);
    }
    
    public function updatePassword($id, $newPassword) {
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password_hash = ? WHERE id = ?";
        
        return $this->db->query($sql, [$passwordHash, $id]);
    }
    
    private function updateLastLogin($id) {
        $sql = "UPDATE users SET last_login = NOW() WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }
    
    public function getAll($limit = null, $offset = 0) {
        $sql = "SELECT id, username, email, role, is_active, last_login, created_at FROM users ORDER BY created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT $limit OFFSET $offset";
        }
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }
    
    public function count() {
        $sql = "SELECT COUNT(*) FROM users";
        $stmt = $this->db->query($sql);
        return $stmt->fetchColumn();
    }
    
    public function isAdmin($userId) {
        $user = $this->findById($userId);
        return $user && $user['role'] === 'admin';
    }
} 