@php
    use Carbon\Carbon;

    $issuedAt = isset($issuedAt) && $issuedAt
        ? ($issuedAt instanceof Carbon ? $issuedAt : Carbon::parse($issuedAt))
        : now();

    $frontDate = $frontDate ?? $issuedAt->translatedFormat('d F Y');
    $certificateNumber = $certificateNumber ?? ('CERT-CRS-' . now()->format('Ymd') . '-0001');
    $courseCode = $courseCode ?? 'CRS';
    $sequenceLabel = $sequenceLabel ?? '0001';

    $frontSummary = $frontSummary ?? [
        'participant_name' => $user->name ?? '-',
        'course_title' => $course->title ?? '-',
        'program_title' => $course->studyProgram->title ?? '-',
        'total_topics' => 0,
        'completed_topics' => 0,
    ];

    $backTopics = $backTopics ?? [];

    $achievementSummary = $achievementSummary ?? [
        'topics_total' => 0,
        'topics_completed' => 0,
        'attendance_present' => 0,
        'attendance_late' => 0,
        'attendance_absent' => 0,
    ];

    $logoBase64 = $logoBase64 ?? '';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 18px; }
        * { box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        .page {
            width: 100%;
            min-height: 1000px;
            position: relative;
        }

        .page-break {
            page-break-after: always;
        }

        .sheet {
            border: 2px solid #0f172a;
            border-radius: 18px;
            padding: 24px;
            min-height: 1000px;
            height: auto; 
            position: relative;
            box-sizing: border-box;
            
            margin-bottom: 20px; 
        }

        .sheet-inner {
            position: absolute;
            
            top: 12px;
            bottom: 12px;
            left: 12px;
            right: 12px;
            
            border: 1px solid #cbd5e1;
            border-radius: 14px;
            pointer-events: none;
        }



        .header {
            display: table;
            width: 100%;
            margin-bottom: 18px;
        }

        .header-left,
        .header-right {
            display: table-cell;
            vertical-align: middle;
        }

        .header-right {
            text-align: right;
        }

        .brand {
            display: table;
        }

        .brand-logo,
        .brand-text {
            display: table-cell;
            vertical-align: middle;
        }

        .logo {
            width: 62px;
            height: 62px;
            border-radius: 14px;
            object-fit: cover;
            margin-right: 12px;
        }

        .brand-title {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .14em;
            color: #475569;
            font-weight: 700;
        }

        .brand-sub {
            font-size: 11px;
            color: #64748b;
            margin-top: 3px;
        }

        .cert-no {
            font-size: 12px;
            color: #334155;
            line-height: 1.6;
        }

        .title {
            text-align: center;
            margin-top: 22px;
        }

        .title h1 {
            margin: 0;
            font-size: 28px;
            letter-spacing: .10em;
            text-transform: uppercase;
            color: #0f172a;
        }

        .title p {
            margin: 8px 0 0;
            color: #64748b;
            font-size: 13px;
        }

        .main-box {
            margin: 34px auto 0;
            max-width: 720px;
            text-align: center;
        }

        .label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .12em;
            font-weight: 700;
        }

        .name {
            margin-top: 10px;
            font-size: 30px;
            font-weight: 800;
            color: #111827;
            line-height: 1.25;
            word-break: break-word;
        }

        .course {
            margin-top: 10px;
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.3;
            word-break: break-word;
        }

        .meta {
            margin-top: 16px;
            font-size: 13px;
            color: #475569;
            line-height: 1.8;
        }

        .pill {
            display: inline-block;
            margin-top: 14px;
            padding: 6px 14px;
            border-radius: 999px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .summary-grid {
            margin-top: 28px;
            display: table;
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
        }

        .summary-cell {
            display: table-cell;
            width: 33.333%;
        }

        .summary-card {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            background: #f8fafc;
            padding: 14px;
            min-height: 86px;
        }

        .summary-card .k {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .10em;
            color: #64748b;
        }

        .summary-card .v {
            margin-top: 8px;
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.35;
            word-break: break-word;
        }

        .footer {
            position: absolute;
            left: 24px;
            right: 24px;
            bottom: 24px;
            display: table;
            width: calc(100% - 48px);
        }

        .footer-col {
            display: table-cell;
            width: 50%;
            text-align: center;
            vertical-align: bottom;
        }

        .sign-title {
            font-size: 12px;
            color: #64748b;
        }

        .sign-line {
            margin: 54px auto 0;
            border-top: 1px solid #111827;
            max-width: 240px;
            padding-top: 8px;
            font-size: 12px;
            font-weight: 700;
            color: #111827;
        }

        .back-header {
            margin-bottom: 18px;
        }

        .back-header h2 {
            margin: 0;
            font-size: 22px;
            color: #0f172a;
        }

        .back-header p {
            margin: 6px 0 0;
            font-size: 12px;
            color: #64748b;
            line-height: 1.7;
        }

        .table-wrap {
            border: 1px solid #dbe3ef;
            border-radius: 14px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        thead th {
            background: #0f172a;
            color: #fff;
            font-size: 11px;
            padding: 10px 8px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
        }

        tbody td {
            border-top: 1px solid #e2e8f0;
            padding: 10px 8px;
            font-size: 11px;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .topic-cell {
            font-weight: 700;
            color: #111827;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            background: #eef2ff;
            color: #3730a3;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .legend {
            margin-top: 16px;
            font-size: 11px;
            color: #64748b;
            line-height: 1.7;
        }

        .watermark {
            position: absolute;
            inset: 0;
            opacity: 0.05;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        .watermark img {
            width: 360px;
            max-width: 70%;
        }
    </style>
</head>
<body>
    <div class="page page-break">
        <div class="sheet">
            <div class="sheet-inner"></div>

            <div class="watermark">
                @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" alt="Watermark">
                @endif
            </div>

            <div class="header">
                <div class="header-left">
                    <div class="brand">
                        @if(!empty($logoBase64))
                            <div class="brand-logo">
                                <img class="logo" src="{{ $logoBase64 }}" alt="Logo">
                            </div>
                        @endif
                        <div class="brand-text">
                            <div class="brand-title">Official Certificate</div>
                            <div class="brand-sub">{{ $course->studyProgram?->title ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="header-right">
                    <div class="cert-no">
                        <strong>Certificate No.</strong><br>
                        {{ $certificateNumber }}<br>
                        <strong>Course Code.</strong> {{ $courseCode }}
                    </div>
                </div>
            </div>

            <div class="title">
                <h1>Certificate of Completion</h1>
                <p>Dokumen resmi penyelesaian pembelajaran yang diterbitkan berdasarkan data progres yang tervalidasi.</p>
            </div>

            <div class="main-box">
                <div class="label">This certifies that</div>
                <div class="name">{{ $user->name }}</div>
                <div class="meta">has successfully completed the course</div>
                <div class="course">{{ $course->title }}</div>
                <div class="pill">Issued on {{ $frontDate }}</div>
                <div class="meta">
                    Completion Sequence: <strong>{{ $sequenceLabel }}</strong><br>
                    Program: <strong>{{ $course->studyProgram?->title ?? '-' }}</strong>
                </div>
            </div>

            <div class="summary-grid">
                <div class="summary-cell">
                    <div class="summary-card">
                        <div class="k">Participant</div>
                        <div class="v">{{ $frontSummary['participant_name'] ?? $user->name }}</div>
                    </div>
                </div>
                <div class="summary-cell">
                    <div class="summary-card">
                        <div class="k">Course</div>
                        <div class="v">{{ $frontSummary['course_title'] ?? $course->title }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page">
        <div class="sheet">
            <div class="sheet-inner"></div>

            <div class="back-header">
                <h2>Topic and Attendance Summary</h2>
                <p>
                    The list of topics, attendance status, and attendance dates are displayed for official archiving purposes.
                </p>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 40%;">Topic</th>
                            <th style="width: 30%;">Attendance</th>
                            <th style="width: 30%;">Attendance Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($backTopics as $topic)
                            @foreach($topic['sessions'] as $index => $session)
                                <tr>
                                    @if($index === 0)
                                        <td rowspan="{{ count($topic['sessions']) }}" class="topic-cell">
                                            {{ $topic['topic_name'] }}
                                        </td>
                                        <td rowspan="{{ count($topic['sessions']) }}">
                                            <span class="badge">{{ strtoupper($topic['topic_status'] ?? '-') }}</span>
                                        </td>
                                    @endif
                                    <td>{{ $session['attendance_date'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="4" style="text-align:center; padding:18px;">
                                    No attendance records available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="summary-grid" style="margin-top: 20px;">
                <div class="summary-cell">
                    <div class="summary-card">
                        <div class="k">Total Topics</div>
                        <div class="v">{{ $achievementSummary['topics_total'] ?? 0 }}</div>
                    </div>
                </div>
                <div class="summary-cell">
                    <div class="summary-card">
                        <div class="k">Topics Completed</div>
                        <div class="v">{{ $achievementSummary['topics_completed'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>