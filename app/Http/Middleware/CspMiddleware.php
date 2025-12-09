<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CspMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Kita hapus dulu header CSP bawaan (jika ada) biar tidak bentrok
        $response->headers->remove('Content-Security-Policy');
        $response->headers->remove('X-Content-Security-Policy');
        $response->headers->remove('X-WebKit-CSP');

        // Definisi Policy yang Super Longgar (Allow All)
        // Perhatikan bagian 'script-src' yang ada 'unsafe-eval'-nya
        $policy = "default-src * data: blob: 'unsafe-eval' 'unsafe-inline'; " .
                  "script-src * 'unsafe-inline' 'unsafe-eval' blob: data:; " .
                  "style-src * 'unsafe-inline'; " .
                  "img-src * data: blob: 'unsafe-inline'; " .
                  "font-src * data: 'unsafe-inline'; " .
                  "connect-src * 'unsafe-inline'; " .
                  "frame-src *;";

        // Set header baru
        $response->headers->set('Content-Security-Policy', $policy);

        return $response;
    }
}