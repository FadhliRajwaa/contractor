<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        // If user is already authenticated, redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'string', 'email'],
                'password' => ['required', 'string'],
            ]);
        } catch (ValidationException $e) {
            \Log::warning('Login validation failed', [
                'email' => $request->input('email'),
                'ip' => $request->ip(),
                'errors' => $e->errors()
            ]);
            throw $e;
        }

        // Check rate limiting
        $this->checkTooManyFailedAttempts($request);

        // Attempt login
        if (Auth::attempt(
            $request->only('email', 'password'),
            $request->filled('remember')
        )) {
            $request->session()->regenerate();
            RateLimiter::clear($this->throttleKey($request));

            // Check if user is active
            if (!Auth::user()->is_active) {
                $email = Auth::user()->email;
                Auth::logout();
                
                \Log::warning('Inactive user attempted login', [
                    'email' => $email,
                    'ip' => $request->ip(),
                ]);
                
                throw ValidationException::withMessages([
                    'email' => '🚫 Akun Anda telah dinonaktifkan. Silakan hubungi administrator untuk informasi lebih lanjut.',
                ]);
            }

            // Log successful login for debugging
            \Log::info('User logged in successfully', [
                'user_id' => Auth::id(),
                'email' => Auth::user()->email,
                'session_id' => $request->session()->getId(),
            ]);

            // Ensure proper redirect to dashboard
            return redirect()->intended(route('dashboard'));
        }

        // Failed login
        RateLimiter::hit($this->throttleKey($request), 60);
        
        \Log::warning('Failed login attempt', [
            'email' => $request->input('email'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        throw ValidationException::withMessages([
            'email' => '❌ Email atau password yang Anda masukkan salah. Silakan periksa kembali.',
        ]);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Get the rate limiting throttle key
     */
    protected function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());
    }

    /**
     * Check if too many failed login attempts
     */
    protected function checkTooManyFailedAttempts(Request $request): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        \Log::warning('Too many login attempts', [
            'email' => $request->input('email'),
            'ip' => $request->ip(),
            'retry_after_seconds' => $seconds,
        ]);
        
        throw ValidationException::withMessages([
            'email' => '⏱️ Terlalu banyak percobaan login. Silakan coba lagi dalam ' . ceil($seconds / 60) . ' menit.',
        ]);
    }
}
