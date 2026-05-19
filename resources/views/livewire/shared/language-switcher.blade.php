<div class="language-switcher">
    <label for="language-select" class="sr-only">{{ __('general.shared.language_switcher.label') }}</label>

    <div class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2">
        <select id="language-select"
            wire:model.live="locale"
            class="border-0 bg-transparent pr-5 text-sm font-medium text-slate-700 focus:outline-none focus:ring-0">
            @foreach($availableLocales as $key => $label)
                <option value="{{ $key }}">{{ ($localeFlags[$key] ?? '🌐') . ' ' . $label }}</option>
            @endforeach
        </select>
    </div>
</div>
