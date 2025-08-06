<?php
namespace App\Controllers;

use App\Models\UserModel;

class AuthController {
    public function form() {
        include_once __DIR__ . '/../Views/login.php';
    }

    public function login() {
        session_start();

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Get user from database
        $user = UserModel::findByUsername($username);

        if ($user && password_verify($password, $user['password']) && $user['is_active']) {
            // Store user info in session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ];

            // Optional: update last login
            UserModel::updateLastLogin($user['id']);

            // Redirect after login
            header('Location: index.php?page=dashboard');
            exit;
        }

        // If login fails
        echo '<p style="color:red;">Invalid username or password.</p>';
        $this->form();
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php?page=auth&method=form');
        exit;
    }
}
