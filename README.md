# IP Tools Suite - Professional Geolocation & Network Intelligence Platform

[![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)](https://github.com/your-username/ip-tools)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/php-7.4+-purple.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/mysql-5.7+-orange.svg)](https://mysql.com)

> **Enterprise-grade tools for geolocation tracking, network analysis, and digital forensics. Built for developers, security professionals, and businesses who need reliable IP intelligence.**

## 🎯 **What is IP Tools Suite?**

IP Tools Suite is a comprehensive web application that provides professional-grade tools for:

- **🌍 Geolocation Tracking** - Create location-aware tracking links with pinpoint accuracy
- **📊 Advanced Analytics** - Visualize data with interactive heatmaps and detailed reports
- **📱 SMS Tracking** - Monitor engagement across mobile devices with click analytics
- **🔍 IP Intelligence** - Get instant insights into any IP address for security analysis
- **🌐 Network Diagnostics** - Comprehensive speed testing and performance monitoring
- **🛡️ Security Tools** - Professional-grade utilities for development and security research

## ✨ **Key Features**

### 🔐 **Enterprise Security**
- **CSRF Protection** - Built-in security against cross-site request forgery
- **Session Management** - Secure user authentication and authorization
- **Admin Controls** - Role-based access control for team management
- **Audit Logging** - Comprehensive tracking of all system activities

### 📱 **Modern User Experience**
- **Responsive Design** - Works perfectly on desktop, tablet, and mobile
- **Theme System** - Multiple professional themes including macOS Aqua and Liquid Glass
- **Real-time Updates** - Live data refresh and interactive dashboards
- **Intuitive Interface** - Clean, professional design that's easy to navigate

### 🚀 **Developer Friendly**
- **MVC Architecture** - Clean, maintainable code structure
- **RESTful API** - Well-designed endpoints for integration
- **Extensible Design** - Easy to add new features and modules
- **Comprehensive Logging** - Debug and monitor system performance

## 🏗️ **Architecture Overview**

```
IP Tools Suite
├── 🎨 Frontend (HTML5, CSS3, JavaScript)
├── 🔧 Backend (PHP 7.4+, MVC Framework)
├── 🗄️ Database (MySQL 5.7+)
├── 🚀 Web Server (Apache/Nginx)
└── 📱 Mobile Responsive Design
```

## 🚀 **Quick Start Guide**

### **Prerequisites**
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Composer (for dependency management)

### **Installation**

1. **Clone the Repository**
   ```bash
   git clone https://github.com/your-username/ip-tools.git
   cd ip-tools
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Configure Database**
   ```bash
   # Copy configuration file
   cp config.example.php config.php
   
   # Edit database settings
   nano config.php
   ```

4. **Run Database Setup**
   ```bash
   php setup_database.php
   ```

5. **Configure Web Server**
   ```apache
   # Apache .htaccess (already included)
   RewriteEngine On
   RewriteCond %{REQUEST_FILENAME} !-f
   RewriteCond %{REQUEST_FILENAME} !-d
   RewriteRule ^(.*)$ public/index.php [QSA,L]
   ```

6. **Access Your Application**
   ```
   http://your-domain.com/projects/ip-tools/public/
   ```

### **Default Login Credentials**
- **Username:** `admin`
- **Password:** `admin123`
- **Role:** Administrator

## 🎨 **Theme System**

IP Tools Suite includes multiple professional themes:

- **🌞 Light Theme** - Clean, professional appearance
- **🌙 Dark Theme** - Easy on the eyes for extended use
- **🌅 Dim Theme** - Reduced brightness for comfort
- **🌊 macOS Aqua** - Classic Apple-inspired design
- **💎 Liquid Glass** - Modern frosted glass effects

## 📊 **Dashboard Features**

### **Geolocation Tracker**
- Create tracking links with custom parameters
- Real-time visitor location mapping
- Device detection and analytics
- Export data in multiple formats

### **Network Diagnostics**
- Speed testing with detailed metrics
- Ping analysis and network monitoring
- Performance benchmarking tools
- Historical data tracking

### **Phone Tracker**
- SMS link tracking and analytics
- Mobile device engagement metrics
- Click-through rate analysis
- Geographic distribution reports

## 🔧 **Configuration Options**

### **Environment Variables**
```php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'ip_tools');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');

// Application Settings
define('APP_DEBUG', false);
define('APP_URL', 'https://your-domain.com');
define('GOOGLE_MAPS_API_KEY', 'your_api_key');
```

### **Security Settings**
```php
// Session Configuration
define('SESSION_LIFETIME', 3600); // 1 hour
define('SESSION_NAME', 'ip_tools_session');

// CSRF Protection
define('CSRF_TOKEN_EXPIRY', 1800); // 30 minutes
```

## 📱 **API Endpoints**

### **Authentication**
```
POST /auth/login      - User authentication
POST /auth/register   - User registration
POST /auth/logout     - User logout
GET  /auth/profile    - User profile
```

### **Geolocation**
```
POST /geologger/create           - Create tracking link
GET  /geologger/logs            - View tracking logs
GET  /geologger/my-links        - User's tracking links
POST /geologger/precise_track   - Precise location tracking
```

### **Network Tools**
```
POST /speed-test/save      - Save speed test results
GET  /speed-test/analytics - View speed test analytics
GET  /speed-test/export    - Export speed test data
```

## 🛡️ **Security Features**

- **CSRF Protection** - Prevents cross-site request forgery attacks
- **SQL Injection Prevention** - Prepared statements and parameterized queries
- **XSS Protection** - Input sanitization and output encoding
- **Session Security** - Secure session management with configurable timeouts
- **Role-based Access Control** - Granular permissions for different user types

## 📈 **Performance & Scalability**

- **Database Optimization** - Indexed queries and efficient data structures
- **Caching System** - Configurable caching for improved performance
- **Asset Optimization** - Minified CSS/JS and optimized images
- **Responsive Design** - Mobile-first approach for all devices

## 🧪 **Testing & Quality Assurance**

- **Unit Testing** - Comprehensive test coverage for core functionality
- **Integration Testing** - End-to-end testing of user workflows
- **Performance Testing** - Load testing and optimization
- **Security Testing** - Vulnerability assessment and penetration testing

## 🤝 **Contributing**

We welcome contributions from the community! Please read our [Contributing Guidelines](CONTRIBUTING.md) before submitting pull requests.

### **Development Setup**
```bash
# Fork and clone the repository
git clone https://github.com/your-username/ip-tools.git

# Create a feature branch
git checkout -b feature/amazing-feature

# Make your changes and commit
git commit -m 'Add amazing feature'

# Push to your fork
git push origin feature/amazing-feature

# Create a Pull Request
```

## 📄 **License**

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 **Support & Documentation**

- **📖 [User Guide](docs/USER_GUIDE.md)** - Complete user documentation
- **🔧 [API Reference](docs/API_REFERENCE.md)** - Detailed API documentation
- **🚀 [Developer Guide](docs/DEVELOPER_GUIDE.md)** - Development and contribution guide
- **🐛 [Issue Tracker](https://github.com/your-username/ip-tools/issues)** - Report bugs and request features
- **💬 [Discussions](https://github.com/your-username/ip-tools/discussions)** - Community support and questions

## 🌟 **Why Choose IP Tools Suite?**

- **✅ Professional Grade** - Built for enterprise use with security in mind
- **✅ Easy to Use** - Intuitive interface that requires no technical expertise
- **✅ Highly Customizable** - Flexible configuration and theming options
- **✅ Scalable Architecture** - Designed to grow with your business needs
- **✅ Active Development** - Regular updates and new features
- **✅ Community Support** - Active community and comprehensive documentation

## 📞 **Contact & Support**

- **🌐 Website:** [https://your-domain.com](https://your-domain.com)
- **📧 Email:** support@your-domain.com
- **💬 Chat:** [Discord Community](https://discord.gg/your-community)
- **📱 Social:** [Twitter](https://twitter.com/your-handle) | [LinkedIn](https://linkedin.com/company/your-company)

---

**Built with ❤️ by the IP Tools Suite Team**

*Empowering developers and businesses with professional-grade IP intelligence tools.*
