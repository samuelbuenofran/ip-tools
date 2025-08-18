<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>IP Tools Suite - Professional IP Intelligence Tools</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Professional-grade tools for geolocation tracking, network analysis, and digital forensics. Built for developers, security professionals, and businesses.">
  <link rel="icon" type="image/svg+xml" href="/projects/ip-tools/assets/favico.svg">
  <link rel="alternate icon" href="/projects/ip-tools/assets/favico.svg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    .hero-section {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 80px 0;
      margin-top: -20px;
    }
    
    .feature-card {
      transition: all 0.3s ease;
      border: none;
      border-radius: 15px;
    }
    
    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    
    .icon-large {
      font-size: 3rem;
      color: #007bff;
      margin-bottom: 1.5rem;
    }
    
    .cta-section {
      background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
      color: white;
      border-radius: 20px;
    }
    
    .btn-custom {
      border-radius: 50px;
      padding: 12px 30px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    
    .navbar {
      background: rgba(255, 255, 255, 0.95) !important;
      backdrop-filter: blur(10px);
    }
    
    .navbar-brand {
      color: #007bff !important;
      font-weight: 700;
    }
    
    .nav-link {
      color: #333 !important;
      font-weight: 500;
    }
    
    .nav-link:hover {
      color: #007bff !important;
    }
  </style>
</head>
<body>
  <?php include('header.php'); ?>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h1 class="display-3 fw-bold mb-4">
            <i class="fa-solid fa-toolbox me-3"></i>IP Tools Suite
          </h1>
          <p class="lead mb-4 fs-5">
            Professional-grade tools for geolocation tracking, network analysis, and digital forensics. 
            Built for developers, security professionals, and businesses who need reliable IP intelligence.
          </p>
          <div class="d-grid gap-3 d-md-flex">
            <a href="/projects/ip-tools/public/auth/login" class="btn btn-light btn-custom btn-lg px-5 me-md-3">
              <i class="fa-solid fa-sign-in-alt me-2"></i>Login to Dashboard
            </a>
            <a href="#features" class="btn btn-outline-light btn-custom btn-lg px-5">
              <i class="fa-solid fa-info-circle me-2"></i>Learn More
            </a>
          </div>
        </div>
        <div class="col-lg-6 text-center">
          <img src="/projects/ip-tools/assets/iptoolssuite-logo.png" alt="IP Tools Suite" class="img-fluid" style="max-width: 400px; filter: brightness(1.1);">
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="py-5 bg-light">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="display-5 fw-bold text-primary mb-3">
          <i class="fa-solid fa-star text-warning me-3"></i>
          Powerful Features for Modern Businesses
        </h2>
        <p class="lead text-muted">Everything you need for comprehensive IP intelligence and network analysis</p>
      </div>
      
      <div class="row g-4">
        <div class="col-md-6 col-lg-4">
          <div class="card feature-card h-100 shadow-sm">
            <div class="card-body text-center p-4">
              <div class="icon-large">
                <i class="fa-solid fa-map-pin"></i>
              </div>
              <h5 class="card-title fw-bold">Geolocation Tracker</h5>
              <p class="card-text text-muted">
                Create location-aware tracking links that capture visitor IP addresses, 
                geographic locations, and device information with pinpoint accuracy.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card feature-card h-100 shadow-sm">
            <div class="card-body text-center p-4">
              <div class="icon-large">
                <i class="fa-solid fa-chart-line"></i>
              </div>
              <h5 class="card-title fw-bold">Advanced Analytics</h5>
              <p class="card-text text-muted">
                Visualize your data with interactive heatmaps, detailed logs, 
                and comprehensive reports to understand your audience better.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card feature-card h-100 shadow-sm">
            <div class="card-body text-center p-4">
              <div class="icon-large">
                <i class="fa-solid fa-mobile-screen-button"></i>
              </div>
              <h5 class="card-title fw-bold">SMS Tracking</h5>
              <p class="card-text text-muted">
                Send trackable SMS links and monitor engagement across mobile devices 
                with detailed click analytics and location data.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card feature-card h-100 shadow-sm">
            <div class="card-body text-center p-4">
              <div class="icon-large">
                <i class="fa-solid fa-globe"></i>
              </div>
              <h5 class="card-title fw-bold">IP Intelligence</h5>
              <p class="card-text text-muted">
                Get instant insights into any IP address including location, 
                ISP details, and network information for security analysis.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card feature-card h-100 shadow-sm">
            <div class="card-body text-center p-4">
              <div class="icon-large">
                <i class="fa-solid fa-gauge-high"></i>
              </div>
              <h5 class="card-title fw-bold">Network Diagnostics</h5>
              <p class="card-text text-muted">
                Comprehensive speed testing, ping analysis, and network 
                performance monitoring tools for IT professionals.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card feature-card h-100 shadow-sm">
            <div class="card-body text-center p-4">
              <div class="icon-large">
                <i class="fa-solid fa-shield-halved"></i>
              </div>
              <h5 class="card-title fw-bold">Security Tools</h5>
              <p class="card-text text-muted">
                Professional-grade security utilities including mock data generators 
                and testing tools for development and security research.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action -->
  <section class="py-5">
    <div class="container">
      <div class="cta-section text-center p-5">
        <h3 class="display-6 fw-bold mb-3">Ready to Get Started?</h3>
        <p class="lead mb-4">
          Join thousands of professionals who trust IP Tools Suite for their 
          geolocation tracking and network analysis needs.
        </p>
        <a href="/projects/ip-tools/public/auth/login" class="btn btn-light btn-custom btn-lg px-5">
          <i class="fa-solid fa-rocket me-2"></i>Access Dashboard Now
        </a>
      </div>
    </div>
  </section>

  <?php include('footer.php'); ?>
  
  <script>
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });
  </script>
</body>
</html>
