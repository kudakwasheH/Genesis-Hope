@extends('layouts.public')

@section('title', $blog->title . ' - ' . ($siteSettings['site_name'] ?? 'Genesis Goodhope Population Health'))

@section('content')
<!-- Header visual block -->
<div class="bg-gradient-to-r from-slate-900 to-teal-950 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <a href="{{ route('blog.index') }}" class="text-xs sm:text-sm font-bold text-teal-400 hover:underline inline-flex items-center space-x-1.5">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to blog feed</span>
        </a>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight leading-tight pt-2">
            {{ $blog->title }}
        </h1>
        <div class="flex items-center space-x-4 text-slate-300 text-xs sm:text-sm pt-2">
            <span>By <strong class="text-white font-semibold">{{ $blog->author->name }}</strong></span>
            <span>•</span>
            <span>Published {{ $blog->published_at ? $blog->published_at->format('M d, Y') : $blog->created_at->format('M d, Y') }}</span>
        </div>
    </div>
</div>

<!-- Article Core Body -->
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-12">
    <!-- Main Article Body -->
    <article class="lg:col-span-8 bg-white border border-slate-100 rounded-3xl p-8 sm:p-12 shadow-sm space-y-6">
        @if($blog->image_path)
            <div class="rounded-2xl overflow-hidden mb-8 shadow-sm">
                <img src="{{ asset('storage/' . $blog->image_path) }}" alt="{{ $blog->title }}" class="w-full h-auto max-h-[400px] object-cover">
            </div>
        @endif
        
        <div class="prose prose-teal max-w-none text-slate-600 leading-relaxed space-y-4 text-sm sm:text-base">
            {!! nl2br(e($blog->content)) !!}
        </div>
        
        <hr class="border-slate-100 my-8">
        
        <!-- Social Sharing -->
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Share this article</span>
            <div class="flex space-x-3 text-slate-400">
                <a href="#" class="hover:text-teal-600 transition-colors"><i class="fa-brands fa-facebook-f text-lg"></i></a>
                <a href="#" class="hover:text-teal-600 transition-colors"><i class="fa-brands fa-twitter text-lg"></i></a>
                <a href="#" class="hover:text-teal-600 transition-colors"><i class="fa-brands fa-linkedin-in text-lg"></i></a>
            </div>
        </div>
    </article>

    <!-- Sidebar / Related articles -->
    <aside class="lg:col-span-4 space-y-8">
        <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
            <h3 class="text-lg font-bold text-slate-900 border-b border-slate-50 pb-3">Related Articles</h3>
            
            <div class="space-y-6">
                @forelse($relatedBlogs as $rel)
                    <div class="space-y-2">
                        <span class="text-slate-400 text-xs font-semibold">{{ $rel->published_at ? $rel->published_at->format('M d, Y') : $rel->created_at->format('M d, Y') }}</span>
                        <h4 class="font-bold text-slate-900 text-sm hover:text-teal-600 transition-colors leading-snug">
                            <a href="{{ route('blog.show', $rel->slug) }}">{{ $rel->title }}</a>
                        </h4>
                    </div>
                @empty
                    <p class="text-slate-400 text-xs">No other articles available.</p>
                @endforelse
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-teal-900 to-emerald-800 text-white rounded-3xl p-8 shadow-md space-y-4 text-center">
            <i class="fa-solid fa-house-chimney-medical text-4xl text-emerald-400"></i>
            <h3 class="text-xl font-bold">Genesis Goodhope Services</h3>
            <p class="text-slate-300 text-xs leading-relaxed">
                Take the first step towards a healthier life. Schedule a wellness assessment or general check-up.
            </p>
            <a href="{{ route('booking.index') }}" class="block w-full text-center px-4 py-3 rounded-full bg-white text-slate-900 font-bold hover:bg-slate-50 text-xs shadow-sm transition-all">
                Book Consultation Now
            </a>
        </div>
    </aside>
</section>
@endsection
