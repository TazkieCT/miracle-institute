<div class="mx-auto max-w-6xl space-y-6">
    <section class="overflow-hidden rounded-[2rem] border border-[#004777]/10 bg-gradient-to-br from-[#004777] via-[#0a5c91] to-[#35A7FF] text-white shadow-sm">
        <div class="grid gap-6 px-6 py-8 sm:px-8 lg:grid-cols-[1.1fr_0.9fr] lg:px-10">
            <div class="space-y-4">
                <span class="inline-flex rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em]">
                    {{ __('general.profile.hero.badge') }}
                </span>

                <div class="space-y-2">
                    <h1 class="text-3xl font-semibold tracking-tight sm:text-4xl">
                        {{ __('general.profile.hero.title') }}
                    </h1>
                    <p class="max-w-2xl text-sm text-white/80 sm:text-base">
                        {{ __('general.profile.hero.subtitle') }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-3 text-sm text-white/85">
                    <span class="rounded-full border border-white/15 bg-white/10 px-3 py-1.5">
                        {{ __('general.profile.hero.active_role') }}: {{ ucfirst((string) $activeRole) }}
                    </span>
                    <span class="rounded-full border border-white/15 bg-white/10 px-3 py-1.5">
                        {{ __('general.profile.hero.member_since') }}: {{ optional($user?->created_at)->translatedFormat('d M Y') }}
                    </span>
                </div>
            </div>

            <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-1">
                <div class="rounded-3xl border border-white/15 bg-white/10 p-4 backdrop-blur-sm">
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">{{ __('general.profile.stats.roles') }}</div>
                    <div class="mt-2 text-2xl font-semibold">{{ $user?->roles?->count() ?? 0 }}</div>
                </div>

                <div class="rounded-3xl border border-white/15 bg-white/10 p-4 backdrop-blur-sm">
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">{{ __('general.profile.stats.status') }}</div>
                    <div class="mt-2 text-sm font-semibold">
                        {{ $user?->hasVerifiedEmail() ? __('general.profile.status.verified') : __('general.profile.status.unverified') }}
                    </div>
                </div>

                <div class="rounded-3xl border border-white/15 bg-white/10 p-4 backdrop-blur-sm">
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">{{ __('general.profile.stats.email') }}</div>
                    <div class="mt-2 truncate text-sm font-semibold">{{ $user?->email }}</div>
                </div>
            </div>
        </div>
    </section>

    <div class="grid gap-6 lg:grid-cols-[0.82fr_1.18fr]">
        <aside class="space-y-6 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-3xl border border-slate-200 bg-slate-100 text-2xl font-semibold text-slate-500">
                    @if($this->profileImageUrl)
                        <img src="{{ $this->profileImageUrl }}" alt="{{ $user?->name }}" class="h-full w-full object-cover">
                    @else
                        {{ strtoupper(substr((string) $user?->name, 0, 1)) }}
                    @endif
                </div>

                <div class="min-w-0 space-y-1">
                    <h2 class="truncate text-xl font-semibold text-slate-900">{{ $user?->name }}</h2>
                    <p class="truncate text-sm text-slate-500">{{ $user?->email }}</p>
                    <div class="flex flex-wrap gap-2 pt-2">
                        @foreach(($user?->roles ?? collect()) as $role)
                            <span class="rounded-full bg-[#35A7FF]/10 px-3 py-1 text-xs font-medium text-[#004777]">
                                {{ $role->label }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="space-y-3 rounded-3xl bg-slate-50 p-5">
                <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">
                    {{ __('general.profile.summary.title') }}
                </h3>

                <dl class="space-y-3 text-sm">
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">{{ __('general.profile.fields.phone') }}</dt>
                        <dd class="text-right font-medium text-slate-800">{{ $user?->phone ?: __('general.profile.summary.empty') }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">{{ __('general.profile.fields.gender') }}</dt>
                        <dd class="text-right font-medium text-slate-800">
                            @if($user?->gender === 'male')
                                {{ __('general.profile.gender.male') }}
                            @elseif($user?->gender === 'female')
                                {{ __('general.profile.gender.female') }}
                            @else
                                {{ __('general.profile.summary.empty') }}
                            @endif
                        </dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">{{ __('general.profile.fields.dob') }}</dt>
                        <dd class="text-right font-medium text-slate-800">
                            {{ $user?->dob ? $user->dob->translatedFormat('d M Y') : __('general.profile.summary.empty') }}
                        </dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">{{ __('general.profile.summary.verification') }}</dt>
                        <dd class="text-right font-medium {{ $user?->hasVerifiedEmail() ? 'text-emerald-600' : 'text-amber-600' }}">
                            {{ $user?->hasVerifiedEmail() ? __('general.profile.status.verified') : __('general.profile.status.unverified') }}
                        </dd>
                    </div>
                </dl>
            </div>
        </aside>

        <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6 space-y-2">
                <h2 class="text-2xl font-semibold text-slate-900">{{ __('general.profile.form.title') }}</h2>
                <p class="text-sm text-slate-500">{{ __('general.profile.form.subtitle') }}</p>
            </div>

            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid gap-6 lg:grid-cols-[0.7fr_1.3fr]">
                    <div class="space-y-3">
                        <label class="text-sm font-semibold text-slate-700">{{ __('general.profile.fields.image') }}</label>

                        <div class="flex aspect-square items-center justify-center overflow-hidden rounded-[1.75rem] border border-dashed border-slate-300 bg-slate-50">
                            @if($this->profileImageUrl)
                                <img src="{{ $this->profileImageUrl }}" alt="{{ $user?->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="space-y-2 px-6 text-center">
                                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-2xl font-semibold text-slate-500 shadow-sm">
                                        {{ strtoupper(substr((string) $user?->name, 0, 1)) }}
                                    </div>
                                    <p class="text-xs text-slate-500">{{ __('general.profile.form.image_help') }}</p>
                                </div>
                            @endif
                        </div>

                        <input
                            type="file"
                            wire:model="imageFile"
                            accept="image/*"
                            class="block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-[#004777] file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-[#0a5c91]"
                        >
                        @error('imageFile') <span class="text-xs font-medium text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="space-y-2 sm:col-span-2">
                            <label class="text-sm font-semibold text-slate-700">{{ __('general.profile.fields.name') }}</label>
                            <input
                                wire:model.blur="name"
                                type="text"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 transition focus:border-[#35A7FF] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#35A7FF]/10"
                            >
                            @error('name') <span class="text-xs font-medium text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2 sm:col-span-2">
                            <label class="text-sm font-semibold text-slate-700">{{ __('general.profile.fields.email') }}</label>
                            <input
                                wire:model.blur="email"
                                type="email"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 transition focus:border-[#35A7FF] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#35A7FF]/10"
                            >
                            @error('email') <span class="text-xs font-medium text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">{{ __('general.profile.fields.phone') }}</label>
                            <input
                                wire:model.blur="phone"
                                type="text"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 transition focus:border-[#35A7FF] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#35A7FF]/10"
                            >
                            @error('phone') <span class="text-xs font-medium text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">{{ __('general.profile.fields.gender') }}</label>
                            <select
                                wire:model.live="gender"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 transition focus:border-[#35A7FF] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#35A7FF]/10"
                            >
                                <option value="">{{ __('general.profile.form.select_gender') }}</option>
                                <option value="male">{{ __('general.profile.gender.male') }}</option>
                                <option value="female">{{ __('general.profile.gender.female') }}</option>
                            </select>
                            @error('gender') <span class="text-xs font-medium text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2 sm:col-span-2">
                            <label class="text-sm font-semibold text-slate-700">{{ __('general.profile.fields.dob') }}</label>
                            <input
                                wire:model.live="dob"
                                type="date"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 transition focus:border-[#35A7FF] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#35A7FF]/10"
                            >
                            @error('dob') <span class="text-xs font-medium text-rose-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button
                        type="submit"
                        class="rounded-2xl bg-[#004777] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0a5c91]"
                    >
                        {{ __('general.profile.form.save') }}
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>
