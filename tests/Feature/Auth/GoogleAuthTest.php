<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Tests\TestCase;

class GoogleAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_redirect_route_returns_redirect(): void
    {
        $provider = $this->createMock(\Laravel\Socialite\Two\GoogleProvider::class);
        $provider->method('redirect')->willReturn(redirect()->away('https://accounts.google.com'));

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get('/auth/google');

        $response->assertRedirect('https://accounts.google.com');
    }

    public function test_google_callback_creates_and_authenticates_new_user(): void
    {
        $abstractUser = $this->createMock(\Laravel\Socialite\Two\User::class);
        $abstractUser->method('getId')->willReturn('google-id-123');
        $abstractUser->method('getName')->willReturn('Google User');
        $abstractUser->method('getEmail')->willReturn('google.user@example.com');

        $provider = $this->createMock(\Laravel\Socialite\Two\GoogleProvider::class);
        $provider->method('user')->willReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'google.user@example.com',
            'google_id' => 'google-id-123',
            'role' => 'patient',
        ]);

        $this->assertAuthenticated();
    }

    public function test_google_callback_authenticates_existing_user_by_google_id(): void
    {
        $existingUser = User::create([
            'name' => 'Existing User',
            'email' => 'existing@example.com',
            'google_id' => 'google-id-456',
            'role' => 'patient',
        ]);

        $abstractUser = $this->createMock(\Laravel\Socialite\Two\User::class);
        $abstractUser->method('getId')->willReturn('google-id-456');
        $abstractUser->method('getName')->willReturn('Google User');
        $abstractUser->method('getEmail')->willReturn('existing@example.com');

        $provider = $this->createMock(\Laravel\Socialite\Two\GoogleProvider::class);
        $provider->method('user')->willReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($existingUser);
    }

    public function test_google_callback_authenticates_and_links_existing_email(): void
    {
        $existingUser = User::create([
            'name' => 'Existing User',
            'email' => 'existing.email@example.com',
            'role' => 'patient',
            'password' => bcrypt('password123'),
        ]);

        $abstractUser = $this->createMock(\Laravel\Socialite\Two\User::class);
        $abstractUser->method('getId')->willReturn('google-id-789');
        $abstractUser->method('getName')->willReturn('Google User');
        $abstractUser->method('getEmail')->willReturn('existing.email@example.com');

        $provider = $this->createMock(\Laravel\Socialite\Two\GoogleProvider::class);
        $provider->method('user')->willReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($existingUser);

        $this->assertDatabaseHas('users', [
            'email' => 'existing.email@example.com',
            'google_id' => 'google-id-789',
        ]);
    }
}
