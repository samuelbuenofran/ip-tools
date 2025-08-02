<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4><i class="fa-solid fa-user-plus"></i> <span data-translate="register">Registrar</span></h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= $this->url('auth/registerPost') ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">
                                        <i class="fa-solid fa-user"></i> <span data-translate="first_name">Nome</span>
                                    </label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">
                                        <i class="fa-solid fa-user"></i> <span data-translate="last_name">Sobrenome</span>
                                    </label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="fa-solid fa-at"></i> <span data-translate="username">Nome de Usuário</span>
                            </label>
                            <input type="text" class="form-control" id="username" name="username" required>
                            <div class="form-text">
                                <span data-translate="username_requirements">Apenas letras, números e underscore. Mínimo 3 caracteres.</span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fa-solid fa-envelope"></i> <span data-translate="email">Email</span>
                            </label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fa-solid fa-lock"></i> <span data-translate="password">Senha</span>
                            </label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="form-text">
                                <span data-translate="password_requirements">Mínimo 6 caracteres.</span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">
                                <i class="fa-solid fa-lock"></i> <span data-translate="confirm_password">Confirmar Senha</span>
                            </label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-user-plus"></i> <span data-translate="register">Registrar</span>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">
                        <span data-translate="already_have_account">Já tem uma conta?</span>
                        <a href="<?= $this->url('auth/login') ?>" class="text-decoration-none">
                            <span data-translate="login">Entrar</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div> 