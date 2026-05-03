<div
    wire:key="assessment-{{ $attempt->id }}"
    x-data="assessmentApp(
        @js($answers),
        {{ $timeLimit ?? 'null' }},
        {{ $startedAt ?? 'null' }},
        'assessment-answers-{{ $attempt->id }}',
        {{ $currentIndex }},
        {{ $questions->count() }}
    )"
    x-init="init()"
    x-on:keydown.window.escape="openSubmit = false"
    class="max-w-6xl mx-auto space-y-6 p-4 sm:p-6"
>

<style>[x-cloak]{display:none!important}</style>

<section class="rounded-3xl bg-white border p-6 shadow-sm">
    <div class="flex justify-between items-start gap-4">
        <div>
            <h1 class="text-2xl font-bold">{{ $assessment->title }}</h1>
            <p class="text-sm text-slate-500">{{ $assessment->topic?->name }}</p>
        </div>

        <div class="text-right">
            <div class="text-xs uppercase tracking-wide text-slate-400" x-show="timeLeft !== null">Sisa waktu</div>
            <div class="text-red-600 font-semibold text-lg" x-show="timeLeft !== null">
                <span x-text="formatTime(timeLeft)"></span>
            </div>
        </div>
    </div>
</section>

<section class="grid grid-cols-1 xl:grid-cols-[260px_1fr] gap-6">

    <aside class="bg-white border rounded-3xl p-4 h-fit sticky top-24">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold">Navigator</h2>
            <span class="text-xs text-slate-500">
                <span x-text="answeredCount()"></span> / {{ $questions->count() }}
            </span>
        </div>

        <div class="grid grid-cols-5 gap-2">
            @foreach($questions as $i => $q)
                <button
                    type="button"
                    @click="goTo({{ $i }})"
                    :class="{
                        'bg-black text-white border-black': currentIndex === {{ $i }},
                        'bg-green-100 border-green-300': currentIndex !== {{ $i }} && !!answers['{{ $q->id }}'],
                        'bg-white': currentIndex !== {{ $i }} && !answers['{{ $q->id }}']
                    }"
                    class="h-10 border rounded-xl text-sm transition"
                >
                    {{ $i + 1 }}
                </button>
            @endforeach
        </div>
    </aside>

    <main class="space-y-4">

        @php $q = $questions->get($currentIndex); @endphp

        @if($q)
            <div class="bg-white border rounded-3xl p-6 space-y-4">
                <div class="flex items-start justify-between gap-4">
                    <h2 class="text-lg font-semibold">
                        {{ $currentIndex + 1 }}. {{ $q->question }}
                    </h2>

                    <span
                        class="text-xs font-medium px-2 py-1 rounded-full bg-slate-100 text-slate-600"
                        x-show="answers['{{ $q->id }}']"
                    >
                        Sudah dijawab
                    </span>
                </div>

                @if($q->question_type === 'mcq')
                    <div class="space-y-3">
                        @foreach($q->options as $opt)
                            <label class="flex gap-3 border p-3 rounded-xl cursor-pointer hover:bg-slate-50">
                                <input
                                    type="radio"
                                    name="question_{{ $q->id }}"
                                    class="mt-1"
                                    :checked="String(answers['{{ $q->id }}'] ?? '') === '{{ $opt->id }}'"
                                    @change="setAnswer('{{ $q->id }}', '{{ $opt->id }}')"
                                >
                                <span>{{ $opt->option_text }}</span>
                            </label>
                        @endforeach
                    </div>
                @else
                    <textarea
                        class="w-full border rounded-xl p-3 min-h-40 focus:outline-none focus:ring-2 focus:ring-black/10"
                        x-model="answers['{{ $q->id }}']"
                        @input="setAnswer('{{ $q->id }}', $event.target.value)"
                    ></textarea>
                @endif
            </div>

            <div class="flex justify-between">
                <button
                    type="button"
                    @click="prev()"
                    :disabled="currentIndex === 0 || submitting"
                    class="px-4 py-2 border rounded-xl disabled:opacity-50"
                >
                    Prev
                </button>

                <button
                    type="button"
                    @click="next()"
                    :disabled="currentIndex >= {{ $questions->count() - 1 }} || submitting"
                    class="px-4 py-2 border rounded-xl disabled:opacity-50"
                >
                    Next
                </button>
            </div>

            <div class="flex justify-end">
                <button
                    type="button"
                    @click="openSubmit = true"
                    class="px-5 py-3 bg-black text-white rounded-xl"
                >
                    Submit
                </button>
            </div>
        @else
            <div class="bg-white border rounded-2xl p-6 text-center text-slate-500">
                Question not found.
            </div>
        @endif

    </main>
</section>

<div
    x-show="openSubmit"
    x-cloak
    class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50"
>
    <div
        class="bg-white p-6 rounded-2xl space-y-4 w-full max-w-md shadow-xl"
        @click.outside="openSubmit = false"
    >
        <h3 class="font-semibold text-lg">Submit?</h3>
        <p class="text-sm text-slate-600">
            Setelah dikirim, jawaban tidak bisa diubah lagi.
        </p>

        <div class="flex justify-end gap-2">
            <button
                type="button"
                @click="openSubmit = false"
                class="border px-4 py-2 rounded-xl"
            >
                Cancel
            </button>

            <button
                type="button"
                :disabled="submitting"
                @click="submitNow()"
                class="bg-black text-white px-4 py-2 rounded-xl disabled:opacity-50"
            >
                <span x-show="!submitting">Submit</span>
                <span x-show="submitting">Sending...</span>
            </button>
        </div>
    </div>
</div>

</div>