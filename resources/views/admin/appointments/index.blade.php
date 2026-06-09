@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Heading -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white">Clinic Bookings</h1>
            <p class="text-slate-400 text-sm mt-0.5">Manage, confirm, search, and export patient appointments.</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.appointments.export', request()->all()) }}" class="px-5 py-2.5 rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-bold transition-all shadow-sm flex items-center space-x-1.5">
                <i class="fa-solid fa-file-csv text-teal-600"></i>
                <span>Export Filtered CSV</span>
            </a>
        </div>
    </div>

    <!-- Filters Panel -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-6 shadow-sm">
        <form action="{{ route('admin.appointments.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="space-y-1">
                <label for="search" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Search Patient</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Name or email..." 
                       class="w-full rounded-xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-xs px-3 py-2 bg-slate-50">
            </div>

            <!-- Service Filter -->
            <div class="space-y-1">
                <label for="service_id" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Filter Service</label>
                <select name="service_id" id="service_id" 
                        class="w-full rounded-xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-xs px-3 py-2 bg-slate-50">
                    <option value="">-- All Services --</option>
                    @foreach($services as $srv)
                        <option value="{{ $srv->id }}" {{ request('service_id') == $srv->id ? 'selected' : '' }}>{{ $srv->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div class="space-y-1">
                <label for="status" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Filter Status</label>
                <select name="status" id="status" 
                        class="w-full rounded-xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-xs px-3 py-2 bg-slate-50">
                    <option value="">-- All Statuses --</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <!-- Date Filter -->
            <div class="space-y-1">
                <label for="date" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Filter Date</label>
                <div class="flex space-x-2">
                    <input type="date" name="date" id="date" value="{{ request('date') }}" 
                           class="w-full rounded-xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-xs px-3 py-2 bg-slate-50">
                    <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-teal-600 hover:text-white text-white text-xs font-bold transition-all shrink-0">
                        Apply
                    </button>
                    @if(request()->anyFilled(['search', 'service_id', 'status', 'date']))
                        <a href="{{ route('admin.appointments.index') }}" class="px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold flex items-center justify-center shrink-0" title="Clear Filters">
                            <i class="fa-solid fa-filter-circle-xmark"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Listings Table -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700 text-left text-sm text-slate-500 dark:text-slate-400">
                <thead class="bg-slate-50 dark:bg-slate-900 text-xs text-slate-700 dark:text-slate-300 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Patient</th>
                        <th class="px-6 py-4">Service</th>
                        <th class="px-6 py-4">Date & Time</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($appointments as $app)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">#{{ $app->id }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-850 dark:text-slate-100">
                                    @if($app->patient)
                                        <a href="{{ route('admin.patients.show', $app->patient_id) }}" class="hover:underline text-teal-650">
                                            {{ $app->patient->user->name ?? 'N/A' }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div class="text-slate-400 text-xs mt-0.5">{{ $app->patient->user->email ?? '' }} | {{ $app->patient->phone ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-900 dark:text-white">{{ $app->service->name ?? 'N/A' }}</div>
                                <div class="text-teal-600 text-xs font-bold mt-0.5">${{ number_format($app->service->price ?? 0, 2) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 dark:text-white text-xs sm:text-sm">
                                    {{ $app->appointment_date ? $app->appointment_date->format('M d, Y') : 'N/A' }}
                                </div>
                                <div class="text-slate-400 text-xs mt-0.5">{{ $app->appointment_time }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $badgeColor = match($app->status) {
                                        'pending' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/20 dark:text-amber-400',
                                        'confirmed' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/20 dark:text-emerald-400',
                                        'completed' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-950/20 dark:text-blue-400',
                                        'cancelled' => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/20 dark:text-rose-400',
                                    };
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold border capitalize {{ $badgeColor }}">
                                    {{ $app->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 shrink-0">
                                <a href="{{ route('admin.appointments.show', $app->id) }}" class="text-teal-600 hover:text-teal-700 font-bold text-xs">Manage</a>
                                <a href="{{ route('admin.appointments.print', $app->id) }}" target="_blank" class="text-slate-500 hover:text-slate-700 font-bold text-xs" title="Print Invoice/Summary"><i class="fa-solid fa-print"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">No patient bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($appointments->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
