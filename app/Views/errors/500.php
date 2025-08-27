<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Internal Server Error</title>
    
    <!-- Error Stop Icon as Favicon -->
    <link rel="icon" type="image/svg+xml" href="/projects/ip-tools/assets/icons/error-stop.svg">
    <link rel="alternate icon" href="/projects/ip-tools/assets/icons/error-stop.svg">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="/projects/ip-tools/assets/themes.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .error-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .error-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .error-code {
            font-size: 4rem;
            font-weight: bold;
            color: #dc3545;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .error-message {
            font-size: 1.5rem;
            color: #6c757d;
            margin-bottom: 2rem;
        }
        
        .error-description {
            color: #6c757d;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-home {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            color: white;
        }
        
        .btn-back {
            background: transparent;
            border: 2px solid #667eea;
            color: #667eea;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-back:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        
        .technical-details {
            margin-top: 2rem;
            padding: 1rem;
            background: rgba(108, 117, 125, 0.1);
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            color: #6c757d;
            text-align: left;
        }
        
        .technical-details h6 {
            color: #495057;
            margin-bottom: 0.5rem;
        }
        
        @media (max-width: 768px) {
            .error-container {
                margin: 1rem;
                padding: 2rem;
            }
            
            .error-code {
                font-size: 3rem;
            }
            
            .error-message {
                font-size: 1.2rem;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="error-container">
                    <!-- Error Stop Icon -->
                    <img src="/projects/ip-tools/assets/icons/error-stop.svg" alt="Error" class="error-icon">
                    
                    <!-- Error Code -->
                    <div class="error-code">500</div>
                    
                    <!-- Error Message -->
                    <h1 class="error-message">Internal Server Error</h1>
                    
                    <!-- Error Description -->
                    <p class="error-description">
                        Oops! Something went wrong on our end. Our team has been notified and is working to fix the issue.
                        Please try again in a few moments.
                    </p>
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="/projects/ip-tools/public/" class="btn btn-home">
                            <i class="fa-solid fa-home me-2"></i>
                            Go Home
                        </a>
                        <button onclick="history.back()" class="btn btn-back">
                            <i class="fa-solid fa-arrow-left me-2"></i>
                            Go Back
                        </button>
                    </div>
                    
                                                <!-- Technical Details (for debugging) -->
                            <?php if (isset($error_details) && is_array($error_details)): ?>
                                <div class="technical-details">
                                    <h6>Technical Details:</h6>
                                    <div><strong>Error:</strong> <?= htmlspecialchars($error_details['message'] ?? 'Unknown error') ?></div>
                                    <div><strong>File:</strong> <?= htmlspecialchars($error_details['file'] ?? 'Unknown') ?></div>
                                    <div><strong>Line:</strong> <?= htmlspecialchars($error_details['line'] ?? 'Unknown') ?></div>
                                    <div><strong>Time:</strong> <?= date('Y-m-d H:i:s') ?></div>
                                </div>
                            <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
