<?php
namespace App\Core;

use App\Config\App;

class View {
    private $layout = 'default';
    private $viewPath = __DIR__ . '/../Views/';
    
    public function render($view, $data = []) {
        // Extract data to make variables available in view
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        $viewFile = $this->viewPath . $view . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            throw new \Exception("View file not found: $viewFile");
        }
        
        // Get the content
        $content = ob_get_clean();
        
        // Include layout if specified
        if ($this->layout) {
            $layoutFile = $this->viewPath . 'layouts/' . $this->layout . '.php';
            if (file_exists($layoutFile)) {
                include $layoutFile;
            } else {
                // If no layout, just output content
                echo $content;
            }
        } else {
            echo $content;
        }
    }
    
    public function setLayout($layout) {
        $this->layout = $layout;
    }
    
    public function partial($view, $data = []) {
        extract($data);
        $viewFile = $this->viewPath . 'partials/' . $view . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            throw new \Exception("Partial view not found: $viewFile");
        }
    }
    
    public function asset($path) {
        return App::getAssetUrl($path);
    }
    
    public function url($path = '') {
        return App::getBaseUrl() . '/' . ltrim($path, '/');
    }
    
    public function csrf() {
        return '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] ?? '' . '">';
    }
    
    public function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    
    public function formatDate($date, $format = 'Y-m-d H:i:s') {
        return date($format, strtotime($date));
    }
    
    public function formatNumber($number, $decimals = 2) {
        return number_format($number, $decimals);
    }
    
    public function isActive($path) {
        $currentPath = $_SERVER['REQUEST_URI'] ?? '';
        return strpos($currentPath, $path) !== false ? 'active' : '';
    }
} 