<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .page {
            width: 100%;
            height: 100%;
            padding: 48px;
            border: 12px solid #6b46c1;
            box-sizing: border-box;
        }
        .title {
            font-size: 34px;
            font-weight: bold;
            text-align: center;
            margin-top: 30px;
        }
        .subtitle {
            font-size: 18px;
            text-align: center;
            margin-top: 10px;
        }
        .name {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            margin: 50px 0 10px;
        }
        .content {
            text-align: center;
            font-size: 16px;
            line-height: 1.7;
            margin-top: 10px;
        }
        .meta {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }
        .footer {
            position: absolute;
            bottom: 40px;
            left: 48px;
            right: 48px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="title">Certificate of {{ ucfirst($certificate->type) }}</div>
        <div class="subtitle">This certificate is proudly presented to</div>

        <div class="name">{{ $user->full_name }}</div>

        <div class="content">
            @if($certificate->type === 'topic')
                for successfully completing the topic <strong>{{ $topic?->name }}</strong>
                under the course <strong>{{ $course?->title }}</strong>.
            @else
                for successfully completing the course <strong>{{ $course?->title }}</strong>.
            @endif
        </div>

        <div class="meta">
            <div>
                <div><strong>Certificate No:</strong> {{ $certificate->certificate_number }}</div>
                <div><strong>Issued At:</strong> {{ optional($certificate->issued_at)->format('d M Y') }}</div>
            </div>
            <div>
                <div><strong>Type:</strong> {{ ucfirst($certificate->type) }}</div>
                <div><strong>Status:</strong> {{ ucfirst($certificate->status) }}</div>
            </div>
        </div>

        <div class="footer">
            {{ config('app.name', 'LMS') }} — Generated automatically by the system
        </div>
    </div>
</body>
</html>