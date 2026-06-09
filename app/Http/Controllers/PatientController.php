<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with(['user', 'appointments']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('phone', 'like', "%{$search}%");
        }

        $patients = $query->paginate(15)->withQueryString();

        return view('admin.patients.index', compact('patients'));
    }

    public function show(Patient $patient)
    {
        $patient->load(['user', 'appointments.service', 'testimonials']);
        return view('admin.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        $patient->load('user');
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:Male,Female,Other',
            'address' => 'required|string|max:500',
            'medical_history' => 'nullable|string',
        ]);

        // Update User Name
        $patient->user->update([
            'name' => $request->name,
        ]);

        // Update Patient Profile
        $patient->update([
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'medical_history' => $request->medical_history,
        ]);

        return redirect()->route('admin.patients.show', $patient->id)->with('success', 'Patient profile updated successfully.');
    }
}
