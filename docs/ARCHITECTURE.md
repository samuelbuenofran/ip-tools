# IP Tools Suite - Technical Architecture Documentation

## 🏗️ **System Architecture Overview**

IP Tools Suite is built using a modern, scalable MVC (Model-View-Controller) architecture that provides clean separation of concerns, maintainable code structure, and enterprise-grade security.

```
┌─────────────────────────────────────────────────────────────┐
│                    Web Server Layer                        │
│              (Apache/Nginx + .htaccess)                    │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│                   Entry Point Layer                        │
│                public/index.php                            │
│              (Application Bootstrap)                       │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│                    Router Layer                            │
│              App\Core\Router                               │
│           (URL Processing & Dispatch)                     │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│                  Controller Layer                          │
│            App\Controllers\*Controller                     │
│           (Business Logic & Request Handling)              │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│                    Model Layer                             │
│              App\Models\*Model                             │
│           (Data Access & Business Rules)                   │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│                   Database Layer                           │
│              MySQL Database                                │
│           (Data Storage & Retrieval)                       │
└─────────────────────────────────────────────────────────────┘
```

## 🚀 **Application Entry Point**

### **Primary Entry Point: `public/index.php`**

The main application entry point is located at `public/index.php`. This file serves as the bootstrap for the entire application and handles:

1. **Session Initialization** - Starts PHP sessions and sets security parameters
2. **Class Loading** - Includes all necessary PHP classes and dependencies
3. **Application Configuration** - Initializes the App class with settings
4. **Router Setup** - Creates and configures the URL router
5. **Route Definition** - Defines all application routes and their handlers
6. **Request Dispatch** - Processes incoming requests and routes them appropriately

```php
<?php
// Entry point: public/index.php

// 1. Start output buffering
ob_start();

// 2. Load all required classes
require_once __DIR__ . '/../app/Config/App.php';
require_once __DIR__ . '/../app/Config/Database.php';
require_once __DIR__ . '/../app/Core/Router.php';
// ... more includes

// 3. Initialize application
App::init();

// 4. Create router and define routes
$router = new Router();
$router->add('', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('dashboard', ['controller' => 'DashboardController', 'action' => 'index']);
// ... more routes

// 5. Process the request
$url = $_SERVER['REQUEST_URI'] ?? '';
$router->dispatch($url);
```

### **URL Processing Flow**

```
User Request → Web Server → .htaccess → index.php → Router → Controller → Model → View → Response
```

1. **User makes request** to any URL (e.g., `/dashboard`)
2. **Web server** receives request and processes `.htaccess` rules
3. **`.htaccess`** redirects all requests to `public/index.php`
4. **`index.php`** processes the URL and creates the router
5. **Router** matches the URL to defined routes
6. **Controller** is instantiated and method is called
7. **Model** processes data and business logic
8. **View** renders the response
9. **Response** is sent back to the user

## 🔧 **Core Framework Components**

### **1. Router (`App\Core\Router`)**

The router is responsible for:
- **URL Matching** - Converting URLs to controller/action pairs
- **Route Definition** - Managing application routes
- **Request Dispatch** - Directing requests to appropriate controllers
- **Authentication Checks** - Verifying user permissions before routing

```php
class Router {
    private $routes = [];
    
    public function add($route, $params = []) {
        // Convert route to regex pattern
        $route = preg_replace('/\//', '\\/', $route);
        $this->routes[$route] = $params;
    }
    
    public function dispatch($url) {
        // Check authentication first
        $this->checkAuthentication($url);
        
        // Match route and execute controller
        if ($this->match($url)) {
            $controller = new $this->params['controller']($this->params);
            $action = $this->params['action'];
            return $controller->$action();
        }
    }
}
```

### **2. Controller Base (`App\Core\Controller`)**

All controllers extend this base class, which provides:
- **Common Methods** - Shared functionality across controllers
- **Security Features** - CSRF validation, input sanitization
- **Authentication Helpers** - Login checks and role verification
- **Response Methods** - Rendering views and redirects

```php
abstract class Controller {
    protected $params;
    protected $db;
    protected $view;
    
    public function __construct($params = []) {
        $this->params = $params;
        $this->db = Database::getInstance();
        $this->view = new View();
    }
    
    protected function render($view, $data = []) {
        return $this->view->render($view, $data);
    }
    
    protected function requireLogin() {
        \App\Core\AuthMiddleware::requireAuth();
    }
}
```

### **3. View System (`App\Core\View`)**

The view system handles:
- **Template Rendering** - Converting PHP templates to HTML
- **Layout Management** - Applying consistent page layouts
- **Data Injection** - Making controller data available in views
- **Asset Management** - Handling CSS, JS, and image URLs

```php
class View {
    private $layout = 'default';
    private $viewPath = __DIR__ . '/../Views/';
    
    public function render($viewName, $data = []) {
        // Extract data to variables
        extract($data);
        
        // Make view object available
        $view = $this;
        
        // Capture view output
        ob_start();
        include $this->viewPath . $viewName . '.php';
        $content = ob_get_clean();
        
        // Apply layout
        if ($this->layout) {
            include $this->viewPath . 'layouts/' . $this->layout . '.php';
        }
    }
}
```

## 🔐 **Authentication & Security Architecture**

### **Authentication Middleware (`App\Core\AuthMiddleware`)**

The authentication system provides:
- **Route Protection** - Automatic authentication checks for protected routes
- **Role-based Access Control** - Different permission levels for users
- **Session Management** - Secure session handling and validation
- **CSRF Protection** - Cross-site request forgery prevention

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

### **Security Features**

- **CSRF Tokens** - Every form includes a unique token
- **Input Sanitization** - All user input is cleaned and validated
- **SQL Injection Prevention** - Prepared statements and parameterized queries
- **XSS Protection** - Output encoding and sanitization
- **Session Security** - Secure session management with configurable timeouts

## 🗄️ **Database Architecture**

### **Database Connection (`App\Config\Database`)**

The database layer provides:
- **Singleton Pattern** - Single database connection instance
- **PDO Interface** - Modern database abstraction
- **Connection Pooling** - Efficient connection management
- **Error Handling** - Graceful database error management

```php
class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        $this->connection = new PDO(
            "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
            $this->username,
            $this->password,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
```

### **Model Architecture**

Models provide:
- **Data Abstraction** - Clean interface to database tables
- **Business Logic** - Data validation and processing rules
- **Query Building** - Structured database queries
- **Relationship Management** - Handling data relationships

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
}
```

## 🌐 **Frontend Architecture**

### **Theme System**

The application includes a sophisticated theme system:
- **CSS Variables** - Dynamic theme switching
- **Multiple Themes** - Light, Dark, Dim, macOS Aqua, Liquid Glass
- **Responsive Design** - Mobile-first approach
- **Accessibility** - High contrast and readable fonts

### **JavaScript Architecture**

- **Modular Design** - Organized JavaScript modules
- **Theme Switcher** - Dynamic theme management
- **Form Validation** - Client-side input validation
- **AJAX Support** - Asynchronous data loading

## 📱 **Mobile & Responsive Design**

### **Responsive Breakpoints**

- **Mobile First** - Design starts with mobile devices
- **Tablet Support** - Optimized for medium screens
- **Desktop Experience** - Full-featured desktop interface
- **Touch Friendly** - Optimized for touch devices

### **Performance Optimization**

- **Asset Minification** - Compressed CSS and JavaScript
- **Image Optimization** - Optimized images and icons
- **Caching Strategy** - Browser and server-side caching
- **Lazy Loading** - Load resources as needed

## 🔧 **Configuration Management**

### **Environment Configuration**

The application uses a centralized configuration system:
- **App Settings** - Application-wide configuration
- **Database Config** - Database connection parameters
- **Security Settings** - Security and authentication parameters
- **Feature Flags** - Enable/disable specific features

```php
class App {
    const APP_NAME = 'IP Tools Suite';
    const DEBUG_MODE = false;
    const SESSION_LIFETIME = 3600;
    const GOOGLE_MAPS_API_KEY = 'your_api_key';
    
    public static function init() {
        // Initialize application settings
        session_name(self::SESSION_NAME);
        session_set_cookie_params(self::SESSION_LIFETIME);
        session_start();
        
        // Set error reporting based on mode
        if (self::DEBUG_MODE) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }
    }
}
```

## 🚀 **Deployment Architecture**

### **Production Deployment**

- **Web Server** - Apache/Nginx with optimized configuration
- **PHP Configuration** - Production-ready PHP settings
- **Database** - Optimized MySQL configuration
- **SSL/TLS** - Secure HTTPS connections
- **CDN Integration** - Content delivery network for assets

### **Development Environment**

- **Local Development** - Easy local setup with Docker
- **Debug Mode** - Comprehensive error reporting
- **Hot Reloading** - Automatic page refresh during development
- **Database Seeding** - Sample data for development

## 📊 **Monitoring & Logging**

### **Application Logging**

- **Error Logging** - Comprehensive error tracking
- **Access Logging** - User activity monitoring
- **Performance Logging** - Response time and resource usage
- **Security Logging** - Authentication and authorization events

### **Performance Monitoring**

- **Response Time Tracking** - Monitor page load times
- **Database Query Monitoring** - Track slow queries
- **Memory Usage** - Monitor memory consumption
- **Error Rate Monitoring** - Track application errors

## 🔮 **Future Architecture Considerations**

### **Scalability Planning**

- **Load Balancing** - Multiple server support
- **Database Sharding** - Horizontal database scaling
- **Microservices** - Breaking into smaller services
- **API-First Design** - RESTful API architecture

### **Technology Evolution**

- **PHP 8+ Support** - Modern PHP features
- **Modern Frontend** - React/Vue.js integration
- **Containerization** - Docker deployment
- **Cloud Native** - Cloud platform optimization

---

**This architecture provides a solid foundation for building scalable, maintainable, and secure web applications while maintaining flexibility for future enhancements.**
