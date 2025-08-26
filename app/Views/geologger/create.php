<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa-solid fa-map-pin"></i> Create Tracking Link</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($success) && $success): ?>
                        <div class="alert alert-success">
                            <i class="fa-solid fa-check-circle"></i>
                            <strong>Success!</strong> Your tracking link has been created.
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Tracking Link</h5>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="<?= $link['tracking_url'] ?>" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('<?= $link['tracking_url'] ?>')">
                                        <i class="fa-solid fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>QR Code</h5>
                                <div class="text-center">
                                    <img src="<?= $link['qr_code_url'] ?>" alt="QR Code" class="img-fluid" style="max-width: 200px;">
                                    <br>
                                    <button class="btn btn-sm btn-outline-primary mt-2" onclick="downloadQRCode('<?= $link['qr_code_url'] ?>')">
                                        <i class="fa-solid fa-download"></i> Download QR Code
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="<?= $view->url('geologger/logs') ?>" class="btn btn-primary">
                                <i class="fa-solid fa-chart-line"></i> View Logs
                            </a>
                            <a href="<?= $view->url('geologger/my-links') ?>" class="btn btn-info">
                                <i class="fa-solid fa-link"></i> Ver Meus Links
                            </a>
                            <a href="<?= $view->url('geologger/create') ?>" class="btn btn-outline-primary">
                                <i class="fa-solid fa-plus"></i> Create Another Link
                            </a>
                        </div>
                    <?php else: ?>
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <i class="fa-solid fa-exclamation-triangle"></i>
                                <strong>Error:</strong> <?= implode(', ', $errors) ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="<?= $view->url('geologger/create') ?>">
                            <?= $view->csrf() ?>
                            
                            <div class="mb-3">
                                <label for="original_url" class="form-label">Original URL *</label>
                                <input type="url" class="form-control" id="original_url" name="original_url" 
                                       value="<?= $form_data['original_url'] ?? '' ?>" required 
                                       placeholder="https://example.com">
                                <div class="form-text">Enter the URL you want to track visits to.</div>
                            </div>
                            
                            <!-- Expiration Settings -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fa-solid fa-clock"></i> Expiration Settings</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Checkbox for no expiration -->
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="noExpiration" name="no_expiration" value="1"
                                               <?= ($form_data['no_expiration'] ?? false) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="noExpiration">
                                            <strong>Meu link não expira</strong> (My link doesn't expire)
                                        </label>
                                    </div>
                                    
                                    <!-- Date picker (hidden when no expiration is checked) -->
                                    <div id="expirationDateGroup" class="mb-3">
                                        <label for="expires_at" class="form-label">
                                            <i class="fa-solid fa-calendar"></i> Expira em (Expires on):
                                        </label>
                                        <input type="datetime-local" class="form-control" id="expires_at" name="expires_at"
                                               value="<?= $form_data['expires_at'] ?? date('Y-m-d\TH:i', strtotime('+30 days')) ?>"
                                               min="<?= date('Y-m-d\TH:i') ?>">
                                        <div class="form-text">Deixe em branco para não expirar (Leave blank to never expire)</div>
                                    </div>
                                    
                                    <!-- Click limit -->
                                    <div class="mb-3">
                                        <label for="click_limit" class="form-label">
                                            <i class="fa-solid fa-mouse-pointer"></i> Limite de cliques (Click limit):
                                        </label>
                                        <input type="number" class="form-control" id="click_limit" name="click_limit" 
                                               min="1" max="10000" placeholder="Sem limite (No limit)"
                                               value="<?= $form_data['click_limit'] ?? '' ?>">
                                        <div class="form-text">Deixe em branco para sem limite (Leave blank for no limit)</div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-plus"></i> Create Tracking Link
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Handle expiration checkbox
document.addEventListener('DOMContentLoaded', function() {
    const noExpirationCheckbox = document.getElementById('noExpiration');
    const expirationDateGroup = document.getElementById('expirationDateGroup');
    
    if (noExpirationCheckbox && expirationDateGroup) {
        // Initial state
        updateExpirationVisibility();
        
        // Listen for changes
        noExpirationCheckbox.addEventListener('change', updateExpirationVisibility);
    }
    
    function updateExpirationVisibility() {
        if (noExpirationCheckbox.checked) {
            expirationDateGroup.style.display = 'none';
            // Clear the date value when hidden
            document.getElementById('expires_at').value = '';
        } else {
            expirationDateGroup.style.display = 'block';
            // Set default date if empty
            if (!document.getElementById('expires_at').value) {
                const defaultDate = new Date();
                defaultDate.setDate(defaultDate.getDate() + 30);
                document.getElementById('expires_at').value = defaultDate.toISOString().slice(0, 16);
            }
        }
    }
});

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fa-solid fa-check"></i>';
        button.classList.remove('btn-outline-secondary');
        button.classList.add('btn-success');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-secondary');
        }, 2000);
    });
}

function downloadQRCode(url) {
    const link = document.createElement('a');
    link.href = url;
    link.download = 'qr-code.png';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script> 