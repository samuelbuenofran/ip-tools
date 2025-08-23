<?php 
require_once('config.php');

// Language setting - Portuguese by default, English only in dev mode
$current_lang = 'pt';
if ($DEV_MODE && $DEV_LANGUAGE === 'en') {
    $current_lang = $_GET['lang'];
}

// Allow language switching in dev mode via URL parameter
if ($DEV_MODE && isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'pt'])) {
    $current_lang = $_GET['lang'];
}

// Page-specific variables for the layout
$page_title = 'IP Tools Suite - Professional IP Intelligence Tools';
$page_description = 'Professional-grade tools for geolocation tracking, network analysis, and digital forensics. Built for developers, security professionals, and businesses.';

// Page-specific CSS
$page_css = '
<style>
  .hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 80px 0;
    margin-top: -20px;
  }
  
  .feature-card {
    transition: box-shadow 0.2s ease;
    border: none;
    border-radius: 15px;
  }
  
  .feature-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    border-color: #007bff;
  }
  
  .feature-card:hover .icon-large {
    color: #007bff;
  }
  
  .icon-large {
    font-size: 3rem;
    color: #007bff;
    margin-bottom: 1.5rem;
    transition: color 0.2s ease;
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
</style>
';

// Start output buffering to capture content
ob_start();
?>

  <!-- Developer Language Switcher (only visible in dev mode) -->
  <?php if ($DEV_MODE): ?>
  <div class="container mt-3">
    <div class="alert alert-info text-center">
      <i class="fa-solid fa-code me-2"></i>
      <strong>Modo Desenvolvedor Ativo</strong> - Idioma Atual: <span class="badge bg-primary"><?= strtoupper($current_lang) ?></span>
      <?php if ($current_lang === 'pt'): ?>
        <a href="?lang=en" class="btn btn-sm btn-outline-primary ms-2">Mudar para Inglês</a>
      <?php else: ?>
        <a href="?btn btn-sm btn-outline-primary ms-2">Mudar para Português</a>
      <?php endif; ?>
    </div>
  </div>
  <?php endif; ?>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h1 class="display-3 fw-bold mb-4">
            <i class="fa-solid fa-toolbox me-3"></i>IP Tools Suite
          </h1>
          <p class="lead mb-4 fs-5">
            Ferramentas profissionais para rastreamento de geolocalização, análise de rede e forense digital. 
            Construído para desenvolvedores, profissionais de segurança e empresas que precisam de inteligência IP confiável.
          </p>
          <div class="d-grid gap-3 d-md-flex">
            <a href="/projects/ip-tools/public/auth/login" class="btn btn-light btn-custom btn-lg px-5 me-md-3">
              <i class="fa-solid fa-sign-in-alt me-2"></i>Entrar no Painel
            </a>
            <a href="#features" class="btn btn-outline-light btn-custom btn-lg px-5">
              <i class="fa-solid fa-info-circle me-2"></i>Saiba Mais
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
          Recursos Poderosos para Empresas Modernas
        </h2>
        <p class="lead text-muted">Tudo que você precisa para inteligência IP abrangente e análise de rede</p>
      </div>
      
      <div class="row g-4">
        <div class="col-md-6 col-lg-4">
          <div class="card feature-card h-100 shadow-sm" style="cursor: pointer;" onclick="window.location.href='/projects/ip-tools/geolocation-tracker-info.php'">
            <div class="card-body text-center p-4">
              <div class="icon-large">
                <i class="fa-solid fa-map-pin"></i>
              </div>
              <h5 class="card-title fw-bold">Rastreador de Geolocalização</h5>
              <p class="card-text text-muted">
                Crie links de rastreamento com consciência de localização que capturam endereços IP dos visitantes, 
                localizações geográficas e informações do dispositivo com precisão milimétrica.
              </p>
              <div class="mt-3">
                <span class="badge bg-primary">Clique para saber mais</span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card feature-card h-100 shadow-sm" style="cursor: pointer;" onclick="window.location.href='/projects/ip-tools/logs-dashboard-info.php'">
            <div class="card-body text-center p-4">
              <div class="icon-large">
                <i class="fa-solid fa-chart-line"></i>
              </div>
              <h5 class="card-title fw-bold">Análises Avançadas</h5>
              <p class="card-text text-muted">
                Visualize seus dados com mapas de calor interativos, logs detalhados 
                e relatórios abrangentes para entender melhor seu público.
              </p>
              <div class="mt-3">
                <span class="badge bg-primary">Clique para saber mais</span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card feature-card h-100 shadow-sm" style="cursor: pointer;" onclick="window.location.href='/projects/ip-tools/phone-tracker-info.php'">
            <div class="card-body text-center p-4">
              <div class="icon-large">
                <i class="fa-solid fa-mobile-screen-button"></i>
              </div>
              <h5 class="card-title fw-bold">Rastreamento SMS</h5>
              <p class="card-text text-muted">
                Envie links SMS rastreáveis e monitore o engajamento em dispositivos móveis 
                com análises detalhadas de cliques e dados de localização.
              </p>
              <div class="mt-3">
                <span class="badge bg-primary">Clique para saber mais</span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card feature-card h-100 shadow-sm">
            <div class="card-body text-center p-4">
              <div class="icon-large">
                <i class="fa-solid fa-globe"></i>
              </div>
              <h5 class="card-title fw-bold">Inteligência IP</h5>
              <p class="card-text text-muted">
                Obtenha insights instantâneos sobre qualquer endereço IP, incluindo localização, 
                detalhes do ISP e informações de rede para análise de segurança.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card feature-card h-100 shadow-sm" style="cursor: pointer;" onclick="window.location.href='/projects/ip-tools/speed-test-info.php'">
            <div class="card-body text-center p-4">
              <div class="icon-large">
                <i class="fa-solid fa-gauge-high"></i>
              </div>
              <h5 class="card-title fw-bold">Diagnósticos de Rede</h5>
              <p class="card-text text-muted">
                Ferramentas abrangentes de teste de velocidade, análise de ping 
                e monitoramento de desempenho de rede para profissionais de TI.
              </p>
              <div class="mt-3">
                <span class="badge bg-primary">Clique para saber mais</span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card feature-card h-100 shadow-sm">
            <div class="card-body text-center p-4">
              <div class="icon-large">
                <i class="fa-solid fa-shield-halved"></i>
              </div>
              <h5 class="card-title fw-bold">Ferramentas de Segurança</h5>
              <p class="card-text text-muted">
                Utilitários de segurança de nível profissional, incluindo geradores de dados simulados 
                e ferramentas de teste para desenvolvimento e pesquisa de segurança.
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
        <h3 class="display-6 fw-bold mb-3">Pronto para Começar?</h3>
        <p class="lead mb-4">
          Junte-se a milhares de profissionais que confiam no IP Tools Suite para suas 
          necessidades de rastreamento de geolocalização e análise de rede.
        </p>
        <a href="/projects/ip-tools/public/auth/login" class="btn btn-light btn-custom btn-lg px-5">
          <i class="fa-solid fa-rocket me-2"></i>Acessar Painel Agora
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

<?php
// Get the buffered content
$content = ob_get_clean();

// Include the unified layout
include('app/Views/layouts/main.php');
?>
