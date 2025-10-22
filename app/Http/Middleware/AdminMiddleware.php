<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // ✅ Kalau request dari AJAX (fetch / JS), balikin JSON error
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Anda bukan admin.'
            ], 403);
        }

        // 🔁 Kalau request biasa, redirect ke dashboard user
        return redirect()->route('dashboard.user');
    }
}
