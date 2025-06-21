<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Veloxa | Nestlé Lanka SPD</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Veloxa Core CSS -->
    <link href="{{ asset('css/veloxa.css') }}" rel="stylesheet">
    
    <!-- Dashboard specific styles -->
    <style>
        .veloxa-dashboard {
            display: flex;
            min-height: 100vh;
            background: var(--veloxa-gray-50);
        }

        .veloxa-sidebar {
            width: 280px;
            background: white;
            border-right: 1px solid var(--veloxa-gray-200);
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 40;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            overflow-y: auto;
        }

        .veloxa-sidebar.open {
            transform: translateX(0);
        }

        .veloxa-main-content {
            flex: 1;
            margin-left: 0;
            transition: margin-left 0.3s ease;
        }

        .veloxa-sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--veloxa-gray-200);
            background: var(--veloxa-gradient-primary);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .veloxa-sidebar-nav {
            padding: 1rem;
        }

        .veloxa-nav-section {
            margin-bottom: 2rem;
        }

        .veloxa-nav-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--veloxa-gray-500);
            margin-bottom: 0.5rem;
            padding: 0 1rem;
        }

        .veloxa-nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            color: var(--veloxa-gray-600);
            text-decoration: none;
            border-radius: var(--veloxa-radius-lg);
            margin-bottom: 0.25rem;
            transition: all var(--veloxa-transition-fast);
            font-weight: 500;
            position: relative;
        }

        .veloxa-nav-item:hover {
            background: var(--veloxa-primary-50);
            color: var(--veloxa-primary-700);
            transform: translateX(4px);
        }

        .veloxa-nav-item.active {
            background: var(--veloxa-primary-100);
            color: var(--veloxa-primary-700);
            font-weight: 600;
            box-shadow: inset 3px 0 0 var(--veloxa-primary-600);
        }

        .veloxa-nav-item.active::before {
            content: '';
            position: absolute;
            right: 1rem;
            width: 6px;
            height: 6px;
            background: var(--veloxa-primary-600);
            border-radius: 50%;
        }

        .veloxa-nav-icon {
            width: 20px;
            text-align: center;
            font-size: 1.125rem;
        }

        .veloxa-nav-badge {
            background: var(--veloxa-primary-600);
            color: white;
            font-size: 0.625rem;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            margin-left: auto;
            font-weight: 600;
        }

        .veloxa-topbar {
            background: white;
            border-bottom: 1px solid var(--veloxa-gray-200);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: between;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 30;
            box-shadow: var(--veloxa-shadow-sm);
        }

        .veloxa-topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
        }

        .veloxa-topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .veloxa-mobile-menu-btn {
            background: none;
            border: none;
            padding: 0.5rem;
            border-radius: var(--veloxa-radius-md);
            color: var(--veloxa-gray-600);
            cursor: pointer;
            transition: all var(--veloxa-transition-fast);
        }

        .veloxa-mobile-menu-btn:hover {
            background: var(--veloxa-gray-100);
            color: var(--veloxa-gray-800);
        }

        .veloxa-search-bar {
            position: relative;
            max-width: 400px;
            flex: 1;
        }

        .veloxa-search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 2px solid var(--veloxa-gray-200);
            border-radius: var(--veloxa-radius-lg);
            background: var(--veloxa-gray-50);
            transition: all var(--veloxa-transition-fast);
            font-size: 0.875rem;
        }

        .veloxa-search-input:focus {
            outline: none;
            border-color: var(--veloxa-primary-500);
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .veloxa-search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--veloxa-gray-400);
            pointer-events: none;
        }

        .veloxa-notification-btn {
            position: relative;
            background: none;
            border: none;
            padding: 0.75rem;
            border-radius: var(--veloxa-radius-lg);
            color: var(--veloxa-gray-600);
            cursor: pointer;
            transition: all var(--veloxa-transition-fast);
        }

        .veloxa-notification-btn:hover {
            background: var(--veloxa-gray-100);
            color: var(--veloxa-gray-800);
        }

        .veloxa-notification-badge {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            width: 12px;
            height: 12px;
            background: var(--veloxa-error);
            border: 2px solid white;
            border-radius: 50%;
            font-size: 0.625rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .veloxa-user-menu {
            position: relative;
        }

        .veloxa-user-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: none;
            border: none;
            padding: 0.5rem;
            border-radius: var(--veloxa-radius-lg);
            cursor: pointer;
            transition: all var(--veloxa-transition-fast);
        }

        .veloxa-user-btn:hover {
            background: var(--veloxa-gray-100);
        }

        .veloxa-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--veloxa-gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .veloxa-user-info {
            text-align: left;
        }

        .veloxa-user-name {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--veloxa-gray-800);
            line-height: 1.2;
        }

        .veloxa-user-role {
            font-size: 0.75rem;
            color: var(--veloxa-gray-500);
            line-height: 1.2;
        }

        .veloxa-page-content {
            padding: 2rem;
        }

        .veloxa-page-header {
            margin-bottom: 2rem;
        }

        .veloxa-page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--veloxa-gray-900);
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .veloxa-page-subtitle {
            color: var(--veloxa-gray-600);
            font-size: 1rem;
        }

        .veloxa-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .veloxa-stat-card {
            background: white;
            border-radius: var(--veloxa-radius-xl);
            padding: 1.5rem;
            box-shadow: var(--veloxa-shadow-md);
            border: 1px solid var(--veloxa-gray-100);
            transition: all var(--veloxa-transition-normal);
            position: relative;
            overflow: hidden;
        }

        .veloxa-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--veloxa-gradient-primary);
        }

        .veloxa-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--veloxa-shadow-xl);
        }

        .veloxa-stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .veloxa-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--veloxa-radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
        }

        .veloxa-stat-value {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--veloxa-gray-900);
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .veloxa-stat-label {
            color: var(--veloxa-gray-600);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .veloxa-stat-change {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .veloxa-stat-change.positive {
            color: var(--veloxa-success);
        }

        .veloxa-stat-change.negative {
            color: var(--veloxa-error);
        }

        /* Mobile Responsive */
        @media (min-width: 1024px) {
            .veloxa-sidebar {
                position: static;
                transform: translateX(0);
            }

            .veloxa-main-content {
                margin-left: 280px;
            }

            .veloxa-mobile-menu-btn {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .veloxa-topbar {
                padding: 1rem;
            }

            .veloxa-search-bar {
                display: none;
            }

            .veloxa-page-content {
                padding: 1rem;
            }

            .veloxa-page-title {
                font-size: 1.5rem;
            }

            .veloxa-stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .veloxa-user-info {
                display: none;
            }
        }

        /* Sidebar backdrop for mobile */
        .veloxa-sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 35;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .veloxa-sidebar-backdrop.show {
            opacity: 1;
            visibility: visible;
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="veloxa-dashboard">
        
        <!-- Sidebar Backdrop (Mobile) -->
        <div class="veloxa-sidebar-backdrop" id="sidebarBackdrop"></div>

        <!-- Sidebar -->
        <aside class="veloxa-sidebar" id="sidebar">
            <!-- Sidebar Header -->
            <div class="veloxa-sidebar-header">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-cube text-xl text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-white font-bold text-lg">Veloxa</h1>
                            <p class="text-blue-100 text-xs">SPD Management</p>
                        </div>
                    </div>
                    <button class="veloxa-mobile-menu-btn text-white lg:hidden" onclick="Veloxa.toggleSidebar()">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- User Info -->
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="veloxa-user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ auth()->user()->getRoleDisplayName() }}</p>
                    </div>
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="veloxa-sidebar-nav">
                @yield('sidebar-nav')
            </nav>

            <!-- Sidebar Footer -->
            <div class="mt-auto p-4 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="veloxa-nav-item w-full text-red-600 hover:bg-red-50 hover:text-red-700">
                        <i class="fas fa-sign-out-alt veloxa-nav-icon"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="veloxa-main-content">
            <!-- Top Bar -->
            <header class="veloxa-topbar">
                <div class="veloxa-topbar-left">
                    <button class="veloxa-mobile-menu-btn lg:hidden" onclick="Veloxa.toggleSidebar()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <!-- Search Bar -->
                    <div class="veloxa-search-bar">
                        <input 
                            type="text" 
                            placeholder="Search..." 
                            class="veloxa-search-input"
                        >
                        <i class="fas fa-search veloxa-search-icon"></i>
                    </div>
                </div>

                <div class="veloxa-topbar-right">
                    <!-- Notifications -->
                    <button class="veloxa-notification-btn" data-dropdown data-dropdown-trigger>
                        <i class="fas fa-bell text-xl"></i>
                        <span class="veloxa-notification-badge">3</span>
                    </button>

                    <!-- User Menu -->
                    <div class="veloxa-user-menu" data-dropdown>
                        <button class="veloxa-user-btn" data-dropdown-trigger>
                            <div class="veloxa-user-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div class="veloxa-user-info">
                                <div class="veloxa-user-name">{{ auth()->user()->name }}</div>
                                <div class="veloxa-user-role">{{ auth()->user()->getRoleDisplayName() }}</div>
                            </div>
                            <i class="fas fa-chevron-down text-sm text-gray-400"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="veloxa-hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2" data-dropdown-menu>
                            <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-user-circle w-4"></i>
                                Profile
                            </a>
                            <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-cog w-4"></i>
                                Settings
                            </a>
                            <hr class="my-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left">
                                    <i class="fas fa-sign-out-alt w-4"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="veloxa-page-content">
                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="veloxa-alert veloxa-alert-success mb-6 veloxa-animate-slide-up">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="veloxa-alert veloxa-alert-error mb-6 veloxa-animate-slide-up">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/veloxa.js') }}"></script>
    <script>
        // Sidebar toggle functionality
        Veloxa.toggleSidebar = function() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            
            sidebar.classList.toggle('open');
            backdrop.classList.toggle('show');
        };

        // Close sidebar when clicking backdrop
        document.getElementById('sidebarBackdrop').addEventListener('click', function() {
            Veloxa.toggleSidebar();
        });

        // Close sidebar on window resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                const sidebar = document.getElementById('sidebar');
                const backdrop = document.getElementById('sidebarBackdrop');
                sidebar.classList.remove('open');
                backdrop.classList.remove('show');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>