<?php $this->layout('layouts/main'); ?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0">
                        <i class="fa-solid fa-question-circle me-3"></i>
                        Support Center
                    </h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>How Can We Help You?</h2>
                            <p class="lead">
                                Find answers to common questions, troubleshoot issues, and get the support you need 
                                to make the most of IP Tools Suite.
                            </p>
                            
                            <h3>Frequently Asked Questions</h3>
                            
                            <div class="accordion" id="faqAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq1">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                            How do I create a tracking link?
                                        </button>
                                    </h2>
                                    <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p>Creating a tracking link is simple:</p>
                                            <ol>
                                                <li>Go to the "Create Tracking Link" page</li>
                                                <li>Enter the URL you want to track (e.g., youtube.com)</li>
                                                <li>Set expiration and click limits if needed</li>
                                                <li>Click "Create Tracking Link"</li>
                                                <li>Copy and share your generated tracking URL</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq2">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                            What data is collected when someone clicks my link?
                                        </button>
                                    </h2>
                                    <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p>When someone clicks your tracking link, we collect:</p>
                                            <ul>
                                                <li>IP address (for geolocation)</li>
                                                <li>User agent (browser/device info)</li>
                                                <li>Referrer (where they came from)</li>
                                                <li>Timestamp of the click</li>
                                                <li>GPS coordinates (if permission granted)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq3">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                            How accurate is the geolocation tracking?
                                        </button>
                                    </h2>
                                    <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p>Geolocation accuracy depends on the method used:</p>
                                            <ul>
                                                <li><strong>IP-based:</strong> City/region level (usually accurate within 50-100km)</li>
                                                <li><strong>GPS tracking:</strong> Very accurate (within 10-50 meters)</li>
                                                <li><strong>Browser geolocation:</strong> High accuracy (within 10-100 meters)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq4">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                            Can I delete my tracking data?
                                        </button>
                                    </h2>
                                    <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p>Yes, you have full control over your data:</p>
                                            <ul>
                                                <li>Delete individual tracking links</li>
                                                <li>Remove specific log entries</li>
                                                <li>Clear all data for a link</li>
                                                <li>Export your data before deletion</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq5">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5">
                                            Is my data secure and private?
                                        </button>
                                    </h2>
                                    <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p>Absolutely! We take data security seriously:</p>
                                            <ul>
                                                <li>All data is encrypted in transit and at rest</li>
                                                <li>Access is limited to authorized personnel only</li>
                                                <li>We never sell or share your data with third parties</li>
                                                <li>Regular security audits and updates</li>
                                                <li>GDPR and privacy law compliant</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <h3 class="mt-4">Still Need Help?</h3>
                            <p>
                                If you couldn't find the answer you're looking for, our support team is here to help. 
                                Contact us and we'll get back to you as soon as possible.
                            </p>
                            
                            <a href="contact.php" class="btn btn-primary">
                                <i class="fa-solid fa-envelope me-2"></i>
                                Contact Support
                            </a>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h4>Quick Support</h4>
                                    <p class="text-muted">Get help faster with these resources.</p>
                                    
                                    <div class="mb-3">
                                        <h6><i class="fa-solid fa-book text-primary me-2"></i>Documentation</h6>
                                        <p class="mb-0">Comprehensive guides and tutorials.</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <h6><i class="fa-solid fa-video text-primary me-2"></i>Video Tutorials</h6>
                                        <p class="mb-0">Step-by-step video guides.</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <h6><i class="fa-solid fa-users text-primary me-2"></i>Community</h6>
                                        <p class="mb-0">Connect with other users.</p>
                                    </div>
                                    
                                    <hr>
                                    
                                    <h6>Contact Options</h6>
                                    <div class="d-grid gap-2">
                                        <a href="contact.php" class="btn btn-outline-primary btn-sm">
                                            <i class="fa-solid fa-envelope me-1"></i>
                                            Email Support
                                        </a>
                                        <a href="about.php" class="btn btn-outline-secondary btn-sm">
                                            <i class="fa-solid fa-info-circle me-1"></i>
                                            About Us
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h5>System Status</h5>
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-success me-2">●</span>
                                        <span>All systems operational</span>
                                    </div>
                                    <small class="text-muted">Last updated: <?= date('M j, g:i A') ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
