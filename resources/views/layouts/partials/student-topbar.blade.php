@php
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

    $navClass = function ($routeName) {
        return request()->routeIs($routeName)
            ? 'text-slate-900 font-semibold'
            : 'text-slate-600 hover:text-slate-900';
    };
@endphp

<header class="sticky top-0 z-30 bg-white/95 backdrop-blur border-b border-slate-200">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="h-16 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <a href="{{ route('explore.dashboard') }}" class="font-semibold text-lg shrink-0">
                    LMS
                </a>

                <div class="hidden md:flex items-center gap-5 text-sm">
                    @foreach($generalRoutes as $item)
                        <a href="{{ route($item['route']) }}" class="{{ $navClass($item['route']) }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach

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
                </div>
            </div>

            <div class="flex items-center gap-3">
                @livewire('shared.role-switcher')

                <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                    @csrf
                    <button class="px-3 py-2 rounded-xl bg-slate-900 text-white text-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>