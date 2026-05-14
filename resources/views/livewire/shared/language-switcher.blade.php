<div class="language-switcher">
    <label for="language-select" class="sr-only">{{ __('messages.language') }}</label>

    <div class="inline-flex items-center gap-2">
        <span class="text-sm font-medium">{{ __('messages.language') }}:</span>

        <select id="language-select"
            wire:model.live="locale"
            class="rounded border-gray-300 bg-white px-3 py-2 text-sm">
            @foreach($availableLocales as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>