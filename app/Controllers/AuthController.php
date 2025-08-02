<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Controller;

class AuthController extends Controller {
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        try {
            $this->userModel = new User();
        } catch (Exception $e) {
            // Handle database connection error gracefully
            error_log("Database connection failed in AuthController: " . $e->getMessage());
        }
    }
    
    /**
     * Show login form
     */
    public function login() {
        // If already logged in, redirect to dashboard
        if ($this->isLoggedIn()) {
            $this->redirect('dashboard');
        }
        
        $this->view->render('auth/login', [
            'title' => 'Login - IP Tools Suite'
        ]);
    }
    
    /**
     * Handle login form submission
     */
    public function loginPost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/login');
        }
        
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Validate input
        if (empty($username) || empty($password)) {
            $_SESSION['error_message'] = 'Por favor, preencha todos os campos.';
            $this->redirect('auth/login');
        }
        
        // Demo mode - allow admin login without database
        if ($username === 'admin' && $password === 'admin123') {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = 1;
            $_SESSION['username'] = 'admin';
            $_SESSION['user_role'] = 'admin';
            $_SESSION['demo_mode'] = true;
            
            $_SESSION['success_message'] = 'Login realizado com sucesso! (Modo Demo)';
            $this->redirect('dashboard');
            return;
        }
        
        // Check if database is available
        if (!$this->userModel) {
            $_SESSION['error_message'] = 'Sistema temporariamente indisponível. Tente novamente mais tarde.';
            $this->redirect('auth/login');
        }
        
        try {
            // Find user
            $user = $this->userModel->findByUsernameOrEmail($username);
            
            if (!$user || !password_verify($password, $user['password'])) {
                $_SESSION['error_message'] = 'Usuário ou senha inválidos.';
                $this->redirect('auth/login');
            }
            
            if (!$user['is_active']) {
                $_SESSION['error_message'] = 'Sua conta está desativada.';
                $this->redirect('auth/login');
            }
            
            // Update last login
            $this->userModel->updateLastLogin($user['id']);
            
            // Set session
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];
            
            $_SESSION['success_message'] = 'Login realizado com sucesso!';
            $this->redirect('dashboard');
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erro de conexão com o banco de dados. Tente novamente mais tarde.';
            $this->redirect('auth/login');
        }
    }
    
    /**
     * Show registration form
     */
    public function register() {
        // If already logged in, redirect to dashboard
        if ($this->isLoggedIn()) {
            $this->redirect('dashboard');
        }
        
        $this->view->render('auth/register', [
            'title' => 'Registrar - IP Tools Suite'
        ]);
    }
    
    /**
     * Handle registration form submission
     */
    public function registerPost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/register');
        }
        
        $data = [
            'username' => trim($_POST['username'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'confirm_password' => $_POST['confirm_password'] ?? '',
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? '')
        ];
        
        // Validate input
        $errors = $this->validateRegistration($data);
        
        if (!empty($errors)) {
            $_SESSION['error_message'] = implode('<br>', $errors);
            $this->redirect('auth/register');
        }
        
        // Check if username or email already exists
        if ($this->userModel->usernameExists($data['username'])) {
            $_SESSION['error_message'] = 'Nome de usuário já está em uso.';
            $this->redirect('auth/register');
        }
        
        if ($this->userModel->emailExists($data['email'])) {
            $_SESSION['error_message'] = 'Email já está em uso.';
            $this->redirect('auth/register');
        }
        
        // Create user
        if ($this->userModel->create($data)) {
            $_SESSION['success_message'] = 'Conta criada com sucesso! Faça login para continuar.';
            $this->redirect('auth/login');
        } else {
            $_SESSION['error_message'] = 'Erro ao criar conta. Tente novamente.';
            $this->redirect('auth/register');
        }
    }
    
    /**
     * Logout user
     */
    public function logout() {
        // Clear session
        session_destroy();
        
        $_SESSION['success_message'] = 'Logout realizado com sucesso!';
        $this->redirect('');
    }
    
    /**
     * Show user profile
     */
    public function profile() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
        }
        
        $user = $this->userModel->findById($_SESSION['user_id']);
        
        $this->view->render('auth/profile', [
            'title' => 'Perfil - IP Tools Suite',
            'user' => $user
        ]);
    }
    
    /**
     * Update user profile
     */
    public function updateProfile() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/profile');
        }
        
        $data = [
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'email' => trim($_POST['email'] ?? '')
        ];
        
        // Validate email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message'] = 'Email inválido.';
            $this->redirect('auth/profile');
        }
        
        // Check if email is already used by another user
        $currentUser = $this->userModel->findById($_SESSION['user_id']);
        if ($data['email'] !== $currentUser['email'] && $this->userModel->emailExists($data['email'])) {
            $_SESSION['error_message'] = 'Email já está em uso.';
            $this->redirect('auth/profile');
        }
        
        // Update profile
        if ($this->userModel->updateProfile($_SESSION['user_id'], $data)) {
            $_SESSION['success_message'] = 'Perfil atualizado com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao atualizar perfil.';
        }
        
        $this->redirect('auth/profile');
    }
    
    /**
     * Change password
     */
    public function changePassword() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/profile');
        }
        
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        // Validate input
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['error_message'] = 'Por favor, preencha todos os campos.';
            $this->redirect('auth/profile');
        }
        
        if ($newPassword !== $confirmPassword) {
            $_SESSION['error_message'] = 'As senhas não coincidem.';
            $this->redirect('auth/profile');
        }
        
        if (strlen($newPassword) < 6) {
            $_SESSION['error_message'] = 'A nova senha deve ter pelo menos 6 caracteres.';
            $this->redirect('auth/profile');
        }
        
        // Verify current password
        $user = $this->userModel->findById($_SESSION['user_id']);
        if (!password_verify($currentPassword, $user['password'])) {
            $_SESSION['error_message'] = 'Senha atual incorreta.';
            $this->redirect('auth/profile');
        }
        
        // Change password
        if ($this->userModel->changePassword($_SESSION['user_id'], $newPassword)) {
            $_SESSION['success_message'] = 'Senha alterada com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao alterar senha.';
        }
        
        $this->redirect('auth/profile');
    }
    
    /**
     * Validate registration data
     */
    private function validateRegistration($data) {
        $errors = [];
        
        if (empty($data['username'])) {
            $errors[] = 'Nome de usuário é obrigatório.';
        } elseif (strlen($data['username']) < 3) {
            $errors[] = 'Nome de usuário deve ter pelo menos 3 caracteres.';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $data['username'])) {
            $errors[] = 'Nome de usuário deve conter apenas letras, números e underscore.';
        }
        
        if (empty($data['email'])) {
            $errors[] = 'Email é obrigatório.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email inválido.';
        }
        
        if (empty($data['password'])) {
            $errors[] = 'Senha é obrigatória.';
        } elseif (strlen($data['password']) < 6) {
            $errors[] = 'Senha deve ter pelo menos 6 caracteres.';
        }
        
        if ($data['password'] !== $data['confirm_password']) {
            $errors[] = 'As senhas não coincidem.';
        }
        
        return $errors;
    }
} 