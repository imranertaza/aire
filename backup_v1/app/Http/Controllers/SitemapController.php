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
}
