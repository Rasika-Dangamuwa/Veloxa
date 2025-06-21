<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - SPD Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd',
                            400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8',
                            800: '#1e40af', 900: '#1e3a8a', 950: '#172554'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <i class="fas fa-cube text-primary-600 text-2xl mr-3"></i>
                    <h1 class="text-xl font-bold text-gray-900">SPD Hub</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-700">Welcome, {{ $user->name }}</span>
                    <span class="px-2 py-1 bg-primary-100 text-primary-800 text-xs rounded-full">
                        {{ $user->getRoleDisplayName() }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <!-- Dashboard Title -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">{{ $title }}</h2>
            <p class="mt-1 text-sm text-gray-600">Manage your daily operations and track performance</p>
        </div>

        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-lg p-6 text-white mb-8">
            <h3 class="text-xl font-bold mb-2">Welcome back, {{ $user->name }}!</h3>
            <p class="text-primary-100">You're logged in as {{ $user->getRoleDisplayName() }}. Here's what's happening today.</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Today's Tasks</p>
                        <p class="text-2xl font-bold text-gray-900">5</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Completed</p>
                        <p class="text-2xl font-bold text-gray-900">12</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pending</p>
                        <p class="text-2xl font-bold text-gray-900">3</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Team Members</p>
                        <p class="text-2xl font-bold text-gray-900">8</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <button class="flex items-center p-4 bg-primary-50 hover:bg-primary-100 rounded-lg transition-colors">
                        <i class="fas fa-plus-circle text-2xl text-primary-600 mr-4"></i>
                        <div class="text-left">
                            <p class="font-medium text-primary-700">Create New Event</p>
                            <p class="text-sm text-primary-600">Add a new promotional event</p>
                        </div>
                    </button>

                    <button class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                        <i class="fas fa-box-open text-2xl text-green-600 mr-4"></i>
                        <div class="text-left">
                            <p class="font-medium text-green-700">Manage Stock</p>
                            <p class="text-sm text-green-600">Update inventory levels</p>
                        </div>
                    </button>

                    <button class="flex items-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors">
                        <i class="fas fa-chart-bar text-2xl text-yellow-600 mr-4"></i>
                        <div class="text-left">
                            <p class="font-medium text-yellow-700">View Reports</p>
                            <p class="text-sm text-yellow-600">Check performance metrics</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Role-Specific Content -->
        <div class="mt-8 bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">{{ $user->getRoleDisplayName() }} Features</h3>
            </div>
            <div class="p-6">
                @if($user->hasRole('master_admin'))
                    <div class="text-center py-8">
                        <i class="fas fa-cogs text-4xl text-gray-400 mb-4"></i>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">System Administration</h4>
                        <p class="text-gray-600">Manage users, system settings, and monitor overall performance.</p>
                    </div>
                @elseif($user->hasRole('hod'))
                    <div class="text-center py-8">
                        <i class="fas fa-crown text-4xl text-gray-400 mb-4"></i>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Department Leadership</h4>
                        <p class="text-gray-600">Approve events, manage team workload, and track department performance.</p>
                    </div>
                @elseif($user->hasRole('manager'))
                    <div class="text-center py-8">
                        <i class="fas fa-user-tie text-4xl text-gray-400 mb-4"></i>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Brand Management</h4>
                        <p class="text-gray-600">Manage brand promotions, assign propagandists, and track campaign success.</p>
                    </div>
                @elseif($user->hasRole('warehouse'))
                    <div class="text-center py-8">
                        <i class="fas fa-warehouse text-4xl text-gray-400 mb-4"></i>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Inventory Control</h4>
                        <p class="text-gray-600">Manage stock levels, process transfers, and maintain inventory records.</p>
                    </div>
                @elseif($user->hasRole('propagandist'))
                    <div class="text-center py-8">
                        <i class="fas fa-truck text-4xl text-gray-400 mb-4"></i>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Field Operations</h4>
                        <p class="text-gray-600">Execute events, manage vehicle stock, and run gift distribution activities.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>