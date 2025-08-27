<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fa-solid fa-database text-primary me-2"></i>
                    Database Debug Tools
                </h1>
                <a href="<?= $view->url('debug') ?>" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>
                    Back to Dashboard
                </a>
            </div>
            
            <!-- Database Operations -->
            <div class="row g-4">
                <!-- Connection Test -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-plug me-2"></i>
                                Test Database Connection
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?= $view->url('debug/database') ?>">
                                <input type="hidden" name="action" value="test_connection">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fa-solid fa-database me-2"></i>
                                    Test Connection
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Show Tables -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-table me-2"></i>
                                Show All Tables
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?= $view->url('debug/database') ?>">
                                <input type="hidden" name="action" value="show_tables">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fa-solid fa-list me-2"></i>
                                    List Tables
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Table Operations -->
            <div class="row g-4 mt-2">
                <!-- Describe Table -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-info-circle me-2"></i>
                                Describe Table
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?= $view->url('debug/database') ?>">
                                <input type="hidden" name="action" value="describe_table">
                                <div class="mb-3">
                                    <label for="table_name" class="form-label">Table Name:</label>
                                    <select class="form-select" name="table_name" required>
                                        <option value="">Select a table...</option>
                                        <?php foreach ($tables as $table): ?>
                                            <option value="<?= htmlspecialchars($table) ?>"><?= htmlspecialchars($table) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-info w-100">
                                    <i class="fa-solid fa-search me-2"></i>
                                    Describe Table
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Backup Table -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-download me-2"></i>
                                Backup Table
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?= $view->url('debug/database') ?>">
                                <input type="hidden" name="action" value="backup_table">
                                <div class="mb-3">
                                    <label for="table_name_backup" class="form-label">Table Name:</label>
                                    <select class="form-select" name="table_name" required>
                                        <option value="">Select a table...</option>
                                        <?php foreach ($tables as $table): ?>
                                            <option value="<?= htmlspecialchars($table) ?>"><?= htmlspecialchars($table) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fa-solid fa-save me-2"></i>
                                    Backup Table
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Repair Table -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-wrench me-2"></i>
                                Repair Table
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?= $view->url('debug/database') ?>">
                                <input type="hidden" name="action" value="repair_table">
                                <div class="mb-3">
                                    <label for="table_name_repair" class="form-label">Table Name:</label>
                                    <select class="form-select" name="table_name" required>
                                        <option value="">Select a table...</option>
                                        <?php foreach ($tables as $table): ?>
                                            <option value="<?= htmlspecialchars($table) ?>"><?= htmlspecialchars($table) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fa-solid fa-tools me-2"></i>
                                    Repair Table
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Custom Query Execution -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-terminal me-2"></i>
                                Execute Custom Query
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fa-solid fa-info-circle me-2"></i>
                                <strong>Security Note:</strong> Only SELECT, SHOW, DESCRIBE, and EXPLAIN queries are allowed for security reasons.
                            </div>
                            
                            <form method="POST" action="<?= $view->url('debug/database') ?>">
                                <input type="hidden" name="action" value="execute_query">
                                <div class="mb-3">
                                    <label for="query" class="form-label">SQL Query:</label>
                                    <textarea class="form-control" name="query" rows="4" placeholder="SELECT * FROM users LIMIT 10;" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-dark">
                                    <i class="fa-solid fa-play me-2"></i>
                                    Execute Query
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
                                <?php if ($result['success']): ?>
                                    <div class="alert alert-success">
                                        <i class="fa-solid fa-check-circle me-2"></i>
                                        <strong>Success:</strong> <?= htmlspecialchars($result['message'] ?? 'Operation completed successfully') ?>
                                    </div>
                                    
                                    <?php if (isset($result['data'])): ?>
                                        <?php if (is_array($result['data']) && !empty($result['data'])): ?>
                                            <h6>Data:</h6>
                                            <div class="table-responsive">
                                                <table class="table table-sm table-striped">
                                                    <thead>
                                                        <tr>
                                                            <?php foreach (array_keys($result['data'][0]) as $header): ?>
                                                                <th><?= htmlspecialchars($header) ?></th>
                                                            <?php endforeach; ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($result['data'] as $row): ?>
                                                            <tr>
                                                                <?php foreach ($row as $value): ?>
                                                                    <td>
                                                                        <?php if (is_array($value) || is_object($value)): ?>
                                                                            <code><?= htmlspecialchars(json_encode($value)) ?></code>
                                                                        <?php else: ?>
                                                                            <?= htmlspecialchars($value) ?>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                <?php endforeach; ?>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <?php if (isset($result['rowCount'])): ?>
                                                <p class="text-muted mt-2">
                                                    <small>Total rows: <?= $result['rowCount'] ?></small>
                                                </p>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <p class="text-muted">No data returned.</p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <?php if (isset($result['output'])): ?>
                                        <h6>Output:</h6>
                                        <pre class="bg-light p-3 rounded"><code><?= htmlspecialchars($result['output']) ?></code></pre>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="alert alert-danger">
                                        <i class="fa-solid fa-exclamation-triangle me-2"></i>
                                        <strong>Error:</strong> <?= htmlspecialchars($result['message']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Available Tables -->
            <?php if (!empty($tables)): ?>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fa-solid fa-table me-2"></i>
                                    Available Tables (<?= count($tables) ?>)
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php foreach ($tables as $table): ?>
                                        <div class="col-md-3 col-sm-6 mb-2">
                                            <span class="badge bg-secondary"><?= htmlspecialchars($table) ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
