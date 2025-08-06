<!-- app/Views/auth/login.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Entrar</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://kit.fontawesome.com/YOUR-KIT-ID.js" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm">
          <div class="card-header text-center">
            <h4>
              <i class="fas fa-sign-in-alt"></i>
              <span data-translate="login">Entrar</span>
            </h4>
          </div>
          <div class="card-body">
            <form method="POST" action="index.php?page=auth&method=login">
              <div class="mb-3">
                <label for="username" class="form-label">
                  <i class="fas fa-user"></i>
                  <span data-translate="username">Nome de Usuário ou Email</span>
                </label>
                <input type="text"
                       class="form-control"
                       id="username"
                       name="username"
                       required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">
                  <i class="fas fa-lock"></i>
                  <span data-translate="password">Senha</span>
                </label>
                <input type="password"
                       class="form-control"
                       id="password"
                       name="password"
                       required>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-sign-in-alt"></i>
                  <span data-translate="login">Entrar</span>
                </button>
              </div>
            </form>
          </div>
          <div class="card-footer text-center">
            <span data-translate="dont_have_account">Não tem uma conta?</span>
            <a href="index.php?page=auth&method=register" class="text-decoration-none">
              <span data-translate="register">Registrar</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
