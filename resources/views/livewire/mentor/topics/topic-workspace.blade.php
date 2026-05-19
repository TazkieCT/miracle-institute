<div
    class="space-y-6 lg:px-36"
    style="
        --mentor-primary: #004777;
        --mentor-primary-soft: color-mix(in oklab, #004777 12%, white);
        --mentor-primary-soft-2: color-mix(in oklab, #004777 7%, white);
        --mentor-secondary: color-mix(in oklab, #3B82F6 70%, transparent);
        --mentor-secondary-solid: color-mix(in oklab, #3B82F6 70%, white);
    "
>
    <section class="rounded-2xl border border-slate-200 bg-white px-6 pt-6 shadow-[0_18px_40px_color-mix(in_oklab,#004777_10%,transparent)]">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div class="space-y-2">
                <div class="text-xs uppercase tracking-[0.18em] text-[color:color-mix(in_oklab,#004777_45%,white)]">
                    {{ __('mentor.topic_workspace.header') }} · {{ $topic->course?->title }}
                </div>
                <h1 class="text-2xl font-bold text-[var(--mentor-primary)]">
                    {{ $topic->name }}
                </h1>
                <p class="max-w-3xl text-sm text-[color:color-mix(in_oklab,#004777_72%,white)]">
                    {{ __('mentor.topic_workspace.subtitle') }}
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ localized_route('topics.show', $topic->slug) }}"
                   class="rounded-xl border border-slate-200 bg-[var(--mentor-primary-soft-2)] px-4 py-2 text-sm font-medium text-[var(--mentor-primary)] transition hover:bg-[var(--mentor-secondary)]">
                    {{ __('mentor.topic_workspace.visit_topic') }}
                </a>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-3 text-sm sm:grid-cols-3">
            <div class="rounded-xl border border-slate-200 bg-[var(--mentor-primary-soft-2)] p-4">
                <div class="text-xs uppercase tracking-wide text-[color:color-mix(in_oklab,#004777_50%,white)]">{{ __('mentor.topic_workspace.cards.topic') }}</div>
                <div class="mt-1 font-semibold text-[var(--mentor-primary)]">{{ strtoupper($topic->status) }}</div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-[var(--mentor-primary-soft-2)] p-4">
                <div class="text-xs uppercase tracking-wide text-[color:color-mix(in_oklab,#004777_50%,white)]">{{ __('mentor.topic_workspace.cards.course') }}</div>
                <div class="mt-1 font-semibold text-[var(--mentor-primary)]">{{ $topic->course?->title ?? '-' }}</div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-[var(--mentor-primary-soft-2)] p-4">
                <div class="text-xs uppercase tracking-wide text-[color:color-mix(in_oklab,#004777_50%,white)]">{{ __('mentor.topic_workspace.cards.program') }}</div>
                <div class="mt-1 font-semibold text-[var(--mentor-primary)]">{{ $topic->course?->studyProgram?->title ?? '-' }}</div>
            </div>
        </div>

        <div class="mt-6">
            <div class="-mb-px flex gap-2 overflow-x-auto">
                @foreach($tabs as $key => $label)
                    <button type="button"
                            wire:click="setTab('{{ $key }}')"
                            class="whitespace-nowrap rounded-t-xl border-b-2 px-4 py-3 text-sm font-medium transition
                                {{ $tab === $key
                                    ? 'border-[var(--mentor-primary)] bg-[var(--mentor-primary)] text-white shadow-sm'
                                    : 'border-transparent text-[color:color-mix(in_oklab,#004777_55%,white)] hover:border-[var(--mentor-secondary)] hover:bg-[var(--mentor-primary-soft-2)] hover:text-[var(--mentor-primary)]' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    @livewire($activeComponent, ['topicId' => $topic->id], key($activeComponent . '-' . $topic->id))
</div>
