<div class="space-y-6">
    <x-ui.page-header
        title="Admin Dashboard"
        subtitle="Ringkasan sistem, konten, dan aktivitas terbaru."
    />

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-6 gap-4">
        <div class="rounded-2xl bg-white border p-5">
            <div class="text-sm text-slate-500">Users</div>
            <div class="text-3xl font-bold mt-2">{{ $usersCount }}</div>
        </div>
        <div class="rounded-2xl bg-white border p-5">
            <div class="text-sm text-slate-500">Programs</div>
            <div class="text-3xl font-bold mt-2">{{ $studyProgramsCount }}</div>
        </div>
        <div class="rounded-2xl bg-white border p-5">
            <div class="text-sm text-slate-500">Courses</div>
            <div class="text-3xl font-bold mt-2">{{ $coursesCount }}</div>
        </div>
        <div class="rounded-2xl bg-white border p-5">
            <div class="text-sm text-slate-500">Topics</div>
            <div class="text-3xl font-bold mt-2">{{ $topicsCount }}</div>
        </div>
        <div class="rounded-2xl bg-white border p-5">
            <div class="text-sm text-slate-500">Assessments</div>
            <div class="text-3xl font-bold mt-2">{{ $assessmentsCount }}</div>
        </div>
        <div class="rounded-2xl bg-white border p-5">
            <div class="text-sm text-slate-500">Certificates</div>
            <div class="text-3xl font-bold mt-2">{{ $certificatesCount }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <section class="rounded-2xl bg-white border p-5">
            <div class="flex items-end justify-between mb-4">
                <div>
                    <h2 class="font-semibold text-lg">Latest Courses</h2>
                    <p class="text-sm text-slate-500">Course terbaru yang masuk sistem.</p>
                </div>
            </div>

            <div class="space-y-3">
                @foreach($latestCourses as $course)
                    <div class="rounded-xl border p-4 flex items-start justify-between gap-4">
                        <div>
                            <div class="font-medium">{{ $course->title }}</div>
                            <div class="text-xs text-slate-500">{{ $course->studyProgram?->title }}</div>
                        </div>
                        <a href="{{ route('admin.courses.index') }}" class="text-sm underline">Open</a>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-2xl bg-white border p-5">
            <div class="flex items-end justify-between mb-4">
                <div>
                    <h2 class="font-semibold text-lg">Latest Certificates</h2>
                    <p class="text-sm text-slate-500">Riwayat sertifikat terbaru.</p>
                </div>
            </div>

            <div class="space-y-3">
                @foreach($latestCertificates as $certificate)
                    <div class="rounded-xl border p-4 flex items-start justify-between gap-4">
                        <div>
                            <div class="font-medium">{{ $certificate->certificate_number }}</div>
                            <div class="text-xs text-slate-500">
                                {{ $certificate->user?->full_name }} · {{ ucfirst($certificate->type) }}
                            </div>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full bg-slate-100">{{ $certificate->status }}</span>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</div>