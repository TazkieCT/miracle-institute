@php
    $nav = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'ability' => 'view_reports'],
        ['label' => 'Study Programs', 'route' => 'admin.study-programs.index', 'ability' => 'manage_courses'],
        ['label' => 'Courses', 'route' => 'admin.courses.index', 'ability' => 'manage_courses'],
        ['label' => 'Topics', 'route' => 'admin.topics.index', 'ability' => 'manage_topics'],
        ['label' => 'Materials', 'route' => 'admin.materials.index', 'ability' => 'manage_topics'],
        ['label' => 'Users', 'route' => 'admin.users.index', 'ability' => 'manage_users'],
        ['label' => 'Roles', 'route' => 'admin.roles.index', 'ability' => 'manage_users'],
        ['label' => 'Permissions', 'route' => 'admin.permissions.index', 'ability' => 'manage_users'],
        ['label' => 'Assessments', 'route' => 'admin.assessments.index', 'ability' => 'manage_assessments'],
        ['label' => 'Certificates', 'route' => 'admin.certificates.index', 'ability' => 'manage_certificates'],
        ['label' => 'Articles', 'route' => 'admin.articles.index', 'ability' => 'view_reports'],
        ['label' => 'Audit Trail', 'route' => 'admin.audit.index', 'ability' => 'view_reports'],
        ['label' => 'Settings', 'route' => 'admin.settings.index', 'ability' => 'view_reports'],
    ];

    $visible = collect($nav)->filter(function ($item) {
        return auth()->check() && auth()->user()->can($item['ability']);
    });

    $itemClass = fn ($route) => request()->routeIs($route)
        ? 'block px-4 py-2 rounded-xl bg-slate-900 text-white text-sm'
        : 'block px-4 py-2 rounded-xl text-slate-700 hover:bg-slate-100 text-sm';
@endphp

<aside class="hidden lg:flex lg:flex-col lg:fixed lg:inset-y-0 lg:w-72 bg-white border-r border-slate-200">
    <div class="h-16 flex items-center px-6 border-b border-slate-200">
        <div>
            <div class="font-semibold">Admin Panel</div>
            <div class="text-xs text-slate-500">{{ auth()->user()->full_name ?? 'Administrator' }}</div>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto p-4 space-y-6">
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-3">Navigation</p>
            <div class="space-y-1">
                @foreach($visible as $item)
                    <a href="{{ route($item['route']) }}" 
                    wire:navigate 
                    class="{{ $itemClass($item['route']) }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </nav>
</aside>