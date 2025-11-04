<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN apakah dia admin
        if (! $request->user() || ! $request->user()->isAdmin()) {
            // Kalau bukan, lempar ke halaman 403 (Forbidden)
            abort(403);
        }

        return $next($request);
    }
}
