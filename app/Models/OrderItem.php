<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OrderItem extends Model
{
  use HasFactory;


  protected $fillable = [
    'order_id',
    'product_id',
    'product_name',
    'price',
    'qty',
  ];


  protected $casts = [
    'price' => 'decimal:0',
    'qty' => 'integer',
  ];


  public function order()
  {
    return $this->belongsTo(Order::class);
  }
}