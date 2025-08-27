<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fa-solid fa-cogs text-info me-2"></i>
                    System Debug Tools
                </h1>
                <a href="<?= $view->url('debug') ?>" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>
                    Back to Dashboard
                </a>
            </div>
            
            <!-- System Operations -->
            <div class="row g-4">
                <!-- Check Permissions -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-key me-2"></i>
                                Check File Permissions
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?= $view->url('debug/system') ?>">
                                <input type="hidden" name="action" value="check_permissions">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fa-solid fa-search me-2"></i>
                                    Check Permissions
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Check Dependencies -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-puzzle-piece me-2"></i>
                                Check Dependencies
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?= $view->url('debug/system') ?>">
                                <input type="hidden" name="action" value="check_dependencies">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fa-solid fa-list-check me-2"></i>
                                    Check Dependencies
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional Operations -->
            <div class="row g-4 mt-2">
                <!-- System Health -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-heartbeat me-2"></i>
                                System Health Check
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?= $view->url('debug/system') ?>">
                                <input type="hidden" name="action" value="system_health">
                                <button type="submit" class="btn btn-info w-100">
                                    <i class="fa-solid fa-stethoscope me-2"></i>
                                    Check Health
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Clear Cache -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-broom me-2"></i>
                                Clear Cache
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?= $view->url('debug/system') ?>">
                                <input type="hidden" name="action" value="clear_cache">
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fa-solid fa-trash me-2"></i>
                                    Clear Cache
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Results Display -->
            <?php if (isset($result)): ?>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fa-solid fa-list-check me-2"></i>
                                    Operation Result
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if (is_array($result)): ?>
                                    <?php if (isset($result['success'])): ?>
                                        <div class="alert alert-success">
                                            <i class="fa-solid fa-check-circle me-2"></i>
                                            <strong>Success:</strong> <?= htmlspecialchars($result['message']) ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Permissions Check Result -->
                                    <?php if (isset($result['app/Views'])): ?>
                                        <h6>File Permissions:</h6>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Path</th>
                                                        <th>Current Permissions</th>
                                                        <th>Expected</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($result as $path => $info): ?>
                                                        <?php if (is_array($info) && isset($info['status'])): ?>
                                                            <tr>
                                                                <td><code><?= htmlspecialchars($path) ?></code></td>
                                                                <td>
                                                                    <?php if (isset($info['permissions'])): ?>
                                                                        <span class="badge bg-secondary"><?= $info['permissions'] ?></span>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if (isset($info['expected'])): ?>
                                                                        <span class="badge bg-info"><?= $info['expected'] ?></span>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($info['status'] === 'OK'): ?>
                                                                        <span class="badge bg-success">OK</span>
                                                                    <?php elseif ($info['status'] === 'WARNING'): ?>
                                                                        <span class="badge bg-warning text-dark">WARNING</span>
                                                                    <?php else: ?>
                                                                        <span class="badge bg-danger"><?= $info['status'] ?></span>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Dependencies Check Result -->
                                    <?php if (isset($result['pdo'])): ?>
                                        <h6>PHP Extensions:</h6>
                                        <div class="row">
                                            <?php foreach ($result as $ext => $status): ?>
                                                <div class="col-md-4 col-sm-6 mb-2">
                                                    <span class="badge <?= $status === 'LOADED' ? 'bg-success' : 'bg-danger' ?>">
                                                        <?= strtoupper($ext) ?>: <?= $status ?>
                                                    </span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- System Health Result -->
                                    <?php if (isset($result['memory_usage'])): ?>
                                        <h6>System Health:</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td><strong>Memory Usage:</strong></td>
                                                            <td><?= $view->formatNumber($result['memory_usage'] / 1024 / 1024, 2) ?> MB</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Peak Memory:</strong></td>
                                                            <td><?= $view->formatNumber($result['memory_peak'] / 1024 / 1024, 2) ?> MB</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Free Disk Space:</strong></td>
                                                            <td><?= $view->formatNumber($result['disk_free_space'] / 1024 / 1024 / 1024, 2) ?> GB</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td><strong>PHP Version:</strong></td>
                                                            <td><?= $result['php_version'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Max Execution Time:</strong></td>
                                                            <td><?= $result['max_execution_time'] ?>s</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Memory Limit:</strong></td>
                                                            <td><?= $result['memory_limit'] ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        <i class="fa-solid fa-info-circle me-2"></i>
                                        <?= htmlspecialchars($result) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- System Information -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-info-circle me-2"></i>
                                System Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
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
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tbody>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
