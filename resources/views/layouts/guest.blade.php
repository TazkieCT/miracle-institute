<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'LMS') }}</title>

    @livewireStyles
    @stack('styles')

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-[#004777]">

    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">
            {{ $slot ?? '' }}
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>