<?php
// app/Views/auth/login.php
?><!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Entrar – IP Tools Suite</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/YOUR-KIT-ID.js" crossorigin="anonymous"></script>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php?page=dashboard">IP Tools Suite</a>
    <div class="ms-auto">
      <a class="btn btn-outline-primary me-2"
         href="index.php?page=auth&method=form">
        <i class="fas fa-sign-in-alt"></i> Entrar
      </a>
      <a class="btn btn-primary"
         href="index.php?page=auth&method=register">
        <i class="fas fa-user-plus"></i> Registrar
      </a>
    </div>
  </nav>

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
            <form method="POST"
                  action="index.php?page=auth&method=login">
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
            <a href="index.php?page=auth&method=register">Registrar</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
