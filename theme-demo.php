<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Theme Demo - IP Tools Suite</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="/projects/ip-tools/assets/themes.css" rel="stylesheet">
  <script src="/projects/ip-tools/assets/theme-switcher.js" defer></script>
  <style>
    .demo-section {
      margin: 2rem 0;
      padding: 2rem;
      border-radius: 10px;
      background: var(--bg-secondary);
    }
    .component-demo {
      margin: 1rem 0;
      padding: 1rem;
      border: 1px solid var(--border-color);
      border-radius: var(--border-radius);
      background: var(--bg-primary);
    }
    .color-palette {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
      margin: 1rem 0;
    }
    .color-swatch {
      width: 60px;
      height: 60px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
      font-size: 0.8rem;
    }
  </style>
</head>
<body>
  <?php include('header.php'); ?>

  <div class="container py-4">
    <div class="row">
      <div class="col-12">
        <div class="text-center mb-4">
          <img src="/projects/ip-tools/assets/iptoolssuite-logo.png" alt="IP Tools Suite Logo" height="60" class="mb-3">
          <h1 class="mb-0">
            <i class="fa-solid fa-palette text-primary"></i> Theme Demo
          </h1>
        </div>
        <p class="text-center text-muted mb-5">
          Explore the four different themes available in the IP Tools Suite. 
          Use the theme selector in the top-right corner to switch between themes.
        </p>
      </div>
    </div>

         <!-- Logo Showcase -->
     <div class="demo-section">
       <h3><i class="fa-solid fa-image"></i> Logo Showcase</h3>
       <div class="component-demo text-center">
         <div class="row">
           <div class="col-md-6">
             <h5>Header Logo</h5>
             <div class="p-3 border rounded">
               <img src="/projects/ip-tools/assets/iptoolssuite-logo.png" alt="IP Tools Suite Logo" height="40" class="me-2">
               <span class="fw-bold">IP Tools Suite</span>
             </div>
           </div>
           <div class="col-md-6">
             <h5>Footer Logo</h5>
             <div class="p-3 border rounded">
               <img src="/projects/ip-tools/assets/iptoolssuite-logo.png" alt="IP Tools Suite Logo" height="30" class="me-2">
               <span class="fw-bold">IP Tools Suite</span>
             </div>
           </div>
         </div>
       </div>
     </div>

     <!-- Theme Information -->
     <div class="demo-section">
       <h3><i class="fa-solid fa-info-circle"></i> Current Theme</h3>
       <div id="theme-info" class="alert alert-info">
         Loading theme information...
       </div>
     </div>

    <!-- Color Palette -->
    <div class="demo-section">
      <h3><i class="fa-solid fa-paintbrush"></i> Color Palette</h3>
      <div class="color-palette">
        <div class="color-swatch" style="background: var(--primary-color);">Primary</div>
        <div class="color-swatch" style="background: var(--secondary-color);">Secondary</div>
        <div class="color-swatch" style="background: var(--success-color);">Success</div>
        <div class="color-swatch" style="background: var(--danger-color);">Danger</div>
        <div class="color-swatch" style="background: var(--warning-color); color: #000;">Warning</div>
        <div class="color-swatch" style="background: var(--info-color);">Info</div>
      </div>
    </div>

    <!-- Buttons Demo -->
    <div class="demo-section">
      <h3><i class="fa-solid fa-square"></i> Buttons</h3>
      <div class="component-demo">
        <button class="btn btn-primary me-2">Primary Button</button>
        <button class="btn btn-secondary me-2">Secondary Button</button>
        <button class="btn btn-success me-2">Success Button</button>
        <button class="btn btn-danger me-2">Danger Button</button>
        <button class="btn btn-warning me-2">Warning Button</button>
        <button class="btn btn-info me-2">Info Button</button>
        <button class="btn btn-outline-primary me-2">Outline Primary</button>
        <button class="btn btn-outline-secondary me-2">Outline Secondary</button>
      </div>
    </div>

    <!-- Cards Demo -->
    <div class="demo-section">
      <h3><i class="fa-solid fa-credit-card"></i> Cards</h3>
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card Title</h5>
              <p class="card-text">This is a sample card with some content to demonstrate the theme styling.</p>
              <button class="btn btn-primary">Action</button>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Card with Header</h5>
            </div>
            <div class="card-body">
              <p class="card-text">This card has a header section to show different styling options.</p>
            </div>
            <div class="card-footer">
              <small class="text-muted">Card footer</small>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card border-success">
            <div class="card-body">
              <h5 class="card-title text-success">Success Card</h5>
              <p class="card-text">This card uses success colors to demonstrate theme variations.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Forms Demo -->
    <div class="demo-section">
      <h3><i class="fa-solid fa-wpforms"></i> Forms</h3>
      <div class="component-demo">
        <form>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="exampleInput1" class="form-label">Text Input</label>
                <input type="text" class="form-control" id="exampleInput1" placeholder="Enter text here">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="exampleSelect1" class="form-label">Select Dropdown</label>
                <select class="form-select" id="exampleSelect1">
                  <option>Option 1</option>
                  <option>Option 2</option>
                  <option>Option 3</option>
                </select>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="exampleTextarea1" class="form-label">Textarea</label>
            <textarea class="form-control" id="exampleTextarea1" rows="3" placeholder="Enter longer text here"></textarea>
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Checkbox example</label>
          </div>
          <div class="mb-3 form-check">
            <input type="radio" class="form-check-input" id="exampleRadio1" name="radioGroup">
            <label class="form-check-label" for="exampleRadio1">Radio button 1</label>
          </div>
          <div class="mb-3 form-check">
            <input type="radio" class="form-check-input" id="exampleRadio2" name="radioGroup">
            <label class="form-check-label" for="exampleRadio2">Radio button 2</label>
          </div>
          <button type="submit" class="btn btn-primary">Submit Form</button>
        </form>
      </div>
    </div>

    <!-- Alerts Demo -->
    <div class="demo-section">
      <h3><i class="fa-solid fa-triangle-exclamation"></i> Alerts</h3>
      <div class="component-demo">
        <div class="alert alert-primary" role="alert">
          <i class="fa-solid fa-info-circle"></i> This is a primary alert—check it out!
        </div>
        <div class="alert alert-success" role="alert">
          <i class="fa-solid fa-check-circle"></i> This is a success alert—check it out!
        </div>
        <div class="alert alert-warning" role="alert">
          <i class="fa-solid fa-exclamation-triangle"></i> This is a warning alert—check it out!
        </div>
        <div class="alert alert-danger" role="alert">
          <i class="fa-solid fa-times-circle"></i> This is a danger alert—check it out!
        </div>
      </div>
    </div>

    <!-- Tables Demo -->
    <div class="demo-section">
      <h3><i class="fa-solid fa-table"></i> Tables</h3>
      <div class="component-demo">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>John Doe</td>
              <td>john@example.com</td>
              <td><span class="badge bg-success">Active</span></td>
              <td>
                <button class="btn btn-sm btn-primary">Edit</button>
                <button class="btn btn-sm btn-danger">Delete</button>
              </td>
            </tr>
            <tr>
              <td>Jane Smith</td>
              <td>jane@example.com</td>
              <td><span class="badge bg-warning">Pending</span></td>
              <td>
                <button class="btn btn-sm btn-primary">Edit</button>
                <button class="btn btn-sm btn-danger">Delete</button>
              </td>
            </tr>
            <tr>
              <td>Bob Johnson</td>
              <td>bob@example.com</td>
              <td><span class="badge bg-secondary">Inactive</span></td>
              <td>
                <button class="btn btn-sm btn-primary">Edit</button>
                <button class="btn btn-sm btn-danger">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Progress Bars Demo -->
    <div class="demo-section">
      <h3><i class="fa-solid fa-bars-progress"></i> Progress Bars</h3>
      <div class="component-demo">
        <div class="mb-3">
          <label class="form-label">Default Progress</label>
          <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Success Progress</label>
          <div class="progress">
            <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Warning Progress</label>
          <div class="progress">
            <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Danger Progress</label>
          <div class="progress">
            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Theme Features -->
    <div class="demo-section">
      <h3><i class="fa-solid fa-star"></i> Theme Features</h3>
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class="fa-solid fa-palette"></i> Flat Minimalist</h5>
              <ul class="list-unstyled">
                <li><i class="fa-solid fa-check text-success"></i> Clean, minimal design</li>
                <li><i class="fa-solid fa-check text-success"></i> Sharp edges and bold colors</li>
                <li><i class="fa-solid fa-check text-success"></i> No shadows or gradients</li>
                <li><i class="fa-solid fa-check text-success"></i> High contrast elements</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class="fa-solid fa-window-maximize"></i> Frutiger Aero</h5>
              <ul class="list-unstyled">
                <li><i class="fa-solid fa-check text-success"></i> Windows Vista/7 inspired</li>
                <li><i class="fa-solid fa-check text-success"></i> Subtle shadows and depth</li>
                <li><i class="fa-solid fa-check text-success"></i> Professional color scheme</li>
                <li><i class="fa-solid fa-check text-success"></i> Smooth transitions</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class="fa-solid fa-apple-whole"></i> macOS Aqua</h5>
              <ul class="list-unstyled">
                <li><i class="fa-solid fa-check text-success"></i> Apple-inspired design</li>
                <li><i class="fa-solid fa-check text-success"></i> Rounded corners and soft shadows</li>
                <li><i class="fa-solid fa-check text-success"></i> Clean typography</li>
                <li><i class="fa-solid fa-check text-success"></i> Elegant animations</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class="fa-solid fa-gem"></i> Liquid Glass</h5>
              <ul class="list-unstyled">
                <li><i class="fa-solid fa-check text-success"></i> Glassmorphism effects</li>
                <li><i class="fa-solid fa-check text-success"></i> Backdrop blur and transparency</li>
                <li><i class="fa-solid fa-check text-success"></i> Animated elements</li>
                <li><i class="fa-solid fa-check text-success"></i> Modern gradient backgrounds</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include('footer.php'); ?>

  <script>
    // Update theme info when page loads
    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(() => {
        const themeInfo = document.getElementById('theme-info');
        if (themeInfo && window.getThemeInfo) {
          const currentTheme = window.getThemeInfo();
          if (currentTheme) {
            themeInfo.innerHTML = `
              <strong>Current Theme:</strong> ${currentTheme.icon} ${currentTheme.name}<br>
              <small class="text-muted">Theme ID: ${currentTheme.id}</small>
            `;
          }
        }
      }, 100);
    });
  </script>
</body>
</html> 