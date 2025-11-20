<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
  use HasFactory;


  protected $fillable = [
    'name',
    'email',
    'address',
    'phone',
    'payment_method',
    'total_price',
    'status',
  ];


  protected $casts = [
    'total_price' => 'decimal:0',
  ];


  /**
   * Order has many items
   */
  public function items()
  {
    return $this->hasMany(OrderItem::class);
  }
}