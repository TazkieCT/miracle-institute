<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureRole
{
    public function handle(Request $request, Closure $next, ...$allowedRoles)
    {
        if (!auth()->check()) {
            abort(401);
        }

        $user = $request->user()->loadMissing('roles');
        $userRoles = $user->roles->pluck('name')->values()->all();
        $activeRole = session('active_role');

        $hasAllowedRole = count(array_intersect($allowedRoles, $userRoles)) > 0;
        $activeRoleAllowed = in_array($activeRole, $allowedRoles, true);

        if (!$hasAllowedRole || !$activeRoleAllowed) {
            abort(403, 'Role aktif tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}