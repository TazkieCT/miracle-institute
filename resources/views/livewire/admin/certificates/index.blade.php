<div class="space-y-6">
    <x-ui.page-header
        title="Certificates"
        subtitle="Kelola arsip sertifikat yang sudah dihasilkan."
    />

    <div class="rounded-2xl bg-white border p-4 grid grid-cols-1 md:grid-cols-4 gap-3">
        <input wire:model.live="search" class="border rounded-xl px-4 py-2" placeholder="Search number...">
        <select wire:model.live="type" class="border rounded-xl px-4 py-2">
            <option value="">All types</option>
            <option value="course">Course</option>
            <option value="topic">Topic</option>
        </select>
        <select wire:model.live="status" class="border rounded-xl px-4 py-2">
            <option value="">All status</option>
            <option value="draft">Draft</option>
            <option value="issued">Issued</option>
        </select>
        <select wire:model.live="perPage" class="border rounded-xl px-4 py-2">
            <option value="10">10 / page</option>
            <option value="25">25 / page</option>
        </select>
    </div>

    <div class="rounded-2xl bg-white border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="p-4">Number</th>
                    <th class="p-4">User</th>
                    <th class="p-4">Type</th>
                    <th class="p-4">Target</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $row)
                    <tr class="border-t">
                        <td class="p-4 font-medium">{{ $row->certificate_number }}</td>
                        <td class="p-4">{{ $row->user?->full_name }}</td>
                        <td class="p-4">{{ $row->type }}</td>
                        <td class="p-4">{{ $row->type === 'course' ? $row->course?->title : $row->topic?->name }}</td>
                        <td class="p-4">{{ $row->status }}</td>
                        <td class="p-4 flex gap-3">
                            @if($row->file_path)
                                <a href="{{ route('certificates.download', $row->id) }}" class="text-slate-900 underline">Download</a>
                            @endif
                            <button wire:click="delete('{{ $row->id }}')" class="text-rose-600">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-6 text-center text-slate-500">No certificates.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $rows->links() }}</div>
</div>