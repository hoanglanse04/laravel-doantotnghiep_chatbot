<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\CustomersController;
use Modules\Admin\Http\Controllers\BuilderItemController;
use Modules\Admin\Http\Controllers\OverviewController;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\CategoryController;
use Modules\Admin\Http\Controllers\ProductController;
use Modules\Admin\Http\Controllers\PageController;
use Modules\Admin\Http\Controllers\PostController;
use Modules\Admin\Http\Controllers\SettingsController;
use Modules\Admin\Http\Controllers\UserController;
use Modules\Admin\Http\Middleware\AuthenticateAdmin;
use Modules\Admin\Http\Controllers\BuilderController;
use Modules\Admin\Http\Controllers\ImageController;
use CKSource\CKFinderBridge\Controller\CKFinderController;
use Modules\Admin\Http\Controllers\ContactController;
use Modules\Admin\Http\Controllers\PermissionsController;
use Modules\Admin\Http\Controllers\RolesController;
use Modules\Admin\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!§§
|
*/

Route::name('admin.')->prefix('admin')->middleware([AuthenticateAdmin::class])->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.overview');
    });
    Route::get('login', [AdminController::class, 'login'])->name('login')->withoutMiddleware(AuthenticateAdmin::class);
    Route::post('login', [AdminController::class, 'authenticate'])->name('login.process')->withoutMiddleware(AuthenticateAdmin::class);
    Route::post('logout', [AdminController::class, 'logout'])->name('logout');

    Route::get('overview', [OverviewController::class, 'overview'])->name('overview');
    Route::resource('customer', CustomersController::class);
    Route::resource('user', UserController::class);
    Route::resource('post', PostController::class);
    Route::resource('page', PageController::class);
    Route::resource('product', ProductController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);
    Route::resource('setting', SettingsController::class);
    Route::post('settings/update-order', [SettingsController::class, 'updateOrder'])->name('setting.updateOrder');
    Route::post('settings/update-field-order', [SettingsController::class, 'updateFieldOrder'])->name('setting.updateFieldOrder');
    Route::resource('contact', ContactController::class);
    Route::resource('builder', BuilderController::class);
    Route::post('builder/update-order', [BuilderController::class, 'updateOrder'])->name('builder.updateOrder');
    Route::resource('builder-item', BuilderItemController::class);
    Route::post('builder-item/create-custome', [BuilderItemController::class, 'createCustome'])->name('builder.item.create-custome');
    Route::post('builder-item/{builder_item}/delete-custome', [BuilderItemController::class, 'destroyCustome'])->name('builder.item.destroy-custome');
    Route::resource('category', CategoryController::class);

    Route::prefix('uploads')->name('uploads')->group(function () {
        Route::post('process', [ImageController::class, 'process'])->name('process');
        Route::get('load', [ImageController::class, 'load'])->name('load');
    });
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');


    Route::any('ckfinder/connector', [CKFinderController::class, 'requestAction'])->name('ckfinder_connector');
    Route::any('ckfinder/browser', [CKFinderController::class, 'browserAction'])->name('ckfinder_browser');
});
