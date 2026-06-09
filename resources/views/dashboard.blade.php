@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Dashboard Heading -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white">Analytics Dashboard</h1>
            <p class="text-slate-400 text-sm mt-0.5">Welcome back, {{ Auth::user()->name }}. Here is an overview of Genesis Goodhope's clinic activity.</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.appointments.export') }}" class="px-5 py-2.5 rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-bold transition-all shadow-sm flex items-center space-x-1.5">
                <i class="fa-solid fa-file-csv text-teal-600"></i>
                <span>Export CSV Report</span>
            </a>
            <a href="{{ route('booking.index') }}" target="_blank" class="px-5 py-2.5 rounded-full bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold transition-all shadow-sm">
                + New Booking
            </a>
        </div>
    </div>

    <!-- Stats Count Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-6 flex items-center justify-between shadow-sm">
            <div class="space-y-1">
                <h4 class="text-2xl font-black text-slate-900 dark:text-white">{{ $totalAppointments }}</h4>
                <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Total Bookings</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-teal-50 dark:bg-teal-950/50 text-teal-600 dark:text-teal-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-6 flex items-center justify-between shadow-sm">
            <div class="space-y-1">
                <h4 class="text-2xl font-black text-slate-900 dark:text-white">{{ $pendingAppointments }}</h4>
                <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Pending Approvals</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-clock"></i>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-6 flex items-center justify-between shadow-sm">
            <div class="space-y-1">
                <h4 class="text-2xl font-black text-slate-900 dark:text-white">{{ $confirmedAppointments }}</h4>
                <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider font-medium">Confirmed Slots</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-check-double"></i>
            </div>
        </div>
        <!-- Card 4 -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-6 flex items-center justify-between shadow-sm">
            <div class="space-y-1">
                <h4 class="text-2xl font-black text-slate-900 dark:text-white">{{ $totalPatients }}</h4>
                <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Total Patients</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-users-medical"></i>
            </div>
        </div>
    </div>

    <!-- Charts Visualization Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Monthly Bookings Bar Chart -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-6 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 dark:text-white text-base">Booking Growth (Last 6 Months)</h3>
            <div class="h-80 w-full relative">
                <canvas id="monthlyBookingsChart"></canvas>
            </div>
        </div>

        <!-- Bookings Status Distribution -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-6 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 dark:text-white text-base">Booking Status Distribution</h3>
            <div class="h-80 w-full relative flex items-center justify-center">
                <canvas id="statusDistributionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Popular Services & Recent Bookings List -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Left: Popular Services -->
        <div class="lg:col-span-4 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-6 shadow-sm space-y-6">
            <h3 class="font-bold text-slate-900 dark:text-white text-base border-b border-slate-50 dark:border-slate-700 pb-3">Popular Services</h3>
            <div class="h-64 relative flex items-center justify-center">
                @if(count($serviceLabels) > 0)
                    <canvas id="popularServicesChart"></canvas>
                @else
                    <p class="text-slate-400 text-xs italic">No data yet available.</p>
                @endif
            </div>
        </div>

        <!-- Right: Recent Bookings List -->
        <div class="lg:col-span-8 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-6 shadow-sm space-y-4">
            <div class="flex justify-between items-center border-b border-slate-50 dark:border-slate-700 pb-3">
                <h3 class="font-bold text-slate-900 dark:text-white text-base">Recent Appointment Activity</h3>
                <a href="{{ route('admin.appointments.index') }}" class="text-xs font-semibold text-teal-600 hover:underline">View All &rarr;</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-xs text-slate-500 dark:text-slate-400">
                    <thead>
                        <tr class="text-slate-700 dark:text-slate-300 font-bold border-b border-slate-100 dark:border-slate-700">
                            <th class="py-2.5">Patient</th>
                            <th class="py-2.5">Service</th>
                            <th class="py-2.5">Date</th>
                            <th class="py-2.5">Time</th>
                            <th class="py-2.5">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                        @forelse($recentAppointments as $app)
                            <tr>
                                <td class="py-3 font-bold text-slate-800 dark:text-white">{{ $app->patient->user->name ?? 'Deleted User' }}</td>
                                <td class="py-3">{{ $app->service->name ?? 'N/A' }}</td>
                                <td class="py-3">{{ $app->appointment_date ? $app->appointment_date->format('M d, Y') : 'N/A' }}</td>
                                <td class="py-3">{{ $app->appointment_time }}</td>
                                <td class="py-3">
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold border capitalize 
                                        {{ $app->status === 'confirmed' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : ($app->status === 'pending' ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-slate-50 text-slate-600') }}">
                                        {{ $app->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-slate-400">No appointments booked yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart Scripts -->
@section('scripts')
<script>
    // 1. Monthly Bookings Bar Chart
    const ctxMonthly = document.getElementById('monthlyBookingsChart').getContext('2d');
    new Chart(ctxMonthly, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyLabels) !!},
            datasets: [{
                label: 'Bookings',
                data: {!! json_encode($monthlyValues) !!},
                backgroundColor: 'rgba(20, 184, 166, 0.7)',
                borderColor: 'rgb(20, 184, 166)',
                borderWidth: 1.5,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    // 2. Status Distribution Doughnut Chart
    const ctxStatus = document.getElementById('statusDistributionChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Confirmed', 'Completed', 'Cancelled'],
            datasets: [{
                data: {!! json_encode($statusData) !!},
                backgroundColor: [
                    'rgba(245, 158, 11, 0.8)', // Pending - amber
                    'rgba(16, 185, 129, 0.8)',  // Confirmed - emerald
                    'rgba(59, 130, 246, 0.8)',  // Completed - blue
                    'rgba(239, 68, 68, 0.8)'    // Cancelled - rose
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // 3. Popular Services Doughnut Chart
    @if(count($serviceLabels) > 0)
        const ctxServices = document.getElementById('popularServicesChart').getContext('2d');
        new Chart(ctxServices, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($serviceLabels) !!},
                datasets: [{
                    data: {!! json_encode($serviceValues) !!},
                    backgroundColor: [
                        'rgba(20, 184, 166, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(99, 102, 241, 0.8)',
                        'rgba(168, 85, 247, 0.8)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    @endif
</script>
@endsection

@endsection
