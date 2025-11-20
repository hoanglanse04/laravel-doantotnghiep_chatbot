<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
  // Hiển thị danh sách orders (admin)
  public function index(Request $request)
  {
    $q = $request->query('q');
    $status = $request->query('status');

    $query = Order::query();

    if ($q) {
      $query->where(function ($sub) use ($q) {
        $sub->where('name', 'like', "%{$q}%")
          ->orWhere('email', 'like', "%{$q}%")
          ->orWhere('phone', 'like', "%{$q}%")
          ->orWhere('id', $q);
      });
    }

    if ($status) {
      $query->where('status', $status);
    }

    // Mặc định latest first, paginate 20
    $orders = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

    // Trả view admin.orders.index
    return view('admin::orders.index', compact('orders', 'q', 'status'));
  }

  // Hiển thị chi tiết 1 order
  public function show($id)
  {
    $order = Order::with('items')->findOrFail($id);
    return view('admin::orders.show', compact('order'));
  }

  // (tùy chọn) cập nhật trạng thái đơn hàng
  public function updateStatus(Request $request, $id)
  {
    $request->validate([
      'status' => 'required|string',
    ]);

    $order = Order::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    return redirect()->back()->with('success', 'Cập nhật trạng thái thành công.');
  }
}
