@extends('layouts.admin')

@section('content')
<div class="space-y-8 max-w-4xl mx-auto">
    
    <!-- Heading -->
    <div>
        <h1 class="text-3xl font-black text-slate-900 dark:text-white">Website Settings</h1>
        <p class="text-slate-400 text-sm mt-0.5">Edit general contact details, office schedules, and public landing page content blocks.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-250 text-emerald-800 rounded-2xl p-4 text-sm font-semibold flex items-center space-x-3 shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Form -->
    <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl p-8 shadow-sm">
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Section 1: Contact Details -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white border-b border-slate-50 dark:border-slate-700 pb-2">Organization Contacts</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="site_name" class="text-sm font-bold text-slate-700 dark:text-slate-300">Organization Name</label>
                        <input type="text" name="site_name" id="site_name" required value="{{ old('site_name', $settings['site_name'] ?? '') }}"
                               class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                    </div>
                    <div class="space-y-2">
                        <label for="site_email" class="text-sm font-bold text-slate-700 dark:text-slate-300">Office Email Address</label>
                        <input type="email" name="site_email" id="site_email" required value="{{ old('site_email', $settings['site_email'] ?? '') }}"
                               class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="site_phone" class="text-sm font-bold text-slate-700 dark:text-slate-300">Office Telephone / Phone</label>
                        <input type="text" name="site_phone" id="site_phone" required value="{{ old('site_phone', $settings['site_phone'] ?? '') }}"
                               class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                    </div>
                    <div class="space-y-2">
                        <label for="whatsapp_number" class="text-sm font-bold text-slate-700 dark:text-slate-300">WhatsApp Line (Include country code, e.g. 263712162369)</label>
                        <input type="text" name="whatsapp_number" id="whatsapp_number" required value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '') }}"
                               class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="working_hours" class="text-sm font-bold text-slate-700 dark:text-slate-300">Working Hours Summary</label>
                        <input type="text" name="working_hours" id="working_hours" required value="{{ old('working_hours', $settings['working_hours'] ?? '') }}"
                               class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                    </div>
                    <div class="space-y-2">
                        <label for="address" class="text-sm font-bold text-slate-700 dark:text-slate-300">Physical Address</label>
                        <input type="text" name="address" id="address" required value="{{ old('address', $settings['address'] ?? '') }}"
                               class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                    </div>
                </div>
            </div>

            <!-- Section 2: Home Page Copy -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white border-b border-slate-50 dark:border-slate-700 pb-2">Public Homepage Content Copy</h3>
                
                <div class="space-y-2">
                    <label for="hero_title" class="text-sm font-bold text-slate-700 dark:text-slate-300">Hero Section Heading</label>
                    <input type="text" name="hero_title" id="hero_title" required value="{{ old('hero_title', $settings['hero_title'] ?? '') }}"
                           class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                </div>
                
                <div class="space-y-2">
                    <label for="hero_subtitle" class="text-sm font-bold text-slate-700 dark:text-slate-300">Hero Section Subtitle</label>
                    <input type="text" name="hero_subtitle" id="hero_subtitle" required value="{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}"
                           class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                </div>

                <div class="space-y-2">
                    <label for="about_content" class="text-sm font-bold text-slate-700 dark:text-slate-300">Organization History / Description (About Us)</label>
                    <textarea name="about_content" id="about_content" rows="6" required
                              class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">{{ old('about_content', $settings['about_content'] ?? '') }}</textarea>
                </div>
            </div>

            <!-- Section 3: Integrations -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white border-b border-slate-50 dark:border-slate-700 pb-2">Integrations</h3>
                
                <div class="space-y-2">
                    <label for="google_maps_embed" class="text-sm font-bold text-slate-700 dark:text-slate-300">Google Maps Embed code (Iframe HTML snippet)</label>
                    <textarea name="google_maps_embed" id="google_maps_embed" rows="4" placeholder="<iframe src='...'></iframe>"
                              class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-xs px-4 py-3 bg-slate-50">{{ old('google_maps_embed', $settings['google_maps_embed'] ?? '') }}</textarea>
                </div>
            </div>

            <!-- Action -->
            <div class="flex justify-end pt-4 border-t border-slate-50 dark:border-slate-700">
                <button type="submit" class="px-8 py-3.5 rounded-full bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold transition-all">
                    Save All Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
