@extends('layouts.public')

@section('title', 'Book Appointment - ' . ($siteSettings['site_name'] ?? 'Genesis Goodhope Population Health'))

@section('content')
<!-- Subpage Header -->
<section class="bg-gradient-to-r from-slate-900 to-teal-950 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-2">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Appointment Booking Wizard</h1>
        <p class="text-slate-300 max-w-xl mx-auto text-sm">Fill in the details below to secure a confirmed appointment slot instantly.</p>
    </div>
</section>

<!-- Booking Body -->
<section class="py-16 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white border border-slate-100 rounded-3xl p-8 sm:p-12 shadow-sm space-y-8">
        
        <!-- Step Indicators -->
        <div class="flex items-center justify-between max-w-md mx-auto mb-10 text-xs sm:text-sm font-semibold text-slate-400">
            <div class="flex items-center space-x-2 text-teal-600" id="step-indicator-1">
                <span class="w-7 h-7 rounded-full bg-teal-50 border border-teal-500 flex items-center justify-center font-bold">1</span>
                <span>Service</span>
            </div>
            <div class="flex-grow border-t border-slate-200 mx-3"></div>
            <div class="flex items-center space-x-2" id="step-indicator-2">
                <span class="w-7 h-7 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center font-bold">2</span>
                <span>Date & Time</span>
            </div>
            <div class="flex-grow border-t border-slate-200 mx-3"></div>
            <div class="flex items-center space-x-2" id="step-indicator-3">
                <span class="w-7 h-7 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center font-bold">3</span>
                <span>Profile Details</span>
            </div>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl p-4 text-sm font-semibold space-y-1">
                @foreach($errors->all() as $error)
                    <p><i class="fa-solid fa-circle-exclamation text-rose-600 mr-2"></i> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('booking.store') }}" method="POST" id="booking-form" class="space-y-8">
            @csrf

            <!-- STEP 1: SERVICE SELECTION -->
            <div id="step-1" class="step-container space-y-6">
                <h3 class="text-xl font-bold text-slate-900 border-b border-slate-50 pb-3">Step 1: Select Healthcare Service</h3>
                
                <div class="grid grid-cols-1 gap-4">
                    @foreach($services as $service)
                        <label class="relative border rounded-2xl p-6 flex items-start space-x-4 cursor-pointer hover:bg-slate-50 transition-all select-none {{ $selectedService == $service->id ? 'border-teal-500 bg-teal-50/10' : 'border-slate-200' }}" 
                               id="service-label-{{ $service->id }}">
                            <input type="radio" name="service_id" value="{{ $service->id }}" class="mt-1 text-teal-600 focus:ring-teal-500" 
                                   {{ $selectedService == $service->id ? 'checked' : '' }}
                                   onclick="selectService({{ $service->id }})">
                            <div class="flex-grow text-sm">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-bold text-slate-900 text-base">{{ $service->name }}</span>
                                    <span class="font-extrabold text-teal-700 text-base">${{ number_format($service->price, 2) }}</span>
                                </div>
                                <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">{{ $service->description }}</p>
                                <div class="mt-2 text-slate-400 text-xs">
                                    <i class="fa-solid fa-clock mr-1"></i> Duration: {{ $service->duration }} minutes
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>

                <div class="flex justify-end pt-4">
                    <button type="button" onclick="goToStep(2)" class="px-8 py-3.5 rounded-full bg-slate-900 text-white font-bold hover:bg-slate-800 transition-all text-sm">
                        Continue to Date & Time
                    </button>
                </div>
            </div>

            <!-- STEP 2: DATE & TIME SELECTION -->
            <div id="step-2" class="step-container hidden space-y-6">
                <h3 class="text-xl font-bold text-slate-900 border-b border-slate-50 pb-3">Step 2: Choose Date & Time</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Date Selection -->
                    <div class="space-y-3">
                        <label for="appointment_date" class="text-sm font-bold text-slate-700 block">Select Date</label>
                        <select name="appointment_date" id="appointment_date" required onchange="fetchTimeSlots()" 
                                class="w-full rounded-2xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 transition-all text-sm px-4 py-3 bg-slate-50">
                            <option value="">-- Choose Date --</option>
                            @foreach($availableDates as $dateOption)
                                <option value="{{ $dateOption['formatted'] }}" {{ old('appointment_date') == $dateOption['formatted'] ? 'selected' : '' }}>
                                    {{ $dateOption['display'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Time Slots Selection -->
                    <div class="space-y-3">
                        <span class="text-sm font-bold text-slate-700 block">Available Slots</span>
                        <div id="slots-loader" class="hidden text-slate-400 text-xs py-2"><i class="fa-solid fa-spinner fa-spin mr-1.5"></i> Checking slot counts...</div>
                        
                        <div id="slots-grid" class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <p class="text-slate-400 text-xs col-span-3 italic">Please select a date to view available time slots.</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between pt-6 border-t border-slate-50">
                    <button type="button" onclick="goToStep(1)" class="px-6 py-3 rounded-full border border-slate-200 hover:bg-slate-50 text-slate-600 font-bold transition-all text-sm">
                        &larr; Back
                    </button>
                    <button type="button" onclick="goToStep(3)" class="px-8 py-3.5 rounded-full bg-slate-900 text-white font-bold hover:bg-slate-800 transition-all text-sm">
                        Continue to Details
                    </button>
                </div>
            </div>

            <!-- STEP 3: REGISTRATION AND PROFILE DETAILS -->
            <div id="step-3" class="step-container hidden space-y-6">
                <h3 class="text-xl font-bold text-slate-900 border-b border-slate-50 pb-3">Step 3: Patient Information</h3>

                @auth
                    <!-- Pre-filled info -->
                    <div class="bg-teal-50 border border-teal-200 text-teal-800 rounded-2xl p-6 space-y-4">
                        <div class="flex items-center space-x-3">
                            <i class="fa-solid fa-user-circle text-2xl text-teal-700"></i>
                            <h4 class="font-bold text-base">Booking as: {{ Auth::user()->name }}</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600">
                            We will associate this appointment automatically with your profile. You can review your patient records in your dashboard after booking.
                        </p>
                    </div>
                @else
                    <!-- Guest Registration Form -->
                    <div class="bg-slate-50 border border-slate-100 rounded-3xl p-6 space-y-6">
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Since you are not currently logged in, completing this booking will automatically register a secure health portal account for you.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="name" class="text-sm font-bold text-slate-700">Full Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="John Doe" 
                                       class="w-full rounded-2xl border-slate-200 focus:border-teal-500 focus:ring-teal-200 transition-all text-sm px-4 py-3 bg-white">
                            </div>
                            
                            <div class="space-y-2">
                                <label for="email" class="text-sm font-bold text-slate-700">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="john@example.com" 
                                       class="w-full rounded-2xl border-slate-200 focus:border-teal-500 focus:ring-teal-200 transition-all text-sm px-4 py-3 bg-white">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="phone" class="text-sm font-bold text-slate-700">Phone Number (WhatsApp Active)</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="+263 77 123 4567" 
                                       class="w-full rounded-2xl border-slate-200 focus:border-teal-500 focus:ring-teal-200 transition-all text-sm px-4 py-3 bg-white">
                            </div>
                            
                            <div class="space-y-2">
                                <label for="date_of_birth" class="text-sm font-bold text-slate-700">Date of Birth</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" 
                                       class="w-full rounded-2xl border-slate-200 focus:border-teal-500 focus:ring-teal-200 transition-all text-sm px-4 py-3 bg-white">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="gender" class="text-sm font-bold text-slate-700">Gender</label>
                                <select name="gender" id="gender" 
                                        class="w-full rounded-2xl border-slate-200 focus:border-teal-500 focus:ring-teal-200 transition-all text-sm px-4 py-3 bg-white">
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            
                            <div class="space-y-2">
                                <label for="address" class="text-sm font-bold text-slate-700">Residential Address</label>
                                <input type="text" name="address" id="address" value="{{ old('address') }}" placeholder="12 Fife Ave, Harare" 
                                       class="w-full rounded-2xl border-slate-200 focus:border-teal-500 focus:ring-teal-200 transition-all text-sm px-4 py-3 bg-white">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="password" class="text-sm font-bold text-slate-700">Password</label>
                                <input type="password" name="password" id="password" placeholder="Min 8 characters" 
                                       class="w-full rounded-2xl border-slate-200 focus:border-teal-500 focus:ring-teal-200 transition-all text-sm px-4 py-3 bg-white">
                            </div>
                            
                            <div class="space-y-2">
                                <label for="password_confirmation" class="text-sm font-bold text-slate-700">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type password" 
                                       class="w-full rounded-2xl border-slate-200 focus:border-teal-500 focus:ring-teal-200 transition-all text-sm px-4 py-3 bg-white">
                            </div>
                        </div>
                    </div>
                @endauth

                <!-- General Notes -->
                <div class="space-y-2">
                    <label for="notes" class="text-sm font-bold text-slate-700">Additional Notes / Symptoms (Optional)</label>
                    <textarea name="notes" id="notes" rows="3" placeholder="Provide any details about symptoms or background health info..." 
                              class="w-full rounded-2xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 transition-all text-sm px-4 py-3 bg-slate-50">{{ old('notes') }}</textarea>
                </div>

                <div class="flex justify-between pt-6 border-t border-slate-50">
                    <button type="button" onclick="goToStep(2)" class="px-6 py-3 rounded-full border border-slate-200 hover:bg-slate-50 text-slate-600 font-bold transition-all text-sm">
                        &larr; Back
                    </button>
                    <button type="submit" class="px-8 py-4 rounded-full bg-gradient-to-r from-teal-600 to-emerald-500 hover:from-teal-700 hover:to-emerald-600 text-white font-bold transition-all text-sm shadow-md">
                        Submit & Book Appointment
                    </button>
                </div>
            </div>

        </form>
    </div>
</section>

<!-- Scripts -->
@section('scripts')
<script>
    function selectService(id) {
        // Remove class from all labels
        document.querySelectorAll('[id^="service-label-"]').forEach(lbl => {
            lbl.classList.remove('border-teal-500', 'bg-teal-50/10');
            lbl.classList.add('border-slate-200');
        });
        
        // Add class to active label
        const activeLabel = document.getElementById('service-label-' + id);
        if (activeLabel) {
            activeLabel.classList.remove('border-slate-200');
            activeLabel.classList.add('border-teal-500', 'bg-teal-50/10');
        }
    }

    function goToStep(stepNumber) {
        // Validate basic fields before advancing
        if (stepNumber === 2) {
            const selected = document.querySelector('input[name="service_id"]:checked');
            if (!selected) {
                alert('Please choose a healthcare service before continuing.');
                return;
            }
        }
        
        if (stepNumber === 3) {
            const date = document.getElementById('appointment_date').value;
            const time = document.querySelector('input[name="appointment_time"]:checked');
            if (!date || !time) {
                alert('Please select an appointment date and an available time slot.');
                return;
            }
        }

        // Hide all steps
        document.querySelectorAll('.step-container').forEach(el => el.classList.add('hidden'));
        
        // Show selected step
        document.getElementById('step-' + stepNumber).classList.remove('hidden');

        // Update step indicators
        document.querySelectorAll('[id^="step-indicator-"]').forEach(indicator => {
            indicator.classList.remove('text-teal-600');
            const span = indicator.querySelector('span');
            span.classList.remove('bg-teal-50', 'border-teal-500');
            span.classList.add('bg-slate-50', 'border-slate-200');
        });

        for (let i = 1; i <= stepNumber; i++) {
            const ind = document.getElementById('step-indicator-' + i);
            if (ind) {
                ind.classList.add('text-teal-600');
                const sp = ind.querySelector('span');
                sp.classList.remove('bg-slate-50', 'border-slate-200');
                sp.classList.add('bg-teal-50', 'border-teal-500');
            }
        }
    }

    function fetchTimeSlots() {
        const dateInput = document.getElementById('appointment_date').value;
        const slotsGrid = document.getElementById('slots-grid');
        const loader = document.getElementById('slots-loader');
        
        if (!dateInput) {
            slotsGrid.innerHTML = '<p class="text-slate-400 text-xs col-span-3 italic">Please select a date to view available time slots.</p>';
            return;
        }

        loader.classList.remove('hidden');
        slotsGrid.innerHTML = '';

        fetch(`{{ route('booking.slots') }}?date=${dateInput}`)
            .then(res => res.json())
            .then(data => {
                loader.classList.add('hidden');
                
                let hasSlots = false;
                data.forEach(slot => {
                    const buttonId = `slot-${slot.time.replace(':', '-')}`;
                    const isDisabled = !slot.available;
                    
                    const labelClass = isDisabled 
                        ? 'border-slate-100 bg-slate-50 text-slate-300 opacity-50 cursor-not-allowed' 
                        : 'border-slate-200 hover:border-teal-500 hover:bg-teal-50/20 text-slate-800 cursor-pointer';

                    const inputHtml = isDisabled 
                        ? '' 
                        : `<input type="radio" name="appointment_time" value="${slot.time}" class="sr-only" onchange="highlightSlot('${buttonId}')">`;

                    const badgeHtml = isDisabled 
                        ? '<span class="text-[9px] uppercase tracking-wider font-extrabold text-slate-400">Booked</span>' 
                        : '<span class="text-[9px] uppercase tracking-wider font-extrabold text-teal-600">Available</span>';

                    slotsGrid.innerHTML += `
                        <label id="${buttonId}" class="relative border rounded-xl p-3 flex flex-col items-center justify-center text-center select-none transition-all ${labelClass}">
                            ${inputHtml}
                            <span class="font-bold text-sm block">${slot.time}</span>
                            ${badgeHtml}
                        </label>
                    `;
                });
            })
            .catch(err => {
                loader.classList.add('hidden');
                slotsGrid.innerHTML = '<p class="text-rose-500 text-xs col-span-3">Failed to load available slots. Please try refreshing.</p>';
            });
    }

    function highlightSlot(id) {
        document.querySelectorAll('[id^="slot-"]').forEach(lbl => {
            lbl.classList.remove('border-teal-500', 'bg-teal-50/20', 'ring-2', 'ring-teal-500');
            if (!lbl.classList.contains('opacity-50')) {
                lbl.classList.add('border-slate-200');
            }
        });

        const activeSlot = document.getElementById(id);
        if (activeSlot) {
            activeSlot.classList.remove('border-slate-200');
            activeSlot.classList.add('border-teal-500', 'bg-teal-50/20', 'ring-2', 'ring-teal-500');
        }
    }
    
    // Trigger slots check if date was preselected (e.g. from validation error back)
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('appointment_date').value;
        if (dateInput) {
            fetchTimeSlots();
        }
    });
</script>
@endsection

@endsection
