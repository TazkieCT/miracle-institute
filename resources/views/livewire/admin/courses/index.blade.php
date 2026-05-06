<div x-data="{ open: @entangle('showModal').live }" class="max-w-6xl mx-auto px-4 space-y-6">

    <x-ui.page-header
        title="Courses"
        subtitle="Halaman utama course. Detail topik, materi, sesi, assessment, dan certificate dibuka dari sini."
    >
        <div>
            <button wire:click="create"
                class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm">
                + New Course
            </button>
        </div>
    </x-ui.page-header>

    {{-- STATS --}}
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
        @foreach([
            ['Courses', $stats['courses']],
            ['Topics', $stats['topics']],
            ['Materials', $stats['materials']],
            ['Sessions', $stats['sessions']],
            ['Assessments', $stats['assessments']],
            ['Certificates', $stats['certificates']],
        ] as [$label, $value])
            <div class="rounded-2xl bg-white border p-5">
                <div class="text-xs text-slate-500">{{ $label }}</div>
                <div class="text-2xl font-bold mt-1">
                    {{ number_format($value) }}
                </div>
            </div>
        @endforeach
    </div>

    {{-- TABLE --}}
    <section class="space-y-4">
        <div class="rounded-2xl bg-white border p-4 space-y-3">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <input wire:model.live="search"
                       class="border rounded-xl px-4 py-2"
                       placeholder="Search course...">

                <select wire:model.live="studyProgramFilter"
                        class="border rounded-xl px-4 py-2">
                    <option value="">All programs</option>
                    @foreach($studyPrograms as $sp)
                        <option value="{{ $sp->id }}">{{ $sp->title }}</option>
                    @endforeach
                </select>

                <select wire:model.live="statusFilter"
                        class="border rounded-xl px-4 py-2">
                    <option value="">All status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>

                <select wire:model.live="perPage"
                        class="border rounded-xl px-4 py-2">
                    <option value="10">10 / page</option>
                    <option value="25">25 / page</option>
                    <option value="50">50 / page</option>
                </select>
            </div>
        </div>

        <x-ui.table-shell class="table-auto">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap">Course</th>
                    <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap">Program</th>
                    <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap">Topics</th>
                    <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap">Enrollments</th>
                    <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap">Certificates</th>
                    <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap">Status</th>
                    <th class="px-4 py-3 font-medium text-slate-600 whitespace-nowrap">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($rows as $row)
                    <tr class="align-top">
                        <td class="px-4 py-3">
                            <div class="font-medium text-slate-900">{{ $row->title }}</div>
                            <div class="text-xs text-slate-500">{{ $row->slug }}</div>
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">{{ $row->studyProgram?->title }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $row->topics_count }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $row->enrollments_count }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $row->certificates_count }}</td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2 py-1 rounded-full text-xs bg-slate-100">
                                {{ $row->status }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-2">
                                
                                <a href="{{ route('admin.topics.index', ['courseFilter' => $row->id]) }}"
                                   class="px-3 py-1.5 rounded-lg text-xs bg-slate-100 hover:bg-slate-200">
                                    Topics
                                </a>

                                <a href="{{ route('admin.materials.index', ['courseFilter' => $row->id]) }}"
                                   class="px-3 py-1.5 rounded-lg text-xs bg-slate-100 hover:bg-slate-200">
                                    Materials
                                </a>

                                <a href="{{ route('admin.sessions.index', ['courseFilter' => $row->id]) }}"
                                   class="px-3 py-1.5 rounded-lg text-xs bg-slate-100 hover:bg-slate-200">
                                    Sessions
                                </a>

                                <a href="{{ route('admin.assessments.index', ['courseFilter' => $row->id]) }}"
                                   class="px-3 py-1.5 rounded-lg text-xs bg-slate-100 hover:bg-slate-200">
                                    Assessments
                                </a>

                                <a href="{{ route('admin.certificates.index', ['courseFilter' => $row->id]) }}"
                                   class="px-3 py-1.5 rounded-lg text-xs bg-slate-100 hover:bg-slate-200">
                                    Certificates
                                </a>

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
                            No data.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-ui.table-shell>

        <div>{{ $rows->links() }}</div>
    </section>

    {{-- MODAL --}}
    <template x-teleport="body">
        <div x-show="open"
             x-cloak
             x-transition
             class="fixed inset-0 z-[9999] flex items-center justify-center">

            <!-- overlay -->
            <div class="absolute inset-0 bg-black/50"
                 @click="open = false">
            </div>

            <!-- modal -->
            <div @click.stop
                 class="relative bg-white w-full max-w-2xl rounded-2xl shadow-xl p-6 space-y-4 mx-4">

                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">
                        {{ $editingId ? 'Edit Course' : 'New Course' }}
                    </h2>

                    <button @click="open = false"
                            class="text-slate-500 hover:text-black">
                        ✕
                    </button>
                </div>

                <select wire:model="study_program_id" class="w-full border rounded-xl px-4 py-2">
                    <option value="">Select program</option>
                    @foreach($studyPrograms as $sp)
                        <option value="{{ $sp->id }}">{{ $sp->title }}</option>
                    @endforeach
                </select>

                <input wire:model="title"
                       class="w-full border rounded-xl px-4 py-2"
                       placeholder="Title">

                <input wire:model="poster"
                       class="w-full border rounded-xl px-4 py-2"
                       placeholder="Poster path/url">

                <div class="grid grid-cols-2 gap-3">
                    <input wire:model="credit" type="number"
                           class="border rounded-xl px-4 py-2" placeholder="Credit">

                    <input wire:model="quota" type="number"
                           class="border rounded-xl px-4 py-2" placeholder="Quota">
                </div>

                <textarea wire:model="description"
                          rows="4"
                          class="w-full border rounded-xl px-4 py-2"
                          placeholder="Description"></textarea>

                <select wire:model="status"
                        class="w-full border rounded-xl px-4 py-2">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>

                <div class="flex justify-end gap-2">
                    <button @click="open = false"
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