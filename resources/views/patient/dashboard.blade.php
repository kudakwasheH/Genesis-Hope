<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Patient Health Portal') }}
        </h2>
    </x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        
        <!-- Alerts -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-4 text-sm font-semibold flex items-center space-x-3 shadow-sm dark:bg-emerald-950/20 dark:border-emerald-500/20 dark:text-emerald-400">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg dark:text-emerald-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl p-4 text-sm font-semibold space-y-1 dark:bg-rose-950/20 dark:border-rose-500/20 dark:text-rose-400">
                @foreach($errors->all() as $error)
                    <p><i class="fa-solid fa-circle-exclamation text-rose-600 mr-2 dark:text-rose-500"></i> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Portal Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-6 flex items-center space-x-4 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-teal-50 dark:bg-teal-950/50 text-teal-600 dark:text-teal-400 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div>
                    <h4 class="text-2xl font-black text-slate-900 dark:text-white">{{ $upcomingAppointments->count() }}</h4>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Upcoming Bookings</p>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-6 flex items-center space-x-4 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-notes-medical"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate max-w-[180px]">{{ $patient->gender ?? 'Not Specified' }}</h4>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Patient Gender</p>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-6 flex items-center space-x-4 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-address-book"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate max-w-[180px]">{{ $patient->phone ?? 'Add phone' }}</h4>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Contact Number</p>
                </div>
            </div>
        </div>

        <!-- Tab Controls -->
        <div class="border-b border-slate-200 dark:border-slate-700">
            <nav class="flex space-x-8" aria-label="Tabs">
                <button type="button" id="tab-btn-bookings" onclick="switchTab('bookings')"
                        class="border-teal-500 text-teal-600 dark:text-teal-400 border-b-2 py-4 px-1 text-sm font-bold tracking-tight transition-all">
                    My Appointments
                </button>
                <button type="button" id="tab-btn-profile" onclick="switchTab('profile')"
                        class="border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 dark:text-slate-400 dark:hover:text-slate-300 dark:hover:border-slate-600 border-b-2 py-4 px-1 text-sm font-semibold tracking-tight transition-all">
                    Health Profile
                </button>
            </nav>
        </div>

        <!-- TAB 1: BOOKINGS -->
        <div id="tab-content-bookings" class="space-y-8">
            <!-- Upcoming Bookings Grid -->
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Upcoming Appointments</h3>
                    <a href="{{ route('booking.index') }}" class="px-5 py-2.5 rounded-full bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold transition-all shadow-sm">
                        + New Booking
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($upcomingAppointments as $app)
                        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-6 shadow-sm flex flex-col justify-between">
                            <div class="space-y-4">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-extrabold text-slate-900 dark:text-white text-base">{{ $app->service->name }}</h4>
                                    
                                    @php
                                        $badgeColor = match($app->status) {
                                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/20 dark:text-amber-400 dark:border-amber-500/20',
                                            'confirmed' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/20 dark:text-emerald-400 dark:border-emerald-500/20',
                                            'completed' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-950/20 dark:text-blue-400 dark:border-blue-500/20',
                                            'cancelled' => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/20 dark:text-rose-400 dark:border-rose-500/20',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $badgeColor }}">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                                    <div class="flex items-center space-x-2">
                                        <i class="fa-solid fa-calendar text-teal-500"></i>
                                        <span>{{ $app->appointment_date->format('l, M j, Y') }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i class="fa-solid fa-clock text-teal-500"></i>
                                        <span>{{ $app->appointment_time }}</span>
                                    </div>
                                </div>

                                @if($app->notes)
                                    <div class="bg-slate-50 dark:bg-slate-900 rounded-xl p-3 text-xs text-slate-500 dark:text-slate-400 italic">
                                        <strong>My Notes:</strong> {{ $app->notes }}
                                    </div>
                                @endif

                                @if($app->staff_notes)
                                    <div class="bg-teal-50/50 border border-teal-100 dark:bg-teal-950/20 dark:border-teal-500/20 rounded-xl p-3 text-xs text-slate-600 dark:text-slate-400">
                                        <strong>Dr./Staff Feedback:</strong> {{ $app->staff_notes }}
                                    </div>
                                @endif
                            </div>

                            @if($app->status === 'pending' || $app->status === 'confirmed')
                                <div class="mt-6 pt-4 border-t border-slate-50 dark:border-slate-700 flex justify-end">
                                    <form action="{{ route('patient.appointments.cancel', $app->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 rounded-full border border-rose-200 hover:bg-rose-50 dark:border-rose-500/20 dark:hover:bg-rose-950/20 text-rose-600 dark:text-rose-400 text-xs font-bold transition-all">
                                            Request Cancellation
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-2 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-12 text-center text-slate-400 dark:text-slate-500">
                            <i class="fa-solid fa-calendar-times text-4xl mb-3 block text-slate-300 dark:text-slate-600"></i>
                            <p class="text-sm">You have no upcoming appointments.</p>
                            <a href="{{ route('booking.index') }}" class="inline-block mt-4 text-xs font-bold text-teal-600 hover:underline">Book one now &rarr;</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Past Bookings Grid -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Past & Completed History</h3>
                
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 overflow-hidden shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700 text-left text-sm text-slate-500 dark:text-slate-400">
                            <thead class="bg-slate-50 dark:bg-slate-900 text-xs text-slate-700 dark:text-slate-300 font-bold uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Service</th>
                                    <th class="px-6 py-4">Date</th>
                                    <th class="px-6 py-4">Time</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">Doctor Notes</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                @forelse($pastAppointments as $past)
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">{{ $past->service->name }}</td>
                                        <td class="px-6 py-4">{{ $past->appointment_date->format('M d, Y') }}</td>
                                        <td class="px-6 py-4">{{ $past->appointment_time }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium uppercase border 
                                                {{ $past->status === 'completed' ? 'bg-blue-50 text-blue-700 border-blue-100 dark:bg-blue-950/20 dark:text-blue-400' : 'bg-rose-50 text-rose-700 border-rose-100 dark:bg-rose-950/20 dark:text-rose-400' }}">
                                                {{ $past->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-xs italic max-w-xs truncate">{{ $past->staff_notes ?? 'No feedback logged' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-slate-400">No past health record history found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($pastAppointments->hasPages())
                        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700">
                            {{ $pastAppointments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- TAB 2: PROFILE MANAGEMENT -->
        <div id="tab-content-profile" class="hidden space-y-6">
            <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl p-8 shadow-sm">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white border-b border-slate-50 dark:border-slate-700 pb-3 mb-6">Patient Health Profile Details</h3>
                
                <form action="{{ route('admin.patients.update', $patient->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="name" class="text-sm font-bold text-slate-700 dark:text-slate-300">Account Name</label>
                            <input type="text" name="name" id="name" required value="{{ old('name', Auth::user()->name) }}"
                                   class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="phone" class="text-sm font-bold text-slate-700 dark:text-slate-300">WhatsApp Phone Number</label>
                            <input type="text" name="phone" id="phone" required value="{{ old('phone', $patient->phone) }}"
                                   class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="date_of_birth" class="text-sm font-bold text-slate-700 dark:text-slate-300">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" required value="{{ old('date_of_birth', $patient->date_of_birth) }}"
                                   class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="gender" class="text-sm font-bold text-slate-700 dark:text-slate-300">Gender</label>
                            <select name="gender" id="gender" required
                                    class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                                <option value="Male" {{ $patient->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $patient->gender === 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ $patient->gender === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="address" class="text-sm font-bold text-slate-700 dark:text-slate-300">Residential Address</label>
                        <input type="text" name="address" id="address" required value="{{ old('address', $patient->address) }}"
                               class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                    </div>

                    <div class="space-y-2">
                        <label for="medical_history" class="text-sm font-bold text-slate-700 dark:text-slate-300">Chronic Conditions & Medical History (Confidential)</label>
                        <textarea name="medical_history" id="medical_history" rows="4" placeholder="List chronic illnesses, medications, or allergies..."
                                  class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">{{ old('medical_history', $patient->medical_history) }}</textarea>
                    </div>

                    <button type="submit" class="px-6 py-3.5 rounded-full bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold transition-all">
                        Update Profile Info
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function switchTab(tab) {
        // Hide all tab contents
        document.getElementById('tab-content-bookings').classList.add('hidden');
        document.getElementById('tab-content-profile').classList.add('hidden');
        
        // Remove classes from buttons
        const btnBookings = document.getElementById('tab-btn-bookings');
        const btnProfile = document.getElementById('tab-btn-profile');
        
        btnBookings.className = 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 dark:text-slate-400 dark:hover:text-slate-300 dark:hover:border-slate-600 border-b-2 py-4 px-1 text-sm font-semibold tracking-tight transition-all';
        btnProfile.className = 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 dark:text-slate-400 dark:hover:text-slate-300 dark:hover:border-slate-600 border-b-2 py-4 px-1 text-sm font-semibold tracking-tight transition-all';

        // Show selected content and activate button
        if (tab === 'bookings') {
            document.getElementById('tab-content-bookings').classList.remove('hidden');
            btnBookings.className = 'border-teal-500 text-teal-600 dark:text-teal-400 border-b-2 py-4 px-1 text-sm font-bold tracking-tight transition-all';
        } else {
            document.getElementById('tab-content-profile').classList.remove('hidden');
            btnProfile.className = 'border-teal-500 text-teal-600 dark:text-teal-400 border-b-2 py-4 px-1 text-sm font-bold tracking-tight transition-all';
        }
    }
</script>
</x-app-layout>
