<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Geolocation Tracker - IP Tools Suite</title>
    <link rel="icon" type="image/svg+xml" href="/projects/ip-tools/assets/favico.svg">
    <link rel="alternate icon" href="/projects/ip-tools/assets/favico.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
    <link href="assets/themes.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
        }
        
        .feature-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: box-shadow 0.2s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #667eea;
        }
        
        .demo-section {
            background-color: #f8f9fa;
            padding: 60px 0;
        }
        
        .cta-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
        }
        
        .step-number {
            background: #667eea;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 1rem;
            font-size: 0.9rem;
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
                    <h1 class="display-4 fw-bold mb-4">
                        <i class="fa-solid fa-map-pin me-3"></i>
                        Geolocation Tracker
                    </h1>
                    <p class="lead mb-4">
                        Rastreie a localização geográfica de visitantes com precisão GPS e análise IP avançada. 
                        Ideal para marketing, segurança e análise de dados de usuários.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="/projects/ip-tools/public/geologger/create" class="btn btn-light btn-lg">
                            <i class="fa-solid fa-rocket me-2"></i>
                            Testar Agora
                        </a>
                        <a href="#features" class="btn btn-outline-light btn-lg">
                            <i class="fa-solid fa-info-circle me-2"></i>
                            Saiba Mais
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="position-relative">
                        <div class="bg-white bg-opacity-20 rounded-circle p-5 d-inline-block">
                            <i class="fa-solid fa-globe fa-8x text-white"></i>
                        </div>
                        <div class="position-absolute top-0 start-100 translate-middle">
                            <div class="bg-success rounded-circle p-2">
                                <i class="fa-solid fa-location-dot fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-primary mb-3">
                    <i class="fa-solid fa-star text-warning me-3"></i>
                    Recursos Poderosos
                </h2>
                <p class="lead text-muted">
                    Tudo que você precisa para rastreamento geográfico profissional
                </p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fa-solid fa-map-marker-alt"></i>
                            </div>
                            <h4 class="card-title fw-bold">Rastreamento GPS Preciso</h4>
                            <p class="card-text">
                                Capture coordenadas GPS exatas com precisão de metros. 
                                Ideal para aplicações que precisam de localização precisa.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <h4 class="card-title fw-bold">Análise de Dados Avançada</h4>
                            <p class="card-text">
                                Visualize dados em mapas de calor, analise padrões de visitação 
                                e gere relatórios detalhados de localização.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <h4 class="card-title fw-bold">Privacidade e Segurança</h4>
                            <p class="card-text">
                                Links de rastreamento seguros com expiração automática. 
                                Controle total sobre dados coletados.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="demo-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-primary">
                    <i class="fa-solid fa-cogs me-3"></i>
                    Como Funciona
                </h2>
                <p class="lead text-muted">
                    Processo simples em apenas 3 passos
                </p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="step-number">1</div>
                        <div>
                            <h4 class="fw-bold">Crie o Link</h4>
                            <p class="text-muted">
                                Gere um link de rastreamento único para qualquer URL. 
                                Personalize expiração e limites de cliques.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="step-number">2</div>
                        <div>
                            <h4 class="fw-bold">Compartilhe</h4>
                            <p class="text-muted">
                                Envie o link por email, SMS ou redes sociais. 
                                O link é discreto e não revela o rastreamento.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="step-number">3</div>
                        <div>
                            <h4 class="fw-bold">Analise</h4>
                            <p class="text-muted">
                                Visualize dados em tempo real: localização, dispositivo, 
                                referrer e muito mais em mapas interativos.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Use Cases Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-primary">
                    <i class="fa-solid fa-lightbulb me-3"></i>
                    Casos de Uso
                </h2>
                <p class="lead text-muted">
                    Aplicações práticas para diferentes setores
                </p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                            <i class="fa-solid fa-store fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">E-commerce</h5>
                        <p class="text-muted small">
                            Analise padrões de compra por região geográfica
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                            <i class="fa-solid fa-chart-pie fa-2x text-success"></i>
                        </div>
                        <h5 class="fw-bold">Marketing</h5>
                        <p class="text-muted small">
                            Campanhas direcionadas por localização
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                            <i class="fa-solid fa-shield-alt fa-2x text-warning"></i>
                        </div>
                        <h5 class="fw-bold">Segurança</h5>
                        <p class="text-muted small">
                            Detecção de atividades suspeitas por localização
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-info bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                            <i class="fa-solid fa-users fa-2x text-info"></i>
                        </div>
                        <h5 class="fw-bold">Analytics</h5>
                        <p class="text-muted small">
                            Compreensão do comportamento do usuário
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center">
            <h2 class="display-5 fw-bold mb-4">
                <i class="fa-solid fa-rocket me-3"></i>
                Pronto para Começar?
            </h2>
            <p class="lead mb-4">
                Experimente o Geolocation Tracker hoje mesmo e descubra o poder 
                do rastreamento geográfico profissional.
            </p>
            <div class="d-flex gap-3 justify-content-center">
                <a href="/projects/ip-tools/public/geologger/create" class="btn btn-light btn-lg">
                    <i class="fa-solid fa-play me-2"></i>
                    Criar Primeiro Link
                </a>
                <a href="/projects/ip-tools/public/" class="btn btn-outline-light btn-lg">
                    <i class="fa-solid fa-arrow-left me-2"></i>
                    Voltar ao Início
                </a>
            </div>
        </div>
    </section>

    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/theme-switcher.js"></script>
</body>
</html>
