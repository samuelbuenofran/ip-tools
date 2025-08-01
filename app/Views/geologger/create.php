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
                            <a href="<?= $this->url('geologger/logs') ?>" class="btn btn-primary">
                                <i class="fa-solid fa-chart-line"></i> View Logs
                            </a>
                            <a href="<?= $this->url('geologger/create') ?>" class="btn btn-outline-primary">
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
                        
                        <form method="POST" action="<?= $this->url('geologger/create') ?>">
                            <?= $this->csrf() ?>
                            
                            <div class="mb-3">
                                <label for="original_url" class="form-label">Original URL *</label>
                                <input type="url" class="form-control" id="original_url" name="original_url" 
                                       value="<?= $form_data['original_url'] ?? '' ?>" required 
                                       placeholder="https://example.com">
                                <div class="form-text">Enter the URL you want to track visits to.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="expires_at" class="form-label">Expiration Date (Optional)</label>
                                <input type="datetime-local" class="form-control" id="expires_at" name="expires_at"
                                       value="<?= $form_data['expires_at'] ?? '' ?>">
                                <div class="form-text">Leave empty for no expiration.</div>
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