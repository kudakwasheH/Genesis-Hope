@extends('layouts.admin')

@section('content')
<div class="space-y-8 max-w-2xl mx-auto">
    
    <!-- Back Header -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.staff.index') }}" class="px-3 py-2 rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold transition-all">
            &larr; Cancel & Back
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl p-8 shadow-sm">
        <h3 class="text-xl font-bold text-slate-900 dark:text-white border-b border-slate-50 dark:border-slate-700 pb-3 mb-6">Edit Staff Details</h3>
        
        <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="space-y-2">
                <label for="name" class="text-sm font-bold text-slate-700 dark:text-slate-300">Staff Full Name</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $staff->name) }}" placeholder="Staff name"
                       class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                @error('name') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="space-y-2">
                <label for="email" class="text-sm font-bold text-slate-700 dark:text-slate-300">Email Address</label>
                <input type="email" name="email" id="email" required value="{{ old('email', $staff->email) }}" placeholder="Email address"
                       class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                @error('email') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <!-- Role Select (Disabled for self to prevent locking self out of admin role) -->
            <div class="space-y-2">
                <label for="role" class="text-sm font-bold text-slate-700 dark:text-slate-300">System Role</label>
                @if($staff->id === Auth::id())
                    <input type="hidden" name="role" value="{{ $staff->role }}">
                    <select disabled
                            class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-100 opacity-70">
                        <option value="admin" selected>Administrator (Active Self)</option>
                    </select>
                    <p class="text-xs text-slate-400 mt-1 italic">Note: You cannot change your own role to prevent lockout.</p>
                @else
                    <select name="role" id="role" required
                            class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                        <option value="staff" {{ old('role', $staff->role) === 'staff' ? 'selected' : '' }}>Staff (Doctor / Clinician)</option>
                        <option value="admin" {{ old('role', $staff->role) === 'admin' ? 'selected' : '' }}>Administrator (Full Access)</option>
                    </select>
                @endif
                @error('role') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <hr class="border-slate-100 dark:border-slate-700 my-4">
            
            <p class="text-xs text-slate-400 italic">Leave password fields blank to keep current password.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="text-sm font-bold text-slate-700 dark:text-slate-300">Change Password</label>
                    <input type="password" name="password" id="password" placeholder="New password"
                           class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                    @error('password') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
                
                <!-- Password Confirmation -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="text-sm font-bold text-slate-700 dark:text-slate-300">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type new password"
                           class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                </div>
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
