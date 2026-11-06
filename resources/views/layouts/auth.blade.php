<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SIM Inventori RS')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=JetBrains+Mono:wght@100..900&family=Manrope:wght@100..900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface font-body-md text-body-md text-on-surface">
    <main class="min-h-screen w-full flex items-center justify-center bg-surface p-space-md">
        <div class="flex flex-col w-full items-center justify-center p-space-sm sm:p-space-lg">
            <div class="relative w-full max-w-5xl rounded-xl bg-surface-container-lowest shadow-xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-12 min-h-[660px]">

                    {{-- Left Panel: Hospital Branding & Assurance --}}
                    <div class="lg:col-span-5 bg-gradient-to-br from-primary via-primary-container to-on-primary-fixed-variant text-on-primary p-space-lg sm:p-space-xl flex flex-col justify-between relative overflow-hidden">
                        <svg class="absolute -right-16 -bottom-16 w-80 h-80 opacity-10 pointer-events-none text-on-primary" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 10.5h-5.5V5c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v5.5H5c-.83 0-1.5.67-1.5 1.5s.67 1.5 1.5 1.5h5.5V19c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5v-5.5H19c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5z"></path>
                        </svg>

                        <div class="relative z-10 flex flex-col gap-space-lg">
                            <div class="flex items-center gap-space-sm">
                                <div class="h-12 w-auto flex items-center justify-center">
                                    <img alt="RS Cipto Mangunkusumo" class="h-12 w-auto object-contain bg-white/90 p-2 rounded-lg shadow-sm" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCkw6Z2F-BgP7kOxbqaEBa4TTqGUO9G3k5PqlxZMo3MJwFjNyb8bANAClOVzm5PvaksGNOA-nREj5bDDKFA1DzYtZwR6zmC566sEB4Q5aoFEGbq4wzNtEjjbOsS0G5xHn2q4x0vh8Ddl_1IDEPKaXPn54VYuXiKLEQXG7h9Zhy_eUnH_r5uGlFmF9dQ7fIlv49Bn7lVaYRx4tK__hzHP42RN3B2XawzPpUucv36QI8cqEV1eP90QqG0dA">
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-primary tracking-tight">RS Cipto Mangunkusumo</span>
                                    <span class="font-label-md text-label-md text-primary-fixed uppercase tracking-wider">Unit CSSD &amp; Logistik Medis</span>
                                </div>
                            </div>

                            <div class="space-y-space-xs mt-space-md">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-surface-container-lowest/15 backdrop-blur text-primary-fixed text-label-md font-label-md w-fit">
                                    <span class="w-2 h-2 rounded-full bg-primary-fixed animate-ping"></span>
                                    Sistem Aktif • Versi 2.4.0
                                </div>
                                <h1 class="font-headline-lg text-headline-lg text-on-primary leading-tight">
                                    Sistem Inventori &amp; CSSD Terintegrasi
                                </h1>
                                <p class="font-body-md text-body-md text-on-primary/80 leading-relaxed">
                                    Platform operasional sterilisasi alat bedah, pelacakan barcode baki instrumen, dan manajemen stok medis terpusat.
                                </p>
                            </div>

                            <div class="flex flex-col gap-space-md mt-space-sm">
                                <div class="flex items-start gap-3">
                                    <div class="p-2 rounded-lg bg-surface-container-lowest/10 text-primary-fixed shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">qr_code_scanner</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-label-lg text-label-lg text-on-primary">Pelacakan Status Real-time</span>
                                        <span class="font-body-sm text-body-sm text-on-primary/70">Pemindaian cepat siklus alat dari ruang operasi hingga ruang simpan.</span>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="p-2 rounded-lg bg-surface-container-lowest/10 text-primary-fixed shrink-0">
                                        <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">sanitizer</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-label-lg text-label-lg text-on-primary">Siklus Sterilisasi CSSD Terverifikasi</span>
                                        <span class="font-body-sm text-body-sm text-on-primary/70">Monitoring tahapan Autoclave, validasi indikator biologi dan QC rilis.</span>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="p-2 rounded-lg bg-surface-container-lowest/10 text-primary-fixed shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">verified_user</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-label-lg text-label-lg text-on-primary">Audit Pergerakan Alat Akurat</span>
                                        <span class="font-body-sm text-body-sm text-on-primary/70">Pencatatan mutasi instrumen terproteksi dengan audit trail PostgreSQL.</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative z-10 pt-space-lg mt-space-lg flex items-center justify-between text-body-sm font-body-sm text-on-primary/60">
                            <span class="font-label-code text-label-code">HIPAA &amp; KARS Compliant</span>
                            <span>© 2025 SIMRS IT</span>
                        </div>
                    </div>

                    {{-- Right Panel --}}
                    <div class="lg:col-span-7 bg-surface-container-lowest p-space-lg sm:p-space-xl flex flex-col justify-between">
                        <div class="w-full max-w-md mx-auto">
                            @yield('content')
                        </div>

                        <div class="mt-space-lg pt-space-sm text-center">
                            <span class="font-label-code text-label-code text-outline text-[11px]">
                                Server ID: MEDIKA-CSSD-01 • Enkripsi TLS 1.3 Aktif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @stack('scripts')
</body>
</html>
