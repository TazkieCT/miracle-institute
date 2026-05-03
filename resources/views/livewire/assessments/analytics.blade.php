<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <div class="rounded-xl border p-4">
        <div class="text-xs text-slate-500">Total Attempts</div>
        <div class="text-xl font-semibold">{{ $stats->total_attempts }}</div>
    </div>

    <div class="rounded-xl border p-4">
        <div class="text-xs text-slate-500">Average Score</div>
        <div class="text-xl font-semibold">{{ round($stats->avg_score) }}</div>
    </div>

    <div class="rounded-xl border p-4">
        <div class="text-xs text-slate-500">Pass Rate</div>
        <div class="text-xl font-semibold">{{ $passRate }}%</div>
    </div>

    <div class="rounded-xl border p-4">
        <div class="text-xs text-slate-500">Your Best</div>
        <div class="text-xl font-semibold">{{ $best ?? '-' }}</div>
    </div>
</div>