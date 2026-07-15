<?php

use App\Http\Controllers\Api\AdminDashboardController;
use App\Http\Controllers\Api\AdminRoleController;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\BlogCategoryController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommitteeMemberController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\MenuItemController;
use App\Http\Controllers\Api\NewsCategoryController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\NoticeController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ResultController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\EventCategoryController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/* Admin Authentication Routes */

Route::prefix('admin')->controller(AdminAuthController::class)->group(function () {
    Route::post('login', 'login')->name('admin.login');

    Route::middleware('auth:user')->group(function () {
        Route::get('me', 'me')->name('admin.me');
        Route::get('profile', 'profile')->name('admin.profile');
        Route::post('logout', 'logout')->name('admin.logout');
    });
});
Route::get('/dashboard', [AdminDashboardController::class, 'index'])->middleware('auth:user');
/* Admin Users & Role/Permission Management */
Route::middleware(['auth:user'])->controller(AdminRoleController::class)->group(function () {
    Route::get('admins', 'index');
    Route::get('admins/{admin}', 'show');
    Route::put('admins/{admin}', 'updateUser')->middleware('permission:update-users');
    Route::put('admins/{admin}/role', 'updateUserRole')->middleware('permission:update-users');
    Route::post('admins', 'store')->middleware('permission:create-users');
    Route::delete('admins/{admin}', 'destroy')->middleware('permission:delete-users');

    // Role & Permissions
    Route::get('roles', 'roles');
    Route::get('roles-with-permissions', 'rolesWithPermissions');
    Route::put('roles/{role}/permissions', 'updatePermissions')->middleware('permission:update-permissions');
    Route::get('permissions', 'permissions');
});

/* Posts Management */
Route::middleware('auth:user')->prefix('posts')->controller(PostController::class)->group(function () {
    Route::get('/', 'index')->middleware('permission:view-posts');
    Route::post('/', 'store')->middleware('permission:create-posts');
    Route::get('{id}', 'show')->middleware('permission:view-posts');
    Route::put('{id}', 'update')->middleware('permission:edit-posts');
    Route::delete('{id}', 'destroy')->middleware('permission:delete-posts');
    Route::patch('{id}/status', 'toggleStatus')->middleware('permission:publish-posts');
});

/* Pages Management */
Route::middleware('auth:user')->prefix('pages')->controller(PageController::class)->group(function () {
    Route::get('/', 'index')->middleware('permission:view-pages');
    Route::post('/', 'store')->middleware('permission:create-pages');
    Route::get('{id}', 'show')->middleware('permission:view-pages');
    Route::put('{id}', 'update')->middleware('permission:edit-pages');
    Route::delete('{id}', 'destroy')->middleware('permission:delete-pages');
    Route::patch('{id}/status', 'toggleStatus')->middleware('permission:publish-pages');
});

/* Frontend Sections & Sliders */
Route::prefix('sections')->middleware(['auth:user', 'permission:manage-frontend'])->controller(SectionController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('{id}', 'show')->name('sections.show');
    Route::put('{id}', 'update')->name('sections.update');
});

Route::prefix('sliders')->middleware(['auth:user', 'permission:manage-frontend'])->controller(SliderController::class)->group(function () {
    Route::get('/{key}', 'bannerSliders');
    Route::get('/{id}/show', 'show');
    Route::post('/', 'store');
    Route::post('/{id}', 'update');
    Route::patch('/{id}/toggle', 'toggle')->name('sliders.toggle');
    Route::delete('/{id}', 'destroy');
});

/* Global Settings */
Route::middleware('auth:user')->prefix('settings')->controller(SettingsController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/update', 'update');
    Route::get('/security', 'getSecuritySettings');
});

/* Categories */
Route::prefix('categories')->middleware(['auth:user'])->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index')->middleware('permission:view-categories');
    Route::post('/', 'store')->middleware('permission:create-categories');

    Route::prefix('{category}')->group(function () {
        Route::get('/', 'show')->middleware('permission:view-categories');
        Route::put('/', 'update')->middleware('permission:edit-categories');
        Route::patch('/', 'updateStatus')->middleware('permission:edit-categories');
        Route::delete('/', 'destroy')->middleware('permission:delete-categories');
    });
});

/* News & News Categories */
Route::middleware('auth:user')->prefix('news')->controller(NewsController::class)->group(function () {
    Route::get('/', 'index')->middleware('permission:view-news');
    Route::post('/', 'store')->middleware('permission:create-news');
    Route::get('{id}', 'show')->middleware('permission:view-news');
    Route::put('{id}', 'update')->middleware('permission:edit-news');
    Route::delete('{id}', 'destroy')->middleware('permission:delete-news');
    Route::patch('{id}/status', 'toggleStatus')->middleware('permission:publish-news');
});

Route::prefix('news-categories')->middleware(['auth:user'])->controller(NewsCategoryController::class)->group(function () {
    Route::get('/', 'index')->middleware('permission:view-news-categories');
    Route::post('/', 'store')->middleware('permission:create-news-categories');

    Route::prefix('{category}')->group(function () {
        Route::get('/', 'show')->middleware('permission:view-news-categories');
        Route::put('/', 'update')->middleware('permission:edit-news-categories');
        Route::patch('/', 'updateStatus')->middleware('permission:edit-news-categories');
        Route::delete('/', 'destroy')->middleware('permission:delete-news-categories');
    });
});

/* Blogs & Blog Categories */
Route::middleware('auth:user')->prefix('blogs')->controller(BlogController::class)->group(function () {
    Route::get('/', 'index')->middleware('permission:view-blog');
    Route::post('/', 'store')->middleware('permission:create-blog');
    Route::get('{id}', 'show')->middleware('permission:view-blog');
    Route::put('{id}', 'update')->middleware('permission:edit-blog');
    Route::delete('{id}', 'destroy')->middleware('permission:delete-blog');
    Route::patch('{id}/status', 'toggleStatus')->middleware('permission:publish-blog');
});

Route::prefix('blog-categories')->middleware(['auth:user'])->controller(BlogCategoryController::class)->group(function () {
    Route::get('/', 'index')->middleware('permission:view-blog-categories');
    Route::post('/', 'store')->middleware('permission:create-blog-categories');

    Route::prefix('{category}')->group(function () {
        Route::get('/', 'show')->middleware('permission:view-blog-categories');
        Route::put('/', 'update')->middleware('permission:edit-blog-categories');
        Route::patch('/', 'updateStatus')->middleware('permission:edit-blog-categories');
        Route::delete('/', 'destroy')->middleware('permission:delete-blog-categories');
    });
});

/* Menus & Menu Items */
Route::prefix('menus')->middleware(['auth:user', 'permission:manage-menus'])->controller(MenuController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::prefix('{menu}')->group(function () {
        Route::get('/', 'show');
        Route::put('/', 'update');
        Route::delete('/', 'destroy');
    });
});

Route::prefix('menu-items')->middleware(['auth:user', 'permission:manage-menus'])->controller(MenuItemController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('{menuItem}', 'show');
    Route::put('{menuItem}', 'update');
    Route::delete('{menuItem}', 'destroy');
    Route::post('reorder', 'reorder');
});

/* Media Management */
Route::middleware(['auth:user'])->prefix('media')->controller(MediaController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/upload', 'upload');
    Route::delete('/file', 'deleteFile');
});

/* Gallery Management */
Route::middleware(['auth:user'])->prefix('gallery')->controller(GalleryController::class)->group(function () {
    Route::get('/', 'index')->name('gallery.index')->middleware('permission:view-galleries');
    Route::post('/', 'store')->name('gallery.store')->middleware('permission:create-galleries');
    Route::get('{gallery}', 'show')->name('gallery.show')->middleware('permission:view-galleries');
    Route::put('{gallery}', 'update')->name('gallery.update')->middleware('permission:edit-galleries');
    Route::delete('{gallery}', 'destroy')->name('gallery.destroy')->middleware('permission:delete-galleries');
    Route::patch('{id}/toggle-status', 'toggleStatus')->name('gallery.toggle')->middleware('permission:edit-galleries');

    // Gallery Details (Images)
    Route::post('details', 'storeDetail')->name('gallery.details.store')->middleware('permission:edit-galleries');
    Route::patch('details/{detail}', 'updateDetail')->name('gallery.details.update')->middleware('permission:edit-galleries');
    Route::delete('details/{detail}', 'destroyGalleryDetail')->name('gallery.details.destroy')->middleware('permission:delete-galleries');
});

/* Events & Event Categories */
Route::prefix('events')->middleware(['auth:user'])->controller(EventController::class)->group(function () {
    Route::get('/', 'index')->name('events.index')->middleware('permission:view-events');
    Route::post('/', 'store')->name('events.store')->middleware('permission:create-events');
    Route::get('{id}', 'show')->name('events.show')->middleware('permission:view-events');
    Route::put('{id}', 'update')->name('events.update')->middleware('permission:edit-events');
    Route::patch('{id}/toggle-status', 'toggleStatus')->name('events.toggle')->middleware('permission:edit-events');
    Route::delete('{id}', 'destroy')->name('events.destroy')->middleware('permission:delete-events');
});

Route::prefix('events-categories')->middleware(['auth:user'])->controller(EventCategoryController::class)->group(function () {
    Route::get('/', 'index')->middleware('permission:view-events-categories');
    Route::post('/', 'store')->middleware('permission:create-events-categories');

    Route::prefix('{category}')->group(function () {
        Route::get('/', 'show')->middleware('permission:view-events-categories');
        Route::put('/', 'update')->middleware('permission:edit-events-categories');
        Route::patch('/', 'updateStatus')->middleware('permission:edit-events-categories');
        Route::delete('/', 'destroy')->middleware('permission:delete-events-categories');
    });
});

/* Notices */
Route::prefix('notices')->middleware(['auth:user'])->controller(NoticeController::class)->group(function () {
    Route::get('/', 'index')->name('notices.index')->middleware('permission:view-notices');
    Route::post('/', 'store')->name('notices.store')->middleware('permission:create-notices');
    Route::get('{id}', 'show')->name('notices.show')->middleware('permission:view-notices');
    Route::put('{id}', 'update')->name('notices.update')->middleware('permission:edit-notices');
    Route::patch('{id}/toggle-status', 'toggleStatus')->name('notices.toggle')->middleware('permission:edit-notices');
    Route::delete('{id}', 'destroy')->name('notices.destroy')->middleware('permission:delete-notices');
});

/* Brands */
Route::prefix('brands')->middleware(['auth:user'])->controller(BrandController::class)->group(function () {
    Route::get('/', 'index')->name('brands.index')->middleware('permission:view-brands');
    Route::post('/', 'store')->name('brands.store')->middleware('permission:create-brands');
    Route::get('{brand}', 'show')->name('brands.show')->middleware('permission:view-brands');
    Route::put('{brand}', 'update')->name('brands.update')->middleware('permission:edit-brands');
    Route::patch('{brand}/toggle-status', 'toggleStatus')->name('brands.toggle')->middleware('permission:edit-brands');
    Route::delete('{brand}', 'destroy')->name('brands.destroy')->middleware('permission:delete-brands');
});

/* Icons */
Route::middleware(['auth:user'])->get('icons', [\App\Http\Controllers\Api\IconController::class, 'index']);

/* Product Categories */
Route::prefix('product-categories')->middleware(['auth:user'])->controller(ProductCategoryController::class)->group(function () {
    Route::get('/', 'index')->name('product-categories.index')->middleware('permission:view-product-categories');
    Route::get('all', 'allCategories')->name('product-categories.all')->middleware('permission:view-product-categories');
    Route::post('/', 'store')->name('product-categories.store')->middleware('permission:create-product-categories');
    Route::get('{id}', 'show')->name('product-categories.show')->middleware('permission:view-product-categories');
    Route::put('{id}', 'update')->name('product-categories.update')->middleware('permission:edit-product-categories');
    Route::patch('{id}/toggle-status', 'toggleStatus')->name('product-categories.toggle')->middleware('permission:edit-product-categories');
    Route::delete('{id}', 'destroy')->name('product-categories.destroy')->middleware('permission:delete-product-categories');
});

/* Product Attribute Groups */
Route::prefix('product-attribute-groups')->middleware(['auth:user'])->controller(\App\Http\Controllers\Api\ProductAttributeGroupController::class)->group(function () {
    Route::get('/', 'index')->name('product-attribute-groups.index')->middleware('permission:view-attribute-groups');
    Route::get('all', 'allAttributeGroups')->name('product-attribute-groups.all')->middleware('permission:view-attribute-groups');
    Route::post('/', 'store')->name('product-attribute-groups.store')->middleware('permission:create-attribute-groups');
    Route::get('{id}', 'show')->name('product-attribute-groups.show')->middleware('permission:view-attribute-groups');
    Route::put('{id}', 'update')->name('product-attribute-groups.update')->middleware('permission:edit-attribute-groups');
    Route::patch('{id}/toggle-status', 'toggleStatus')->name('product-attribute-groups.toggle')->middleware('permission:edit-attribute-groups');
    Route::delete('{id}', 'destroy')->name('product-attribute-groups.destroy')->middleware('permission:delete-attribute-groups');
});

/* Players */
Route::prefix('players')->middleware(['auth:user'])->controller(PlayerController::class)->group(function () {
    Route::get('/', 'index')->name('players.index')->middleware('permission:view-players');
    Route::post('/', 'store')->name('players.store')->middleware('permission:create-players');
    Route::get('{id}', 'show')->name('players.show')->middleware('permission:view-players');
    Route::put('{id}', 'update')->name('players.update')->middleware('permission:edit-players');
    Route::patch('{id}/toggle-status', 'toggleStatus')->name('players.toggle')->middleware('permission:edit-players');
    Route::delete('{id}', 'destroy')->name('players.destroy')->middleware('permission:delete-players');
});

/* Results */
Route::prefix('results')->middleware(['auth:user'])->controller(ResultController::class)->group(function () {
    Route::get('/', 'index')->name('results.index')->middleware('permission:view-results');
    Route::post('/', 'store')->name('results.store')->middleware('permission:create-results');
    Route::get('{id}', 'show')->name('results.show')->middleware('permission:view-results');
    Route::put('{id}', 'update')->name('results.update')->middleware('permission:edit-results');
    Route::patch('{id}/toggle-status', 'toggleStatus')->name('results.toggle')->middleware('permission:edit-results');
    Route::delete('{id}', 'destroy')->name('results.destroy')->middleware('permission:delete-results');
});

/* Committee Members */
Route::prefix('committee-members')
    ->middleware(['auth:user', 'permission:manage-committee-members'])
    ->controller(CommitteeMemberController::class)
    ->group(function () {
        Route::get('/', 'index')->name('committee-members.index');
        Route::post('/', 'store')->name('committee-members.store');
        Route::get('{id}', 'show')->name('committee-members.show');
        Route::put('{id}', 'update')->name('committee-members.update');
        Route::patch('{id}/toggle-status', 'toggleStatus')->name('committee-members.toggle');
        Route::delete('{id}', 'destroy')->name('committee-members.destroy');
    });

/* Utility: List available frontend template files */
Route::middleware(['auth:user'])->get('templates', function () {
    $path  = resource_path('views/layouts/frontend');
    $files = [];

    if (File::exists($path)) {
        $files = collect(File::files($path))
            ->filter(fn($file) => Str::endsWith($file->getFilename(), '.blade.php'))
            ->map(fn($file) => Str::replaceLast('.blade', '', pathinfo($file->getFilename(), PATHINFO_FILENAME)))
            ->values()
            ->toArray();
    }

    return response()->json($files);
});
