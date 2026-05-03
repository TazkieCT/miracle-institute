<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class MenuHelper
{
    public static function getAdminMenu()
    {
        $user = Auth::user();

        return collect(config('menu.admin'))
            ->filter(function ($item) use ($user) {

                if (!$item['permission']) {
                    return true;
                }

                return $user->hasPermission($item['permission']);
            });
    }
}