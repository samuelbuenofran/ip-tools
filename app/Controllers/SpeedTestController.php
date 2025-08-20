<?php

namespace App\Controllers;

use App\Core\Controller;
// use App\Models\SpeedTest; // Not needed when manually including files

class SpeedTestController extends Controller
{
    private $speedTestModel;

    public function __construct()
    {
        parent::__construct();
        $this->speedTestModel = new \App\Models\SpeedTest();
    }

    /**
     * Display the speed test interface
     */
    public function index()
    {
        try {
            // Get recent test results
            $recent_tests = $this->speedTestModel->getRecentTests(10);
            
            // Calculate average speeds
            $avg_speeds = $this->speedTestModel->getAverageSpeeds();
            
            // Render the view
            $this->view->render('speed-test/index', [
                'recent_tests' => $recent_tests,
                'avg_speeds' => $avg_speeds
            ]);
            
        } catch (\Exception $e) {
            // Log error and show user-friendly message
            error_log("Speed test error: " . $e->getMessage());
            $this->view->render('speed-test/index', [
                'recent_tests' => [],
                'avg_speeds' => ['avg_download' => 0, 'avg_upload' => 0, 'avg_ping' => 0, 'total_tests' => 0],
                'error' => 'Unable to load speed test data. Please try again.'
            ]);
        }
    }

    /**
     * Save speed test results
     */
    public function save()
    {
        // Only allow POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        try {
            // Get POST data
            $download_speed = $_POST['download_speed'] ?? 0;
            $upload_speed = $_POST['upload_speed'] ?? 0;
            $ping = $_POST['ping'] ?? 0;
            $jitter = $_POST['jitter'] ?? 0;

            // Validate data
            if (!is_numeric($download_speed) || !is_numeric($upload_speed) || 
                !is_numeric($ping) || !is_numeric($jitter)) {
                throw new \Exception('Invalid speed test data');
            }

            // Get user IP and location
            $ip_address = $this->getUserIP();
            $location_data = $this->getLocationData($ip_address);

            // Save to database
            $result = $this->speedTestModel->saveTest([
                'ip_address' => $ip_address,
                'download_speed' => (float)$download_speed,
                'upload_speed' => (float)$upload_speed,
                'ping' => (float)$ping,
                'jitter' => (float)$jitter,
                'country' => $location_data['country'],
                'city' => $location_data['city'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
            ]);

            if ($result) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Speed test results saved successfully',
                    'test_id' => $result
                ]);
            } else {
                throw new \Exception('Failed to save test results');
            }

        } catch (\Exception $e) {
            error_log("Speed test save error: " . $e->getMessage());
            echo json_encode([
                'success' => false, 
                'message' => 'Failed to save speed test results: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display speed test analytics
     */
    public function analytics()
    {
        try {
            // Get comprehensive analytics data
            $analytics = $this->speedTestModel->getAnalytics();
            
            $this->view->render('speed-test/analytics', [
                'analytics' => $analytics
            ]);
            
        } catch (\Exception $e) {
            error_log("Speed test analytics error: " . $e->getMessage());
            $this->view->render('speed-test/analytics', [
                'analytics' => [],
                'error' => 'Unable to load analytics data. Please try again.'
            ]);
        }
    }

    /**
     * Get user's IP address
     */
    private function getUserIP()
    {
        return $_SERVER['HTTP_CLIENT_IP'] 
            ?? $_SERVER['HTTP_X_FORWARDED_FOR'] 
            ?? $_SERVER['REMOTE_ADDR'] 
            ?? 'UNKNOWN';
    }

    /**
     * Get location data for IP address
     */
    private function getLocationData($ip_address)
    {
        $country = 'Unknown';
        $city = 'Unknown';

        try {
            // Use ipwho.is service for geolocation
            $geo_url = "https://ipwho.is/{$ip_address}";
            $geo_response = @file_get_contents($geo_url);
            
            if ($geo_response) {
                $geo_data = json_decode($geo_response, true);
                if ($geo_data && isset($geo_data['success']) && $geo_data['success']) {
                    $country = $geo_data['country'] ?? 'Unknown';
                    $city = $geo_data['city'] ?? 'Unknown';
                }
            }
        } catch (\Exception $e) {
            // Continue without geocoding
            error_log("Geolocation error: " . $e->getMessage());
        }

        return [
            'country' => $country,
            'city' => $city
        ];
    }

    /**
     * API endpoint to get speed test history
     */
    public function history()
    {
        try {
            $limit = $_GET['limit'] ?? 50;
            $offset = $_GET['offset'] ?? 0;
            
            $tests = $this->speedTestModel->getTestHistory((int)$limit, (int)$offset);
            
            echo json_encode([
                'success' => true,
                'data' => $tests,
                'total' => count($tests)
            ]);
            
        } catch (\Exception $e) {
            error_log("Speed test history error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Failed to load test history'
            ]);
        }
    }

    /**
     * Export speed test data
     */
    public function export()
    {
        try {
            $format = $_GET['format'] ?? 'csv';
            $tests = $this->speedTestModel->getAllTests();
            
            switch ($format) {
                case 'csv':
                    $this->exportCSV($tests);
                    break;
                case 'json':
                    $this->exportJSON($tests);
                    break;
                default:
                    throw new \Exception('Unsupported export format');
            }
            
        } catch (\Exception $e) {
            error_log("Speed test export error: " . $e->getMessage());
            echo "Export failed: " . $e->getMessage();
        }
    }

    /**
     * Export data as CSV
     */
    private function exportCSV($tests)
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="speed_tests_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // CSV headers
        fputcsv($output, [
            'Date', 'IP Address', 'Download (Mbps)', 'Upload (Mbps)', 
            'Ping (ms)', 'Jitter (ms)', 'Country', 'City'
        ]);
        
        // Data rows
        foreach ($tests as $test) {
            fputcsv($output, [
                $test['timestamp'],
                $test['ip_address'],
                $test['download_speed'],
                $test['upload_speed'],
                $test['ping'],
                $test['jitter'] ?? 0,
                $test['country'],
                $test['city']
            ]);
        }
        
        fclose($output);
    }

    /**
     * Export data as JSON
     */
    private function exportJSON($tests)
    {
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="speed_tests_' . date('Y-m-d') . '.json"');
        
        echo json_encode([
            'export_date' => date('Y-m-d H:i:s'),
            'total_tests' => count($tests),
            'data' => $tests
        ], JSON_PRETTY_PRINT);
    }
} 