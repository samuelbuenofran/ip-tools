<?php
namespace App\Core;

use App\Config\App;

class AuthMiddleware {
    /**
     * List of public routes that don't require authentication
     */
    private static $publicRoutes = [
        '', // Home page
        'home',
        'about',
        'contact', 
        'privacy',
        'support',
        'auth/login',
        'auth/register',
        'auth/loginPost',
        'auth/registerPost'
    ];
    
    /**
     * Check if the current route requires authentication
     */
    public static function requiresAuth($route) {
        // Remove leading/trailing slashes
        $route = trim($route, '/');
        
        // Check if route is in public routes
        return !in_array($route, self::$publicRoutes);
    }
    
    /**
     * Check if user is authenticated
     */
    public static function isAuthenticated() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    /**
     * Check if user is admin
     */
    public static function isAdmin() {
        return self::isAuthenticated() && 
               isset($_SESSION['user_role']) && 
               $_SESSION['user_role'] === 'admin';
    }
    
    /**
     * Redirect to login if not authenticated
     */
    public static function requireAuth() {
        if (!self::isAuthenticated()) {
            // Store the intended destination for after login
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? '/';
            
            // Redirect to login
            App::redirect('auth/login');
        }
    }
    
    /**
     * Redirect to login if not admin
     */
    public static function requireAdmin() {
        if (!self::isAdmin()) {
            // If not logged in, redirect to login
            if (!self::isAuthenticated()) {
                $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? '/';
                App::redirect('auth/login');
            }
            
            // If logged in but not admin, redirect to dashboard
            App::redirect('dashboard');
        }
    }
    
    /**
     * Get the redirect URL after successful login
     */
    public static function getRedirectAfterLogin() {
        $redirect = $_SESSION['redirect_after_login'] ?? 'dashboard';
        unset($_SESSION['redirect_after_login']);
        return $redirect;
    }
}
