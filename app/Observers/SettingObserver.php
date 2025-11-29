<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use Modules\Admin\Models\Setting;

class SettingObserver
{
    public function created(Setting $setting): void
    {
        Cache::forget('settings');
    }

    public function updated(Setting $setting): void
    {
        Cache::forget('settings');
    }

    public function deleted(Setting $setting): void
    {
        Cache::forget('settings');
    }
}
