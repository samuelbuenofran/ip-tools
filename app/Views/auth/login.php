<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4><i class="fa-solid fa-sign-in-alt"></i> <span data-translate="login">Entrar</span></h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= $this->url('auth/loginPost') ?>">
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="fa-solid fa-user"></i> <span data-translate="username">Nome de Usuário ou Email</span>
                            </label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fa-solid fa-lock"></i> <span data-translate="password">Senha</span>
                            </label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-sign-in-alt"></i> <span data-translate="login">Entrar</span>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">
                        <span data-translate="dont_have_account">Não tem uma conta?</span>
                        <a href="<?= $this->url('auth/register') ?>" class="text-decoration-none">
                            <span data-translate="register">Registrar</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div> 