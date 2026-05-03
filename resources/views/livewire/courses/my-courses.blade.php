<div class="space-y-6">
    <x-ui.page-header
        title="My Courses"
        subtitle="Daftar kursus yang sudah kamu ikuti."
    />

    <div class="rounded-2xl bg-white border p-4">
        <input type="search"
               wire:model.debounce.300ms="search"
               placeholder="Cari course yang sudah diikuti..."
               class="w-full md:w-1/2 border rounded-xl px-4 py-2">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($enrollments as $row)
            <div class="rounded-2xl bg-white border overflow-hidden flex flex-col">
                <div class="aspect-[16/9] bg-slate-100">
                    <img src="{{ asset('storage/' . $row['enrollment']->course?->poster) }}"
                         class="w-full h-full object-cover"
                         alt="{{ $row['enrollment']->course?->title }}">
                </div>

                <div class="p-5 space-y-4 flex-1 flex flex-col">
                    <div>
                        <div class="text-xs uppercase tracking-wide text-slate-400">
                            {{ $row['enrollment']->course?->studyProgram?->title }}
                        </div>
                        <h3 class="text-lg font-semibold mt-1">
                            {{ $row['enrollment']->course?->title }}
                        </h3>
                        <p class="text-sm text-slate-600 mt-2">
                            {{ \Illuminate\Support\Str::limit($row['enrollment']->course?->description, 120) }}
                        </p>
                    </div>

                    <div class="grid grid-cols-3 gap-2 text-sm">
                        <div class="rounded-xl border p-3 text-center">
                            <div class="font-semibold">{{ $row['percent'] }}%</div>
                            <div class="text-xs text-slate-500">Progress</div>
                        </div>
                        <div class="rounded-xl border p-3 text-center">
                            <div class="font-semibold">{{ $row['completedTopics'] }}</div>
                            <div class="text-xs text-slate-500">Done</div>
                        </div>
                        <div class="rounded-xl border p-3 text-center">
                            <div class="font-semibold">{{ $row['totalTopics'] }}</div>
                            <div class="text-xs text-slate-500">Topics</div>
                        </div>
                    </div>

                    <div class="mt-auto flex items-center justify-between gap-3">
                        <a href="{{ route('courses.show', $row['enrollment']->course?->slug) }}"
                           class="inline-flex px-4 py-2 rounded-xl bg-slate-900 text-white text-sm">
                            Open
                        </a>

                        <span class="text-xs px-3 py-2 rounded-xl bg-emerald-50 text-emerald-700">
                            Enrolled
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <x-ui.empty-state
                title="Belum ada course"
                description="Kamu belum mengikuti course apa pun."
                button-label="Back to Explore"
                button-href="{{ route('dashboard') }}"
            />
        @endforelse
    </div>

    <div>{{ $enrollments->links() }}</div>
</div>