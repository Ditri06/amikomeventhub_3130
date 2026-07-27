<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PartnerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Pastikan role user adalah partner
        if (auth()->user()->role !== 'partner') {
            abort(403, 'Anda tidak memiliki akses ke halaman Partner.');
        }

        // Lanjutkan request jika user adalah partner
        return $next($request);
    }
}
