<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logs Dashboard - IP Tools Suite</title>
    <link rel="icon" type="image/svg+xml" href="/projects/ip-tools/assets/favico.svg">
    <link rel="alternate icon" href="/projects/ip-tools/assets/favico.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
    <link href="assets/themes.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #9c27b0 0%, #673ab7 100%);
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
            color: #9c27b0;
        }
        
        .demo-section {
            background-color: #f8f9fa;
            padding: 60px 0;
        }
        
        .cta-section {
            background: linear-gradient(135deg, #9c27b0 0%, #673ab7 100%);
            color: white;
            padding: 60px 0;
        }
        
        .step-number {
            background: #9c27b0;
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
        
        .dashboard-preview {
            background: linear-gradient(45deg, #f8f9fa 25%, transparent 25%), 
                        linear-gradient(-45deg, #f8f9fa 25%, transparent 25%), 
                        linear-gradient(45deg, transparent 75%, #f8f9fa 75%), 
                        linear-gradient(-45deg, transparent 75%, #f8f9fa 75%);
            background-size: 20px 20px;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
            border-radius: 15px;
            padding: 30px;
            border: 2px solid #e9ecef;
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
                        <i class="fa-solid fa-chart-line me-3"></i>
                        Logs Dashboard
                    </h1>
                    <p class="lead mb-4">
                        Visualize e analise todos os dados de rastreamento em um painel centralizado. 
                        Mapas de calor interativos, estatísticas detalhadas e relatórios em tempo real.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="/projects/ip-tools/public/geologger/logs" class="btn btn-light btn-lg">
                            <i class="fa-solid fa-rocket me-2"></i>
                            Acessar Dashboard
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
                            <i class="fa-solid fa-chart-area fa-8x text-white"></i>
                        </div>
                        <div class="position-absolute top-0 start-100 translate-middle">
                            <div class="bg-success rounded-circle p-2">
                                <i class="fa-solid fa-chart-line fa-2x text-white"></i>
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
                    Dashboard completo para análise de dados de rastreamento
                </p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fa-solid fa-map-location-dot"></i>
                            </div>
                            <h4 class="card-title fw-bold">Mapas de Calor</h4>
                            <p class="card-text">
                                Visualize a distribuição geográfica dos visitantes com mapas de calor 
                                interativos e personalizáveis.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fa-solid fa-chart-pie"></i>
                            </div>
                            <h4 class="card-title fw-bold">Estatísticas Detalhadas</h4>
                            <p class="card-text">
                                Análise completa de cliques, visitantes únicos, dispositivos 
                                e padrões de comportamento.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <h4 class="card-title fw-bold">Tempo Real</h4>
                            <p class="card-text">
                                Monitore atividades em tempo real com atualizações automáticas 
                                e notificações instantâneas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Preview Section -->
    <section class="demo-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-primary">
                    <i class="fa-solid fa-eye me-3"></i>
                    Visualização do Dashboard
                </h2>
                <p class="lead text-muted">
                    Veja como seus dados serão apresentados
                </p>
            </div>
            
            <div class="dashboard-preview">
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="text-center p-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block mb-2">
                                <i class="fa-solid fa-mouse-pointer fa-2x text-primary"></i>
                            </div>
                            <h5 class="fw-bold">Total de Cliques</h5>
                            <h3 class="text-primary">1,247</h3>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="text-center p-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3 d-inline-block mb-2">
                                <i class="fa-solid fa-users fa-2x text-success"></i>
                            </div>
                            <h5 class="fw-bold">Visitantes Únicos</h5>
                            <h3 class="text-success">892</h3>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="text-center p-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3 d-inline-block mb-2">
                                <i class="fa-solid fa-mobile-alt fa-2x text-warning"></i>
                            </div>
                            <h5 class="fw-bold">Dispositivos Móveis</h5>
                            <h3 class="text-warning">67%</h3>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="text-center p-3">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3 d-inline-block mb-2">
                                <i class="fa-solid fa-globe fa-2x text-info"></i>
                            </div>
                            <h5 class="fw-bold">Países</h5>
                            <h3 class="text-info">24</h3>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <div class="bg-light rounded p-4">
                        <i class="fa-solid fa-map-marked-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Mapa de Calor Interativo</h5>
                        <p class="text-muted mb-0">Visualize a distribuição geográfica dos seus visitantes</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-5">
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
                            <h4 class="fw-bold">Coleta de Dados</h4>
                            <p class="text-muted">
                                O sistema coleta automaticamente dados de todos os links 
                                de rastreamento criados.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="step-number">2</div>
                        <div>
                            <h4 class="fw-bold">Processamento</h4>
                            <p class="text-muted">
                                Os dados são processados e organizados em categorias 
                                para fácil análise.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="step-number">3</div>
                        <div>
                            <h4 class="fw-bold">Visualização</h4>
                            <p class="text-muted">
                                Acesse o dashboard para visualizar estatísticas, 
                                mapas e relatórios detalhados.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Use Cases Section -->
    <section class="py-5 bg-light">
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
                            <i class="fa-solid fa-bullseye fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Marketing</h5>
                        <p class="text-muted small">
                            Analise o desempenho de campanhas por região
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                            <i class="fa-solid fa-chart-bar fa-2x text-success"></i>
                        </div>
                        <h5 class="fw-bold">Analytics</h5>
                        <p class="text-muted small">
                            Compreenda o comportamento dos usuários
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
                            Detecte atividades suspeitas e padrões anômalos
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-info bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                            <i class="fa-solid fa-building fa-2x text-info"></i>
                        </div>
                        <h5 class="fw-bold">Negócios</h5>
                        <p class="text-muted small">
                            Tome decisões baseadas em dados reais
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
                Pronto para Analisar?
            </h2>
            <p class="lead mb-4">
                Acesse o Logs Dashboard hoje mesmo e descubra insights valiosos 
                sobre seus visitantes e campanhas.
            </p>
            <div class="d-flex gap-3 justify-content-center">
                <a href="/projects/ip-tools/public/geologger/logs" class="btn btn-light btn-lg">
                    <i class="fa-solid fa-chart-line me-2"></i>
                    Acessar Dashboard
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
