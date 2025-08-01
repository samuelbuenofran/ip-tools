<?php
namespace App\Core;

use App\Config\Database;
use App\Config\App;

abstract class Controller {
    protected $params;
    protected $db;
    protected $view;
    
    public function __construct($params = []) {
        $this->params = $params;
        $this->db = Database::getInstance();
        $this->view = new View();
    }
    
    protected function render($view, $data = []) {
        return $this->view->render($view, $data);
    }
    
    protected function renderJson($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
    
    protected function redirect($url) {
        App::redirect($url);
    }
    
    protected function getParam($key, $default = null) {
        return $this->params[$key] ?? $default;
    }
    
    protected function getRequest($key, $default = null) {
        return $_REQUEST[$key] ?? $default;
    }
    
    protected function getPost($key, $default = null) {
        return $_POST[$key] ?? $default;
    }
    
    protected function getGet($key, $default = null) {
        return $_GET[$key] ?? $default;
    }
    
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    protected function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
    
    protected function isAjax() {
        return App::isAjax();
    }
    
    protected function validateCSRF() {
        if ($this->isPost()) {
            $token = $this->getPost('csrf_token');
            if (!$token || $token !== $_SESSION['csrf_token'] ?? '') {
                throw new \Exception('CSRF token validation failed');
            }
        }
    }
    
    protected function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    protected function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    
    protected function validateRequired($data, $fields) {
        $errors = [];
        foreach ($fields as $field) {
            if (empty($data[$field])) {
                $errors[] = ucfirst($field) . ' is required';
            }
        }
        return $errors;
    }
    
    protected function logError($message, $context = []) {
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'message' => $message,
            'context' => $context,
            'url' => $_SERVER['REQUEST_URI'] ?? '',
            'ip' => App::getClientIP(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
        ];
        
        // Log to file (you can implement this as needed)
        error_log(json_encode($logEntry) . PHP_EOL, 3, __DIR__ . '/../../logs/error.log');
    }
    
    // Authentication methods
    protected function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }
    }
    
    protected function requireAdmin() {
        $this->requireLogin();
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $this->redirect('/dashboard');
        }
    }
    
    protected function getCurrentUser() {
        if (!$this->isLoggedIn()) {
            return null;
        }
        
        $userModel = new \App\Models\User();
        return $userModel->findById($_SESSION['user_id']);
    }
    
    protected function getCurrentUserId() {
        return $_SESSION['user_id'] ?? null;
    }
    
    protected function getCurrentUsername() {
        return $_SESSION['username'] ?? null;
    }
    
    protected function getCurrentUserRole() {
        return $_SESSION['role'] ?? null;
    }
} 