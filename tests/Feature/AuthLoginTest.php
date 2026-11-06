<?php

namespace Tests\Feature;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Masuk ke SIM Inventori');
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'petugas.cssd@rsud-medika.go.id',
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $user = User::factory()->create();

        $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'salah',
        ])->assertRedirect('/login')->assertSessionHasErrors([
            'email' => 'Email atau kata sandi tidak cocok.',
        ]);

        $this->assertGuest();
    }

    public function test_login_validates_email_format(): void
    {
        $this->from('/login')->post('/login', [
            'email' => 'bukan-email',
            'password' => 'secret',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_is_throttled_after_too_many_attempts(): void
    {
        $user = User::factory()->create();

        for ($i = 0; $i < LoginRequest::MAX_ATTEMPTS; $i++) {
            $this->from('/login')->post('/login', [
                'email' => $user->email,
                'password' => 'salah',
            ]);
        }

        $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'salah',
        ])->assertSessionHasErrors('email');

        $this->assertStringContainsString(
            'Terlalu banyak percobaan masuk',
            session('errors')->first('email'),
        );

        $this->assertGuest();
    }

    public function test_guest_is_redirected_to_login_from_root(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_root(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/')
            ->assertOk();
    }
}
