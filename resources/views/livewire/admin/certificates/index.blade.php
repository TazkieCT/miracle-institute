<div x-data="{ open: @entangle('showModal').live }" class="max-w-6xl mx-auto px-4 space-y-6">

    <x-ui.page-header
        title="Certificates"
        subtitle="CRUD certificate penuh. Bisa difilter per course/topic/type/status."
    >
        <button wire:click="create"
            class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm">
            + New Certificate
        </button>
    </x-ui.page-header>

    {{-- STATS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="rounded-2xl bg-white border p-5">
            <div class="text-xs text-slate-500">Total</div>
            <div class="text-3xl font-bold mt-1">{{ number_format($stats['total']) }}</div>
        </div>

        <div class="rounded-2xl bg-emerald-50/30 border p-5">
            <div class="text-xs text-slate-500">Issued</div>
            <div class="text-3xl font-bold mt-1 text-emerald-600">
                {{ number_format($stats['issued']) }}
            </div>
        </div>

        <div class="rounded-2xl bg-slate-50 border p-5">
            <div class="text-xs text-slate-500">Draft</div>
            <div class="text-3xl font-bold mt-1">
                {{ number_format($stats['draft']) }}
            </div>
        </div>

        <div class="rounded-2xl bg-rose-50/30 border p-5">
            <div class="text-xs text-slate-500">Expired</div>
            <div class="text-3xl font-bold mt-1 text-rose-600">
                {{ number_format($stats['expired']) }}
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
        <input wire:model.live="search"
            class="w-full border rounded-xl px-4 py-2"
            placeholder="Search certificate...">

        <select wire:model.live="courseFilter" class="border rounded-xl px-4 py-2">
            <option value="">All courses</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endforeach
        </select>

        <select wire:model.live="topicFilter" class="border rounded-xl px-4 py-2">
            <option value="">All topics</option>
            @foreach($topics as $topic)
                <option value="{{ $topic->id }}">
                    {{ $topic->course?->title }} · {{ $topic->name }}
                </option>
            @endforeach
        </select>

        <select wire:model.live="typeFilter" class="border rounded-xl px-4 py-2">
            <option value="">All types</option>
            <option value="course">Course</option>
            <option value="topic">Topic</option>
        </select>

        <select wire:model.live="statusFilter" class="border rounded-xl px-4 py-2">
            <option value="">All status</option>
            <option value="issued">Issued</option>
            <option value="draft">Draft</option>
            <option value="expired">Expired</option>
        </select>
    </div>

    {{-- TABLE --}}
    <x-ui.table-shell class="table-auto">
        <thead class="bg-slate-50 text-left">
            <tr>
                <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap">Certificate</th>
                <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap">Course / Topic</th>
                <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap">Type</th>
                <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap">Issued</th>
                <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap">Status</th>
                <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap">Action</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-100 bg-white">
            @forelse($rows as $row)
                <tr class="align-top">
                    <td class="px-4 py-3">
                        <div class="font-medium text-slate-900">{{ $row->certificate_number }}</div>
                        <div class="text-xs text-slate-500 truncate max-w-[200px]">
                            {{ $row->file_path }}
                        </div>
                        <span class="text-xs text-slate-500">
                            {{ $row->user?->full_name }}
                        </span>
                    </td>

                    <td class="px-4 py-3">
                        <div class="font-medium text-slate-900">{{ $row->course?->title ?? '-' }}</div>
                        <div class="text-xs text-slate-500">{{ $row->topic?->name ?? '-' }}</div>
                    </td>

                    <td class="px-4 py-3 whitespace-nowrap">{{ ucfirst($row->type) }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $row->issued_at?->format('d M Y H:i') ?? '-' }}</td>

                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="px-2 py-1 rounded-full text-xs bg-slate-100">
                            {{ $row->status }}
                        </span>
                    </td>

                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-2">
                            
                                        @if($row->file_path)
                                            <a href="{{ route('certificates.download', $row->id) }}"
                                                class="px-3 py-1.5 rounded-lg text-xs bg-slate-100 hover:bg-slate-200">
                                                Download
                                            </a>
                                        @endif

                                        <div class="w-full border-t my-1"></div>

                                        <button wire:click="edit('{{ $row->id }}')"
                                            class="px-3 py-1.5 rounded-lg text-xs bg-blue-100 text-blue-700 hover:bg-blue-200">
                                            Edit
                                        </button>

                                        <button wire:click="delete('{{ $row->id }}')"
                                            class="px-3 py-1.5 rounded-lg text-xs bg-red-100 text-red-700 hover:bg-red-200">
                                            Delete
                                        </button>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-slate-500">
                        No certificates found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </x-ui.table-shell>

    

    {{-- MODAL --}}
    <template x-teleport="body">
        <div x-show="open"
             x-cloak
             x-transition
             @click.self="open = false; $wire.set('showModal', false)"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">

            <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl flex flex-col max-h-[90vh]">

                <div class="flex justify-between items-center p-6 border-b">
                    <h2 class="text-lg font-semibold">
                        {{ $editingId ? 'Edit Certificate' : 'New Certificate' }}
                    </h2>

                    <button @click="open = false; $wire.set('showModal', false)"
                        class="text-slate-500 text-xl">
                        ✕
                    </button>
                </div>

                <div class="p-6 space-y-4 overflow-y-auto">

                    <input wire:model="certificate_number"
                        class="w-full border rounded-xl px-4 py-2"
                        placeholder="Certificate number">

                    <select wire:model="user_id"
                        class="w-full border rounded-xl px-4 py-2">
                        <option value="">Select user</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->full_name }} · {{ $user->email }}
                            </option>
                        @endforeach
                    </select>

                    <select wire:model="course_id"
                        class="w-full border rounded-xl px-4 py-2">
                        <option value="">Select course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>

                    <select wire:model="topic_id"
                        class="w-full border rounded-xl px-4 py-2">
                        <option value="">Select topic</option>
                        @foreach($topics as $topic)
                            <option value="{{ $topic->id }}">
                                {{ $topic->course?->title }} · {{ $topic->name }}
                            </option>
                        @endforeach
                    </select>

                    <select wire:model="type"
                        class="w-full border rounded-xl px-4 py-2">
                        <option value="course">Course</option>
                        <option value="topic">Topic</option>
                    </select>

                    <input wire:model="file_path"
                        class="w-full border rounded-xl px-4 py-2"
                        placeholder="File path">

                    <input wire:model="issued_at"
                        type="datetime-local"
                        class="w-full border rounded-xl px-4 py-2">

                    <select wire:model="status"
                        class="w-full border rounded-xl px-4 py-2">
                        <option value="issued">Issued</option>
                        <option value="draft">Draft</option>
                        <option value="expired">Expired</option>
                    </select>

                </div>

                <div class="flex justify-end gap-2 p-4 border-t">
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