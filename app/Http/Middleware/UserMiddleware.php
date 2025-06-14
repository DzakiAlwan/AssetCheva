<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error-unauthorized', 'Silahkan login terlebih dahulu');
        }

        if (Auth::user()->role !== 'mahasiswa') {
            abort(403, 'Akses terbatas untuk mahasiswa');
        }

        return $next($request);
    }
}
