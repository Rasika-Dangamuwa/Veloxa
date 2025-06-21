/**
 * =========================================
 * VELOXA - Modern JavaScript Framework
 * Nestlé Lanka Limited - Sales Promotion Department
 * =========================================
 */

// =========================================
// CORE VELOXA OBJECT
// =========================================
window.Veloxa = {
    version: '1.0.0',
    components: {},
    utils: {},
    animations: {},
    init: function() {
        this.utils.domReady(() => {
            this.initializeComponents();
            this.setupGlobalEvents();
            console.log('🚀 Veloxa v' + this.version + ' initialized');
        });
    }
};

// =========================================
// UTILITY FUNCTIONS
// =========================================
Veloxa.utils = {
    // DOM Ready
    domReady: function(callback) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', callback);
        } else {
            callback();
        }
    },

    // Element Selection
    $: function(selector, context = document) {
        return context.querySelector(selector);
    },

    $$: function(selector, context = document) {
        return Array.from(context.querySelectorAll(selector));
    },

    // Element Creation
    createElement: function(tag, attributes = {}, children = []) {
        const element = document.createElement(tag);
        
        Object.entries(attributes).forEach(([key, value]) => {
            if (key === 'className') {
                element.className = value;
            } else if (key === 'innerHTML') {
                element.innerHTML = value;
            } else {
                element.setAttribute(key, value);
            }
        });

        children.forEach(child => {
            if (typeof child === 'string') {
                element.appendChild(document.createTextNode(child));
            } else {
                element.appendChild(child);
            }
        });

        return element;
    },

    // Class manipulation
    addClass: function(element, className) {
        if (element) element.classList.add(className);
    },

    removeClass: function(element, className) {
        if (element) element.classList.remove(className);
    },

    toggleClass: function(element, className) {
        if (element) element.classList.toggle(className);
    },

    hasClass: function(element, className) {
        return element ? element.classList.contains(className) : false;
    },

    // Event handling
    on: function(element, event, handler) {
        if (element) element.addEventListener(event, handler);
    },

    off: function(element, event, handler) {
        if (element) element.removeEventListener(event, handler);
    },

    // Debounce function
    debounce: function(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    // Throttle function
    throttle: function(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    },

    // Local storage helper
    storage: {
        set: function(key, value) {
            try {
                localStorage.setItem(key, JSON.stringify(value));
            } catch (e) {
                console.warn('localStorage not available:', e);
            }
        },

        get: function(key) {
            try {
                const item = localStorage.getItem(key);
                return item ? JSON.parse(item) : null;
            } catch (e) {
                console.warn('localStorage not available:', e);
                return null;
            }
        },

        remove: function(key) {
            try {
                localStorage.removeItem(key);
            } catch (e) {
                console.warn('localStorage not available:', e);
            }
        }
    },

    // Animation helpers
    fadeIn: function(element, duration = 300) {
        element.style.opacity = '0';
        element.style.display = 'block';
        
        const start = performance.now();
        
        function animate(currentTime) {
            const elapsed = currentTime - start;
            const progress = Math.min(elapsed / duration, 1);
            
            element.style.opacity = progress;
            
            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        }
        
        requestAnimationFrame(animate);
    },

    fadeOut: function(element, duration = 300) {
        const start = performance.now();
        const initialOpacity = parseFloat(window.getComputedStyle(element).opacity) || 1;
        
        function animate(currentTime) {
            const elapsed = currentTime - start;
            const progress = Math.min(elapsed / duration, 1);
            
            element.style.opacity = initialOpacity * (1 - progress);
            
            if (progress < 1) {
                requestAnimationFrame(animate);
            } else {
                element.style.display = 'none';
            }
        }
        
        requestAnimationFrame(animate);
    }
};

// =========================================
// ANIMATION SYSTEM
// =========================================
Veloxa.animations = {
    // Intersection Observer for scroll animations
    observeElements: function(selector, animationClass = 'veloxa-animate-slide-up') {
        const elements = Veloxa.utils.$$(selector);
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    Veloxa.utils.addClass(entry.target, animationClass);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        elements.forEach(element => {
            observer.observe(element);
        });
    },

    // Stagger animation
    staggerElements: function(selector, delay = 100) {
        const elements = Veloxa.utils.$$(selector);
        elements.forEach((element, index) => {
            setTimeout(() => {
                Veloxa.utils.addClass(element, 'veloxa-animate-scale-in');
            }, index * delay);
        });
    },

    // Parallax effect
    parallax: function(selector, speed = 0.5) {
        const elements = Veloxa.utils.$$(selector);
        
        const updateParallax = Veloxa.utils.throttle(() => {
            const scrollY = window.pageYOffset;
            
            elements.forEach(element => {
                const rect = element.getBoundingClientRect();
                const elementTop = rect.top + scrollY;
                const elementHeight = rect.height;
                const windowHeight = window.innerHeight;
                
                // Check if element is in viewport
                if (scrollY + windowHeight > elementTop && scrollY < elementTop + elementHeight) {
                    const yPos = -(scrollY - elementTop) * speed;
                    element.style.transform = `translateY(${yPos}px)`;
                }
            });
        }, 16);

        window.addEventListener('scroll', updateParallax);
    }
};

// =========================================
// UI COMPONENTS
// =========================================

// Modal Component
Veloxa.components.Modal = class {
    constructor(element) {
        this.modal = element;
        this.isOpen = false;
        this.init();
    }

    init() {
        const closeButtons = Veloxa.utils.$$('[data-modal-close]', this.modal);
        const backdrop = Veloxa.utils.$('.veloxa-modal-backdrop', this.modal);

        closeButtons.forEach(btn => {
            Veloxa.utils.on(btn, 'click', () => this.close());
        });

        if (backdrop) {
            Veloxa.utils.on(backdrop, 'click', (e) => {
                if (e.target === backdrop) this.close();
            });
        }

        // ESC key to close
        Veloxa.utils.on(document, 'keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) this.close();
        });
    }

    open() {
        this.isOpen = true;
        Veloxa.utils.removeClass(this.modal, 'veloxa-hidden');
        Veloxa.utils.addClass(this.modal, 'veloxa-animate-scale-in');
        document.body.style.overflow = 'hidden';
    }

    close() {
        this.isOpen = false;
        Veloxa.utils.addClass(this.modal, 'veloxa-hidden');
        document.body.style.overflow = '';
    }
};

// Dropdown Component
Veloxa.components.Dropdown = class {
    constructor(element) {
        this.dropdown = element;
        this.trigger = Veloxa.utils.$('[data-dropdown-trigger]', element);
        this.menu = Veloxa.utils.$('[data-dropdown-menu]', element);
        this.isOpen = false;
        this.init();
    }

    init() {
        if (!this.trigger || !this.menu) return;

        Veloxa.utils.on(this.trigger, 'click', (e) => {
            e.preventDefault();
            this.toggle();
        });

        // Close on outside click
        Veloxa.utils.on(document, 'click', (e) => {
            if (!this.dropdown.contains(e.target) && this.isOpen) {
                this.close();
            }
        });
    }

    toggle() {
        this.isOpen ? this.close() : this.open();
    }

    open() {
        this.isOpen = true;
        Veloxa.utils.removeClass(this.menu, 'veloxa-hidden');
        Veloxa.utils.addClass(this.menu, 'veloxa-animate-scale-in');
    }

    close() {
        this.isOpen = false;
        Veloxa.utils.addClass(this.menu, 'veloxa-hidden');
    }
};

// Toast Notification Component
Veloxa.components.Toast = class {
    static container = null;

    static init() {
        if (!this.container) {
            this.container = Veloxa.utils.createElement('div', {
                className: 'veloxa-toast-container',
                style: 'position: fixed; top: 1rem; right: 1rem; z-index: 1000; display: flex; flex-direction: column; gap: 0.5rem;'
            });
            document.body.appendChild(this.container);
        }
    }

    static show(message, type = 'info', duration = 5000) {
        this.init();

        const toast = Veloxa.utils.createElement('div', {
            className: `veloxa-alert veloxa-alert-${type} veloxa-animate-slide-up`,
            style: 'min-width: 300px; box-shadow: var(--veloxa-shadow-lg);'
        });

        const icon = this.getIcon(type);
        toast.innerHTML = `
            <i class="fas fa-${icon}"></i>
            <span>${message}</span>
            <button class="veloxa-toast-close" style="margin-left: auto; background: none; border: none; cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        `;

        this.container.appendChild(toast);

        // Close button
        const closeBtn = Veloxa.utils.$('.veloxa-toast-close', toast);
        Veloxa.utils.on(closeBtn, 'click', () => this.remove(toast));

        // Auto remove
        if (duration > 0) {
            setTimeout(() => this.remove(toast), duration);
        }

        return toast;
    }

    static remove(toast) {
        Veloxa.utils.fadeOut(toast, 300);
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }

    static getIcon(type) {
        const icons = {
            success: 'check-circle',
            error: 'exclamation-triangle',
            warning: 'exclamation-circle',
            info: 'info-circle'
        };
        return icons[type] || icons.info;
    }
};

// Form Validation Component
Veloxa.components.FormValidator = class {
    constructor(form) {
        this.form = form;
        this.rules = {};
        this.init();
    }

    init() {
        Veloxa.utils.on(this.form, 'submit', (e) => {
            if (!this.validate()) {
                e.preventDefault();
            }
        });

        // Real-time validation
        const inputs = Veloxa.utils.$('input, select, textarea', this.form);
        inputs.forEach(input => {
            Veloxa.utils.on(input, 'blur', () => this.validateField(input));
            Veloxa.utils.on(input, 'input', Veloxa.utils.debounce(() => {
                this.validateField(input);
            }, 300));
        });
    }

    addRule(fieldName, validator, message) {
        if (!this.rules[fieldName]) {
            this.rules[fieldName] = [];
        }
        this.rules[fieldName].push({ validator, message });
        return this;
    }

    validateField(field) {
        const fieldName = field.name;
        const value = field.value;
        const rules = this.rules[fieldName] || [];

        // Remove existing error
        this.clearFieldError(field);

        for (const rule of rules) {
            if (!rule.validator(value, field)) {
                this.showFieldError(field, rule.message);
                return false;
            }
        }

        this.showFieldSuccess(field);
        return true;
    }

    validate() {
        let isValid = true;
        const inputs = Veloxa.utils.$('input, select, textarea', this.form);

        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isValid = false;
            }
        });

        return isValid;
    }

    showFieldError(field, message) {
        Veloxa.utils.addClass(field, 'border-red-500');
        Veloxa.utils.removeClass(field, 'border-green-500');

        const errorElement = Veloxa.utils.createElement('div', {
            className: 'veloxa-field-error text-red-600 text-sm mt-1',
            innerHTML: `<i class="fas fa-exclamation-circle mr-1"></i>${message}`
        });

        field.parentNode.appendChild(errorElement);
    }

    showFieldSuccess(field) {
        Veloxa.utils.addClass(field, 'border-green-500');
        Veloxa.utils.removeClass(field, 'border-red-500');
    }

    clearFieldError(field) {
        const existingError = Veloxa.utils.$('.veloxa-field-error', field.parentNode);
        if (existingError) {
            existingError.remove();
        }
        Veloxa.utils.removeClass(field, 'border-red-500', 'border-green-500');
    }

    // Common validators
    static validators = {
        required: (value) => value.trim() !== '',
        email: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
        minLength: (min) => (value) => value.length >= min,
        maxLength: (max) => (value) => value.length <= max,
        pattern: (regex) => (value) => regex.test(value),
        numeric: (value) => /^\d+$/.test(value),
        phone: (value) => /^[\+]?[1-9][\d]{0,15}$/.test(value)
    };
};

// Loading Component
Veloxa.components.Loading = class {
    static overlay = null;

    static show(message = 'Loading...') {
        this.hide(); // Remove existing overlay

        this.overlay = Veloxa.utils.createElement('div', {
            className: 'veloxa-loading-overlay',
            style: `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 9999;
            `,
            innerHTML: `
                <div class="veloxa-glass text-center p-8 rounded-2xl">
                    <div class="veloxa-spinner mb-4"></div>
                    <p class="text-white font-medium">${message}</p>
                </div>
            `
        });

        // Add spinner CSS
        const style = Veloxa.utils.createElement('style', {
            innerHTML: `
                .veloxa-spinner {
                    width: 40px;
                    height: 40px;
                    border: 4px solid rgba(255, 255, 255, 0.3);
                    border-top: 4px solid white;
                    border-radius: 50%;
                    animation: spin 1s linear infinite;
                    margin: 0 auto;
                }
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            `
        });

        document.head.appendChild(style);
        document.body.appendChild(this.overlay);
        Veloxa.utils.addClass(this.overlay, 'veloxa-animate-scale-in');
    }

    static hide() {
        if (this.overlay) {
            Veloxa.utils.fadeOut(this.overlay, 200);
            setTimeout(() => {
                if (this.overlay && this.overlay.parentNode) {
                    this.overlay.parentNode.removeChild(this.overlay);
                    this.overlay = null;
                }
            }, 200);
        }
    }
};

// =========================================
// INITIALIZATION & GLOBAL EVENTS
// =========================================
Veloxa.initializeComponents = function() {
    // Initialize Modals
    Veloxa.utils.$('[data-modal]').forEach(modal => {
        new Veloxa.components.Modal(modal);
    });

    // Initialize Dropdowns
    Veloxa.utils.$('[data-dropdown]').forEach(dropdown => {
        new Veloxa.components.Dropdown(dropdown);
    });

    // Initialize scroll animations
    Veloxa.animations.observeElements('.veloxa-animate-on-scroll');

    // Initialize parallax elements
    if (Veloxa.utils.$('[data-parallax]').length > 0) {
        Veloxa.animations.parallax('[data-parallax]');
    }
};

Veloxa.setupGlobalEvents = function() {
    // Mobile menu toggle
    const mobileMenuToggle = Veloxa.utils.$('[data-mobile-menu-toggle]');
    const mobileMenu = Veloxa.utils.$('[data-mobile-menu]');
    
    if (mobileMenuToggle && mobileMenu) {
        Veloxa.utils.on(mobileMenuToggle, 'click', () => {
            Veloxa.utils.toggleClass(mobileMenu, 'veloxa-hidden');
        });
    }

    // Modal triggers
    Veloxa.utils.$('[data-modal-target]').forEach(trigger => {
        Veloxa.utils.on(trigger, 'click', (e) => {
            e.preventDefault();
            const targetId = trigger.getAttribute('data-modal-target');
            const modal = Veloxa.utils.$(`#${targetId}`);
            if (modal && modal.modalInstance) {
                modal.modalInstance.open();
            }
        });
    });

    // Smooth scroll for anchor links
    Veloxa.utils.$('a[href^="#"]').forEach(link => {
        Veloxa.utils.on(link, 'click', (e) => {
            const href = link.getAttribute('href');
            if (href === '#') return;
            
            e.preventDefault();
            const target = Veloxa.utils.$(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Form loading states
    Veloxa.utils.$('form[data-loading]').forEach(form => {
        Veloxa.utils.on(form, 'submit', () => {
            const submitBtn = Veloxa.utils.$('[type="submit"]', form);
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
                submitBtn.disabled = true;

                // Re-enable after 5 seconds (fallback)
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 5000);
            }
        });
    });
};

// =========================================
// API HELPER
// =========================================
Veloxa.api = {
    async request(url, options = {}) {
        const defaultOptions = {
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };

        // Add CSRF token if available
        const csrfToken = Veloxa.utils.$('meta[name="csrf-token"]');
        if (csrfToken) {
            defaultOptions.headers['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
        }

        const config = { ...defaultOptions, ...options };
        
        try {
            const response = await fetch(url, config);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return await response.json();
            }
            
            return await response.text();
        } catch (error) {
            console.error('API request failed:', error);
            throw error;
        }
    },

    async get(url, params = {}) {
        const searchParams = new URLSearchParams(params);
        const fullUrl = searchParams.toString() ? `${url}?${searchParams}` : url;
        return this.request(fullUrl);
    },

    async post(url, data = {}) {
        return this.request(url, {
            method: 'POST',
            body: JSON.stringify(data)
        });
    },

    async put(url, data = {}) {
        return this.request(url, {
            method: 'PUT',
            body: JSON.stringify(data)
        });
    },

    async delete(url) {
        return this.request(url, {
            method: 'DELETE'
        });
    }
};

// =========================================
// GLOBAL HELPERS
// =========================================
window.VeloxaToast = Veloxa.components.Toast;
window.VeloxaLoading = Veloxa.components.Loading;

// Initialize Veloxa when DOM is ready
Veloxa.init();