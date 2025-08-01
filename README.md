# IP Tools Suite - MVC Architecture

A modern, scalable web application built with PHP following the MVC (Model-View-Controller) design pattern. This platform provides advanced geolocation tracking, phone monitoring, and network analytics capabilities.

## 🏗️ Architecture Overview

### MVC Structure

```
app/
├── Config/           # Configuration classes
│   ├── App.php      # Application settings
│   └── Database.php # Database configuration
├── Core/            # Core framework classes
│   ├── Controller.php # Base controller
│   ├── Router.php   # URL routing
│   └── View.php     # Template rendering
├── Controllers/     # Application controllers
│   ├── HomeController.php
│   ├── GeologgerController.php
│   └── ...
├── Models/          # Data models
│   ├── GeoLink.php
│   ├── GeoLog.php
│   └── ...
└── Views/           # Template files
    ├── layouts/
    ├── home/
    ├── geologger/
    └── ...

public/              # Public entry point
├── index.php        # Main application entry
└── assets/          # Static assets

vendor/              # Composer dependencies
```

## 🚀 Features

### Core Functionality

- **Precise Geolocation Tracking**: GPS-based location tracking with street-level accuracy
- **Phone Tracking**: SMS link monitoring and mobile device analytics
- **Speed Testing**: Comprehensive internet speed testing with historical data
- **Stealth Mode**: Invisible tracking with immediate redirects
- **Analytics Dashboard**: Real-time statistics and heatmap visualization

### Technical Features

- **MVC Architecture**: Clean separation of concerns
- **PSR-4 Autoloading**: Modern PHP standards
- **Database Abstraction**: PDO with prepared statements
- **Security**: CSRF protection, input sanitization
- **Responsive Design**: Bootstrap 5 with dark mode
- **Error Handling**: Comprehensive logging and debugging

## 📋 Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Composer
- Web server (Apache/Nginx)

## 🛠️ Installation

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/ip-tools.git
cd ip-tools
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure Database

Edit `app/Config/Database.php` with your database credentials:

```php
private $host = 'localhost';
private $dbname = 'your_database';
private $username = 'your_username';
private $password = 'your_password';
```

### 4. Import Database Schema

```bash
mysql -u username -p database_name < techeletric_ip_tools.sql
```

### 5. Configure Web Server

#### Apache (.htaccess)

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ public/index.php [QSA,L]
```

#### Nginx

```nginx
location / {
    try_files $uri $uri/ /public/index.php?$query_string;
}
```

### 6. Set Permissions

```bash
chmod 755 logs/
chmod 644 app/Config/Database.php
```

## 🔧 Configuration

### Application Settings (`app/Config/App.php`)

```php
const APP_NAME = 'IP Tools Suite';
const BASE_URL = 'https://your-domain.com';
const DEBUG_MODE = false;
const SHOW_LOCATION_MESSAGES = false; // Stealth mode
```

### Privacy Settings

- **Normal Mode**: Users see tracking messages
- **Stealth Mode**: Hidden tracking messages
- **Ultimate Stealth**: Immediate redirects

## 📖 Usage

### Creating Tracking Links

1. Navigate to `/geologger/create`
2. Enter destination URL
3. Set expiration date (optional)
4. Generate tracking link and QR code

### Viewing Analytics

1. Navigate to `/geologger/logs`
2. View visitor statistics
3. Analyze heatmap data
4. Export reports

### Phone Tracking

1. Navigate to `/phone-tracker/send_sms`
2. Create SMS tracking links
3. Monitor click analytics
4. View detailed reports

### Speed Testing

1. Navigate to `/utils/speedtest`
2. Run speed tests
3. View historical data
4. Analyze performance trends

## 🏛️ MVC Pattern Implementation

### Models

Models handle data logic and database interactions:

```php
class GeoLink extends Model {
    public function create($data) {
        // Database insertion logic
    }

    public function findByCode($code) {
        // Database query logic
    }
}
```

### Views

Views handle presentation and user interface:

```php
// app/Views/home/index.php
<div class="container">
    <h1><?= $title ?></h1>
    <div class="stats">
        <?= $this->renderPartial('stats', $stats) ?>
    </div>
</div>
```

### Controllers

Controllers handle business logic and request processing:

```php
class HomeController extends Controller {
    public function index() {
        $stats = $this->geoLink->getStats();
        return $this->render('home/index', ['stats' => $stats]);
    }
}
```

## 🔒 Security Features

### CSRF Protection

```php
// In forms
<?= $this->csrf() ?>

// In controllers
$this->validateCSRF();
```

### Input Sanitization

```php
$input = $this->sanitizeInput($_POST['data']);
```

### SQL Injection Prevention

```php
// Using prepared statements
$stmt = $this->db->query("SELECT * FROM users WHERE id = ?", [$id]);
```

## 🧪 Testing

### Running Tests

```bash
composer test
```

### Manual Testing

1. Create tracking links
2. Test stealth mode
3. Verify GPS tracking
4. Check analytics accuracy

## 📊 Database Schema

### Core Tables

- `geo_links`: Tracking link management
- `geo_logs`: Visitor tracking data
- `phone_tracking`: SMS tracking data
- `phone_clicks`: SMS click analytics
- `speed_tests`: Speed test results

## 🔧 Development

### Adding New Features

1. Create controller in `app/Controllers/`
2. Create model in `app/Models/`
3. Create views in `app/Views/`
4. Add routes in `public/index.php`

### Code Standards

- PSR-4 autoloading
- PSR-12 coding style
- Comprehensive error handling
- Detailed logging

## 🚀 Deployment

### Production Checklist

- [ ] Set `DEBUG_MODE = false`
- [ ] Configure database credentials
- [ ] Set up SSL certificate
- [ ] Configure web server
- [ ] Set proper file permissions
- [ ] Enable error logging
- [ ] Configure backup system

### Performance Optimization

- Enable OPcache
- Use CDN for static assets
- Implement caching
- Optimize database queries

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests
5. Submit a pull request

## 📞 Support

For support and questions:

- Email: contact@keizai-tech.com
- Documentation: `/support`
- Issues: GitHub Issues

---

**Built with ❤️ by Keizai Tech**
