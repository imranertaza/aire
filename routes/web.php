<?php

use App\Http\Controllers\FrontendController;
use App\Services\ImageService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

/* Utility route for clearing all caches */

Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    Artisan::call('storage:link');

    // Remove the public/cache directory
    $cacheDir = public_path('cache');
    if (File::exists($cacheDir)) {
        File::deleteDirectory($cacheDir);
    }

    return "Application cache cleared!";
});

/* Storefront Multi-Theme Routes */
Route::controller(\App\Http\Controllers\StorefrontController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/solutions', 'solutions')->name('solutions');
    Route::get('/about', 'about')->name('about');
    Route::get('/docs', 'docs')->name('docs');
    Route::get('/contact', 'contact')->name('contact');
});

Route::controller(\App\Http\Controllers\ProductController::class)->group(function () {
    Route::get('/categories', 'categories')->name('categories');
    Route::get('/products', 'categories')->name('products.index');
    Route::get('/category/{slug?}', 'categories')->name('category.show');
    Route::get('/product-filter/{sub_category_slug?}', 'productFilter')->name('products.filter');
    Route::get('/product-landing', 'productLanding')->name('products.landing');
    Route::get('/filter', 'filter')->name('products.filter-step');
    Route::post('/api/filter-wizard/query', 'filterStepApi')->name('api.filter-step.query');
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

/* Legacy / Secondary Frontend Routes */
Route::controller(FrontendController::class)->group(function () {
    Route::get('match-fixtures', 'matchFixtures')->name('match-fixtures');
    Route::get('notice-board', 'noticeBoard')->name('notice-board');
    // Route::get('tournament-result', 'tournamentResult')->name('tournament-result');
    Route::get('/photo-gallery', 'gallery')->name('gallery');
    Route::get('gallery-details/{id}', 'galleryDetails')->name('gallery-details');
    Route::get('news-and-updates', 'newsAndUpdates')->name('news-and-updates');
    Route::get('spotlights', 'spotlightNews')->name('spotlight-news');
    Route::get('news-and-updates/{slug}', 'newsAndUpdatesDetails')->name('news-and-updates-details');
    Route::get('blogs', 'blogs')->name('blogs');
    Route::get('blogs/{slug}', 'blogsDetails')->name('blogs-details');
    // Route::get('players', 'players')->name('player.index');
    Route::get('players/{slug}', 'playerDetails')->name('player.details');
    Route::get('post-categories/{slug}', 'postCategoryDetails')->name('post-categories');
    Route::get('sports/{slug}', 'postDetails')->name('sports-details');

    Route::get('running-events', 'runningEvents')->name('running-events');
    // Route::get('upcoming-events', 'upcomingEvents')->name('upcoming-events');
    Route::get('events/{slug}', 'runningEventsDetails')->name('event-details');
    // Route::get('executive-committee', 'committeeMembers')->name('committee-members');
    Route::get('executive-committee/{slug}', 'committeeMembersDetails')->name('committee-members-details');
    Route::post('contact-us', 'contactSubmit')->name('contact.submit');

    /* Static pages */
    Route::prefix('pages')->name('page.')->group(function () {
        Route::get('/', 'pages')->name('index');
        Route::get('/{slug}', 'pageDetails')->name('details');
    });

    /* Dynamic image resize & cache route (returns file directly) */
    Route::get('/image/{width}/{height}/{format}/{path}', function ($width, $height, $format, $path) {
        $fullPath = $path;
        $url = ImageService::resizeAndCache($fullPath, (int) $width, (int) $height, $format);

        // Convert URL back to actual file path
        $filePath = public_path(str_replace(asset(''), '', $url));

        // Return raw file with correct headers
        return Response::file($filePath, [
            'Content-Type'  => 'image/' . $format,
            'Cache-Control' => 'public, max-age=604800' // 1 week cache
        ]);
    })->where('path', '.*');

    /* Image resize redirect route (legacy support) */
    Route::get('/image_url/{width}/{height}/{format}/{path}', function ($width, $height, $format, $path) {
        $fullPath = $path;
        $url = ImageService::resizeAndCache($fullPath, (int) $width, (int) $height, $format);

        return redirect($url);
    })->where('path', '.*');
});

/* Admin panel routes */

/* Catch-all route for Vue SPA admin panel */
Route::get('admin/{any?}', function () {
    return view('welcome');
})->where('any', '.*');
