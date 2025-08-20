<?php

namespace App\Models;

use PDO;
use PDOException;

class SpeedTest
{
    private $db;

    public function __construct()
    {
        // Don't connect to database until needed
        $this->db = null;
    }

    /**
     * Get database connection
     */
    private function getConnection()
    {
        try {
            // Use the same database connection as the main application
            // Since this is called from public/index.php, we need to find the right path
            $configPath = __DIR__ . '/../../config.php';
            
            if (!file_exists($configPath)) {
                // Try alternative path
                $configPath = __DIR__ . '/../../../config.php';
            }
            
            if (!file_exists($configPath)) {
                throw new \Exception("Could not find config.php at expected paths");
            }
            
            require_once $configPath;
            return connectDB();
        } catch (Exception $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new \Exception("Database connection failed: " . $e->getMessage());
        }
    }
    
    /**
     * Ensure database connection is available
     */
    private function ensureConnection()
    {
        if ($this->db === null) {
            $this->db = $this->getConnection();
        }
    }

    /**
     * Save speed test results
     */
    public function saveTest($data)
    {
        try {
            // Ensure database connection is available
            $this->ensureConnection();
            
            // Ensure speed_tests table exists
            $this->createTableIfNotExists();
            
            $sql = "INSERT INTO speed_tests (
                ip_address, download_speed, upload_speed, ping, jitter,
                country, city, user_agent, timestamp
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $data['ip_address'],
                $data['download_speed'],
                $data['upload_speed'],
                $data['ping'],
                $data['jitter'],
                $data['country'],
                $data['city'],
                $data['user_agent']
            ]);
            
            return $this->db->lastInsertId();
            
        } catch (PDOException $e) {
            error_log("Failed to save speed test: " . $e->getMessage());
            throw new \Exception("Failed to save speed test results");
        }
    }

    /**
     * Get recent speed tests
     */
    public function getRecentTests($limit = 10)
    {
        try {
            // Ensure database connection is available
            $this->ensureConnection();
            
            $this->createTableIfNotExists();
            
            $sql = "SELECT * FROM speed_tests ORDER BY timestamp DESC LIMIT ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$limit]);
            
            return $stmt->fetchAll();
            
        } catch (PDOException $e) {
            error_log("Failed to get recent tests: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get average speeds
     */
    public function getAverageSpeeds()
    {
        try {
            // Ensure database connection is available
            $this->ensureConnection();
            
            $this->createTableIfNotExists();
            
            $sql = "SELECT 
                AVG(download_speed) as avg_download,
                AVG(upload_speed) as avg_upload,
                AVG(ping) as avg_ping,
                COUNT(*) as total_tests
                FROM speed_tests";
            
            $stmt = $this->db->query($sql);
            $result = $stmt->fetch();
            
            return [
                'avg_download' => $result['avg_download'] ?? 0,
                'avg_upload' => $result['avg_upload'] ?? 0,
                'avg_ping' => $result['avg_ping'] ?? 0,
                'total_tests' => $result['total_tests'] ?? 0
            ];
            
        } catch (PDOException $e) {
            error_log("Failed to get average speeds: " . $e->getMessage());
            return [
                'avg_download' => 0,
                'avg_upload' => 0,
                'avg_ping' => 0,
                'total_tests' => 0
            ];
        }
    }

    /**
     * Get comprehensive analytics
     */
    public function getAnalytics()
    {
        try {
            $this->createTableIfNotExists();
            
            $analytics = [];
            
            // Overall statistics
            $analytics['overall'] = $this->getAverageSpeeds();
            
            // Speed distribution
            $analytics['speed_distribution'] = $this->getSpeedDistribution();
            
            // Location-based statistics
            $analytics['location_stats'] = $this->getLocationStats();
            
            // Time-based trends
            $analytics['time_trends'] = $this->getTimeTrends();
            
            // Performance categories
            $analytics['performance_categories'] = $this->getPerformanceCategories();
            
            return $analytics;
            
        } catch (PDOException $e) {
            error_log("Failed to get analytics: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get speed distribution
     */
    private function getSpeedDistribution()
    {
        $this->ensureConnection();
        
        $sql = "SELECT 
            CASE 
                WHEN download_speed < 25 THEN 'Slow (< 25 Mbps)'
                WHEN download_speed < 100 THEN 'Moderate (25-100 Mbps)'
                WHEN download_speed < 500 THEN 'Fast (100-500 Mbps)'
                ELSE 'Very Fast (> 500 Mbps)'
            END as speed_category,
            COUNT(*) as count
            FROM speed_tests 
            GROUP BY speed_category 
            ORDER BY count DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Get location statistics
     */
    private function getLocationStats()
    {
        $this->ensureConnection();
        
        $sql = "SELECT 
            country, city, 
            COUNT(*) as test_count,
            AVG(download_speed) as avg_download,
            AVG(upload_speed) as avg_upload,
            AVG(ping) as avg_ping
            FROM speed_tests 
            WHERE country != 'Unknown'
            GROUP BY country, city 
            ORDER BY test_count DESC 
            LIMIT 20";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Get time-based trends
     */
    private function getTimeTrends()
    {
        $this->ensureConnection();
        
        $sql = "SELECT 
            DATE(timestamp) as test_date,
            COUNT(*) as test_count,
            AVG(download_speed) as avg_download,
            AVG(upload_speed) as avg_upload,
            AVG(ping) as avg_ping
            FROM speed_tests 
            WHERE timestamp >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            GROUP BY DATE(timestamp) 
            ORDER BY test_date DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Get performance categories
     */
    private function getPerformanceCategories()
    {
        $this->ensureConnection();
        
        $sql = "SELECT 
            CASE 
                WHEN ping <= 50 THEN 'Excellent (≤ 50ms)'
                WHEN ping <= 100 THEN 'Good (51-100ms)'
                WHEN ping <= 200 THEN 'Fair (101-200ms)'
                ELSE 'Poor (> 200ms)'
            END as ping_category,
            COUNT(*) as count
            FROM speed_tests 
            GROUP BY ping_category 
            ORDER BY count DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Get test history with pagination
     */
    public function getTestHistory($limit = 50, $offset = 0)
    {
        try {
            $this->ensureConnection();
            $this->createTableIfNotExists();
            
            $sql = "SELECT * FROM speed_tests ORDER BY timestamp DESC LIMIT ? OFFSET ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$limit, $offset]);
            
            return $stmt->fetchAll();
            
        } catch (PDOException $e) {
            error_log("Failed to get test history: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get all tests for export
     */
    public function getAllTests()
    {
        try {
            $this->ensureConnection();
            $this->createTableIfNotExists();
            
            $sql = "SELECT * FROM speed_tests ORDER BY timestamp DESC";
            $stmt = $this->db->query($sql);
            
            return $stmt->fetchAll();
            
        } catch (PDOException $e) {
            error_log("Failed to get all tests: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Create speed_tests table if it doesn't exist
     */
    private function createTableIfNotExists()
    {
        // Ensure database connection is available
        $this->ensureConnection();
        
        $sql = "CREATE TABLE IF NOT EXISTS speed_tests (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ip_address VARCHAR(45) NOT NULL,
            download_speed DECIMAL(10,2) NOT NULL,
            upload_speed DECIMAL(10,2) NOT NULL,
            ping DECIMAL(10,2) NOT NULL,
            jitter DECIMAL(10,2) DEFAULT 0,
            country VARCHAR(100) DEFAULT 'Unknown',
            city VARCHAR(100) DEFAULT 'Unknown',
            user_agent TEXT,
            timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_timestamp (timestamp),
            INDEX idx_ip (ip_address),
            INDEX idx_location (country, city)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        try {
            $this->db->exec($sql);
        } catch (PDOException $e) {
            error_log("Failed to create speed_tests table: " . $e->getMessage());
        }
    }

    /**
     * Clean up old test data
     */
    public function cleanupOldData($days = 90)
    {
        try {
            $this->ensureConnection();
            $this->createTableIfNotExists();
            
            $sql = "DELETE FROM speed_tests WHERE timestamp < DATE_SUB(NOW(), INTERVAL ? DAY)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$days]);
            
            return $stmt->rowCount();
            
        } catch (PDOException $e) {
            error_log("Failed to cleanup old data: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get test statistics for a specific time period
     */
    public function getStatsForPeriod($start_date, $end_date)
    {
        try {
            $this->ensureConnection();
            $this->createTableIfNotExists();
            
            $sql = "SELECT 
                COUNT(*) as total_tests,
                AVG(download_speed) as avg_download,
                AVG(upload_speed) as avg_upload,
                AVG(ping) as avg_ping,
                AVG(jitter) as avg_jitter,
                MIN(download_speed) as min_download,
                MAX(download_speed) as max_download,
                MIN(upload_speed) as min_upload,
                MAX(upload_speed) as max_upload
                FROM speed_tests 
                WHERE timestamp BETWEEN ? AND ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$start_date, $end_date]);
            
            return $stmt->fetch();
            
        } catch (PDOException $e) {
            error_log("Failed to get stats for period: " . $e->getMessage());
            return [];
        }
    }
}
