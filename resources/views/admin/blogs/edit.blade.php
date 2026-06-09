@extends('layouts.admin')

@section('content')
<div class="space-y-8 max-w-3xl mx-auto">
    
    <!-- Back Header -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.blogs.index') }}" class="px-3 py-2 rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold transition-all">
            &larr; Cancel & Back
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl p-8 shadow-sm">
        <h3 class="text-xl font-bold text-slate-900 dark:text-white border-b border-slate-50 dark:border-slate-700 pb-3 mb-6">Edit Blog Article</h3>
        
        <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="space-y-2">
                <label for="title" class="text-sm font-bold text-slate-700 dark:text-slate-300">Article Title</label>
                <input type="text" name="title" id="title" required value="{{ old('title', $blog->title) }}" placeholder="Article title"
                       class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                @error('title') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <!-- Optional Image Upload -->
            <div class="space-y-2">
                <label for="image" class="text-sm font-bold text-slate-700 dark:text-slate-300">Banner Image (Optional, Max 2MB)</label>
                @if($blog->image_path)
                    <div class="mb-3 text-xs text-slate-400">
                        <p class="mb-1">Current Banner Image:</p>
                        <img src="{{ asset('storage/' . $blog->image_path) }}" alt="{{ $blog->title }}" class="h-20 w-auto rounded border border-slate-100">
                    </div>
                @endif
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full text-slate-500 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-2xl p-3 focus:outline-none">
                @error('image') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <!-- Content -->
            <div class="space-y-2">
                <label for="content" class="text-sm font-bold text-slate-700 dark:text-slate-300">Article Content (Markdown supported)</label>
                <textarea name="content" id="content" rows="12" required placeholder="Type the awareness article content here..."
                          class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">{{ old('content', $blog->content) }}</textarea>
                @error('content') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <!-- Publish Status Toggle -->
            <div class="flex items-center space-x-3 select-none">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ $blog->is_published ? 'checked' : '' }}
                       class="rounded border-slate-200 dark:border-slate-600 text-teal-600 focus:ring-teal-500">
                <label for="is_published" class="text-sm font-bold text-slate-700 dark:text-slate-300">Publish immediately (Visible to public)</label>
            </div>

            <!-- Action -->
            <div class="flex justify-end pt-4 border-t border-slate-50 dark:border-slate-700">
                <button type="submit" class="px-8 py-3.5 rounded-full bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold transition-all">
                    Save Updates
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
