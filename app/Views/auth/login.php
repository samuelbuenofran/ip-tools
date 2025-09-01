<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4>
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Debug info (remove in production) -->
                    <div class="alert alert-info">
                        <strong>Session Status:</strong> <?= session_status() ?><br>
                        <strong>Session Name:</strong> <?= session_name() ?><br>
                        <strong>Session ID:</strong> <?= session_id() ?><br>
                        <strong>CSRF Token:</strong> <?= $_SESSION['csrf_token'] ?? 'NOT SET' ?><br>
                        <strong>Session Data:</strong> <?= print_r($_SESSION, true) ?>
                    </div>
                    
                    <form method="POST" action="<?= $view->url('auth/loginPost') ?>">
                        <?= $view->csrf() ?>
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="fas fa-user"></i>
                                Username or Email
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
                                Password
                            </label>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="form-control"
                                   required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    Don't have an account?
                    <a href="<?= $view->url('auth/register') ?>">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>
