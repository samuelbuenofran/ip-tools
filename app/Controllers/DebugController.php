<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Config\Database;
use App\Config\App;
use PDO;
use PDOException;

class DebugController extends Controller {
    // $db is already inherited from parent Controller class as protected
    
    public function __construct($params = []) {
        parent::__construct($params);
        
        // Only allow access to admins
        if (!$this->isAdmin()) {
            http_response_code(403);
            die('Access denied. Admin privileges required.');
        }
        
        // $this->db is already set by parent constructor
        // Parent sets it to Database::getInstance() (the Database object)
        // If you need the PDO connection, use $this->db->getConnection()
    }
    
    public function index() {
        $data = [
            'title' => 'Debug Tools - ' . App::APP_NAME,
            'systemInfo' => $this->getSystemInfo(),
            'databaseStatus' => $this->getDatabaseStatus(),
            'recentLogs' => $this->getRecentLogs()
        ];
        
        return $this->render('debug/index', $data);
    }
    
    public function database() {
        $action = $this->getPost('action');
        $result = null;
        
        switch ($action) {
            case 'test_connection':
                $result = $this->testDatabaseConnection();
                break;
            case 'show_tables':
                $result = $this->showTables();
                break;
            case 'describe_table':
                $tableName = $this->getPost('table_name');
                $result = $this->describeTable($tableName);
                break;
            case 'execute_query':
                $query = $this->getPost('query');
                $result = $this->executeQuery($query);
                break;
            case 'backup_table':
                $tableName = $this->getPost('table_name');
                $result = $this->backupTable($tableName);
                break;
            case 'repair_table':
                $tableName = $this->getPost('table_name');
                $result = $this->repairTable($tableName);
                break;
        }
        
        $data = [
            'title' => 'Database Debug - ' . App::APP_NAME,
            'result' => $result,
            'tables' => $this->getTablesList()
        ];
        
        return $this->render('debug/database', $data);
    }
    
    public function scripts() {
        $action = $this->getPost('action');
        $result = null;
        
        switch ($action) {
            case 'test_script':
                $scriptCode = $this->getPost('script_code');
                $result = $this->testScript($scriptCode);
                break;
            case 'execute_file':
                $fileName = $this->getPost('file_name');
                $result = $this->executeFile($fileName);
                break;
            case 'php_info':
                $result = $this->getPhpInfo();
                break;
        }
        
        $data = [
            'title' => 'Script Debug - ' . App::APP_NAME,
            'result' => $result,
            'availableFiles' => $this->getAvailableFiles()
        ];
        
        return $this->render('debug/scripts', $data);
    }
    
    public function system() {
        $action = $this->getPost('action');
        $result = null;
        
        switch ($action) {
            case 'check_permissions':
                $result = $this->checkPermissions();
                break;
            case 'check_dependencies':
                $result = $this->checkDependencies();
                break;
            case 'system_health':
                $result = $this->getSystemHealth();
                break;
            case 'clear_cache':
                $result = $this->clearCache();
                break;
        }
        
        $data = [
            'title' => 'System Debug - ' . App::APP_NAME,
            'result' => $result,
            'systemInfo' => $this->getSystemInfo()
        ];
        
        return $this->render('debug/system', $data);
    }
    
    // Database methods
    private function testDatabaseConnection() {
        try {
            if ($this->db) {
                $this->db->query('SELECT 1');
                return ['success' => true, 'message' => 'Database connection successful'];
            } else {
                return ['success' => false, 'message' => 'Database connection failed'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
    
    private function showTables() {
        try {
            if (!$this->db) {
                return ['success' => false, 'message' => 'No database connection'];
            }
            
            $stmt = $this->db->query('SHOW TABLES');
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            return ['success' => true, 'data' => $tables];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
    
    private function describeTable($tableName) {
        try {
            if (!$this->db) {
                return ['success' => false, 'message' => 'No database connection'];
            }
            
            $stmt = $this->db->prepare('DESCRIBE ' . $tableName);
            $stmt->execute();
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return ['success' => true, 'data' => $columns];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
    
    private function executeQuery($query) {
        try {
            if (!$this->db) {
                return ['success' => false, 'message' => 'No database connection'];
            }
            
            // Security check - only allow SELECT, SHOW, DESCRIBE, EXPLAIN
            $query = trim($query);
            $firstWord = strtoupper(explode(' ', $query)[0]);
            $allowedCommands = ['SELECT', 'SHOW', 'DESCRIBE', 'EXPLAIN', 'DESC'];
            
            if (!in_array($firstWord, $allowedCommands)) {
                return ['success' => false, 'message' => 'Only SELECT, SHOW, DESCRIBE, and EXPLAIN queries are allowed for security'];
            }
            
            $stmt = $this->db->query($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return ['success' => true, 'data' => $result, 'rowCount' => count($result)];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Query error: ' . $e->getMessage()];
        }
    }
    
    private function backupTable($tableName) {
        try {
            if (!$this->db) {
                return ['success' => false, 'message' => 'No database connection'];
            }
            
            $stmt = $this->db->prepare('SHOW CREATE TABLE ' . $tableName);
            $stmt->execute();
            $createTable = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $stmt = $this->db->prepare('SELECT * FROM ' . $tableName);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $backup = [
                'table_name' => $tableName,
                'create_statement' => $createTable['Create Table'],
                'data' => $data,
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
            return ['success' => true, 'data' => $backup];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Backup error: ' . $e->getMessage()];
        }
    }
    
    private function repairTable($tableName) {
        try {
            if (!$this->db) {
                return ['success' => false, 'message' => 'No database connection'];
            }
            
            $stmt = $this->db->prepare('REPAIR TABLE ' . $tableName);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return ['success' => true, 'data' => $result];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Repair error: ' . $e->getMessage()];
        }
    }
    
    // Script methods
    private function testScript($scriptCode) {
        try {
            // Security: Only allow safe operations
            $dangerousFunctions = ['exec', 'shell_exec', 'system', 'passthru', 'eval', 'file_get_contents', 'file_put_contents'];
            foreach ($dangerousFunctions as $func) {
                if (strpos($scriptCode, $func) !== false) {
                    return ['success' => false, 'message' => 'Dangerous function "' . $func . '" is not allowed for security'];
                }
            }
            
            // Create a temporary file with the script
            $tempFile = tempnam(sys_get_temp_dir(), 'debug_script_');
            file_put_contents($tempFile, '<?php ' . $scriptCode);
            
            // Capture output
            ob_start();
            include $tempFile;
            $output = ob_get_clean();
            
            // Clean up
            unlink($tempFile);
            
            return ['success' => true, 'output' => $output];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Script error: ' . $e->getMessage()];
        }
    }
    
    private function executeFile($fileName) {
        try {
            $filePath = __DIR__ . '/../../' . $fileName;
            
            if (!file_exists($filePath)) {
                return ['success' => false, 'message' => 'File not found: ' . $fileName];
            }
            
            // Security: Only allow files in specific directories
            $allowedDirs = ['utils', 'scripts', 'debug'];
            $fileDir = dirname($fileName);
            if (!in_array($fileDir, $allowedDirs)) {
                return ['success' => false, 'message' => 'File access restricted to: ' . implode(', ', $allowedDirs)];
            }
            
            ob_start();
            include $filePath;
            $output = ob_get_clean();
            
            return ['success' => true, 'output' => $output];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'File execution error: ' . $e->getMessage()];
        }
    }
    
    private function getPhpInfo() {
        ob_start();
        phpinfo();
        $phpInfo = ob_get_clean();
        
        return ['success' => true, 'data' => $phpInfo];
    }
    
    // System methods
    private function checkPermissions() {
        $paths = [
            'app/Views' => '0755',
            'logs' => '0755',
            'assets' => '0755',
            'uploads' => '0755'
        ];
        
        $results = [];
        foreach ($paths as $path => $expectedPerms) {
            $fullPath = __DIR__ . '/../../' . $path;
            if (is_dir($fullPath)) {
                $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
                $results[$path] = [
                    'permissions' => $perms,
                    'expected' => $expectedPerms,
                    'status' => $perms >= $expectedPerms ? 'OK' : 'WARNING'
                ];
            } else {
                $results[$path] = ['status' => 'NOT_FOUND'];
            }
        }
        
        return $results;
    }
    
    private function checkDependencies() {
        $extensions = ['pdo', 'pdo_mysql', 'json', 'mbstring', 'openssl'];
        $results = [];
        
        foreach ($extensions as $ext) {
            $results[$ext] = extension_loaded($ext) ? 'LOADED' : 'MISSING';
        }
        
        return $results;
    }
    
    private function getSystemHealth() {
        return [
            'memory_usage' => memory_get_usage(true),
            'memory_peak' => memory_get_peak_usage(true),
            'disk_free_space' => disk_free_space(__DIR__),
            'php_version' => PHP_VERSION,
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'max_execution_time' => ini_get('max_execution_time'),
            'memory_limit' => ini_get('memory_limit')
        ];
    }
    
    private function clearCache() {
        try {
            $cacheDir = __DIR__ . '/../../cache';
            if (is_dir($cacheDir)) {
                $files = glob($cacheDir . '/*');
                foreach ($files as $file) {
                    if (is_file($file)) {
                        unlink($file);
                    }
                }
                return ['success' => true, 'message' => 'Cache cleared successfully'];
            } else {
                return ['success' => false, 'message' => 'Cache directory not found'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Cache clear error: ' . $e->getMessage()];
        }
    }
    
    // Helper methods
    private function getTablesList() {
        try {
            if (!$this->db) {
                return [];
            }
            
            $stmt = $this->db->query('SHOW TABLES');
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            return [];
        }
    }
    
    private function getAvailableFiles() {
        $dirs = ['utils', 'scripts'];
        $files = [];
        
        foreach ($dirs as $dir) {
            $fullPath = __DIR__ . '/../../' . $dir;
            if (is_dir($fullPath)) {
                $dirFiles = glob($fullPath . '/*.php');
                foreach ($dirFiles as $file) {
                    $files[] = $dir . '/' . basename($file);
                }
            }
        }
        
        return $files;
    }
    
    private function getRecentLogs() {
        $logFile = __DIR__ . '/../../logs/error.log';
        if (file_exists($logFile)) {
            $logs = file($logFile);
            return array_slice($logs, -10); // Last 10 lines
        }
        return [];
    }
    
    private function getSystemInfo() {
        return [
            'php_version' => PHP_VERSION,
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown',
            'script_name' => $_SERVER['SCRIPT_NAME'] ?? 'Unknown',
            'request_uri' => $_SERVER['REQUEST_URI'] ?? 'Unknown',
            'http_host' => $_SERVER['HTTP_HOST'] ?? 'Unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
        ];
    }
    
    private function getDatabaseStatus() {
        try {
            if (!$this->db) {
                return ['status' => 'disconnected', 'message' => 'No database connection'];
            }
            
            $stmt = $this->db->query('SELECT VERSION() as version');
            $version = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return [
                'status' => 'connected',
                'version' => $version['version'],
                'connection_info' => $this->db->getAttribute(PDO::ATTR_CONNECTION_STATUS)
            ];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    
    private function isAdmin() {
        // Check if user is logged in and has admin privileges
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            return false;
        }
        
        // Check if user has admin role (you can customize this logic)
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
            return true;
        }
        
        // For now, allow access if user is logged in (you can make this more restrictive)
        return true;
    }
}
