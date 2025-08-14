// JavaFX Button Enhancement Script
document.addEventListener('DOMContentLoaded', function() {
    // Add ripple effect to all JavaFX buttons
    const javafxButtons = document.querySelectorAll('.btn-javafx');
    
    javafxButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            createRipple(e, this);
        });
        
        // Add loading state support
        if (button.hasAttribute('data-loading')) {
            button.classList.add('loading');
        }
    });
    
    // Ripple effect function
    function createRipple(event, button) {
        const ripple = document.createElement('span');
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');
        
        button.appendChild(ripple);
        
        // Remove ripple after animation
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }
    
    // Enhanced hover effects
    javafxButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.02)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
        
        button.addEventListener('mousedown', function() {
            this.style.transform = 'translateY(0) scale(0.98)';
        });
        
        button.addEventListener('mouseup', function() {
            this.style.transform = 'translateY(-2px) scale(1.02)';
        });
    });
    
    // Add focus management
    javafxButtons.forEach(button => {
        button.addEventListener('focus', function() {
            this.style.transform = 'translateY(-1px) scale(1.01)';
        });
        
        button.addEventListener('blur', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Keyboard navigation support
    javafxButtons.forEach(button => {
        button.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
    
    // Add loading state functionality
    window.setButtonLoading = function(buttonElement, isLoading) {
        if (isLoading) {
            buttonElement.classList.add('loading');
            buttonElement.disabled = true;
        } else {
            buttonElement.classList.remove('loading');
            buttonElement.disabled = false;
        }
    };
    
    // Add success state functionality
    window.setButtonSuccess = function(buttonElement, message = 'Success!') {
        const originalText = buttonElement.innerHTML;
        const originalClasses = buttonElement.className;
        
        buttonElement.innerHTML = `<i class="fa-solid fa-check"></i> ${message}`;
        buttonElement.className = buttonElement.className.replace('btn-primary', 'btn-success');
        
        setTimeout(() => {
            buttonElement.innerHTML = originalText;
            buttonElement.className = originalClasses;
        }, 2000);
    };
    
    // Add error state functionality
    window.setButtonError = function(buttonElement, message = 'Error!') {
        const originalText = buttonElement.innerHTML;
        const originalClasses = buttonElement.className;
        
        buttonElement.innerHTML = `<i class="fa-solid fa-exclamation-triangle"></i> ${message}`;
        buttonElement.className = buttonElement.className.replace('btn-primary', 'btn-danger');
        
        setTimeout(() => {
            buttonElement.innerHTML = originalText;
            buttonElement.className = originalClasses;
        }, 2000);
    };
});

// Utility function to convert existing Bootstrap buttons to JavaFX style
window.convertToJavaFX = function(selector = '.btn') {
    const buttons = document.querySelectorAll(selector);
    buttons.forEach(button => {
        button.classList.add('btn-javafx');
    });
};

// Auto-convert buttons on page load
document.addEventListener('DOMContentLoaded', function() {
    // Convert common button classes to JavaFX style
    const commonButtons = document.querySelectorAll('.btn-primary, .btn-success, .btn-warning, .btn-danger, .btn-info, .btn-secondary, .btn-dark, .btn-light');
    commonButtons.forEach(button => {
        button.classList.add('btn-javafx');
    });
});
