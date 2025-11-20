<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Treconyl\ImagesUpload\Traits\Resizable;

use App\Models\User;

class Product extends Model
{
    use HasFactory, SoftDeletes, Resizable;

    protected $table = "products";
    protected $guarded = [];
    protected $casts = [
        'specifications' => 'array',
        'multiple_image' => 'array',
    ];

    /**
     * Get the category that owns the Product
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the category that owns the Product
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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

    /**
     * Scope: Lọc theo danh mục (category)
     */
    public function scopeCategory($query, $categoryId)
    {
        if (!empty($categoryId)) {
            return $query->where('category_id', $categoryId);
        }
        return $query;
    }
}
