<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowHomeAccess
{
    /**
     * Handle an incoming request.
     * Middleware ini memastikan halaman "/" (beranda) dapat diakses oleh semua user
     * tanpa redirect ke admin dashboard, terlepas dari role mereka.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user mengakses "/" (beranda), izinkan akses normal
        // tanpa ada redirect ke admin dashboard
        if ($request->path() === '/' || $request->path() === '') {
            // User boleh akses beranda, tidak perlu redirect
            return $next($request);
        }

        return $next($request);
    }
}
