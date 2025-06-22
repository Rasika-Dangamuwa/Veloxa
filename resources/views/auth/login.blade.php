<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veloxa - Login</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/veloxa.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mobile.css') }}" rel="stylesheet">
    
    <style>
        /* Login Specific Styles */
        .login-container {
            background: linear-gradient(135deg, var(--blue-600) 0%, var(--blue-800) 100%);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        [data-theme="dark"] .login-container {
            background: linear-gradient(135deg, var(--blue-900) 0%, #0f172a 100%);
        }

        .login-bg-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.1;
            background-image: 
                radial-gradient(circle at 20% 20%, rgba(255,255,255,0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255,255,255,0.2) 0%, transparent 50%),
                radial-gradient(circle at 40% 70%, rgba(255,255,255,0.1) 0%, transparent 50%);
        }

        .floating-shapes {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        .login-card {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        [data-theme="dark"] .login-card {
            background: rgba(15, 23, 42, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo-container {
            background: linear-gradient(135deg, var(--blue-500), var(--blue-600));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-tertiary);
            pointer-events: none;
        }

        .form-input.with-icon {
            padding-left: 2.5rem;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-tertiary);
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all var(--transition-fast);
        }

        .password-toggle:hover {
            color: var(--text-secondary);
            background: var(--bg-secondary);
        }

        .remember-checkbox {
            appearance: none;
            width: 1rem;
            height: 1rem;
            border: 1px solid var(--border-primary);
            border-radius: 3px;
            background: var(--bg-primary);
            cursor: pointer;
            position: relative;
            transition: all var(--transition-fast);
        }

        .remember-checkbox:checked {
            background: var(--blue-500);
            border-color: var(--blue-500);
        }

        .remember-checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: -2px;
            left: 1px;
            color: white;
            font-size: 0.75rem;
            font-weight: bold;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.5rem;
            background: var(--bg-secondary);
            border: 1px solid var(--border-primary);
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .theme-toggle-login {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 10;
        }

        @media (max-width: 640px) {
            .login-card {
                margin: 1rem;
                padding: 1.5rem;
            }
            
            .theme-toggle-login {
                top: 0.5rem;
                right: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Theme Toggle -->
    <div class="theme-toggle-login">
        <button class="theme-toggle">
            <div class="theme-toggle-slider">☀️</div>
        </button>
    </div>

    <div class="login-container">
        <!-- Background Pattern -->
        <div class="login-bg-pattern"></div>
        
        <!-- Floating Shapes -->
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <!-- Login Content -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="w-full max-w-md">
                <!-- Logo and Branding -->
                <div class="text-center mb-8 animate-fade-in">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl shadow-lg mb-4 animate-float">
                        <i class="fas fa-cube text-2xl logo-container"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Veloxa</h1>
                    <p class="text-blue-100">Nestlé Lanka Sales Promotion System</p>
                </div>

                <!-- Login Card -->
                <div class="login-card rounded-2xl p-8 animate-fade-in" style="animation-delay: 0.2s;">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-primary mb-2">Welcome Back</h2>
                        <p class="text-secondary">Sign in to your account to continue</p>
                    </div>

                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg animate-slide-in" data-auto-hide>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>{{ session('success') }}</span>
                                <button class="alert-close ml-auto">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg animate-slide-in" data-auto-hide>
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <span>{{ session('error') }}</span>
                                <button class="alert-close ml-auto">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="email" class="form-label">
                                Email Address
                            </label>
                            <div class="input-group">
                                <i class="fas fa-envelope input-icon"></i>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email') }}"
                                    class="form-input with-icon @error('email') border-red-500 @enderror"
                                    placeholder="Enter your email address"
                                    required
                                    autocomplete="email"
                                >
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <label for="password" class="form-label">
                                Password
                            </label>
                            <div class="input-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="form-input with-icon @error('password') border-red-500 @enderror"
                                    placeholder="Enter your password"
                                    required
                                    autocomplete="current-password"
                                >
                                <button type="button" class="password-toggle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    name="remember" 
                                    class="remember-checkbox"
                                >
                                <span class="text-sm text-secondary">Remember me</span>
                            </label>
                            <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">
                                Forgot password?
                            </a>
                        </div>

                        <!-- Login Button -->
                        <button 
                            type="submit" 
                            class="btn btn-primary w-full text-base py-3"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Sign In
                        </button>
                    </form>

                    <!-- Available Roles Info -->
                    <div class="mt-8 pt-6 border-t border-primary">
                        <p class="text-center text-xs text-tertiary mb-3">Available User Roles:</p>
                        <div class="flex flex-wrap justify-center gap-2">
                            <div class="role-badge">
                                <i class="fas fa-crown text-blue-500"></i>
                                <span>Admin</span>
                            </div>
                            <div class="role-badge">
                                <i class="fas fa-user-tie text-blue-500"></i>
                                <span>HOD</span>
                            </div>
                            <div class="role-badge">
                                <i class="fas fa-briefcase text-blue-500"></i>
                                <span>Manager</span>
                            </div>
                            <div class="role-badge">
                                <i class="fas fa-warehouse text-blue-500"></i>
                                <span>Warehouse</span>
                            </div>
                            <div class="role-badge">
                                <i class="fas fa-truck text-blue-500"></i>
                                <span>Propagandist</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-8 animate-fade-in" style="animation-delay: 0.4s;">
                    <p class="text-blue-100 text-sm">
                        © 2025 Nestlé Lanka Limited. All rights reserved.
                    </p>
                    <p class="text-blue-200 text-xs mt-1">
                        Powered by Veloxa v1.0
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('js/veloxa.js') }}"></script>
    
    <script>
        // Page-specific JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Add staggered animation to role badges
            const roleBadges = document.querySelectorAll('.role-badge');
            roleBadges.forEach((badge, index) => {
                badge.style.animationDelay = `${0.6 + (index * 0.1)}s`;
                badge.classList.add('animate-fade-in');
            });

            // Focus management
            const emailInput = document.getElementById('email');
            if (emailInput && !emailInput.value) {
                emailInput.focus();
            }

            // Enhanced form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                if (!email || !password) {
                    e.preventDefault();
                    window.VeloxaUI.showToast('Please fill in all required fields', 'error');
                    return;
                }

                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Signing In...';
                submitBtn.disabled = true;
            });

            // Demo credentials tooltip (remove in production)
            if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
                const emailInput = document.getElementById('email');
                emailInput.title = 'Demo: admin@spdhub.com';
                
                const passwordInput = document.getElementById('password');
                passwordInput.title = 'Demo: password';
            }
        });
    </script>
</body>
</html>