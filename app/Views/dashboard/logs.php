<?php $this->layout('layouts/default', ['title' => $title]); ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-dark" data-translate="my_logs">Meus Logs</h1>
                <a href="dashboard" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> 
                    <span data-translate="back_to_dashboard">Voltar ao Dashboard</span>
                </a>
            </div>

            <?php if (empty($logs)): ?>
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                        <h5 class="text-dark" data-translate="no_logs_yet">Nenhum log ainda</h5>
                        <p class="text-muted" data-translate="logs_will_appear">Os logs aparecerão aqui quando alguém clicar em seus links de rastreamento.</p>
                        <a href="dashboard" class="btn btn-primary">
                            <i class="fas fa-plus"></i> 
                            <span data-translate="create_link">Criar Link</span>
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-dark mb-0">
                            <i class="fas fa-chart-line"></i> 
                            <span data-translate="recent_activity">Atividade Recente</span>
                            <span class="badge bg-primary ms-2"><?php echo count($logs); ?></span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-dark" data-translate="date_time">Data/Hora</th>
                                        <th class="text-dark" data-translate="link">Link</th>
                                        <th class="text-dark" data-translate="ip_address">IP</th>
                                        <th class="text-dark" data-translate="location">Localização</th>
                                        <th class="text-dark" data-translate="device">Dispositivo</th>
                                        <th class="text-dark" data-translate="details">Detalhes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($logs as $log): ?>
                                        <tr>
                                            <td class="text-muted">
                                                <?php echo date('d/m/Y H:i:s', strtotime($log['timestamp'])); ?>
                                            </td>
                                            <td>
                                                <code class="text-primary"><?php echo htmlspecialchars($log['short_code']); ?></code>
                                            </td>
                                            <td>
                                                <code class="text-secondary"><?php echo htmlspecialchars($log['ip_address']); ?></code>
                                            </td>
                                            <td>
                                                <?php if ($log['latitude'] && $log['longitude']): ?>
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-map-marker-alt"></i> 
                                                        <?php echo htmlspecialchars($log['city'] ?? 'N/A'); ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-question"></i> 
                                                        <span data-translate="unknown">Desconhecido</span>
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($log['user_agent']): ?>
                                                    <?php
                                                    $userAgent = $log['user_agent'];
                                                    $device = 'Desktop';
                                                    if (strpos($userAgent, 'Mobile') !== false) {
                                                        $device = 'Mobile';
                                                    } elseif (strpos($userAgent, 'Tablet') !== false) {
                                                        $device = 'Tablet';
                                                    }
                                                    ?>
                                                    <span class="badge bg-info"><?php echo $device; ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted" data-translate="unknown">Desconhecido</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        onclick="showLogDetails(<?php echo htmlspecialchars(json_encode($log)); ?>)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
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

<!-- Log Details Modal -->
<div class="modal fade" id="logDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" data-translate="log_details">Detalhes do Log</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="logDetailsContent">
                    <!-- Content will be populated by JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <span data-translate="close">Fechar</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showLogDetails(log) {
    const content = `
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-dark" data-translate="basic_info">Informações Básicas</h6>
                <table class="table table-sm">
                    <tr>
                        <td class="text-muted" data-translate="date_time">Data/Hora:</td>
                        <td>${new Date(log.timestamp).toLocaleString('pt-BR')}</td>
                    </tr>
                    <tr>
                        <td class="text-muted" data-translate="ip_address">Endereço IP:</td>
                        <td><code>${log.ip_address}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted" data-translate="link">Link:</td>
                        <td><code>${log.short_code}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted" data-translate="destination">Destino:</td>
                        <td><a href="${log.original_url}" target="_blank">${log.original_url}</a></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6 class="text-dark" data-translate="location_info">Informações de Localização</h6>
                <table class="table table-sm">
                    <tr>
                        <td class="text-muted" data-translate="country">País:</td>
                        <td>${log.country || 'N/A'}</td>
                    </tr>
                    <tr>
                        <td class="text-muted" data-translate="region">Região:</td>
                        <td>${log.region || 'N/A'}</td>
                    </tr>
                    <tr>
                        <td class="text-muted" data-translate="city">Cidade:</td>
                        <td>${log.city || 'N/A'}</td>
                    </tr>
                    <tr>
                        <td class="text-muted" data-translate="coordinates">Coordenadas:</td>
                        <td>${log.latitude && log.longitude ? `${log.latitude}, ${log.longitude}` : 'N/A'}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h6 class="text-dark" data-translate="device_info">Informações do Dispositivo</h6>
                <table class="table table-sm">
                    <tr>
                        <td class="text-muted" data-translate="user_agent">User Agent:</td>
                        <td><code>${log.user_agent || 'N/A'}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted" data-translate="location_type">Tipo de Localização:</td>
                        <td>
                            <span class="badge ${log.location_type === 'GPS' ? 'bg-success' : 'bg-warning'}">
                                ${log.location_type || 'IP'}
                            </span>
                        </td>
                    </tr>
                    ${log.accuracy ? `
                    <tr>
                        <td class="text-muted" data-translate="accuracy">Precisão:</td>
                        <td>${log.accuracy} metros</td>
                    </tr>
                    ` : ''}
                    ${log.address ? `
                    <tr>
                        <td class="text-muted" data-translate="address">Endereço:</td>
                        <td>${log.address}</td>
                    </tr>
                    ` : ''}
                </table>
            </div>
        </div>
    `;
    
    document.getElementById('logDetailsContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('logDetailsModal')).show();
}
</script> 