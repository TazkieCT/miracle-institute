@php
    $active = 'text-slate-900';
    $inactive = 'text-slate-500';

    $isActive = function (array $routes) {
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return true;
            }
        }

        return false;
    };
@endphp

<nav class="lg:hidden fixed bottom-0 inset-x-0 z-30 bg-white border-t border-slate-200">
    <div class="grid grid-cols-4">
        <a href="{{ route('dashboard') }}" class="py-2 text-center text-xs {{ $isActive(['dashboard']) ? $active : $inactive }}">
            Dashboard
        </a>
        <a href="{{ route('courses.index') }}" class="py-2 text-center text-xs {{ $isActive(['courses.index','courses.show','topics.show']) ? $active : $inactive }}">
            Courses
        </a>
        <a href="{{ route('certificates.index') }}" class="py-2 text-center text-xs {{ $isActive(['certificates.index']) ? $active : $inactive }}">
            Certs
        </a>
        <a href="{{ route('articles.index') }}" class="py-2 text-center text-xs {{ $isActive(['articles.index','articles.show']) ? $active : $inactive }}">
            Articles
        </a>
    </div>
</nav>