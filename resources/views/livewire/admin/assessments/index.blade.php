<div class="space-y-6">
    <x-ui.page-header title="Assessments" subtitle="Kelola post test, passing grade, dan timer." />

    <div class="grid grid-cols-1 xl:grid-cols-[1.2fr_0.8fr] gap-6">
        <section class="space-y-4">
            <div class="rounded-2xl bg-white border p-4">
                <input wire:model.live="search" class="w-full border rounded-xl px-4 py-2" placeholder="Search assessment...">
            </div>

            <div class="rounded-2xl bg-white border overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-left">
                        <tr>
                            <th class="p-4">Title</th>
                            <th class="p-4">Topic</th>
                            <th class="p-4">Grade</th>
                            <th class="p-4">Timer</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $row)
                            <tr class="border-t">
                                <td class="p-4">{{ $row->title }}</td>
                                <td class="p-4">{{ $row->topic?->name }}</td>
                                <td class="p-4">{{ $row->passing_grade }}</td>
                                <td class="p-4">{{ $row->time_limit_minutes ?? '-' }}</td>
                                <td class="p-4">{{ $row->status }}</td>
                                <td class="p-4 flex gap-3">
                                    <button wire:click="edit('{{ $row->id }}')" class="text-blue-600">Edit</button>
                                    <a href="{{ route('admin.assessments.questions', $row->id) }}" class="text-slate-900 underline">Questions</a>
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
            <h2 class="font-semibold text-lg">{{ $editingId ? 'Edit' : 'New' }} Assessment</h2>

            <select wire:model="topic_id" class="w-full border rounded-xl px-4 py-2">
                <option value="">Select topic</option>
                @foreach($topics as $topic)
                    <option value="{{ $topic->id }}">{{ $topic->course?->title }} · {{ $topic->name }}</option>
                @endforeach
            </select>

            <input wire:model="title" class="w-full border rounded-xl px-4 py-2" placeholder="Title">
            <div class="grid grid-cols-2 gap-3">
                <input wire:model="passing_grade" type="number" class="w-full border rounded-xl px-4 py-2" placeholder="Passing grade">
                <input wire:model="question_limit" type="number" class="w-full border rounded-xl px-4 py-2" placeholder="Question limit">
            </div>
            <input wire:model="time_limit_minutes" type="number" class="w-full border rounded-xl px-4 py-2" placeholder="Time limit (minutes)">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" wire:model="randomize_questions">
                Randomize questions
            </label>
            <select wire:model="status" class="w-full border rounded-xl px-4 py-2">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="draft">Draft</option>
            </select>

            <button wire:click="save" class="w-full px-4 py-2 rounded-xl bg-slate-900 text-white">
                Save
            </button>
        </aside>
    </div>
</div>