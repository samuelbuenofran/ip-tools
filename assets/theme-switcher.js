// ===== THEME SWITCHER =====
class ThemeSwitcher {
    constructor() {
        this.themes = [
            { id: 'macos-aqua', name: 'macOS Aqua', icon: 'fa-solid fa-apple-whole', description: 'Classic macOS X Leopard Aqua theme' },
            { id: 'dim', name: 'Dim', icon: 'fa-solid fa-moon', description: 'Soft, dimmed palette for reduced eye strain' },
            { id: 'dark-dim', name: 'Dark Dim', icon: 'fa-solid fa-moon', description: 'Dark theme with dimmed colors' },
            { id: 'liquid-glass', name: 'Liquid Glass', icon: 'fa-solid fa-droplet', description: 'Modern glassmorphism with frosted glass effects and translucent UI elements' }
        ];
        
        this.currentTheme = 'macos-aqua';
        this.init();
    }
    
    init() {
        // Load saved theme from localStorage
        const savedTheme = localStorage.getItem('selected-theme');
        if (savedTheme && this.themes.find(t => t.id === savedTheme)) {
            this.currentTheme = savedTheme;
        }
        
        // Apply saved theme
        this.applyTheme(this.currentTheme);
        
        // Create theme switcher UI
        this.createThemeSwitcher();
        
        // Add fade-in animation to main content
        this.addFadeInAnimation();
    }
    
    createThemeSwitcher() {
        // Create theme switcher container
        const themeSwitcher = document.createElement('div');
        themeSwitcher.className = 'theme-switcher';
        themeSwitcher.innerHTML = `
            <div class="theme-switcher-header">
                <span class="theme-switcher-title">
                    <i class="fa-solid fa-palette me-2"></i>
                    Themes
                </span>
                <button class="theme-control-btn" onclick="themeSwitcher.toggleThemeSwitcher()">
                    <i class="fa-solid fa-chevron-up"></i>
                </button>
            </div>
            <div class="theme-switcher-content">
                ${this.themes.map(theme => `
                    <button class="theme-option ${theme.id === this.currentTheme ? 'active' : ''}" 
                            data-theme="${theme.id}" 
                            onclick="themeSwitcher.switchTheme('${theme.id}')"
                            title="${theme.description}">
                        <i class="${theme.icon} theme-option-icon"></i>
                        <span>${theme.name}</span>
                    </button>
                `).join('')}
            </div>
        `;
        
        // Add to body
        document.body.appendChild(themeSwitcher);
        
        // Add toggle functionality
        this.themeSwitcherElement = themeSwitcher;
    }
    
    toggleThemeSwitcher() {
        const content = this.themeSwitcherElement.querySelector('.theme-switcher-content');
        const toggleBtn = this.themeSwitcherElement.querySelector('.theme-control-btn i');
        
        if (content.style.display === 'none') {
            content.style.display = 'block';
            toggleBtn.className = 'fa-solid fa-chevron-up';
        } else {
            content.style.display = 'none';
            toggleBtn.className = 'fa-solid fa-chevron-down';
        }
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
        
        // Update theme switcher active state
        this.updateThemeSwitcherActiveState(themeId);
    }
    
    updateThemeSwitcherActiveState(themeId) {
        if (this.themeSwitcherElement) {
            document.querySelectorAll('.theme-option').forEach(option => {
                option.classList.remove('active');
            });
            
            const activeOption = this.themeSwitcherElement.querySelector(`[data-theme="${themeId}"]`);
            if (activeOption) {
                activeOption.classList.add('active');
            }
        }
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
            -webkit-backdrop-filter: blur(10px);
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
        
        .theme-switcher-content {
            display: block;
        }
        
        .theme-control-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 4px;
            border-radius: 3px;
            transition: var(--transition);
            font-size: 0.8rem;
        }
        
        .theme-control-btn:hover {
            background: var(--bg-secondary);
            color: var(--text-primary);
        }
        
        [data-theme="liquid-glass"] .theme-control-btn:hover {
            background: rgba(255, 255, 255, 0.2);
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