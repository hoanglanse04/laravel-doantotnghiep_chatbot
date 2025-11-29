<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the name of the password field for authentication.
     *
     * @return string
     */
    public function getAuthPasswordName(): string
    {
        return 'password';
    }

    /**
     * Scope: Tìm kiếm theo từ khóa (keywords)
     */
    public function scopeKeywords($query, $keywords): mixed
    {
        if (!empty($keywords)) {
            return $query->where('name', 'LIKE', "%{$keywords}%")
                ->orWhere('description', 'LIKE', "%{$keywords}%");
        }
        return $query;
    }

    /**
     * Scope: Lọc theo trạng thái sản phẩm
     */
    public function scopeStatus($query, $status): mixed
    {
        if (!empty($status)) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Kiểm tra người dùng hiện tại có quyền cụ thể hay không.
     *
     * @param string $permission Tên quyền (ví dụ: 'view-post')
     * @return bool Trả về true nếu user có quyền, ngược lại false
     */
    public function hasPermission($permission): mixed
    {
        $user = Auth::guard('admin')->user();

        $cacheKey = "admin-menu-permissions-{$user->id}";

        $permissions = Cache::remember($cacheKey, now()->addDays(30), function () use ($user) {
            return $user->roles
                ->flatMap(fn($role) => $role->permissions)
                ->pluck('key')
                ->unique();
        });

        return $permissions->contains($permission);
    }

    /**
     * Kiểm tra người dùng hiện tại có ít nhất một trong các quyền được chỉ định.
     *
     * @param array|string $permissions Mảng hoặc chuỗi quyền (ví dụ: ['view-post', 'edit-post'])
     * @return bool Trả về true nếu user có ít nhất 1 quyền, ngược lại false
     */
    public function hasAnyPermission($permissions): bool
    {
        $permissions = is_array($permissions) ? $permissions : [$permissions];

        $user = Auth::guard('admin')->user();
        $cacheKey = "admin-menu-permissions-{$user->id}";

        $userPermissions = Cache::remember($cacheKey, now()->addDays(30), function () use ($user) {
            return $user->roles
                ->flatMap(fn($role) => $role->permissions)
                ->pluck('key')
                ->unique();
        });

        return collect($permissions)->contains(fn($perm) => $userPermissions->contains($perm));
    }
}
