@extends('layouts.admin')

@section('content')
<div class="space-y-8 max-w-2xl mx-auto">
    
    <!-- Back Header -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.services.index') }}" class="px-3 py-2 rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold transition-all">
            &larr; Cancel & Back
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl p-8 shadow-sm">
        <h3 class="text-xl font-bold text-slate-900 dark:text-white border-b border-slate-50 dark:border-slate-700 pb-3 mb-6">Edit Service Details</h3>
        
        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="space-y-2">
                <label for="name" class="text-sm font-bold text-slate-700 dark:text-slate-300">Service Name</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $service->name) }}" placeholder="Service name"
                       class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                @error('name') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Duration -->
                <div class="space-y-2">
                    <label for="duration" class="text-sm font-bold text-slate-700 dark:text-slate-300">Duration (Minutes)</label>
                    <input type="number" name="duration" id="duration" required value="{{ old('duration', $service->duration) }}" placeholder="30" min="5"
                           class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                    @error('duration') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
                
                <!-- Price -->
                <div class="space-y-2">
                    <label for="price" class="text-sm font-bold text-slate-700 dark:text-slate-300">Price Rate ($ USD)</label>
                    <input type="number" name="price" id="price" required value="{{ old('price', $service->price) }}" placeholder="25.00" step="0.01" min="0"
                           class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                    @error('price') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="text-sm font-bold text-slate-700 dark:text-slate-300">Detailed Description</label>
                <textarea name="description" id="description" rows="5" required placeholder="Service description..."
                          class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">{{ old('description', $service->description) }}</textarea>
                @error('description') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <!-- Active Status Toggle -->
            <div class="flex items-center space-x-3 select-none">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $service->is_active ? 'checked' : '' }}
                       class="rounded border-slate-200 dark:border-slate-600 text-teal-600 focus:ring-teal-500">
                <label for="is_active" class="text-sm font-bold text-slate-700 dark:text-slate-300">Set service active (Available for online booking)</label>
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
