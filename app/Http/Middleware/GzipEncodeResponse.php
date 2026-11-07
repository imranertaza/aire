<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GzipEncodeResponse
{
    /**
     * Handle an incoming request.
     *
     * Automatically applies GZIP compression to text, HTML, and JSON responses
     * when supported by the client browser (saving 70-85% bandwidth & reducing LCP).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Skip binary file responses, streams, HEAD requests, or if zlib/gzencode unavailable
        // Also skip in development / debug mode to prevent breaking Laravel Debugbar and devtools
        if (
            config('app.debug') ||
            !app()->isProduction() ||
            $response instanceof BinaryFileResponse ||
            $response instanceof StreamedResponse ||
            $request->isMethod('HEAD') ||
            !function_exists('gzencode')
        ) {
            return $response;
        }

        // Only compress if client explicitly accepts gzip
        $acceptEncoding = $request->header('Accept-Encoding', '');
        if (!str_contains($acceptEncoding, 'gzip')) {
            return $response;
        }

        // Avoid double compression if already encoded
        if ($response->headers->has('Content-Encoding')) {
            return $response;
        }

        // Skip empty, redirect, or informational status codes
        $statusCode = $response->getStatusCode();
        if ($statusCode < 200 || $statusCode === 204 || ($statusCode >= 300 && $statusCode < 400)) {
            return $response;
        }

        $content = $response->getContent();
        if (empty($content) || strlen($content) < 512) {
            return $response;
        }

        // Only compress text-based content types
        $contentType = $response->headers->get('Content-Type', '');
        if (!preg_match('/(text\/|application\/json|application\/xml|application\/javascript|image\/svg\+xml)/i', $contentType)) {
            return $response;
        }

        // Compress using optimal level 6 (optimal balance between CPU overhead & compression ratio)
        $compressed = gzencode($content, 6);
        if ($compressed !== false && strlen($compressed) < strlen($content)) {
            $response->setContent($compressed);
            $response->headers->set('Content-Encoding', 'gzip');
            $response->headers->set('Content-Length', (string) strlen($compressed));
            $response->headers->set('Vary', 'Accept-Encoding');
        }

        return $response;
    }
}
