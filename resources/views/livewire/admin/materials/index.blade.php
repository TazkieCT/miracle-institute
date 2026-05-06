<div x-data="{ open: @entangle('showModal') }" class="space-y-6">
    <x-ui.page-header
        title="Materials"
        subtitle="Halaman utama materi. Detail material berada di bawah topic yang relevan."
    />

    <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
        <input wire:model.live="search" class="w-full border rounded-xl px-4 py-2" placeholder="Search material, topic, or course...">

        <select wire:model.live="courseFilter" class="border rounded-xl px-4 py-2">
            <option value="">All courses</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endforeach
        </select>

        <select wire:model.live="topicFilter" class="border rounded-xl px-4 py-2">
            <option value="">All topics</option>
            @foreach($topics as $topic)
                <option value="{{ $topic->id }}">{{ $topic->course?->title }} · {{ $topic->name }}</option>
            @endforeach
        </select>

        <select wire:model.live="typeFilter" class="border rounded-xl px-4 py-2">
            <option value="">All types</option>
            <option value="pdf">PDF</option>
            <option value="ppt">PPT</option>
            <option value="video">VIDEO</option>
        </select>

        <select wire:model.live="statusFilter" class="border rounded-xl px-4 py-2">
            <option value="">All status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>

    <div class="space-y-4">
        @forelse($topics->groupBy('course_id') as $group)
            @php($course = $group->first()?->course)
            <div class="rounded-2xl bg-white border overflow-hidden">
                <div class="p-4 border-b bg-slate-50 flex items-center justify-between">
                    <div>
                        <h2 class="font-semibold">{{ $course?->title }}</h2>
                        <p class="text-xs text-slate-500">{{ $group->count() }} topics in this course</p>
                    </div>
                    <a href="{{ route('admin.topics.index', ['courseFilter' => $course?->id]) }}" class="text-sm underline">Open Topics</a>
                </div>

                <div class="divide-y">
                    @foreach($group as $topic)
                        <div class="p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <div class="font-semibold">{{ $topic->name }}</div>
                                    <div class="text-xs text-slate-500">
                                        {{ $topic->materials->count() }} materials · {{ $topic->visibility }} · {{ $topic->status }}
                                    </div>
                                </div>

                                <div class="flex gap-2">
                                    <button wire:click="toggleTopic('{{ $topic->id }}')" class="px-3 py-1 border rounded-lg text-sm">
                                        {{ in_array($topic->id, $openTopics) ? 'Hide' : 'Show' }}
                                    </button>
                                    <button wire:click="create('{{ $topic->id }}')" class="px-3 py-1 bg-slate-900 text-white rounded-lg text-sm">
                                        + Add
                                    </button>
                                </div>
                            </div>

                            @if(in_array($topic->id, $openTopics))
                                <div class="mt-4 overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead class="bg-white border-b">
                                            <tr>
                                                <th class="p-4 text-left">Name</th>
                                                <th class="p-4">Type</th>
                                                <th class="p-4">Source</th>
                                                <th class="p-4">Visibility</th>
                                                <th class="p-4">Status</th>
                                                <th class="p-4">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topic->materials as $row)
                                                <tr class="border-t hover:bg-slate-50">
                                                    <td class="p-4">
                                                        <div class="font-medium">{{ $row->name }}</div>
                                                        <div class="text-xs text-slate-500">Sort {{ $row->sort_order }}</div>
                                                    </td>
                                                    <td class="p-4">{{ strtoupper($row->type) }}</td>
                                                    <td class="p-4 text-xs text-slate-500 break-all">
                                                        {{ $row->path ?: $row->external_url }}
                                                    </td>
                                                    <td class="p-4">{{ $row->visibility }}</td>
                                                    <td class="p-4">{{ $row->status }}</td>
                                                    <td class="p-4">
                                                        <div class="flex gap-3">
                                                            <button wire:click="edit('{{ $row->id }}')" class="text-blue-600 text-sm">Edit</button>
                                                            <button wire:click="delete('{{ $row->id }}')" class="text-rose-600 text-sm">Delete</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            @if($topic->materials->isEmpty())
                                                <tr>
                                                    <td colspan="6" class="p-6 text-center text-slate-500">No materials.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="rounded-2xl bg-white border p-6 text-center text-slate-500">
                No data.
            </div>
        @endforelse
    </div>

    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl p-6 space-y-4">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">{{ $editingId ? 'Edit Material' : 'New Material' }}</h2>
                <button @click="open = false; $wire.set('showModal', false)" class="text-slate-500">✕</button>
            </div>

            <div class="space-y-3">
                <select wire:model="topic_id" class="w-full border rounded-xl px-4 py-2">
                    <option value="">Select topic</option>
                    @foreach($topics as $t)
                        <option value="{{ $t->id }}">{{ $t->course?->title }} · {{ $t->name }}</option>
                    @endforeach
                </select>

                <select wire:model="uploader_id" class="w-full border rounded-xl px-4 py-2">
                    <option value="">Select uploader</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                    @endforeach
                </select>

                <input wire:model="name" class="w-full border rounded-xl px-4 py-2" placeholder="Material name">

                <select wire:model="type" class="w-full border rounded-xl px-4 py-2">
                    <option value="">Select type</option>
                    @foreach($this->availableTypes as $opt)
                        <option value="{{ $opt }}">{{ strtoupper($opt) }}</option>
                    @endforeach
                    @if($editingId && !in_array($this->type, $this->availableTypes))
                        <option value="{{ $this->type }}">{{ strtoupper($this->type) }} (current)</option>
                    @endif
                </select>

                @if($this->type === 'video')
                    <input wire:model="external_url" class="w-full border rounded-xl px-4 py-2" placeholder="YouTube / Vimeo URL">
                @elseif(in_array($this->type, ['pdf', 'ppt']))
                    <input wire:model="path" class="w-full border rounded-xl px-4 py-2" placeholder="File path (storage)">
                @endif

                <div class="grid grid-cols-2 gap-3">
                    <select wire:model="visibility" class="border rounded-xl px-4 py-2">
                        <option value="Public">Public</option>
                        <option value="Private">Private</option>
                    </select>

                    <select wire:model="status" class="border rounded-xl px-4 py-2">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <input wire:model="sort_order" type="number" class="w-full border rounded-xl px-4 py-2" placeholder="Sort order">

                @error('topic_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                @error('uploader_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                @error('name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                @error('type') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                @error('external_url') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                @error('path') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-2 pt-3">
                <button @click="open = false; $wire.set('showModal', false)" class="px-4 py-2 border rounded-xl">Cancel</button>
                <button wire:click="save" class="px-4 py-2 bg-slate-900 text-white rounded-xl">Save</button>
            </div>
        </div>
    </div>
</div>