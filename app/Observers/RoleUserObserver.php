<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

use App\Models\RoleUser;

class RoleUserObserver
{
    /**
     * Khi tạo mới quan hệ role_user, xóa cache permission của user
     */
    public function created(RoleUser $roleUser)
    {
        Cache::forget("admin-menu-permissions-{$roleUser->user_id}");
    }

    /**
     * Khi xóa role_user, cũng xóa cache permission của user
     */
    public function deleted(RoleUser $roleUser)
    {
        Cache::forget("admin-menu-permissions-{$roleUser->user_id}");
    }
}
