<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqEntry extends Model
{
    // Nếu table không theo convention (faq_entries) thì bật dòng sau:
    // protected $table = 'faq_entries';

    protected $fillable = [
        'question',
        'answer',
        'embedding',
        'active',
    ];

    // casting embedding JSON vào array khi lấy ra
    protected $casts = [
        'embedding' => 'array',
        'active' => 'boolean',
    ];

    // nếu bạn dùng timestamps mặc định (created_at, updated_at) thì giữ nguyên
    public $timestamps = true;
}
