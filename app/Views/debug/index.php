<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fa-solid fa-bug text-danger me-2"></i>
                    Debug Tools Dashboard
                </h1>
                <div class="badge bg-warning text-dark">
                    <i class="fa-solid fa-shield-alt me-1"></i>
                    Admin Only
                </div>
            </div>
            
            <!-- System Status Overview -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-database fa-2x text-primary mb-2"></i>
                            <h5 class="card-title">Database</h5>
                            <div class="badge <?= $databaseStatus['status'] === 'connected' ? 'bg-success' : 'bg-danger' ?>">
                                <?= ucfirst($databaseStatus['status']) ?>
                            </div>
                            <?php if (isset($databaseStatus['version'])): ?>
                                <small class="d-block text-muted mt-1"><?= $databaseStatus['version'] ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-server fa-2x text-success mb-2"></i>
                            <h5 class="card-title">PHP Version</h5>
                            <div class="badge bg-info"><?= $systemInfo['php_version'] ?></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-globe fa-2x text-info mb-2"></i>
                            <h5 class="card-title">Server</h5>
                            <div class="badge bg-secondary"><?= $systemInfo['http_host'] ?></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card border-warning">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-file-lines fa-2x text-warning mb-2"></i>
                            <h5 class="card-title">Recent Logs</h5>
                            <div class="badge bg-warning text-dark"><?= count($recentLogs) ?> entries</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-database me-2"></i>
                                Database Tools
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Test connections, explore tables, execute queries, and manage database operations.</p>
                            <div class="d-grid gap-2">
                                <a href="<?= $view->url('debug/database') ?>" class="btn btn-primary">
                                    <i class="fa-solid fa-arrow-right me-2"></i>
                                    Database Debug
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-code me-2"></i>
                                Script Tools
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Test PHP scripts, execute files, and get PHP information for debugging.</p>
                            <div class="d-grid gap-2">
                                <a href="<?= $view->url('debug/scripts') ?>" class="btn btn-success">
                                    <i class="fa-solid fa-arrow-right me-2"></i>
                                    Script Debug
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-cogs me-2"></i>
                                System Tools
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Check permissions, dependencies, system health, and clear cache.</p>
                            <div class="d-grid gap-2">
                                <a href="<?= $view->url('debug/system') ?>" class="btn btn-info">
                                    <i class="fa-solid fa-arrow-right me-2"></i>
                                    System Debug
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- System Information -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-info-circle me-2"></i>
                                System Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <td><strong>PHP Version:</strong></td>
                                        <td><?= $systemInfo['php_version'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Server Software:</strong></td>
                                        <td><?= $systemInfo['server_software'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Document Root:</strong></td>
                                        <td><code><?= $systemInfo['document_root'] ?></code></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Script Name:</strong></td>
                                        <td><code><?= $systemInfo['script_name'] ?></code></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Request URI:</strong></td>
                                        <td><code><?= $systemInfo['request_uri'] ?></code></td>
                                    </tr>
                                    <tr>
                                        <td><strong>HTTP Host:</strong></td>
                                        <td><?= $systemInfo['http_host'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-file-lines me-2"></i>
                                Recent Error Logs
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recentLogs)): ?>
                                <div class="table-responsive" style="max-height: 300px;">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Timestamp</th>
                                                <th>Message</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (array_reverse($recentLogs) as $log): ?>
                                                <?php 
                                                $logData = json_decode($log, true);
                                                if ($logData): 
                                                ?>
                                                <tr>
                                                    <td><small><?= $logData['timestamp'] ?? 'Unknown' ?></small></td>
                                                    <td><small><?= htmlspecialchars($logData['message'] ?? 'Unknown') ?></small></td>
                                                </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted mb-0">No recent error logs found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Security Notice -->
            <div class="alert alert-warning mt-4">
                <i class="fa-solid fa-exclamation-triangle me-2"></i>
                <strong>Security Notice:</strong> This debug tool is restricted to admin users only. 
                All operations are logged and monitored for security purposes. 
                Use these tools responsibly and only for legitimate debugging purposes.
            </div>
        </div>
    </div>
</div>
