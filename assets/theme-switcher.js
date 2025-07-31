// ===== THEME SWITCHER =====
class ThemeSwitcher {
    constructor() {
        this.themes = [
            { id: 'flat-minimalist', name: 'Flat Minimalist', icon: 'fa-solid fa-palette' },
            { id: 'frutiger-aero', name: 'Frutiger Aero', icon: 'fa-solid fa-window-maximize' },
            { id: 'macos-aqua', name: 'macOS Aqua', icon: 'fa-solid fa-apple-whole' },
            { id: 'liquid-glass', name: 'Liquid Glass', icon: 'fa-solid fa-gem' }
        ];
        
        this.currentTheme = localStorage.getItem('selected-theme') || 'flat-minimalist';
        this.init();
    }
    
    init() {
        // Apply saved theme
        this.applyTheme(this.currentTheme);
        
        // Create theme selector if it doesn't exist
        if (!document.querySelector('.theme-selector')) {
            this.createThemeSelector();
        }
        
        // Add fade-in animation to main content
        this.addFadeInAnimation();
    }
    
    createThemeSelector() {
        const selector = document.createElement('div');
        selector.className = 'theme-selector fade-in';
        
        // Check saved state
        const isCollapsed = localStorage.getItem('theme-selector-collapsed') === 'true';
        const isMinimized = localStorage.getItem('theme-selector-minimized') === 'true';
        const isHidden = localStorage.getItem('theme-selector-hidden') === 'true';
        
        if (isCollapsed) selector.classList.add('collapsed');
        if (isMinimized) selector.classList.add('minimized');
        if (isHidden) selector.classList.add('hidden');
        
        selector.innerHTML = `
            <div class="theme-selector-header">
                <div class="theme-selector-title">
                    <i class="fa-solid fa-palette me-2"></i>
                    Theme
                </div>
                <div class="theme-selector-controls">
                    <button class="theme-control-btn" onclick="themeSwitcher.toggleCollapse()" title="Toggle">
                        <i class="fa-solid fa-chevron-${isCollapsed ? 'down' : 'up'}"></i>
                    </button>
                    <button class="theme-control-btn" onclick="themeSwitcher.toggleMinimize()" title="Minimize">
                        <i class="fa-solid fa-${isMinimized ? 'expand' : 'minus'}"></i>
                    </button>
                    <button class="theme-control-btn" onclick="themeSwitcher.hide()" title="Hide">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="theme-selector-content">
                ${this.themes.map(theme => `
                    <button class="theme-option ${theme.id === this.currentTheme ? 'active' : ''}" 
                            data-theme="${theme.id}" 
                            onclick="themeSwitcher.switchTheme('${theme.id}')">
                        <span class="theme-option-icon"><i class="${theme.icon}"></i></span>
                        <span>${theme.name}</span>
                    </button>
                `).join('')}
            </div>
        `;
        
        document.body.appendChild(selector);
        this.makeDraggable(selector);
        
        // If hidden, create restore button
        if (isHidden) {
            this.createRestoreButton();
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
        
        // Add liquid glass specific styling
        if (themeId === 'liquid-glass') {
            notification.style.background = 'rgba(255, 255, 255, 0.1)';
            notification.style.backdropFilter = 'blur(20px)';
            notification.style.border = '1px solid rgba(255, 255, 255, 0.2)';
        }
        
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
    
    // Toggle collapse/expand
    toggleCollapse() {
        const selector = document.querySelector('.theme-selector');
        if (selector) {
            selector.classList.toggle('collapsed');
            const isCollapsed = selector.classList.contains('collapsed');
            
            // Save state to localStorage
            localStorage.setItem('theme-selector-collapsed', isCollapsed);
            
            const toggleBtn = selector.querySelector('.theme-control-btn i');
            if (toggleBtn) {
                toggleBtn.className = isCollapsed 
                    ? 'fa-solid fa-chevron-down' 
                    : 'fa-solid fa-chevron-up';
            }
        }
    }
    
    // Toggle minimize/restore
    toggleMinimize() {
        const selector = document.querySelector('.theme-selector');
        if (selector) {
            selector.classList.toggle('minimized');
            const isMinimized = selector.classList.contains('minimized');
            
            // Save state to localStorage
            localStorage.setItem('theme-selector-minimized', isMinimized);
            
            const minimizeBtn = selector.querySelector('.theme-control-btn:nth-child(2) i');
            if (minimizeBtn) {
                minimizeBtn.className = isMinimized 
                    ? 'fa-solid fa-expand' 
                    : 'fa-solid fa-minus';
            }
        }
    }
    
    // Hide theme selector
    hide() {
        const selector = document.querySelector('.theme-selector');
        if (selector) {
            selector.classList.add('hidden');
            
            // Save state to localStorage
            localStorage.setItem('theme-selector-hidden', 'true');
            
            // Show a small floating button to restore
            this.createRestoreButton();
        }
    }
    
    // Create restore button
    createRestoreButton() {
        const restoreBtn = document.createElement('button');
        restoreBtn.className = 'theme-restore-btn';
        restoreBtn.innerHTML = '<i class="fa-solid fa-palette"></i>';
        restoreBtn.title = 'Show Theme Selector';
        restoreBtn.onclick = () => this.show();
        
        // Style the restore button
        restoreBtn.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: var(--bg-primary);
            border: var(--border-width) solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 8px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
            cursor: pointer;
            transition: var(--transition);
            color: var(--text-primary);
        `;
        
        document.body.appendChild(restoreBtn);
    }
    
    // Show theme selector
    show() {
        const selector = document.querySelector('.theme-selector');
        const restoreBtn = document.querySelector('.theme-restore-btn');
        
        if (selector) {
            selector.classList.remove('hidden');
        }
        
        if (restoreBtn) {
            restoreBtn.remove();
        }
        
        // Clear hidden state from localStorage
        localStorage.removeItem('theme-selector-hidden');
    }
    
    // Make theme selector draggable
    makeDraggable(element) {
        let isDragging = false;
        let currentX;
        let currentY;
        let initialX;
        let initialY;
        let xOffset = 0;
        let yOffset = 0;
        
        const dragStart = (e) => {
            if (e.target.closest('.theme-control-btn')) return; // Don't drag when clicking controls
            
            initialX = e.clientX - xOffset;
            initialY = e.clientY - yOffset;
            
            if (e.target === element || element.contains(e.target)) {
                isDragging = true;
            }
        };
        
        const dragEnd = () => {
            initialX = currentX;
            initialY = currentY;
            isDragging = false;
        };
        
        const drag = (e) => {
            if (isDragging) {
                e.preventDefault();
                
                currentX = e.clientX - initialX;
                currentY = e.clientY - initialY;
                
                xOffset = currentX;
                yOffset = currentY;
                
                setTranslate(currentX, currentY, element);
            }
        };
        
        const setTranslate = (xPos, yPos, el) => {
            el.style.transform = `translate3d(${xPos}px, ${yPos}px, 0)`;
        };
        
        element.addEventListener('mousedown', dragStart);
        document.addEventListener('mousemove', drag);
        document.addEventListener('mouseup', dragEnd);
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
        
                 /* Special animations for liquid glass theme */
         [data-theme="liquid-glass"] .card {
             animation: liquidFloat 6s ease-in-out infinite;
         }
         
         @keyframes liquidFloat {
             0%, 100% { transform: translateY(0px); }
             50% { transform: translateY(-5px); }
         }
         
         [data-theme="liquid-glass"] .btn {
             animation: liquidGlow 4s ease-in-out infinite;
         }
         
         @keyframes liquidGlow {
             0%, 100% { box-shadow: 0 0 5px rgba(135, 206, 235, 0.3); }
             50% { box-shadow: 0 0 20px rgba(135, 206, 235, 0.6); }
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