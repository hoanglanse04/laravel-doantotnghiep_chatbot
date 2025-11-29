<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatSession extends Model
{
  protected $table = 'chat_sessions';

  protected $fillable = [
    'user_id',
    'status',
    'meta',
  ];

  protected $casts = [
    'meta' => 'array',
  ];

  /**
   * Mỗi session có nhiều message
   */
  public function messages(): HasMany
  {
    return $this->hasMany(ChatMessage::class, 'session_id')
      ->orderBy('created_at');
  }

  /**
   * Quan hệ user (nếu user đăng nhập)
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }
}
