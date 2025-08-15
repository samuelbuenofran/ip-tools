// ===== SIMPLE DROPDOWN FIX =====
// This is a simplified, bulletproof fix for dropdown overlay issues

console.log('Simple Dropdown Fix loaded');

// Function to force dropdown styles
function forceDropdownStyles() {
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(dropdown => {
        const dropdownMenu = dropdown.querySelector('.dropdown-menu');
        if (dropdownMenu) {
            // Force maximum z-index
            dropdownMenu.style.zIndex = '999999';
            dropdownMenu.style.position = 'absolute';
            dropdownMenu.style.background = '#007bff';
            dropdownMenu.style.border = '2px solid #ffffff';
            dropdownMenu.style.borderRadius = '8px';
            dropdownMenu.style.boxShadow = '0 10px 40px rgba(0, 0, 0, 0.3)';
            dropdownMenu.style.minWidth = '200px';
            
            // Force dropdown items
            const dropdownItems = dropdownMenu.querySelectorAll('.dropdown-item');
            dropdownItems.forEach(item => {
                item.style.background = '#007bff';
                item.style.color = '#ffffff';
                item.style.fontWeight = '600';
                item.style.textShadow = '0 1px 2px rgba(0, 0, 0, 0.5)';
            });
        }
    });
}

// Function to force navbar text to be white
function forceNavbarText() {
    const navbarLinks = document.querySelectorAll('.navbar-dark .navbar-nav .nav-link, .navbar-dark .navbar-brand, .navbar-dark .navbar-nav .dropdown-toggle');
    
    navbarLinks.forEach(link => {
        link.style.color = '#ffffff';
        link.style.textShadow = '0 1px 2px rgba(0, 0, 0, 0.5)';
    });
}

// Function to force all other elements to stay below
function forceElementsBelow() {
    const elements = document.querySelectorAll('.container, .row, .col, [class*="col-"], .card, .btn, .alert, .bg-primary, .welcome-card, .overlapping-element');
    
    elements.forEach(el => {
        el.style.position = 'relative';
        el.style.zIndex = '1';
    });
}

// Apply fixes when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('Applying Simple Dropdown Fix...');
    
    // Apply fixes immediately
    forceDropdownStyles();
    forceNavbarText();
    forceElementsBelow();
    
    // Apply fixes every 100ms to ensure they stick
    setInterval(() => {
        forceDropdownStyles();
        forceNavbarText();
        forceElementsBelow();
    }, 100);
    
    // Apply fixes when dropdown is clicked
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('dropdown-toggle')) {
            setTimeout(() => {
                forceDropdownStyles();
                forceNavbarText();
                forceElementsBelow();
            }, 50);
        }
    });
    
    console.log('Simple Dropdown Fix applied successfully');
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {};
}
