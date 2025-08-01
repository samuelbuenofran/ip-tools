<?php
// Simple autoloader for development
spl_autoload_register(function ($class) {
    // Convert namespace to file path
    $file = str_replace('\\', '/', $class) . '.php';
    
    // Look in app directory (relative to autoload.php location)
    $appFile = __DIR__ . '/app/' . $file;
    if (file_exists($appFile)) {
        require_once $appFile;
        return;
    }
    
    // Look in vendor directory (if using Composer)
    $vendorFile = __DIR__ . '/vendor/' . $file;
    if (file_exists($vendorFile)) {
        require_once $vendorFile;
        return;
    }
    
    // Debug: Log failed attempts (only in debug mode)
    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        error_log("Autoloader failed to find: $class");
        error_log("Tried paths: $appFile, $vendorFile");
    }
});

// Load configuration
require_once __DIR__ . '/app/Config/App.php';
require_once __DIR__ . '/app/Config/Database.php'; 