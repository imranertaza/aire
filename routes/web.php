<?php

use App\Services\ImageService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\EnsureAdminOrSecretKey;
use App\Jobs\RunTestSuiteJob;

/* =========================================================================
| Protected Browser Maintenance & Admin Utility Routes
| ========================================================================= */

Route::middleware([EnsureAdminOrSecretKey::class, 'throttle:30,1'])->group(function () {

    // Dispatch Background or Sync Test Suite Job
    Route::get('/trigger-tests', function (\Illuminate\Http\Request $request) {
        $secret = $request->query('key') ?: $request->query('secret');
        $redirectUrl = '/test-report' . ($secret ? '?key=' . urlencode($secret) : '');

        if ($request->has('sync') || $request->wantsJson() === false) {
            // Run immediately so report is generated right away
            RunTestSuiteJob::dispatchSync();

            return redirect($redirectUrl);
        }

        RunTestSuiteJob::dispatch();

        return response()->json([
            'status'    => true,
            'message'   => 'Test suite execution dispatched to background queue worker! Ensure "php artisan queue:work" is running.',
            'view_url'  => url($redirectUrl),
        ]);
    });

    // View Latest Test Suite Execution Report
    Route::get('/test-report', function (\Illuminate\Http\Request $request) {
        $reportLogPath = storage_path('app/test-reports/latest.log');
        $meta = cache('latest_test_run');
        $secret = $request->query('key') ?: $request->query('secret');
        $keyQuery = $secret ? '?key=' . urlencode($secret) : '';

        if (!File::exists($reportLogPath)) {
            return '<div style="background:#121212; color:#eee; font-family:system-ui, sans-serif; padding:30px; min-height:100vh;">'
                . '<h2 style="color:#60a5fa; margin-top:0;">Automated Test Suite Runner</h2>'
                . '<p style="color:#aaa;">No test report found yet.</p>'
                . '<a href="/trigger-tests' . $keyQuery . '" style="display:inline-block; padding:10px 18px; background:#2563eb; color:#fff; text-decoration:none; border-radius:6px; font-weight:bold;">Trigger Tests Now</a>'
                . '</div>';
        }

        $logContent = File::get($reportLogPath);
        $status = $meta['status'] ?? 'completed';
        $statusColor = $status === 'passed' ? '#22c55e' : ($status === 'running' ? '#f59e0b' : '#ef4444');
        $time = $meta['completed_at'] ?? ($meta['started_at'] ?? 'Recently');

        return '<div style="background:#121212; color:#eee; font-family:system-ui, sans-serif; padding:30px; min-height:100vh;">'
            . '<div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; margin-bottom:20px; border-bottom:1px solid #27272a; padding-bottom:15px;">'
            . '<div>'
            . '<h2 style="margin:0; color:#f8fafc;">Laravel Test Suite Report</h2>'
            . '<p style="margin:6px 0 0 0; color:#a1a1aa; font-size:14px;">Last Run: <strong>' . htmlspecialchars($time) . '</strong> | Status: <span style="font-weight:bold; color:' . $statusColor . '; text-transform:uppercase;">' . htmlspecialchars($status) . '</span></p>'
            . '</div>'
            . '<div style="margin-top:10px;">'
            . '<a href="/trigger-tests' . $keyQuery . '" style="padding:9px 16px; background:#2563eb; color:#fff; text-decoration:none; border-radius:6px; font-size:14px; font-weight:600; margin-right:10px;">Re-run Tests</a>'
            . '<a href="/test-report' . $keyQuery . '" style="padding:9px 16px; background:#27272a; color:#fff; text-decoration:none; border-radius:6px; font-size:14px; font-weight:600;">Refresh</a>'
            . '</div>'
            . '</div>'
            . '<pre style="background:#09090b; color:#4ade80; border:1px solid #27272a; padding:20px; border-radius:8px; overflow-x:auto; font-size:13px; line-height:1.6; font-family:Consolas, Monaco, monospace; white-space:pre-wrap;">'
            . htmlspecialchars($logContent)
            . '</pre>'
            . '</div>';
    });

    // Universal Cache & Image Clear
    Route::get('/clear', function () {
        Artisan::call('optimize:clear');
        Artisan::call('cache:clear');
        Artisan::call('storage:link');

        // Remove the public/cache directory & flush image keys
        $deletedImages = 0;
        if (class_exists(\App\Services\ImageService::class)) {
            $deletedImages = \App\Services\ImageService::clearCache();
        } else {
            $cacheDir = public_path('cache');
            if (File::exists($cacheDir)) {
                File::deleteDirectory($cacheDir);
            }
        }

        // Rebuild theme CSS bundle from source files
        $cssBundleBytes = 0;
        if (function_exists('rebuild_theme_css_bundle')) {
            $cssBundleBytes = rebuild_theme_css_bundle();
        }

        return response()->json([
            'status'  => true,
            'message' => 'Application cache cleared, storage linked, theme CSS bundled, and ' . $deletedImages . ' cached image(s) purged successfully!',
            'cleared' => [
                'config_cache'       => true,
                'route_cache'        => true,
                'view_cache'         => true,
                'application_cache'  => true,
                'storage_symlink'    => true,
                'image_cache_files'  => $deletedImages,
                'theme_css_bundle_kb' => round($cssBundleBytes / 1024, 2),
            ],
        ]);
    });

    // Rebuild Theme CSS Bundle On-Demand
    Route::get('/build-css', function () {
        $cssBundleBytes = function_exists('rebuild_theme_css_bundle') ? rebuild_theme_css_bundle() : 0;
        return response()->json([
            'status'  => true,
            'message' => 'Theme CSS bundle compiled and minified successfully! Total size: ' . round($cssBundleBytes / 1024, 2) . ' KB',
            'bundle_size_kb' => round($cssBundleBytes / 1024, 2),
        ]);
    });

    // Storage Symlink Route
    Route::get('/storage-link', function () {
        Artisan::call('storage:link');
        return response()->json([
            'status'  => true,
            'message' => 'Storage symlink created/verified!',
        ]);
    });

    // Production Cache & Optimize
    Route::get('/optimize', function () {
        Artisan::call('optimize');
        Artisan::call('view:cache');

        return response()->json([
            'status'  => true,
            'message' => 'Application config, routes, events, and Blade views compiled & optimized successfully!',
            'cached'  => [
                'config_cached' => true,
                'routes_cached' => true,
                'views_cached'  => true,
            ],
        ]);
    });
});

/* Storefront Multi-Theme Routes */
Route::controller(\App\Http\Controllers\StorefrontController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/resources', 'resources')->name('resources');
    Route::get('/resources/category/{slug}', 'resourceCategory')->name('resources.category');
    Route::get('/resources/download/{id}', 'downloadResource')->name('resources.download');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'submitContact')->name('contact.submit');
    Route::get('/page/{slug}', 'pageDetails')->name('page.show');
    Route::get('/pages/{slug}', 'pageDetails')->name('page.details');
    Route::get('/news', 'newsIndex')->name('news.index');
    Route::get('/news-and-updates', 'newsIndex')->name('news-and-updates');
    Route::get('/news/{slug}', 'newsDetails')->name('news.show');
    Route::get('/news-and-updates/{slug}', 'newsDetails')->name('news-and-updates-details');
    Route::post('/newsletter/subscribe', 'subscribeNewsletter')->name('newsletter.subscribe');
    Route::match(['get', 'post'], '/newsletter/unsubscribe/{token}', 'unsubscribe')->name('newsletter.unsubscribe');
    Route::post('/newsletter/resubscribe/{token}', 'resubscribe')->name('newsletter.resubscribe');
});

Route::controller(\App\Http\Controllers\ProductController::class)->group(function () {
    Route::get('/categories', 'categories')->name('categories');
    Route::get('/products', 'categories')->name('products.index');
    Route::get('/category/{slug}/all', 'categoriesDetails')->name('category.all');
    Route::get('/category/{slug?}', 'categories')->name('category.show');
    Route::get('/category/details/{sub_category_slug}', 'categoriesDetails')->name('category.detail');
    Route::get('/products-filter/{sub_category_slug?}', 'productFilter')->name('products.filter');
    Route::get('/product-landing/{slug?}', 'productLanding')->name('products.landing');
    Route::get('/filter', 'filter')->name('products.filter-step');
    Route::get('/product-finder', 'filter')->name('products.finder');
    Route::get('/finder', 'filter')->name('products.finder-short');
    Route::match(['get', 'post'], '/api/filter-wizard/query', 'filterStepApi')->name('api.filter-step.query');
    Route::get('/products/{slug}', 'productDetail')->name('products.detail');
    Route::get('/favorite', 'favorite')->name('favorite');
    Route::post('/favorite/toggle', 'toggleFavorite')->name('favorite.toggle');
    Route::get('/compare', 'compare')->name('compare');
    Route::get('/products-dropdown', 'dropdownList')->name('product.dropdown');
    Route::post('/compare/add', 'addToCompare')->name('compare.add');
    Route::post('/compare/remove', 'removeFromCompare')->name('compare.remove');
    Route::post('/compare/clear', 'clearCompare')->name('compare.clear');
});

Route::controller(\App\Http\Controllers\CartController::class)->group(function () {
    Route::get('/cart', 'cart')->name('cart');
    Route::post('/cart/add', 'addToCart')->name('cart.add');
    Route::post('/cart/update', 'updateCart')->name('cart.update');
    Route::post('/cart/remove', 'removeFromCart')->name('cart.remove');
    Route::post('/cart/save-later', 'saveForLater')->name('cart.save-later');
    Route::post('/cart/move-to-cart', 'moveToCart')->name('cart.move-to-cart');
    Route::post('/cart/remove-saved', 'removeSaved')->name('cart.remove-saved');
    Route::get('/cart/count', 'getCartCount')->name('cart.count');
});

Route::controller(\App\Http\Controllers\CheckoutController::class)->group(function () {
    Route::get('/checkout', 'checkout')->name('checkout');
    Route::post('/checkout', 'postCheckout')->name('checkout.post');
    Route::post('/checkout/zones', 'getZones')->name('checkout.zones');
    Route::post('/checkout/shipping-rate', 'getShippingRate')->name('checkout.shipping-rate');
    Route::post('/coupon/apply', 'applyCoupon')->name('coupon.apply');
    Route::post('/coupon/remove', 'removeCoupon')->name('coupon.remove');
    Route::get('/order-confirm', 'orderConfirm')->name('order.confirm');
});

Route::middleware('customer.guest')->group(function () {
    Route::controller(\App\Http\Controllers\CustomerAuthController::class)->group(function () {
        Route::get('/signin', 'signin')->name('signin');
        Route::post('/signin', 'postSignin')->name('signin.post');
        Route::get('/login', 'signin')->name('login');
        Route::get('/signup', 'signup')->name('signup');
        Route::post('/signup', 'postSignup')->name('signup.post');

        // Password Reset Routes
        Route::get('/forgot-password', 'forgotPassword')->name('password.request');
        Route::post('/forgot-password', 'sendResetLinkEmail')->name('password.email');
        Route::get('/reset-password/{token}', 'resetPassword')->name('password.reset');
        Route::post('/reset-password', 'updatePassword')->name('password.update');
    });
});

Route::middleware('customer.auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\CustomerAuthController::class, 'logout'])->name('logout');

    Route::controller(\App\Http\Controllers\CustomerDashboardController::class)->group(function () {
        Route::get('/customer/dashboard', 'dashboard')->name('customer.dashboard');
        Route::get('/customer/orders', 'customerOrders')->name('customer.orders');
        Route::get('/customer/orders/{id}', 'customerOrderDetail')->name('customer.orders.detail');
        Route::get('/customer/orders/{id}/invoice', 'orderInvoice')->name('customer.invoice');
        Route::get('/customer/profile', 'customerProfile')->name('customer.profile');
        Route::post('/customer/profile', 'updateProfile')->name('customer.profile.update');
        Route::get('/customer/wallet', 'customerWallet')->name('customer.wallet');
        Route::post('/customer/wallet/add-funds', 'customerAddFund')->name('customer.wallet.add-funds');
        Route::get('/customer/ledger', 'customerLedger')->name('customer.ledger');
        Route::get('/customer/points', 'customerPoints')->name('customer.points');
        Route::post('/customer/wishlist/toggle', 'toggleWishlist')->name('customer.wishlist.toggle');
    });
});

// Dynamic XML Sitemap & Robots.txt for Search Engines (Google, Bing)
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [\App\Http\Controllers\SitemapController::class, 'robots'])->name('robots');

/* Dynamic image resize & cache route (returns 301 immutable redirect to static file) */
Route::get('/image/{width}/{height}/{format}/{path}', function ($width, $height, $format, $path) {
    $fullPath = $path;
    $url = ImageService::resizeAndCache($fullPath, (int) $width, (int) $height, $format);

    return redirect($url, 301, [
        'Cache-Control' => 'public, max-age=31536000, immutable'
    ]);
})->where('path', '.*');

/* Image resize redirect route (legacy support) */
Route::get('/image_url/{width}/{height}/{format}/{path}', function ($width, $height, $format, $path) {
    $fullPath = $path;
    $url = ImageService::resizeAndCache($fullPath, (int) $width, (int) $height, $format);

    return redirect($url, 301, [
        'Cache-Control' => 'public, max-age=604800, immutable'
    ]);
})->where('path', '.*');

/* Admin panel routes */

/* Catch-all route for Vue SPA admin panel */
Route::get('admin/{any?}', function () {
    return view('welcome');
})->where('any', '.*');
