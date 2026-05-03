<div class="space-y-5">
    <x-ui.page-header
        title="Course Catalog"
        subtitle="Pencarian dan filter mendalam untuk menemukan course yang paling relevan."
    />

    <div class="rounded-2xl bg-white border p-4 space-y-3">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div>
                <input type="search"
                       wire:model.debounce.300ms="search"
                       placeholder="Cari course..."
                       class="w-full border rounded-xl px-4 py-2">
            </div>

            <div>
                <select wire:model="studyProgram" class="w-full border rounded-xl px-4 py-2">
                    <option value="">Semua study program</option>
                    @foreach($studyPrograms as $sp)
                        <option value="{{ $sp->slug }}">{{ $sp->title }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <select wire:model="level" class="w-full border rounded-xl px-4 py-2">
                    <option value="">Semua level</option>
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
            </div>

            <div>
                <select wire:model="sort" class="w-full border rounded-xl px-4 py-2">
                    <option value="latest">Newest</option>
                    <option value="title">Title</option>
                    <option value="topics">Most topics</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <select wire:model="perPage" class="border rounded-xl px-4 py-2">
                <option value="9">9 / halaman</option>
                <option value="12">12 / halaman</option>
                <option value="24">24 / halaman</option>
            </select>
        </div>
    </div>

    <div wire:loading.class="opacity-60" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($courses as $course)
            @php $enrolled = in_array($course->id, $enrolledCourseIds, true); @endphp

            <div class="rounded-2xl bg-white border overflow-hidden flex flex-col">
                <div class="aspect-[16/9] bg-slate-100">
                    <img src="{{ asset('storage/' . $course->poster) }}"
                         class="h-full w-full object-cover"
                         alt="{{ $course->title }}">
                </div>

                <div class="p-5 flex-1 flex flex-col gap-3">
                    <div>
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="font-semibold text-lg">{{ $course->title }}</h3>
                                <p class="text-sm text-slate-500">{{ $course->studyProgram?->title }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full bg-slate-100">
                                {{ $course->topics_count }} topics
                            </span>
                        </div>

                        <p class="text-sm text-slate-600 mt-3">
                            {{ \Illuminate\Support\Str::limit($course->description, 120) }}
                        </p>
                    </div>

                    <div class="mt-auto flex items-center justify-between gap-3">
                        <a href="{{ route('courses.show', $course->slug) }}" class="text-sm underline">
                            Open
                        </a>

                        @if($enrolled)
                            <span class="text-xs px-3 py-2 rounded-xl bg-emerald-50 text-emerald-700">
                                Enrolled
                            </span>
                        @else
                            <button wire:click="enroll('{{ $course->id }}')"
                                    class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm">
                                Enroll
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <x-ui.empty-state
                title="Course tidak ditemukan"
                description="Coba ubah filter atau kata kunci pencarian."
            />
        @endforelse
    </div>

    <div>{{ $courses->links() }}</div>
</div>