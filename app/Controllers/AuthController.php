<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Config\App;

class AuthController extends Controller {
    private $userModel;
    
    public function __construct($params = []) {
        parent::__construct($params);
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
        if (!$this->userModel || !$this->userModel->isConnected()) {
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
        
        $this->validateCSRF();
        
        $data = [
            'first_name' => $this->sanitizeInput($this->getPost('first_name')),
            'last_name' => $this->sanitizeInput($this->getPost('last_name')),
            'username' => $this->sanitizeInput($this->getPost('username')),
            'email' => $this->sanitizeInput($this->getPost('email')),
            'password' => $this->getPost('password'),
            'confirm_password' => $this->getPost('confirm_password')
        ];
        
        // Validate required fields
        $errors = $this->validateRequired($data, ['first_name', 'last_name', 'username', 'email', 'password', 'confirm_password']);
        
        if (!empty($errors)) {
            $_SESSION['error_message'] = implode(', ', $errors);
            $_SESSION['form_data'] = $data;
            $this->redirect('auth/register');
        }
        
        // Validate password match
        if ($data['password'] !== $data['confirm_password']) {
            $_SESSION['error_message'] = 'As senhas não coincidem.';
            $_SESSION['form_data'] = $data;
            $this->redirect('auth/register');
        }
        
        // Validate password strength
        if (strlen($data['password']) < 6) {
            $_SESSION['error_message'] = 'A senha deve ter pelo menos 6 caracteres.';
            $_SESSION['form_data'] = $data;
            $this->redirect('auth/register');
        }
        
        // Validate username format
        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $data['username'])) {
            $_SESSION['error_message'] = 'Nome de usuário deve conter apenas letras, números e underscore (3-20 caracteres).';
            $_SESSION['form_data'] = $data;
            $this->redirect('auth/register');
        }
        
        // Validate email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message'] = 'Email inválido.';
            $_SESSION['form_data'] = $data;
            $this->redirect('auth/register');
        }
        
        // Check if database is available
        if (!$this->userModel || !$this->userModel->isConnected()) {
            $_SESSION['error_message'] = 'Sistema temporariamente indisponível. Tente novamente mais tarde.';
            $this->redirect('auth/register');
        }
        
        try {
            // Check if username already exists
            if ($this->userModel->findByUsername($data['username'])) {
                $_SESSION['error_message'] = 'Nome de usuário já está em uso.';
                $_SESSION['form_data'] = $data;
                $this->redirect('auth/register');
            }
            
            // Check if email already exists
            if ($this->userModel->findByEmail($data['email'])) {
                $_SESSION['error_message'] = 'Email já está em uso.';
                $_SESSION['form_data'] = $data;
                $this->redirect('auth/register');
            }
            
            // Create user
            $userData = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'role' => 'user',
                'is_active' => 1
            ];
            
            $userId = $this->userModel->create($userData);
            
            if ($userId) {
                $_SESSION['success_message'] = 'Conta criada com sucesso! Faça login para continuar.';
                $this->redirect('auth/login');
            } else {
                $_SESSION['error_message'] = 'Erro ao criar conta. Tente novamente.';
                $_SESSION['form_data'] = $data;
                $this->redirect('auth/register');
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erro de conexão com o banco de dados. Tente novamente mais tarde.';
            $_SESSION['form_data'] = $data;
            $this->redirect('auth/register');
        }
    }
    
    /**
     * Logout user
     */
    public function logout() {
        session_destroy();
        $this->redirect('auth/login');
    }
    
    /**
     * Show user profile
     */
    public function profile() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
        }
        
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);
        
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
        
        $this->validateCSRF();
        
        $userId = $_SESSION['user_id'];
        $data = [
            'first_name' => $this->sanitizeInput($this->getPost('first_name')),
            'last_name' => $this->sanitizeInput($this->getPost('last_name')),
            'email' => $this->sanitizeInput($this->getPost('email'))
        ];
        
        // Validate required fields
        $errors = $this->validateRequired($data, ['first_name', 'last_name', 'email']);
        
        if (!empty($errors)) {
            $_SESSION['error_message'] = implode(', ', $errors);
            $this->redirect('auth/profile');
        }
        
        // Validate email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message'] = 'Email inválido.';
            $this->redirect('auth/profile');
        }
        
        try {
            // Check if email is already used by another user
            $existingUser = $this->userModel->findByEmail($data['email']);
            if ($existingUser && $existingUser['id'] != $userId) {
                $_SESSION['error_message'] = 'Email já está em uso por outro usuário.';
                $this->redirect('auth/profile');
            }
            
            // Update user
            if ($this->userModel->update($userId, $data)) {
                $_SESSION['success_message'] = 'Perfil atualizado com sucesso!';
            } else {
                $_SESSION['error_message'] = 'Erro ao atualizar perfil.';
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erro de conexão com o banco de dados. Tente novamente mais tarde.';
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
        
        $this->validateCSRF();
        
        $userId = $_SESSION['user_id'];
        $currentPassword = $this->getPost('current_password');
        $newPassword = $this->getPost('new_password');
        $confirmPassword = $this->getPost('confirm_password');
        
        // Validate required fields
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['error_message'] = 'Todos os campos são obrigatórios.';
            $this->redirect('auth/profile');
        }
        
        // Validate password match
        if ($newPassword !== $confirmPassword) {
            $_SESSION['error_message'] = 'As novas senhas não coincidem.';
            $this->redirect('auth/profile');
        }
        
        // Validate password strength
        if (strlen($newPassword) < 6) {
            $_SESSION['error_message'] = 'A nova senha deve ter pelo menos 6 caracteres.';
            $this->redirect('auth/profile');
        }
        
        try {
            // Get current user
            $user = $this->userModel->findById($userId);
            
            // Verify current password
            if (!password_verify($currentPassword, $user['password'])) {
                $_SESSION['error_message'] = 'Senha atual incorreta.';
                $this->redirect('auth/profile');
            }
            
            // Update password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            if ($this->userModel->update($userId, ['password' => $hashedPassword])) {
                $_SESSION['success_message'] = 'Senha alterada com sucesso!';
            } else {
                $_SESSION['error_message'] = 'Erro ao alterar senha.';
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erro de conexão com o banco de dados. Tente novamente mais tarde.';
        }
        
        $this->redirect('auth/profile');
    }
}
