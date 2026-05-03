<div class="space-y-6">
    <x-ui.page-header title="Articles" subtitle="Kelola artikel dan publikasi konten." />

    <div class="grid grid-cols-1 xl:grid-cols-[1.2fr_0.8fr] gap-6">
        <section class="space-y-4">
            <div class="rounded-2xl bg-white border p-4">
                <input wire:model.live="search" class="w-full border rounded-xl px-4 py-2" placeholder="Search article...">
            </div>

            <div class="rounded-2xl bg-white border overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-left">
                        <tr>
                            <th class="p-4">Title</th>
                            <th class="p-4">Author</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                            <tr class="border-t">
                                <td class="p-4 font-medium">{{ $row->title }}</td>
                                <td class="p-4">{{ $row->author }}</td>
                                <td class="p-4">{{ $row->status }}</td>
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
            <h2 class="font-semibold text-lg">{{ $editingId ? 'Edit' : 'New' }} Article</h2>
            <input wire:model="title" class="w-full border rounded-xl px-4 py-2" placeholder="Title">
            <input wire:model="author" class="w-full border rounded-xl px-4 py-2" placeholder="Author">
            <textarea wire:model="content" rows="8" class="w-full border rounded-xl px-4 py-2" placeholder="Content HTML/Text"></textarea>
            <select wire:model="status" class="w-full border rounded-xl px-4 py-2">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="draft">Draft</option>
            </select>
            <button wire:click="save" class="w-full px-4 py-2 rounded-xl bg-slate-900 text-white">Save</button>
        </aside>
    </div>
</div>