<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Phone Tracker - IP Tools Suite</title>
    <link rel="icon" type="image/svg+xml" href="/projects/ip-tools/assets/favico.svg">
    <link rel="alternate icon" href="/projects/ip-tools/assets/favico.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
    <link href="assets/themes.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
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
            color: #ff6b6b;
        }
        
        .demo-section {
            background-color: #f8f9fa;
            padding: 60px 0;
        }
        
        .cta-section {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            padding: 60px 0;
        }
        
        .step-number {
            background: #ff6b6b;
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
                        <i class="fa-solid fa-mobile-screen-button me-3"></i>
                        Phone Tracker
                    </h1>
                    <p class="lead mb-4">
                        Rastreie a localização de dispositivos móveis através de SMS e análise de rede. 
                        Solução ideal para segurança empresarial e rastreamento de ativos.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="/projects/ip-tools/public/phone-tracker/send_sms" class="btn btn-light btn-lg">
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
                            <i class="fa-solid fa-mobile-screen fa-8x text-white"></i>
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
                    Recursos Avançados
                </h2>
                <p class="lead text-muted">
                    Tecnologia de rastreamento móvel de última geração
                </p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fa-solid fa-sms"></i>
                            </div>
                            <h4 class="card-title fw-bold">Rastreamento via SMS</h4>
                            <p class="card-text">
                                Envie links de rastreamento por SMS para capturar localização 
                                GPS precisa de dispositivos móveis.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fa-solid fa-network-wired"></i>
                            </div>
                            <h4 class="card-title fw-bold">Análise de Rede</h4>
                            <p class="card-text">
                                Capture informações detalhadas sobre a rede do usuário, 
                                incluindo IP, provedor e localização aproximada.
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
                            <h4 class="card-title fw-bold">Segurança Avançada</h4>
                            <p class="card-text">
                                Links de rastreamento seguros com criptografia e 
                                controle de acesso baseado em tempo.
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
                    Processo simples e eficiente
                </p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="step-number">1</div>
                        <div>
                            <h4 class="fw-bold">Configure o Rastreamento</h4>
                            <p class="text-muted">
                                Defina o número de telefone e mensagem personalizada. 
                                Configure opções de segurança e expiração.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="step-number">2</div>
                        <div>
                            <h4 class="fw-bold">Envie o SMS</h4>
                            <p class="text-muted">
                                O sistema envia automaticamente o SMS com link de rastreamento. 
                                O usuário recebe uma mensagem discreta.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="step-number">3</div>
                        <div>
                            <h4 class="fw-bold">Monitore em Tempo Real</h4>
                            <p class="text-muted">
                                Acompanhe a localização em tempo real através de mapas 
                                interativos e relatórios detalhados.
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
                    Aplicações práticas para diferentes necessidades
                </p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                            <i class="fa-solid fa-building fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Empresas</h5>
                        <p class="text-muted small">
                            Rastreamento de funcionários e ativos móveis
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                            <i class="fa-solid fa-car fa-2x text-success"></i>
                        </div>
                        <h5 class="fw-bold">Logística</h5>
                        <p class="text-muted small">
                            Monitoramento de entregas e rotas
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                            <i class="fa-solid fa-user-shield fa-2x text-warning"></i>
                        </div>
                        <h5 class="fw-bold">Segurança</h5>
                        <p class="text-muted small">
                            Proteção de pessoas e propriedades
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-info bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                            <i class="fa-solid fa-heart fa-2x text-info"></i>
                        </div>
                        <h5 class="fw-bold">Família</h5>
                        <p class="text-muted small">
                            Localização de familiares e crianças
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
                Experimente o Phone Tracker hoje mesmo e descubra o poder 
                do rastreamento móvel profissional.
            </p>
            <div class="d-flex gap-3 justify-content-center">
                <a href="/projects/ip-tools/public/phone-tracker/send_sms" class="btn btn-light btn-lg">
                    <i class="fa-solid fa-play me-2"></i>
                    Enviar Primeiro SMS
                </a>
                <a href="/projects/ip-tools/" class="btn btn-outline-light btn-lg">
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
