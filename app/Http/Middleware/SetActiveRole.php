<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SetActiveRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return $next($request);
        }

        $user = $request->user()->loadMissing('roles');
        $availableRoles = $user->roles->pluck('name')->values()->all();

        if (empty($availableRoles)) {
            abort(403, 'User tidak memiliki role yang valid.');
        }

        $activeRole = session('active_role');

        if (!$activeRole || !in_array($activeRole, $availableRoles, true)) {
            $activeRole = $availableRoles[0];
            session(['active_role' => $activeRole]);
        }

        View::share('activeRole', $activeRole);
        View::share('availableRoles', $availableRoles);

        return $next($request);
    }
}