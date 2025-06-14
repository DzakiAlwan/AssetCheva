<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminDosenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error-unauthorized', 'Silahkan login terlebih dahulu');
        }

        if (!in_array(Auth::user()->role, ['admin', 'dosen'])) {
            abort(403, 'Akses terbatas untuk admin dan dosen');
        }

        return $next($request);
    }
}
