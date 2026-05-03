@php
    $activeRole = session('active_role');
    $isStudent = in_array($activeRole, ['student', 'disciples'], true);

    $isActive = function (array|string $routes) {
        foreach ((array) $routes as $route) {
            if (request()->routeIs($route)) {
                return true;
            }
        }

        return false;
    };

    $base = 'block px-4 py-2 rounded-xl text-sm transition';
    $on = 'bg-slate-900 text-white';
    $off = 'text-slate-700 hover:bg-slate-100';
@endphp

<aside class="hidden lg:flex lg:flex-col lg:fixed lg:inset-y-0 lg:w-72 bg-white border-r border-slate-200">
    <div class="h-16 flex items-center px-6 border-b border-slate-200">
        <div>
            <div class="font-semibold">LMS Student</div>
            <div class="text-xs text-slate-500">Learning portal</div>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto p-4 space-y-6">
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-3">General</p>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" class="{{ $base }} {{ $isActive('dashboard') ? $on : $off }}">Dashboard</a>
                <a href="{{ route('courses.index') }}" class="{{ $base }} {{ $isActive(['courses.index','courses.show','topics.show']) ? $on : $off }}">Courses</a>
                <a href="{{ route('certificates.index') }}" class="{{ $base }} {{ $isActive(['certificates.index']) ? $on : $off }}">Certificates</a>
                <a href="{{ route('articles.index') }}" class="{{ $base }} {{ $isActive(['articles.index','articles.show']) ? $on : $off }}">Articles</a>
            </div>
        </div>

        @if($isStudent)
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-3">Learning</p>
                <div class="space-y-1">
                    <a href="{{ route('learning.dashboard') }}" class="{{ $base }} {{ $isActive('learning.dashboard') ? $on : $off }}">My Learning</a>
                    <a href="{{ route('courses.index') }}" class="{{ $base }} {{ $isActive(['courses.index','courses.show']) ? $on : $off }}">Course Catalog</a>
                    <a href="{{ route('assessments.index') }}" class="{{ $base }} {{ $isActive(['assessments.index','assessments.take']) ? $on : $off }}">Assessment</a>
                </div>
            </div>
        @endif
    </nav>
</aside>