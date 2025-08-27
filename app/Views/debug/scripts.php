<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fa-solid fa-code text-success me-2"></i>
                    Script Debug Tools
                </h1>
                <a href="<?= $view->url('debug') ?>" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>
                    Back to Dashboard
                </a>
            </div>
            
            <!-- Script Testing -->
            <div class="row g-4">
                <!-- Test Script -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-play me-2"></i>
                                Test PHP Script
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?= $view->url('debug/scripts') ?>">
                                <input type="hidden" name="action" value="test_script">
                                <div class="mb-3">
                                    <label for="script_code" class="form-label">PHP Code:</label>
                                    <textarea class="form-control" name="script_code" rows="6" placeholder="echo 'Hello World';&#10;$date = date('Y-m-d H:i:s');&#10;echo 'Current time: ' . $date;" required></textarea>
                                    <div class="form-text">
                                        <small>Note: Dangerous functions like exec(), eval(), file_get_contents() are blocked for security.</small>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fa-solid fa-code me-2"></i>
                                    Test Script
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Execute File -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-file-code me-2"></i>
                                Execute PHP File
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?= $view->url('debug/scripts') ?>">
                                <input type="hidden" name="action" value="execute_file">
                                <div class="mb-3">
                                    <label for="file_name" class="form-label">File Path:</label>
                                    <select class="form-select" name="file_name" required>
                                        <option value="">Select a file...</option>
                                        <?php foreach ($availableFiles as $file): ?>
                                            <option value="<?= htmlspecialchars($file) ?>"><?= htmlspecialchars($file) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="form-text">
                                        <small>Only files in utils/, scripts/, and debug/ directories are allowed.</small>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info w-100">
                                    <i class="fa-solid fa-play me-2"></i>
                                    Execute File
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- PHP Info -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-info-circle me-2"></i>
                                PHP Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?= $view->url('debug/scripts') ?>">
                                <input type="hidden" name="action" value="php_info">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fa-solid fa-server me-2"></i>
                                    Show PHP Info
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
                                        <strong>Success:</strong> Operation completed successfully
                                    </div>
                                    
                                    <?php if (isset($result['output'])): ?>
                                        <h6>Script Output:</h6>
                                        <pre class="bg-light p-3 rounded"><code><?= htmlspecialchars($result['output']) ?></code></pre>
                                    <?php endif; ?>
                                    
                                    <?php if (isset($result['data'])): ?>
                                        <h6>PHP Info:</h6>
                                        <div class="bg-light p-3 rounded" style="max-height: 500px; overflow-y: auto;">
                                            <?= $result['data'] ?>
                                        </div>
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
            
            <!-- Available Files -->
            <?php if (!empty($availableFiles)): ?>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fa-solid fa-folder me-2"></i>
                                    Available Files (<?= count($availableFiles) ?>)
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php foreach ($availableFiles as $file): ?>
                                        <div class="col-md-4 col-sm-6 mb-2">
                                            <span class="badge bg-secondary"><?= htmlspecialchars($file) ?></span>
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
