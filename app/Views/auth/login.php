<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4>
                        <i class="fas fa-sign-in-alt"></i>
                        Entrar
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= $view->url('auth/loginPost') ?>">
                        <?= $view->csrf() ?>
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="fas fa-user"></i>
                                Nome de Usuário ou Email
                            </label>
                            <input type="text"
                                   id="username"
                                   name="username"
                                   class="form-control"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock"></i>
                                Senha
                            </label>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="form-control"
                                   required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Entrar
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    Não tem uma conta?
                    <a href="<?= $view->url('auth/register') ?>">Registrar</a>
                </div>
            </div>
        </div>
    </div>
</div>
