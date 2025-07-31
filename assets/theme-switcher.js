// ===== THEME SWITCHER =====
class ThemeSwitcher {
    constructor() {
        this.themes = [
            { id: 'macos-aqua', name: 'macOS Aqua', icon: 'fa-solid fa-apple-whole' }
        ];
        
        this.currentTheme = 'macos-aqua';
        this.init();
    }
    
    init() {
        // Apply saved theme
        this.applyTheme(this.currentTheme);
        
        // Add fade-in animation to main content
        this.addFadeInAnimation();
    }
    

    
    switchTheme(themeId) {
        // Remove active class from all options
        document.querySelectorAll('.theme-option').forEach(option => {
            option.classList.remove('active');
        });
        
        // Add active class to selected option
        const selectedOption = document.querySelector(`[data-theme="${themeId}"]`);
        if (selectedOption) {
            selectedOption.classList.add('active');
        }
        
        // Apply theme with transition
        this.applyTheme(themeId);
        
        // Save to localStorage
        localStorage.setItem('selected-theme', themeId);
        this.currentTheme = themeId;
        
        // Show success message
        this.showThemeNotification(themeId);
    }
    
    applyTheme(themeId) {
        // Add transition class to body for smooth theme switching
        document.body.classList.add('theme-transitioning');
        
        // Set theme attribute on body
        document.body.setAttribute('data-theme', themeId);
        
        // Remove transition class after animation completes
        setTimeout(() => {
            document.body.classList.remove('theme-transitioning');
        }, 300);
        
        // Update page title with theme info
        this.updatePageTitle(themeId);
    }
    
    updatePageTitle(themeId) {
        const theme = this.themes.find(t => t.id === themeId);
        const currentTitle = document.title.replace(/ - .*$/, '');
        document.title = `${currentTitle} - ${theme.name}`;
    }
    
    showThemeNotification(themeId) {
        const theme = this.themes.find(t => t.id === themeId);
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'theme-notification fade-in';
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="${theme.icon} me-2"></i>
                <span>Switched to ${theme.name}</span>
            </div>
        `;
        
        // Style the notification
        notification.style.cssText = `
            position: fixed;
            top: 80px;
            right: 20px;
            background: var(--bg-primary);
            border: var(--border-width) solid var(--border-color);
            border-radius: var(--border-radius);
            padding: var(--spacing-sm) var(--spacing-md);
            box-shadow: var(--shadow);
            z-index: 1001;
            font-size: 0.9rem;
            color: var(--text-primary);
            backdrop-filter: blur(10px);
        `;
        
        
        
        document.body.appendChild(notification);
        
        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100px)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
    
    addFadeInAnimation() {
        // Add fade-in animation to main content
        const mainContent = document.querySelector('.container') || document.querySelector('main');
        if (mainContent) {
            mainContent.classList.add('fade-in');
        }
        
        // Add animation to cards
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('fade-in');
        });
    }
    
    // Get current theme info
    getCurrentTheme() {
        return this.themes.find(t => t.id === this.currentTheme);
    }
    
    // Get all available themes
    getThemes() {
        return this.themes;
    }
    

}

// ===== INITIALIZATION =====
let themeSwitcher;

document.addEventListener('DOMContentLoaded', function() {
    themeSwitcher = new ThemeSwitcher();
    
    // Add theme transition styles
    const style = document.createElement('style');
    style.textContent = `
        .theme-transitioning * {
            transition: all 0.3s ease !important;
        }
        
        .theme-notification {
            transition: all 0.3s ease;
        }
        
        
    `;
    document.head.appendChild(style);
});

// ===== UTILITY FUNCTIONS =====
function getThemeInfo() {
    return themeSwitcher ? themeSwitcher.getCurrentTheme() : null;
}

function getAllThemes() {
    return themeSwitcher ? themeSwitcher.getThemes() : [];
}

// ===== EXPORT FOR GLOBAL ACCESS =====
window.themeSwitcher = themeSwitcher;
window.getThemeInfo = getThemeInfo;
window.getAllThemes = getAllThemes; 