<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DebugAuthMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Debug authentication state
        Log::info('Auth Debug Middleware', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'authenticated' => Auth::check(),
            'user_id' => Auth::id(),
            'user_email' => Auth::user()?->email ?? 'N/A',
            'session_id' => $request->session()->getId(),
            'session_data' => $request->session()->all(),
            'headers' => [
                'user-agent' => $request->header('User-Agent'),
                'accept' => $request->header('Accept'),
                'cookie' => $request->header('Cookie') ? 'Present' : 'Missing',
            ]
        ]);

        return $next($request);
    }
}
