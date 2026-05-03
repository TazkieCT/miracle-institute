<div class="space-y-6">
    <x-ui.page-header title="Roles" subtitle="Kelola role dan permission matrix." />

    <div class="grid grid-cols-1 xl:grid-cols-[1.2fr_0.8fr] gap-6">
        <section class="space-y-4">
            <div class="rounded-2xl bg-white border overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-left">
                        <tr>
                            <th class="p-4">Name</th>
                            <th class="p-4">Label</th>
                            <th class="p-4">Permissions</th>
                            <th class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                            <tr class="border-t">
                                <td class="p-4 font-medium">{{ $row->name }}</td>
                                <td class="p-4">{{ $row->label }}</td>
                                <td class="p-4">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($row->permissions as $perm)
                                            <span class="text-xs px-2 py-1 rounded-full bg-slate-100">{{ $perm->name }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="p-4 flex gap-3">
                                    <button wire:click="edit('{{ $row->id }}')" class="text-blue-600">Edit</button>
                                    <button wire:click="delete('{{ $row->id }}')" class="text-rose-600">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div>{{ $rows->links() }}</div>
        </section>

        <aside class="rounded-2xl bg-white border p-5 space-y-4 h-fit">
            <h2 class="font-semibold text-lg">{{ $editingId ? 'Edit' : 'New' }} Role</h2>

            <input wire:model="name" class="w-full border rounded-xl px-4 py-2" placeholder="name">
            <input wire:model="label" class="w-full border rounded-xl px-4 py-2" placeholder="label">
            <textarea wire:model="description" rows="3" class="w-full border rounded-xl px-4 py-2" placeholder="description"></textarea>

            <div class="space-y-2">
                <div class="font-medium">Permissions</div>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($permissions as $perm)
                        <label class="rounded-xl border p-3 flex items-center gap-2">
                            <input type="checkbox" wire:model="permissionIds" value="{{ $perm->id }}">
                            <span class="text-sm">{{ $perm->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <button wire:click="save" class="w-full px-4 py-2 rounded-xl bg-slate-900 text-white">
                Save
            </button>
        </aside>
    </div>
</div>