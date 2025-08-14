<?php
// This view will use the default layout automatically
// The title is passed from the controller
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-dark" data-translate="my_links">Meus Links</h1>
                <a href="<?= $view->url('dashboard') ?>" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> 
                    <span data-translate="back_to_dashboard">Voltar ao Dashboard</span>
                </a>
            </div>

            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['success_message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['error_message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <?php if (empty($links)): ?>
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-link fa-3x text-muted mb-3"></i>
                        <h5 class="text-dark" data-translate="no_links_created">Nenhum link criado ainda</h5>
                        <p class="text-muted" data-translate="create_first_link">Crie seu primeiro link de rastreamento no dashboard.</p>
                        <a href="<?= $view->url('dashboard') ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> 
                            <span data-translate="create_link">Criar Link</span>
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-dark mb-0">
                            <i class="fas fa-link"></i> 
                            <span data-translate="total_links">Total de Links:</span> 
                            <?php echo count($links); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-dark" data-translate="link">Link</th>
                                        <th class="text-dark" data-translate="destination">Destino</th>
                                        <th class="text-dark" data-translate="created">Criado</th>
                                        <th class="text-dark" data-translate="expires">Expira</th>
                                        <th class="text-dark" data-translate="clicks">Cliques</th>
                                        <th class="text-dark" data-translate="actions">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($links as $link): ?>
                                        <tr>
                                            <td>
                                                <code class="text-primary"><?php echo htmlspecialchars($link['short_code']); ?></code>
                                            </td>
                                            <td>
                                                <a href="<?php echo htmlspecialchars($link['original_url']); ?>" 
                                                   target="_blank" class="text-decoration-none">
                                                    <?php echo htmlspecialchars(substr($link['original_url'], 0, 50)); ?>
                                                    <?php if (strlen($link['original_url']) > 50): ?>...<?php endif; ?>
                                                </a>
                                            </td>
                                            <td class="text-muted">
                                                <?php echo date('d/m/Y H:i', strtotime($link['created_at'])); ?>
                                            </td>
                                            <td class="text-muted">
                                                <?php if ($link['expires_at']): ?>
                                                    <?php echo date('d/m/Y H:i', strtotime($link['expires_at'])); ?>
                                                <?php else: ?>
                                                    <span class="text-success" data-translate="never">Nunca</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary"><?php echo $link['clicks'] ?? 0; ?></span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= $view->url('geologger/logs') ?>?link=<?php echo $link['short_code']; ?>" 
                                                       class="btn btn-sm btn-outline-primary" title="Ver Logs">
                                                        <i class="fas fa-chart-line"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                                            onclick="deleteLink(<?php echo $link['id']; ?>)" 
                                                            title="Deletar Link">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Delete Link Modal -->
<div class="modal fade" id="deleteLinkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" data-translate="confirm_delete">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-dark" data-translate="delete_link_warning">
                    Tem certeza que deseja deletar este link? Esta ação não pode ser desfeita.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <span data-translate="cancel">Cancelar</span>
                </button>
                <form method="POST" action="<?= $view->url('dashboard/deleteLink') ?>" style="display: inline;">
                    <input type="hidden" name="link_id" id="deleteLinkId">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> 
                        <span data-translate="delete">Deletar</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function deleteLink(linkId) {
    document.getElementById('deleteLinkId').value = linkId;
    new bootstrap.Modal(document.getElementById('deleteLinkModal')).show();
}
</script> 