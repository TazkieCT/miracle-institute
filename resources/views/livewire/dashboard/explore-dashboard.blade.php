@php
    $isMentor = session('active_role') === 'disciples';
    $studyProgramCount = $studyPrograms->count();
    $featuredCount = $featured->count();
    $continueCount = count($continueCourses);
@endphp

<div class="min-h-screen bg-white text-[#0f172a]">
    <section class="relative z-20 isolate overflow-x-clip px-4 pb-20 pt-0 sm:px-6 sm:pb-28 sm:pt-24 lg:px-8">
        <div class="mx-auto grid max-w-6xl items-center gap-6 lg:grid-cols-[1.2fr_0.8fr] lg:gap-4">
            <div class="relative z-10 order-2 text-center lg:order-1 lg:text-left">
                <h1 class="mx-auto max-w-4xl text-4xl font-bold leading-tight tracking-normal text-[#004777] sm:text-6xl lg:mx-0 lg:text-6xl">
                    {{ __('general.explore_dashboard.hero.guest.title') }}
                </h1>

                <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-slate-600 sm:text-xl lg:mx-0">
                    {{ __('general.explore_dashboard.hero.guest.description') }}
                </p>

                <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row lg:justify-start">
                    <a href="{{ localized_route('courses.index') }}"
                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#004777] px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-[#004777]/15 transition hover:bg-[#00395f]">
                        {{ __('general.explore_dashboard.hero.guest.explore_journey') }}
                    </a>

                    @guest
                        <a href="{{ localized_route('login') }}"
                           class="inline-flex items-center justify-center rounded-xl border border-[#004777]/20 bg-white px-5 py-3 text-sm font-semibold text-[#004777] transition hover:border-[#35A7FF] hover:text-[#00395f]">
                            {{ __('general.explore_dashboard.hero.guest.login') }}
                        </a>
                    @endguest
                </div>

            </div>

            <div class="relative z-10 order-1 flex justify-center lg:order-2 lg:justify-end">
                <div class="absolute inset-[10%] -z-10 rounded-full bg-[#7DD3FC]/55 blur-3xl" aria-hidden="true"></div>
                <span class="pointer-events-none absolute left-[8%] top-[12%] z-0 h-8 w-8 rotate-12 bg-[#FFE100] sm:h-10 sm:w-10"
                      style="-webkit-mask: url('{{ asset('images/decor/star.svg') }}') center / contain no-repeat; mask: url('{{ asset('images/decor/star.svg') }}') center / contain no-repeat;"
                      aria-hidden="true"></span>
                <span class="pointer-events-none absolute right-[5%] top-[20%] z-0 h-6 w-6 -rotate-12 bg-[#FF8FA3] sm:h-8 sm:w-8"
                      style="-webkit-mask: url('{{ asset('images/decor/star.svg') }}') center / contain no-repeat; mask: url('{{ asset('images/decor/star.svg') }}') center / contain no-repeat;"
                      aria-hidden="true"></span>
                <span class="pointer-events-none absolute bottom-[28%] left-[2%] z-20 h-5 w-5 rotate-45 bg-[#A78BFA] sm:h-7 sm:w-7"
                      style="-webkit-mask: url('{{ asset('images/decor/star.svg') }}') center / contain no-repeat; mask: url('{{ asset('images/decor/star.svg') }}') center / contain no-repeat;"
                      aria-hidden="true"></span>
                <span class="pointer-events-none absolute bottom-[18%] right-[2%] z-20 h-7 w-7 -rotate-12 bg-[#38BDF8] sm:h-9 sm:w-9"
                      style="-webkit-mask: url('{{ asset('images/decor/star.svg') }}') center / contain no-repeat; mask: url('{{ asset('images/decor/star.svg') }}') center / contain no-repeat;"
                      aria-hidden="true"></span>
                <span class="pointer-events-none absolute right-[20%] top-[4%] z-20 hidden h-5 w-5 rotate-45 bg-[#34D399] sm:block sm:h-6 sm:w-6"
                      style="-webkit-mask: url('{{ asset('images/decor/star.svg') }}') center / contain no-repeat; mask: url('{{ asset('images/decor/star.svg') }}') center / contain no-repeat;"
                      aria-hidden="true"></span>
                <img src="{{ asset('images/decor/jesus_christ.png') }}"
                     alt="Jesus teaching children"
                     class="relative z-10 w-full max-w-md drop-shadow-2xl sm:max-w-lg lg:max-w-[34rem]">
            </div>
        </div>

        <img src="{{ asset('images/decor/cloud_1.png') }}"
             alt=""
             class="pointer-events-none absolute -bottom-40 left-16 z-[60] w-64 sm:-bottom-52 sm:left-24 sm:w-96 lg:-bottom-64 lg:left-32 lg:w-[28rem]"
             aria-hidden="true">
    </section>

    <section class="relative z-0 overflow-x-clip px-4 pb-16 pt-16 sm:px-6 sm:pb-24 sm:pt-24 lg:px-8">
        <div class="relative z-10 mx-auto grid max-w-6xl gap-5 md:grid-cols-2">
            <article class="group relative isolate overflow-hidden rounded-[2rem] bg-[#004777] p-7 text-white shadow-xl shadow-[#004777]/10 sm:p-10 md:min-h-[440px]">
                <img src="{{ asset('images/decor/background.png') }}"
                     alt=""
                     class="pointer-events-none absolute inset-0 -z-10 h-full w-full object-cover opacity-10"
                     aria-hidden="true">
                <div class="pointer-events-none absolute -right-16 -top-16 -z-10 h-64 w-64 rounded-full bg-[#35A7FF]/40 blur-3xl" aria-hidden="true"></div>

                <h2 class="max-w-md text-3xl font-bold leading-tight sm:text-5xl md:max-w-[80%]">
                    {{ __('general.explore_dashboard.journey_cards.begin.title') }} <span class="text-[#9fd7ff]">{{ __('general.explore_dashboard.journey_cards.begin.highlight') }}</span>
                </h2>
                <p class="mt-5 max-w-sm text-sm leading-7 text-white/75 sm:text-base md:max-w-[58%]">
                    {{ __('general.explore_dashboard.journey_cards.begin.description') }}
                </p>

                <img src="{{ asset('images/decor/card_1.png') }}"
                     alt="{{ __('general.explore_dashboard.journey_cards.begin.image_alt') }}"
                     class="pointer-events-none mx-auto -mb-14 -translate-y-8 w-[15.5rem] drop-shadow-2xl transition duration-500 group-hover:-translate-y-5 group-hover:translate-x-2 sm:w-[18.25rem] md:absolute md:-bottom-2 md:-right-0 md:mb-0 md:mt-0 md:translate-y-0 md:w-64 md:group-hover:-translate-y-2">
            </article>

            <article class="group relative isolate overflow-hidden rounded-[2rem] bg-[#eef8ff] p-7 shadow-xl shadow-[#004777]/10 sm:p-10 md:min-h-[440px]">
                <img src="{{ asset('images/decor/background.png') }}"
                     alt=""
                     class="pointer-events-none absolute inset-0 -z-10 h-full w-full object-cover opacity-[0.04]"
                     aria-hidden="true">
                <div class="pointer-events-none absolute -bottom-20 -left-16 -z-10 h-72 w-72 rounded-full bg-[#35A7FF]/20 blur-3xl" aria-hidden="true"></div>

                <h2 class="max-w-md text-3xl font-bold leading-tight text-[#0f172a] sm:text-5xl md:max-w-[70%]">
                    {{ __('general.explore_dashboard.journey_cards.learn.title') }} <span class="text-[#168bd9]">{{ __('general.explore_dashboard.journey_cards.learn.highlight') }}</span>
                </h2>
                <p class="mt-5 max-w-sm text-sm leading-7 text-slate-600 sm:text-base md:max-w-[58%]">
                    {{ __('general.explore_dashboard.journey_cards.learn.description') }}
                </p>

                <img src="{{ asset('images/decor/card_2.png') }}"
                     alt="{{ __('general.explore_dashboard.journey_cards.learn.image_alt') }}"
                     class="pointer-events-none mx-auto -mb-16 mt-5 -translate-y-8 w-[17rem] drop-shadow-2xl transition duration-500 group-hover:-translate-y-6 group-hover:rotate-2 sm:w-[19.5rem] md:absolute md:-bottom-0 md:-right-2 md:mb-0 md:mt-0 md:translate-y-0 md:w-72 md:group-hover:-translate-y-3">
            </article>

            <article class="group relative isolate overflow-hidden rounded-[2rem] bg-[#f4f1ff] p-7 shadow-xl shadow-[#004777]/10 sm:p-10 md:min-h-[440px]">
                <img src="{{ asset('images/decor/background.png') }}"
                     alt=""
                     class="pointer-events-none absolute inset-0 -z-10 h-full w-full object-cover opacity-[0.04]"
                     aria-hidden="true">
                <div class="pointer-events-none absolute -right-16 -top-16 -z-10 h-64 w-64 rounded-full bg-violet-300/30 blur-3xl" aria-hidden="true"></div>

                <h2 class="max-w-md text-3xl font-bold leading-tight text-[#0f172a] sm:text-5xl md:max-w-[72%]">
                    {{ __('general.explore_dashboard.journey_cards.connect.title') }} <span class="text-violet-600">{{ __('general.explore_dashboard.journey_cards.connect.highlight') }}</span>
                </h2>
                <p class="mt-5 max-w-sm text-sm leading-7 text-slate-600 sm:text-base md:max-w-[58%]">
                    {{ __('general.explore_dashboard.journey_cards.connect.description') }}
                </p>

                <img src="{{ asset('images/decor/card_3.png') }}"
                     alt="{{ __('general.explore_dashboard.journey_cards.connect.image_alt') }}"
                     class="pointer-events-none mx-auto -mb-14 mt-5 -translate-y-8 w-[15.5rem] drop-shadow-2xl transition duration-500 group-hover:-translate-y-6 group-hover:-rotate-2 sm:w-[18.25rem] md:absolute md:-bottom-0 md:-right-2 md:mb-0 md:mt-0 md:translate-y-0 md:w-64 md:group-hover:-translate-y-3">
            </article>

            <article class="group relative isolate overflow-hidden rounded-[2rem] bg-[#fff8df] p-7 shadow-xl shadow-[#004777]/10 sm:p-10 md:min-h-[440px]">
                <img src="{{ asset('images/decor/background.png') }}"
                     alt=""
                     class="pointer-events-none absolute inset-0 -z-10 h-full w-full object-cover opacity-[0.04]"
                     aria-hidden="true">
                <div class="pointer-events-none absolute -bottom-20 -left-16 -z-10 h-72 w-72 rounded-full bg-amber-300/30 blur-3xl" aria-hidden="true"></div>

                <h2 class="max-w-md text-3xl font-bold leading-tight text-[#0f172a] sm:text-5xl md:max-w-[75%]">
                    {{ __('general.explore_dashboard.journey_cards.achieve.title') }} <span class="text-amber-600">{{ __('general.explore_dashboard.journey_cards.achieve.highlight') }}</span>
                </h2>
                <p class="mt-5 max-w-sm text-sm leading-7 text-slate-600 sm:text-base md:max-w-[58%]">
                    {{ __('general.explore_dashboard.journey_cards.achieve.description') }}
                </p>

                <img src="{{ asset('images/decor/card_4.png') }}"
                     alt="{{ __('general.explore_dashboard.journey_cards.achieve.image_alt') }}"
                     class="pointer-events-none mx-auto -mb-16 mt-5 -translate-y-8 w-[17rem] drop-shadow-2xl transition duration-500 group-hover:-translate-y-6 group-hover:rotate-2 sm:w-[19.5rem] md:absolute md:-bottom-7 md:-right-2 md:mb-0 md:mt-0 md:translate-y-0 md:w-72 md:group-hover:-translate-y-3">
            </article>
        </div>

        <img src="{{ asset('images/decor/cloud_2.png') }}"
             alt=""
             class="pointer-events-none absolute -bottom-28 right-4 z-20 w-64 sm:-bottom-36 sm:right-8 sm:w-96 lg:-bottom-48 lg:right-16 lg:w-[30rem]"
             aria-hidden="true">
    </section>

    @if(!$isGuest && !$isMentor && $continueCount)
        <section class="px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
            <div class="mx-auto max-w-6xl">
                <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-[#0f172a] sm:text-4xl">{{ __('general.explore_dashboard.continue.title') }}</h2>
                        <p class="mt-2 text-sm text-slate-600">{{ __('general.explore_dashboard.continue.continue_where_left_off') }}</p>
                    </div>
                    <a href="{{ localized_route('courses.index') }}" class="text-sm font-semibold text-[#004777] hover:text-[#35A7FF]">
                        {{ __('general.explore_dashboard.hero.guest.explore_journey') }}
                    </a>
                </div>

                <div class="flex gap-4 overflow-x-auto pb-3">
                    @foreach($continueCourses as $item)
                        @php
                            $progress = (int) ($item->progress_percentage ?? 0);
                            $progress = max(0, min(100, $progress));

                            $courseImage = $item->course->poster ?? null;
                            $courseImageSrc = null;
                            if ($courseImage) {
                                if (\Illuminate\Support\Str::startsWith($courseImage, ['http://', 'https://'])) {
                                    $courseImageSrc = $courseImage;
                                } elseif (\Illuminate\Support\Str::startsWith($courseImage, 'images/')) {
                                    $courseImageSrc = asset($courseImage);
                                } else {
                                    $courseImageSrc = asset('images/thumbnail/' . $courseImage);
                                }
                            }
                        @endphp

                        <a href="{{ localized_route('courses.show', $item->course->slug) }}"
                           class="w-[280px] shrink-0 overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:-translate-y-0.5 hover:border-[#35A7FF] hover:shadow-xl hover:shadow-[#004777]/5 sm:w-[320px]">
                            @if($courseImageSrc)
                                <img src="{{ $courseImageSrc }}" alt="{{ $item->course->title }}" class="h-40 w-full object-cover">
                            @else
                                <div class="flex h-40 w-full items-center justify-center bg-slate-100 text-sm text-slate-400">
                                    {{ __('general.explore_dashboard.featured_teachings.title') }}
                                </div>
                            @endif

                            <div class="p-5">
                                <p class="text-[11px] font-semibold uppercase tracking-wide text-[#35A7FF]">{{ $item->course->studyProgram?->title }}</p>
                                <h3 class="mt-2 text-base font-bold leading-snug text-[#0f172a]">{{ \Illuminate\Support\Str::limit($item->course->title, 70) }}</h3>
                                <div class="mt-4">
                                    <div class="mb-1 flex items-center justify-between text-xs text-slate-500">
                                        <span>{{ __('general.explore_dashboard.continue.progress') }}</span>
                                        <span class="font-bold text-[#004777]">{{ $progress }}%</span>
                                    </div>
                                    <div class="h-2 overflow-hidden rounded-full bg-[#35A7FF]/15">
                                        <div class="h-2 rounded-full bg-[#004777]" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section id="community" class="px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
        <div class="mx-auto grid max-w-6xl gap-10 md:grid-cols-2 md:items-center">
            <div>
                <h2 class="text-3xl font-bold leading-tight text-[#0f172a] sm:text-5xl">
                    {{ __('general.explore_dashboard.cta.title') }}
                </h2>
                <p class="mt-5 text-base leading-7 text-slate-600 sm:text-lg">
                    {{ __('general.explore_dashboard.cta.description') }}
                </p>

                <ul class="mt-8 space-y-4">
                    <li class="flex gap-3">
                        <span class="mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#35A7FF]/15 text-[#004777]">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M20 6 9 17l-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span>{{ __('general.explore_dashboard.cta.learn.description') }}</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#35A7FF]/15 text-[#004777]">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M20 6 9 17l-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span>{{ __('general.explore_dashboard.cta.disciple.description') }}</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#35A7FF]/15 text-[#004777]">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M20 6 9 17l-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span>{{ __('general.explore_dashboard.cta.community.description') }}</span>
                    </li>
                </ul>

                <a href="{{ localized_route('courses.index') }}"
                   class="mt-8 inline-flex items-center justify-center rounded-xl bg-[#004777] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#00395f]">
                    {{ __('general.explore_dashboard.cta.start_your_journey') }}
                </a>
            </div>

            <div class="relative overflow-hidden rounded-2xl border border-slate-200 p-3">
                <img src="{{ asset('images/decor/church_1.jpeg') }}"
                     alt="{{ __('general.explore_dashboard.defaults.church_illustration') }}"
                     class="h-80 w-full rounded-xl object-cover sm:h-96">
            </div>
        </div>
    </section>

    @if($featuredCount)
        <section id="impact" class="px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
            <div class="mx-auto max-w-6xl">
                <div class="mx-auto mb-12 max-w-2xl text-center">
                    <h2 class="text-3xl font-bold text-[#0f172a] sm:text-5xl">{{ __('general.explore_dashboard.featured_teachings.title') }}</h2>
                    <p class="mt-4 text-base leading-7 text-slate-600 sm:text-lg">{{ __('general.explore_dashboard.featured_teachings.description') }}</p>
                </div>

                <div class="grid gap-6 md:grid-cols-3">
                    @foreach($featured->take(3) as $course)
                        @php
                            $courseImage = $course->poster ?? null;
                            $courseImageSrc = null;
                            if ($courseImage) {
                                if (\Illuminate\Support\Str::startsWith($courseImage, ['http://', 'https://'])) {
                                    $courseImageSrc = $courseImage;
                                } elseif (\Illuminate\Support\Str::startsWith($courseImage, 'images/')) {
                                    $courseImageSrc = asset($courseImage);
                                } else {
                                    $courseImageSrc = asset('images/thumbnail/' . $courseImage);
                                }
                            }
                        @endphp

                        <a href="{{ localized_route('courses.show', $course->slug) }}"
                           class="group overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:-translate-y-0.5 hover:border-[#35A7FF] hover:shadow-xl hover:shadow-[#004777]/5">
                            @if($courseImageSrc)
                                <img src="{{ $courseImageSrc }}" alt="{{ $course->title }}" class="h-44 w-full object-cover">
                            @else
                                <div class="flex h-44 w-full items-center justify-center bg-gradient-to-br from-[#004777]/10 to-[#35A7FF]/10 text-[#004777]">
                                    {{ __('general.explore_dashboard.featured_teachings.title') }}
                                </div>
                            @endif

                            <div class="p-6">
                                <p class="text-xs font-semibold uppercase tracking-wide text-[#35A7FF]">{{ $course->studyProgram?->title }}</p>
                                <h3 class="mt-2 text-lg font-bold leading-snug text-[#0f172a]">{{ \Illuminate\Support\Str::limit($course->title, 80) }}</h3>
                                <p class="mt-2 text-sm text-slate-500">
                                    {{ $course->instructor?->name ?? $course->author ?? __('general.explore_dashboard.defaults.instructor') }}
                                </p>

                                <div class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#004777]">
                                    {{ __('general.explore_dashboard.featured_teachings.open') }}
                                    <svg class="h-4 w-4 transition group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
        <div class="mx-auto max-w-4xl text-center">
            <h2 class="text-3xl font-bold leading-tight text-[#0f172a] sm:text-5xl">
                {{ __('general.explore_dashboard.cta.title') }}
            </h2>
            <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-slate-600 sm:text-xl">
                {{ __('general.explore_dashboard.cta.description') }}
            </p>
            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="{{ localized_route('courses.index') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#004777] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#00395f]">
                    {{ __('general.explore_dashboard.cta.start_your_journey') }}
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                @guest
                    <a href="{{ localized_route('login') }}"
                       class="inline-flex items-center justify-center rounded-xl border border-[#004777]/20 bg-white px-5 py-3 text-sm font-semibold text-[#004777] transition hover:border-[#35A7FF]">
                        {{ __('general.explore_dashboard.hero.guest.login') }}
                    </a>
                @endguest
            </div>
        </div>
    </section>
</div>
