<?php

namespace App\Http\Controllers;

use App\Services\Common\SitemapService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __construct(
        protected SitemapService $sitemapService
    ) {}

    /**
     * Generate and deliver dynamic XML sitemap for search engines.
     */
    public function index(Request $request): Response
    {
        $xml = $this->sitemapService->generateSitemapXml($request->boolean('refresh'));

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }

    /**
     * Generate dynamic robots.txt with absolute Sitemap URL.
     */
    public function robots(Request $request): Response
    {
        $baseUrl = rtrim($request->schemeAndHttpHost(), '/');
        $sitemapUrl = $baseUrl . '/sitemap.xml';

        $content = implode("\n", [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin/',
            'Disallow: /api/',
            'Disallow: /cart',
            'Disallow: /checkout',
            'Disallow: /customer/',
            'Disallow: /clear',
            'Disallow: /clear-images',
            'Disallow: /clear-sections',
            '',
            'Sitemap: ' . $sitemapUrl,
            '',
        ]);

        return response($content, 200)
            ->header('Content-Type', 'text/plain; charset=utf-8');
    }
}
