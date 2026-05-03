@php
    $role = session('active_role');
    $sections = config('navigation.sections', []);

    $isVisible = function (array $item) use ($role) {
        if (! $role) {
            return false;
        }

        if (! in_array($role, $item['roles'] ?? [], true)) {
            return false;
        }

        if (! empty($item['ability']) && auth()->check() && ! auth()->user()->can($item['ability'])) {
            return false;
        }

        return true;
    };

    $navClass = function ($routeName) {
        return request()->routeIs($routeName)
            ? 'block px-4 py-2 rounded-xl bg-slate-900 text-white text-sm'
            : 'block px-4 py-2 rounded-xl text-slate-700 hover:bg-slate-100 text-sm';
    };
@endphp

<aside class="hidden lg:flex lg:flex-col lg:fixed lg:inset-y-0 lg:w-72 bg-white border-r border-slate-200">
    <div class="h-16 flex items-center px-6 border-b border-slate-200">
        <div>
            <div class="font-semibold">LMS Panel</div>
            <div class="text-xs text-slate-500">Role: {{ ucfirst($role ?? 'guest') }}</div>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto p-4 space-y-6">
        @foreach($sections as $sectionName => $items)
            @php
                $visibleItems = collect($items)->filter($isVisible);
            @endphp

            @if($visibleItems->isNotEmpty())
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-3">
                        {{ ucfirst($sectionName) }}
                    </p>

                    <div class="space-y-1">
                        @foreach($visibleItems as $item)
                            <a href="{{ route($item['route']) }}" class="{{ $navClass($item['route']) }}">
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </nav>
</aside>