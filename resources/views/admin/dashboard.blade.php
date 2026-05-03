@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <p class="text-gray-500">Ringkasan sistem LMS.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="rounded-2xl bg-white border p-5">
                <p class="text-sm text-gray-500">Users</p>
                <p class="text-3xl font-bold">—</p>
            </div>
            <div class="rounded-2xl bg-white border p-5">
                <p class="text-sm text-gray-500">Courses</p>
                <p class="text-3xl font-bold">—</p>
            </div>
            <div class="rounded-2xl bg-white border p-5">
                <p class="text-sm text-gray-500">Attendance</p>
                <p class="text-3xl font-bold">—</p>
            </div>
            <div class="rounded-2xl bg-white border p-5">
                <p class="text-sm text-gray-500">Certificates</p>
                <p class="text-3xl font-bold">—</p>
            </div>
        </div>

        <div class="rounded-2xl bg-white border p-5">
            <h2 class="font-semibold mb-3">Overview</h2>
            <p class="text-sm text-gray-500">
                Dashboard ini nanti bisa diganti dengan Livewire admin metrics.
            </p>
        </div>
    </div>
@endsection