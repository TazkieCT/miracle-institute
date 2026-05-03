<div class="space-y-6">
    <x-ui.page-header
        title="Settings"
        subtitle="Branding, visi-misi, dan tautan sosial."
    />

    <div class="max-w-4xl rounded-2xl bg-white border p-6 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <input wire:model="name" class="border rounded-xl px-4 py-2" placeholder="Company name">
            <input wire:model="logo" class="border rounded-xl px-4 py-2" placeholder="Logo path/url">
        </div>

        <textarea wire:model="description" rows="3" class="w-full border rounded-xl px-4 py-2" placeholder="Description"></textarea>
        <textarea wire:model="address" rows="2" class="w-full border rounded-xl px-4 py-2" placeholder="Address"></textarea>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <textarea wire:model="vision" rows="3" class="w-full border rounded-xl px-4 py-2" placeholder="Vision"></textarea>
            <textarea wire:model="mission" rows="3" class="w-full border rounded-xl px-4 py-2" placeholder="Mission"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <input wire:model="facebook" class="border rounded-xl px-4 py-2" placeholder="Facebook URL">
            <input wire:model="instagram" class="border rounded-xl px-4 py-2" placeholder="Instagram URL">
            <input wire:model="youtube" class="border rounded-xl px-4 py-2" placeholder="YouTube URL">
            <input wire:model="whatsapp" class="border rounded-xl px-4 py-2" placeholder="WhatsApp URL">
        </div>

        <button wire:click="save" class="px-5 py-3 rounded-xl bg-slate-900 text-white">
            Save Settings
        </button>
    </div>
</div>