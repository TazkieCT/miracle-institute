@php
    use Carbon\Carbon;

    $issuedAt = isset($issuedAt) && $issuedAt
        ? ($issuedAt instanceof Carbon ? $issuedAt : Carbon::parse($issuedAt))
        : now();

    $certificateNumber = $certificateNumber ?? ('CERT-CRS-' . now()->format('Ymd') . '-0001');
    $participantName = strtoupper($user->full_name ?? $user->name ?? '-');
    $signatureName = 'Ali Sutiyono';

    // Placeholders: can be replaced by actual storage paths/base64 later.
    $background = $background ?? null;
    $backgroundBack = $backgroundBack ?? null;
    $signature = $signature ?? null;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat - {{ $course->title ?? '-' }}</title>
    <style>
        @page { margin: 0; size: 297mm 210mm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        html,
        body {
            width: 297mm;
            font-family: 'Times New Roman', serif;
        }

        .page {
            position: relative;
            width: 297mm;
            height: 210mm;
            overflow: hidden;
        }

        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .background img {
            width: 100%;
            height: 100%;
        }

        .wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 297mm;
            height: 210mm;
        }

        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 85%;
            text-align: center;
        }

        .page-break {
            page-break-before: always;
        }

        .second-content {
            padding: 20mm 20mm 24mm 20mm;
            height: 210mm;
            position: relative;
        }

        .second-title {
            text-align: center;
            font-size: 24px;
            color: #0000c7;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .material-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 14px;
        }

        .material-table {
            width: 100%;
            min-height: 100mm;
            border-collapse: collapse;
            font-size: 16px;
        }

        .material-table th,
        .material-table td {
            border: 1px solid #000;
            padding: 8px 10px;
        }

        .material-table th {
            background: #f2f2f2;
            text-align: center;
        }

        .material-table td {
            background: #ffffff;
            text-align: center;
        }

        .material-table td.no,
        .material-table td.duration {
            text-align: center;
            width: 15%;
        }

        .material-table td.topic {
            width: 70%;
        }

        .signature-right-bottom {
            text-align: center;
            margin-left: auto;
            width: 70mm;
            margin-top: 16px;
        }
    </style>
</head>
<body>
    <div class="page">
        @if($background)
            <div class="background">
                <img src="{{ $background }}" alt="">
            </div>
        @endif

        <div class="wrapper">
            <div class="content">
                <h1 style="font-size: 24px; color: #0000c7; font-weight: bold;">
                    KSP <span style="color: #c20000;">CU</span> BEREROD GRATIA
                </h1>
                <h2 style="font-size: 46px; color: #000; font-weight: 900; letter-spacing: 3px; margin: 5px 0;">SERTIFIKAT</h2>
                <p style="font-size: 20px; color: #000; font-weight: bold; font-style: italic;">No. {{ $certificateNumber }}</p>
                <p style="font-size: 24px; color: #000; margin: 15px 0 5px 0;">Diberikan kepada:</p>
                <div style="font-size: 28px; color: #000; font-weight: bold; border-bottom: 3px solid #000; display: inline-block; padding: 8px 30px;">
                    {{ $participantName }}
                </div>
                <p style="font-size: 24px; color: #000; margin: 5px 0 0 0;">Telah mengikuti dan menyelesaikan :</p>
                <div style="font-size: 28px; color: #000; font-weight: bold; margin: 0 0 5px 0;">{{ $course->title ?? '-' }}</div>
                <div style="font-size: 22px; color: #000; margin: 10px 0;">
                    Sebagai <strong>Peserta</strong> yang diselenggarakan KSP CU Bererod Gratia di Kantor Pusat.
                </div>
                <p style="font-size: 20px; color: #000; margin: 20px 0 0 0;">
                    <strong>{{ $issuedAt->locale('id')->isoFormat('D MMMM Y') }}</strong>
                </p>
                @if($signature)
                    <div>
                        <img src="{{ $signature }}" alt="Signature" style="width: 150px; height: auto;">
                    </div>
                @endif
                <div style="border-bottom: 2px solid #000; width: 250px; margin: 0 auto;">
                    <p style="font-size: 26px; font-weight: bold; color: #000;">{{ $signatureName }}</p>
                </div>
                <p style="font-size: 16px; color: #000; margin: 3px 0 0 0;">WAKIL KETUA PENGURUS</p>
            </div>
        </div>
    </div>

    <div class="page-break page">
        @if($backgroundBack)
            <div class="background">
                <img src="{{ $backgroundBack }}" alt="">
            </div>
        @endif

        <div class="wrapper">
            <div class="second-content">
                <h1 class="second-title">
                    KSP <span style="color: #c20000;">CU</span> BEREROD GRATIA
                </h1>

                <p class="material-title">
                    MATERI {{ strtoupper($course->title ?? '-') }} TAHUN {{ $issuedAt->format('Y') }}.
                </p>

                <table class="material-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Materi</th>
                            <th>Durasi Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($course->topics as $index => $topic)
                            <tr>
                                <td class="no">{{ $index + 1 }}</td>
                                <td class="topic">{{ $topic->name }}</td>
                                <td class="duration">{{ (int) ($topic->duration ?? 0) }} Menit</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align:center;">Belum ada materi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="signature-right-bottom">
                    <p style="font-size: 20px; color: #000; margin: 0;">
                        <strong>{{ $issuedAt->locale('id')->isoFormat('D MMMM Y') }}</strong>
                    </p>
                    @if($signature)
                        <div>
                            <img src="{{ $signature }}" alt="Signature" style="width: 150px; height: auto;">
                        </div>
                    @endif
                    <div style="border-bottom: 2px solid #000; width: 250px; margin: 0 auto;">
                        <p style="font-size: 26px; font-weight: bold; color: #000;">{{ $signatureName }}</p>
                    </div>
                    <p style="font-size: 16px; color: #000; margin: 3px 0 0 0;">WAKIL KETUA PENGURUS</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>