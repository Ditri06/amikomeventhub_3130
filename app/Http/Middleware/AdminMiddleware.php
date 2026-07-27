<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login dan memiliki role admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman Admin.');
        }

        return $next($request);
    }
}
