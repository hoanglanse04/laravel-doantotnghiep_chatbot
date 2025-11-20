<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use Modules\Admin\Models\SettingField;

class SettingFieldObserver
{
    public function created(SettingField $settingField): void
    {
        Cache::forget('settings');
    }

    public function updated(SettingField $settingField): void
    {
        Cache::forget('settings');
    }

    public function deleted(SettingField $settingField): void
    {
        Cache::forget('settings');
    }
}
