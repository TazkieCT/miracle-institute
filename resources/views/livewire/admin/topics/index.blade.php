<div x-data="{ open: @entangle('showModal').live }" class="mx-auto max-w-6xl space-y-6 px-4">
    <x-ui.page-header
        title="{{ __('admin.topics.page_title') }}"
        subtitle="{{ __('admin.topics.page_subtitle') }}"
    >
        <div class="flex items-center gap-2">
            @if($selectedCourse)
                <a href="{{ localized_route('admin.courses.index') }}"
                   class="rounded-xl border px-4 py-2 text-sm">
                    Back
                </a>
            @endif

            <button wire:click="create"
                class="rounded-xl bg-slate-900 px-4 py-2 text-sm text-white">
                {{ __('admin.topics.actions.create') }}
            </button>
        </div>
    </x-ui.page-header>

    @if($selectedCourse)
        <div class="rounded-2xl border bg-white p-4">
            <div class="text-xs text-slate-500">Selected Course</div>
            <div class="mt-1 text-lg font-semibold text-slate-900">{{ $selectedCourse->title }}</div>
        </div>
    @endif

    <section class="space-y-4">
        <div class="rounded-2xl border bg-white p-4">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                <input wire:model.live="search"
                    class="rounded-xl border px-4 py-2"
                    placeholder="{{ __('admin.topics.search_placeholder') }}">

                <select wire:model.live="teacherFilter"
                    class="rounded-xl border px-4 py-2">
                    <option value="">{{ __('admin.topics.filters.all_teachers') }}</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                    @endforeach
                </select>

                <select wire:model.live="statusFilter"
                    class="rounded-xl border px-4 py-2">
                    <option value="">{{ __('admin.topics.filters.all_status') }}</option>
                    <option value="published">{{ __('admin.topics.status.published') }}</option>
                    <option value="archived">{{ __('admin.topics.status.archived') }}</option>
                    <option value="draft">{{ __('admin.topics.status.draft') }}</option>
                </select>
            </div>
        </div>

        <x-ui.table-shell class="table-auto">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="whitespace-nowrap px-4 py-3 font-medium text-slate-600">{{ __('admin.topics.table.topic') }}</th>
                    <th class="whitespace-nowrap px-4 py-3 font-medium text-slate-600">{{ __('admin.topics.table.teacher') }}</th>
                    <th class="whitespace-nowrap px-4 py-3 font-medium text-slate-600">{{ __('admin.topics.table.order') }}</th>
                    <th class="whitespace-nowrap px-4 py-3 font-medium text-slate-600">{{ __('admin.topics.table.content') }}</th>
                    <th class="whitespace-nowrap px-4 py-3 font-medium text-slate-600">{{ __('admin.topics.table.status') }}</th>
                    <th class="whitespace-nowrap px-4 py-3 font-medium text-slate-600">{{ __('admin.topics.table.action') }}</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($rows as $row)
                    <tr class="align-top">
                        <td class="px-4 py-3">
                            <div class="font-medium text-slate-900">{{ $row->name }}</div>
                            <div class="text-xs text-slate-500">{{ $row->category }}</div>
                        </td>

                        <td class="whitespace-nowrap px-4 py-3">{{ $row->teacher?->full_name }}</td>
                        <td class="whitespace-nowrap px-4 py-3">{{ $row->sort_order }}</td>

                        <td class="px-4 py-3 text-xs text-slate-500">
                            {{ __('admin.topics.metrics.materials', ['count' => $row->materials_count]) }}<br>
                            {{ __('admin.topics.metrics.sessions', ['count' => $row->video_sessions_count]) }}<br>
                            {{ __('admin.topics.metrics.certificates', ['count' => $row->certificates_count]) }}
                        </td>

                        <td class="whitespace-nowrap px-4 py-3">
                            <span class="rounded-full bg-slate-100 px-2 py-1 text-xs">
                                {{ __('admin.topics.status.' . $row->status, [], $row->status) }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ localized_route('admin.materials.index', ['topicFilter' => $row->id]) }}"
                                   class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs hover:bg-slate-200">
                                    {{ __('admin.topics.actions.materials') }}
                                </a>

                                <a href="{{ localized_route('admin.sessions.index', ['topicFilter' => $row->id]) }}"
                                   class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs hover:bg-slate-200">
                                    {{ __('admin.topics.actions.sessions') }}
                                </a>

                                {{-- Assessments & Certificates actions removed from topic row — available on Courses page only --}}

                                <div class="my-1 w-full border-t"></div>

                                <button wire:click="edit('{{ $row->id }}')"
                                    class="rounded-lg bg-blue-100 px-3 py-1.5 text-xs text-blue-700 hover:bg-blue-200">
                                    {{ __('admin.topics.actions.edit') }}
                                </button>

                                <button wire:click="delete('{{ $row->id }}')"
                                    class="rounded-lg bg-red-100 px-3 py-1.5 text-xs text-red-700 hover:bg-red-200">
                                    {{ __('admin.topics.actions.delete') }}
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-slate-500">
                            {{ __('admin.topics.empty') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-ui.table-shell>

        <div>{{ $rows->links() }}</div>
    </section>

    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            x-transition
            @click.self="open = false; $wire.set('showModal', false)"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
        >
            <div class="flex max-h-[90vh] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white shadow-xl">
                <div class="flex items-center justify-between border-b p-5">
                    <h2 class="text-lg font-semibold">
                        {{ $editingId ? __('admin.topics.modal.edit_title') : __('admin.topics.modal.create_title') }}
                    </h2>

                    <button
                        @click="open = false; $wire.set('showModal', false)"
                        class="text-slate-500 hover:text-black"
                    >
                        ✕
                    </button>
                </div>

                <div class="space-y-4 overflow-y-auto p-5">
                    @if($selectedCourse)
                        <input
                            value="{{ $selectedCourse->title }}"
                            disabled
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-slate-600"
                        >
                    @endif

                    <select wire:model="teacher_id" class="w-full rounded-xl border px-4 py-2">
                        <option value="">{{ __('admin.topics.form.select_teacher') }}</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                        @endforeach
                    </select>

                    <input wire:model="name" class="w-full rounded-xl border px-4 py-2" placeholder="{{ __('admin.topics.form.name_placeholder') }}">

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <select wire:model="visibility" class="w-full rounded-xl border px-4 py-2">
                            <option value="Public">{{ __('admin.topics.visibility.public') }}</option>
                            <option value="Private">{{ __('admin.topics.visibility.private') }}</option>
                        </select>

                        <select wire:model="status" class="w-full rounded-xl border px-4 py-2">
                            <option value="published">{{ __('admin.topics.status.published') }}</option>
                            <option value="archived">{{ __('admin.topics.status.archived') }}</option>
                            <option value="draft">{{ __('admin.topics.status.draft') }}</option>
                        </select>
                    </div>

                    <input wire:model="sort_order" type="number" class="w-full rounded-xl border px-4 py-2" placeholder="{{ __('admin.topics.form.sort_order_placeholder') }}">

                    <textarea wire:model="description" rows="4" class="w-full rounded-xl border px-4 py-2" placeholder="{{ __('admin.topics.form.description_placeholder') }}"></textarea>
                </div>

                <div class="flex items-center justify-between border-t bg-slate-50 p-5">
                    <div class="flex gap-2">
                        <button
                            @click="open = false; $wire.set('showModal', false)"
                            class="rounded-xl border px-4 py-2"
                        >
                            {{ __('admin.topics.actions.cancel') }}
                        </button>

                        <button
                            wire:click="save"
                            class="rounded-xl bg-slate-900 px-4 py-2 text-white"
                        >
                            {{ __('admin.topics.actions.save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>