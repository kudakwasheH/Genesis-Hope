@extends('layouts.admin')

@section('content')
<div class="space-y-8 max-w-3xl mx-auto">
    
    <!-- Back Header -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.patients.show', $patient->id) }}" class="px-3 py-2 rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold transition-all">
            &larr; Cancel & Back
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl p-8 shadow-sm">
        <h3 class="text-xl font-bold text-slate-900 dark:text-white border-b border-slate-50 dark:border-slate-700 pb-3 mb-6">Edit Patient Profile Details</h3>
        
        <form action="{{ route('admin.patients.update', $patient->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-2">
                    <label for="name" class="text-sm font-bold text-slate-700 dark:text-slate-300">Account Name</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $patient->user->name ?? '') }}"
                           class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                    @error('name') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
                
                <!-- Phone -->
                <div class="space-y-2">
                    <label for="phone" class="text-sm font-bold text-slate-700 dark:text-slate-300">WhatsApp Phone Number</label>
                    <input type="text" name="phone" id="phone" required value="{{ old('phone', $patient->phone) }}"
                           class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                    @error('phone') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- DOB -->
                <div class="space-y-2">
                    <label for="date_of_birth" class="text-sm font-bold text-slate-700 dark:text-slate-300">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" required value="{{ old('date_of_birth', $patient->date_of_birth) }}"
                           class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                    @error('date_of_birth') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
                
                <!-- Gender -->
                <div class="space-y-2">
                    <label for="gender" class="text-sm font-bold text-slate-700 dark:text-slate-300">Gender</label>
                    <select name="gender" id="gender" required
                            class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                        <option value="Male" {{ old('gender', $patient->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $patient->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender', $patient->gender) === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Address -->
            <div class="space-y-2">
                <label for="address" class="text-sm font-bold text-slate-700 dark:text-slate-300">Residential Address</label>
                <input type="text" name="address" id="address" required value="{{ old('address', $patient->address) }}"
                       class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                @error('address') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <!-- Medical History -->
            <div class="space-y-2">
                <label for="medical_history" class="text-sm font-bold text-slate-700 dark:text-slate-300">Chronic Conditions & Confidential Medical History</label>
                <textarea name="medical_history" id="medical_history" rows="5" placeholder="E.g. Diagnosed hypertension, penicillin allergy..."
                          class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">{{ old('medical_history', $patient->medical_history) }}</textarea>
                @error('medical_history') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
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
