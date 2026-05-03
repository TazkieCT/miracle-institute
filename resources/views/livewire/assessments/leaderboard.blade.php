<div class="rounded-2xl bg-white border p-5 space-y-4">
    <h2 class="text-lg font-semibold">Leaderboard</h2>

    <div class="space-y-3">
        @foreach($leaders as $index => $item)
            <div class="flex items-center justify-between border rounded-xl p-3">
                <div class="flex items-center gap-3">
                    <span class="font-bold w-6">#{{ $index + 1 }}</span>
                    <div>
                        <div class="font-medium">{{ $item->user->name }}</div>
                        <div class="text-xs text-slate-500">
                            Attempt {{ $item->attempt_no }}
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <div class="font-semibold">{{ $item->score }}</div>
                    <div class="text-xs text-slate-500">
                        {{ gmdate('i:s', $item->duration_seconds ?? 0) }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>