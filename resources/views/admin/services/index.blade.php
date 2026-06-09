@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Heading -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white">Healthcare Services</h1>
            <p class="text-slate-400 text-sm mt-0.5">Define, edit, and adjust pricing or duration of healthcare consults.</p>
        </div>
        <div>
            <a href="{{ route('admin.services.create') }}" class="px-5 py-2.5 rounded-full bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold transition-all shadow-sm">
                + Add Service Offering
            </a>
        </div>
    </div>

    <!-- Listings Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($services as $service)
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-8 shadow-sm flex flex-col justify-between group">
                <div class="space-y-4">
                    <div class="flex justify-between items-start">
                        <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold border capitalize 
                            {{ $service->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-100 dark:bg-emerald-950/20 dark:text-emerald-400' : 'bg-slate-50 text-slate-400 border-slate-200 dark:bg-slate-900 dark:text-slate-550' }}">
                            {{ $service->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        
                        <span class="font-extrabold text-teal-600 dark:text-teal-400 text-base">${{ number_format($service->price, 2) }}</span>
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-snug">{{ $service->name }}</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">{{ Str::limit($service->description, 160) }}</p>
                    
                    <div class="text-xs text-slate-400 font-semibold"><i class="fa-solid fa-clock mr-1 text-teal-500"></i> Duration: {{ $service->duration }} minutes</div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-50 dark:border-slate-700 flex justify-between items-center space-x-2">
                    <a href="{{ route('admin.services.edit', $service->id) }}" class="px-4 py-2 rounded-full border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-900 text-slate-700 dark:text-slate-300 text-xs font-bold transition-all">
                        Edit Settings
                    </a>
                    
                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Delete this service? This will delete all appointments linked to it!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 rounded-full hover:bg-rose-50 text-rose-600 text-xs font-bold transition-all border border-transparent hover:border-rose-100">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-12 text-center text-slate-400">
                No health services currently configured.
            </div>
        @endforelse
    </div>
</div>
@endsection
