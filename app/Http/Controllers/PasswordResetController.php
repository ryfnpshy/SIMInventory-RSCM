<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    /**
     * Step 1 (email) or step 2 (new password), depending on the reset session flag.
     */
    public function requestForm(Request $request): View
    {
        return view('auth.forgot-password', [
            'resetEmail' => $request->session()->get('reset_email'),
        ]);
    }

    /**
     * Step 1: verify the email exists, then reveal the password fields.
     */
    public function checkEmail(Request $request): RedirectResponse
    {
        $request->validate(
            ['email' => ['required', 'string', 'email']],
            [
                'email.required' => 'Alamat email wajib diisi.',
                'email.email' => 'Format alamat email tidak valid.',
            ],
        );

        if (! User::where('email', $request->email)->exists()) {
            return back()->withInput()->withErrors(['email' => 'Email tidak terdaftar.']);
        }

        return redirect()->route('password.request')->with('reset_email', $request->email);
    }

    /**
     * Step 2: store the new password for the verified email.
     */
    public function update(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', Rule::exists('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.exists' => 'Email tidak terdaftar.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        if ($validator->fails()) {
            // Keep the form on step 2 so the user can correct the password.
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('reset_email', $request->input('email'));
        }

        $user = User::where('email', $request->email)->firstOrFail();

        // 'password' di-cast 'hashed', jadi plaintext otomatis di-hash.
        $user->forceFill([
            'password' => $request->password,
            'remember_token' => Str::random(60),
        ])->save();

        return redirect()
            ->route('login')
            ->with('status', 'Kata sandi berhasil diubah. Silakan masuk dengan kata sandi baru.');
    }
}
