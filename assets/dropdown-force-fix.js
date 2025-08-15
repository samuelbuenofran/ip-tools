// ===== DROPDOWN FORCE FIX =====
// This JavaScript file forces the dropdown to work properly despite Bootstrap interference

document.addEventListener('DOMContentLoaded', function() {
    console.log('Dropdown Force Fix loaded');
    
    // Force dropdown positioning and z-index
    function forceDropdownFix() {
        const dropdowns = document.querySelectorAll('.dropdown');
        
        dropdowns.forEach(dropdown => {
            const dropdownMenu = dropdown.querySelector('.dropdown-menu');
            const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
            
            if (dropdownMenu && dropdownToggle) {
                // Force proper z-index and positioning
                dropdownMenu.style.zIndex = '99999';
                dropdownMenu.style.position = 'absolute';
                
                // Ensure dropdown is positioned correctly
                dropdown.addEventListener('show.bs.dropdown', function() {
                    console.log('Dropdown showing - applying force fix');
                    
                    // Force maximum z-index
                    dropdownMenu.style.zIndex = '99999';
                    dropdownMenu.style.position = 'absolute';
                    dropdownMenu.style.top = '100%';
                    dropdownMenu.style.left = 'auto';
                    dropdownMenu.style.right = '0';
                    dropdownMenu.style.transform = 'none';
                    
                    // Force visibility
                    dropdownMenu.style.visibility = 'visible';
                    dropdownMenu.style.opacity = '1';
                    dropdownMenu.style.display = 'block';
                    
                    // Force background and colors
                    dropdownMenu.style.background = '#007bff';
                    dropdownMenu.style.border = '2px solid #ffffff';
                    dropdownMenu.style.borderRadius = '8px';
                    dropdownMenu.style.boxShadow = '0 10px 40px rgba(0, 0, 0, 0.3), 0 5px 20px rgba(0, 0, 0, 0.2)';
                    
                    // Force dropdown items styling
                    const dropdownItems = dropdownMenu.querySelectorAll('.dropdown-item');
                    dropdownItems.forEach(item => {
                        item.style.background = '#007bff';
                        item.style.color = '#ffffff';
                        item.style.fontWeight = '600';
                        item.style.textShadow = '0 1px 2px rgba(0, 0, 0, 0.5)';
                    });
                    
                    // Force divider styling
                    const dividers = dropdownMenu.querySelectorAll('.dropdown-divider');
                    dividers.forEach(divider => {
                        divider.style.borderColor = 'rgba(255, 255, 255, 0.4)';
                        divider.style.borderWidth = '2px';
                    });
                });
                
                // Ensure dropdown stays visible when shown
                dropdown.addEventListener('shown.bs.dropdown', function() {
                    console.log('Dropdown shown - maintaining force fix');
                    
                    // Re-apply styles to ensure they stick
                    setTimeout(() => {
                        dropdownMenu.style.zIndex = '99999';
                        dropdownMenu.style.visibility = 'visible';
                        dropdownMenu.style.opacity = '1';
                        dropdownMenu.style.display = 'block';
                        
                        // Force all other elements to stay below
                        const allElements = document.querySelectorAll('*:not(.dropdown-menu):not(.dropdown-menu *)');
                        allElements.forEach(el => {
                            if (el !== dropdownMenu && !dropdownMenu.contains(el)) {
                                el.style.zIndex = '1';
                            }
                        });
                    }, 10);
                });
                
                // Clean up when dropdown is hidden
                dropdown.addEventListener('hide.bs.dropdown', function() {
                    console.log('Dropdown hiding - cleaning up');
                    dropdownMenu.style.zIndex = '99999';
                });
            }
        });
    }
    
    // Apply fix immediately
    forceDropdownFix();
    
    // Apply fix after any dynamic content changes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                forceDropdownFix();
            }
        });
    });
    
    // Observe the entire document for changes
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
    
    // Force navbar text to be white
    function forceNavbarText() {
        const navbarLinks = document.querySelectorAll('.navbar-dark .navbar-nav .nav-link, .navbar-dark .navbar-brand, .navbar-dark .navbar-nav .dropdown-toggle');
        
        navbarLinks.forEach(link => {
            link.style.color = '#ffffff';
            link.style.textShadow = '0 1px 2px rgba(0, 0, 0, 0.5)';
            link.style.fontWeight = '500';
        });
    }
    
    // Apply navbar text fix
    forceNavbarText();
    
    // Re-apply navbar text fix periodically
    setInterval(forceNavbarText, 1000);
    
    // Override Bootstrap's dropdown positioning
    if (typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
        const originalDropdown = bootstrap.Dropdown;
        
        // Create a custom dropdown class
        class ForceFixedDropdown extends originalDropdown {
            constructor(element, config) {
                super(element, config);
                this._forceFix();
            }
            
            _forceFix() {
                const dropdownMenu = this._menu;
                if (dropdownMenu) {
                    dropdownMenu.style.zIndex = '99999';
                    dropdownMenu.style.position = 'absolute';
                    dropdownMenu.style.background = '#007bff';
                    dropdownMenu.style.border = '2px solid #ffffff';
                    dropdownMenu.style.borderRadius = '8px';
                    dropdownMenu.style.boxShadow = '0 10px 40px rgba(0, 0, 0, 0.3), 0 5px 20px rgba(0, 0, 0, 0.2)';
                }
            }
            
            show() {
                super.show();
                this._forceFix();
                
                // Ensure dropdown stays on top
                setTimeout(() => {
                    if (this._menu) {
                        this._menu.style.zIndex = '99999';
                        this._menu.style.visibility = 'visible';
                        this._menu.style.opacity = '1';
                        this._menu.style.display = 'block';
                    }
                }, 10);
            }
        }
        
        // Replace Bootstrap's Dropdown with our custom one
        bootstrap.Dropdown = ForceFixedDropdown;
        
        // Re-initialize existing dropdowns
        document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
            if (toggle.dataset.bsToggle === 'dropdown') {
                new ForceFixedDropdown(toggle);
            }
        });
    }
    
    // Additional safety: force dropdown visibility on click
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('dropdown-toggle')) {
            setTimeout(() => {
                const dropdown = e.target.closest('.dropdown');
                if (dropdown) {
                    const dropdownMenu = dropdown.querySelector('.dropdown-menu');
                    if (dropdownMenu) {
                        dropdownMenu.style.zIndex = '99999';
                        dropdownMenu.style.visibility = 'visible';
                        dropdownMenu.style.opacity = '1';
                        dropdownMenu.style.display = 'block';
                        dropdownMenu.style.background = '#007bff';
                        dropdownMenu.style.border = '2px solid #ffffff';
                    }
                }
            }, 50);
        }
    });
    
    // Log success
    console.log('Dropdown Force Fix applied successfully');
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {};
}
