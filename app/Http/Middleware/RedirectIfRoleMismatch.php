<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfRoleMismatch
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $activeRole = session('active_role');

        if (!in_array($activeRole, $roles)) {
            return redirect()->to(localized_route('redirect.by.role'));
        }

        return $next($request);
    }
}
