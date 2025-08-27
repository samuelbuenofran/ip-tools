<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    
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
        
        .search-suggestions {
            margin-top: 2rem;
            padding: 1.5rem;
            background: rgba(108, 117, 125, 0.1);
            border-radius: 10px;
        }
        
        .search-suggestions h6 {
            color: #495057;
            margin-bottom: 1rem;
        }
        
        .suggestion-links {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            justify-content: center;
        }
        
        .suggestion-links a {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }
        
        .suggestion-links a:hover {
            background: rgba(102, 126, 234, 0.2);
            transform: translateY(-1px);
            color: #667eea;
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
                    <div class="error-code">404</div>
                    
                    <!-- Error Message -->
                    <h1 class="error-message">Page Not Found</h1>
                    
                    <!-- Error Description -->
                    <p class="error-description">
                        The page you're looking for doesn't exist. It might have been moved, deleted, or you entered the wrong URL.
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
                    
                    <!-- Search Suggestions -->
                    <div class="search-suggestions">
                        <h6>Popular Pages:</h6>
                        <div class="suggestion-links">
                            <a href="/projects/ip-tools/public/">Home</a>
                            <a href="/projects/ip-tools/public/about">About</a>
                            <a href="/projects/ip-tools/public/contact">Contact</a>
                            <a href="/projects/ip-tools/public/support">Support</a>
                            <a href="/projects/ip-tools/public/geologger/create">Create Link</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
