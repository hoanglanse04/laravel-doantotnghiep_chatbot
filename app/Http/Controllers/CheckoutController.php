<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Treconyl\Shoppingcart\Facades\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    // Hiển thị trang checkout
    public function index()
    {
        $cartItems = Cart::content();   // NOT Cart::getContent()
        $totalPrice = Cart::total();    // NOT Cart::getTotal()

        return view('checkout.index', compact('cartItems', 'totalPrice'));
    }

    // Xử lý đặt hàng
    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required|string|max:500',
            'phone' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);

        if (Cart::count() == 0) {
            return redirect()->back()->with('error', 'Giỏ hàng trống.');
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone,
                'payment_method' => $request->payment_method,
                'total_price' => (float) str_replace([','], ['', ''], Cart::total()), // đơn giản chuyển string -> number
                'status' => 'pending',
            ]);

            foreach (Cart::content() as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'product_name' => $item->name,
                    'price' => $item->price,
                    'qty' => $item->qty,
                ]);
            }

            Cart::destroy();

            DB::commit();

            return redirect()->route('welcome')->with('success', 'Đơn hàng của bạn đã được đặt thành công!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi khi đặt hàng: ' . $e->getMessage());
        }
    }
}
