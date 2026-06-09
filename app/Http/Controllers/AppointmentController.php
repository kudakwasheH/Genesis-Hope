<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient.user', 'service']);

        // Filter by search (patient name or email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by service
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        $appointments = $query->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->paginate(15)
            ->withQueryString();

        $services = Service::where('is_active', true)->orderBy('name')->get();

        return view('admin.appointments.index', compact('appointments', 'services'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'service']);
        return view('admin.appointments.show', compact('appointment'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|string|in:pending,confirmed,completed,cancelled',
            'staff_notes' => 'nullable|string|max:1000',
        ]);

        $appointment->update([
            'status' => $request->status,
            'staff_notes' => $request->staff_notes,
        ]);

        return redirect()->back()->with('success', 'Appointment status updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('admin.appointments.index')->with('success', 'Appointment deleted successfully.');
    }

    public function exportCsv(Request $request)
    {
        $query = Appointment::with(['patient.user', 'service']);

        // Reapply active filters to report
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="genesis_appointments_report_' . date('Ymd_His') . '.csv"',
            'Cache-Control' => 'no-cache, must-revalidate',
            'Expires' => '0',
        ];

        $callback = function() use ($appointments) {
            $file = fopen('php://output', 'w');
            
            // CSV header
            fputcsv($file, [
                'Appointment ID', 
                'Patient Name', 
                'Patient Email', 
                'Patient Phone', 
                'Service Name', 
                'Price ($)', 
                'Duration (min)', 
                'Date', 
                'Time', 
                'Status', 
                'Patient Notes', 
                'Staff Notes', 
                'Booked At'
            ]);

            foreach ($appointments as $app) {
                fputcsv($file, [
                    $app->id,
                    $app->patient->user->name ?? 'N/A',
                    $app->patient->user->email ?? 'N/A',
                    $app->patient->phone ?? 'N/A',
                    $app->service->name ?? 'N/A',
                    $app->service->price ?? 0.00,
                    $app->service->duration ?? 0,
                    $app->appointment_date ? $app->appointment_date->format('Y-m-d') : 'N/A',
                    $app->appointment_time,
                    ucfirst($app->status),
                    $app->notes ?? '',
                    $app->staff_notes ?? '',
                    $app->created_at ? $app->created_at->format('Y-m-d H:i:s') : 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function printInvoice(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'service']);
        return view('admin.appointments.print', compact('appointment'));
    }
}
