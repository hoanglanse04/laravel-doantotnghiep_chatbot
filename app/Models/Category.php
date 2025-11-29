<?php

namespace App\Models;

use App\Enums\Common;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "categories";
    protected $guarded = [];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the category that owns the Product
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    // Quan hệ cha đệ quy
    public function parentRecursive(): BelongsTo
    {
        return $this->parent()->with('parentRecursive');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public static function getCategoryOptions($parentId = null, $prefix = '')
    {
        $categories = self::where('parent_id', $parentId)->orderBy('name')->get();
        $result = [];

        foreach ($categories as $category) {
            $result[$category->id] = $prefix . $category->name;
            $result += self::getCategoryOptions($category->id, $prefix . '— ');
        }

        return $result;
    }

    public function getBreadcrumbNameAttribute()
    {
        $names = [];
        $category = $this;

        while ($category) {
            array_unshift($names, $category->name); // thêm vào đầu mảng
            $category = $category->parent;
        }

        return implode(' > ', $names);
    }


    /**
     * Scope: Tìm kiếm theo từ khóa (keywords)
     */
    public function scopeKeywords($query, $keywords)
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
    public function scopeStatus($query, $status)
    {
        if (!empty($status)) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function getAllProductsCountAttribute(): int
    {
        $categoryIds = $this->getAllChildCategoryIdsForModel();
        return Product::whereIn('category_id', $categoryIds)
            ->where('status', Common::PUBLISHED->value)
            ->count();
    }

    private function getAllChildCategoryIdsForModel(): array
    {
        $allIds = [$this->id];

        foreach ($this->children as $child) {
            $allIds = array_merge($allIds, $child->getAllChildCategoryIdsForModel());
        }

        return $allIds;
    }
}
