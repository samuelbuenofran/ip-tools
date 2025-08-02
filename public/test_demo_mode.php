<?php
// Test script to verify demo mode functionality
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Demo Mode Test</h1>";

// Test 1: Check if we can access the login page
echo "<h2>Test 1: Login Page Access</h2>";
echo "<p>Try accessing: <a href='auth/login' target='_blank'>Login Page</a></p>";

// Test 2: Check if we can access the register page
echo "<h2>Test 2: Register Page Access</h2>";
echo "<p>Try accessing: <a href='auth/register' target='_blank'>Register Page</a></p>";

// Test 3: Check if we can access the home page
echo "<h2>Test 3: Home Page Access</h2>";
echo "<p>Try accessing: <a href='home' target='_blank'>Home Page</a></p>";

// Test 4: Check if we can access the dashboard (should redirect to login)
echo "<h2>Test 4: Dashboard Access (Should Redirect to Login)</h2>";
echo "<p>Try accessing: <a href='dashboard' target='_blank'>Dashboard</a></p>";

echo "<h2>Demo Mode Instructions</h2>";
echo "<p>To test the application in demo mode:</p>";
echo "<ol>";
echo "<li>Go to the <a href='auth/login' target='_blank'>Login Page</a></li>";
echo "<li>Use these credentials:</li>";
echo "<ul>";
echo "<li><strong>Username:</strong> admin</li>";
echo "<li><strong>Password:</strong> admin123</li>";
echo "</ul>";
echo "<li>You should be redirected to the dashboard with demo data</li>";
echo "<li>You can then test the links and logs pages</li>";
echo "</ol>";

echo "<h2>Expected Behavior</h2>";
echo "<ul>";
echo "<li>Login and Register pages should load without errors</li>";
echo "<li>Home page should load without errors</li>";
echo "<li>Dashboard should redirect to login (since not authenticated)</li>";
echo "<li>After login with admin/admin123, you should see demo data</li>";
echo "<li>All pages should work without database connection</li>";
echo "</ul>";

echo "<h2>Database Status</h2>";
echo "<p>The database connection is currently failing, but the application should work in demo mode.</p>";
echo "<p>To set up the database later, you can:</p>";
echo "<ul>";
echo "<li>Run <a href='../setup_database.php'>setup_database.php</a> (requires MySQL root access)</li>";
echo "<li>Or update the database credentials in <code>app/Config/Database.php</code></li>";
echo "</ul>";
?> 