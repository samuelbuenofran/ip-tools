<?php
require_once('../config.php');
$db = connectDB();

// Fetch all tracking links with their statistics
$stmt = $db->query("
  SELECT l.*, 
         COUNT(g.id) as total_clicks,
         MAX(g.timestamp) as last_click,
         CASE 
           WHEN l.expires_at IS NULL THEN 'Never'
           WHEN l.expires_at < NOW() THEN 'Expired'
           ELSE 'Active'
         END as status
  FROM geo_links l
  LEFT JOIN geo_logs g ON l.id = g.link_id
  GROUP BY l.id
  ORDER BY l.created_at DESC
");
$links = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate summary statistics
$totalLinks = count($links);
$activeLinks = count(array_filter($links, function($link) { return $link['status'] === 'Active'; }));
$expiredLinks = count(array_filter($links, function($link) { return $link['status'] === 'Expired'; }));
$totalClicks = array_sum(array_column($links, 'total_clicks'));
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>My Tracking Links | Geolocation Tracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/svg+xml" href="/projects/ip-tools/assets/favico.svg">
  <link rel="alternate icon" href="/projects/ip-tools/assets/favico.svg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    .link-card {
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .link-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .status-badge {
      font-size: 0.8rem;
    }
    .stats-card {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
    }
    .table th { font-size: 0.9rem; }
    .table td { font-size: 0.85rem; vertical-align: middle; }
  </style>
</head>
<body class="bg-light">
  <?php include('../header.php'); ?>

  <div class="container py-4">
    <!-- DEMO MODE NOTICE -->
    <div class="alert alert-warning text-center mb-4">
      <i class="fa-solid fa-triangle-exclamation fa-2x mb-2"></i>
      <h4>🚧 Demo Mode - Standalone Version</h4>
      <p class="mb-2">This is the standalone demo version of the application.</p>
      <p class="mb-0">
        <strong>For production use, please use the MVC version:</strong><br>
        <a href="/projects/ip-tools/public/" class="btn btn-primary mt-2">
          <i class="fa-solid fa-external-link-alt"></i> Go to Production App
        </a>
      </p>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2><i class="fa-solid fa-link text-primary"></i> Meus Links de Rastreamento</h2>
      <a href="create.php" class="btn btn-success">
        <i class="fa-solid fa-plus"></i> Criar Novo Link
      </a>
    </div>

    <!-- Summary Statistics -->
    <div class="row mb-4">
      <div class="col-md-3">
        <div class="card stats-card text-center">
          <div class="card-body">
            <h3 class="mb-0"><?= $totalLinks ?></h3>
            <p class="mb-0">Total de Links</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card stats-card text-center">
          <div class="card-body">
            <h3 class="mb-0"><?= $activeLinks ?></h3>
            <p class="mb-0">Links Ativos</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card stats-card text-center">
          <div class="card-body">
            <h3 class="mb-0"><?= $expiredLinks ?></h3>
            <p class="mb-0">Links Expirados</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card stats-card text-center">
          <div class="card-body">
            <h3 class="mb-0"><?= $totalClicks ?></h3>
            <p class="mb-0">Total de Cliques</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Search and Filter -->
    <div class="row mb-3">
      <div class="col-md-6">
        <input type="search" class="form-control" id="searchInput" placeholder="🔍 Buscar por URL ou código...">
      </div>
      <div class="col-md-3">
        <select class="form-select" id="statusFilter">
          <option value="">Todos os Status</option>
          <option value="Active">Ativos</option>
          <option value="Expired">Expirados</option>
          <option value="Never">Sem Expiração</option>
        </select>
      </div>
      <div class="col-md-3">
        <select class="form-select" id="sortBy">
          <option value="created_at">Mais Recentes</option>
          <option value="total_clicks">Mais Clicados</option>
          <option value="last_click">Último Clique</option>
        </select>
      </div>
    </div>

    <?php if (empty($links)): ?>
      <div class="text-center py-5">
        <i class="fa-solid fa-link fa-3x text-muted mb-3"></i>
        <h5>Nenhum link criado ainda</h5>
        <p class="text-muted">Crie seu primeiro link de rastreamento para começar!</p>
        <a href="create.php" class="btn btn-primary">
          <i class="fa-solid fa-plus"></i> Criar Primeiro Link
        </a>
      </div>
    <?php else: ?>
      <!-- Links Table -->
      <div class="table-responsive">
        <table class="table table-hover table-striped" id="linksTable">
          <thead class="table-primary">
            <tr>
              <th>Status</th>
              <th>Código</th>
              <th>URL Original</th>
              <th>Cliques</th>
              <th>Criado em</th>
              <th>Expira em</th>
              <th>Último Clique</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($links as $link): ?>
              <tr data-status="<?= $link['status'] ?>">
                <td>
                  <?php if ($link['status'] === 'Active'): ?>
                    <span class="badge bg-success status-badge">Ativo</span>
                  <?php elseif ($link['status'] === 'Expired'): ?>
                    <span class="badge bg-danger status-badge">Expirado</span>
                  <?php else: ?>
                    <span class="badge bg-info status-badge">Sem Expiração</span>
                  <?php endif; ?>
                </td>
                <td>
                  <code class="bg-light px-2 py-1 rounded"><?= $link['short_code'] ?></code>
                </td>
                <td>
                  <a href="<?= htmlspecialchars($link['original_url']) ?>" target="_blank" class="text-decoration-none">
                    <?= htmlspecialchars(substr($link['original_url'], 0, 50)) ?>
                    <?= strlen($link['original_url']) > 50 ? '...' : '' ?>
                  </a>
                </td>
                <td>
                  <span class="badge bg-secondary"><?= $link['total_clicks'] ?></span>
                </td>
                <td><?= date('d/m/Y H:i', strtotime($link['created_at'])) ?></td>
                <td>
                  <?php if ($link['expires_at']): ?>
                    <?= date('d/m/Y H:i', strtotime($link['expires_at'])) ?>
                  <?php else: ?>
                    <span class="text-muted">Nunca</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($link['last_click']): ?>
                    <?= date('d/m/Y H:i', strtotime($link['last_click'])) ?>
                  <?php else: ?>
                    <span class="text-muted">Nunca</span>
                  <?php endif; ?>
                </td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <a href="precise_track.php?code=<?= $link['short_code'] ?>" target="_blank" 
                       class="btn btn-outline-primary" title="Testar Link">
                      <i class="fa-solid fa-play"></i>
                    </a>
                    <a href="logs.php?filter=<?= $link['short_code'] ?>" 
                       class="btn btn-outline-info" title="Ver Logs">
                      <i class="fa-solid fa-chart-bar"></i>
                    </a>
                    <button class="btn btn-outline-secondary" onclick="copyToClipboard('<?= $link['short_code'] ?>')" 
                            title="Copiar Código">
                      <i class="fa-solid fa-copy"></i>
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>

    <!-- Navigation -->
    <div class="text-center mt-4">
      <a href="create.php" class="btn btn-success me-2">
        <i class="fa-solid fa-plus"></i> Criar Novo Link
      </a>
      <a href="logs.php" class="btn btn-info me-2">
        <i class="fa-solid fa-chart-bar"></i> Ver Todos os Logs
      </a>
      <a href="../" class="btn btn-outline-secondary">
        <i class="fa-solid fa-home"></i> Voltar ao Início
      </a>
    </div>
  </div>

  <?php include('../footer.php'); ?>

  <script>
    // Search and filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const sortBy = document.getElementById('sortBy');
        const table = document.getElementById('linksTable');
        
        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusFilterValue = statusFilter.value;
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const status = row.getAttribute('data-status');
                const text = row.textContent.toLowerCase();
                const matchesSearch = text.includes(searchTerm);
                const matchesStatus = !statusFilterValue || status === statusFilterValue;
                
                row.style.display = matchesSearch && matchesStatus ? '' : 'none';
            });
        }
        
        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);
        
        // Copy to clipboard function
        window.copyToClipboard = function(code) {
            const trackingUrl = `https://keizai-tech.com/projects/ip-tools/geologger/precise_track.php?code=${code}`;
            navigator.clipboard.writeText(trackingUrl).then(() => {
                // Show success message
                const btn = event.target.closest('button');
                const originalIcon = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-check"></i>';
                btn.classList.remove('btn-outline-secondary');
                btn.classList.add('btn-success');
                
                setTimeout(() => {
                    btn.innerHTML = originalIcon;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-outline-secondary');
                }, 2000);
            });
        };
    });
  </script>
</body>
</html>
