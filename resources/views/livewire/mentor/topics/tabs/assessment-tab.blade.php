<section class="mentor-workspace-panel">
    <h2 class="mentor-workspace-heading">Assessment</h2>
    <p class="mentor-workspace-subheading">Ringkasan singkat assessment pada course ini.</p>

    @if($assessment)
        <div class="mt-4 grid grid-cols-1 gap-3 text-sm sm:grid-cols-4">
            <div class="mentor-workspace-card p-4">
                <div class="text-xs text-[color:color-mix(in_oklab,#004777_60%,white)]">Title</div>
                <div class="mt-1 font-semibold text-[var(--mentor-primary)]">{{ $assessment->title }}</div>
            </div>
            <div class="mentor-workspace-card p-4">
                <div class="text-xs text-[color:color-mix(in_oklab,#004777_60%,white)]">Passing Grade</div>
                <div class="mt-1 font-semibold text-[var(--mentor-primary)]">{{ $assessment->passing_grade }}</div>
            </div>
            <div class="mentor-workspace-card p-4">
                <div class="text-xs text-[color:color-mix(in_oklab,#004777_60%,white)]">Questions</div>
                <div class="mt-1 font-semibold text-[var(--mentor-primary)]">{{ $assessment->question_limit ?? 'All' }}</div>
            </div>
        </div>
    @else
        <div class="mentor-workspace-empty mt-4">
            Assessment belum tersedia.
        </div>
    @endif
</section>
