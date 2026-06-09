@extends('layouts.public')

@section('title', 'About Us - ' . ($siteSettings['site_name'] ?? 'Genesis Goodhope Population Health'))

@section('content')
<!-- Subpage Header -->
<section class="bg-gradient-to-r from-slate-900 to-teal-950 text-white py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">About Our Organization</h1>
        <p class="text-slate-300 max-w-2xl mx-auto">Genesis Goodhope Population Health - Health and Wellness Services in Harare, Zimbabwe</p>
    </div>
</section>

<!-- Vision & Mission -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-12">
    <div class="bg-white rounded-3xl border border-slate-100 p-8 sm:p-12 shadow-sm space-y-4">
        <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-2xl font-bold">
            <i class="fa-solid fa-eye"></i>
        </div>
        <h3 class="text-2xl font-bold text-slate-900">Our Vision</h3>
        <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
            To build healthy, resilient, and thriving communities across Zimbabwe through innovative preventive care models, tailored wellness options, and continuous support mechanisms.
        </p>
    </div>
    
    <div class="bg-white rounded-3xl border border-slate-100 p-8 sm:p-12 shadow-sm space-y-4">
        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl font-bold">
            <i class="fa-solid fa-bullseye"></i>
        </div>
        <h3 class="text-2xl font-bold text-slate-900">Our Mission</h3>
        <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
            To make healthcare delivery proactive rather than reactive by promoting health awareness, executing routine and specialized screenings, managing chronic diseases, and leveraging digital technologies to simplify booking, patient interaction, and follow-up.
        </p>
    </div>
</section>

<!-- Company Details Section -->
<section class="py-24 bg-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-6 space-y-6">
            <h2 class="text-emerald-500 font-extrabold uppercase tracking-widest text-sm">Our Background</h2>
            <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Who We Are</h3>
            <div class="text-slate-600 leading-relaxed space-y-4 text-sm sm:text-base">
                <p>
                    {{ $siteSettings['about_content'] ?? 'Genesis Goodhope Population Health is a health and wellness organization based in Harare, Zimbabwe. Our mission is to promote population health, deliver preventive care, manage chronic diseases, and offer convenient healthcare booking options.' }}
                </p>
                <p>
                    From our headquarters in Harare, Zimbabwe, we seek to address the growing need for organized health checks, nutrition planning, physical recovery support, and corporate wellness initiatives. We focus heavily on preventive metrics to catch ailments before they impact family or business productivity.
                </p>
            </div>
        </div>
        
        <div class="lg:col-span-6 grid grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm text-center space-y-2">
                <i class="fa-solid fa-shield-halved text-teal-600 text-3xl"></i>
                <h4 class="font-bold text-slate-900 text-base">Community Trust</h4>
                <p class="text-slate-400 text-xs">Providing secure, professional interactions for all patient groups.</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-sm text-center space-y-2">
                <i class="fa-solid fa-user-doctor text-teal-600 text-3xl"></i>
                <h4 class="font-bold text-slate-900 text-base">Expert Staff</h4>
                <p class="text-slate-400 text-xs">A growing network of registered practitioners and consultants.</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-sm text-center space-y-2">
                <i class="fa-solid fa-clock-rotate-left text-teal-600 text-3xl"></i>
                <h4 class="font-bold text-slate-900 text-base">Timely Booking</h4>
                <p class="text-slate-400 text-xs">Guaranteed slot times to eliminate long queues at local clinics.</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-sm text-center space-y-2">
                <i class="fa-solid fa-handshake-angle text-teal-600 text-3xl"></i>
                <h4 class="font-bold text-slate-900 text-base">Partnership</h4>
                <p class="text-slate-400 text-xs">Coordinating care cycles alongside family members and physicians.</p>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center space-y-4 mb-16">
        <h2 class="text-emerald-500 font-extrabold uppercase tracking-widest text-sm">Core Values</h2>
        <p class="text-3xl font-extrabold text-slate-900">What Drives Genesis Goodhope</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="bg-white border border-slate-100 rounded-2xl p-8 space-y-3">
            <h4 class="font-bold text-slate-900 text-lg">1. Compassion</h4>
            <p class="text-slate-500 text-sm leading-relaxed">Treating every single patient with empathy, respect, and deep understanding of their unique circumstances.</p>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl p-8 space-y-3">
            <h4 class="font-bold text-slate-900 text-lg">2. Integrity</h4>
            <p class="text-slate-500 text-sm leading-relaxed">Adhering strictly to clinical code of ethics, medical confidentiality, and transparent communication protocols.</p>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl p-8 space-y-3">
            <h4 class="font-bold text-slate-900 text-lg">3. Accessibility</h4>
            <p class="text-slate-500 text-sm leading-relaxed">Ensuring wellness plans and direct appointments can be made online easily, bypass long queues, and stay cost-friendly.</p>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl p-8 space-y-3">
            <h4 class="font-bold text-slate-900 text-lg">4. Collaboration</h4>
            <p class="text-slate-500 text-sm leading-relaxed">Coordinating care cycles alongside patients, their families, and local healthcare structures to maximize results.</p>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="bg-gradient-to-r from-teal-800 to-emerald-700 text-white py-16 text-center space-y-6">
    <h3 class="text-3xl font-extrabold">Ready to take control of your health?</h3>
    <p class="text-slate-200 max-w-xl mx-auto text-sm sm:text-base">Book your medical wellness consult or chronic disease tracking session today in under 2 minutes.</p>
    <a href="{{ route('booking.index') }}" class="inline-block px-8 py-4 rounded-full bg-slate-900 text-white font-bold hover:bg-slate-800 shadow-xl transition-all">
        Book Appointment Now
    </a>
</section>
@endsection
