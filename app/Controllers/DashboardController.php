<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\GeoLink;
use App\Models\GeoLog;

class DashboardController extends Controller {
    private $userModel;
    private $geoLinkModel;
    private $geoLogModel;
    
    public function __construct($params = []) {
        parent::__construct($params);
        
        // Require authentication
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
        }
        
        try {
            $this->userModel = new User();
            $this->geoLinkModel = new GeoLink();
            $this->geoLogModel = new GeoLog();
        } catch (Exception $e) {
            // Handle database connection error gracefully
            error_log("Database connection failed in DashboardController: " . $e->getMessage());
        }
    }
    
    /**
     * Show user dashboard
     */
    public function index() {
        $userId = $_SESSION['user_id'];
        
        // Demo mode disabled - always use real data
        
        // Check if database is available
        if (!$this->userModel) {
            $_SESSION['error_message'] = 'Sistema temporariamente indisponível. Tente novamente mais tarde.';
            $this->redirect('auth/login');
        }
        
        try {
            // Get user statistics
            $userStats = $this->userModel->getUserStats($userId);
            
            // Get recent activity
            $recentActivity = $this->userModel->getRecentActivity($userId, 5);
            
            // Get user's links
            $userLinks = $this->userModel->getUserLinks($userId);
            
            // Get user info
            $user = $this->userModel->findById($userId);
            
            $this->view->render('dashboard/index', [
                'title' => 'Dashboard - IP Tools Suite',
                'user' => $user,
                'userStats' => $userStats,
                'recentActivity' => $recentActivity,
                'userLinks' => $userLinks
            ]);
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erro de conexão com o banco de dados. Tente novamente mais tarde.';
            $this->redirect('auth/login');
        }
    }
    
    /**
     * Create a new tracking link
     */
    public function createLink() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('dashboard');
        }
        
        $userId = $_SESSION['user_id'];
        $originalUrl = $_POST['original_url'] ?? '';
        $expiresAt = $_POST['expires_at'] ?? null;
        
        // Validate URL
        if (empty($originalUrl) || !filter_var($originalUrl, FILTER_VALIDATE_URL)) {
            $_SESSION['error_message'] = 'URL inválida.';
            $this->redirect('dashboard');
        }
        
        // Generate short code
        $shortCode = $this->generateShortCode();
        
        // Create link
        $linkData = [
            'original_url' => $originalUrl,
            'short_code' => $shortCode,
            'expires_at' => $expiresAt ? date('Y-m-d H:i:s', strtotime($expiresAt)) : null
        ];
        
        try {
            if ($this->userModel->createLink($userId, $linkData)) {
                $_SESSION['success_message'] = 'Link de rastreamento criado com sucesso!';
            } else {
                $_SESSION['error_message'] = 'Erro ao criar link de rastreamento.';
            }
        } catch (Exception $e) {
            error_log("Error creating tracking link: " . $e->getMessage());
            $_SESSION['error_message'] = 'Erro de banco de dados ao criar link de rastreamento. Verifique se a estrutura do banco está correta.';
        }
        
        $this->redirect('dashboard');
    }
    
    /**
     * Show user's links
     */
    public function links() {
        $userId = $_SESSION['user_id'];
        
        // Demo mode disabled - always use real data
        
        try {
            $userLinks = $this->userModel->getUserLinks($userId);
            
            $this->view->render('dashboard/links', [
                'title' => 'Meus Links - IP Tools Suite',
                'links' => $userLinks
            ]);
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erro de conexão com o banco de dados. Tente novamente mais tarde.';
            $this->redirect('dashboard');
        }
    }
    
    /**
     * Show user's logs
     */
    public function logs() {
        $userId = $_SESSION['user_id'];
        
        // Demo mode disabled - always use real data
        
        try {
            $recentActivity = $this->userModel->getRecentActivity($userId, 50);
            
            $this->view->render('dashboard/logs', [
                'title' => 'Meus Logs - IP Tools Suite',
                'logs' => $recentActivity
            ]);
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erro de conexão com o banco de dados. Tente novamente mais tarde.';
            $this->redirect('dashboard');
        }
    }
    
    /**
     * Delete a link
     */
    public function deleteLink() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('dashboard/links');
        }
        
        $userId = $_SESSION['user_id'];
        $linkId = $_POST['link_id'] ?? 0;
        
        // Verify link belongs to user
        $link = $this->geoLinkModel->findById($linkId);
        if (!$link || $link['user_id'] != $userId) {
            $_SESSION['error_message'] = 'Link não encontrado ou não autorizado.';
            $this->redirect('dashboard/links');
        }
        
        if ($this->geoLinkModel->delete($linkId)) {
            $_SESSION['success_message'] = 'Link deletado com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao deletar link.';
        }
        
        $this->redirect('dashboard/links');
    }
    
    /**
     * Generate unique short code
     */
    private function generateShortCode($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $shortCode = '';
        
        do {
            $shortCode = '';
            for ($i = 0; $i < $length; $i++) {
                $shortCode .= $characters[rand(0, strlen($characters) - 1)];
            }
        } while ($this->geoLinkModel->findByShortCode($shortCode));
        
        return $shortCode;
    }
} 