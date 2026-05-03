<div class="min-h-screen bg-white">
    <section class="px-6 py-20 bg-gradient-to-br from-purple-50 via-white to-blue-50">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div class="space-y-6">
                <span class="inline-flex px-3 py-1 rounded-full bg-black text-white text-xs tracking-wide">
                    Learning Management System
                </span>

                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    Pembelajaran gereja yang rapi, interaktif, dan terukur.
                </h1>

                <p class="text-gray-600 text-lg leading-relaxed">
                    Course, topic, material, attendance, post-test, certificate, dan progress tracking
                    dalam satu platform web.
                </p>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('courses.index') }}"
                       class="px-5 py-3 rounded-lg bg-black text-white">
                        Explore Courses
                    </a>

                    <a href="{{ route('dashboard') }}"
                       class="px-5 py-3 rounded-lg border border-gray-300">
                        Go to Dashboard
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="rounded-2xl bg-white shadow p-5 border">
                    <p class="text-sm text-gray-500">Course</p>
                    <p class="text-2xl font-bold">{{ $courses->count() }}</p>
                </div>
                <div class="rounded-2xl bg-white shadow p-5 border">
                    <p class="text-sm text-gray-500">Article</p>
                    <p class="text-2xl font-bold">{{ $articles->count() }}</p>
                </div>
                <div class="rounded-2xl bg-white shadow p-5 border">
                    <p class="text-sm text-gray-500">Attendance</p>
                    <p class="text-2xl font-bold">Live</p>
                </div>
                <div class="rounded-2xl bg-white shadow p-5 border">
                    <p class="text-sm text-gray-500">Certificate</p>
                    <p class="text-2xl font-bold">Auto</p>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 py-16">
        <div class="flex items-end justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold">Featured Courses</h2>
                <p class="text-gray-500">Kursus yang tersedia saat ini.</p>
            </div>
            <a href="{{ route('courses.index') }}" class="text-sm underline">
                See all
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @forelse($courses as $course)
                <div class="rounded-2xl border bg-white p-5 shadow-sm space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="font-semibold text-lg">{{ $course->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $course->studyProgram?->title }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full bg-gray-100">
                            {{ $course->status }}
                        </span>
                    </div>

                    <p class="text-sm text-gray-600">
                        {{ \Illuminate\Support\Str::limit($course->description, 120) }}
                    </p>

                    <a href="{{ route('courses.show', $course->slug) }}"
                       class="inline-flex text-sm font-medium underline">
                        Open course
                    </a>
                </div>
            @empty
                <div class="col-span-full text-gray-500">
                    Belum ada course aktif.
                </div>
            @endforelse
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 py-16 border-t">
        <div class="flex items-end justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold">Latest Articles</h2>
                <p class="text-gray-500">Informasi dan pengumuman terbaru.</p>
            </div>
            <a href="{{ route('articles.index') }}" class="text-sm underline">
                See all
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @forelse($articles as $article)
                <article class="rounded-2xl border bg-white p-5 shadow-sm space-y-3">
                    <h3 class="font-semibold text-lg">{{ $article->title }}</h3>
                    <p class="text-sm text-gray-500">By {{ $article->author }}</p>
                    <p class="text-sm text-gray-600">
                        {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 120) }}
                    </p>
                </article>
            @empty
                <div class="col-span-full text-gray-500">
                    Belum ada artikel aktif.
                </div>
            @endforelse
        </div>
    </section>
</div>