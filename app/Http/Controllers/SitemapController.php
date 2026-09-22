<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML sitemap for search engines (Google, Bing, etc.)
     */
    public function index(): Response
    {
        // Flush previous sitemap cache if requested via ?refresh=1
        if (request()->has('refresh')) {
            Cache::forget('site_sitemap_xml');
        }

        $xml = Cache::remember('site_sitemap_xml', 3600, function () {
            $urls = [];

            // 1. Static Core Pages
            $urls[] = [
                'loc'        => route('home'),
                'lastmod'    => now()->toAtomString(),
                'changefreq' => 'daily',
                'priority'   => '1.0',
            ];

            if (Route::has('products.index')) {
                $urls[] = [
                    'loc'        => route('products.index'),
                    'lastmod'    => now()->toAtomString(),
                    'changefreq' => 'daily',
                    'priority'   => '0.9',
                ];
            }

            if (Route::has('categories')) {
                $urls[] = [
                    'loc'        => route('categories'),
                    'lastmod'    => now()->toAtomString(),
                    'changefreq' => 'daily',
                    'priority'   => '0.8',
                ];
            }

            if (Route::has('about')) {
                $urls[] = [
                    'loc'        => route('about'),
                    'lastmod'    => now()->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority'   => '0.7',
                ];
            }

            if (Route::has('docs')) {
                $urls[] = [
                    'loc'        => route('docs'),
                    'lastmod'    => now()->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority'   => '0.7',
                ];
            }

            if (Route::has('contact')) {
                $urls[] = [
                    'loc'        => route('contact'),
                    'lastmod'    => now()->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority'   => '0.6',
                ];
            }

            if (Route::has('compare')) {
                $urls[] = [
                    'loc'        => route('compare'),
                    'lastmod'    => now()->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority'   => '0.5',
                ];
            }

            // CMS Custom Pages
            if (Schema::hasTable('pages') && Route::has('page.details')) {
                $customPages = DB::table('pages')
                    ->where('status', 'Active')
                    ->select('slug', 'updated_at')
                    ->get();
                foreach ($customPages as $cp) {
                    if (!empty($cp->slug)) {
                        $urls[] = [
                            'loc'        => route('page.details', $cp->slug),
                            'lastmod'    => Carbon::parse($cp->updated_at ?? now())->toAtomString(),
                            'changefreq' => 'monthly',
                            'priority'   => '0.6',
                        ];
                    }
                }
            }

            // 2. Product Categories
            if (Schema::hasTable('product_categories')) {
                $categories = ProductCategory::where('status', 1)->select('id', 'slug', 'updated_at')->get();
                foreach ($categories as $cat) {
                    $urls[] = [
                        'loc'        => route('category.show', $cat->slug ?: $cat->id),
                        'lastmod'    => ($cat->updated_at ?? now())->toAtomString(),
                        'changefreq' => 'weekly',
                        'priority'   => '0.8',
                    ];
                }
            }

            // 3. Products
            if (Schema::hasTable('products')) {
                $products = Product::where('status', 1)->select('id', 'slug', 'updated_at')->get();
                foreach ($products as $prod) {
                    $urls[] = [
                        'loc'        => route('products.detail', $prod->slug ?: $prod->id),
                        'lastmod'    => ($prod->updated_at ?? now())->toAtomString(),
                        'changefreq' => 'weekly',
                        'priority'   => '0.8',
                    ];
                }
            }


            // Build XML document
            $xmlOutput = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            $xmlOutput .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

            foreach ($urls as $u) {
                $xmlOutput .= "  <url>\n";
                $xmlOutput .= "    <loc>" . htmlspecialchars($u['loc'], ENT_XML1, 'UTF-8') . "</loc>\n";
                $xmlOutput .= "    <lastmod>" . $u['lastmod'] . "</lastmod>\n";
                $xmlOutput .= "    <changefreq>" . $u['changefreq'] . "</changefreq>\n";
                $xmlOutput .= "    <priority>" . $u['priority'] . "</priority>\n";
                $xmlOutput .= "  </url>\n";
            }

            $xmlOutput .= '</urlset>';

            return $xmlOutput;
        });

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }
}
