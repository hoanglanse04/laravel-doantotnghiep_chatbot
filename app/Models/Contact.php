<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "contact";
    protected $guarded = [];

    const NEW = 'new';
    const CONTACTED = 'contacted';
    const INTERESTED = 'interested';
    const NOT_INTERESTED = 'not_interested';
    const CONVERTED = 'converted';
    const ARCHIVED = 'archived';

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
}
