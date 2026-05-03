<div class="space-y-6">
    <x-ui.page-header title="Study Programs" subtitle="Kelola jalur pembelajaran utama." />

    <div class="grid grid-cols-1 xl:grid-cols-[1.2fr_0.8fr] gap-6">
        <section class="space-y-4">
            <div class="rounded-2xl bg-white border p-4">
                <input wire:model.live="search" class="w-full border rounded-xl px-4 py-2" placeholder="Search program...">
            </div>

            <div class="rounded-2xl bg-white border overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-left">
                        <tr>
                            <th class="p-4">Title</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $row)
                            <tr class="border-t">
                                <td class="p-4">
                                    <div class="font-medium">{{ $row->title }}</div>
                                    <div class="text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($row->description, 80) }}</div>
                                </td>
                                <td class="p-4">{{ $row->status }}</td>
                                <td class="p-4 flex gap-3">
                                    <button wire:click="edit('{{ $row->id }}')" class="text-blue-600">Edit</button>
                                    <button wire:click="delete('{{ $row->id }}')" class="text-rose-600">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="p-6 text-center text-slate-500">No data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>{{ $rows->links() }}</div>
        </section>

        <aside class="rounded-2xl bg-white border p-5 space-y-4 h-fit">
            <h2 class="font-semibold text-lg">{{ $editingId ? 'Edit' : 'New' }} Program</h2>

            <input wire:model="title" class="w-full border rounded-xl px-4 py-2" placeholder="Title">
            <textarea wire:model="description" rows="4" class="w-full border rounded-xl px-4 py-2" placeholder="Description"></textarea>
            <select wire:model="status" class="w-full border rounded-xl px-4 py-2">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>

            <button wire:click="save" class="w-full px-4 py-2 rounded-xl bg-slate-900 text-white">
                Save
            </button>
        </aside>
    </div>
</div>