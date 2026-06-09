@extends('layouts.admin')

@section('content')
<div class="space-y-8 max-w-5xl mx-auto">
    
    <!-- Back Header -->
    <div class="flex justify-between items-center">
        <a href="{{ route('admin.patients.index') }}" class="px-3 py-2 rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold transition-all">
            &larr; Back to Directory
        </a>
        <a href="{{ route('admin.patients.edit', $patient->id) }}" class="px-5 py-2.5 rounded-full bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-sm">
            Edit Patient Profile
        </a>
    </div>

    <!-- Patient Header Summary Card -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-8 shadow-sm grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Personal Info -->
        <div class="space-y-3">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Patient Details</span>
            <h2 class="text-2xl font-black text-slate-900 dark:text-white">{{ $patient->user->name ?? 'N/A' }}</h2>
            <div class="text-slate-500 text-sm space-y-1.5">
                <p><i class="fa-solid fa-envelope text-teal-600 mr-2"></i> {{ $patient->user->email ?? 'N/A' }}</p>
                <p><i class="fa-solid fa-phone text-teal-600 mr-2"></i> {{ $patient->phone }}</p>
            </div>
        </div>

        <!-- Demographics -->
        <div class="space-y-3">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Demographics</span>
            <div class="text-slate-650 dark:text-slate-350 text-sm space-y-1.5 pt-1">
                <p><strong>Date of Birth:</strong> {{ $patient->date_of_birth }}</p>
                <p><strong>Gender:</strong> {{ $patient->gender }}</p>
                <p class="truncate"><strong>Address:</strong> {{ $patient->address }}</p>
            </div>
        </div>

        <!-- Medical History Block -->
        <div class="space-y-3 bg-rose-50/50 dark:bg-rose-950/10 border border-rose-100 dark:border-rose-900/30 rounded-2xl p-5">
            <span class="text-xs font-bold text-rose-800 dark:text-rose-400 uppercase tracking-wider">Confidential Medical History</span>
            <p class="text-slate-600 dark:text-slate-300 text-xs sm:text-sm leading-relaxed italic mt-1">
                "{{ $patient->medical_history ?? 'No chronic health issues or allergies logged.' }}"
            </p>
        </div>
    </div>

    <!-- Appointment History List -->
    <div class="space-y-4">
        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Appointment Record History</h3>
        
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700 text-left text-sm text-slate-500 dark:text-slate-400">
                    <thead class="bg-slate-50 dark:bg-slate-900 text-xs text-slate-700 dark:text-slate-300 font-bold uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Service</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Time</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($patient->appointments as $app)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">#{{ $app->id }}</td>
                                <td class="px-6 py-4 font-bold text-slate-850 dark:text-slate-100">{{ $app->service->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $app->appointment_date ? $app->appointment_date->format('M d, Y') : 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $app->appointment_time }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $badgeColor = match($app->status) {
                                            'pending' => 'bg-amber-50 text-amber-700 border-amber-250 dark:bg-amber-950/20 dark:text-amber-400',
                                            'confirmed' => 'bg-emerald-50 text-emerald-700 border-emerald-250 dark:bg-emerald-950/20 dark:text-emerald-400',
                                            'completed' => 'bg-blue-50 text-blue-700 border-blue-250 dark:bg-blue-950/20 dark:text-blue-400',
                                            'cancelled' => 'bg-rose-50 text-rose-700 border-rose-250 dark:bg-rose-950/20 dark:text-rose-400',
                                        };
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold border capitalize {{ $badgeColor }}">
                                        {{ $app->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.appointments.show', $app->id) }}" class="text-teal-650 hover:underline font-bold text-xs">Manage</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-400">No appointments logged for this patient.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
