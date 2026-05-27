<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const SUPPORTED_LOCALES = ['en', 'id'];
    private const DEFAULT_LOCALE = 'id';

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = (string) (
            $request->route('locale')
            ?? session('locale')
            ?? config('app.locale', self::DEFAULT_LOCALE)
        );

        if (! in_array($locale, self::SUPPORTED_LOCALES, true)) {
            $locale = self::DEFAULT_LOCALE;
        }

        session()->put('locale', $locale);
        App::setLocale($locale);
        Carbon::setLocale($locale);

        URL::defaults($locale === self::DEFAULT_LOCALE
            ? []
            : ['locale' => $locale]);

        return $next($request);
    }
}
