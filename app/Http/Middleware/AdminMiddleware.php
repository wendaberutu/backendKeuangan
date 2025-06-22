<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;  // Pastikan menggunakan facade Auth

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan pengguna terautentikasi dengan token API (Sanctum / JWT)
        $user = Auth::user();  // Gunakan Auth untuk mengambil pengguna yang terautentikasi

        // Memeriksa apakah pengguna memiliki peran 'admin'
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Access denied'], 403);
        }

        return $next($request);  // Melanjutkan request jika role adalah 'admin'
    }
}
