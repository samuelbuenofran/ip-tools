<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0">
                        <i class="fa-solid fa-envelope me-3"></i>
                        Contato
                    </h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Entre em contato</h2>
                            <p class="lead">
                                Tem dúvidas sobre o IP Tools Suite? Precisa de suporte técnico? Estamos aqui para ajudá-lo a aproveitar ao máximo nossa plataforma.
                            </p>
                            
                            <?php if (isset($error_message)): ?>
                                <div class="alert alert-danger">
                                    <i class="fa-solid fa-exclamation-triangle me-2"></i>
                                    <?= htmlspecialchars($error_message) ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (isset($success_message)): ?>
                                <div class="alert alert-success">
                                    <i class="fa-solid fa-check-circle me-2"></i>
                                    <?= htmlspecialchars($success_message) ?>
                                </div>
                            <?php endif; ?>
                            
                            <form method="POST" action="contact.php">
                                <?= $this->csrf() ?>
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name *</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="name" 
                                           name="name" 
                                           value="<?= htmlspecialchars($form_data['name'] ?? '') ?>" 
                                           required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" 
                                           class="form-control" 
                                           id="email" 
                                           name="email" 
                                           value="<?= htmlspecialchars($form_data['email'] ?? '') ?>" 
                                           required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message *</label>
                                    <textarea class="form-control" 
                                              id="message" 
                                              name="message" 
                                              rows="5" 
                                              required><?= htmlspecialchars($form_data['message'] ?? '') ?></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-paper-plane me-2"></i>
                                    Send Message
                                </button>
                            </form>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h4>Contact Information</h4>
                                    <p class="text-muted">We're here to help you succeed with IP Tools Suite.</p>
                                    
                                    <div class="mb-3">
                                        <h6><i class="fa-solid fa-clock text-primary me-2"></i>Response Time</h6>
                                        <p class="mb-0">We typically respond within 24 hours during business days.</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <h6><i class="fa-solid fa-globe text-primary me-2"></i>Location</h6>
                                        <p class="mb-0">São Paulo, Brazil</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <h6><i class="fa-solid fa-language text-primary me-2"></i>Languages</h6>
                                        <p class="mb-0">English, Portuguese</p>
                                    </div>
                                    
                                    <hr>
                                    
                                    <h6>Other Ways to Get Help</h6>
                                    <div class="d-grid gap-2">
                                        <a href="support.php" class="btn btn-outline-primary btn-sm">
                                            <i class="fa-solid fa-question-circle me-1"></i>
                                            Support Center
                                        </a>
                                        <a href="about.php" class="btn btn-outline-secondary btn-sm">
                                            <i class="fa-solid fa-info-circle me-1"></i>
                                            About Us
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
