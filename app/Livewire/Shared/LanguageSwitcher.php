<?php

namespace App\Livewire\Shared;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    private const DEFAULT_LOCALE = 'id';

    public string $locale;
    public ?string $currentRouteName = null;
    public array $currentRouteParams = [];
    public array $currentQueryParams = [];
    public string $currentPath = '/';

    public array $availableLocales = [
        'id' => 'Indonesia',
        'en' => 'English',
    ];

    public array $localeFlags = [
        'id' => '🇮🇩',
        'en' => '🇺🇸',
    ];

    public function mount()
    {
        $this->locale = Session::get('locale', config('app.locale', 'id'));
        $this->currentPath = '/' . ltrim(request()->path(), '/');

        if ($this->currentPath === '/index.php') {
            $this->currentPath = '/';
        }
        
        if (request()->route()) {
            $this->currentRouteName = request()->route()->getName();
            $this->currentRouteParams = collect(request()->route()->parameters())
                ->except('locale')
                ->all();
        }

        $this->currentQueryParams = request()->query();
    }

    public function updatedLocale(string $value)
    {
        if (! array_key_exists($value, $this->availableLocales)) {
            return;
        }

        Session::put('locale', $value);
        Cookie::queue(Cookie::forever('locale', $value));
        App::setLocale($value);

        if ($this->currentRouteName) {
            $parameters = array_merge($this->currentRouteParams, $this->currentQueryParams);

            if ($value !== 'id') {
                $parameters['locale'] = $value;
            }

            return redirect()->to(localized_route($this->currentRouteName, $parameters));
        }

        return redirect()->to($this->localizedPathFor($value));
    }

    private function localizedPathFor(string $locale): string
    {
        $path = $this->currentPath === '/' ? '' : trim($this->currentPath, '/');
        $segments = $path === '' ? [] : explode('/', $path);

        if (isset($segments[0]) && in_array($segments[0], array_keys($this->availableLocales), true)) {
            array_shift($segments);
        }

        $basePath = '/' . implode('/', $segments);
        $basePath = $basePath === '/' ? '' : $basePath;

        $targetPath = $locale === self::DEFAULT_LOCALE
            ? ($basePath ?: '/')
            : '/' . $locale . $basePath;

        $query = http_build_query($this->currentQueryParams);

        return $query !== '' ? $targetPath . '?' . $query : $targetPath;
    }

    public function render()
    {
        return view('livewire.shared.language-switcher');
    }
}
