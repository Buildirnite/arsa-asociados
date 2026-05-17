<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class AdminPassword
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('admin_authenticated')) {
            return $next($request);
        }

        if ($request->isMethod('post')) {
            $key = 'admin-login:' . $request->ip();

            if (RateLimiter::tooManyAttempts($key, 5)) {
                $seconds = RateLimiter::availableIn($key);
                return response()->view('admin.login', [
                    'error' => "Demasiados intentos. Espera {$seconds} segundos.",
                ], 429);
            }

            if ($request->input('password') === config('app.admin_password')) {
                RateLimiter::clear($key);
                $request->session()->put('admin_authenticated', true);
                return redirect()->intended(route('admin.posts.index'));
            }

            RateLimiter::hit($key, 60);

            return response()->view('admin.login', [
                'error' => 'Contraseña incorrecta.',
            ]);
        }

        return response()->view('admin.login', ['error' => null]);
    }
}
