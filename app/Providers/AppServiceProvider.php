<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use App\Enums\Common;

use App\Models\Post;
use App\Models\RoleUser;
use App\Models\Category;
use App\Models\Product;
use Treconyl\Shoppingcart\Facades\Cart;
use Modules\Admin\Models\MenuItem;
use Modules\Admin\Models\Setting;
use Modules\Admin\Models\SettingField;

use App\Observers\RoleUserObserver;
use App\Observers\MenuItemObserver;
use App\Observers\SettingObserver;
use App\Observers\SettingFieldObserver;
use App\Observers\ProductObserver;
use App\Observers\PostObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
        {
            RoleUser::observe(RoleUserObserver::class);
            MenuItem::observe(MenuItemObserver::class);
            Post::observe(PostObserver::class);
            Product::observe(ProductObserver::class);
            Setting::observe(SettingObserver::class);
            SettingField::observe(SettingFieldObserver::class);

            View::share('categories_provider', Category::where('status', Common::PUBLISHED->value)
                ->whereNull('parent_id')
                ->orderBy('id', 'DESC')
                ->get());

            View::composer('*', function ($view) {
                try {
                    $cartCount = Cart::count(); 
                } catch (\Exception $e) {
                    $cartCount = 0; 
                }

                $view->with('cartCount', $cartCount);
            });
        }
}
