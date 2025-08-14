<?php
// Test script to debug database issues with link creation and retrieval
require_once 'config.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Database Connection Test</h2>";
    echo "✅ Database connected successfully<br><br>";
    
    // Test 1: Check if users table exists and has admin user
    echo "<h3>1. Users Table Check</h3>";
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Users table exists<br>";
        
        $stmt = $pdo->query("SELECT * FROM users WHERE username = 'admin'");
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($admin) {
            echo "✅ Admin user exists (ID: {$admin['id']})<br>";
        } else {
            echo "❌ Admin user not found<br>";
        }
    } else {
        echo "❌ Users table does not exist<br>";
    }
    
    // Test 2: Check geo_links table structure
    echo "<h3>2. Geo Links Table Structure</h3>";
    $stmt = $pdo->query("DESCRIBE geo_links");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $requiredColumns = ['id', 'user_id', 'original_url', 'short_code', 'created_at', 'expires_at', 'clicks'];
    $existingColumns = array_column($columns, 'Field');
    
    foreach ($requiredColumns as $col) {
        if (in_array($col, $existingColumns)) {
            echo "✅ Column '{$col}' exists<br>";
        } else {
            echo "❌ Column '{$col}' MISSING<br>";
        }
    }
    
    // Test 3: Check existing links
    echo "<h3>3. Existing Links Check</h3>";
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM geo_links");
    $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    echo "Total links in database: {$total}<br>";
    
    if ($total > 0) {
        $stmt = $pdo->query("SELECT * FROM geo_links LIMIT 3");
        $links = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h4>Sample Links:</h4>";
        foreach ($links as $link) {
            echo "ID: {$link['id']}, URL: {$link['original_url']}, Code: {$link['short_code']}, User ID: " . ($link['user_id'] ?? 'NULL') . "<br>";
        }
    }
    
    // Test 4: Try to create a test link
    echo "<h3>4. Test Link Creation</h3>";
    $testData = [
        'user_id' => 1,
        'original_url' => 'https://test-example.com',
        'short_code' => 'TEST' . time(),
        'expires_at' => null
    ];
    
    try {
        $sql = "INSERT INTO geo_links (user_id, original_url, short_code, expires_at) 
                VALUES (:user_id, :original_url, :short_code, :expires_at)";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute($testData);
        
        if ($result) {
            $newId = $pdo->lastInsertId();
            echo "✅ Test link created successfully (ID: {$newId})<br>";
            
            // Test 5: Try to retrieve the test link
            echo "<h3>5. Test Link Retrieval</h3>";
            $stmt = $pdo->prepare("SELECT * FROM geo_links WHERE user_id = :user_id ORDER BY created_at DESC");
            $stmt->execute(['user_id' => 1]);
            $userLinks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "Found " . count($userLinks) . " links for user ID 1<br>";
            
            if (count($userLinks) > 0) {
                echo "<h4>User Links:</h4>";
                foreach ($userLinks as $link) {
                    echo "ID: {$link['id']}, URL: {$link['original_url']}, Code: {$link['short_code']}, Created: " . ($link['created_at'] ?? 'NULL') . ", Clicks: " . ($link['clicks'] ?? 'NULL') . "<br>";
                }
            }
            
            // Clean up test link
            $pdo->exec("DELETE FROM geo_links WHERE id = {$newId}");
            echo "🧹 Test link cleaned up<br>";
            
        } else {
            echo "❌ Failed to create test link<br>";
            echo "Error: " . print_r($stmt->errorInfo(), true) . "<br>";
        }
    } catch (Exception $e) {
        echo "❌ Error creating test link: " . $e->getMessage() . "<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}
?>
