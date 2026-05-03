<div class="space-y-6">
    <section class="rounded-3xl overflow-hidden bg-white border">
        <div class="grid grid-cols-1 xl:grid-cols-2">
            <div class="p-6 sm:p-8 xl:p-10 space-y-5">
                <div class="flex items-center justify-between gap-4">
                    <div class="text-xs uppercase tracking-wide text-slate-400">
                        {{ $course->studyProgram?->title }}
                    </div>

                    @if($courseCertificate)
                        <a href="{{ route('certificates.download', $courseCertificate->id) }}"
                           class="inline-flex px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-medium">
                            View Certificate
                        </a>
                    @else
                        <a href="{{ route('certificates.course.claim', $course->id) }}"
                           class="inline-flex px-4 py-2 rounded-xl border border-slate-200 text-slate-700 text-sm font-medium">
                            Claim Certificate
                        </a>
                    @endif
                </div>

                <h1 class="text-3xl sm:text-4xl font-bold leading-tight">{{ $course->title }}</h1>

                <p class="text-slate-600 leading-relaxed max-w-2xl">
                    {{ $course->description }}
                </p>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="rounded-2xl border bg-slate-50 p-4">
                        <div class="text-xs text-slate-500">Topics</div>
                        <div class="text-xl font-semibold mt-1">{{ $course->topics->count() }}</div>
                    </div>
                    <div class="rounded-2xl border bg-slate-50 p-4">
                        <div class="text-xs text-slate-500">Credit</div>
                        <div class="text-xl font-semibold mt-1">{{ $course->credit }}</div>
                    </div>
                    <div class="rounded-2xl border bg-slate-50 p-4">
                        <div class="text-xs text-slate-500">Quota</div>
                        <div class="text-xl font-semibold mt-1">{{ $course->quota }}</div>
                    </div>
                    <div class="rounded-2xl border bg-slate-50 p-4">
                        <div class="text-xs text-slate-500">Status</div>
                        <div class="text-xl font-semibold mt-1">{{ ucfirst($course->status) }}</div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 pt-1">
                    @if($enrolled)
                        <span class="inline-flex px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-medium">
                            Enrolled
                        </span>
                    @else
                        <button wire:click="enroll"
                                class="px-5 py-3 rounded-xl bg-slate-900 text-white text-sm font-medium">
                            Enroll now
                        </button>
                    @endif

                    <a href="#topics"
                       class="px-5 py-3 rounded-xl border border-slate-200 text-sm font-medium text-slate-700">
                        View Topics
                    </a>
                </div>
            </div>

            <div class="bg-slate-100 aspect-[16/10]">
                <img src="{{ asset('storage/' . $course->poster) }}"
                     class="w-full h-full object-cover"
                     alt="{{ $course->title }}">
            </div>
        </div>
    </section>

    <section id="topics" class="space-y-4">
        <div class="flex items-end justify-between">
            <div>
                <h2 class="text-xl font-semibold">Topics</h2>
                <p class="text-sm text-slate-500">Setiap topik ditampilkan dengan progress dan status yang jelas.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($course->topics as $topic)
                @php
                    $status = $topicStatusMap[$topic->id] ?? 'not_started';
                    $percent = match($status) {
                        'completed' => 100,
                        'in_progress' => 50,
                        default => 0
                    };

                    $certificate = $topicCertificates[$topic->id] ?? null;
                @endphp

                <div class="rounded-2xl bg-white border p-5 space-y-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="font-semibold text-lg">{{ $topic->name }}</h3>
                            <p class="text-sm text-slate-500 mt-1">{{ $topic->description }}</p>
                        </div>

                        <span class="text-xs px-2 py-1 rounded-full bg-slate-100">
                            {{ strtoupper($status) }}
                        </span>
                    </div>

                    <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-2 rounded-full bg-slate-900" style="width: {{ $percent }}%"></div>
                    </div>

                    <div class="grid grid-cols-3 gap-2 text-sm">
                        <div class="rounded-xl border p-3 text-center">
                            <div class="font-semibold">{{ $topic->materials->count() }}</div>
                            <div class="text-xs text-slate-500">Materials</div>
                        </div>
                        <div class="rounded-xl border p-3 text-center">
                            <div class="font-semibold">{{ $topic->sessions->count() }}</div>
                            <div class="text-xs text-slate-500">Sessions</div>
                        </div>
                        <div class="rounded-xl border p-3 text-center">
                            <div class="font-semibold">{{ $topic->assessments->count() }}</div>
                            <div class="text-xs text-slate-500">Tests</div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('topics.show', $topic->slug) }}"
                               class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm">
                                Open Topic
                            </a>

                            @if($certificate)
                                <a href="{{ route('certificates.download', $certificate['id']) }}"
                                   class="px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-sm">
                                    View Certificate
                                </a>
                            @elseif($status === 'completed')
                                <a href="{{ route('certificates.topic.claim', $topic->id) }}"
                                   class="px-4 py-2 rounded-xl border border-slate-200 text-slate-700 text-sm">
                                    Claim Certificate
                                </a>
                            @else
                                <span class="px-4 py-2 rounded-xl border border-slate-200 text-slate-400 text-sm">
                                    Certificate Pending
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <x-ui.empty-state
                    title="Belum ada topic"
                    description="Course ini belum memiliki topic."
                />
            @endforelse
        </div>
    </section>
</div>