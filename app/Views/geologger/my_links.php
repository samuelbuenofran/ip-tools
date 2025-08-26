<?php $this->layout('layouts/default', ['title' => $title]) ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-link text-primary"></i> Meus Links de Rastreamento</h2>
        <a href="<?= App::getBaseUrl() ?>/geologger/create" class="btn btn-success">
            <i class="fa-solid fa-plus"></i> Criar Novo Link
        </a>
    </div>

    <!-- Summary Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white text-center">
                <div class="card-body">
                    <h3 class="mb-0"><?= $stats['total_links'] ?? 0 ?></h3>
                    <p class="mb-0">Total de Links</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white text-center">
                <div class="card-body">
                    <h3 class="mb-0"><?= $stats['active_links'] ?? 0 ?></h3>
                    <p class="mb-0">Links Ativos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white text-center">
                <div class="card-body">
                    <h3 class="mb-0"><?= $stats['expired_links'] ?? 0 ?></h3>
                    <p class="mb-0">Links Expirados</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white text-center">
                <div class="card-body">
                    <h3 class="mb-0"><?= array_sum(array_column($links, 'total_clicks')) ?></h3>
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
            <a href="<?= App::getBaseUrl() ?>/geologger/create" class="btn btn-primary">
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
                                    <span class="badge bg-success">Ativo</span>
                                <?php elseif ($link['status'] === 'Expired'): ?>
                                    <span class="badge bg-danger">Expirado</span>
                                <?php else: ?>
                                    <span class="badge bg-info">Sem Expiração</span>
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
                                    <a href="<?= App::getBaseUrl() ?>/geologger/precise_track?code=<?= $link['short_code'] ?>" 
                                       target="_blank" class="btn btn-outline-primary" title="Testar Link">
                                        <i class="fa-solid fa-play"></i>
                                    </a>
                                    <a href="<?= App::getBaseUrl() ?>/geologger/logs?filter=<?= $link['short_code'] ?>" 
                                       class="btn btn-outline-info" title="Ver Logs">
                                        <i class="fa-solid fa-chart-bar"></i>
                                    </a>
                                    <button class="btn btn-outline-secondary" 
                                            onclick="copyToClipboard('<?= $link['short_code'] ?>')" 
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

        <!-- Pagination -->
        <?php if ($pagination['total'] > $pagination['limit']): ?>
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php
                    $totalPages = ceil($pagination['total'] / $pagination['limit']);
                    $currentPage = $pagination['page'];
                    ?>
                    
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $currentPage - 1 ?>">Anterior</a>
                        </li>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                        <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Próxima</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Navigation -->
    <div class="text-center mt-4">
        <a href="<?= App::getBaseUrl() ?>/geologger/create" class="btn btn-success me-2">
            <i class="fa-solid fa-plus"></i> Criar Novo Link
        </a>
        <a href="<?= App::getBaseUrl() ?>/geologger/logs" class="btn btn-info me-2">
            <i class="fa-solid fa-chart-bar"></i> Ver Todos os Logs
        </a>
        <a href="<?= App::getBaseUrl() ?>/" class="btn btn-outline-secondary">
            <i class="fa-solid fa-home"></i> Voltar ao Início
        </a>
    </div>
</div>

<script>
    // Search and filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
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
            const trackingUrl = `<?= App::getBaseUrl() ?>/geologger/precise_track?code=${code}`;
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
