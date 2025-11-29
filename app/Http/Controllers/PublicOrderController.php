<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class PublicOrderController extends Controller
{
  /**
   * Hiển thị trang tìm kiếm và (nếu có) kết quả
   * GET /order-search?id=123
   */
  public function index(Request $request)
  {
    $id = $request->query('id');

    $order = null;
    if ($id !== null && $id !== '') {
      // tìm theo id chính xác
      $order = Order::with('items')->find($id);
    }

    return view('order-search', [
      'order' => $order,
      'queryId' => $id,
      // include json path for client usage (dev asked to include)
      'locationsJsonUrl' => '/mnt/data/vietnamAddress.json'
    ]);
  }
}
