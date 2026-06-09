<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::where('is_active', true)->get();
        
        // Available dates: Next 14 days, excluding Sundays
        $availableDates = [];
        $date = Carbon::today();
        for ($i = 0; $i < 14; $i++) {
            if ($date->dayOfWeek !== Carbon::SUNDAY) {
                $availableDates[] = [
                    'formatted' => $date->format('Y-m-d'),
                    'display' => $date->format('l, M j, Y'),
                ];
            }
            $date->addDay();
        }

        $timeSlots = ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'];
        
        $selectedService = $request->query('service_id');

        return view('public.booking', compact('services', 'availableDates', 'timeSlots', 'selectedService'));
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        $date = $request->date;
        $slots = ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'];
        
        // Find already booked slots on this date
        $bookedTimes = Appointment::where('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->pluck('appointment_time')
            ->map(function ($time) {
                return Carbon::parse($time)->format('H:i');
            })
            ->toArray();

        $availableSlots = [];
        foreach ($slots as $slot) {
            $availableSlots[] = [
                'time' => $slot,
                'available' => !in_array($slot, $bookedTimes),
            ];
        }

        return response()->json($availableSlots);
    }

    public function store(Request $request)
    {
        // 1. Validation rules
        $rules = [
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|string',
            'notes' => 'nullable|string|max:500',
        ];

        // If guest, require registration fields
        if (!Auth::check()) {
            $rules += [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:20',
                'date_of_birth' => 'required|date|before:today',
                'gender' => 'required|string|in:Male,Female,Other',
                'address' => 'required|string|max:500',
                'password' => 'required|string|min:8|confirmed',
            ];
        }

        $request->validate($rules);

        // Check if slot is already booked
        $existing = Appointment::where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($existing) {
            return back()->withErrors(['appointment_time' => 'The selected time slot is no longer available. Please choose another one.'])->withInput();
        }

        DB::beginTransaction();
        try {
            if (Auth::check()) {
                $user = Auth::user();
                $patient = $user->patient;
                if (!$patient) {
                    $patient = Patient::create([
                        'user_id' => $user->id,
                        'phone' => $request->phone ?? '+263',
                        'date_of_birth' => $request->date_of_birth ?? '1990-01-01',
                        'gender' => $request->gender ?? 'Other',
                        'address' => $request->address ?? 'Harare, Zimbabwe',
                    ]);
                }
            } else {
                // Register Guest User
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'patient',
                ]);

                // Create Patient Profile
                $patient = Patient::create([
                    'user_id' => $user->id,
                    'phone' => $request->phone,
                    'date_of_birth' => $request->date_of_birth,
                    'gender' => $request->gender,
                    'address' => $request->address,
                ]);

                // Auto login
                Auth::login($user);
            }

            // Create Appointment
            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'service_id' => $request->service_id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'status' => 'pending',
                'notes' => $request->notes,
            ]);

            DB::commit();

            return redirect()->route('patient.dashboard')->with('success', 'Appointment booked successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'An error occurred during booking: ' . $e->getMessage()])->withInput();
        }
    }
}
