<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JavaFX-Style Buttons Demo - IP Tools Suite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/javafx-buttons.css" rel="stylesheet">
    <style>
        .demo-section {
            margin-bottom: 3rem;
            padding: 2rem;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            background: #f8f9fa;
        }
        .button-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }
        .button-showcase {
            text-align: center;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .code-example {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 1rem;
            margin: 1rem 0;
            font-family: monospace;
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-4">
        <h1 class="text-center mb-5">
            <i class="fa-solid fa-cube text-primary"></i> JavaFX-Style 3D Buttons Demo
        </h1>
        
        <div class="alert alert-info">
            <i class="fa-solid fa-info-circle"></i>
            <strong>Welcome to the JavaFX Button Showcase!</strong> This page demonstrates all the available JavaFX-style button variants with their 3D effects, hover animations, and interactive features.
        </div>

        <!-- Basic Button Variants -->
        <div class="demo-section">
            <h2><i class="fa-solid fa-palette text-primary"></i> Basic Button Variants</h2>
            <p class="text-muted">Standard button styles with JavaFX 3D effects</p>
            
            <div class="button-grid">
                <div class="button-showcase">
                    <button class="btn btn-primary btn-javafx">
                        <i class="fa-solid fa-star"></i> Primary
                    </button>
                    <div class="code-example">class="btn btn-primary btn-javafx"</div>
                </div>
                
                <div class="button-showcase">
                    <button class="btn btn-success btn-javafx">
                        <i class="fa-solid fa-check"></i> Success
                    </button>
                    <div class="code-example">class="btn btn-success btn-javafx"</div>
                </div>
                
                <div class="button-showcase">
                    <button class="btn btn-warning btn-javafx">
                        <i class="fa-solid fa-exclamation-triangle"></i> Warning
                    </button>
                    <div class="code-example">class="btn btn-warning btn-javafx"</div>
                </div>
                
                <div class="button-showcase">
                    <button class="btn btn-danger btn-javafx">
                        <i class="fa-solid fa-times"></i> Danger
                    </button>
                    <div class="code-example">class="btn btn-danger btn-javafx"</div>
                </div>
                
                <div class="button-showcase">
                    <button class="btn btn-info btn-javafx">
                        <i class="fa-solid fa-info-circle"></i> Info
                    </button>
                    <div class="code-example">class="btn btn-info btn-javafx"</div>
                </div>
                
                <div class="button-showcase">
                    <button class="btn btn-secondary btn-javafx">
                        <i class="fa-solid fa-cog"></i> Secondary
                    </button>
                    <div class="code-example">class="btn btn-secondary btn-javafx"</div>
                </div>
            </div>
        </div>

        <!-- Outline Button Variants -->
        <div class="demo-section">
            <h2><i class="fa-solid fa-border-style text-success"></i> Outline Button Variants</h2>
            <p class="text-muted">Outline buttons that fill with color on hover</p>
            
            <div class="button-grid">
                <div class="button-showcase">
                    <button class="btn btn-outline-primary btn-javafx">
                        <i class="fa-solid fa-star"></i> Outline Primary
                    </button>
                    <div class="code-example">class="btn btn-outline-primary btn-javafx"</div>
                </div>
                
                <div class="button-showcase">
                    <button class="btn btn-outline-success btn-javafx">
                        <i class="fa-solid fa-check"></i> Outline Success
                    </button>
                    <div class="code-example">class="btn btn-outline-success btn-javafx"</div>
                </div>
                
                <div class="button-showcase">
                    <button class="btn btn-outline-warning btn-javafx">
                        <i class="fa-solid fa-exclamation-triangle"></i> Outline Warning
                    </button>
                    <div class="code-example">class="btn btn-outline-warning btn-javafx"</div>
                </div>
                
                <div class="button-showcase">
                    <button class="btn btn-outline-info btn-javafx">
                        <i class="fa-solid fa-info-circle"></i> Outline Info
                    </button>
                    <div class="code-example">class="btn btn-outline-info btn-javafx"</div>
                </div>
            </div>
        </div>

        <!-- Button Sizes -->
        <div class="demo-section">
            <h2><i class="fa-solid fa-expand-arrows-alt text-warning"></i> Button Sizes</h2>
            <p class="text-muted">Different button sizes with JavaFX styling</p>
            
            <div class="button-grid">
                <div class="button-showcase">
                    <button class="btn btn-primary btn-javafx btn-sm">
                        <i class="fa-solid fa-star"></i> Small
                    </button>
                    <div class="code-example">class="btn btn-primary btn-javafx btn-sm"</div>
                </div>
                
                <div class="button-showcase">
                    <button class="btn btn-primary btn-javafx">
                        <i class="fa-solid fa-star"></i> Default
                    </button>
                    <div class="code-example">class="btn btn-primary btn-javafx"</div>
                </div>
                
                <div class="button-showcase">
                    <button class="btn btn-primary btn-javafx btn-lg">
                        <i class="fa-solid fa-star"></i> Large
                    </button>
                    <div class="code-example">class="btn btn-primary btn-javafx btn-lg"</div>
                </div>
            </div>
        </div>

        <!-- Interactive Features -->
        <div class="demo-section">
            <h2><i class="fa-solid fa-magic text-danger"></i> Interactive Features</h2>
            <p class="text-muted">Demonstrating loading states, success, and error effects</p>
            
            <div class="button-grid">
                <div class="button-showcase">
                    <button class="btn btn-primary btn-javafx" onclick="demoLoading(this)">
                        <i class="fa-solid fa-download"></i> Loading Demo
                    </button>
                    <div class="code-example">setButtonLoading(button, true/false)</div>
                </div>
                
                <div class="button-showcase">
                    <button class="btn btn-success btn-javafx" onclick="demoSuccess(this)">
                        <i class="fa-solid fa-check"></i> Success Demo
                    </button>
                    <div class="code-example">setButtonSuccess(button, 'Message')</div>
                </div>
                
                <div class="button-showcase">
                    <button class="btn btn-danger btn-javafx" onclick="demoError(this)">
                        <i class="fa-solid fa-times"></i> Error Demo
                    </button>
                    <div class="code-example">setButtonError(button, 'Message')</div>
                </div>
                
                <div class="button-showcase">
                    <button class="btn btn-warning btn-javafx" onclick="demoRipple(this)">
                        <i class="fa-solid fa-water"></i> Ripple Effect
                    </button>
                    <div class="code-example">Automatic on click</div>
                </div>
            </div>
        </div>

        <!-- Dark and Light Variants -->
        <div class="demo-section">
            <h2><i class="fa-solid fa-adjust text-info"></i> Dark and Light Variants</h2>
            <p class="text-muted">Special button styles for different themes</p>
            
            <div class="button-grid">
                <div class="button-showcase">
                    <button class="btn btn-dark btn-javafx">
                        <i class="fa-solid fa-moon"></i> Dark
                    </button>
                    <div class="code-example">class="btn btn-dark btn-javafx"</div>
                </div>
                
                <div class="button-showcase">
                    <button class="btn btn-light btn-javafx">
                        <i class="fa-solid fa-sun"></i> Light
                    </button>
                    <div class="code-example">class="btn btn-light btn-javafx"</div>
                </div>
            </div>
        </div>

        <!-- Usage Instructions -->
        <div class="demo-section">
            <h2><i class="fa-solid fa-book text-secondary"></i> How to Use</h2>
            <div class="row">
                <div class="col-md-6">
                    <h5>1. Include CSS and JS</h5>
                    <div class="code-example">
&lt;link href="assets/javafx-buttons.css" rel="stylesheet"&gt;
&lt;script src="assets/javafx-buttons.js"&gt;&lt;/script&gt;
                    </div>
                    
                    <h5>2. Add Button Classes</h5>
                    <div class="code-example">
&lt;button class="btn btn-primary btn-javafx"&gt;
    &lt;i class="fa-solid fa-star"&gt;&lt;/i&gt; My Button
&lt;/button&gt;
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h5>3. JavaScript Functions</h5>
                    <div class="code-example">
// Loading state
setButtonLoading(button, true);

// Success state
setButtonSuccess(button, 'Success!');

// Error state
setButtonError(button, 'Error!');

// Auto-convert existing buttons
convertToJavaFX('.my-buttons');
                    </div>
                    
                    <h5>4. Features</h5>
                    <ul>
                        <li>3D gradient backgrounds</li>
                        <li>Hover lift effects</li>
                        <li>Click ripple animation</li>
                        <li>Icon scaling on hover</li>
                        <li>Loading states</li>
                        <li>Success/Error feedback</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Auto-Conversion Demo -->
        <div class="demo-section">
            <h2><i class="fa-solid fa-sync text-primary"></i> Auto-Conversion Demo</h2>
            <p class="text-muted">Convert existing Bootstrap buttons to JavaFX style</p>
            
            <div class="button-grid">
                <div class="button-showcase">
                    <button class="btn btn-primary" id="convertDemo">
                        <i class="fa-solid fa-magic"></i> Convert Me!
                    </button>
                    <div class="code-example">Standard Bootstrap button</div>
                </div>
                
                <div class="button-showcase">
                    <button class="btn btn-success" id="convertDemo2">
                        <i class="fa-solid fa-wand-magic-sparkles"></i> Me Too!
                    </button>
                    <div class="code-example">Another standard button</div>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <button class="btn btn-warning btn-javafx" onclick="convertDemoButtons()">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> Convert All Demo Buttons
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/javafx-buttons.js"></script>
    <script>
        // Demo functions
        function demoLoading(button) {
            setButtonLoading(button, true);
            setTimeout(() => setButtonLoading(button, false), 2000);
        }
        
        function demoSuccess(button) {
            setButtonSuccess(button, 'Great!');
        }
        
        function demoError(button) {
            setButtonError(button, 'Oops!');
        }
        
        function demoRipple(button) {
            // Ripple effect is automatic
            button.innerHTML = '<i class="fa-solid fa-water"></i> Splash!';
            setTimeout(() => {
                button.innerHTML = '<i class="fa-solid fa-water"></i> Ripple Effect';
            }, 1000);
        }
        
        function convertDemoButtons() {
            convertToJavaFX('#convertDemo, #convertDemo2');
            document.querySelector('.btn-warning').innerHTML = '<i class="fa-solid fa-check"></i> Converted!';
        }
        
        // Auto-convert on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Convert any remaining standard buttons
            convertToJavaFX('.btn:not(.btn-javafx)');
        });
    </script>
</body>
</html>
