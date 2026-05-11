<div class="space-y-6 px-4 py-6 sm:px-6 lg:px-12 xl:px-36">
    <x-ui.page-header
        title="My Learning"
        subtitle="Halaman khusus untuk progres kursus yang sedang kamu ikuti."
    >
        <a href="{{ route('courses.index') }}" class="rounded-xl bg-[#004777] px-4 py-2 text-sm text-white transition hover:bg-[#004777]/90">
            Open Catalog
        </a>
    </x-ui.page-header>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <div class="rounded-2xl border border-[#004777]/10 bg-white p-5 shadow-sm">
            <p class="text-sm text-[#004777]/70">Courses Enrolled</p>
            <p class="mt-2 text-3xl font-black text-[#004777]">{{ $summary['courses_enrolled'] ?? 0 }}</p>
            <p class="mt-2 text-sm text-[#004777]/70">Yang sedang anda ikuti</p>
        </div>

        <div class="rounded-2xl border border-[#004777]/10 bg-white p-5 shadow-sm">
            <p class="text-sm text-[#004777]/70">Topics Completed</p>
            <p class="mt-2 text-3xl font-black text-[#004777]">{{ $summary['topics_completed'] ?? 0 }}</p>
            <p class="mt-2 text-sm text-[#004777]/70">Topik yang telah diselesaikan</p>
        </div>

        <div class="rounded-2xl border border-[#004777]/10 bg-white p-5 shadow-sm">
            <p class="text-sm text-[#004777]/70">Certificates</p>
            <p class="mt-2 text-3xl font-black text-[#004777]">{{ $summary['certificates'] ?? 0 }}</p>
            <p class="mt-2 text-sm text-[#004777]/70">Yang sudah anda dapatkan</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <section class="xl:col-span-2 space-y-4">
            <div class="flex items-end justify-between">
                <div>
                    <h2 class="text-lg font-bold text-[#004777]">Courses in progress</h2>
                    <p class="text-sm text-[#004777]/70">Track each enrolled course.</p>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($enrollments as $row)
                    <div class="rounded-2xl border border-[#004777]/10 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="font-semibold text-[#004777]">{{ $row['enrollment']->course?->title }}</h3>
                                <p class="text-sm text-[#004777]/70">{{ $row['enrollment']->course?->studyProgram?->title }}</p>
                            </div>
                            <span class="text-sm font-semibold text-[#004777]">{{ $row['percent'] }}%</span>
                        </div>

                        <div class="mt-4 h-2 overflow-hidden rounded-full bg-[#35A7FF]/15">
                            <div class="h-2 rounded-full bg-[#004777]" style="width: {{ $row['percent'] }}%"></div>
                        </div>

                        <div class="mt-3 text-sm text-[#004777]/70">
                            {{ $row['completedTopics'] }} / {{ $row['totalTopics'] }} topics completed
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="{{ route('courses.show', $row['enrollment']->course?->slug) }}"
                               class="inline-flex rounded-xl bg-[#004777] px-4 py-2 text-sm text-white transition hover:bg-[#004777]/90">
                                Continue
                            </a>
                            <a href="{{ route('topics.show', $row['enrollment']->course?->topics->first()?->slug) }}"
                               class="inline-flex rounded-xl border border-[#004777]/15 px-4 py-2 text-sm text-[#004777] transition hover:bg-[#35A7FF]/10">
                                Open first topic
                            </a>
                        </div>
                    </div>
                @empty
                    <x-ui.empty-state
                        title="Belum ada course"
                        description="Kamu belum mengikuti course apa pun."
                        button-label="Browse Courses"
                        button-href="{{ route('courses.index') }}"
                    />
                @endforelse
            </div>
        </section>

        <aside class="space-y-4">
            <div class="rounded-2xl border border-[#004777]/10 bg-white p-5 shadow-sm">
                <h2 class="mb-3 font-bold text-[#004777]">Upcoming Sessions</h2>
                <div class="space-y-3">
                    @forelse($upcomingSessions as $session)
                        <div class="rounded-xl border border-[#004777]/10 bg-[#f4faff] p-3">
                            <div class="text-sm font-medium text-[#004777]">{{ $session->topic?->name }}</div>
                            <div class="text-xs text-[#004777]/70">{{ $session->start_at->format('d M Y, H:i') }}</div>
                        </div>
                    @empty
                        <div class="text-sm text-[#004777]/70">Tidak ada sesi terjadwal.</div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-[#004777]/10 bg-white p-5 shadow-sm">
                <h2 class="mb-3 font-bold text-[#004777]">Latest Certificates</h2>
                <div class="space-y-3">
                    @forelse($latestCertificates as $certificate)
                        <div class="rounded-xl border border-[#004777]/10 bg-[#f4faff] p-3">
                            <div class="text-sm font-medium text-[#004777]">{{ $certificate->certificate_number }}</div>
                            <div class="text-xs text-[#004777]/70">{{ ucfirst($certificate->type) }}</div>
                        </div>
                    @empty
                        <div class="text-sm text-[#004777]/70">Belum ada sertifikat.</div>
                    @endforelse
                </div>
            </div>
        </aside>
    </div>
</div>