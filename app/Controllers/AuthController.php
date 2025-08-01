<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Config\App;

class AuthController extends Controller {
    private $user;
    
    public function __construct($params = []) {
        parent::__construct($params);
        $this->user = new User();
    }
    
    public function login() {
        // Redirect if already logged in
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        
        if ($this->isPost()) {
            $this->validateCSRF();
            
            $username = $this->sanitizeInput($this->getPost('username'));
            $password = $this->getPost('password');
            $remember = $this->getPost('remember') ? true : false;
            
            $errors = $this->validateRequired([
                'username' => $username,
                'password' => $password
            ], ['username', 'password']);
            
            if (empty($errors)) {
                $user = $this->user->authenticate($username, $password);
                
                if ($user) {
                    // Set session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['logged_in'] = true;
                    
                    // Set remember me cookie if requested
                    if ($remember) {
                        $token = bin2hex(random_bytes(32));
                        setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/'); // 30 days
                        
                        // Store token in database (you might want to create a separate table for this)
                        // For now, we'll just use the session
                    }
                    
                    $_SESSION['success_message'] = 'Welcome back, ' . $user['username'] . '!';
                    $this->redirect('/dashboard');
                } else {
                    $errors[] = 'Invalid username or password';
                }
            }
            
            $data = [
                'title' => 'Login - ' . App::APP_NAME,
                'errors' => $errors,
                'form_data' => [
                    'username' => $username
                ],
                'csrf_token' => $this->generateCSRFToken()
            ];
            
            return $this->render('auth/login', $data);
        }
        
        $data = [
            'title' => 'Login - ' . App::APP_NAME,
            'csrf_token' => $this->generateCSRFToken()
        ];
        
        return $this->render('auth/login', $data);
    }
    
    public function logout() {
        // Clear session
        session_destroy();
        
        // Clear remember me cookie
        setcookie('remember_token', '', time() - 3600, '/');
        
        $this->redirect('/login');
    }
    
    public function register() {
        // Only allow registration if not logged in
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        
        if ($this->isPost()) {
            $this->validateCSRF();
            
            $username = $this->sanitizeInput($this->getPost('username'));
            $email = $this->sanitizeInput($this->getPost('email'));
            $password = $this->getPost('password');
            $confirmPassword = $this->getPost('confirm_password');
            
            $errors = $this->validateRequired([
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'confirm_password' => $confirmPassword
            ], ['username', 'email', 'password', 'confirm_password']);
            
            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address';
            }
            
            // Validate password length
            if (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters long';
            }
            
            // Validate password confirmation
            if ($password !== $confirmPassword) {
                $errors[] = 'Passwords do not match';
            }
            
            // Check if username already exists
            if ($this->user->findByUsername($username)) {
                $errors[] = 'Username already exists';
            }
            
            // Check if email already exists
            if ($this->user->findByEmail($email)) {
                $errors[] = 'Email already exists';
            }
            
            if (empty($errors)) {
                try {
                    $userId = $this->user->create([
                        'username' => $username,
                        'email' => $email,
                        'password' => $password,
                        'role' => 'user'
                    ]);
                    
                    $_SESSION['success_message'] = 'Registration successful! Please log in.';
                    $this->redirect('/login');
                } catch (\Exception $e) {
                    $errors[] = 'Registration failed. Please try again.';
                }
            }
            
            $data = [
                'title' => 'Register - ' . App::APP_NAME,
                'errors' => $errors,
                'form_data' => [
                    'username' => $username,
                    'email' => $email
                ],
                'csrf_token' => $this->generateCSRFToken()
            ];
            
            return $this->render('auth/register', $data);
        }
        
        $data = [
            'title' => 'Register - ' . App::APP_NAME,
            'csrf_token' => $this->generateCSRFToken()
        ];
        
        return $this->render('auth/register', $data);
    }
    
    public function profile() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }
        
        $user = $this->user->findById($_SESSION['user_id']);
        
        if ($this->isPost()) {
            $this->validateCSRF();
            
            $username = $this->sanitizeInput($this->getPost('username'));
            $email = $this->sanitizeInput($this->getPost('email'));
            $currentPassword = $this->getPost('current_password');
            $newPassword = $this->getPost('new_password');
            $confirmPassword = $this->getPost('confirm_password');
            
            $errors = [];
            
            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address';
            }
            
            // Check if username already exists (excluding current user)
            $existingUser = $this->user->findByUsername($username);
            if ($existingUser && $existingUser['id'] != $_SESSION['user_id']) {
                $errors[] = 'Username already exists';
            }
            
            // Check if email already exists (excluding current user)
            $existingUser = $this->user->findByEmail($email);
            if ($existingUser && $existingUser['id'] != $_SESSION['user_id']) {
                $errors[] = 'Email already exists';
            }
            
            // If changing password
            if (!empty($newPassword)) {
                if (strlen($newPassword) < 6) {
                    $errors[] = 'Password must be at least 6 characters long';
                }
                
                if ($newPassword !== $confirmPassword) {
                    $errors[] = 'New passwords do not match';
                }
                
                if (!password_verify($currentPassword, $user['password_hash'])) {
                    $errors[] = 'Current password is incorrect';
                }
            }
            
            if (empty($errors)) {
                try {
                    $this->user->update($_SESSION['user_id'], [
                        'username' => $username,
                        'email' => $email,
                        'role' => $user['role'],
                        'is_active' => $user['is_active']
                    ]);
                    
                    // Update password if provided
                    if (!empty($newPassword)) {
                        $this->user->updatePassword($_SESSION['user_id'], $newPassword);
                    }
                    
                    $_SESSION['username'] = $username;
                    $_SESSION['success_message'] = 'Profile updated successfully!';
                    $this->redirect('/profile');
                } catch (\Exception $e) {
                    $errors[] = 'Failed to update profile. Please try again.';
                }
            }
            
            $data = [
                'title' => 'Profile - ' . App::APP_NAME,
                'user' => $user,
                'errors' => $errors,
                'csrf_token' => $this->generateCSRFToken()
            ];
            
            return $this->render('auth/profile', $data);
        }
        
        $data = [
            'title' => 'Profile - ' . App::APP_NAME,
            'user' => $user,
            'csrf_token' => $this->generateCSRFToken()
        ];
        
        return $this->render('auth/profile', $data);
    }
} 