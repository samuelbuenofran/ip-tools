<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support | IP Tools Suite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .faq-item {
            border-left: 4px solid #007bff;
            margin-bottom: 1rem;
        }
        .contact-card {
            transition: transform 0.2s;
        }
        .contact-card:hover {
            transform: translateY(-2px);
        }
        .feature-icon {
            font-size: 2rem;
            color: #007bff;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="bg-light">
    <?php include('header.php'); ?>

    <div class="container py-4">
        <h2 class="mb-4 text-center">
            <i class="fa-solid fa-headset text-primary"></i> Support Center
        </h2>

        <!-- Quick Help Section -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card contact-card h-100 text-center">
                    <div class="card-body">
                        <div class="feature-icon">
                            <i class="fa-solid fa-question-circle"></i>
                        </div>
                        <h5>Need Help?</h5>
                        <p class="text-muted">Find answers to common questions in our FAQ section below.</p>
                        <a href="#faq" class="btn btn-outline-primary">View FAQ</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card contact-card h-100 text-center">
                    <div class="card-body">
                        <div class="feature-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <h5>Contact Us</h5>
                        <p class="text-muted">Get in touch with our support team for personalized assistance.</p>
                        <a href="#contact" class="btn btn-outline-primary">Contact Support</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card contact-card h-100 text-center">
                    <div class="card-body">
                        <div class="feature-icon">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <h5>Documentation</h5>
                        <p class="text-muted">Learn how to use our tools effectively with detailed guides.</p>
                        <a href="#docs" class="btn btn-outline-primary">View Docs</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div id="faq" class="mb-5">
            <h3 class="mb-4 text-center">
                <i class="fa-solid fa-question-circle text-primary"></i> Frequently Asked Questions
            </h3>
            
            <div class="accordion" id="faqAccordion">
                <!-- Geolocation Tracker FAQ -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            <i class="fa-solid fa-map-pin me-2"></i> How does the Geolocation Tracker work?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p>The Geolocation Tracker creates special links that record visitor information when clicked. It captures:</p>
                            <ul>
                                <li><strong>IP Address:</strong> To identify the visitor's location</li>
                                <li><strong>Geolocation:</strong> Country, city, and approximate coordinates</li>
                                <li><strong>Device Information:</strong> Browser type, device type (mobile/desktop)</li>
                                <li><strong>Referrer:</strong> Where the visitor came from</li>
                            </ul>
                            <p>Simply create a tracking link, share it, and view the results in your dashboard!</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            <i class="fa-solid fa-shield-halved me-2"></i> Is my data secure and private?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p><strong>Yes, absolutely!</strong> We take privacy and security very seriously:</p>
                            <ul>
                                <li>All data is stored securely on our servers</li>
                                <li>We don't collect personal information (names, emails, etc.)</li>
                                <li>Only IP-based location data is collected</li>
                                <li>You have full control over your tracking data</li>
                                <li>We comply with privacy regulations</li>
                            </ul>
                            <p>For more details, see our <a href="privacy.php">Privacy Policy</a>.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            <i class="fa-solid fa-mobile-screen-button me-2"></i> How does the Phone Tracker work?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p>The Phone Tracker allows you to send SMS messages with tracking links:</p>
                            <ol>
                                <li>Enter the phone number and message</li>
                                <li>Add the URL you want to track</li>
                                <li>System generates a tracking link</li>
                                <li>Send the SMS with the tracking link</li>
                                <li>Monitor clicks and engagement in real-time</li>
                            </ol>
                            <p><strong>Note:</strong> You'll need to integrate with an SMS service (like Twilio) for actual message sending.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            <i class="fa-solid fa-gauge-high me-2"></i> How accurate is the Speed Test?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p>Our Speed Test provides accurate measurements of your internet connection:</p>
                            <ul>
                                <li><strong>Download Speed:</strong> How fast you can receive data</li>
                                <li><strong>Upload Speed:</strong> How fast you can send data</li>
                                <li><strong>Ping:</strong> Response time to servers</li>
                                <li><strong>Jitter:</strong> Connection stability</li>
                            </ul>
                            <p>The test uses advanced algorithms to provide reliable results. For best accuracy, close other applications during testing.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                            <i class="fa-solid fa-chart-line me-2"></i> Can I export my tracking data?
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p>Currently, data is viewable through our dashboard interface. We're working on export features including:</p>
                            <ul>
                                <li>CSV export for spreadsheet analysis</li>
                                <li>PDF reports for presentations</li>
                                <li>API access for custom integrations</li>
                                <li>Automated email reports</li>
                            </ul>
                            <p>Contact us if you need specific data export capabilities!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div id="contact" class="mb-5">
            <h3 class="mb-4 text-center">
                <i class="fa-solid fa-envelope text-primary"></i> Contact Support
            </h3>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-envelope"></i> Get in Touch</h5>
                        </div>
                        <div class="card-body">
                            <p>Need help with our tools? We're here to assist you!</p>
                            
                            <div class="mb-3">
                                <h6><i class="fa-solid fa-envelope text-primary"></i> Email Support</h6>
                                <p class="mb-1">For general inquiries and technical support:</p>
                                <a href="mailto:support@keizai-tech.com" class="text-decoration-none">
                                    support@keizai-tech.com
                                </a>
                            </div>
                            
                            <div class="mb-3">
                                <h6><i class="fa-solid fa-clock text-primary"></i> Response Time</h6>
                                <p class="mb-0">We typically respond within 24 hours during business days.</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6><i class="fa-solid fa-globe text-primary"></i> Business Hours</h6>
                                <p class="mb-0">Monday - Friday: 9:00 AM - 6:00 PM (GMT-3)</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-lightbulb"></i> Before Contacting Us</h5>
                        </div>
                        <div class="card-body">
                            <p>To help us assist you faster, please include:</p>
                            <ul>
                                <li><strong>Tool Name:</strong> Which feature you're using</li>
                                <li><strong>Issue Description:</strong> What problem you're experiencing</li>
                                <li><strong>Steps to Reproduce:</strong> How to recreate the issue</li>
                                <li><strong>Browser/Device:</strong> What you're using to access the tool</li>
                                <li><strong>Screenshots:</strong> If applicable, include screenshots</li>
                            </ul>
                            <p class="text-muted small">The more details you provide, the faster we can help!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documentation Section -->
        <div id="docs" class="mb-5">
            <h3 class="mb-4 text-center">
                <i class="fa-solid fa-book text-primary"></i> Documentation & Guides
            </h3>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="feature-icon">
                                <i class="fa-solid fa-map-pin"></i>
                            </div>
                            <h5>Geolocation Tracker Guide</h5>
                            <p class="text-muted">Learn how to create and manage tracking links effectively.</p>
                            <a href="#" class="btn btn-outline-primary">Read Guide</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="feature-icon">
                                <i class="fa-solid fa-mobile-screen-button"></i>
                            </div>
                            <h5>SMS Tracking Setup</h5>
                            <p class="text-muted">Step-by-step guide to set up SMS tracking with popular services.</p>
                            <a href="#" class="btn btn-outline-primary">Read Guide</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="feature-icon">
                                <i class="fa-solid fa-gauge-high"></i>
                            </div>
                            <h5>Speed Test API</h5>
                            <p class="text-muted">Technical documentation for integrating speed testing into your applications.</p>
                            <a href="#" class="btn btn-outline-primary">Read Guide</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="card bg-light">
            <div class="card-body text-center">
                <h5><i class="fa-solid fa-server text-success"></i> System Status</h5>
                <p class="mb-2">All systems are operating normally</p>
                <small class="text-muted">Last updated: <?= date('M j, Y H:i T') ?></small>
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