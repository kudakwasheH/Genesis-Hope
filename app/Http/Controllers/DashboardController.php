<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use App\Models\User;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'patient') {
            return $this->patientDashboard($user);
        }

        return $this->adminDashboard();
    }

    private function patientDashboard($user)
    {
        $patient = $user->patient;

        if (!$patient) {
            $patient = Patient::create([
                'user_id' => $user->id,
                'phone' => '+263',
                'date_of_birth' => '1990-01-01',
                'gender' => 'Other',
                'address' => 'Harare, Zimbabwe',
            ]);
        }

        $upcomingAppointments = Appointment::with('service')
            ->where('patient_id', $patient->id)
            ->where('appointment_date', '>=', Carbon::today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        $pastAppointments = Appointment::with('service')
            ->where('patient_id', $patient->id)
            ->where(function($query) {
                $query->where('appointment_date', '<', Carbon::today())
                      ->orWhereIn('status', ['completed', 'cancelled']);
            })
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(5);

        return view('patient.dashboard', compact('patient', 'upcomingAppointments', 'pastAppointments'));
    }

    private function adminDashboard()
    {
        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $confirmedAppointments = Appointment::where('status', 'confirmed')->count();
        $totalPatients = Patient::count();
        
        $recentAppointments = Appointment::with(['patient.user', 'service'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentMessages = ContactMessage::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Bookings by Status
        $statusCounts = Appointment::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        $statusData = [];
        foreach ($statuses as $status) {
            $statusData[] = $statusCounts[$status] ?? 0;
        }

        // Bookings over the last 6 months (SQLite / MySQL format support)
        $isSqlite = DB::connection()->getDriverName() === 'sqlite';
        $monthlyBookings = Appointment::select(
                $isSqlite 
                    ? DB::raw("strftime('%m', appointment_date) as month") 
                    : DB::raw("DATE_FORMAT(appointment_date, '%m') as month"),
                $isSqlite 
                    ? DB::raw("strftime('%Y', appointment_date) as year") 
                    : DB::raw("DATE_FORMAT(appointment_date, '%Y') as year"),
                DB::raw('count(*) as total')
            )
            ->where('appointment_date', '>=', Carbon::today()->subMonths(6)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $monthlyLabels = [];
        $monthlyValues = [];
        foreach ($monthlyBookings as $record) {
            $date = Carbon::createFromDate($record->year, $record->month, 1);
            $monthlyLabels[] = $date->format('M Y');
            $monthlyValues[] = $record->total;
        }

        // Popular Services
        $popularServices = Service::select('services.name', DB::raw('count(appointments.id) as total'))
            ->join('appointments', 'services.id', '=', 'appointments.service_id')
            ->groupBy('services.id', 'services.name')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        $serviceLabels = $popularServices->pluck('name')->toArray();
        $serviceValues = $popularServices->pluck('total')->toArray();

        return view('dashboard', compact(
            'totalAppointments',
            'pendingAppointments',
            'confirmedAppointments',
            'totalPatients',
            'recentAppointments',
            'recentMessages',
            'statusData',
            'monthlyLabels',
            'monthlyValues',
            'serviceLabels',
            'serviceValues'
        ));
    }
}
