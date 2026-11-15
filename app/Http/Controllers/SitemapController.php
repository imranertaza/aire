<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\ProductCategory;
use App\Models\ResourceCategory;
use App\Services\Common\SitemapService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SitemapController extends Controller
{
    public function __construct(
        protected SitemapService $sitemapService
    ) {}

    /**
     * Display the human-readable Apple-style Site Map page.
     */
    public function htmlSitemap(Request $request): View
    {
        $categories = Cache::remember('html_sitemap_categories_v4', 3600, function () {
            return ProductCategory::active()
                ->where(function ($q) {
                    $q->whereNull('parent_id')->orWhere('parent_id', 0);
                })
                ->with([
                    'products' => fn($pq) => $pq->where('products.status', 1)->select('products.id', 'products.name', 'products.slug')->take(6),
                    'children' => fn($q) => $q->active()->with([
                        'products' => fn($pq) => $pq->where('products.status', 1)->select('products.id', 'products.name', 'products.slug')->take(6),
                        'children' => fn($gq) => $gq->active()->with([
                            'products' => fn($pq) => $pq->where('products.status', 1)->select('products.id', 'products.name', 'products.slug')->take(6)
                        ])
                    ])
                ])
                ->orderBy('sort_order')
                ->get();
        });

        $resourceCategories = Cache::remember('html_sitemap_resource_cats_v1', 3600, function () {
            return class_exists(ResourceCategory::class)
                ? ResourceCategory::active()->get()
                : collect();
        });

        $cmsPages = Cache::remember('html_sitemap_pages_v2', 3600, function () {
            return class_exists(Page::class)
                ? Page::active()->select('id', 'page_title', 'slug')->orderBy('page_title')->get()
                : collect();
        });

        return \theme_view('sitemap', compact('categories', 'resourceCategories', 'cmsPages'));
    }

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
