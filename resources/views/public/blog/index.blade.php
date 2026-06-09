@extends('layouts.public')

@section('title', 'Health Awareness Blog - ' . ($siteSettings['site_name'] ?? 'Genesis Goodhope Population Health'))

@section('content')
<!-- Subpage Header -->
<section class="bg-gradient-to-r from-slate-900 to-teal-950 text-white py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">Health Awareness Blog</h1>
        <p class="text-slate-300 max-w-2xl mx-auto">Providing medical wellness insights, preventive care updates, and health guidelines for our community in Harare.</p>
    </div>
</section>

<!-- Blog Search & Feed -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
    <!-- Search Bar -->
    <div class="max-w-xl mx-auto">
        <form action="{{ route('blog.index') }}" method="GET" class="flex items-center space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles (e.g. Hypertension)..." 
                   class="w-full rounded-full border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 transition-all text-sm px-6 py-3 bg-white">
            <button type="submit" class="px-6 py-3 rounded-full bg-slate-900 hover:bg-teal-600 hover:text-white text-white font-bold transition-all text-sm">
                Search
            </button>
        </form>
    </div>

    <!-- Blog Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($blogs as $blog)
            <article class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                <div>
                    <!-- Header visual -->
                    @if($blog->image_path)
                        <img src="{{ asset('storage/' . $blog->image_path) }}" alt="{{ $blog->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="bg-gradient-to-r from-teal-800 to-emerald-700 h-48 flex items-center justify-center text-white/30 text-5xl">
                            <i class="fa-solid fa-newspaper"></i>
                        </div>
                    @endif
                    
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
                No health articles match your search.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-8">
        {{ $blogs->links() }}
    </div>
</section>
@endsection
