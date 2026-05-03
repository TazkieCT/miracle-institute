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
