<div class="space-y-6">
    <x-ui.page-header title="Audit Trail" subtitle="Jejak aktivitas admin dan sistem." />

    <div class="rounded-2xl bg-white border p-4 grid grid-cols-1 md:grid-cols-3 gap-3">
        <input wire:model.live="search" class="border rounded-xl px-4 py-2" placeholder="Search action...">
        <select wire:model.live="userId" class="border rounded-xl px-4 py-2">
            <option value="">All users</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
            @endforeach
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
                    <th class="p-4">Date</th>
                    <th class="p-4">User</th>
                    <th class="p-4">Action</th>
                    <th class="p-4">Payload</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $row)
                    <tr class="border-t align-top">
                        <td class="p-4">{{ $row->created_at->format('d M Y H:i') }}</td>
                        <td class="p-4">{{ $row->user?->full_name ?? '-' }}</td>
                        <td class="p-4 font-medium">{{ $row->action }}</td>
                        <td class="p-4">
                            <pre class="text-xs whitespace-pre-wrap break-words">{{ is_string($row->payload) ? $row->payload : json_encode($row->payload, JSON_PRETTY_PRINT) }}</pre>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>{{ $rows->links() }}</div>
</div>