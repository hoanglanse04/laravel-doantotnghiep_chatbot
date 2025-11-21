<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Treconyl\Shoppingcart\Facades\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderCreatedMail;
use Illuminate\Support\Facades\Mail;
class CheckoutController extends Controller
{
    // Hiển thị trang checkout
    public function index()
    {
        $cartItems = Cart::content();
        $totalPrice = Cart::subtotal();

        return view('checkout.index', compact('cartItems', 'totalPrice'));
    }

    // Xử lý đặt hàng
    public function process(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required|string|max:500',      // street / số nhà
            'phone' => 'required|string',
            'payment_method' => 'required|string',
            'location_full' => 'nullable|string',        // Xã, Huyện, Tỉnh (tự động từ JS)
        ]);

        if (Cart::count() == 0) {
            return redirect()->back()->with('error', 'Giỏ hàng trống.');
        }

        DB::beginTransaction();

        try {
            // gộp address + Xã/Huyện/Tỉnh
            $street = trim($data['address']);
            $loc = trim($data['location_full'] ?? '');

            $fullAddress = $street;
            if ($loc) {
                $fullAddress .= ', ' . $loc;
            }

            // xử lý tiền
            $normalizedTotal = preg_replace('/[^\d\.]/', '', Cart::subtotal());
            $totalPriceFloat = $normalizedTotal !== '' ? (float) $normalizedTotal : 0;

            // tạo đơn hàng
            $order = Order::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'address' => $fullAddress,   // <-- chỉ lưu địa chỉ gộp
                'phone' => $data['phone'],
                'payment_method' => $data['payment_method'],
                'total_price' => $totalPriceFloat,
                'status' => 'pending',
            ]);

            // thêm item
            foreach (Cart::content() as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'product_name' => $item->name,
                    'price' => $item->price,
                    'qty' => $item->qty,
                ]);
            }
            try {
                Mail::to($order->email)->send(new OrderCreatedMail($order));
            } catch (\Throwable $e) {
                dd($e->getMessage());
            }
            // dọn giỏ
            try {
                Cart::destroy();
            } catch (\Throwable $e) {
            }

            DB::commit();

            return redirect()->route('welcome')->with('success', 'Đơn hàng của bạn đã được đặt thành công! Mã đơn hàng của bạn là #' . $order->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi khi đặt hàng: ' . $e->getMessage());
        }
    }
}
