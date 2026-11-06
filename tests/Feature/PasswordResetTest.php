<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_page_shows_email_step(): void
    {
        $this->get('/forgot-password')
            ->assertOk()
            ->assertSee('Lupa Kata Sandi')
            ->assertSee('Lanjut');
    }

    public function test_unknown_email_is_rejected(): void
    {
        $this->from('/forgot-password')
            ->post('/forgot-password', ['email' => 'tidak-terdaftar@rsud-medika.go.id'])
            ->assertRedirect('/forgot-password')
            ->assertSessionHasErrors([
                'email' => 'Email tidak terdaftar.',
            ]);
    }

    public function test_known_email_reveals_password_fields(): void
    {
        $user = User::factory()->create(['email' => 'petugas@rsud-medika.go.id']);

        $this->from('/forgot-password')
            ->post('/forgot-password', ['email' => $user->email])
            ->assertRedirect('/forgot-password')
            ->assertSessionHas('reset_email', $user->email)
            ->assertSessionHasNoErrors();

        $this->get('/forgot-password')
            ->assertOk()
            ->assertSee('Atur Ulang Kata Sandi')
            ->assertSee($user->email);
    }

    public function test_password_can_be_updated_after_email_check(): void
    {
        $user = User::factory()->create(['password' => 'password-lama']);

        $this->post('/reset-password', [
            'email' => $user->email,
            'password' => 'KataSandiBaru1!',
            'password_confirmation' => 'KataSandiBaru1!',
        ])->assertRedirect('/login')->assertSessionHas('status');

        $this->assertTrue(Hash::check('KataSandiBaru1!', $user->fresh()->password));
    }

    public function test_password_update_keeps_step_two_on_validation_error(): void
    {
        $user = User::factory()->create();

        $this->from('/forgot-password')
            ->post('/reset-password', [
                'email' => $user->email,
                'password' => 'KataSandiBaru1!',
                'password_confirmation' => 'beda',
            ])
            ->assertRedirect('/forgot-password')
            ->assertSessionHasErrors('password')
            ->assertSessionHas('reset_email', $user->email);
    }

    public function test_password_update_rejects_unknown_email(): void
    {
        $this->from('/forgot-password')
            ->post('/reset-password', [
                'email' => 'ghost@rsud-medika.go.id',
                'password' => 'KataSandiBaru1!',
                'password_confirmation' => 'KataSandiBaru1!',
            ])
            ->assertSessionHasErrors('email');
    }

    public function test_password_must_be_at_least_eight_characters(): void
    {
        $user = User::factory()->create();

        $this->from('/forgot-password')
            ->post('/reset-password', [
                'email' => $user->email,
                'password' => 'pendek',
                'password_confirmation' => 'pendek',
            ])
            ->assertSessionHasErrors('password');
    }
}
