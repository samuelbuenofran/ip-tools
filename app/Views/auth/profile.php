<div class="container">
    <div class="row">
        <div class="col-md-8">
            <!-- Profile Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5><i class="fa-solid fa-user-edit"></i> <span data-translate="profile_information">Informações do Perfil</span></h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= $this->url('auth/updateProfile') ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">
                                        <i class="fa-solid fa-user"></i> <span data-translate="first_name">Nome</span>
                                    </label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" 
                                           value="<?= htmlspecialchars($user['first_name'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">
                                        <i class="fa-solid fa-user"></i> <span data-translate="last_name">Sobrenome</span>
                                    </label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" 
                                           value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fa-solid fa-envelope"></i> <span data-translate="email">Email</span>
                            </label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-save"></i> <span data-translate="update_profile">Atualizar Perfil</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Change Password -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5><i class="fa-solid fa-key"></i> <span data-translate="change_password">Alterar Senha</span></h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= $this->url('auth/changePassword') ?>">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">
                                <i class="fa-solid fa-lock"></i> <span data-translate="current_password">Senha Atual</span>
                            </label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="new_password" class="form-label">
                                <i class="fa-solid fa-lock"></i> <span data-translate="new_password">Nova Senha</span>
                            </label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <div class="form-text">
                                <span data-translate="password_requirements">Mínimo 6 caracteres.</span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">
                                <i class="fa-solid fa-lock"></i> <span data-translate="confirm_password">Confirmar Nova Senha</span>
                            </label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning">
                                <i class="fa-solid fa-key"></i> <span data-translate="change_password">Alterar Senha</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Account Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5><i class="fa-solid fa-info-circle"></i> <span data-translate="account_info">Informações da Conta</span></h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong><span data-translate="username">Nome de Usuário:</span></strong><br>
                        <span class="text-muted"><?= htmlspecialchars($user['username']) ?></span>
                    </div>
                    
                    <div class="mb-3">
                        <strong><span data-translate="role">Função:</span></strong><br>
                        <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'primary' ?>">
                            <?= ucfirst($user['role']) ?>
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <strong><span data-translate="status">Status:</span></strong><br>
                        <span class="badge bg-<?= $user['is_active'] ? 'success' : 'secondary' ?>">
                            <?= $user['is_active'] ? 'Ativo' : 'Inativo' ?>
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <strong><span data-translate="created_at">Criado em:</span></strong><br>
                        <span class="text-muted"><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></span>
                    </div>
                    
                    <?php if ($user['last_login']): ?>
                    <div class="mb-3">
                        <strong><span data-translate="last_login">Último Login:</span></strong><br>
                        <span class="text-muted"><?= date('d/m/Y H:i', strtotime($user['last_login'])) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5><i class="fa-solid fa-bolt"></i> <span data-translate="quick_actions">Ações Rápidas</span></h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= $this->url('dashboard') ?>" class="btn btn-outline-primary">
                            <i class="fa-solid fa-tachometer-alt"></i> <span data-translate="dashboard">Dashboard</span>
                        </a>
                        <a href="<?= $this->url('geologger/create') ?>" class="btn btn-outline-success">
                            <i class="fa-solid fa-plus"></i> <span data-translate="create_link">Criar Link</span>
                        </a>
                        <a href="<?= $this->url('geologger/logs') ?>" class="btn btn-outline-info">
                            <i class="fa-solid fa-chart-line"></i> <span data-translate="view_logs">Ver Logs</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 