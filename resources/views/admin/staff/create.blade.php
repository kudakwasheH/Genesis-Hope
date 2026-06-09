@extends('layouts.admin')

@section('content')
<div class="space-y-8 max-w-2xl mx-auto">
    
    <!-- Back Header -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.staff.index') }}" class="px-3 py-2 rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold transition-all">
            &larr; Cancel & Back
        </a>
    </div>

    <!-- Create Form Card -->
    <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl p-8 shadow-sm">
        <h3 class="text-xl font-bold text-slate-900 dark:text-white border-b border-slate-50 dark:border-slate-700 pb-3 mb-6">Register Staff Account</h3>
        
        <form action="{{ route('admin.staff.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Name -->
            <div class="space-y-2">
                <label for="name" class="text-sm font-bold text-slate-700 dark:text-slate-300">Staff Full Name</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Dr. Jane Doe"
                       class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                @error('name') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="space-y-2">
                <label for="email" class="text-sm font-bold text-slate-700 dark:text-slate-300">Email Address</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="jane@genesis.org.zw"
                       class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                @error('email') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <!-- Role Select -->
            <div class="space-y-2">
                <label for="role" class="text-sm font-bold text-slate-700 dark:text-slate-300">System Role</label>
                <select name="role" id="role" required
                        class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                    <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff (Doctor / Clinician)</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator (Full Access)</option>
                </select>
                @error('role') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="text-sm font-bold text-slate-700 dark:text-slate-300">Default Password</label>
                    <input type="password" name="password" id="password" required placeholder="Min 8 characters"
                           class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                    @error('password') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
                
                <!-- Password Confirmation -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="text-sm font-bold text-slate-700 dark:text-slate-300">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Re-type password"
                           class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                </div>
            </div>

            <!-- Action -->
            <div class="flex justify-end pt-4 border-t border-slate-50 dark:border-slate-700">
                <button type="submit" class="px-8 py-3.5 rounded-full bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold transition-all">
                    Register Staff Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
