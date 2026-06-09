@extends('layouts.public')

@section('title', 'Our Services - ' . ($siteSettings['site_name'] ?? 'Genesis Goodhope Population Health'))

@section('content')
<!-- Subpage Header -->
<section class="bg-gradient-to-r from-slate-900 to-teal-950 text-white py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">Our Population Health Services</h1>
        <p class="text-slate-300 max-w-2xl mx-auto">Explore our diverse programs tailored to disease prevention, physical therapy, and wellness planning.</p>
    </div>
</section>

<!-- Services Grid -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($services as $service)
            <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm flex flex-col justify-between group hover:shadow-xl hover:border-teal-500/20 transition-all duration-300">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-2xl font-bold group-hover:bg-teal-600 group-hover:text-white transition-all">
                        <i class="fa-solid fa-stethoscope"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">{{ $service->name }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ $service->description }}</p>
                    
                    <div class="flex items-center space-x-6 pt-2 text-sm text-slate-500">
                        <span><i class="fa-solid fa-clock text-teal-500 mr-1.5"></i> {{ $service->duration }} minutes</span>
                        <span><i class="fa-solid fa-tag text-teal-500 mr-1.5"></i> ${{ number_format($service->price, 2) }}</span>
                    </div>
                </div>
                
                <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('booking.index', ['service_id' => $service->id]) }}" class="w-full text-center px-6 py-3.5 rounded-full bg-slate-900 group-hover:bg-teal-600 group-hover:text-white text-white font-bold transition-all text-sm">
                        Schedule This Service
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 text-slate-400">
                No health services are currently active.
            </div>
        @endforelse
    </div>
</section>

<!-- General Inquiries CTA -->
<section class="bg-slate-100 py-16">
    <div class="max-w-4xl mx-auto px-4 text-center space-y-6">
        <h3 class="text-2xl font-extrabold text-slate-900">Need a Customized Health Program?</h3>
        <p class="text-slate-600 text-sm sm:text-base">We design bespoke screening plans, corporate wellness exercises, and custom chronic care timelines for businesses and large households in Harare.</p>
        <div class="flex justify-center space-x-4 pt-2">
            <a href="{{ route('contact') }}" class="px-6 py-3 rounded-full bg-slate-900 text-white font-bold hover:bg-slate-800 transition-all text-sm">
                Contact Our Team
            </a>
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number'] ?? '263712162369') }}" target="_blank" class="px-6 py-3 rounded-full border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-bold transition-all text-sm flex items-center space-x-2">
                <i class="fa-brands fa-whatsapp text-emerald-500 text-lg"></i>
                <span>Chat via WhatsApp</span>
            </a>
        </div>
    </div>
</section>
@endsection
