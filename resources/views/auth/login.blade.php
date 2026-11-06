@extends('layouts.auth')

@section('title', 'Login — SIM Inventori RS')

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

        {{-- Welcome Badge / Subheading --}}
        <div class="bg-surface-container-low p-space-sm rounded-lg flex flex-col gap-0.5">
            <span class="font-label-lg text-label-lg text-on-surface">Masuk ke Akun Anda</span>
            <span class="font-body-sm text-body-sm text-on-surface-variant">Silakan masukkan kredensial resmi rumah sakit untuk mengakses unit operasional.</span>
        </div>

        {{-- Success banner (e.g. setelah reset kata sandi) --}}
        @if (session('status'))
            <div class="bg-primary-container/15 text-on-primary-fixed p-space-sm rounded-lg flex items-start gap-2.5 shadow-sm" id="statusAlert">
                <span class="material-symbols-outlined text-[20px] text-primary shrink-0 mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                <span class="font-label-md text-label-md font-semibold">{{ session('status') }}</span>
            </div>
        @endif

        {{-- Validation error banner --}}
        @if ($errors->any())
            <div class="bg-error-container text-on-error-container p-space-sm rounded-lg flex items-start justify-between gap-3 shadow-sm transition-all duration-200" id="errorAlert">
                <div class="flex items-start gap-2.5">
                    <span class="material-symbols-outlined text-[20px] text-error shrink-0 mt-0.5" style="font-variation-settings: 'FILL' 1;">error</span>
                    <div class="flex flex-col text-body-sm font-body-sm">
                        <span class="font-label-md text-label-md font-semibold text-error">{{ $errors->first() }}</span>
                        <span class="text-on-error-container/80 text-[11px] leading-tight mt-0.5">Akun dinonaktifkan atau belum diverifikasi? Hubungi unit administrator SIMRS.</span>
                    </div>
                </div>
                <button aria-label="Tutup notifikasi" class="text-on-error-container/60 hover:text-on-error-container p-0.5 rounded" onclick="document.getElementById('errorAlert').style.display='none'" type="button">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
        @endif

        {{-- Authentication Form --}}
        <form class="space-y-space-md" id="loginForm" action="{{ route('login') }}" method="POST">
            @csrf

            {{-- Email Field --}}
            <div class="flex flex-col gap-1.5">
                <label class="font-label-md text-label-md text-on-surface flex items-center justify-between" for="email">
                    <span>Alamat Email Kedinasan</span>
                    <span class="text-on-surface-variant font-label-code text-[11px]">RSUD Domain</span>
                </label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-3 text-[18px] text-outline pointer-events-none">mail</span>
                    <input class="w-full bg-surface-container-low focus:bg-surface-container-lowest text-on-surface font-body-md text-body-md rounded-lg py-2.5 pl-10 pr-3.5 transition-all outline-none focus:ring-2 focus:ring-primary shadow-sm" id="email" name="email" placeholder="petugas@rsud-medika.go.id" required type="email" value="{{ old('email') }}" autofocus autocomplete="username">
                </div>
            </div>

            {{-- Password Field --}}
            <div class="flex flex-col gap-1.5">
                <label class="font-label-md text-label-md text-on-surface flex items-center justify-between" for="password">
                    <span>Kata Sandi</span>
                    <a class="text-secondary hover:underline cursor-pointer font-label-md text-[11px]" href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
                </label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-3 text-[18px] text-outline pointer-events-none">lock</span>
                    <input class="w-full bg-surface-container-low focus:bg-surface-container-lowest text-on-surface font-body-md text-body-md rounded-lg py-2.5 pl-10 pr-10 transition-all outline-none focus:ring-2 focus:ring-primary shadow-sm" id="password" name="password" placeholder="Masukkan kata sandi" required type="password" autocomplete="current-password">
                    <button aria-label="Tampilkan atau sembunyikan kata sandi" class="absolute right-3 text-outline hover:text-on-surface p-1 rounded transition-colors flex items-center justify-center" id="togglePassword" type="button">
                        <span class="material-symbols-outlined text-[18px]" id="eyeIcon">visibility</span>
                    </button>
                </div>
            </div>

            {{-- Role Selector Reference Pill Grid --}}
            <div class="bg-surface-container-low/70 p-space-sm rounded-lg flex flex-col gap-2">
                <div class="flex items-center gap-1.5 text-on-surface-variant font-label-md text-[11px]">
                    <span class="material-symbols-outlined text-[14px] text-secondary">badge</span>
                    <span>Otoritas Hak Akses Sistem (RBAC Terkunci):</span>
                </div>
                <div class="grid grid-cols-2 gap-1.5 text-[11px]">
                    <div class="flex items-center gap-1.5 px-2 py-1 rounded bg-surface-container-lowest text-on-surface shadow-xs font-label-md">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                        <span>Admin Inventori</span>
                    </div>
                    <div class="flex items-center gap-1.5 px-2 py-1 rounded bg-surface-container-lowest text-on-surface shadow-xs font-label-md">
                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                        <span>Petugas CSSD</span>
                    </div>
                    <div class="flex items-center gap-1.5 px-2 py-1 rounded bg-surface-container-lowest text-on-surface shadow-xs font-label-md">
                        <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                        <span>Unit Medis (IBS/IGD)</span>
                    </div>
                    <div class="flex items-center gap-1.5 px-2 py-1 rounded bg-surface-container-lowest text-on-surface shadow-xs font-label-md">
                        <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>
                        <span>Petugas Inventori</span>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <button class="w-full py-3 px-space-md bg-primary hover:bg-primary-container text-on-primary font-label-lg text-label-lg rounded-lg shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-[0.99]" type="submit">
                <span class="material-symbols-outlined text-[20px]">login</span>
                <span>Masuk ke SIM Inventori</span>
            </button>
        </form>

        {{-- System Protection Notice --}}
        <div class="pt-space-xs text-center space-y-1">
            <div class="inline-flex items-center gap-1.5 text-body-sm font-body-sm text-outline">
                <span class="material-symbols-outlined text-[16px]">lock_clock</span>
                <span>Sistem Terproteksi RBAC Rumah Sakit</span>
            </div>
            <p class="font-body-sm text-[11px] text-on-surface-variant">
                Pendaftaran akun baru hanya dilakukan oleh Administrator SIMRS &amp; Tim Kepegawaian Medis.
            </p>
        </div>
    </div>
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
@endsection
