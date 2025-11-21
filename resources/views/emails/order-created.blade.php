<h2>Xin chào {{ $order->name }},</h2>

<p>Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi.</p>

<p><strong>Mã đơn hàng:</strong> #{{ $order->id }}</p>
<p><strong>Tổng tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }}đ</p>
<p><strong>Địa chỉ giao hàng:</strong> {{ $order->address }}</p>
<p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method }}</p>

<h3>Chi tiết sản phẩm:</h3>
<ul>
  @foreach ($order->items as $item)
    <li>{{ $item->product_name }} × {{ $item->qty }} — {{ number_format($item->price) }}đ</li>
  @endforeach
</ul>

<p>Chúng tôi sẽ liên hệ ngay khi đơn được xử lý.</p>