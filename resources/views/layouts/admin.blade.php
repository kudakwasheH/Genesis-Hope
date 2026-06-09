<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 dark:bg-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - {{ $siteSettings['site_name'] ?? 'Genesis Goodhope Population Health' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js (for analytics) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Tailwind & App Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
    @yield('styles')
</head>
<body class="h-full flex text-slate-800 dark:text-slate-200">

    <!-- Sidebar -->
    <aside id="admin-sidebar" class="hidden md:flex flex-col w-64 bg-slate-900 text-slate-400 shrink-0 border-r border-slate-800 transition-all duration-300">
        <!-- Brand logo -->
        <div class="h-20 flex items-center space-x-3 border-b border-slate-800 px-6">
            <img src="{{ asset('images/logo.jpg') }}" alt="Genesis Logo" class="h-9 w-auto rounded-md border border-slate-750">
            <span class="text-base font-black bg-gradient-to-r from-teal-400 to-emerald-400 bg-clip-text text-transparent tracking-tight">
                GENESIS PANEL
            </span>
        </div>

        <!-- User profile summary -->
        <div class="p-6 border-b border-slate-800 flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-teal-500/10 border border-teal-500/20 text-teal-400 flex items-center justify-center font-bold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="truncate text-xs">
                <p class="font-bold text-white leading-tight">{{ Auth::user()->name }}</p>
                <p class="text-slate-500 mt-0.5 capitalize">{{ Auth::user()->role }} Portal</p>
            </div>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="flex-grow py-6 px-4 space-y-1.5 overflow-y-auto text-sm">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-colors {{ Route::is('dashboard') ? 'bg-teal-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-chart-pie w-5"></i>
                <span>Analytics Home</span>
            </a>
            
            <a href="{{ route('admin.appointments.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-colors {{ Route::is('admin.appointments.*') ? 'bg-teal-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-calendar-check w-5"></i>
                <span>Appointments</span>
            </a>
            
            <a href="{{ route('admin.patients.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-colors {{ Route::is('admin.patients.*') ? 'bg-teal-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-users-medical w-5"></i>
                <span>Patients</span>
            </a>

            <a href="{{ route('admin.services.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-colors {{ Route::is('admin.services.*') ? 'bg-teal-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-stethoscope w-5"></i>
                <span>Health Services</span>
            </a>

            <a href="{{ route('admin.blogs.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-colors {{ Route::is('admin.blogs.*') ? 'bg-teal-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-newspaper w-5"></i>
                <span>Blog Posts</span>
            </a>

            <a href="{{ route('admin.testimonials.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-colors {{ Route::is('admin.testimonials.*') ? 'bg-teal-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-star w-5"></i>
                <span>Testimonials</span>
            </a>

            <a href="{{ route('admin.contact.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-colors {{ Route::is('admin.contact.*') ? 'bg-teal-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-inbox w-5"></i>
                <span>Contact Inbox</span>
            </a>

            @if(Auth::user()->role === 'admin')
                <div class="pt-4 pb-2 text-[10px] uppercase font-bold text-slate-600 px-4 tracking-wider">Administration</div>
                
                <a href="{{ route('admin.staff.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-colors {{ Route::is('admin.staff.*') ? 'bg-teal-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-user-shield w-5"></i>
                    <span>Staff Management</span>
                </a>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-colors {{ Route::is('admin.settings.*') ? 'bg-teal-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-gears w-5"></i>
                    <span>Website Settings</span>
                </a>
            @endif
        </nav>
    </aside>

    <!-- Main Workspace Area -->
    <div class="flex-grow flex flex-col min-w-0 overflow-y-auto">
        <!-- Top bar -->
        <header class="h-20 bg-white dark:bg-slate-800 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between px-6 shrink-0 relative z-30">
            <div class="flex items-center space-x-4">
                <button type="button" onclick="toggleSidebar()" class="md:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 focus:outline-none focus:ring">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <a href="{{ route('home') }}" class="text-xs sm:text-sm font-semibold text-teal-600 hover:underline">
                    <i class="fa-solid fa-globe mr-1.5"></i> Visit Public Site
                </a>
            </div>

            <!-- Profile Menu Dropdown -->
            <div class="flex items-center space-x-4">
                <!-- Profile dropdown trigger -->
                <div class="relative" id="profile-dropdown">
                    <button onclick="toggleDropdown()" class="flex items-center space-x-2 text-sm font-semibold text-slate-700 dark:text-slate-300 focus:outline-none">
                        <span>{{ Auth::user()->name }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </button>
                    <!-- Dropdown Options -->
                    <div id="dropdown-menu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl shadow-xl py-2 z-50 text-slate-700 dark:text-slate-300">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-slate-50 dark:hover:bg-slate-900 text-xs font-semibold">My Account Profile</a>
                        <hr class="border-slate-100 dark:border-slate-700 my-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-slate-50 dark:hover:bg-slate-900 text-xs font-semibold text-rose-500">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Body Wrapper -->
        <main class="flex-grow p-6 md:p-8">
            @yield('content')
            @isset($slot)
                {{ $slot }}
            @endisset
        </main>
    </div>

    <!-- Scripts -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('fixed', 'inset-y-0', 'left-0', 'z-40');
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('fixed', 'inset-y-0', 'left-0', 'z-40');
            }
        }

        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown-menu');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            const container = document.getElementById('profile-dropdown');
            const dropdown = document.getElementById('dropdown-menu');
            if (container && !container.contains(e.target) && dropdown) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
