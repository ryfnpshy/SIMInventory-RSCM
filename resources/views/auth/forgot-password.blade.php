@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi — SIM Inventori RS')

@section('content')
    <div class="space-y-space-md">
        {{-- Portal Header --}}
        <div class="flex items-center gap-space-sm pb-space-xs">
            <img alt="SIM Inventori RS" class="w-10 h-10 object-contain lg:hidden" src="https://lh3.googleusercontent.com/aida/AEtjO1X-afpY-o9J70HIHeLkCVerM2hnlixyr0wlDyYJxzfFWZadJ0ZRpy8fUp0PqMrOm9MaMiYRGNA8p61bFkJsX7uf79OqDvPHNN1BlcUz18xfLjFCVjQI36qD58JqaTgHHeedF57Ha_6h6Kq4W9U-P4qge8zPlJgBI8BxXfE0hec4PXU-qhHuXuAXeXAS5E0gKW1pdOxHnN_Beck_W31e4q1Lg5orm89igP7QYDkd9s7G">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="font-headline-md text-headline-md text-on-surface">SIM Inventori RS</h2>
                    <span class="px-2 py-0.5 rounded text-badge-sm font-badge-sm bg-surface-container-high text-secondary">MEDIS</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Sistem Informasi Manajemen Inventori Rumah Sakit</p>
            </div>
        </div>

        @error('email')
            <div class="bg-error-container text-on-error-container p-space-sm rounded-lg flex items-start gap-2.5 shadow-sm" id="errorAlert">
                <span class="material-symbols-outlined text-[20px] text-error shrink-0 mt-0.5" style="font-variation-settings: 'FILL' 1;">error</span>
                <span class="font-label-md text-label-md font-semibold text-error">{{ $message }}</span>
            </div>
        @enderror

        @error('password')
            <div class="bg-error-container text-on-error-container p-space-sm rounded-lg flex items-start gap-2.5 shadow-sm" id="errorAlert">
                <span class="material-symbols-outlined text-[20px] text-error shrink-0 mt-0.5" style="font-variation-settings: 'FILL' 1;">error</span>
                <span class="font-label-md text-label-md font-semibold text-error">{{ $message }}</span>
            </div>
        @enderror

        @if (! empty($resetEmail))
            {{-- STEP 2: new password --}}
            <div class="bg-surface-container-low p-space-sm rounded-lg flex flex-col gap-0.5">
                <span class="font-label-lg text-label-lg text-on-surface">Atur Ulang Kata Sandi</span>
                <span class="font-body-sm text-body-sm text-on-surface-variant">Buat kata sandi baru yang kuat untuk akun kedinasan Anda.</span>
            </div>

            <div class="flex items-center justify-between gap-2 px-3 py-2 rounded-lg bg-surface-container-lowest shadow-xs">
                <div class="flex items-center gap-2 min-w-0">
                    <span class="material-symbols-outlined text-[18px] text-primary shrink-0" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                    <span class="font-label-md text-label-md text-on-surface truncate">{{ $resetEmail }}</span>
                </div>
                <a class="text-secondary hover:underline font-label-md text-[11px] shrink-0" href="{{ route('password.request') }}">Ganti email</a>
            </div>

            <form class="space-y-space-md" action="{{ route('password.update') }}" method="POST">
                @csrf
                <input name="email" type="hidden" value="{{ $resetEmail }}">

                <div class="flex flex-col gap-1.5">
                    <label class="font-label-md text-label-md text-on-surface" for="password">Kata Sandi Baru</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-[18px] text-outline pointer-events-none">lock</span>
                        <input class="w-full bg-surface-container-low focus:bg-surface-container-lowest text-on-surface font-body-md text-body-md rounded-lg py-2.5 pl-10 pr-10 transition-all outline-none focus:ring-2 focus:ring-primary shadow-sm" id="password" name="password" placeholder="Minimal 8 karakter" required type="password" autocomplete="new-password" autofocus>
                        <button aria-label="Tampilkan atau sembunyikan kata sandi" class="absolute right-3 text-outline hover:text-on-surface p-1 rounded transition-colors flex items-center justify-center" id="togglePassword" type="button">
                            <span class="material-symbols-outlined text-[18px]" id="eyeIcon">visibility</span>
                        </button>
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="font-label-md text-label-md text-on-surface" for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-[18px] text-outline pointer-events-none">lock_reset</span>
                        <input class="w-full bg-surface-container-low focus:bg-surface-container-lowest text-on-surface font-body-md text-body-md rounded-lg py-2.5 pl-10 pr-3.5 transition-all outline-none focus:ring-2 focus:ring-primary shadow-sm" id="password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi baru" required type="password" autocomplete="new-password">
                    </div>
                </div>

                <button class="w-full py-3 px-space-md bg-primary hover:bg-primary-container text-on-primary font-label-lg text-label-lg rounded-lg shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-[0.99]" type="submit">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    <span>Simpan Kata Sandi Baru</span>
                </button>
            </form>
        @else
            {{-- STEP 1: email --}}
            <div class="bg-surface-container-low p-space-sm rounded-lg flex flex-col gap-0.5">
                <span class="font-label-lg text-label-lg text-on-surface">Lupa Kata Sandi</span>
                <span class="font-body-sm text-body-sm text-on-surface-variant">Masukkan alamat email kedinasan Anda untuk memverifikasi akun.</span>
            </div>

            <form class="space-y-space-md" action="{{ route('password.check') }}" method="POST">
                @csrf

                <div class="flex flex-col gap-1.5">
                    <label class="font-label-md text-label-md text-on-surface" for="email">Alamat Email Kedinasan</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-[18px] text-outline pointer-events-none">mail</span>
                        <input class="w-full bg-surface-container-low focus:bg-surface-container-lowest text-on-surface font-body-md text-body-md rounded-lg py-2.5 pl-10 pr-3.5 transition-all outline-none focus:ring-2 focus:ring-primary shadow-sm" id="email" name="email" placeholder="petugas@rsud-medika.go.id" required type="email" value="{{ old('email') }}" autofocus autocomplete="username">
                    </div>
                </div>

                <button class="w-full py-3 px-space-md bg-primary hover:bg-primary-container text-on-primary font-label-lg text-label-lg rounded-lg shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-[0.99]" type="submit">
                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    <span>Lanjut</span>
                </button>
            </form>
        @endif

        <div class="text-center">
            <a class="inline-flex items-center gap-1.5 text-secondary hover:underline font-label-md text-label-md" href="{{ route('login') }}">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                <span>Kembali ke halaman masuk</span>
            </a>
        </div>
    </div>

    @if (! empty($resetEmail))
        @push('scripts')
            <script>
                (function () {
                    const toggleBtn = document.getElementById('togglePassword');
                    const passwordInput = document.getElementById('password');
                    const eyeIcon = document.getElementById('eyeIcon');

                    if (toggleBtn && passwordInput && eyeIcon) {
                        toggleBtn.addEventListener('click', function () {
                            const isPassword = passwordInput.getAttribute('type') === 'password';
                            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                            eyeIcon.textContent = isPassword ? 'visibility_off' : 'visibility';
                        });
                    }
                })();
            </script>
        @endpush
    @endif
@endsection
