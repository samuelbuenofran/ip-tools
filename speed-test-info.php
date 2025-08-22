<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Speed Test - IP Tools Suite</title>
    <link rel="icon" type="image/svg+xml" href="/projects/ip-tools/assets/favico.svg">
    <link rel="alternate icon" href="/projects/ip-tools/assets/favico.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
    <link href="assets/themes.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #20bf6b 0%, #0fb9b1 100%);
            color: white;
            padding: 80px 0;
        }
        
        .feature-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #20bf6b;
        }
        
        .demo-section {
            background-color: #f8f9fa;
            padding: 60px 0;
        }
        
        .cta-section {
            background: linear-gradient(135deg, #20bf6b 0%, #0fb9b1 100%);
            color: white;
            padding: 60px 0;
        }
        
        .step-number {
            background: #20bf6b;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 1rem;
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
                        <i class="fa-solid fa-gauge-high me-3"></i>
                        Speed Test
                    </h1>
                    <p class="lead mb-4">
                        Teste a velocidade da sua conexão de internet com precisão profissional. 
                        Análise detalhada de download, upload, ping e jitter para otimização de rede.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="/projects/ip-tools/public/speed-test" class="btn btn-light btn-lg">
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
                            <i class="fa-solid fa-tachometer-alt fa-8x text-white"></i>
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
                    Teste de velocidade profissional com análise completa
                </p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fa-solid fa-download"></i>
                            </div>
                            <h4 class="card-title fw-bold">Teste de Download</h4>
                            <p class="card-text">
                                Medição precisa da velocidade de download com múltiplos 
                                servidores para resultados confiáveis.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fa-solid fa-upload"></i>
                            </div>
                            <h4 class="card-title fw-bold">Teste de Upload</h4>
                            <p class="card-text">
                                Avalie a velocidade de upload para streaming, 
                                videoconferência e compartilhamento de arquivos.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fa-solid fa-signal"></i>
                            </div>
                            <h4 class="card-title fw-bold">Análise de Latência</h4>
                            <p class="card-text">
                                Medição de ping e jitter para jogos online, 
                                VoIP e aplicações sensíveis à latência.
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
                    Processo simples e preciso
                </p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="step-number">1</div>
                        <div>
                            <h4 class="fw-bold">Inicie o Teste</h4>
                            <p class="text-muted">
                                Clique em "Iniciar Teste" para começar a medição 
                                automática da sua conexão de internet.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="step-number">2</div>
                        <div>
                            <h4 class="fw-bold">Medição Automática</h4>
                            <p class="text-muted">
                                O sistema testa download, upload, ping e jitter 
                                automaticamente em poucos segundos.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="step-number">3</div>
                        <div>
                            <h4 class="fw-bold">Resultados Detalhados</h4>
                            <p class="text-muted">
                                Visualize resultados completos com gráficos, 
                                histórico e recomendações de otimização.
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
                            <i class="fa-solid fa-home fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Usuários Domésticos</h5>
                        <p class="text-muted small">
                            Verificar qualidade da conexão residencial
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                            <i class="fa-solid fa-building fa-2x text-success"></i>
                        </div>
                        <h5 class="fw-bold">Empresas</h5>
                        <p class="text-muted small">
                            Monitoramento de infraestrutura de rede
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                            <i class="fa-solid fa-gamepad fa-2x text-warning"></i>
                        </div>
                        <h5 class="fw-bold">Gamers</h5>
                        <p class="text-muted small">
                            Otimização para jogos online
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-info bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                            <i class="fa-solid fa-video fa-2x text-info"></i>
                        </div>
                        <h5 class="fw-bold">Streaming</h5>
                        <p class="text-muted small">
                            Qualidade para videoconferência e streaming
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
                Pronto para Testar?
            </h2>
            <p class="lead mb-4">
                Experimente o Speed Test hoje mesmo e descubra a verdadeira 
                velocidade da sua conexão de internet.
            </p>
            <div class="d-flex gap-3 justify-content-center">
                <a href="/projects/ip-tools/public/speed-test" class="btn btn-light btn-lg">
                    <i class="fa-solid fa-play me-2"></i>
                    Iniciar Teste
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
