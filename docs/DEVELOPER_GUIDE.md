# IP Tools Suite - Developer Guide

## 🚀 **Welcome, Developers!**

This guide is your comprehensive resource for understanding, contributing to, and extending the IP Tools Suite. Whether you're a seasoned developer or just getting started, this guide will help you navigate the codebase and make meaningful contributions.

## 🏗️ **Project Architecture**

### **Directory Structure**

```
ip-tools/
├── 📁 app/                          # Application core
│   ├── 📁 Config/                   # Configuration classes
│   │   ├── App.php                  # Application settings
│   │   └── Database.php             # Database configuration
│   ├── 📁 Core/                     # Framework core classes
│   │   ├── Controller.php           # Base controller
│   │   ├── Router.php               # URL routing system
│   │   ├── View.php                 # Template rendering
│   │   └── AuthMiddleware.php       # Authentication system
│   ├── 📁 Controllers/              # Application controllers
│   │   ├── HomeController.php       # Home page logic
│   │   ├── AuthController.php       # Authentication logic
│   │   ├── DashboardController.php  # Dashboard logic
│   │   └── ...                      # Other controllers
│   ├── 📁 Models/                   # Data models
│   │   ├── User.php                 # User data model
│   │   ├── GeoLink.php              # Tracking link model
│   │   ├── GeoLog.php               # Tracking log model
│   │   └── ...                      # Other models
│   └── 📁 Views/                    # Template files
│       ├── 📁 layouts/              # Page layouts
│       ├── 📁 home/                 # Home page templates
│       ├── 📁 auth/                 # Authentication templates
│       └── ...                      # Other view templates
├── 📁 public/                       # Public entry point
│   ├── index.php                    # Main application bootstrap
│   ├── .htaccess                    # URL rewriting rules
│   └── 📁 assets/                   # Static assets
├── 📁 assets/                       # Application assets
│   ├── themes.css                   # Theme system
│   ├── theme-switcher.js            # Theme management
│   └── ...                          # Other assets
├── 📁 docs/                         # Documentation
├── 📁 logs/                         # Application logs
├── 📁 vendor/                       # Composer dependencies
├── composer.json                     # PHP dependencies
├── README.md                         # Project overview
└── LICENSE                           # License information
```

### **Technology Stack**

- **Backend**: PHP 7.4+ with custom MVC framework
- **Database**: MySQL 5.7+ with PDO abstraction
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Styling**: Bootstrap 5 with custom theme system
- **Icons**: FontAwesome and custom SVG icons
- **Build Tools**: Composer for PHP dependencies

## 🔧 **Development Environment Setup**

### **Prerequisites**

- **PHP**: 7.4 or higher
- **MySQL**: 5.7 or higher
- **Composer**: Latest version
- **Git**: For version control
- **Web Server**: Apache/Nginx (or built-in PHP server)

### **Local Development Setup**

1. **Clone the Repository**
   ```bash
   git clone https://github.com/your-username/ip-tools.git
   cd ip-tools
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Database Setup**
   ```bash
   # Create database
   mysql -u root -p -e "CREATE DATABASE ip_tools_dev;"
   
   # Import schema
   mysql -u root -p ip_tools_dev < techeletric_ip_tools.sql
   ```

4. **Configuration**
   ```bash
   # Copy configuration
   cp config.example.php config.php
   
   # Edit database settings
   nano config.php
   ```

5. **Start Development Server**
   ```bash
   # Using PHP built-in server
   php -S localhost:8000 -t public/
   
   # Or configure Apache/Nginx
   ```

### **IDE Configuration**

#### **VS Code Extensions**
- **PHP Intelephense**: PHP language support
- **PHP Debug**: Xdebug integration
- **PHP DocBlocker**: PHPDoc comments
- **GitLens**: Git integration
- **Thunder Client**: API testing

#### **PHPStorm/IntelliJ**
- **PHP Support**: Built-in PHP support
- **Database Tools**: Database integration
- **Git Integration**: Version control
- **Debugging**: Xdebug support

## 📚 **Understanding the Codebase**

### **MVC Pattern Implementation**

The application follows the Model-View-Controller pattern:

#### **Models (Data Layer)**
Models handle data logic and database interactions:

```php
class GeoLink extends Model {
    public function create($data) {
        $sql = "INSERT INTO geo_links (user_id, destination_url, tracking_code) 
                VALUES (:user_id, :destination_url, :tracking_code)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'destination_url' => $data['destination_url'],
            'tracking_code' => $data['tracking_code']
        ]);
    }
    
    public function findByCode($code) {
        $sql = "SELECT * FROM geo_links WHERE tracking_code = :code";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['code' => $code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
```

#### **Views (Presentation Layer)**
Views handle the user interface and presentation:

```php
<!-- app/Views/geologger/create.php -->
<div class="container">
    <h1><?= $title ?></h1>
    
    <form method="POST" action="<?= $view->url('geologger/create') ?>">
        <?= $view->csrf() ?>
        
        <div class="mb-3">
            <label for="destination_url">Destination URL</label>
            <input type="text" name="destination_url" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Create Tracking Link</button>
    </form>
</div>
```

#### **Controllers (Logic Layer)**
Controllers handle business logic and request processing:

```php
class GeologgerController extends Controller {
    public function create() {
        if ($this->isPost()) {
            $this->validateCSRF();
            
            $data = [
                'destination_url' => $this->getPost('destination_url'),
                'user_id' => $this->getCurrentUserId(),
                'tracking_code' => $this->generateTrackingCode()
            ];
            
            if ($this->geoLinkModel->create($data)) {
                $_SESSION['success_message'] = 'Tracking link created successfully!';
                $this->redirect('geologger/my-links');
            }
        }
        
        return $this->render('geologger/create', [
            'title' => 'Create Tracking Link'
        ]);
    }
}
```

### **Routing System**

The router maps URLs to controller actions:

```php
// public/index.php
$router->add('geologger/create', [
    'controller' => 'GeologgerController', 
    'action' => 'create'
]);

$router->add('geologger/logs', [
    'controller' => 'GeologgerController', 
    'action' => 'logs'
]);
```

### **Authentication System**

The authentication middleware protects routes:

```php
class AuthMiddleware {
    private static $publicRoutes = [
        '', 'home', 'about', 'contact', 'privacy', 'support',
        'auth/login', 'auth/register'
    ];
    
    public static function requiresAuth($route) {
        return !in_array(trim($route, '/'), self::$publicRoutes);
    }
    
    public static function requireAuth() {
        if (!self::isAuthenticated()) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? '/';
            App::redirect('auth/login');
        }
    }
}
```

## 🛠️ **Adding New Features**

### **Step-by-Step Feature Development**

#### **1. Plan Your Feature**
- Define the feature requirements
- Identify affected components
- Plan the database changes
- Design the user interface

#### **2. Create the Database Schema**
```sql
-- Example: Adding a new feature table
CREATE TABLE feature_examples (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

#### **3. Create the Model**
```php
// app/Models/FeatureExample.php
class FeatureExample extends Model {
    public function create($data) {
        $sql = "INSERT INTO feature_examples (user_id, title, description) 
                VALUES (:user_id, :title, :description)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'description' => $data['description']
        ]);
    }
    
    public function findByUserId($userId) {
        $sql = "SELECT * FROM feature_examples WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
```

#### **4. Create the Controller**
```php
// app/Controllers/FeatureExampleController.php
class FeatureExampleController extends Controller {
    private $featureExampleModel;
    
    public function __construct($params = []) {
        parent::__construct($params);
        $this->featureExampleModel = new FeatureExample();
    }
    
    public function index() {
        $this->requireLogin();
        
        $examples = $this->featureExampleModel->findByUserId($this->getCurrentUserId());
        
        return $this->render('feature-example/index', [
            'title' => 'Feature Examples',
            'examples' => $examples
        ]);
    }
    
    public function create() {
        $this->requireLogin();
        
        if ($this->isPost()) {
            $this->validateCSRF();
            
            $data = [
                'user_id' => $this->getCurrentUserId(),
                'title' => $this->sanitizeInput($this->getPost('title')),
                'description' => $this->sanitizeInput($this->getPost('description'))
            ];
            
            if ($this->featureExampleModel->create($data)) {
                $_SESSION['success_message'] = 'Feature example created successfully!';
                $this->redirect('feature-example');
            }
        }
        
        return $this->render('feature-example/create', [
            'title' => 'Create Feature Example'
        ]);
    }
}
```

#### **5. Create the Views**
```php
<!-- app/Views/feature-example/index.php -->
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= $title ?></h1>
        <a href="<?= $view->url('feature-example/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New
        </a>
    </div>
    
    <?php if (empty($examples)): ?>
        <div class="alert alert-info">No feature examples found.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($examples as $example): ?>
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($example['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($example['description']) ?></p>
                            <span class="badge bg-<?= $example['status'] === 'active' ? 'success' : 'secondary' ?>">
                                <?= ucfirst($example['status']) ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
```

#### **6. Add Routes**
```php
// public/index.php
$router->add('feature-example', [
    'controller' => 'FeatureExampleController', 
    'action' => 'index'
]);

$router->add('feature-example/create', [
    'controller' => 'FeatureExampleController', 
    'action' => 'create'
]);
```

#### **7. Update Navigation**
```php
<!-- app/Views/layouts/default.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= $view->url('') ?>">IP Tools Suite</a>
        
        <div class="navbar-nav">
            <a class="nav-link" href="<?= $view->url('dashboard') ?>">Dashboard</a>
            <a class="nav-link" href="<?= $view->url('geologger/create') ?>">Geolocation</a>
            <a class="nav-link" href="<?= $view->url('feature-example') ?>">Feature Examples</a>
        </div>
    </div>
</nav>
```

## 🧪 **Testing Your Code**

### **Manual Testing**
1. **Test the Feature**: Use the application manually
2. **Test Edge Cases**: Try invalid inputs, empty data
3. **Test Security**: Verify CSRF protection, authentication
4. **Test Responsiveness**: Check mobile and desktop views

### **Automated Testing**
```php
// tests/FeatureExampleTest.php
class FeatureExampleTest extends TestCase {
    public function testCreateFeatureExample() {
        $controller = new FeatureExampleController();
        $result = $controller->create();
        
        $this->assertNotNull($result);
        $this->assertContains('Create Feature Example', $result);
    }
}
```

### **Database Testing**
```php
// tests/FeatureExampleModelTest.php
class FeatureExampleModelTest extends TestCase {
    public function testCreateFeatureExample() {
        $model = new FeatureExample();
        $data = [
            'user_id' => 1,
            'title' => 'Test Example',
            'description' => 'Test Description'
        ];
        
        $result = $model->create($data);
        $this->assertTrue($result);
    }
}
```

## 🔒 **Security Best Practices**

### **Input Validation**
```php
// Always validate and sanitize input
$title = $this->sanitizeInput($this->getPost('title'));
$description = $this->sanitizeInput($this->getPost('description'));

// Validate required fields
$errors = $this->validateRequired($_POST, ['title', 'description']);
if (!empty($errors)) {
    $_SESSION['error_message'] = implode(', ', $errors);
    $this->redirect('feature-example/create');
}
```

### **CSRF Protection**
```php
// Include CSRF token in all forms
<?= $view->csrf() ?>

// Validate CSRF token in controllers
$this->validateCSRF();
```

### **SQL Injection Prevention**
```php
// Use prepared statements
$sql = "SELECT * FROM feature_examples WHERE user_id = :user_id";
$stmt = $this->db->prepare($sql);
$stmt->execute(['user_id' => $userId]);
```

### **XSS Prevention**
```php
// Always escape output
<?= htmlspecialchars($example['title']) ?>
<?= htmlspecialchars($example['description']) ?>
```

## 📊 **Performance Optimization**

### **Database Optimization**
```php
// Use indexes for frequently queried columns
CREATE INDEX idx_user_id ON feature_examples(user_id);
CREATE INDEX idx_status ON feature_examples(status);

// Limit query results
public function findByUserId($userId, $limit = 50) {
    $sql = "SELECT * FROM feature_examples WHERE user_id = :user_id LIMIT :limit";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
```

### **Caching Strategies**
```php
// Implement simple caching
class Cache {
    private static $cache = [];
    
    public static function get($key) {
        return self::$cache[$key] ?? null;
    }
    
    public static function set($key, $value, $ttl = 3600) {
        self::$cache[$key] = [
            'value' => $value,
            'expires' => time() + $ttl
        ];
    }
}
```

### **Asset Optimization**
```css
/* Minify CSS */
/* Use CSS variables for theming */
:root {
    --primary-color: #007bff;
    --secondary-color: #6c757d;
}

/* Optimize images */
/* Use WebP format when possible */
/* Implement lazy loading */
```

## 🚀 **Deployment**

### **Production Checklist**
- [ ] Set `DEBUG_MODE = false`
- [ ] Configure production database
- [ ] Set up SSL certificate
- [ ] Configure web server
- [ ] Set proper file permissions
- [ ] Enable error logging
- [ ] Configure backup system

### **Environment Configuration**
```php
// config.php
define('ENVIRONMENT', 'production');
define('DEBUG_MODE', false);
define('DB_HOST', 'production-db-host');
define('DB_NAME', 'production_db_name');
define('DB_USER', 'production_user');
define('DB_PASS', 'production_password');
```

### **Deployment Scripts**
```bash
#!/bin/bash
# deploy.sh

echo "Deploying IP Tools Suite..."

# Pull latest changes
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Clear cache
rm -rf cache/*

# Set permissions
chmod 755 logs/
chmod 644 app/Config/Database.php

echo "Deployment complete!"
```

## 🤝 **Contributing Guidelines**

### **Code Standards**
- **PSR-12**: Follow PSR-12 coding standards
- **PHPDoc**: Document all classes and methods
- **Naming**: Use descriptive names for variables and functions
- **Comments**: Add comments for complex logic

### **Git Workflow**
```bash
# Create feature branch
git checkout -b feature/new-feature

# Make changes and commit
git add .
git commit -m "Add new feature: description of changes"

# Push to remote
git push origin feature/new-feature

# Create pull request on GitHub
```

### **Commit Message Format**
```
type(scope): description

Examples:
feat(auth): add two-factor authentication
fix(geologger): resolve tracking link expiration issue
docs(api): update API documentation
style(theme): improve dark theme contrast
refactor(router): simplify route matching logic
test(auth): add authentication test coverage
```

### **Pull Request Process**
1. **Fork the repository**
2. **Create a feature branch**
3. **Make your changes**
4. **Add tests if applicable**
5. **Update documentation**
6. **Submit pull request**
7. **Address review comments**

## 📚 **Learning Resources**

### **PHP Resources**
- [PHP Official Documentation](https://www.php.net/docs.php)
- [PHP The Right Way](https://phptherightway.com/)
- [Composer Documentation](https://getcomposer.org/doc/)

### **Web Development**
- [MDN Web Docs](https://developer.mozilla.org/)
- [Bootstrap Documentation](https://getbootstrap.com/docs/)
- [JavaScript ES6+ Guide](https://es6-features.org/)

### **Database Design**
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Database Design Best Practices](https://www.databasejournal.com/)

### **Security**
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Guide](https://www.php.net/manual/en/security.php)

## 🆘 **Getting Help**

### **Development Support**
- **GitHub Issues**: [Report bugs and request features](https://github.com/your-username/ip-tools/issues)
- **GitHub Discussions**: [Ask questions and share ideas](https://github.com/your-username/ip-tools/discussions)
- **Documentation**: Check the docs folder for detailed guides

### **Community Resources**
- **Discord Server**: Join our developer community
- **Stack Overflow**: Tag questions with `ip-tools-suite`
- **Reddit**: Share projects and get feedback

---

**Thank you for contributing to IP Tools Suite! Your contributions help make this project better for everyone.**

*Happy coding! 🚀*
