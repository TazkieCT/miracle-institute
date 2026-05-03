<div class="space-y-8">
    <section class="rounded-3xl overflow-hidden bg-slate-900 text-white">
        <div class="grid grid-cols-1 xl:grid-cols-2">
            <div class="p-8 sm:p-10 xl:p-12 space-y-5">
                <span class="inline-flex px-3 py-1 rounded-full bg-white/10 text-xs">
                    Explore Learning
                </span>

                <h1 class="text-3xl sm:text-4xl xl:text-5xl font-bold leading-tight">
                    Temukan course, topik, dan progres belajar kamu dalam satu tempat.
                </h1>

                <p class="text-slate-300 max-w-xl">
                    Halaman ini adalah pintu masuk discovery: lihat promosi, kategori, dan highlight course paling relevan.
                </p>

                <div class="flex flex-wrap gap-3 pt-2">
                    <a href="{{ route('courses.index') }}" class="px-5 py-3 rounded-xl bg-white text-slate-900 text-sm font-medium">
                        Browse Courses
                    </a>
                    <a href="{{ route('learning.dashboard') }}" class="px-5 py-3 rounded-xl border border-white/20 text-sm font-medium">
                        My Learning
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 p-8 sm:p-10 xl:p-12 bg-white/5">
                <div class="rounded-2xl bg-white/10 p-5">
                    <div class="text-sm text-slate-300">Active Courses</div>
                    <div class="text-3xl font-bold mt-2">{{ $featured->count() }}</div>
                </div>
                <div class="rounded-2xl bg-white/10 p-5">
                    <div class="text-sm text-slate-300">Study Programs</div>
                    <div class="text-3xl font-bold mt-2">{{ $studyPrograms->count() }}</div>
                </div>
                <div class="rounded-2xl bg-white/10 p-5 col-span-2">
                    <div class="text-sm text-slate-300">Learning Mode</div>
                    <div class="text-xl font-semibold mt-2">{{ ucfirst(session('active_role') ?? 'student') }}</div>
                </div>
            </div>
        </div>
    </section>

    <section class="space-y-4">
        <div class="flex items-end justify-between">
            <div>
                <h2 class="text-xl font-semibold">Categories</h2>
                <p class="text-sm text-slate-500">Explore based on study program.</p>
            </div>
            <a href="{{ route('courses.index') }}" class="text-sm underline">Open course catalog</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach($studyPrograms as $sp)
                <a href="{{ route('courses.index', ['studyProgram' => $sp->slug]) }}"
                   class="rounded-2xl bg-white border p-5 hover:border-slate-400 transition">
                    <div class="font-semibold">{{ $sp->title }}</div>
                    <div class="text-sm text-slate-500 mt-1">{{ \Illuminate\Support\Str::limit($sp->description, 70) }}</div>
                </a>
            @endforeach
        </div>
    </section>

    <section class="space-y-4">
        <div>
            <h2 class="text-xl font-semibold">Highlights</h2>
            <p class="text-sm text-slate-500">Featured courses curated for discovery.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($featured as $course)
                <div class="rounded-2xl bg-white border overflow-hidden">
                    <div class="aspect-[16/9] bg-slate-100">
                        <img src="{{ asset('storage/' . $course->poster) }}" class="w-full h-full object-cover" alt="{{ $course->title }}">
                    </div>
                    <div class="p-5 space-y-3">
                        <div>
                            <div class="text-xs uppercase tracking-wide text-slate-400">{{ $course->studyProgram?->title }}</div>
                            <h3 class="font-semibold text-lg">{{ $course->title }}</h3>
                            <p class="text-sm text-slate-600 mt-2">
                                {{ \Illuminate\Support\Str::limit($course->description, 110) }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <span>{{ $course->topics_count }} topics</span>
                            <a href="{{ route('courses.show', $course->slug) }}" class="underline">Open</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="space-y-4">
        <div class="flex items-end justify-between">
            <div>
                <h2 class="text-xl font-semibold">Explore all courses</h2>
                <p class="text-sm text-slate-500">Continue browsing below.</p>
            </div>
        </div>

        <div class="rounded-2xl bg-white border p-4">
            <a href="{{ route('courses.index') }}" class="inline-flex px-4 py-2 rounded-xl bg-slate-900 text-white text-sm">
                Open Course Catalog
            </a>
        </div>
    </section>
</div>