class ThemeSwitcher {
    constructor() {
        this.themes = [
            { id: 'macos-aqua', name: 'macOS Aqua', icon: 'fa-solid fa-apple-whole', description: 'Classic macOS X Leopard Aqua theme' },
            { id: 'dim', name: 'Dim', icon: 'fa-solid fa-moon', description: 'Soft, dimmed palette for reduced eye strain' },
            { id: 'dark-dim', name: 'Dark Dim', icon: 'fa-solid fa-moon', description: 'Dark theme with dimmed colors' },
            { id: 'liquid-glass', name: 'Liquid Glass', icon: 'fa-solid fa-droplet', description: 'Dark glassmorphism with frosted glass effects and easy-on-the-eyes design' }
        ];
        
        this.currentTheme = localStorage.getItem('selected-theme') || 'macos-aqua';
        if (!this.themes.find(t => t.id === this.currentTheme)) {
            this.currentTheme = 'macos-aqua';
        }
        
        this.applyTheme(this.currentTheme);
        this.addFadeInAnimation();
    }
    
    createThemeSwitcher() {
        if (!this.isUserLoggedIn() || this.themeSwitcherElement) return;
        
        const switcher = document.createElement('div');
        switcher.className = 'theme-switcher';
        switcher.innerHTML = `
            <div class="theme-switcher-header">
                <span><i class="fa-solid fa-palette me-2"></i>Themes</span>
                <button class="theme-control-btn">
                    <i class="fa-solid fa-chevron-up"></i>
                </button>
            </div>
            <div class="theme-switcher-content">
                ${this.themes.map(theme => `
                    <button class="theme-option ${theme.id === this.currentTheme ? 'active' : ''}" 
                            data-theme="${theme.id}" title="${theme.description}">
                        <i class="${theme.icon}"></i><span>${theme.name}</span>
                    </button>
                `).join('')}
            </div>
        `;
        
        switcher.addEventListener('click', this.handleSwitcherClick.bind(this));
        document.body.appendChild(switcher);
        this.themeSwitcherElement = switcher;
    }
    
    isUserLoggedIn() {
        return document.querySelector('.user-profile, .logout-btn, [data-user-id], .user-menu') ||
               /\/(dashboard|profile|admin)/.test(window.location.pathname);
    }
    
    handleSwitcherClick(e) {
        if (e.target.closest('.theme-control-btn')) {
            const content = this.themeSwitcherElement.querySelector('.theme-switcher-content');
            const icon = e.target.closest('.theme-control-btn').querySelector('i');
            const isHidden = content.style.display === 'none';
            
            content.style.display = isHidden ? 'block' : 'none';
            icon.className = `fa-solid fa-chevron-${isHidden ? 'up' : 'down'}`;
        } else if (e.target.closest('.theme-option')) {
            const themeId = e.target.closest('.theme-option').dataset.theme;
            this.switchTheme(themeId);
        }
    }
    
    switchTheme(themeId) {
        if (themeId === this.currentTheme) return;
        
        this.updateActiveState(themeId);
        this.applyTheme(themeId);
        localStorage.setItem('selected-theme', themeId);
        this.currentTheme = themeId;
        this.showNotification(themeId);
    }
    
    applyTheme(themeId) {
        document.body.classList.add('theme-transitioning');
        document.body.setAttribute('data-theme', themeId);
        
        setTimeout(() => document.body.classList.remove('theme-transitioning'), 300);
        
        const theme = this.themes.find(t => t.id === themeId);
        if (theme) {
            document.title = document.title.replace(/ - .*$/, '') + ` - ${theme.name}`;
        }
    }
    
    updateActiveState(themeId) {
        document.querySelectorAll('.theme-option').forEach(option => {
            option.classList.toggle('active', option.dataset.theme === themeId);
        });
    }
    
    showNotification(themeId) {
        const theme = this.themes.find(t => t.id === themeId);
        if (!theme) return;
        
        const notification = document.createElement('div');
        notification.className = 'theme-notification';
        notification.innerHTML = `<i class="${theme.icon} me-2"></i>Switched to ${theme.name}`;
        notification.style.cssText = `
            position: fixed; top: 80px; right: 20px; z-index: 1001;
            background: var(--bg-primary); border: var(--border-width) solid var(--border-color);
            border-radius: var(--border-radius); padding: var(--spacing-sm) var(--spacing-md);
            box-shadow: var(--shadow); font-size: 0.9rem; color: var(--text-primary);
            backdrop-filter: blur(10px); transition: all 0.3s ease;
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100px)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    addFadeInAnimation() {
        const mainContent = document.querySelector('.container, main');
        if (mainContent) mainContent.classList.add('fade-in');
        
        document.querySelectorAll('.card').forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('fade-in');
        });
    }
    
    getCurrentTheme() {
        return this.themes.find(t => t.id === this.currentTheme);
    }
    
    getThemes() {
        return this.themes;
    }
    
    createSettingsThemeSelector(containerId) {
        if (!this.isUserLoggedIn()) return;
        
        const container = document.getElementById(containerId);
        if (!container) return;
        
        const selector = document.createElement('div');
        selector.className = 'settings-theme-selector';
        selector.innerHTML = `
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fa-solid fa-palette me-2"></i>Theme Settings</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Choose your preferred theme for the application.</p>
                    <div class="theme-grid">
                        ${this.themes.map(theme => `
                            <div class="theme-option-card ${theme.id === this.currentTheme ? 'active' : ''}" data-theme="${theme.id}">
                                <div class="theme-info">
                                    <h6>${theme.name}</h6>
                                    <p>${theme.description}</p>
                                    <button class="btn btn-sm ${theme.id === this.currentTheme ? 'btn-primary' : 'btn-outline-primary'}">
                                        ${theme.id === this.currentTheme ? 'Active' : 'Apply'}
                                    </button>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            </div>
        `;
        
        selector.addEventListener('click', (e) => {
            const card = e.target.closest('.theme-option-card');
            if (card && !e.target.classList.contains('btn')) {
                this.switchTheme(card.dataset.theme);
            }
        });
        
        container.appendChild(selector);
    }
    
    showFloatingThemeSwitcher() {
        if (this.themeSwitcherElement) {
            this.themeSwitcherElement.style.display = 'block';
        } else {
            this.createThemeSwitcher();
        }
    }
    
    hideFloatingThemeSwitcher() {
        if (this.themeSwitcherElement) {
            this.themeSwitcherElement.style.display = 'none';
        }
    }
}

let themeSwitcher;

document.addEventListener('DOMContentLoaded', () => {
    themeSwitcher = new ThemeSwitcher();
    
    const style = document.createElement('style');
    style.textContent = `
        .theme-transitioning * { transition: all 0.3s ease !important; }
        .theme-switcher-content { display: block; }
        .theme-control-btn {
            background: none; border: none; color: var(--text-secondary);
            cursor: pointer; padding: 4px; border-radius: 3px;
            transition: var(--transition); font-size: 0.8rem;
        }
        .theme-control-btn:hover {
            background: var(--bg-secondary); color: var(--text-primary);
        }
        [data-theme="liquid-glass"] .theme-control-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }
    `;
    document.head.appendChild(style);
});

Object.assign(window, {
    themeSwitcher,
    getThemeInfo: () => themeSwitcher?.getCurrentTheme(),
    getAllThemes: () => themeSwitcher?.getThemes() || [],
    createSettingsThemeSelector: (id) => themeSwitcher?.createSettingsThemeSelector(id),
    showFloatingThemeSwitcher: () => themeSwitcher?.showFloatingThemeSwitcher(),
    hideFloatingThemeSwitcher: () => themeSwitcher?.hideFloatingThemeSwitcher()
}); 