<div class="container">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="text-white"><i class="fa-solid fa-tachometer-alt"></i> <span data-translate="welcome_title">Bem-vindo ao IP Tools Suite</span></h3>
                            <p class="mb-0 text-white"><span data-translate="welcome_subtitle">Seu kit completo de ferramentas para rastreamento de IP e análise de rede.</span></p>
                        </div>
                        <div class="col-md-4 text-end">
                            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                                <!-- User is logged in - show welcome message -->
                                <div class="text-white">
                                    <small class="d-block">Bem-vindo, <?= htmlspecialchars($_SESSION['username'] ?? 'Usuário') ?>!</small>
                                    <a href="<?= $view->url('dashboard') ?>" class="btn btn-light btn-sm">
                                        <i class="fa-solid fa-tachometer-alt"></i> Dashboard
                                    </a>
                                    <a href="<?= $view->url('auth/logout') ?>" class="btn btn-outline-light btn-sm">
                                        <i class="fa-solid fa-sign-out-alt"></i> Sair
                                    </a>
                                </div>
                            <?php else: ?>
                                <!-- User is not logged in - show login/register buttons -->
                                <a href="<?= $view->url('auth/login') ?>" class="btn btn-light">
                                    <i class="fa-solid fa-sign-in-alt"></i> <span data-translate="login">Entrar</span>
                                </a>
                                <a href="<?= $view->url('auth/register') ?>" class="btn btn-outline-light">
                                    <i class="fa-solid fa-user-plus"></i> <span data-translate="register">Registrar</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <i class="fa-solid fa-mouse-pointer text-primary fa-2x mb-2"></i>
                    <h4 class="text-dark"><?= $logStats['total_clicks'] ?? 0 ?></h4>
                    <p class="card-text text-muted"><span data-translate="total_clicks">Total de Cliques</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <i class="fa-solid fa-link text-success fa-2x mb-2"></i>
                    <h4 class="text-dark"><?= $linkStats['active_links'] ?? 0 ?></h4>
                    <p class="card-text text-muted"><span data-translate="active_links">Links Ativos</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-info">
                <div class="card-body">
                    <i class="fa-solid fa-user-check text-info fa-2x mb-2"></i>
                    <h4 class="text-dark"><?= $logStats['unique_visitors'] ?? 0 ?></h4>
                    <p class="card-text text-muted"><span data-translate="unique_visitors">Visitantes Únicos</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <i class="fa-solid fa-map-marker-alt text-warning fa-2x mb-2"></i>
                    <h4 class="text-dark"><?= $logStats['gps_tracking'] ?? 0 ?></h4>
                    <p class="card-text text-muted"><span data-translate="gps_tracking">Rastreamento GPS</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa-solid fa-bolt"></i> <span data-translate="quick_actions">Ações Rápidas</span></h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="<?= $view->url('geologger/create') ?>" class="btn btn-primary w-100">
                                <i class="fa-solid fa-plus"></i> <span data-translate="create_tracking_link">Criar Link de Rastreamento</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= $view->url('geologger/logs') ?>" class="btn btn-info w-100">
                                <i class="fa-solid fa-chart-line"></i> <span data-translate="view_logs">Ver Logs</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= $view->url('phone-tracker/send_sms') ?>" class="btn btn-success w-100">
                                <i class="fa-solid fa-mobile-screen-button"></i> <span data-translate="nav_phone_tracker">Rastreador de Telefone</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= $view->url('utils/speedtest') ?>" class="btn btn-warning w-100">
                                <i class="fa-solid fa-gauge-high"></i> <span data-translate="nav_speed_test">Teste de Velocidade</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa-solid fa-clock"></i> <span data-translate="recent_activity">Atividade Recente</span></h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentActivity)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recentActivity as $log): ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?= $log['ip_address'] ?></strong>
                                            <br>
                                            <small class="text-muted">
                                                <?= $log['city'] ?? 'Desconhecido' ?>, <?= $log['country'] ?? 'Desconhecido' ?>
                                            </small>
                                        </div>
                                        <small class="text-muted">
                                            <?= date('M d, H:i', strtotime($log['timestamp'])) ?>
                                        </small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted"><span data-translate="no_recent_activity">Nenhuma atividade recente.</span></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa-solid fa-info-circle"></i> <span data-translate="about_ip_tools">Sobre o IP Tools Suite</span></h5>
                </div>
                <div class="card-body">
                    <p class="text-dark"><span data-translate="about_description">O IP Tools Suite é um kit completo de ferramentas para rastreamento de IP, análise de geolocalização e monitoramento de rede.</span></p>
                    <ul class="text-dark">
                        <li><strong class="text-dark"><span data-translate="geolocation_tracking">Rastreamento de Geolocalização:</span></strong> <span data-translate="geolocation_desc">Criar links de rastreamento e monitorar localizações de visitantes</span></li>
                        <li><strong class="text-dark"><span data-translate="phone_tracking">Rastreamento de Telefone:</span></strong> <span data-translate="phone_desc">Sistema de rastreamento de localização baseado em SMS</span></li>
                        <li><strong class="text-dark"><span data-translate="speed_testing">Teste de Velocidade:</span></strong> <span data-translate="speed_desc">Análise de velocidade de conexão com a internet</span></li>
                        <li><strong class="text-dark"><span data-translate="analytics">Analytics:</span></strong> <span data-translate="analytics_desc">Logs detalhados de visitantes e estatísticas</span></li>
                    </ul>
                    <a href="<?= $view->url('about') ?>" class="btn btn-outline-primary">
                        <i class="fa-solid fa-info-circle"></i> <span data-translate="learn_more">Saiba Mais</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> 