<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

use App\Models\Product;


class ProductObserver
{
    public function created(Product $product): void
    {
        Cache::forget('welcome_1');
    }

    public function updated(Product $product): void
    {
        Cache::forget('welcome_1');
    }

    public function deleted(Product $product): void
    {
        Cache::forget('welcome_1');
    }
}
