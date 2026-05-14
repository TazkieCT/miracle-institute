<?php

/**
 * Simpan log aktivitas pengguna ke database.
 *
 * @param string $action
 * @param int|null $userId
 * @param array $payload
 * @return void
 */
if (!function_exists('activity_log')) {
    function activity_log($action, $userId = null, $payload = [])
    {
        \App\Models\ActivityLog::create([
            'user_id' => $userId ?? (auth()->check() ? auth()->id() : null),
            'action'  => $action,
            'payload' => json_encode($payload),
        ]);
    }
}

/**
 * Generate a URL for a named route while preserving the current locale.
 *
 * @param string $routeName
 * @param array $parameters
 * @return string
 */
if (!function_exists('localized_route')) {
    function localized_route($routeName, $parameters = [])
    {
        $locale = session('locale', config('app.locale', 'id'));
        $parameters = array_merge(['locale' => $locale], $parameters);
        
        return route($routeName, $parameters);
    }
}
