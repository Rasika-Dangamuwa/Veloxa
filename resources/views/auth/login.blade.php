<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Veloxa - Login | Nestlé Lanka SPD</title>
    
    <!-- Preload critical fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Veloxa Core CSS -->
    <link href="{{ asset('css/veloxa.css') }}" rel="stylesheet">
    
    <!-- Page specific styles -->
    <style>
        .veloxa-login-container {
            min-height: 100vh;
            background: var(--veloxa-gradient-mesh);
            position: relative;
            overflow: hidden;
        }

        .veloxa-login-bg-elements {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .veloxa-bg-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(40px);
        }

        .veloxa-bg-circle-1 {
            width: 400px;
            height: 400px;
            top: -200px;
            right: -200px;
            animation: veloxa-float 6s ease-in-out infinite;
        }

        .veloxa-bg-circle-2 {
            width: 300px;
            height: 300px;
            bottom: -150px;
            left: -150px;
            animation: veloxa-float 8s ease-in-out infinite reverse;
        }

        .veloxa-bg-circle-3 {
            width: 200px;
            height: 200px;
            top: 50%;
            left: 20%;
            animation: veloxa-pulse 4s ease-in-out infinite;
            opacity: 0.6;
        }

        .veloxa-login-card {
            backdrop-filter: blur(30px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.2);
        }

        .veloxa-logo-container {
            background: linear-gradient(135deg, var(--veloxa-primary-500), var(--veloxa-primary-600));
            box-shadow: var(--veloxa-shadow-lg);
        }

        .veloxa-input-floating {
            position: relative;
        }

        .veloxa-input-floating input {
            padding: 1rem 3rem 1rem 1rem;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(59, 130, 246, 0.2);
            transition: all 0.3s ease;
        }

        .veloxa-input-floating input:focus {
            background: white;
            border-color: var(--veloxa-primary-500);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            transform: translateY(-2px);
        }

        .veloxa-input-floating label {
            position: absolute;
            left: 1rem;
            top: 1rem;
            color: var(--veloxa-gray-500);
            transition: all 0.3s ease;
            pointer-events: none;
            background: white;
            padding: 0 0.5rem;
            border-radius: 4px;
        }

        .veloxa-input-floating input:focus + label,
        .veloxa-input-floating input:not(:placeholder-shown) + label {
            top: -0.5rem;
            left: 0.75rem;
            font-size: 0.75rem;
            color: var(--veloxa-primary-600);
            font-weight: 600;
        }

        .veloxa-login-btn {
            background: var(--veloxa-gradient-primary);
            border: none;
            box-shadow: 
                var(--veloxa-shadow-lg),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .veloxa-login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 
                0 20px 40px -12px rgba(37, 99, 235, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .veloxa-login-btn:active {
            transform: translateY(-1px);
        }

        .veloxa-login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .veloxa-login-btn:hover::before {
            left: 100%;
        }

        .veloxa-role-badge {
            background: rgba(37, 99, 235, 0.1);
            color: var(--veloxa-primary-700);
            border: 1px solid rgba(37, 99, 235, 0.2);
            backdrop-filter: blur(10px);
        }

        .veloxa-password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--veloxa-gray-400);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
        }

        .veloxa-password-toggle:hover {
            color: var(--veloxa-primary-600);
            background: rgba(59, 130, 246, 0.1);
        }

        @media (max-width: 640px) {
            .veloxa-login-card {
                margin: 1rem;
                padding: 2rem;
            }
            
            .veloxa-bg-circle-1,
            .veloxa-bg-circle-2 {
                transform: scale(0.7);
            }
        }

        /* Loading state */
        .veloxa-btn-loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .veloxa-btn-loading .veloxa-btn-text {
            opacity: 0;
        }

        .veloxa-btn-loading .veloxa-btn-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Alert animations */
        .veloxa-alert-enter {
            animation: veloxa-slide-up 0.3s ease-out;
        }
    </style>
</head>

<body class="veloxa-login-container">
    <!-- Background Elements -->
    <div class="veloxa-login-bg-elements">
        <div class="veloxa-bg-circle veloxa-bg-circle-1"></div>
        <div class="veloxa-bg-circle veloxa-bg-circle-2"></div>
        <div class="veloxa-bg-circle veloxa-bg-circle-3"></div>
    </div>

    <!-- Main Login Container -->
    <div class="min-h-screen flex items-center justify-center px-4 relative z-10">
        <div class="w-full max-w-md">
            
            <!-- Logo & Brand Section -->
            <div class="text-center mb-8 veloxa-animate-slide-up">
                <div class="veloxa-logo-container inline-flex items-center justify-center w-20 h-20 rounded-2xl mb-6 veloxa-animate-float">
                    <i class="fas fa-cube text-3xl text-white"></i>
                </div>
                <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">Veloxa</h1>
                <p class="text-blue-100 font-medium">Nestlé Lanka SPD Management System</p>
                <div class="mt-4 flex justify-center">
                    <div class="veloxa-role-badge px-4 py-2 rounded-full text-sm font-medium">
                        Sales Promotion Department
                    </div>
                </div>
            </div>

            <!-- Login Form Card -->
            <div class="veloxa-login-card rounded-3xl p-8 veloxa-animate-scale-in" style="animation-delay: 0.2s;">
                
                <!-- Form Header -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Welcome Back</h2>
                    <p class="text-gray-600">Please sign in to your account</p>
                </div>

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="veloxa-alert veloxa-alert-success veloxa-alert-enter mb-6">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="veloxa-alert veloxa-alert-error veloxa-alert-enter mb-6">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" id="loginForm" data-loading>
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Email Field -->
                        <div class="veloxa-input-floating">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                placeholder=" "
                                class="w-full rounded-xl @error('email') border-red-500 @enderror"
                                required
                                autocomplete="email"
                            >
                            <label for="email">
                                <i class="fas fa-envelope mr-2"></i>Email Address
                            </label>
                            @error('email')
                                <div class="text-red-600 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="veloxa-input-floating">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder=" "
                                class="w-full rounded-xl pr-12 @error('password') border-red-500 @enderror"
                                required
                                autocomplete="current-password"
                            >
                            <label for="password">
                                <i class="fas fa-lock mr-2"></i>Password
                            </label>
                            <button type="button" class="veloxa-password-toggle" onclick="Veloxa.togglePassword('password')">
                                <i class="fas fa-eye" id="passwordIcon"></i>
                            </button>
                            @error('password')
                                <div class="text-red-600 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer group">
                                <input 
                                    type="checkbox" 
                                    name="remember" 
                                    class="w-4 h-4 rounded border-2 border-gray-300 text-blue-600 focus:ring-blue-500 focus:ring-2 transition-all"
                                >
                                <span class="ml-3 text-sm text-gray-600 group-hover:text-gray-800 transition-colors">
                                    Remember me
                                </span>
                            </label>
                            <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                                Forgot password?
                            </a>
                        </div>

                        <!-- Login Button -->
                        <button 
                            type="submit" 
                            class="veloxa-login-btn w-full py-4 px-6 text-white font-semibold rounded-xl transition-all duration-300"
                            id="loginButton"
                        >
                            <span class="veloxa-btn-text flex items-center justify-center">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Sign In to Veloxa
                            </span>
                            <div class="veloxa-btn-spinner hidden">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </button>
                    </div>
                </form>

                <!-- Available Roles Information -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-center text-xs text-gray-500 mb-4 font-medium">Available User Roles</p>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex items-center justify-center p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-100">
                            <div class="text-center">
                                <i class="fas fa-crown text-blue-600 mb-1"></i>
                                <p class="text-xs font-medium text-blue-800">HOD</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-100">
                            <div class="text-center">
                                <i class="fas fa-user-tie text-green-600 mb-1"></i>
                                <p class="text-xs font-medium text-green-800">Manager</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border border-purple-100">
                            <div class="text-center">
                                <i class="fas fa-truck text-purple-600 mb-1"></i>
                                <p class="text-xs font-medium text-purple-800">Propagandist</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center p-3 bg-gradient-to-r from-orange-50 to-amber-50 rounded-lg border border-orange-100">
                            <div class="text-center">
                                <i class="fas fa-warehouse text-orange-600 mb-1"></i>
                                <p class="text-xs font-medium text-orange-800">Warehouse</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8 veloxa-animate-slide-up" style="animation-delay: 0.4s;">
                <p class="text-blue-100 text-sm font-medium">
                    © 2025 Nestlé Lanka Limited. All rights reserved.
                </p>
                <p class="text-blue-200 text-xs mt-1">
                    Powered by Veloxa v1.0
                </p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/veloxa.js') }}"></script>
    <script>
        // Password toggle functionality
        Veloxa.togglePassword = function(inputId) {
            const passwordField = document.getElementById(inputId);
            const passwordIcon = document.getElementById(inputId + 'Icon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordIcon.className = 'fas fa-eye-slash';
            } else {
                passwordField.type = 'password';
                passwordIcon.className = 'fas fa-eye';
            }
        };

        // Enhanced form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const submitButton = document.getElementById('loginButton');
            const buttonText = submitButton.querySelector('.veloxa-btn-text');
            const buttonSpinner = submitButton.querySelector('.veloxa-btn-spinner');
            
            // Add loading state
            submitButton.classList.add('veloxa-btn-loading');
            buttonText.classList.add('hidden');
            buttonSpinner.classList.remove('hidden');
            
            // Disable button
            submitButton.disabled = true;
        });

        // Show success toast for demo
        document.addEventListener('DOMContentLoaded', function() {
            // Add stagger animation to role cards
            setTimeout(() => {
                Veloxa.animations.staggerElements('.grid div', 100);
            }, 600);
        });
    </script>
</body>
</html>