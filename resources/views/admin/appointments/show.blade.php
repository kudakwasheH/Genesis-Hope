@extends('layouts.admin')

@section('content')
<div class="space-y-8 max-w-4xl mx-auto">
    
    <!-- Header Back -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.appointments.index') }}" class="px-3 py-2 rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold transition-all">
            &larr; Back to Listings
        </a>
    </div>

    <!-- Booking Main Details Card -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-8 shadow-sm space-y-6">
        <div class="flex justify-between items-start border-b border-slate-50 dark:border-slate-700 pb-6">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Appointment #{{ $appointment->id }}</span>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ $appointment->service->name }}</h2>
            </div>
            
            @php
                $badgeColor = match($appointment->status) {
                    'pending' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/20 dark:text-amber-400',
                    'confirmed' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/20 dark:text-emerald-400',
                    'completed' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-950/20 dark:text-blue-400',
                    'cancelled' => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/20 dark:text-rose-400',
                };
            @endphp
            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold border capitalize {{ $badgeColor }}">
                {{ $appointment->status }}
            </span>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm leading-relaxed">
            <!-- Patient Info -->
            <div class="space-y-4">
                <h3 class="font-bold text-slate-900 dark:text-white uppercase tracking-wider text-xs border-b border-slate-50 dark:border-slate-700 pb-2">Patient Information</h3>
                
                @if($appointment->patient)
                    <div class="space-y-2 text-slate-600 dark:text-slate-400">
                        <p><strong>Name:</strong> <a href="{{ route('admin.patients.show', $appointment->patient_id) }}" class="text-teal-600 font-semibold hover:underline">{{ $appointment->patient->user->name ?? 'N/A' }}</a></p>
                        <p><strong>Email:</strong> {{ $appointment->patient->user->email ?? 'N/A' }}</p>
                        <p><strong>Phone:</strong> {{ $appointment->patient->phone }}</p>
                        <p><strong>Date of Birth:</strong> {{ $appointment->patient->date_of_birth }}</p>
                        <p><strong>Gender:</strong> {{ $appointment->patient->gender }}</p>
                        <p><strong>Address:</strong> {{ $appointment->patient->address }}</p>
                        <p><strong>Medical History:</strong> <span class="italic text-xs text-rose-500/90">{{ $appointment->patient->medical_history ?? 'None logged' }}</span></p>
                    </div>
                @else
                    <p class="text-slate-400 text-xs italic">Patient profile details unavailable.</p>
                @endif
            </div>

            <!-- Appointment Slot Info -->
            <div class="space-y-4">
                <h3 class="font-bold text-slate-900 dark:text-white uppercase tracking-wider text-xs border-b border-slate-50 dark:border-slate-700 pb-2">Schedule & Billing</h3>
                
                <div class="space-y-2 text-slate-600 dark:text-slate-400">
                    <p><strong>Scheduled Date:</strong> {{ $appointment->appointment_date ? $appointment->appointment_date->format('l, F j, Y') : 'N/A' }}</p>
                    <p><strong>Scheduled Time Slot:</strong> {{ $appointment->appointment_time }}</p>
                    <p><strong>Service Duration:</strong> {{ $appointment->service->duration ?? 0 }} minutes</p>
                    <p><strong>Consultation Rate:</strong> <span class="font-extrabold text-teal-600">${{ number_format($appointment->service->price ?? 0, 2) }}</span></p>
                    <p><strong>Booking Timestamp:</strong> {{ $appointment->created_at ? $appointment->created_at->format('M d, Y H:i') : 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Patient Notes -->
        @if($appointment->notes)
            <div class="bg-slate-50 dark:bg-slate-900 rounded-2xl p-6 border border-slate-100 dark:border-slate-800 space-y-2">
                <h4 class="font-bold text-xs text-slate-500 uppercase tracking-wider">Patient Symptoms / Notes</h4>
                <p class="text-slate-600 dark:text-slate-350 text-sm leading-relaxed italic">"{{ $appointment->notes }}"</p>
            </div>
        @endif
    </div>

    <!-- Management Form Card -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 p-8 shadow-sm space-y-6">
        <h3 class="font-bold text-slate-900 dark:text-white text-lg">Update Booking Status & Log Notes</h3>
        
        <form action="{{ route('admin.appointments.status', $appointment->id) }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Status Dropdown -->
                <div class="space-y-2 sm:col-span-1">
                    <label for="status" class="text-sm font-bold text-slate-700 dark:text-slate-300">Appointment Status</label>
                    <select name="status" id="status" required
                            class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">
                        <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>Pending Approval</option>
                        <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- Staff Notes -->
                <div class="space-y-2 sm:col-span-2">
                    <label for="staff_notes" class="text-sm font-bold text-slate-700 dark:text-slate-300">Internal Feedback / Doctor Notes</label>
                    <textarea name="staff_notes" id="staff_notes" rows="3" placeholder="Enter findings, prescription guides, or cancellation reasons here..."
                              class="w-full rounded-2xl border-slate-200 dark:border-slate-600 dark:bg-slate-900 focus:border-teal-500 focus:ring focus:ring-teal-200 dark:text-white text-sm px-4 py-3 bg-slate-50">{{ old('staff_notes', $appointment->staff_notes) }}</textarea>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 pt-4 border-t border-slate-50 dark:border-slate-700">
                <a href="{{ route('admin.appointments.print', $appointment->id) }}" target="_blank" class="px-6 py-3 rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-bold transition-all flex items-center space-x-2 shadow-sm">
                    <i class="fa-solid fa-print text-slate-500"></i>
                    <span>Print Summary / Invoice</span>
                </a>
                
                <button type="submit" class="px-8 py-3.5 rounded-full bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold transition-all">
                    Update Details
                </button>
            </div>
        </form>
    </div>

    <!-- Danger Zone (Delete) -->
    <div class="bg-rose-50/50 border border-rose-250 dark:bg-rose-950/10 dark:border-rose-900/30 rounded-3xl p-6 flex items-center justify-between">
        <div>
            <h4 class="font-bold text-rose-800 dark:text-rose-400 text-sm">Danger Zone</h4>
            <p class="text-slate-500 dark:text-slate-400 text-xs mt-0.5">Delete this appointment record entirely from system.</p>
        </div>
        <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record permanently?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-5 py-2.5 rounded-full bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all">
                Delete Record
            </button>
        </form>
    </div>
</div>
@endsection
