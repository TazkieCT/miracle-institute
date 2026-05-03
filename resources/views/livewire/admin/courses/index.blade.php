<div class="space-y-6">
    <x-ui.page-header title="Courses" subtitle="Kelola course, poster, credit, dan quota." />

    <div class="grid grid-cols-1 xl:grid-cols-[1.2fr_0.8fr] gap-6">
        <section class="space-y-4">
            <div class="rounded-2xl bg-white border p-4">
                <input wire:model.live="search" class="w-full border rounded-xl px-4 py-2" placeholder="Search course...">
            </div>

            <div class="rounded-2xl bg-white border overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-left">
                        <tr>
                            <th class="p-4">Title</th>
                            <th class="p-4">Program</th>
                            <th class="p-4">Credit</th>
                            <th class="p-4">Quota</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $row)
                            <tr class="border-t">
                                <td class="p-4">
                                    <div class="font-medium">{{ $row->title }}</div>
                                    <div class="text-xs text-slate-500">{{ $row->slug }}</div>
                                </td>
                                <td class="p-4">{{ $row->studyProgram?->title }}</td>
                                <td class="p-4">{{ $row->credit }}</td>
                                <td class="p-4">{{ $row->quota }}</td>
                                <td class="p-4">{{ $row->status }}</td>
                                <td class="p-4 flex gap-3">
                                    <button wire:click="edit('{{ $row->id }}')" class="text-blue-600">Edit</button>
                                    <button wire:click="delete('{{ $row->id }}')" class="text-rose-600">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="p-6 text-center text-slate-500">No data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>{{ $rows->links() }}</div>
        </section>

        <aside class="rounded-2xl bg-white border p-5 space-y-4 h-fit">
            <h2 class="font-semibold text-lg">{{ $editingId ? 'Edit' : 'New' }} Course</h2>

            <select wire:model="study_program_id" class="w-full border rounded-xl px-4 py-2">
                <option value="">Select program</option>
                @foreach($studyPrograms as $sp)
                    <option value="{{ $sp->id }}">{{ $sp->title }}</option>
                @endforeach
            </select>

            <input wire:model="title" class="w-full border rounded-xl px-4 py-2" placeholder="Title">
            <input wire:model="poster" class="w-full border rounded-xl px-4 py-2" placeholder="Poster path/url">
            <div class="grid grid-cols-2 gap-3">
                <input wire:model="credit" type="number" class="w-full border rounded-xl px-4 py-2" placeholder="Credit">
                <input wire:model="quota" type="number" class="w-full border rounded-xl px-4 py-2" placeholder="Quota">
            </div>
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