@php
    $role = auth()->check() ? session('active_role') : null;

    $generalRoutes = [
        ['label' => 'Dashboard', 'route' => 'explore.dashboard'],
        ['label' => 'Courses', 'route' => 'courses.index'],
        ['label' => 'Certificates', 'route' => 'certificates.index'],
        ['label' => 'Articles', 'route' => 'articles.index'],
    ];

    $learningRoutes = [
        ['label' => 'My Learning', 'route' => 'learning.dashboard'],
        ['label' => 'Assessment', 'route' => 'assessments.index'],
    ];

    $mentorRoutes = [
        ['label' => 'Mentor Dashboard', 'route' => 'mentor.dashboard'],
        ['label' => 'Mentored Topics', 'route' => 'mentor.topics.index'],
    ];

    $navClass = function ($routeName) {
        return request()->routeIs($routeName)
            ? 'text-slate-900 font-semibold'
            : 'text-slate-600 hover:text-slate-900';
    };
@endphp

<header class="sticky top-0 z-30 bg-white/95 backdrop-blur border-b border-slate-200">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="h-16 flex items-center justify-between gap-4">

            <!-- LEFT -->
            <div class="flex items-center gap-3 min-w-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'LMS') }} logo" class="h-32 w-32 object-contain">
                    <span class="sr-only">{{ config('app.name', 'LMS') }}</span>
                </a>

                <!-- DESKTOP NAV -->
                <div class="hidden md:flex items-center gap-5 text-sm">

                    @foreach($generalRoutes as $item)
                        <a href="{{ route($item['route']) }}" class="{{ $navClass($item['route']) }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach

                    {{-- LEARNING (student only) --}}
                    @auth
                        @if($role === 'student')
                            <details class="relative">
                                <summary class="cursor-pointer list-none {{ request()->routeIs('learning.dashboard','assessments.index','assessments.take') ? 'text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900' }}">
                                    Learning
                                </summary>

                                <div class="absolute left-0 mt-3 w-56 rounded-2xl border bg-white shadow-lg p-2">
                                    @foreach($learningRoutes as $item)
                                        <a href="{{ route($item['route']) }}"
                                           class="block px-4 py-2 rounded-xl text-sm hover:bg-slate-100 {{ $navClass($item['route']) }}">
                                            {{ $item['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </details>
                        @endif

                        {{-- MENTOR (disciples only) --}}
                        @if($role === 'disciples')
                            <details class="relative">
                                <summary class="cursor-pointer list-none {{ request()->routeIs('mentor.dashboard','mentor.topics.index','mentor.topics.show') ? 'text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900' }}">
                                    Mentor
                                </summary>

                                <div class="absolute left-0 mt-3 w-64 rounded-2xl border bg-white shadow-lg p-2">
                                    @foreach($mentorRoutes as $item)
                                        <a href="{{ route($item['route']) }}"
                                           class="block px-4 py-2 rounded-xl text-sm hover:bg-slate-100 {{ $navClass($item['route']) }}">
                                            {{ $item['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </details>
                        @endif
                    @endauth

                </div>
            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-3">

                @auth
                    @livewire('shared.role-switcher')

                    <details id="profileDropdown" class="relative" data-dropdown>
                        <summary class="hidden sm:flex items-center gap-2 cursor-pointer px-2 py-1 rounded-xl border bg-white text-sm" aria-haspopup="true" aria-expanded="false">
                            <svg class="h-6 w-6 text-slate-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11a4 4 0 10-8 0 4 4 0 008 0zm-8 4v1a3 3 0 003 3h4a3 3 0 003-3v-1" />
                            </svg>
                            <svg class="h-3 w-3 text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </summary>

                        <div class="absolute right-0 mt-2 w-44 rounded-2xl border bg-white shadow-lg p-2">
                            <a href="{{ url('/profile') }}" class="flex items-center px-4 py-2 rounded-xl text-sm hover:bg-slate-100">
                                <svg class="h-4 w-4 text-slate-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9A3.75 3.75 0 1012 5.25 3.75 3.75 0 0015.75 9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5a8.25 8.25 0 0115 0" />
                                </svg>
                                Profile
                            </a>

                            <a href="{{ route('learning.dashboard') }}" class="flex items-center px-4 py-2 rounded-xl text-sm hover:bg-slate-100">
                                <svg class="h-4 w-4 text-slate-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14.25v4.5" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.75l8.25 4.5 8.25-4.5-8.25-4.5-8.25 4.5z" />
                                </svg>
                                My Learning
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                @csrf
                                <button type="submit" class="flex items-center w-full text-left px-4 py-2 rounded-xl text-sm hover:bg-slate-100">
                                    <svg class="h-4 w-4 text-slate-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6.75A2.25 2.25 0 004.5 5.25v13.5A2.25 2.25 0 006.75 21H13.5a2.25 2.25 0 002.25-2.25V15" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12H3" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 8.25l-3 3 3 3" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </details>
                @endauth

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            var dropdown = document.getElementById('profileDropdown');
                            if (!dropdown) return;

                            function closeIfOutside(e) {
                                if (!dropdown.contains(e.target)) {
                                    dropdown.removeAttribute('open');
                                    removeListeners();
                                }
                            }

                            function onKey(e) {
                                if (e.key === 'Escape') {
                                    dropdown.removeAttribute('open');
                                    removeListeners();
                                }
                            }

                            function removeListeners() {
                                document.removeEventListener('click', closeIfOutside);
                                document.removeEventListener('keydown', onKey);
                            }

                            dropdown.addEventListener('toggle', function () {
                                if (dropdown.hasAttribute('open')) {
                                    setTimeout(function () { document.addEventListener('click', closeIfOutside); }, 0);
                                    document.addEventListener('keydown', onKey);
                                } else {
                                    removeListeners();
                                }
                            });
                        });
                    </script>

                @guest
                    <a href="{{ route('login') }}"
                       class="hidden sm:block px-3 py-2 rounded-xl border text-sm hover:bg-slate-50">
                        Login
                    </a>
                @endguest

                <!-- MOBILE MENU -->
                <details class="md:hidden relative">
                    <summary class="cursor-pointer list-none px-3 py-2 rounded-xl border bg-white text-sm">
                        Menu
                    </summary>

                    <div class="absolute right-0 mt-3 w-72 rounded-2xl border bg-white shadow-lg p-2">

                        <!-- GENERAL -->
                        <div class="px-3 py-2 text-xs uppercase tracking-wide text-slate-400">General</div>
                        @foreach($generalRoutes as $item)
                            <a href="{{ route($item['route']) }}"
                               class="block px-4 py-2 rounded-xl text-sm hover:bg-slate-100">
                                {{ $item['label'] }}
                            </a>
                        @endforeach

                        @auth
                            {{-- LEARNING --}}
                            @if($role === 'student')
                                <div class="mt-2 px-3 py-2 text-xs uppercase tracking-wide text-slate-400">Learning</div>
                                @foreach($learningRoutes as $item)
                                    <a href="{{ route($item['route']) }}"
                                       class="block px-4 py-2 rounded-xl text-sm hover:bg-slate-100">
                                        {{ $item['label'] }}
                                    </a>
                                @endforeach
                            @endif

                            {{-- MENTOR --}}
                            @if($role === 'disciples')
                                <div class="mt-2 px-3 py-2 text-xs uppercase tracking-wide text-slate-400">Mentor</div>
                                @foreach($mentorRoutes as $item)
                                    <a href="{{ route($item['route']) }}"
                                       class="block px-4 py-2 rounded-xl text-sm hover:bg-slate-100">
                                        {{ $item['label'] }}
                                    </a>
                                @endforeach
                            @endif
                        @endauth

                        <!-- AUTH ACTION -->
                        @auth
                            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                @csrf
                                <button class="w-full text-left px-4 py-2 rounded-xl text-sm hover:bg-slate-100">
                                    Logout
                                </button>
                            </form>
                        @endauth

                        @guest
                            <a href="{{ route('login') }}"
                               class="block px-4 py-2 rounded-xl text-sm hover:bg-slate-100 mt-2">
                                Login
                            </a>
                        @endguest

                    </div>
                </details>

            </div>
        </div>
    </div>
</header>