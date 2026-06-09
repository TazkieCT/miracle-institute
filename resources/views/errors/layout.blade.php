<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Terjadi Kesalahan') - {{ config('app.name', 'Miracle Institute') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen overflow-x-hidden bg-[radial-gradient(circle_at_top,_#eef8ff_0%,_#f8fbff_48%,_#ffffff_100%)] text-slate-800">
    <div class="relative isolate min-h-screen">
        <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-72 bg-[linear-gradient(135deg,_rgba(53,167,255,0.18),_rgba(0,71,119,0.04)_55%,_transparent)]"></div>
        <div class="pointer-events-none absolute -left-24 top-20 -z-10 h-56 w-56 rounded-full bg-[#35A7FF]/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-24 bottom-10 -z-10 h-64 w-64 rounded-full bg-[#004777]/10 blur-3xl"></div>

        <main class="mx-auto flex min-h-screen w-full max-w-6xl items-center px-6 py-12 sm:px-10 lg:px-12">
            <section class="relative w-full overflow-hidden rounded-[2rem] border border-white/70 bg-white/90 p-8 shadow-[0_25px_80px_rgba(15,23,42,0.12)] backdrop-blur sm:p-10 lg:p-12">
                <div class="grid items-center gap-8 lg:grid-cols-[1.05fr_0.95fr]">
                    <section class="order-2 lg:order-1">
                    <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-[#35A7FF] via-[#004777] to-[#F59E0B]"></div>

                    <div class="inline-flex items-center rounded-full border border-[#35A7FF]/20 bg-[#eef8ff] px-4 py-1.5 text-xs font-bold uppercase tracking-[0.25em] text-[#004777]">
                        Error @yield('code')
                    </div>

                    <h1 class="mt-6 max-w-xl font-serif text-4xl leading-tight text-[#004777] sm:text-5xl">
                        @yield('headline')
                    </h1>

                    <p class="mt-5 max-w-2xl text-base leading-7 text-slate-600 sm:text-lg">
                        @yield('message')
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        <a href="{{ url('/') }}"
                           class="inline-flex items-center justify-center rounded-2xl bg-[#004777] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#004777]/20 transition hover:-translate-y-0.5 hover:bg-[#02395f]">
                            Kembali ke Beranda
                        </a>

                        <button type="button"
                                onclick="window.history.back()"
                                class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:border-slate-300 hover:bg-slate-50">
                            Kembali ke Halaman Sebelumnya
                        </button>
                    </div>
                    </section>

                    <section class="relative order-1 flex items-center justify-center lg:order-2">
                        <div class="absolute inset-0 -z-10 rounded-full bg-[radial-gradient(circle,_rgba(53,167,255,0.22)_0%,_rgba(53,167,255,0.04)_45%,_transparent_72%)] blur-xl"></div>
                        <img
                            src="{{ asset('images/decor/error.png') }}"
                            alt="Ilustrasi halaman error"
                            class="w-full max-w-[7.5rem] drop-shadow-[0_30px_50px_rgba(0,71,119,0.22)] sm:max-w-xs lg:max-w-md"
                        >
                    </section>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
