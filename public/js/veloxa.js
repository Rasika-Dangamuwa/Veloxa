/* =============================================
   Veloxa Design System - Main JavaScript
   Theme Management & UI Interactions
   ============================================= */

class VeloxaUI {
    constructor() {
        this.theme = localStorage.getItem('veloxa-theme') || 'light';
        this.init();
    }

    init() {
        this.setTheme(this.theme);
        this.bindEvents();
        this.initAnimations();
        console.log('🚀 Veloxa UI initialized');
    }

    // Theme Management
    setTheme(theme) {
        this.theme = theme;
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('veloxa-theme', theme);
        this.updateThemeToggle();
    }

    toggleTheme() {
        const newTheme = this.theme === 'light' ? 'dark' : 'light';
        this.setTheme(newTheme);
    }

    updateThemeToggle() {
        const toggles = document.querySelectorAll('.theme-toggle');
        toggles.forEach(toggle => {
            const isDark = this.theme === 'dark';
            toggle.classList.toggle('dark', isDark);
            
            const slider = toggle.querySelector('.theme-toggle-slider');
            if (slider) {
                slider.innerHTML = isDark ? '🌙' : '☀️';
            }
        });
    }

    // Event Bindings
    bindEvents() {
        // Theme toggle events
        document.addEventListener('click', (e) => {
            if (e.target.closest('.theme-toggle')) {
                e.preventDefault();
                this.toggleTheme();
            }
        });

        // Form enhancements
        this.enhanceForms();
        
        // Mobile menu toggles
        this.bindMobileMenu();
        
        // Smooth scroll for anchor links
        this.bindSmoothScroll();
        
        // Auto-hide alerts
        this.bindAlerts();
    }

    // Form Enhancements
    enhanceForms() {
        // Password visibility toggle
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('password-toggle')) {
                const input = e.target.parentElement.querySelector('input');
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                e.target.innerHTML = isPassword ? 
                    '<i class="fas fa-eye-slash"></i>' : 
                    '<i class="fas fa-eye"></i>';
            }
        });

        // Form validation feedback
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                this.showFormLoading(form);
            });
        });

        // Auto-grow textareas
        const textareas = document.querySelectorAll('textarea[data-auto-grow]');
        textareas.forEach(textarea => {
            textarea.addEventListener('input', () => {
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            });
        });
    }

    // Mobile Menu
    bindMobileMenu() {
        document.addEventListener('click', (e) => {
            const menuToggle = e.target.closest('.mobile-menu-toggle');
            const menuClose = e.target.closest('.mobile-menu-close');
            
            if (menuToggle) {
                this.showMobileMenu();
            }
            
            if (menuClose) {
                this.hideMobileMenu();
            }
        });

        // Close menu on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.hideMobileMenu();
            }
        });
    }

    showMobileMenu() {
        const menu = document.querySelector('.mobile-menu');
        const overlay = document.querySelector('.mobile-menu-overlay');
        
        if (menu) {
            menu.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        if (overlay) {
            overlay.classList.add('active');
        }
    }

    hideMobileMenu() {
        const menu = document.querySelector('.mobile-menu');
        const overlay = document.querySelector('.mobile-menu-overlay');
        
        if (menu) {
            menu.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        if (overlay) {
            overlay.classList.remove('active');
        }
    }

    // Smooth Scroll
    bindSmoothScroll() {
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a[href^="#"]');
            if (link && link.getAttribute('href') !== '#') {
                e.preventDefault();
                const target = document.querySelector(link.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    }

    // Alert Management
    bindAlerts() {
        // Auto-hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert[data-auto-hide]');
        alerts.forEach(alert => {
            setTimeout(() => {
                this.hideAlert(alert);
            }, 5000);
        });

        // Manual alert close
        document.addEventListener('click', (e) => {
            if (e.target.closest('.alert-close')) {
                const alert = e.target.closest('.alert');
                this.hideAlert(alert);
            }
        });
    }

    hideAlert(alert) {
        if (alert) {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }
    }

    // Form Loading States
    showFormLoading(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            submitBtn.disabled = true;
            
            // Store original text for restoration if needed
            submitBtn.dataset.originalText = originalText;
        }
    }

    // Animation Utilities
    initAnimations() {
        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);

        // Observe elements with animation classes
        const animatedElements = document.querySelectorAll('[data-animate]');
        animatedElements.forEach(el => observer.observe(el));
    }

    // Utility Methods
    showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    hideModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    showToast(message, type = 'info', duration = 3000) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fas fa-${this.getToastIcon(type)}"></i>
                <span>${message}</span>
            </div>
            <button class="toast-close">
                <i class="fas fa-times"></i>
            </button>
        `;

        // Add to page
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container';
            document.body.appendChild(toastContainer);
        }

        toastContainer.appendChild(toast);

        // Auto remove
        setTimeout(() => {
            toast.remove();
        }, duration);

        // Manual close
        toast.querySelector('.toast-close').addEventListener('click', () => {
            toast.remove();
        });
    }

    getToastIcon(type) {
        const icons = {
            success: 'check-circle',
            error: 'exclamation-circle',
            warning: 'exclamation-triangle',
            info: 'info-circle'
        };
        return icons[type] || 'info-circle';
    }

    // Loading Spinner
    showLoader(message = 'Loading...') {
        const loader = document.createElement('div');
        loader.id = 'veloxa-loader';
        loader.innerHTML = `
            <div class="loader-backdrop">
                <div class="loader-content">
                    <div class="loader-spinner"></div>
                    <p>${message}</p>
                </div>
            </div>
        `;
        document.body.appendChild(loader);
    }

    hideLoader() {
        const loader = document.getElementById('veloxa-loader');
        if (loader) {
            loader.remove();
        }
    }

    // Device Detection
    isMobile() {
        return window.innerWidth <= 768;
    }

    isTablet() {
        return window.innerWidth > 768 && window.innerWidth <= 1024;
    }

    isDesktop() {
        return window.innerWidth > 1024;
    }
}

// Toast CSS (to be added to main CSS or as inline styles)
const toastCSS = `
.toast-container {
    position: fixed;
    top: 1rem;
    right: 1rem;
    z-index: 9999;
    max-width: 300px;
}

.toast {
    background: var(--bg-primary);
    border: 1px solid var(--border-primary);
    border-radius: var(--radius-lg);
    padding: var(--space-4);
    margin-bottom: var(--space-2);
    box-shadow: var(--shadow-lg);
    display: flex;
    align-items: center;
    justify-content: space-between;
    animation: slideInRight 0.3s ease-out;
}

.toast-success { border-left: 4px solid #10b981; }
.toast-error { border-left: 4px solid #ef4444; }
.toast-warning { border-left: 4px solid #f59e0b; }
.toast-info { border-left: 4px solid var(--blue-500); }

.toast-content {
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.toast-close {
    background: none;
    border: none;
    color: var(--text-tertiary);
    cursor: pointer;
    padding: var(--space-1);
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

#veloxa-loader {
    position: fixed;
    inset: 0;
    z-index: 9999;
}

.loader-backdrop {
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
}

.loader-content {
    background: var(--bg-primary);
    padding: var(--space-8);
    border-radius: var(--radius-xl);
    text-align: center;
    box-shadow: var(--shadow-xl);
}

.loader-spinner {
    width: 2rem;
    height: 2rem;
    border: 3px solid var(--border-primary);
    border-top: 3px solid var(--blue-500);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto var(--space-4);
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
`;

// Initialize Veloxa UI when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Add toast CSS to head
    const style = document.createElement('style');
    style.textContent = toastCSS;
    document.head.appendChild(style);

    // Initialize UI
    window.VeloxaUI = new VeloxaUI();
});

// Export for module use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = VeloxaUI;
}