// ===== THEME SWITCHER =====
class ThemeSwitcher {
    constructor() {
        this.themes = [
            { id: 'macos-aqua', name: 'macOS Aqua', icon: 'fa-solid fa-apple-whole', description: 'Classic macOS X Leopard Aqua theme' },
            { id: 'dim', name: 'Dim', icon: 'fa-solid fa-moon', description: 'Soft, dimmed palette for reduced eye strain' },
            { id: 'dark-dim', name: 'Dark Dim', icon: 'fa-solid fa-moon', description: 'Dark theme with dimmed colors' },
            { id: 'liquid-glass', name: 'Liquid Glass', icon: 'fa-solid fa-droplet', description: 'Dark glassmorphism with frosted glass effects and easy-on-the-eyes design' }
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
        
        // Don't create floating theme switcher by default
        // Only create it when explicitly requested from settings
        
        // Add fade-in animation to main content
        this.addFadeInAnimation();
    }
    
    createThemeSwitcher() {
        // Only create theme switcher if user is logged in
        if (!this.isUserLoggedIn()) {
            return;
        }
        
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
    
    isUserLoggedIn() {
        // Check if user is logged in by looking for common indicators
        // You can customize this logic based on your authentication system
        return document.querySelector('.user-profile') !== null || 
               document.querySelector('.logout-btn') !== null ||
               document.querySelector('[data-user-id]') !== null ||
               document.querySelector('.user-menu') !== null ||
               window.location.pathname.includes('/dashboard') ||
               window.location.pathname.includes('/profile') ||
               window.location.pathname.includes('/admin');
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
    
    // Create settings page theme selector
    createSettingsThemeSelector(containerId) {
        if (!this.isUserLoggedIn()) {
            return;
        }
        
        const container = document.getElementById(containerId);
        if (!container) {
            console.warn('Settings theme selector container not found:', containerId);
            return;
        }
        
        const settingsThemeSelector = document.createElement('div');
        settingsThemeSelector.className = 'settings-theme-selector';
        settingsThemeSelector.innerHTML = `
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-palette me-2"></i>
                        Theme Settings
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Choose your preferred theme for the application.</p>
                    <div class="theme-grid">
                        ${this.themes.map(theme => `
                            <div class="theme-option-card ${theme.id === this.currentTheme ? 'active' : ''}" 
                                 data-theme="${theme.id}">
                                <div class="theme-preview-box" style="background: var(--bg-primary); border: 1px solid var(--border-color);">
                                    <div class="theme-preview-header" style="background: var(--bg-secondary); height: 20px; margin-bottom: 10px;"></div>
                                    <div class="theme-preview-content">
                                        <div class="theme-preview-bar" style="background: var(--primary-color); height: 8px; margin-bottom: 8px;"></div>
                                        <div class="theme-preview-bar" style="background: var(--bg-tertiary); height: 8px; margin-bottom: 8px; width: 70%;"></div>
                                        <div class="theme-preview-bar" style="background: var(--bg-tertiary); height: 8px; width: 50%;"></div>
                                    </div>
                                </div>
                                <div class="theme-info">
                                    <h6 class="theme-name">${theme.name}</h6>
                                    <p class="theme-description">${theme.description}</p>
                                    <button class="btn btn-sm ${theme.id === this.currentTheme ? 'btn-primary' : 'btn-outline-primary'}" 
                                            onclick="themeSwitcher.switchTheme('${theme.id}')">
                                        ${theme.id === this.currentTheme ? 'Active' : 'Apply'}
                                    </button>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            </div>
        `;
        
        container.appendChild(settingsThemeSelector);
        
        // Add event listeners for theme option cards
        settingsThemeSelector.querySelectorAll('.theme-option-card').forEach(card => {
            card.addEventListener('click', (e) => {
                if (!e.target.classList.contains('btn')) {
                    const themeId = card.dataset.theme;
                    this.switchTheme(themeId);
                }
            });
        });
    }
    
    // Method to manually show floating theme switcher (for debugging or special cases)
    showFloatingThemeSwitcher() {
        if (this.themeSwitcherElement) {
            this.themeSwitcherElement.style.display = 'block';
        } else {
            this.createThemeSwitcher();
        }
    }
    
    // Method to hide floating theme switcher
    hideFloatingThemeSwitcher() {
        if (this.themeSwitcherElement) {
            this.themeSwitcherElement.style.display = 'none';
        }
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

function createSettingsThemeSelector(containerId) {
    if (themeSwitcher) {
        themeSwitcher.createSettingsThemeSelector(containerId);
    }
}

function showFloatingThemeSwitcher() {
    if (themeSwitcher) {
        themeSwitcher.showFloatingThemeSwitcher();
    }
}

function hideFloatingThemeSwitcher() {
    if (themeSwitcher) {
        themeSwitcher.hideFloatingThemeSwitcher();
    }
}

// ===== EXPORT FOR GLOBAL ACCESS =====
window.themeSwitcher = themeSwitcher;
window.getThemeInfo = getThemeInfo;
window.getAllThemes = getAllThemes;
window.createSettingsThemeSelector = createSettingsThemeSelector;
window.showFloatingThemeSwitcher = showFloatingThemeSwitcher;
window.hideFloatingThemeSwitcher = hideFloatingThemeSwitcher; 