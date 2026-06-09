@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Heading -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white">Health Awareness Articles</h1>
            <p class="text-slate-400 text-sm mt-0.5">Publish guidelines, safety measures, and population health alerts.</p>
        </div>
        <div>
            <a href="{{ route('admin.blogs.create') }}" class="px-5 py-2.5 rounded-full bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold transition-all shadow-sm">
                + Write New Article
            </a>
        </div>
    </div>

    <!-- Listings Grid/Table -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700 text-left text-sm text-slate-500 dark:text-slate-400">
                <thead class="bg-slate-50 dark:bg-slate-900 text-xs text-slate-700 dark:text-slate-300 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Title</th>
                        <th class="px-6 py-4">Author</th>
                        <th class="px-6 py-4">Date Created</th>
                        <th class="px-6 py-4">Publish Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($blogs as $blog)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">
                                <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="hover:underline text-teal-650">
                                    {{ $blog->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white">{{ $blog->author->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $blog->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold border capitalize 
                                    {{ $blog->is_published ? 'bg-emerald-50 text-emerald-700 border-emerald-100 dark:bg-emerald-950/20 dark:text-emerald-400' : 'bg-amber-50 text-amber-700 border-amber-100 dark:bg-amber-950/20 dark:text-amber-400' }}">
                                    {{ $blog->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 shrink-0">
                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="text-teal-650 hover:underline font-bold text-xs">Edit</a>
                                
                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this article permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:underline font-bold text-xs">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-400">No blog articles written yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($blogs->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700">
                {{ $blogs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
