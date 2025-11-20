<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Treconyl\Shoppingcart\Facades\Cart;

use App\Models\Product;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cartItems = Cart::content();
        // Cart::destroy();

        return view('cart.index', compact('cartItems'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->id);

        if ($product->price < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm này hiện chưa có giá bán hoặc đã tạm hết. Vui lòng liên hệ để được hỗ trợ thêm.'
            ], 400);
        }

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'qty' => $request->quantity ?? 1,
            'tax' => 0
        ])->associate(Product::class);

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng!',
            'total_quantity' => Cart::count(),
            'total_price' => number_format(Cart::total(), 0, ',', '.'),
        ]);
    }

    public function buyNow(Request $request)
    {
        $product = Product::findOrFail($request->id);

        if ($product->price < 1) {
            return redirect()->back()->with('error', 'Sản phẩm hiện chưa có giá bán. Vui lòng liên hệ.');
        }

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'qty' => $request->quantity ?? 1,
            'tax' => 0
        ])->associate(Product::class);

        return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng!');
    }


    // Cập nhật số lượng sản phẩm trong giỏ hàng (AJAX)
    public function update(Request $request)
    {
        $rowId = $request->rowId;
        $quantity = $request->quantity;

        if (!$rowId || $quantity < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ!'
            ]);
        }

        Cart::update($rowId, $quantity);

        $item = Cart::get($rowId);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật giỏ hàng thành công!',
            'total_quantity' => Cart::count(),
            'total_price' => number_format(Cart::total(), 0, ',', '.'),
            'item_subtotal' => number_format($item->subtotal, 0, '.', '.')
        ]);
    }

    // Xóa một sản phẩm khỏi giỏ hàng
    public function remove(Request $request)
    {
        $rowId = $request->rowId;

        if (!$rowId) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm để xoá!'
            ]);
        }

        Cart::remove($rowId);

        return response()->json([
            'success' => true,
            'message' => 'Đã xoá sản phẩm khỏi giỏ hàng!',
            'total_quantity' => Cart::count(),
            'total_price' => number_format(Cart::total(), 0, ',', '.')
        ]);
    }

    // Xóa toàn bộ giỏ hàng
    public function clear()
    {
        Cart::clear();
        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được làm trống!');
    }
}
