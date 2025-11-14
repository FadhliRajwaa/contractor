<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Supports multiple roles separated by pipe: 'role1|role2|role3'
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Split roles by pipe and check if user has any of the roles
        $allowedRoles = explode('|', $roles);
        
        $hasRole = false;
        foreach ($allowedRoles as $role) {
            if ($request->user()->hasRole(trim($role))) {
                $hasRole = true;
                break;
            }
        }

        if (!$hasRole) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini. Role yang dibutuhkan: ' . $roles);
        }

        return $next($request);
    }
}
