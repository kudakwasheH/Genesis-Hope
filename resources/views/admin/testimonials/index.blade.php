@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Heading -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white">Patient Testimonials</h1>
            <p class="text-slate-400 text-sm mt-0.5">Moderate and approve patient feedback to display on the public home page.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-250 text-emerald-800 rounded-2xl p-4 text-sm font-semibold flex items-center space-x-3 shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Listings Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($testimonials as $testimonial)
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-8 shadow-sm flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-start">
                        <div class="flex text-amber-400">
                            @for($i = 0; $i < 5; $i++)
                                <i class="{{ $i < $testimonial->rating ? 'fa-solid' : 'fa-regular' }} fa-star text-sm"></i>
                            @endfor
                        </div>
                        
                        <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold border capitalize 
                            {{ $testimonial->is_approved ? 'bg-emerald-50 text-emerald-700 border-emerald-100 dark:bg-emerald-950/20 dark:text-emerald-400' : 'bg-amber-50 text-amber-700 border-amber-100 dark:bg-amber-950/20 dark:text-amber-400' }}">
                            {{ $testimonial->is_approved ? 'Approved' : 'Pending Approval' }}
                        </span>
                    </div>

                    <p class="text-slate-650 dark:text-slate-350 text-xs sm:text-sm italic leading-relaxed">"{{ $testimonial->content }}"</p>
                </div>

                <div class="pt-6 border-t border-slate-50 dark:border-slate-700 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full bg-teal-500/10 border border-teal-500/20 text-teal-600 dark:text-teal-400 flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr($testimonial->client_name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 dark:text-white text-xs sm:text-sm leading-tight">{{ $testimonial->client_name }}</h4>
                            @if($testimonial->client_title)
                                <p class="text-slate-400 text-[10px] sm:text-xs mt-0.5">{{ $testimonial->client_title }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-between items-center space-x-2 pt-2">
                        <form action="{{ route('admin.testimonials.approve', $testimonial->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-full border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-900 text-slate-700 dark:text-slate-300 text-xs font-bold transition-all">
                                {{ $testimonial->is_approved ? 'Unapprove' : 'Approve & Show' }}
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" onsubmit="return confirm('Delete this testimonial permanently?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 rounded-full hover:bg-rose-50 text-rose-600 text-xs font-bold transition-all">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-12 text-center text-slate-400">
                No client testimonials have been logged.
            </div>
        @endforelse
    </div>
    
    @if($testimonials->hasPages())
        <div class="pt-4">
            {{ $testimonials->links() }}
        </div>
    @endif
</div>
@endsection
