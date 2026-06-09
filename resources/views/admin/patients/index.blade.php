@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Heading -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white">Patient Directory</h1>
            <p class="text-slate-400 text-sm mt-0.5">View and manage clinical patient details and record histories.</p>
        </div>
    </div>

    <!-- Search Panel -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-6 shadow-sm">
        <form action="{{ route('admin.patients.index') }}" method="GET" class="flex items-center space-x-2 max-w-md">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, or phone..." 
                   class="w-full rounded-xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-xs px-3 py-2 bg-slate-50">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-teal-600 hover:text-white text-white text-xs font-bold transition-all shrink-0">
                Search
            </button>
            @if(request()->filled('search'))
                <a href="{{ route('admin.patients.index') }}" class="px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold flex items-center justify-center shrink-0">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Listings Table -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700 text-left text-sm text-slate-500 dark:text-slate-400">
                <thead class="bg-slate-50 dark:bg-slate-900 text-xs text-slate-700 dark:text-slate-300 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Contact</th>
                        <th class="px-6 py-4">Date of Birth</th>
                        <th class="px-6 py-4">Gender</th>
                        <th class="px-6 py-4">Total Bookings</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 dark:text-white">{{ $patient->user->name ?? 'N/A' }}</div>
                                <div class="text-slate-450 text-xs mt-0.5">{{ $patient->user->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-900 dark:text-white font-semibold">{{ $patient->phone }}</td>
                            <td class="px-6 py-4">{{ $patient->date_of_birth }}</td>
                            <td class="px-6 py-4">{{ $patient->gender }}</td>
                            <td class="px-6 py-4 font-bold text-teal-650">{{ $patient->appointments->count() }} bookings</td>
                            <td class="px-6 py-4 text-right space-x-2 shrink-0">
                                <a href="{{ route('admin.patients.show', $patient->id) }}" class="text-teal-600 hover:text-teal-700 font-bold text-xs">View History</a>
                                <a href="{{ route('admin.patients.edit', $patient->id) }}" class="text-slate-500 hover:text-slate-700 font-bold text-xs">Edit Info</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">No patients registered.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($patients->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700">
                {{ $patients->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
