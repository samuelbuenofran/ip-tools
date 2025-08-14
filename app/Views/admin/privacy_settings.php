<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa-solid fa-shield-halved"></i> Privacy Settings</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <i class="fa-solid fa-check-circle"></i>
                        <strong>Privacy Settings are Live!</strong> Configure privacy settings and tracking preferences.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Available Settings:</h5>
                            <ul class="list-unstyled">
                                <li><i class="fa-solid fa-eye-slash text-primary me-2"></i> Location tracking message visibility</li>
                                <li><i class="fa-solid fa-user-secret text-success me-2"></i> Stealth mode configuration</li>
                                <li><i class="fa-solid fa-ghost text-warning me-2"></i> Maximum stealth options</li>
                                <li><i class="fa-solid fa-shield-halved text-info me-2"></i> Privacy and security controls</li>
                                <li><i class="fa-solid fa-cog text-secondary me-2"></i> Advanced configuration options</li>
                            </ul>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="/projects/ip-tools/admin/privacy_settings.php" class="btn btn-primary btn-lg">
                                <i class="fa-solid fa-cog"></i> Configure Settings
                            </a>
                            <br><br>
                            <a href="<?= $view->url('admin') ?>" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-arrow-left"></i> Back to Admin
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 