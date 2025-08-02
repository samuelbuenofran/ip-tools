<?php
// Test if the MVC application works without database access
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>MVC Application Test (No Database)</h1>";

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

echo "<h2>Expected Behavior</h2>";
echo "<ul>";
echo "<li>Login and Register pages should load without errors</li>";
echo "<li>Home page should load without errors</li>";
echo "<li>Dashboard should redirect to login (since not authenticated)</li>";
echo "<li>Any database-dependent features should show appropriate error messages</li>";
echo "</ul>";

echo "<h2>Database Issue</h2>";
echo "<p>The database connection is currently failing with: <code>SQLSTATE[HY000] [1045] Access denied for user 'techeletric_ip_tools'@'localhost'</code></p>";
echo "<p>This is likely due to:</p>";
echo "<ul>";
echo "<li>Incorrect database credentials</li>";
echo "<li>Database server not running</li>";
echo "<li>Database user doesn't exist or has wrong permissions</li>";
echo "<li>Database name doesn't exist</li>";
echo "</ul>";

echo "<h2>Next Steps</h2>";
echo "<p>1. Verify the database credentials in <code>app/Config/Database.php</code></p>";
echo "<p>2. Check if the database server is running</p>";
echo "<p>3. Verify the database and user exist</p>";
echo "<p>4. Test the connection manually</p>";
?> 