<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Treconyl\ImagesUpload\Traits\Resizable;

class Post extends Model
{
    use HasFactory, Resizable;

    protected $table = "posts";

    const DRAFT = 'draft';
    const PUBLISHED = 'published';
    const ARCHIVED = 'archived';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function scopeKeywords($query, $keywords)
    {
        if ($keywords) {
            return $query->where('title', 'LIKE', "%$keywords%");
        }
        return $query;
    }

    public function scopeStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeDate($query, $start_date, $end_date)
    {
        if ($start_date && $end_date) {
            return $query->whereBetween('created_at', [$start_date, $end_date]);
        } elseif ($start_date) {
            return $query->where('created_at', '>=', $start_date);
        } elseif ($end_date) {
            return $query->where('created_at', '<=', $end_date);
        }
        return $query;
    }
}
