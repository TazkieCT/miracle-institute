<div class="space-y-6">

    <x-ui.page-header
        title="Admin Dashboard"
        subtitle="Operational insights, sessions, and attendance monitoring."
    />

    {{-- FILTER --}}
    <div class="flex gap-2">
        @foreach([1,2,3,4] as $w)
            <button
                wire:click="setWeeks({{ $w }})"
                class="px-4 py-2 rounded-xl text-sm border
                    {{ $weeks === $w ? 'bg-slate-900 text-white' : 'bg-white' }}">
                {{ $w }} Week{{ $w > 1 ? 's' : '' }}
            </button>
        @endforeach
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
        @php
            $cards = [
                ['label' => 'Users', 'value' => $usersCount],
                ['label' => 'Programs', 'value' => $studyProgramsCount],
                ['label' => 'Courses', 'value' => $coursesCount],
                ['label' => 'Topics', 'value' => $topicsCount],
                ['label' => 'Assessments', 'value' => $assessmentsCount],
                ['label' => 'Certificates', 'value' => $certificatesCount],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="bg-white border rounded-2xl p-5">
                <div class="text-xs text-slate-500">{{ $card['label'] }}</div>
                <div class="text-2xl font-bold mt-1">
                    {{ number_format($card['value'], 0, ',', '.') }}
                </div>
            </div>
        @endforeach
    </div>

    {{-- ATTENDANCE --}}
    <section class="bg-white border rounded-2xl p-5 space-y-4">
        <div>
            <h2 class="font-semibold text-lg">Attendance (Last {{ $weeks }} Week{{ $weeks > 1 ? 's' : '' }})</h2>
            <p class="text-sm text-slate-500">
                Total records: {{ number_format($attendance['total'], 0, ',', '.') }}
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-4">
            <div class="p-4 rounded-xl bg-emerald-50 border">
                <div class="text-sm text-emerald-600">Present</div>
                <div class="text-2xl font-bold">
                    {{ number_format($attendance['present'], 0, ',', '.') }}
                </div>
                <div class="text-xs text-emerald-600">
                    {{ $attendance['present_pct'] }}%
                </div>
            </div>

            <div class="p-4 rounded-xl bg-yellow-50 border">
                <div class="text-sm text-yellow-600">Late</div>
                <div class="text-2xl font-bold">
                    {{ number_format($attendance['late'], 0, ',', '.') }}
                </div>
                <div class="text-xs text-yellow-600">
                    {{ $attendance['late_pct'] }}%
                </div>
            </div>

            <div class="p-4 rounded-xl bg-red-50 border">
                <div class="text-sm text-red-600">Absent</div>
                <div class="text-2xl font-bold">
                    {{ number_format($attendance['absent'], 0, ',', '.') }}
                </div>
                <div class="text-xs text-red-600">
                    {{ $attendance['absent_pct'] }}%
                </div>
            </div>
        </div>
    </section>

    {{-- PROBLEM SESSIONS --}}
    <section class="bg-white border rounded-2xl p-5 space-y-4">
        <h2 class="font-semibold text-lg">⚠ Problematic Sessions</h2>

        @forelse($problemSessions as $session)
            <div class="border rounded-xl p-4 flex justify-between">
                <div>
                    <div class="font-medium">{{ $session->title }}</div>
                    <div class="text-xs text-slate-500">
                        {{ $session->topic?->name }} • {{ $session->topic?->course?->title }}
                    </div>
                </div>

                <div class="text-sm text-red-600 font-semibold">
                    {{ number_format($session->absent_count) }} absent
                </div>
            </div>
        @empty
            <div class="text-sm text-slate-500">
                No problematic sessions found
            </div>
        @endforelse
    </section>

    {{-- SESSIONS --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- RECENT --}}
        <section class="bg-white border rounded-2xl p-5 space-y-4">
            <h2 class="font-semibold text-lg">Recent Sessions</h2>

            @forelse($recentSessions as $session)
                <div class="border rounded-xl p-4 flex justify-between items-start">
                    <div>
                        <div class="font-medium">{{ $session->title }}</div>

                        <div class="text-xs text-slate-500">
                            {{ $session->topic?->name ?? 'No Topic' }}
                            •
                            {{ $session->topic?->course?->title ?? 'No Course' }}
                        </div>

                        <div class="text-xs text-slate-400 mt-1">
                            {{ $session->start_at->format('d M Y H:i') }}
                        </div>
                    </div>

                    <span class="inline-flex items-center px-2 py-1 rounded bg-slate-100 text-xs whitespace-nowrap self-start">
                        {{ ucfirst($session->status) }}
                    </span>
                </div>
            @empty
                <div class="text-sm text-slate-500">
                    No recent sessions
                </div>
            @endforelse
        </section>

        {{-- UPCOMING --}}
        <section class="bg-white border rounded-2xl p-5 space-y-4">
            <h2 class="font-semibold text-lg">Upcoming Sessions</h2>

            @forelse($upcomingSessions as $session)
                <div class="border rounded-xl p-4 flex justify-between items-start">
                    <div>
                        <div class="font-medium">{{ $session->title }}</div>

                        <div class="text-xs text-slate-500">
                            {{ $session->topic?->name ?? 'No Topic' }}
                            •
                            {{ $session->topic?->course?->title ?? 'No Course' }}
                        </div>

                        <div class="text-xs text-slate-400 mt-1">
                            {{ $session->start_at->format('d M Y H:i') }}
                        </div>
                    </div>

                    <span class="inline-flex items-center px-2 py-1 rounded bg-blue-100 text-blue-600 text-xs whitespace-nowrap self-start">
                        Scheduled
                    </span>
                </div>
            @empty
                <div class="text-sm text-slate-500">
                    No upcoming sessions
                </div>
            @endforelse
        </section>

    </div>

    {{-- COURSES & CERTIFICATES --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- COURSES --}}
        <section class="bg-white border rounded-2xl p-5 space-y-3">
            <h2 class="font-semibold text-lg">Latest Courses</h2>

            @forelse($latestCourses as $course)
                <div class="border rounded-xl p-4 flex justify-between">
                    <div>
                        <div class="font-medium">{{ $course->title }}</div>
                        <div class="text-xs text-slate-500">
                            {{ $course->studyProgram?->title }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-sm text-slate-500">
                    No courses available
                </div>
            @endforelse
        </section>

        {{-- CERTIFICATES --}}
        <section class="bg-white border rounded-2xl p-5 space-y-3">
            <h2 class="font-semibold text-lg">Latest Certificates</h2>

            @forelse($latestCertificates as $certificate)
                <div class="border rounded-xl p-4 flex justify-between">
                    <div>
                        <div class="font-medium">{{ $certificate->certificate_number }}</div>
                        <div class="text-xs text-slate-500">
                            {{ $certificate->user?->full_name }}
                        </div>
                    </div>

                    <span class="text-xs px-2 py-1 rounded bg-slate-100">
                        {{ $certificate->status }}
                    </span>
                </div>
            @empty
                <div class="text-sm text-slate-500">
                    No certificates issued yet
                </div>
            @endforelse
        </section>

    </div>

</div>