<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $availableLocales = ['en', 'id'];
        $locale = $request->route('locale') ?? session('locale') ?? config('app.locale', 'id');

        if (! in_array($locale, $availableLocales, true)) {
            $locale = config('app.locale', 'id');
        }

        if ($request->route() && $request->route()->hasParameter('locale') && $request->route('locale') !== $locale) {
            $request->route()->setParameter('locale', $locale);
        }

        session()->put('locale', $locale);
        App::setLocale($locale);

        return $next($request);
    }
}
