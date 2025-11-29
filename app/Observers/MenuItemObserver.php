<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use Modules\Admin\Models\MenuItem;

class MenuItemObserver
{
    /**
     * Handle the MenuItem "created" event.
     */
    public function created(MenuItem $menuItem): void
    {
        Cache::forget("menu-items-{$menuItem->menu_id}");
    }

    /**
     * Handle the MenuItem "updated" event.
     */
    public function updated(MenuItem $menuItem): void
    {
        Cache::forget("menu-items-{$menuItem->menu_id}");
    }

    /**
     * Handle the MenuItem "deleted" event.
     */
    public function deleted(MenuItem $menuItem): void
    {
        Cache::forget("menu-items-{$menuItem->menu_id}");
    }

    /**
     * Handle the MenuItem "restored" event.
     */
    public function restored(MenuItem $menuItem): void
    {
        //
    }

    /**
     * Handle the MenuItem "force deleted" event.
     */
    public function forceDeleted(MenuItem $menuItem): void
    {
        //
    }
}
