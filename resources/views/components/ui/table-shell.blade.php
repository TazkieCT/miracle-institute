<div class="w-full">
    <div class="rounded-2xl bg-white border overflow-hidden">
        <div class="overflow-x-auto">
            <table {{ $attributes->merge(['class' => 'w-full min-w-full text-sm']) }}>
                {{ $slot }}
            </table>
        </div>
    </div>
</div>