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

/* Frontend Routes - Public website pages */
Route::controller(FrontendController::class)->group(function () {
    // Route::get('/', 'index')->name('home');
    Route::get('/', function () {
        return view('welcome12');
    })->name('home');
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
