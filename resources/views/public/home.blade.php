@extends('layouts.public')

@section('title', ($siteSettings['site_name'] ?? 'Genesis Goodhope Population Health') . ' - Harare, Zimbabwe')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-slate-900 via-teal-950 to-emerald-950 text-white overflow-hidden py-24 md:py-32">
    <!-- Background Abstract Shapes -->
    <div class="absolute inset-0 z-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-7 space-y-6">
            <div class="inline-flex items-center space-x-2 bg-emerald-500/10 border border-emerald-500/30 rounded-full px-4 py-1 text-emerald-400 text-sm font-semibold">
                <i class="fa-solid fa-circle-check"></i>
                <span>Professional Population Health Services</span>
            </div>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight leading-tight">
                {{ $siteSettings['hero_title'] ?? 'Empowering Health & Wellness in Zimbabwe' }}
            </h1>
            <p class="text-lg text-slate-300 max-w-2xl">
                {{ $siteSettings['hero_subtitle'] ?? 'Genesis Goodhope Population Health is dedicated to delivering professional, community-centered healthcare, wellness, and preventive care programs.' }}
            </p>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 pt-4">
                <a href="{{ route('booking.index') }}" class="px-8 py-4 rounded-full bg-gradient-to-r from-teal-500 to-emerald-400 text-slate-950 font-bold hover:shadow-lg hover:shadow-emerald-500/20 transform hover:-translate-y-0.5 transition-all text-center">
                    Book Appointment Online
                </a>
                <a href="{{ route('services') }}" class="px-8 py-4 rounded-full border border-slate-700 hover:border-slate-500 hover:bg-slate-800/50 text-white font-semibold transition-all text-center">
                    View Our Services
                </a>
            </div>
        </div>
        
        <!-- Interactive Card Overlay -->
        <div class="lg:col-span-5 bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-8 shadow-2xl space-y-6">
            <h3 class="text-2xl font-bold text-white">Opening Hours</h3>
            <div class="space-y-3 text-slate-300 text-sm">
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span>Monday - Friday</span>
                    <span class="font-semibold text-white">8:00 AM - 5:00 PM</span>
                </div>
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span>Saturday</span>
                    <span class="font-semibold text-white">8:00 AM - 1:00 PM</span>
                </div>
                <div class="flex justify-between pb-2">
                    <span>Sunday</span>
                    <span class="text-emerald-400 font-semibold">Closed / Emergency Only</span>
                </div>
            </div>
            <div class="bg-teal-500/10 border border-teal-500/20 rounded-2xl p-4 flex items-start space-x-3 text-teal-300">
                <i class="fa-solid fa-location-dot text-xl mt-1"></i>
                <div class="text-sm">
                    <p class="font-semibold text-white">Our Location</p>
                    <p class="mt-0.5 text-slate-300">{{ $siteSettings['address'] ?? 'Harare, Zimbabwe' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Grid -->
<section class="bg-white py-12 border-y border-slate-100 shadow-sm relative z-20 -mt-8 max-w-7xl mx-auto rounded-2xl px-6 grid grid-cols-2 lg:grid-cols-4 gap-8">
    <div class="text-center space-y-1">
        <p class="text-4xl sm:text-5xl font-black text-teal-700">5,000+</p>
        <p class="text-slate-500 text-xs sm:text-sm font-semibold uppercase tracking-wider">Patients Served</p>
    </div>
    <div class="text-center space-y-1">
        <p class="text-4xl sm:text-5xl font-black text-teal-700">100%</p>
        <p class="text-slate-500 text-xs sm:text-sm font-semibold uppercase tracking-wider">Satisfaction Rate</p>
    </div>
    <div class="text-center space-y-1">
        <p class="text-4xl sm:text-5xl font-black text-teal-700">5+</p>
        <p class="text-slate-500 text-xs sm:text-sm font-semibold uppercase tracking-wider">Core Health Programs</p>
    </div>
    <div class="text-center space-y-1">
        <p class="text-4xl sm:text-5xl font-black text-teal-700">10+</p>
        <p class="text-slate-500 text-xs sm:text-sm font-semibold uppercase tracking-wider">Medical Experts</p>
    </div>
</section>

<!-- Services Highlights -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center space-y-4 mb-16">
        <h2 class="text-emerald-500 font-extrabold uppercase tracking-widest text-sm">Key Offerings</h2>
        <p class="text-3xl sm:text-4xl font-extrabold text-slate-900">Our Healthcare & Wellness Services</p>
        <p class="text-slate-500 max-w-2xl mx-auto text-sm sm:text-base">We provide accessible, professional, and preventive wellness programs tailored to your lifestyle.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($services as $service)
            <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm hover:shadow-xl hover:border-teal-500/20 transition-all duration-300 flex flex-col justify-between group">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl font-bold group-hover:bg-teal-600 group-hover:text-white transition-all">
                        <i class="fa-solid fa-stethoscope"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">{{ $service->name }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ Str::limit($service->description, 140) }}</p>
                </div>
                <div class="mt-8 pt-6 border-t border-slate-50 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Service Price</p>
                        <p class="text-lg font-extrabold text-teal-700">${{ number_format($service->price, 2) }}</p>
                    </div>
                    <a href="{{ route('booking.index', ['service_id' => $service->id]) }}" class="px-5 py-2.5 rounded-full bg-slate-900 group-hover:bg-teal-600 group-hover:text-white text-white text-xs font-bold transition-all">
                        Book Now
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 text-slate-400">
                No health services currently configured.
            </div>
        @endforelse
    </div>
    
    <div class="text-center mt-12">
        <a href="{{ route('services') }}" class="inline-flex items-center space-x-2 text-teal-600 font-bold hover:text-teal-700">
            <span>Explore all services</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
</section>

<!-- About Teaser (Harare Context) -->
<section class="py-24 bg-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <!-- Visual/Logo Representation -->
        <div class="lg:col-span-5 flex justify-center">
            <div class="relative w-80 h-80 rounded-3xl bg-teal-800 text-white flex items-center justify-center p-8 shadow-2xl overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-tr from-teal-900 to-emerald-600 opacity-90"></div>
                <div class="relative z-10 text-center space-y-4">
                    <i class="fa-solid fa-house-chimney-medical text-6xl text-emerald-400"></i>
                    <h4 class="text-2xl font-bold tracking-tight">Genesis Goodhope</h4>
                    <p class="text-xs text-slate-300 font-medium">Zimbabwe Health Initiative</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7 space-y-6">
            <h2 class="text-emerald-500 font-extrabold uppercase tracking-widest text-sm">About Organization</h2>
            <p class="text-3xl sm:text-4xl font-extrabold text-slate-900">Caring for the Wellness of Harare & Beyond</p>
            <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                {{ $siteSettings['about_content'] ?? 'Genesis Goodhope Population Health is a health and wellness organization based in Harare, Zimbabwe. Our mission is to promote population health, deliver preventive care, manage chronic diseases, and offer convenient healthcare booking options.' }}
            </p>
            <div class="space-y-3">
                <div class="flex items-center space-x-3 text-slate-700 font-medium">
                    <i class="fa-solid fa-check text-emerald-500 text-lg"></i>
                    <span>Tailored medical wellness & chronic disease assistance</span>
                </div>
                <div class="flex items-center space-x-3 text-slate-700 font-medium">
                    <i class="fa-solid fa-check text-emerald-500 text-lg"></i>
                    <span>Accessible booking, report exports, and follow-ups</span>
                </div>
            </div>
            <div class="pt-4">
                <a href="{{ route('about') }}" class="inline-flex items-center space-x-2 px-6 py-3 rounded-full bg-slate-900 hover:bg-slate-800 text-white font-bold transition-all">
                    Read More About Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Grid -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center space-y-4 mb-16">
        <h2 class="text-emerald-500 font-extrabold uppercase tracking-widest text-sm">Patient Reviews</h2>
        <p class="text-3xl sm:text-4xl font-extrabold text-slate-900">What Our Patients Say</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($testimonials as $testimonial)
            <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="flex text-amber-400">
                        @for($i = 0; $i < 5; $i++)
                            <i class="{{ $i < $testimonial->rating ? 'fa-solid' : 'fa-regular' }} fa-star text-sm"></i>
                        @endfor
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed italic">"{{ $testimonial->content }}"</p>
                </div>
                <div class="mt-8 pt-6 border-t border-slate-50 flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-teal-500 to-emerald-500 flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr($testimonial->client_name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">{{ $testimonial->client_name }}</h4>
                        @if($testimonial->client_title)
                            <p class="text-xs text-slate-400">{{ $testimonial->client_title }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 text-slate-400">
                No patient testimonials available.
            </div>
        @endforelse
    </div>
</section>

<!-- Latest Articles -->
<section class="py-24 bg-slate-50 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-16 space-y-4 md:space-y-0">
            <div class="space-y-2 text-center md:text-left">
                <h2 class="text-emerald-500 font-extrabold uppercase tracking-widest text-sm">Health Education</h2>
                <p class="text-3xl font-extrabold text-slate-900">Latest Health Awareness Articles</p>
            </div>
            <a href="{{ route('blog.index') }}" class="px-6 py-3 rounded-full border border-slate-200 hover:bg-slate-100 text-slate-700 font-bold transition-all text-sm">
                View All Articles
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($blogs as $blog)
                <article class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <!-- Optional Image placeholder -->
                        <div class="bg-gradient-to-r from-teal-800 to-emerald-700 h-48 flex items-center justify-center text-white/30 text-5xl">
                            <i class="fa-solid fa-newspaper"></i>
                        </div>
                        <div class="p-8 space-y-4">
                            <div class="flex items-center space-x-2 text-xs text-slate-400 font-semibold">
                                <span><i class="fa-solid fa-user mr-1"></i> {{ $blog->author->name }}</span>
                                <span>•</span>
                                <span><i class="fa-solid fa-calendar mr-1"></i> {{ $blog->published_at ? $blog->published_at->format('M d, Y') : $blog->created_at->format('M d, Y') }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 hover:text-teal-600 transition-colors">
                                <a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                            </h3>
                            <p class="text-slate-500 text-sm leading-relaxed">{{ Str::limit(strip_tags($blog->content), 120) }}</p>
                        </div>
                    </div>
                    <div class="px-8 pb-8 pt-4">
                        <a href="{{ route('blog.show', $blog->slug) }}" class="text-sm font-bold text-teal-600 hover:text-teal-700 inline-flex items-center space-x-1">
                            <span>Read Full Article</span>
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-12 text-slate-400">
                    No articles currently published.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
