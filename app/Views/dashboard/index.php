<div class="container">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="text-white">
                                <i class="fa-solid fa-tachometer-alt"></i> 
                                <span data-translate="welcome_back" class="fw-bold">Bem-vindo de volta,</span> 
                                <?= htmlspecialchars($user['first_name'] ?? $user['username']) ?>!
                            </h3>
                            <p class="mb-0 text-white">
                                <span data-translate="dashboard_subtitle">Gerencie seus links de rastreamento e monitore a atividade.</span>
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                <a href="<?= $view->url('admin') ?>" class="btn btn-warning me-2">
                                    <i class="fa-solid fa-shield-alt"></i> Admin Panel
                                </a>
                            <?php endif; ?>
                            <a href="<?= $view->url('auth/profile') ?>" class="btn btn-light">
                                <i class="fa-solid fa-user-edit"></i> <span data-translate="profile">Perfil</span>
                            </a>
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
                    <h4 class="text-dark"><?= $userStats['total_clicks'] ?? 0 ?></h4>
                    <p class="card-text text-muted"><span data-translate="total_clicks">Total de Cliques</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <i class="fa-solid fa-link text-success fa-2x mb-2"></i>
                    <h4 class="text-dark"><?= $userStats['total_links'] ?? 0 ?></h4>
                    <p class="card-text text-muted"><span data-translate="total_links">Total de Links</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-info">
                <div class="card-body">
                    <i class="fa-solid fa-user-check text-info fa-2x mb-2"></i>
                    <h4 class="text-dark"><?= $userStats['unique_visitors'] ?? 0 ?></h4>
                    <p class="card-text text-muted"><span data-translate="unique_visitors">Visitantes Únicos</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <i class="fa-solid fa-map-marker-alt text-warning fa-2x mb-2"></i>
                    <h4 class="text-dark"><?= $userStats['gps_tracking'] ?? 0 ?></h4>
                    <p class="card-text text-muted"><span data-translate="gps_tracking">Rastreamento GPS</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Link Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa-solid fa-plus"></i> <span data-translate="create_new_link">Criar Novo Link de Rastreamento</span></h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= $view->url('dashboard/createLink') ?>">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="original_url" class="form-label">
                                        <i class="fa-solid fa-link"></i> <span data-translate="destination_url">URL de Destino</span>
                                    </label>
                                    <input type="url" class="form-control" id="original_url" name="original_url" 
                                           placeholder="https://example.com" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="expires_at" class="form-label">
                                        <i class="fa-solid fa-calendar"></i> <span data-translate="expires_at">Expira em (opcional)</span>
                                    </label>
                                    <input type="datetime-local" class="form-control" id="expires_at" name="expires_at">
                                </div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-plus"></i> <span data-translate="create_link">Criar Link</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Activity -->
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
                                            <strong><?= htmlspecialchars($log['ip_address']) ?></strong>
                                            <br>
                                            <small class="text-muted">
                                                <?= htmlspecialchars($log['city'] ?? 'Desconhecido') ?>, 
                                                <?= htmlspecialchars($log['country'] ?? 'Desconhecido') ?>
                                            </small>
                                            <br>
                                            <small class="text-muted">
                                                <span data-translate="link">Link:</span> 
                                                <?= htmlspecialchars($log['short_code']) ?>
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
        
        <!-- User Links -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa-solid fa-link"></i> <span data-translate="my_links">Meus Links</span></h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($userLinks)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($userLinks as $link): ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?= htmlspecialchars($link['short_code']) ?></strong>
                                            <br>
                                            <small class="text-muted">
                                                <?= htmlspecialchars(substr($link['original_url'], 0, 50)) ?>...
                                            </small>
                                            <br>
                                            <small class="text-muted">
                                                <span data-translate="created">Criado:</span> 
                                                <?= date('M d, Y', strtotime($link['created_at'])) ?>
                                            </small>
                                        </div>
                                        <div>
                                            <a href="<?= $view->url('geologger/track/' . $link['short_code']) ?>" 
                                               target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-external-link-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="mt-3">
                            <a href="<?= $view->url('dashboard/links') ?>" class="btn btn-outline-primary">
                                <i class="fa-solid fa-list"></i> <span data-translate="view_all_links">Ver Todos os Links</span>
                            </a>
                        </div>
                    <?php else: ?>
                        <p class="text-muted"><span data-translate="no_links_created">Nenhum link criado ainda.</span></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> 