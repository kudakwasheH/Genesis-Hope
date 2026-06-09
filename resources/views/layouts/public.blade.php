<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $siteSettings['site_name'] ?? 'Genesis Goodhope Population Health')</title>
    <meta name="description" content="@yield('meta_description', 'Genesis Goodhope Population Health - Empowering health and wellness in Harare, Zimbabwe. Book consultations, manage wellness, chronic care.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind & App Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
        .glass-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }
    </style>
    @yield('styles')
</head>
<body class="h-full bg-slate-50 text-slate-800 flex flex-col">

    <!-- Top Bar -->
    <div class="bg-gradient-to-r from-teal-800 to-emerald-700 text-white py-2 px-4 text-sm font-medium">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center space-y-1 sm:space-y-0">
            <div class="flex items-center space-x-4">
                <span><i class="fa-solid fa-phone mr-1"></i> {{ $siteSettings['site_phone'] ?? '071 216 2369' }}</span>
                <span class="hidden md:inline">|</span>
                <span class="hidden md:inline"><i class="fa-solid fa-envelope mr-1"></i> {{ $siteSettings['site_email'] ?? 'info@genesis.org.zw' }}</span>
            </div>
            <div class="flex items-center space-x-4">
                <span><i class="fa-solid fa-clock mr-1"></i> {{ $siteSettings['working_hours'] ?? 'Mon - Fri: 8 AM - 5 PM' }}</span>
            </div>
        </div>
    </div>

    <!-- Header Navigation -->
    <header class="glass-header sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Genesis Goodhope Logo" class="h-12 w-auto rounded-lg shadow-sm border border-slate-200">
                    <span class="text-xl font-black bg-gradient-to-r from-teal-700 to-emerald-600 bg-clip-text text-transparent tracking-tight hidden sm:inline-block">
                        GENESIS GOODHOPE
                    </span>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="font-medium {{ Route::is('home') ? 'text-teal-600' : 'text-slate-600 hover:text-teal-600' }} transition-colors">Home</a>
                    <a href="{{ route('about') }}" class="font-medium {{ Route::is('about') ? 'text-teal-600' : 'text-slate-600 hover:text-teal-600' }} transition-colors">About Us</a>
                    <a href="{{ route('services') }}" class="font-medium {{ Route::is('services') ? 'text-teal-600' : 'text-slate-600 hover:text-teal-600' }} transition-colors">Services</a>
                    <a href="{{ route('blog.index') }}" class="font-medium {{ Route::is('blog.*') ? 'text-teal-600' : 'text-slate-600 hover:text-teal-600' }} transition-colors">Blog</a>
                    <a href="{{ route('contact') }}" class="font-medium {{ Route::is('contact') ? 'text-teal-600' : 'text-slate-600 hover:text-teal-600' }} transition-colors">Contact Us</a>
                </nav>

                <!-- Action Button -->
                <div class="hidden lg:flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition-colors duration-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-teal-600 font-medium transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-full bg-slate-900 hover:bg-slate-800 text-white font-semibold transition-all shadow-sm">Register</a>
                    @endauth
                    <a href="{{ route('booking.index') }}" class="px-5 py-2.5 rounded-full bg-gradient-to-r from-teal-600 to-emerald-500 hover:from-teal-700 hover:to-emerald-600 text-white font-semibold transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        Book Appointment
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button type="button" id="mobile-menu-btn" class="lg:hidden p-2 rounded-md text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-teal-500">
                    <span class="sr-only">Open main menu</span>
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-slate-100 py-4 px-6 space-y-3 shadow-inner">
            <a href="{{ route('home') }}" class="block font-medium py-2 {{ Route::is('home') ? 'text-teal-600' : 'text-slate-600' }}">Home</a>
            <a href="{{ route('about') }}" class="block font-medium py-2 {{ Route::is('about') ? 'text-teal-600' : 'text-slate-600' }}">About Us</a>
            <a href="{{ route('services') }}" class="block font-medium py-2 {{ Route::is('services') ? 'text-teal-600' : 'text-slate-600' }}">Services</a>
            <a href="{{ route('blog.index') }}" class="block font-medium py-2 {{ Route::is('blog.*') ? 'text-teal-600' : 'text-slate-600' }}">Blog</a>
            <a href="{{ route('contact') }}" class="block font-medium py-2 {{ Route::is('contact') ? 'text-teal-600' : 'text-slate-600' }}">Contact Us</a>
            <hr class="border-slate-100 my-2">
            @auth
                <a href="{{ route('dashboard') }}" class="block w-full text-center px-4 py-2.5 rounded-full bg-slate-100 text-slate-700 font-semibold">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="block w-full text-center py-2 text-slate-600 font-medium">Login</a>
                <a href="{{ route('register') }}" class="block w-full text-center py-2 text-slate-600 font-medium">Register</a>
            @endauth
            <a href="{{ route('booking.index') }}" class="block w-full text-center px-4 py-2.5 rounded-full bg-gradient-to-r from-teal-600 to-emerald-500 text-white font-semibold">
                Book Appointment
            </a>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 pt-16 pb-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <!-- Brand Column -->
            <div class="space-y-4">
                <span class="text-xl font-bold text-white tracking-tight">Genesis Goodhope</span>
                <p class="text-sm leading-relaxed">
                    {{ $siteSettings['hero_subtitle'] ?? 'Dedicated to delivering professional, community-centered healthcare, wellness, and preventive care programs.' }}
                </p>
                <div class="flex space-x-4 pt-2">
                    <a href="#" class="text-slate-400 hover:text-white transition-colors"><i class="fa-brands fa-facebook text-xl"></i></a>
                    <a href="#" class="text-slate-400 hover:text-white transition-colors"><i class="fa-brands fa-twitter text-xl"></i></a>
                    <a href="#" class="text-slate-400 hover:text-white transition-colors"><i class="fa-brands fa-linkedin text-xl"></i></a>
                    <a href="#" class="text-slate-400 hover:text-white transition-colors"><i class="fa-brands fa-instagram text-xl"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-white font-semibold text-lg mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">About Us</a></li>
                    <li><a href="{{ route('services') }}" class="hover:text-white transition-colors">Services</a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-white transition-colors">Blog & Awareness</a></li>
                    <li><a href="{{ route('booking.index') }}" class="hover:text-white transition-colors">Book an Appointment</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h3 class="text-white font-semibold text-lg mb-4">Our Focus Areas</h3>
                <ul class="space-y-2 text-sm">
                    <li>Preventive Screenings</li>
                    <li>Chronic Disease Management</li>
                    <li>Wellness & Nutrition Programs</li>
                    <li>Physiotherapy & Rehab</li>
                    <li>Home Healthcare Services</li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="space-y-4">
                <h3 class="text-white font-semibold text-lg mb-4">Contact Info</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start space-x-3">
                        <i class="fa-solid fa-location-dot text-teal-500 mt-1"></i>
                        <span>{{ $siteSettings['address'] ?? 'Harare, Zimbabwe' }}</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fa-solid fa-phone text-teal-500"></i>
                        <span>{{ $siteSettings['site_phone'] ?? '071 216 2369' }}</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fa-solid fa-envelope text-teal-500"></i>
                        <span>{{ $siteSettings['site_email'] ?? 'info@genesis.org.zw' }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 text-sm">
            <p>&copy; {{ date('Y') }} Genesis Goodhope Population Health. All rights reserved.</p>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Widget -->
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number'] ?? '263712162369') }}?text=Hello%20Genesis%20Goodhope,%20I%20would%20like%20to%20inquire%20about%20your%20healthcare%20services." 
       target="_blank" 
       class="fixed bottom-6 right-6 z-50 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full p-4 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center group"
       title="Chat with us on WhatsApp"
       id="whatsapp-widget">
        <i class="fa-brands fa-whatsapp text-3xl"></i>
        <span class="max-w-0 overflow-hidden group-hover:max-w-xs group-hover:ml-2 text-sm font-semibold transition-all duration-300 whitespace-nowrap">
            Chat with us
        </span>
    </a>

    <!-- Menu Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                    const icon = menuBtn.querySelector('i');
                    if (mobileMenu.classList.contains('hidden')) {
                        icon.className = 'fa-solid fa-bars text-xl';
                    } else {
                        icon.className = 'fa-solid fa-xmark text-xl';
                    }
                });
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
