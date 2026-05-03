<div class="rounded-2xl border bg-white overflow-hidden">
    <div class="p-4 border-b bg-slate-50 animate-pulse">
        <div class="h-4 w-40 rounded bg-slate-200"></div>
    </div>

    <div class="divide-y">
        @for($i = 0; $i < ($rows ?? 5); $i++)
            <div class="p-4 animate-pulse flex items-center gap-4">
                <div class="h-4 w-1/4 rounded bg-slate-200"></div>
                <div class="h-4 w-1/3 rounded bg-slate-200"></div>
                <div class="h-4 w-1/6 rounded bg-slate-200 ml-auto"></div>
            </div>
        @endfor
    </div>
</div>