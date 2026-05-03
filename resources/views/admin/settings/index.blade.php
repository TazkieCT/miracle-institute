@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold">Settings</h1>
            <p class="text-gray-500">Pengaturan branding, kontak, dan identitas platform.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="rounded-2xl bg-white border p-5 space-y-4">
                <h2 class="font-semibold">Branding</h2>
                <div class="space-y-3">
                    <input type="text" placeholder="Name" class="w-full border rounded-lg px-4 py-2">
                    <input type="text" placeholder="Logo URL" class="w-full border rounded-lg px-4 py-2">
                    <textarea placeholder="Description" class="w-full border rounded-lg px-4 py-2" rows="4"></textarea>
                </div>
            </div>

            <div class="rounded-2xl bg-white border p-5 space-y-4">
                <h2 class="font-semibold">Social Links</h2>
                <div class="space-y-3">
                    <input type="text" placeholder="Facebook" class="w-full border rounded-lg px-4 py-2">
                    <input type="text" placeholder="Instagram" class="w-full border rounded-lg px-4 py-2">
                    <input type="text" placeholder="YouTube" class="w-full border rounded-lg px-4 py-2">
                    <input type="text" placeholder="WhatsApp" class="w-full border rounded-lg px-4 py-2">
                </div>
            </div>
        </div>
    </div>
@endsection