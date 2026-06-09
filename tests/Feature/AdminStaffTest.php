<?php

namespace Tests\Feature;

use App\Models\User;
use App\Mail\StaffCreatedMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AdminStaffTest extends TestCase
{
    use RefreshDatabase;

    private $adminUser;
    private $patientUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@genesis.org.zw',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $this->patientUser = User::create([
            'name' => 'Patient User',
            'email' => 'patient@genesis.org.zw',
            'password' => bcrypt('password123'),
            'role' => 'patient',
        ]);
    }

    public function test_guests_cannot_access_staff_creation(): void
    {
        // Guest check
        $response = $this->get('/dashboard/staff/create');
        $response->assertRedirect('/login');

        // Guest post check
        $response = $this->post('/dashboard/staff', [
            'name' => 'New Doctor',
            'email' => 'doctor@genesis.org.zw',
            'role' => 'staff',
        ]);
        $response->assertRedirect('/login');
    }

    public function test_patients_cannot_access_staff_creation(): void
    {
        // Patient check
        $response = $this->actingAs($this->patientUser)->get('/dashboard/staff/create');
        $response->assertStatus(403);

        // Patient post check
        $response = $this->actingAs($this->patientUser)->post('/dashboard/staff', [
            'name' => 'New Doctor',
            'email' => 'doctor@genesis.org.zw',
            'role' => 'staff',
        ]);
        $response->assertStatus(403);
    }

    public function test_admin_can_access_staff_creation_page(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/dashboard/staff/create');
        $response->assertStatus(200);
        $response->assertSee('Register Staff Account');
        $response->assertSee('One-Time Password Setup');
    }

    public function test_admin_can_create_staff_and_sends_email_with_otp(): void
    {
        Mail::fake();

        $response = $this->actingAs($this->adminUser)->post('/dashboard/staff', [
            'name' => 'Dr. Jane Smith',
            'email' => 'janesmith@genesis.org.zw',
            'role' => 'staff',
        ]);

        $response->assertRedirect(route('admin.staff.index'));
        $response->assertSessionHas('success', 'Staff member added successfully. Credentials with a one-time password have been sent to their email.');

        // Assert user was created
        $this->assertDatabaseHas('users', [
            'name' => 'Dr. Jane Smith',
            'email' => 'janesmith@genesis.org.zw',
            'role' => 'staff',
        ]);

        // Retrieve created user
        $user = User::where('email', 'janesmith@genesis.org.zw')->first();
        $this->assertNotNull($user->password); // Hashed password exists

        // Assert that the email was sent
        Mail::assertSent(StaffCreatedMail::class, function ($mail) use ($user) {
            return $mail->hasTo('janesmith@genesis.org.zw') &&
                   $mail->user->id === $user->id &&
                   strlen($mail->password) === 12; // OTP length is 12
        });
    }
}
