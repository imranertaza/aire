<?php

namespace App\Services\Common;

use App\Models\Product;
use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class SitemapService
{
    public const CACHE_KEY = 'site_sitemap_xml';
    public const CACHE_TTL = 3600; // 1 hour

    /**
     * Generate or retrieve cached XML sitemap.
     */
    public function generateSitemapXml(bool $forceRefresh = false): string
    {
        if ($forceRefresh) {
            $this->clearCache();
        }

        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            $urls = array_merge(
                $this->getStaticUrls(),
                $this->getCustomPageUrls(),
                $this->getCategoryUrls(),
                $this->getProductUrls()
            );

            return $this->buildXmlDocument($urls);
        });
    }

    /**
     * Clear sitemap cache.
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Collect static core application routes.
     */
    protected function getStaticUrls(): array
    {
        $now = Carbon::now()->toAtomString();
        $urls = [];

        $staticRoutes = [
            'home'            => ['priority' => '1.0', 'changefreq' => 'daily'],
            'products.index'  => ['priority' => '0.9', 'changefreq' => 'daily'],
            'categories'      => ['priority' => '0.8', 'changefreq' => 'daily'],
            'about'           => ['priority' => '0.7', 'changefreq' => 'monthly'],
            'docs'            => ['priority' => '0.7', 'changefreq' => 'weekly'],
            'contact'         => ['priority' => '0.6', 'changefreq' => 'monthly'],
            'compare'         => ['priority' => '0.5', 'changefreq' => 'monthly'],
        ];

        foreach ($staticRoutes as $routeName => $meta) {
            if (Route::has($routeName)) {
                $urls[] = $this->createUrlEntry(
                    route($routeName),
                    $now,
                    $meta['changefreq'],
                    $meta['priority']
                );
            }
        }

        return $urls;
    }

    /**
     * Collect dynamic CMS pages.
     */
    protected function getCustomPageUrls(): array
    {
        $urls = [];

        if (Schema::hasTable('pages') && Route::has('page.details')) {
            $customPages = DB::table('pages')
                ->where('status', 'Active')
                ->select('slug', 'updated_at')
                ->get();

            foreach ($customPages as $cp) {
                if (!empty($cp->slug)) {
                    $urls[] = $this->createUrlEntry(
                        route('page.details', $cp->slug),
                        Carbon::parse($cp->updated_at ?? now())->toAtomString(),
                        'monthly',
                        '0.6'
                    );
                }
            }
        }

        return $urls;
    }

    /**
     * Collect active product categories.
     */
    protected function getCategoryUrls(): array
    {
        $urls = [];

        if (Schema::hasTable('product_categories') && Route::has('category.show')) {
            $categories = ProductCategory::where('status', 1)
                ->select('id', 'slug', 'updated_at')
                ->get();

            foreach ($categories as $cat) {
                $urls[] = $this->createUrlEntry(
                    route('category.show', $cat->slug ?: $cat->id),
                    ($cat->updated_at ?? Carbon::now())->toAtomString(),
                    'weekly',
                    '0.8'
                );
            }
        }

        return $urls;
    }

    /**
     * Collect active products.
     */
    protected function getProductUrls(): array
    {
        $urls = [];

        if (Schema::hasTable('products') && Route::has('products.detail')) {
            $products = Product::where('status', 1)
                ->select('id', 'slug', 'updated_at')
                ->get();

            foreach ($products as $prod) {
                $urls[] = $this->createUrlEntry(
                    route('products.detail', $prod->slug ?: $prod->id),
                    ($prod->updated_at ?? Carbon::now())->toAtomString(),
                    'weekly',
                    '0.8'
                );
            }
        }

        return $urls;
    }

    /**
     * Helper to construct single URL item array.
     */
    protected function createUrlEntry(string $loc, string $lastmod, string $changefreq, string $priority): array
    {
        return [
            'loc'        => $loc,
            'lastmod'    => $lastmod,
            'changefreq' => $changefreq,
            'priority'   => $priority,
        ];
    }

    /**
     * Construct valid XML sitemap string.
     */
    protected function buildXmlDocument(array $urls): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($u['loc'], ENT_XML1, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>" . $u['lastmod'] . "</lastmod>\n";
            $xml .= "    <changefreq>" . $u['changefreq'] . "</changefreq>\n";
            $xml .= "    <priority>" . $u['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }
}
