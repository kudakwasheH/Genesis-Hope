@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Heading -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white">Staff Management</h1>
            <p class="text-slate-400 text-sm mt-0.5">Manage permissions, register clinicians, and control system roles.</p>
        </div>
        <div>
            <a href="{{ route('admin.staff.create') }}" class="px-5 py-2.5 rounded-full bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold transition-all shadow-sm">
                + Register New Staff
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-250 text-emerald-800 rounded-2xl p-4 text-sm font-semibold flex items-center space-x-3 shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-rose-50 border border-rose-250 text-rose-800 rounded-2xl p-4 text-sm font-semibold flex items-center space-x-3 shadow-sm">
            <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Listings Table -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700 text-left text-sm text-slate-500 dark:text-slate-400">
                <thead class="bg-slate-50 dark:bg-slate-900 text-xs text-slate-700 dark:text-slate-300 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Email Address</th>
                        <th class="px-6 py-4">System Role</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @foreach($staffMembers as $member)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 dark:text-white">{{ $member->name }}</div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white">{{ $member->email }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold border capitalize 
                                    {{ $member->role === 'admin' ? 'bg-purple-50 text-purple-700 border-purple-100 dark:bg-purple-950/20 dark:text-purple-400' : 'bg-teal-50 text-teal-700 border-teal-100 dark:bg-teal-950/20 dark:text-teal-400' }}">
                                    {{ $member->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 shrink-0">
                                <a href="{{ route('admin.staff.edit', $member->id) }}" class="text-teal-650 hover:underline font-bold text-xs">Edit Role</a>
                                
                                @if($member->id !== Auth::id())
                                    <form action="{{ route('admin.staff.destroy', $member->id) }}" method="POST" class="inline" onsubmit="return confirm('Remove this staff user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:underline font-bold text-xs">Delete</button>
                                    </form>
                                @else
                                    <span class="text-slate-350 text-xs italic">Active Self</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
