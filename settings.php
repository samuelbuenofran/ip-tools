<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Configurações - IP Tools Suite</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="/projects/ip-tools/assets/themes.css" rel="stylesheet">
  <script src="/projects/ip-tools/assets/theme-switcher.js" defer></script>
  <script src="/projects/ip-tools/assets/translations.js" defer></script>
</head>
<body class="bg-light">
  <?php include('header.php'); ?>

  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h4 class="mb-0" data-translate="settings">
              <i class="fa-solid fa-cog"></i> Configurações
            </h4>
          </div>
          <div class="card-body">
            
            <!-- Language Settings Section -->
            <div class="mb-4">
              <h5 class="border-bottom pb-2" data-translate="language_settings">
                <i class="fa-solid fa-globe"></i> Configurações de Idioma
              </h5>
              
              <div class="row">
                <div class="col-md-8">
                  <p class="text-muted" data-translate="language_description">
                    O idioma padrão do aplicativo é Português (Brasil). 
                    A opção de inglês está disponível apenas para fins de desenvolvimento e depuração.
                  </p>
                </div>
                <div class="col-md-4 text-end">
                  <button class="btn btn-outline-warning" onclick="switchToEnglish()" data-translate="switch_to_english">
                    <i class="fa-solid fa-code"></i> Alterar para Inglês (Dev)
                  </button>
                </div>
              </div>
              
              <div class="alert alert-info mt-3" role="alert">
                <i class="fa-solid fa-info-circle"></i>
                <span data-translate="language_warning">
                  <strong>Atenção:</strong> O idioma inglês é destinado apenas para desenvolvedores e fins de depuração. 
                  Para uso em produção, recomendamos manter o idioma em Português (Brasil).
                </span>
              </div>
            </div>

            <!-- Theme Settings Section -->
            <div class="mb-4">
              <h5 class="border-bottom pb-2" data-translate="theme_settings">
                <i class="fa-solid fa-palette"></i> Configurações de Tema
              </h5>
              
              <div class="row">
                <div class="col-md-8">
                  <p class="text-muted" data-translate="theme_description">
                    O tema atual é macOS Aqua. Esta é a única opção disponível para manter a consistência visual.
                  </p>
                </div>
                <div class="col-md-4 text-end">
                  <span class="badge bg-primary" data-translate="macos_aqua">macOS Aqua</span>
                </div>
              </div>
            </div>

            <!-- System Information Section -->
            <div class="mb-4">
              <h5 class="border-bottom pb-2" data-translate="system_info">
                <i class="fa-solid fa-info-circle"></i> Informações do Sistema
              </h5>
              
              <div class="row">
                <div class="col-md-6">
                  <p><strong data-translate="version">Versão:</strong> 1.0</p>
                  <p><strong data-translate="php_version">Versão do PHP:</strong> <?php echo phpversion(); ?></p>
                </div>
                <div class="col-md-6">
                  <p><strong data-translate="server_time">Hora do Servidor:</strong> <?php echo date('d/m/Y H:i:s'); ?></p>
                  <p><strong data-translate="timezone">Fuso Horário:</strong> <?php echo date_default_timezone_get(); ?></p>
                </div>
              </div>
            </div>

            <!-- Developer Tools Section -->
            <div class="mb-4">
              <h5 class="border-bottom pb-2" data-translate="developer_tools">
                <i class="fa-solid fa-tools"></i> Ferramentas de Desenvolvedor
              </h5>
              
              <div class="row">
                <div class="col-md-8">
                  <p class="text-muted" data-translate="developer_description">
                    Ferramentas avançadas para desenvolvedores e administradores do sistema.
                  </p>
                </div>
                <div class="col-md-4 text-end">
                  <a href="/projects/ip-tools/theme-demo.php" class="btn btn-outline-secondary btn-sm" data-translate="theme_demo">
                    <i class="fa-solid fa-palette"></i> Demo de Temas
                  </a>
                </div>
              </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-4">
              <a href="/projects/ip-tools/index.php" class="btn btn-primary" data-translate="back_to_home">
                <i class="fa-solid fa-home"></i> Voltar ao Início
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include('footer.php'); ?>

  <script>
    function switchToEnglish() {
      if (confirm(getText('confirm_switch_english'))) {
        switchLanguage('en');
        showNotification(getText('language_switched_english'), 'success');
      }
    }

    function showNotification(message, type = 'info') {
      const notification = document.createElement('div');
      notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
      notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
        min-width: 300px;
      `;
      notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      `;
      
      document.body.appendChild(notification);
      
      setTimeout(() => {
        if (notification.parentNode) {
          notification.remove();
        }
      }, 5000);
    }
  </script>
</body>
</html> 