<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EMS') | Employee Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>body{font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;}</style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-200">
                <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-gray-900 flex items-center gap-2 hover:opacity-80 transition">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold">E</span>
                    </div>
                    EMS
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                    </svg>
                    <span class="font-semibold">Dashboard</span>
                </a>

                    <div class="pt-4">
                        <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Management</p>
                    </div>

                <a href="{{ route('employees.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('employees.*') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                    </svg>
                    <span>Employees</span>
                </a>

                <a href="{{ route('departments.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('departments.*') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM15 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2zM5 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5z"></path>
                    </svg>
                    <span>Departments</span>
                </a>
            </nav>

            <!-- Footer -->
            <div class="p-4 border-t border-gray-200">
                <div class="text-xs text-gray-500">
                    <p class="font-semibold">EMS v1.0</p>
                    <p class="mt-1">&copy; 2025</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex justify-between items-center px-8 py-4">
                    <div>
                        <h2 class="text-gray-900 font-semibold">@yield('page_title', 'Dashboard')</h2>
                    </div>
                    <div class="flex items-center gap-4 relative">
                        <!-- Search -->
                        <div class="hidden sm:block">
                            <input type="text" placeholder="Search" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-48">
                        </div>

                        <!-- Notifications -->
                        <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg relative">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.5 1.5H3a1.5 1.5 0 00-1.5 1.5v12a1.5 1.5 0 001.5 1.5h10a1.5 1.5 0 001.5-1.5V11.3a4 4 0 015.6 3.4V15a4 4 0 11-8 0v-.3a4 4 0 015.6-3.4V15a2 2 0 11-4 0V4"></path>
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- Profile Dropdown -->
                        <div class="relative group">
                            <button class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center text-white font-bold cursor-pointer hover:shadow-lg transition">
                                DU
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-0 w-48 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <!-- User Info -->
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                            DU
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 text-sm">Demo User</p>
                                            <p class="text-xs text-gray-500">Administrator</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Menu Items -->
                                <div class="py-2">
                                    <a href="#" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>My Profile</span>
                                    </a>

                                    <button onclick="toggleTheme()" class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                                        </svg>
                                        <span id="themeText">Dark Mode</span>
                                    </button>

                                    <button onclick="toggleDisplay()" class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                                            <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm11 4a2 2 0 11-4 0 2 2 0 014 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span id="displayText">Compact</span>
                                    </button>

                                    <div class="border-t border-gray-200 my-2"></div>

                                    <a href="#" class="px-4 py-2 text-sm text-red-700 hover:bg-red-50 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Sign out</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-auto">
                <div class="p-8">
                    @if ($message = Session::get('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                            <ul class="space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        // Theme Toggle
        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            const themeText = document.getElementById('themeText');
            
            if (isDark) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                themeText.textContent = 'Dark Mode';
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                themeText.textContent = 'Light Mode';
            }
        }

        // Display Mode Toggle
        function toggleDisplay() {
            const body = document.body;
            const isCompact = body.classList.contains('compact-mode');
            const displayText = document.getElementById('displayText');
            
            if (isCompact) {
                body.classList.remove('compact-mode');
                localStorage.setItem('display-mode', 'full');
                displayText.textContent = 'Compact';
            } else {
                body.classList.add('compact-mode');
                localStorage.setItem('display-mode', 'compact');
                displayText.textContent = 'Full';
            }
        }

        // Load theme from localStorage on page load
        window.addEventListener('load', function() {
            const theme = localStorage.getItem('theme');
            const displayMode = localStorage.getItem('display-mode');
            
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                document.getElementById('themeText').textContent = 'Light Mode';
            }
            
            if (displayMode === 'compact') {
                document.body.classList.add('compact-mode');
                document.getElementById('displayText').textContent = 'Full';
            }
        });

        // Add global styles for dark mode and compact mode
        const style = document.createElement('style');
        style.textContent = `
            html.dark {
                color-scheme: dark;
            }
            
            html.dark body {
                @apply bg-gray-900 text-gray-100;
            }
            
            html.dark .bg-white {
                @apply bg-gray-800;
            }
            
            html.dark .text-gray-900 {
                @apply text-gray-100;
            }
            
            html.dark .border-gray-200 {
                @apply border-gray-700;
            }
            
            body.compact-mode {
                font-size: 13px;
            }
            
            body.compact-mode .p-6 {
                @apply p-4;
            }
            
            body.compact-mode .px-8 {
                @apply px-6;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
