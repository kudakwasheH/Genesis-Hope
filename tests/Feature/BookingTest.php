<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    private $service;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test service
        $this->service = Service::create([
            'name' => 'General Consult',
            'slug' => 'general-consult',
            'description' => 'Test consult description',
            'duration' => 30,
            'price' => 20.00,
            'is_active' => true,
        ]);
    }

    public function test_booking_page_loads_successfully(): void
    {
        $response = $this->get('/book');
        $response->assertStatus(200);
        $response->assertSee('General Consult');
    }

    public function test_guest_can_book_and_auto_registers(): void
    {
        $response = $this->post('/book', [
            'service_id' => $this->service->id,
            'appointment_date' => date('Y-m-d', strtotime('+1 day')),
            'appointment_time' => '10:00',
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone' => '+263777777777',
            'date_of_birth' => '1990-01-01',
            'gender' => 'Male',
            'address' => 'Harare Central',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'notes' => 'Feeling unwell.',
        ]);

        $response->assertRedirect(route('patient.dashboard'));

        // Check user creation
        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com',
            'role' => 'patient',
        ]);

        // Check patient profile creation
        $user = User::where('email', 'john.doe@example.com')->first();
        $this->assertDatabaseHas('patients', [
            'user_id' => $user->id,
            'phone' => '+263777777777',
        ]);

        // Check appointment creation
        $patient = Patient::where('user_id', $user->id)->first();
        $this->assertDatabaseHas('appointments', [
            'patient_id' => $patient->id,
            'service_id' => $this->service->id,
            'appointment_time' => '10:00',
            'notes' => 'Feeling unwell.',
        ]);
    }

    public function test_patients_cannot_access_admin_dashboard_sections(): void
    {
        $patientUser = User::create([
            'name' => 'Patient User',
            'email' => 'patient.test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'patient',
        ]);

        // Access services CRUD (admin only)
        $response = $this->actingAs($patientUser)->get('/dashboard/services');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_dashboard_sections(): void
    {
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin.test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($adminUser)->get('/dashboard/services');
        $response->assertStatus(200);
    }

    public function test_patient_can_access_patient_dashboard(): void
    {
        $patientUser = User::create([
            'name' => 'Patient User',
            'email' => 'patient.test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'patient',
        ]);

        $response = $this->actingAs($patientUser)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Patient Health Portal');
    }
}
