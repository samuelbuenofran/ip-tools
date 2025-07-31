<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy | IP Tools Suite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .privacy-section {
            border-left: 4px solid #007bff;
            padding-left: 1rem;
            margin-bottom: 2rem;
        }
        .privacy-card {
            transition: transform 0.2s;
        }
        .privacy-card:hover {
            transform: translateY(-2px);
        }
        .last-updated {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body class="bg-light">
    <?php include('header.php'); ?>

    <div class="container py-4">
        <h2 class="mb-4 text-center">
            <i class="fa-solid fa-shield-halved text-primary"></i> Privacy Policy
        </h2>

        <!-- Last Updated Notice -->
        <div class="last-updated text-center">
            <h5><i class="fa-solid fa-calendar-alt text-primary"></i> Last Updated</h5>
            <p class="mb-0">This privacy policy was last updated on <?= date('F j, Y') ?></p>
        </div>

        <!-- Introduction -->
        <div class="privacy-section">
            <h3><i class="fa-solid fa-info-circle text-primary"></i> Introduction</h3>
            <p>At Keizai Tech, we are committed to protecting your privacy and ensuring the security of your data. This Privacy Policy explains how we collect, use, and safeguard information when you use our IP Tools Suite.</p>
            <p>By using our services, you agree to the collection and use of information in accordance with this policy. We will not use or share your information with anyone except as described in this Privacy Policy.</p>
        </div>

        <!-- Information We Collect -->
        <div class="privacy-section">
            <h3><i class="fa-solid fa-database text-primary"></i> Information We Collect</h3>
            
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card privacy-card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-map-marker-alt"></i> Geolocation Data</h5>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li><strong>IP Address:</strong> To identify approximate location</li>
                                <li><strong>Country & City:</strong> Based on IP geolocation</li>
                                <li><strong>Coordinates:</strong> Approximate latitude and longitude</li>
                                <li><strong>Device Type:</strong> Mobile, desktop, or tablet</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card privacy-card h-100">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-chart-line"></i> Usage Analytics</h5>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li><strong>Browser Information:</strong> User agent and browser type</li>
                                <li><strong>Referrer Data:</strong> Where visitors came from</li>
                                <li><strong>Click Timestamps:</strong> When links were accessed</li>
                                <li><strong>Speed Test Results:</strong> Internet performance data</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-info">
                <h6><i class="fa-solid fa-exclamation-triangle"></i> Important Note</h6>
                <p class="mb-0">We do <strong>NOT</strong> collect personal information such as names, email addresses, phone numbers, or any other personally identifiable information unless explicitly provided by you.</p>
            </div>
        </div>

        <!-- How We Use Information -->
        <div class="privacy-section">
            <h3><i class="fa-solid fa-cogs text-primary"></i> How We Use Your Information</h3>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="fa-solid fa-chart-bar text-primary" style="font-size: 2rem;"></i>
                            <h5 class="mt-3">Analytics & Insights</h5>
                            <p class="text-muted">Generate reports and analytics to help you understand your audience and improve your campaigns.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="fa-solid fa-shield-alt text-primary" style="font-size: 2rem;"></i>
                            <h5 class="mt-3">Security & Fraud Prevention</h5>
                            <p class="text-muted">Detect and prevent fraudulent activities, spam, and abuse of our services.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="fa-solid fa-tools text-primary" style="font-size: 2rem;"></i>
                            <h5 class="mt-3">Service Improvement</h5>
                            <p class="text-muted">Improve our tools, fix bugs, and develop new features based on usage patterns.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Security -->
        <div class="privacy-section">
            <h3><i class="fa-solid fa-lock text-primary"></i> Data Security</h3>
            
            <div class="card">
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h5><i class="fa-solid fa-server text-success"></i> Technical Safeguards</h5>
                            <ul>
                                <li>All data is encrypted in transit using HTTPS</li>
                                <li>Database access is restricted and monitored</li>
                                <li>Regular security audits and updates</li>
                                <li>Secure hosting with industry-standard protection</li>
                            </ul>
                        </div>
                        
                        <div class="col-md-6">
                            <h5><i class="fa-solid fa-user-shield text-success"></i> Privacy Measures</h5>
                            <ul>
                                <li>No personal information is collected</li>
                                <li>IP addresses are anonymized where possible</li>
                                <li>Data retention policies are strictly enforced</li>
                                <li>Access to data is limited to authorized personnel</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Sharing -->
        <div class="privacy-section">
            <h3><i class="fa-solid fa-share-alt text-primary"></i> Data Sharing & Third Parties</h3>
            
            <div class="alert alert-warning">
                <h6><i class="fa-solid fa-exclamation-triangle"></i> Our Commitment</h6>
                <p class="mb-0">We do not sell, trade, or otherwise transfer your data to third parties for marketing purposes.</p>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h5>When We May Share Data:</h5>
                    <ul>
                        <li><strong>Service Providers:</strong> Only with trusted third-party services necessary for our operations (hosting, analytics)</li>
                        <li><strong>Legal Requirements:</strong> When required by law or to protect our rights and safety</li>
                        <li><strong>Business Transfers:</strong> In case of merger, acquisition, or sale of assets (with notice)</li>
                        <li><strong>With Your Consent:</strong> Only when you explicitly authorize us to do so</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Your Rights -->
        <div class="privacy-section">
            <h3><i class="fa-solid fa-user-check text-primary"></i> Your Rights & Choices</h3>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-eye"></i> Access & Control</h5>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li><strong>View Your Data:</strong> Access all data we have about your usage</li>
                                <li><strong>Delete Data:</strong> Request deletion of your tracking data</li>
                                <li><strong>Export Data:</strong> Download your data in standard formats</li>
                                <li><strong>Opt-Out:</strong> Stop data collection for specific features</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-cog"></i> Privacy Controls</h5>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li><strong>Browser Settings:</strong> Control cookies and tracking</li>
                                <li><strong>VPN Usage:</strong> Use VPN to mask your IP address</li>
                                <li><strong>Private Browsing:</strong> Use incognito/private mode</li>
                                <li><strong>Contact Us:</strong> Email us for privacy concerns</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cookies & Tracking -->
        <div class="privacy-section">
            <h3><i class="fa-solid fa-cookie-bite text-primary"></i> Cookies & Tracking Technologies</h3>
            
            <div class="card">
                <div class="card-body">
                    <h5>What We Use:</h5>
                    <ul>
                        <li><strong>Session Cookies:</strong> To maintain your login session and preferences</li>
                        <li><strong>Analytics Cookies:</strong> To understand how our tools are used</li>
                        <li><strong>Security Cookies:</strong> To protect against fraud and abuse</li>
                    </ul>
                    
                    <h5 class="mt-4">Managing Cookies:</h5>
                    <p>You can control cookies through your browser settings. However, disabling certain cookies may affect the functionality of our tools.</p>
                </div>
            </div>
        </div>

        <!-- Data Retention -->
        <div class="privacy-section">
            <h3><i class="fa-solid fa-clock text-primary"></i> Data Retention</h3>
            
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Retention Periods:</h5>
                            <ul>
                                <li><strong>Tracking Data:</strong> 12 months from last activity</li>
                                <li><strong>Speed Test Results:</strong> 6 months</li>
                                <li><strong>Analytics Data:</strong> 24 months (aggregated)</li>
                                <li><strong>Log Files:</strong> 30 days</li>
                            </ul>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Data Deletion:</h5>
                            <ul>
                                <li>Automatic deletion after retention periods</li>
                                <li>Manual deletion upon request</li>
                                <li>Account deletion removes all associated data</li>
                                <li>Backup data deleted within 30 days</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Children's Privacy -->
        <div class="privacy-section">
            <h3><i class="fa-solid fa-baby text-primary"></i> Children's Privacy</h3>
            
            <div class="alert alert-warning">
                <h6><i class="fa-solid fa-exclamation-triangle"></i> Important Notice</h6>
                <p class="mb-0">Our services are not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13. If you are a parent or guardian and believe your child has provided us with personal information, please contact us immediately.</p>
            </div>
        </div>

        <!-- International Users -->
        <div class="privacy-section">
            <h3><i class="fa-solid fa-globe text-primary"></i> International Users</h3>
            
            <div class="card">
                <div class="card-body">
                    <p>Our services are hosted in Brazil and may be accessed by users worldwide. By using our services, you consent to the transfer of your information to Brazil and other countries where our service providers are located.</p>
                    
                    <h5>GDPR Compliance:</h5>
                    <p>For users in the European Union, we comply with GDPR requirements including:</p>
                    <ul>
                        <li>Right to access and portability</li>
                        <li>Right to rectification and erasure</li>
                        <li>Right to restrict processing</li>
                        <li>Right to data portability</li>
                        <li>Right to object to processing</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Changes to Policy -->
        <div class="privacy-section">
            <h3><i class="fa-solid fa-edit text-primary"></i> Changes to This Privacy Policy</h3>
            
            <div class="card">
                <div class="card-body">
                    <p>We may update this Privacy Policy from time to time. We will notify you of any changes by:</p>
                    <ul>
                        <li>Posting the new Privacy Policy on this page</li>
                        <li>Updating the "Last Updated" date</li>
                        <li>Sending email notifications for significant changes</li>
                        <li>Displaying prominent notices on our website</li>
                    </ul>
                    <p>Your continued use of our services after any changes constitutes acceptance of the new Privacy Policy.</p>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="privacy-section">
            <h3><i class="fa-solid fa-envelope text-primary"></i> Contact Us</h3>
            
            <div class="card">
                <div class="card-body">
                    <p>If you have any questions about this Privacy Policy or our data practices, please contact us:</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fa-solid fa-envelope text-primary"></i> Email</h6>
                            <p><a href="mailto:privacy@keizai-tech.com">privacy@keizai-tech.com</a></p>
                        </div>
                        
                        <div class="col-md-6">
                            <h6><i class="fa-solid fa-globe text-primary"></i> Website</h6>
                            <p><a href="https://keizai-tech.com">https://keizai-tech.com</a></p>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mt-3">
                        <h6><i class="fa-solid fa-clock text-primary"></i> Response Time</h6>
                        <p class="mb-0">We aim to respond to privacy-related inquiries within 48 hours during business days.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="text-center mt-5">
            <h4><i class="fa-solid fa-tasks text-primary"></i> Quick Actions</h4>
            <div class="row g-3 justify-content-center">
                <div class="col-md-3">
                    <a href="mailto:privacy@keizai-tech.com" class="btn btn-outline-primary w-100">
                        <i class="fa-solid fa-envelope"></i> Contact Privacy Team
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="support.php" class="btn btn-outline-success w-100">
                        <i class="fa-solid fa-headset"></i> Get Support
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="index.php" class="btn btn-outline-info w-100">
                        <i class="fa-solid fa-home"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme toggle logic
        const body = document.body;
        const btn = document.getElementById('toggleTheme');
        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('bg-dark', 'text-light');
        }
        btn?.addEventListener('click', () => {
            body.classList.toggle('bg-dark');
            body.classList.toggle('text-light');
            localStorage.setItem('theme', body.classList.contains('bg-dark') ? 'dark' : 'light');
        });
    </script>
</body>
</html> 