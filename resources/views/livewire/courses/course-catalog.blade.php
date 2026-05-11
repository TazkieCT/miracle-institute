@php
    use Illuminate\Support\Str;

    $isMentor = session('active_role') === 'disciples';
@endphp

<div class="space-y-6 lg:px-20 2xl:px-28 origin-top">

    {{-- HEADER --}}
    <section class="rounded-[2rem] border border-[#004777]/10 bg-white overflow-hidden">
        <div class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr] p-7 xl:p-8">

            {{-- LEFT --}}
            <div class="space-y-5">

                <div class="space-y-3">

                    <h1 class="max-w-3xl text-3xl xl:text-4xl font-bold tracking-tight text-[#004777] leading-tight">
                        {{ $isMentor
                            ? 'Guide, mentor, and oversee discipleship learning journeys.'
                            : 'Grow through structured discipleship learning and mentoring.' }}
                    </h1>

                    <p class="max-w-2xl text-sm leading-7 text-[#004777]/70">
                        {{ $isMentor
                            ? 'Kelola course pemuridan, pantau topic pembelajaran, dan bimbing peserta melalui materi yang terstruktur.'
                            : 'Pelajari materi pemuridan secara sistematis melalui topic, mentoring session, assessment, dan progress learning.' }}
                    </p>

                </div>

                {{-- STATS --}}
                <div class="flex flex-wrap gap-3 text-sm">

                    <div class="rounded-2xl border border-[#004777]/10 bg-[#35A7FF]/8 px-5 py-3">
                        <div class="text-[11px] uppercase tracking-wide text-[#004777]/70">
                            Available Courses
                        </div>

                        <div class="mt-1 text-xl font-bold text-[#004777]">
                            {{ $courses->total() }}
                        </div>
                    </div>

                    <div class="rounded-2xl border border-[#004777]/10 bg-[#35A7FF]/8 px-5 py-3">
                        <div class="text-[11px] uppercase tracking-wide text-[#004777]/70">
                            Study Programs
                        </div>

                        <div class="mt-1 text-xl font-bold text-[#004777]">
                            {{ $studyPrograms->count() }}
                        </div>
                    </div>

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="rounded-[2rem] border border-[#004777]/10 bg-gradient-to-br from-[#004777] via-[#00365E] to-[#003050] p-6 text-white flex flex-col justify-between">

                <div>
                    <h2 class="mt-3 text-2xl font-bold leading-tight">
                        Learning centered on spiritual growth, mentoring, and consistency.
                    </h2>

                    <p class="mt-3 text-sm leading-6 text-white/75">
                        Setiap course dirancang untuk membantu peserta memahami materi pemuridan secara bertahap melalui pembelajaran terstruktur dan pendampingan mentor.
                    </p>
                </div>

                <div class="mt-7 grid grid-cols-2 gap-3">

                    <div class="rounded-2xl border border-white/10 bg-[#35A7FF]/20 p-4">
                        <div class="text-[11px] text-white/70">
                            Structured
                        </div>

                        <div class="mt-1 text-lg font-bold">
                            Learning Topics
                        </div>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-[#35A7FF]/20 p-4">
                        <div class="text-[11px] text-white/70">
                            Guided
                        </div>

                        <div class="mt-1 text-lg font-bold">
                            Mentoring System
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>

    {{-- FILTER --}}
    <section class="rounded-[2rem] border border-[#004777]/10 bg-white p-5">
        <div class="grid gap-4 lg:grid-cols-4">

            <div class="lg:col-span-2">
                <input type="search"
                       wire:model.debounce.300ms="search"
                       placeholder="Search course, topic, or keyword..."
                       class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 text-sm outline-none transition focus:border-slate-400 focus:bg-white">
            </div>

            <select wire:model="studyProgram"
                    class="h-12 rounded-2xl border border-[#004777]/15 bg-[#f4faff] px-4 text-sm outline-none focus:border-[#35A7FF] focus:bg-white">
                <option value="">All Study Programs</option>

                @foreach($studyPrograms as $sp)
                    <option value="{{ $sp->slug }}">
                        {{ $sp->title }}
                    </option>
                @endforeach
            </select>

            <div class="grid grid-cols-2 gap-3">

                <select wire:model="sort"
                        class="h-12 rounded-2xl border border-[#004777]/15 bg-[#f4faff] px-4 text-sm outline-none focus:border-[#35A7FF] focus:bg-white">
                    <option value="latest">Newest</option>
                    <option value="title">Title</option>
                    <option value="topics">Most Topics</option>
                </select>

                <select wire:model="perPage"
                        class="h-12 rounded-2xl border border-[#004777]/15 bg-[#f4faff] px-4 text-sm outline-none focus:border-[#35A7FF] focus:bg-white">
                    <option value="8">8</option>
                    <option value="12">12</option>
                    <option value="24">24</option>
                </select>

            </div>

        </div>
    </section>

    {{-- COURSE GRID --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4">

        @forelse($courses as $course)

            @php
                $enrolled = in_array($course->id, $enrolledCourseIds, true);
            @endphp

            <article class="group overflow-hidden rounded-2xl transition hover:bg-[#35A7FF]/8 border border-[#004777]/10 bg-white flex h-full flex-col">

                {{-- IMAGE (dashboard card style) --}}
                <div class="p-2.5">
                    <div class="relative overflow-hidden rounded-lg thumb">
                        @php
                            $poster = $course->poster ?? null;
                        @endphp

                        @if(!empty($poster))
                            <img src="{{ $poster }}"
                                 alt="{{ $course->title }}"
                                 class="h-32 w-full object-cover sm:h-36 transition duration-500 group-hover:scale-105">
                        @elseif(!empty($course->image))
                            <img src="{{ asset('storage/' . $course->image) }}"
                                 alt="{{ $course->title }}"
                                 class="h-32 w-full object-cover sm:h-36 transition duration-500 group-hover:scale-105">
                        @else
                            <div class="flex h-32 w-full items-center justify-center bg-slate-200 sm:h-36">
                                <svg width="100" height="56" viewBox="0 0 280 158" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="280" height="158" fill="#e6e9ee"/>
                                </svg>
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/5 to-transparent"></div>

                        <div class="absolute left-3 top-3">
                            <span class="inline-flex rounded-full border border-white/20 bg-[#35A7FF]/30 px-2.5 py-1 text-[10px] font-medium text-white backdrop-blur">
                                {{ $course->studyProgram?->title }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- BODY --}}
                <div class="flex flex-1 flex-col p-4">

                    <div class="flex-1 space-y-3">

                        <div class="space-y-1.5 min-h-[76px]">
                            <h3 class="line-clamp-2 text-[15px] font-bold leading-snug text-[#004777]">
                                {{ $course->title }}
                            </h3>

                            <p class="line-clamp-2 text-xs leading-5 text-[#004777]/70">
                                {{ $course->description ?: 'No description available for this course.' }}
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-1.5 text-[11px]">

                            <span class="rounded-full border border-[#004777]/15 bg-[#35A7FF]/10 px-2.5 py-1 text-[#004777]">
                                {{ $course->topics_count }} Topics
                            </span>

                            <span class="rounded-full border border-[#004777]/15 bg-[#35A7FF]/10 px-2.5 py-1 text-[#004777]">
                                {{ ucfirst($course->status) }}
                            </span>

                            @if($enrolled)
                                <span class="rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-emerald-700">
                                    Enrolled
                                </span>
                            @endif

                        </div>

                    </div>

                    {{-- ACTIONS --}}
                    <div class="mt-4 flex items-center gap-2">

                        <a href="{{ route('courses.show', $course->slug) }}"
                        class="inline-flex flex-1 items-center justify-center rounded-xl bg-[#004777] px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-[#004777]/90">
                            Open
                        </a>

                        @if($isMentor)

                            <a href="{{ route('mentor.topics.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-[#004777]/15 px-4 py-2.5 text-xs font-medium text-[#004777] transition hover:bg-[#35A7FF]/10">
                                Manage
                            </a>

                        @else

                            @auth

                                @unless($enrolled)

                                    <button wire:click="enroll('{{ $course->id }}')"
                                            class="inline-flex items-center justify-center rounded-xl border border-[#004777]/15 px-4 py-2.5 text-xs font-medium text-[#004777] transition hover:bg-[#35A7FF]/10">
                                        Enroll
                                    </button>

                                @endunless

                            @else

                                <a href="{{ route('login') }}"
                                class="inline-flex items-center justify-center rounded-xl border border-[#004777]/15 px-4 py-2.5 text-xs font-medium text-[#004777] transition hover:bg-[#35A7FF]/10">
                                    Login
                                </a>

                            @endauth

                        @endif

                    </div>

                </div>

            </article>

        @empty

            <div class="col-span-full">
                <div class="rounded-[2rem] border border-dashed border-[#004777]/20 bg-white px-8 py-20 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#35A7FF]/10">
                        <svg class="h-8 w-8 text-[#004777]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M9.75 9.75h4.5m-4.5 4.5h4.5M6.75 3.75h10.5A2.25 2.25 0 0119.5 6v12a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 18V6a2.25 2.25 0 012.25-2.25z"/>
                        </svg>
                    </div>

                    <h3 class="mt-5 text-lg font-bold text-[#004777]">
                        No courses found
                    </h3>

                    <p class="mt-2 text-sm text-[#004777]/70">
                        Try changing filters or keywords.
                    </p>

                </div>
            </div>

        @endforelse

    </section>

    {{-- PAGINATION --}}
    <div class="pt-2">
        {{ $courses->links() }}
    </div>

</div>