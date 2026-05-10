<div x-data="{ open: @entangle('showModal').live }" class="max-w-6xl mx-auto px-4 space-y-6">

    <x-ui.page-header
        title="Video Sessions"
        subtitle="Halaman utama sesi. Detail absensi dibuka dari tiap sesi."
    >
        <div>
            <button wire:click="create"
                class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm">
                + New Session
            </button>
        </div>
    </x-ui.page-header>

    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-4">
        @foreach([
            'Total' => $stats['total'],
            'Scheduled' => $stats['scheduled'],
            'Ongoing' => $stats['ongoing'],
            'Completed' => $stats['completed'],
            'Cancelled' => $stats['cancelled'],
        ] as $label => $value)
            <div class="rounded-2xl bg-white border p-4">
                <div class="text-[11px] text-slate-500">{{ $label }}</div>
                <div class="text-lg font-bold mt-1">{{ number_format($value) }}</div>
            </div>
        @endforeach
    </div>

    <div class="space-y-4">
        <div class="rounded-2xl bg-white border p-4 space-y-3">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <input wire:model.live="search"
                    class="border rounded-xl px-3 py-2 text-xs"
                    placeholder="Search session...">

                <select wire:model.live="courseFilter" class="border rounded-xl px-3 py-2 text-xs">
                    <option value="">All courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>

                <select wire:model.live="topicFilter" class="border rounded-xl px-3 py-2 text-xs">
                    <option value="">All topics</option>
                    @foreach($topics as $topic)
                        <option value="{{ $topic->id }}">
                            {{ $topic->course?->title }} · {{ $topic->name }}
                        </option>
                    @endforeach
                </select>

                <select wire:model.live="statusFilter" class="border rounded-xl px-3 py-2 text-xs">
                    <option value="">All status</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="ongoing">Ongoing</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <x-ui.table-shell class="table-auto">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap">Course</th>
                    <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap">Title</th>
                    <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap">Schedule</th>
                    <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap text-center">Status</th>
                    <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap text-center">Attend</th>
                    <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($rows as $row)
                    <tr class="align-top">
                        <td class="px-4 py-3 whitespace-nowrap max-w-[180px] truncate">
                            {{ $row->topic?->course?->title }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap max-w-[220px] truncate font-medium text-slate-900">
                            {{ $row->title }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div>{{ $row->start_at?->format('d M H:i') }}</div>
                            <div class="text-xs text-slate-500">→ {{ $row->end_at?->format('H:i') }}</div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <span class="px-2 py-1 rounded-full text-xs bg-slate-100">
                                {{ $row->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            {{ $row->attendances->count() }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('admin.attendances.index', ['sessionFilter' => $row->id]) }}"
                                   class="px-2 py-1 rounded-md bg-slate-100 hover:bg-slate-200 text-xs">
                                    Attend
                                </a>

                                <div class="w-full border-t my-1"></div>

                                <button wire:click="edit('{{ $row->id }}')"
                                    class="px-2 py-1 rounded-md bg-blue-100 text-blue-700 hover:bg-blue-200 text-xs">
                                    Edit
                                </button>

                                <button wire:click="delete('{{ $row->id }}')"
                                    class="px-2 py-1 rounded-md bg-rose-100 text-rose-700 hover:bg-rose-200 text-xs">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-slate-500">
                            No sessions found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-ui.table-shell>

        <div>{{ $rows->links() }}</div>
    </div>

    <template x-teleport="body">
        <div x-show="open"
             x-cloak
             x-transition
             @click.self="open = false; $wire.set('showModal', false)"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">

            <div class="bg-white w-full max-w-xl rounded-2xl shadow-xl p-6 max-h-[90vh] overflow-y-auto space-y-4">

                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">
                        {{ $editingId ? 'Edit Session' : 'New Session' }}
                    </h2>
                    <button @click="open = false; $wire.set('showModal', false)">✕</button>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-medium text-slate-600">Topic</label>

                    <input
                        wire:model.live.debounce.300ms="topicSearch"
                        class="w-full border rounded-xl px-4 py-2"
                        placeholder="Search course or topic..."
                    >

                    <div class="flex items-center justify-between text-xs text-slate-500">
                        <span>Select one topic from the results below.</span>

                        @if($topic_id)
                            <button type="button"
                                wire:click="clearTopicSelection"
                                class="underline hover:text-slate-700">
                                Clear
                            </button>
                        @endif
                    </div>

                    @if($topic_id && $selectedTopic)
                        <div class="text-xs text-slate-600">
                            Selected:
                            <span class="font-medium">
                                {{ $selectedTopic->course?->title }} · {{ $selectedTopic->name }}
                            </span>
                        </div>
                    @endif

                    @if($showTopicResults)
                        <div class="max-h-56 overflow-y-auto rounded-xl border divide-y">
                            @forelse($topicOptions as $topic)
                                <button
                                    type="button"
                                    wire:key="topic-option-{{ $topic->id }}"
                                    wire:click="selectTopic('{{ $topic->id }}')"
                                    class="w-full text-left px-4 py-3 hover:bg-slate-50 flex items-center justify-between gap-3"
                                >
                                    <span class="text-sm text-slate-700">
                                        {{ $topic->course?->title }} · {{ $topic->name }}
                                    </span>

                                    @if($topic_id === $topic->id)
                                        <span class="text-[11px] px-2 py-1 rounded-full bg-slate-900 text-white">
                                            Selected
                                        </span>
                                    @endif
                                </button>
                            @empty
                                @if(filled($topicSearch))
                                    <div class="px-4 py-4 text-sm text-slate-500">
                                        No matching topics.
                                    </div>
                                @endif
                            @endforelse
                        </div>
                    @endif

                    @error('topic_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <input wire:model.live="title" class="w-full border rounded-xl px-4 py-2" placeholder="Session title">
                <input wire:model.live="zoom_link" class="w-full border rounded-xl px-4 py-2" placeholder="Zoom link">

                <div class="grid grid-cols-2 gap-3">
                    <input wire:model.live="start_at" type="datetime-local" class="border rounded-xl px-4 py-2">
                    <input wire:model.live="end_at" type="datetime-local" class="border rounded-xl px-4 py-2">
                </div>

                <div class="rounded-xl border bg-slate-50 px-4 py-3 space-y-3">
                    <div>
                        <div class="text-[11px] uppercase tracking-wide text-slate-500">
                            Session Status
                        </div>

                        <div class="mt-1 inline-flex items-center rounded-full bg-white border px-3 py-1 text-sm font-semibold text-slate-700">
                            {{ ucfirst($status) }}
                        </div>
                    </div>

                    <div class="border-t pt-3 text-[11px] leading-relaxed text-slate-500 space-y-1">
                        <div>
                            <span class="font-medium text-slate-600">Scheduled</span>
                            → sebelum sesi dimulai
                        </div>

                        <div>
                            <span class="font-medium text-slate-600">Ongoing</span>
                            → saat sesi sedang berlangsung
                        </div>

                        <div>
                            <span class="font-medium text-slate-600">Completed</span>
                            → setelah sesi selesai
                        </div>

                        <div>
                            <span class="font-medium text-slate-600">Cancelled</span>
                            → sesi dibatalkan manual
                        </div>
                    </div>
                </div>

                @error('title') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                @error('zoom_link') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                @error('start_at') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                @error('end_at') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

                <div class="flex justify-end gap-2">
                    <button @click="open = false; $wire.set('showModal', false)"
                        class="px-4 py-2 border rounded-xl">
                        Cancel
                    </button>

                    <button wire:click="save"
                        class="px-4 py-2 bg-slate-900 text-white rounded-xl">
                        Save
                    </button>
                </div>

            </div>
        </div>
    </template>
</div>