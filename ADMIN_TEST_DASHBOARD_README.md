# Admin Test Dashboard - IP Tools Suite

## 🎯 Overview

The Admin Test Dashboard is a comprehensive testing and monitoring tool designed exclusively for admin users. It provides centralized access to all diagnostic tools, system tests, and monitoring capabilities for your IP Tools Suite.

## 🔐 Access Control

- **Admin Only**: Only users with `user_role = 'admin'` can access this dashboard
- **Session Required**: Must be logged in to access any admin functions
- **Secure Routes**: All admin routes are protected by authentication middleware

## 🚀 How to Access

### Method 1: Via Main Dashboard
1. Log in as an admin user
2. Go to your main dashboard (`/dashboard`)
3. Click the **"Admin Panel"** button (yellow button with shield icon)
4. You'll be taken to the admin dashboard

### Method 2: Direct URL
- **Admin Dashboard**: `/admin`
- **Test Dashboard**: `/admin/test_dashboard`
- **Privacy Settings**: `/admin/privacy_settings`

## 🛠️ Available Tools

### 1. System Status
- **PHP Version**: Current PHP version running
- **Database Status**: Connection status and MySQL version
- **Server Information**: Web server software details
- **Real-time Monitoring**: Live system performance metrics

### 2. Database Status
- **Table Counts**: Total records in each table
- **Table Status**: Verify all required tables exist
- **Connection Health**: Database connectivity status
- **Performance Metrics**: Query performance and statistics

### 3. Test Tools
- **Google Maps API Test**: Test Google Maps integration and API key validity
- **Database Connection Test**: Verify database connectivity
- **Database Debug Test**: Advanced schema validation and debugging
- **Tracking System Test**: Test geolocation tracking functionality

### 4. Quick Tests
- **URL Generation Test**: Test routing and URL generation
- **Session Test**: Verify session management and authentication
- **Real-time Updates**: Live system status updates

### 5. System Information
- **Environment Details**: Server timezone, memory limits, execution time
- **PHP Extensions**: Check required PHP extensions are loaded
- **Configuration**: Current application settings

## 🔍 Testing Features

### Google Maps API Testing
- Tests API key validity
- Verifies map loading and rendering
- Checks heatmap visualization
- Provides detailed error messages

### Database Testing
- Connection validation
- Table existence verification
- Schema validation
- Performance benchmarking

### System Monitoring
- Real-time performance metrics
- Memory and CPU usage simulation
- Response time monitoring
- System health indicators

## 📊 What You Can Monitor

1. **Database Health**
   - Table counts and status
   - Connection stability
   - Query performance

2. **API Status**
   - Google Maps functionality
   - Geolocation services
   - External API connectivity

3. **System Performance**
   - PHP configuration
   - Server resources
   - Application response times

4. **Security Status**
   - Session management
   - Authentication flow
   - Access control verification

## 🚨 Troubleshooting

### Common Issues

1. **"Access Denied" Error**
   - Ensure you're logged in as admin
   - Check your user role is set to 'admin'
   - Verify session is active

2. **Google Maps Not Loading**
   - Check API key validity
   - Verify billing is enabled
   - Check domain restrictions
   - Use the diagnostic script: `test_google_maps.php`

3. **Database Connection Issues**
   - Verify database credentials in `config.php`
   - Check MySQL service status
   - Verify table existence

### Debug Steps

1. **Check Browser Console** for JavaScript errors
2. **Review PHP Error Logs** for server-side issues
3. **Use Test Tools** to isolate specific problems
4. **Verify File Permissions** for configuration files

## 🔧 Customization

### Adding New Tests
1. Create test methods in `AdminController`
2. Add routes in `public/index.php`
3. Create corresponding view files
4. Update the admin dashboard navigation

### Modifying Test Parameters
- Edit test configurations in individual test files
- Adjust monitoring intervals in JavaScript
- Customize error thresholds and alerts

## 📁 File Structure

```
admin/
├── test_dashboard.php          # Main test dashboard
├── privacy_settings.php        # Privacy configuration
└── index.php                   # Admin dashboard index

app/
├── Controllers/
│   └── AdminController.php     # Admin logic and methods
└── Views/
│   └── admin/
│       ├── index.php           # Admin dashboard view
│       └── privacy_settings.php # Privacy settings view

test_google_maps.php            # Google Maps diagnostic script
test_database_connection.php    # Database connection test
test_database_debug.php         # Advanced database debugging
test_tracking.php               # Tracking system test
```

## 🎉 Benefits

1. **Centralized Testing**: All diagnostic tools in one place
2. **Real-time Monitoring**: Live system health updates
3. **Comprehensive Coverage**: Tests all major system components
4. **Easy Access**: Simple navigation from main dashboard
5. **Professional Interface**: Clean, modern admin interface
6. **Security**: Admin-only access with proper authentication

## 🚀 Getting Started

1. **Log in as admin** to your IP Tools Suite
2. **Click "Admin Panel"** from your dashboard
3. **Explore the tools** available in each section
4. **Run tests** to verify system health
5. **Monitor performance** in real-time
6. **Use diagnostic tools** to troubleshoot issues

---

**Note**: This dashboard is designed for system administrators and developers. Regular users will not see these options, ensuring security and preventing unauthorized access to system tools.
