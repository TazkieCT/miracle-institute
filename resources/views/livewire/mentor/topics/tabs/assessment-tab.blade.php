<section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-[0_14px_35px_color-mix(in_oklab,#004777_8%,transparent)]">
    <h2 class="text-lg font-semibold text-[var(--mentor-primary)]">Assessment</h2>
    <p class="mt-1 text-sm text-[color:color-mix(in_oklab,#004777_70%,white)]">Ringkasan singkat assessment pada course ini.</p>

    @if($assessment)
        <div class="mt-4 grid grid-cols-1 gap-3 text-sm sm:grid-cols-4">
            <div class="rounded-xl border border-slate-200 bg-[var(--mentor-primary-soft-2)] p-4">
                <div class="text-xs text-[color:color-mix(in_oklab,#004777_60%,white)]">Title</div>
                <div class="mt-1 font-semibold text-[var(--mentor-primary)]">{{ $assessment->title }}</div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-[var(--mentor-primary-soft-2)] p-4">
                <div class="text-xs text-[color:color-mix(in_oklab,#004777_60%,white)]">Passing Grade</div>
                <div class="mt-1 font-semibold text-[var(--mentor-primary)]">{{ $assessment->passing_grade }}</div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-[var(--mentor-primary-soft-2)] p-4">
                <div class="text-xs text-[color:color-mix(in_oklab,#004777_60%,white)]">Questions</div>
                <div class="mt-1 font-semibold text-[var(--mentor-primary)]">{{ $assessment->question_limit ?? 'All' }}</div>
            </div>
        </div>
    @else
        <div class="mt-4 rounded-xl border border-dashed border-slate-200 bg-[var(--mentor-primary-soft-2)] p-5 text-sm text-[color:color-mix(in_oklab,#004777_70%,white)]">
            Assessment belum tersedia.
        </div>
    @endif
</section>
