@extends('layouts.public')

@section('title', 'Contact Us - ' . ($siteSettings['site_name'] ?? 'Genesis Goodhope Population Health'))

@section('content')
<!-- Subpage Header -->
<section class="bg-gradient-to-r from-slate-900 to-teal-950 text-white py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">Contact Our Team</h1>
        <p class="text-slate-300 max-w-2xl mx-auto">Get in touch with Genesis Goodhope Population Health. We are here to support your wellness journey.</p>
    </div>
</section>

<!-- Contact Body -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-12">
    <!-- Left Column: Contact info & map -->
    <div class="lg:col-span-5 space-y-8">
        <div class="space-y-4">
            <h3 class="text-2xl font-bold text-slate-900">Get in Touch</h3>
            <p class="text-slate-500 text-sm leading-relaxed">
                Have questions about our wellness assessment plans, chronic disease management cycles, or booking rates? Drop us a line or call our Harare office directly.
            </p>
        </div>

        <div class="space-y-6">
            <div class="flex items-start space-x-4">
                <div class="w-10 h-10 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">Physical Address</h4>
                    <p class="text-slate-500 text-xs sm:text-sm mt-0.5">{{ $siteSettings['address'] ?? 'Harare, Zimbabwe' }}</p>
                </div>
            </div>

            <div class="flex items-start space-x-4">
                <div class="w-10 h-10 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">Phone Call</h4>
                    <p class="text-slate-500 text-xs sm:text-sm mt-0.5">{{ $siteSettings['site_phone'] ?? '071 216 2369' }}</p>
                </div>
            </div>

            <div class="flex items-start space-x-4">
                <div class="w-10 h-10 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">Email Inbox</h4>
                    <p class="text-slate-500 text-xs sm:text-sm mt-0.5">{{ $siteSettings['site_email'] ?? 'info@genesis.org.zw' }}</p>
                </div>
            </div>
            
            <div class="flex items-start space-x-4">
                <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <i class="fa-brands fa-whatsapp text-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">WhatsApp Line</h4>
                    <p class="text-slate-500 text-xs sm:text-sm mt-0.5">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number'] ?? '263712162369') }}" target="_blank" class="text-teal-600 font-semibold hover:underline">
                            +{{ $siteSettings['whatsapp_number'] ?? '263712162369' }}
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-teal-500/10 border border-teal-500/20 rounded-3xl p-6 text-teal-800 space-y-2">
            <h4 class="font-bold text-sm">Did you know?</h4>
            <p class="text-slate-600 text-xs leading-relaxed">
                You can directly register an account and book a confirmed slot instantly on our online Booking page. Bypasses general messaging wait times!
            </p>
            <a href="{{ route('booking.index') }}" class="inline-block text-xs font-bold text-teal-700 hover:underline pt-1">
                Go to booking page &rarr;
            </a>
        </div>
    </div>

    <!-- Right Column: Form -->
    <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-100 p-8 sm:p-12 shadow-sm space-y-8">
        <h3 class="text-2xl font-bold text-slate-900">Send an Online Message</h3>
        
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-4 text-sm font-semibold flex items-center space-x-3">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="name" class="text-sm font-bold text-slate-700">Full Name</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="John Doe" 
                           class="w-full rounded-2xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 transition-all text-sm px-4 py-3 bg-slate-50">
                    @error('name') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
                
                <div class="space-y-2">
                    <label for="email" class="text-sm font-bold text-slate-700">Email Address</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="john@example.com" 
                           class="w-full rounded-2xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 transition-all text-sm px-4 py-3 bg-slate-50">
                    @error('email') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="phone" class="text-sm font-bold text-slate-700">Phone Number (Optional)</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="+263 77 123 4567" 
                           class="w-full rounded-2xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 transition-all text-sm px-4 py-3 bg-slate-50">
                    @error('phone') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
                
                <div class="space-y-2">
                    <label for="subject" class="text-sm font-bold text-slate-700">Message Subject</label>
                    <input type="text" name="subject" id="subject" required value="{{ old('subject') }}" placeholder="E.g. Corporate Screening Program" 
                           class="w-full rounded-2xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 transition-all text-sm px-4 py-3 bg-slate-50">
                    @error('subject') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label for="message" class="text-sm font-bold text-slate-700">Detailed Message</label>
                <textarea name="message" id="message" rows="5" required placeholder="Type your message here..." 
                          class="w-full rounded-2xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 transition-all text-sm px-4 py-3 bg-slate-50">{{ old('message') }}</textarea>
                @error('message') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full px-6 py-4 rounded-full bg-slate-900 hover:bg-teal-600 hover:text-white text-white font-bold transition-all text-center">
                Send Message
            </button>
        </form>
    </div>
</section>

<!-- Maps Section -->
<section class="w-full h-[450px] bg-slate-100 border-t border-slate-200 overflow-hidden relative">
    @if(isset($siteSettings['google_maps_embed']))
        {!! $siteSettings['google_maps_embed'] !!}
    @else
        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 space-y-2">
            <i class="fa-solid fa-map-location-dot text-5xl"></i>
            <p>Harare, Zimbabwe Location Map</p>
        </div>
    @endif
</section>
@endsection
