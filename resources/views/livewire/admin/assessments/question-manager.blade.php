<div class="space-y-6">
    <x-ui.page-header
        title="Question Manager"
        subtitle="{{ $assessment->title }} · {{ $assessment->topic?->course?->title }} / {{ $assessment->topic?->name }}"
    >
        <button wire:click="create" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm">
            + New Question
        </button>
    </x-ui.page-header>

    <div class="grid grid-cols-1 xl:grid-cols-[1fr_0.9fr] gap-6">
        <section class="space-y-4">
            <div class="rounded-2xl bg-white border overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-left">
                        <tr>
                            <th class="p-4">Question</th>
                            <th class="p-4">Type</th>
                            <th class="p-4">Sort</th>
                            <th class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $question)
                            <tr class="border-t">
                                <td class="p-4">
                                    <div class="font-medium">{{ $question->question }}</div>
                                    <div class="text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($question->explanation, 80) }}</div>
                                </td>
                                <td class="p-4">{{ $question->question_type }}</td>
                                <td class="p-4">{{ $question->sort_order }}</td>
                                <td class="p-4 flex gap-3">
                                    <button wire:click="edit('{{ $question->id }}')" class="text-blue-600">Edit</button>
                                    <button wire:click="delete('{{ $question->id }}')" class="text-rose-600">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-6 text-center text-slate-500">No questions yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="rounded-2xl bg-white border p-5 space-y-4 h-fit">
            <h2 class="font-semibold text-lg">{{ $editingId ? 'Edit' : 'New' }} Question</h2>

            <select wire:model="question_type" class="w-full border rounded-xl px-4 py-2">
                <option value="mcq">MCQ</option>
                <option value="text">Text</option>
            </select>

            <textarea wire:model="question" rows="4" class="w-full border rounded-xl px-4 py-2" placeholder="Question"></textarea>
            <textarea wire:model="correct_text_answer" rows="2" class="w-full border rounded-xl px-4 py-2" placeholder="Correct text answer (for text type)"></textarea>
            <textarea wire:model="explanation" rows="3" class="w-full border rounded-xl px-4 py-2" placeholder="Explanation"></textarea>
            <input wire:model="sort_order" type="number" class="w-full border rounded-xl px-4 py-2" placeholder="Sort order">

            @if($question_type === 'mcq')
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="font-medium">Options</div>
                        <button type="button" wire:click="addOption" class="text-sm underline">Add option</button>
                    </div>

                    @foreach($options as $index => $option)
                        <div class="rounded-xl border p-3 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-slate-500">Option #{{ $index + 1 }}</span>
                                <button type="button" wire:click="removeOption({{ $index }})" class="text-xs text-rose-600">Remove</button>
                            </div>

                            <input wire:model="options.{{ $index }}.option_text" class="w-full border rounded-lg px-3 py-2" placeholder="Option text">
                            <div class="flex items-center gap-2">
                                <input wire:model="options.{{ $index }}.is_correct" type="checkbox">
                                <span class="text-sm">Correct answer</span>
                            </div>
                            <input wire:model="options.{{ $index }}.sort_order" type="number" class="w-full border rounded-lg px-3 py-2" placeholder="Sort order">
                        </div>
                    @endforeach
                </div>
            @endif

            @error('options')
                <p class="text-sm text-rose-600">{{ $message }}</p>
            @enderror

            <button wire:click="save" class="w-full px-4 py-2 rounded-xl bg-slate-900 text-white">
                Save
            </button>
        </aside>
    </div>
</div>