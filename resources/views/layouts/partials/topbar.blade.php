@php
    $user = auth()->user();
@endphp

<header class="h-16 bg-white border-b flex items-center justify-between px-4 sm:px-6 lg:px-8">
    <div class="flex items-center gap-3">
        <div class="font-semibold text-lg">
            {{ config('app.name', 'LMS') }}
        </div>

        @if(session('active_role'))
            <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-700">
                Active Role: {{ ucfirst(session('active_role')) }}
            </span>
        @endif
    </div>

    <div class="flex items-center gap-4">

        @auth
            @livewire('shared.role-switcher')

            <div class="hidden sm:block text-sm text-gray-600">
                {{ auth()->user()->full_name }}
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm px-3 py-2 rounded-md bg-black text-white">
                    Logout
                </button>
            </form>
        @endauth

        @guest
            <a href="{{ route('login') }}" 
            class="text-sm px-3 py-2 rounded-md bg-black text-white">
                Login
            </a>
        @endguest

    </div>
</header>