@php
    $score = (float) ($attempt->score ?? 0);
    $passingGrade = (float) ($assessment?->passing_grade ?? 0);
    $totalQuestions = max(
        (int) ($attempt->total_questions ?? 0),
        $correctAnswers + $wrongAnswers + $unansweredQuestions
    );
    $scoreWidth = min(100, max(0, $score));
@endphp

<div class="min-h-screen bg-white px-4 pb-16 pt-8 text-[#0f172a] sm:px-6 sm:pb-24 sm:pt-12 lg:px-8">
    <main class="mx-auto max-w-5xl space-y-6">
        <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white">
            <div class="border-b border-slate-200 bg-[#eef8ff] px-6 py-8 sm:px-10 sm:py-10">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#35A7FF]">
                            {{ __('general.assessment_result.title') }}
                        </p>
                        <h1 class="mt-3 text-2xl font-bold leading-tight text-[#004777] sm:text-4xl">
                            {{ $assessment?->title ?? __('general.assessment_result.default_title') }}
                        </h1>
                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            {{ __('general.assessment_result.course', [
                                'course' => $assessment?->course?->title ?? '-',
                            ]) }}
                        </p>
                    </div>

                    <span class="inline-flex w-fit rounded-full px-4 py-2 text-xs font-bold uppercase tracking-wide {{ $attempt->passed ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                        {{ $attempt->passed ? __('general.assessment_result.status.passed') : __('general.assessment_result.status.failed') }}
                    </span>
                </div>
            </div>

            <div class="grid gap-8 p-6 sm:p-10 lg:grid-cols-[0.85fr_1.15fr]">
                <div class="flex flex-col items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 px-6 py-8 text-center">
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        {{ __('general.assessment_result.metrics.score') }}
                    </p>
                    <div class="mt-3 text-6xl font-bold leading-none text-[#004777] sm:text-7xl">
                        {{ number_format($score, 0) }}
                    </div>
                    <p class="mt-3 text-sm text-slate-500">
                        {{ __('general.assessment_result.metrics.passing_grade') }}: {{ number_format($passingGrade, 0) }}%
                    </p>

                    <div class="mt-6 h-2.5 w-full overflow-hidden rounded-full bg-slate-200">
                        <div class="h-full rounded-full {{ $attempt->passed ? 'bg-emerald-500' : 'bg-rose-500' }}"
                             style="width: {{ $scoreWidth }}%"></div>
                    </div>
                </div>

                <div class="space-y-5">
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <p class="text-xs font-semibold text-slate-500">{{ __('general.assessment_result.metrics.questions') }}</p>
                            <p class="mt-2 text-2xl font-bold text-[#004777]">{{ $totalQuestions }}</p>
                        </div>
                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4">
                            <p class="text-xs font-semibold text-emerald-700">{{ __('general.assessment_result.metrics.correct') }}</p>
                            <p class="mt-2 text-2xl font-bold text-emerald-700">{{ $correctAnswers }}</p>
                        </div>
                        <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4">
                            <p class="text-xs font-semibold text-rose-700">{{ __('general.assessment_result.metrics.wrong') }}</p>
                            <p class="mt-2 text-2xl font-bold text-rose-700">{{ $wrongAnswers }}</p>
                        </div>
                    </div>

                    <div class="rounded-2xl border p-5 {{ $attempt->passed ? 'border-emerald-200 bg-emerald-50' : 'border-rose-200 bg-rose-50' }}">
                        <h2 class="font-bold {{ $attempt->passed ? 'text-emerald-800' : 'text-rose-800' }}">
                            {{ $attempt->passed ? __('general.assessment_result.notice.passed') : __('general.assessment_result.notice.failed') }}
                        </h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            {{ $attempt->passed
                                ? __('general.assessment_result.notice.passed_description')
                                : __('general.assessment_result.notice.failed_description') }}
                        </p>
                    </div>

                    <dl class="divide-y divide-slate-200 rounded-2xl border border-slate-200 px-5 text-sm">
                        <div class="flex items-center justify-between gap-4 py-4">
                            <dt class="text-slate-500">{{ __('general.assessment_result.metrics.submitted_at') }}</dt>
                            <dd class="text-right font-semibold text-[#004777]">
                                {{ $attempt->submitted_at?->format('d M Y, H:i') ?? '-' }}
                            </dd>
                        </div>
                        <div class="flex items-center justify-between gap-4 py-4">
                            <dt class="text-slate-500">{{ __('general.assessment_result.metrics.passing_grade') }}</dt>
                            <dd class="font-semibold text-[#004777]">{{ number_format($passingGrade, 0) }}%</dd>
                        </div>
                        @if($certificate)
                            <div class="flex items-center justify-between gap-4 py-4">
                                <dt class="text-slate-500">{{ __('general.assessment_result.certificate.title') }}</dt>
                                <dd class="break-all text-right font-semibold text-[#004777]">
                                    {{ $certificate->certificate_number }}
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 px-6 py-5 sm:flex-row sm:justify-end sm:px-10">
                <a href="{{ localized_route('learning.dashboard') }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-[#004777] transition hover:bg-slate-50">
                    {{ __('general.assessment_result.actions.back_to_learning') }}
                </a>

                @if($assessment?->course?->slug)
                    <a href="{{ localized_route('courses.show', $assessment->course->slug) }}"
                       class="inline-flex items-center justify-center rounded-xl bg-[#004777] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#00395f]">
                        {{ __('general.assessment_result.actions.back_to_course') }}
                    </a>
                @endif
            </div>
        </section>
    </main>
</div>
