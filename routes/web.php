<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::post('/buy-now', [CartController::class, 'buyNow'])->name('buyNow');
    Route::get('/clear', [CartController::class, 'clear'])->name('clear');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});

Route::get('chuyen-muc/{slug}', [CategoryController::class, 'article'])->name('category');
Route::prefix('san-pham')->name('product.')->group(function () {
    Route::get('/', [ProductController::class, 'category'])->name('category');
    Route::get('{slug}', [ProductController::class, 'article'])->name('article');
});

Route::prefix('bai-viet')->name('post.')->group(function () {
    Route::get('/', [NewsController::class, 'category'])->name('category');
    Route::get('{slug}', [NewsController::class, 'article'])->name('article');
});

Route::prefix('san-pham')->name('product.')->group(function () {
    Route::get('/', [ProductController::class, 'category'])->name('category');
    Route::get('{slug}', [ProductController::class, 'article'])->name('article');
});

Route::prefix('page')->name('page.')->group(function () {
    Route::get('{slug}', [PageController::class, 'article'])->name('article');
});

Route::prefix('form')->name('form.')->group(function () {
    Route::post('contact', [FormController::class, 'contact'])->name('contact');
    Route::get('search', [FormController::class, 'search'])->name('search');
});

Route::prefix('artisan')->group(function () {
    Route::get('/optimize-clear', function () {
        Artisan::call('optimize:clear');
        return response()->json(['message' => 'Optimize Clear Done']);
    });

    Route::get('/config-clear', function () {
        Artisan::call('config:clear');
        return response()->json(['message' => 'Config Clear Done']);
    });

    Route::get('/cache-clear', function () {
        Artisan::call('cache:clear');
        return response()->json(['message' => 'Cache Clear Done']);
    });

    Route::get('/route-clear', function () {
        Artisan::call('route:clear');
        return response()->json(['message' => 'Route Clear Done']);
    });

    Route::get('/view-clear', function () {
        Artisan::call('view:clear');
        return response()->json(['message' => 'View Clear Done']);
    });

    Route::get('/config-cache', function () {
        Artisan::call('config:cache');
        return response()->json(['message' => 'Config Cache Done']);
    });

    Route::get('/route-cache', function () {
        Artisan::call('route:cache');
        return response()->json(['message' => 'Route Cache Done']);
    });

    Route::get('/view-cache', function () {
        Artisan::call('view:cache');
        return response()->json(['message' => 'View Cache Done']);
    });

    Route::get('/migrate', function () {
        Artisan::call('migrate');
        return response()->json(['message' => 'Migration Done']);
    });

    Route::get('/storage-link', function () {
        Artisan::call('storage:link');
        return response()->json(['message' => 'Storage Link Created']);
    });

    Route::get('/queue-restart', function () {
        Artisan::call('queue:restart');
        return response()->json(['message' => 'Queue Restarted']);
    });
});
