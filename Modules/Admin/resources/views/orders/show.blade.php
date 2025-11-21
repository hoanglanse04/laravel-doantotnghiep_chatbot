@extends('admin::layouts.master')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Chi tiết đơn hàng #{{ $order->id }}</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="col-span-2 bg-white p-4 rounded shadow">
                <h2 class="font-semibold mb-2">Sản phẩm</h2>
                <ul class="divide-y">
                    @foreach($order->items as $item)
                        <li class="py-3 flex justify-between">
                            <div>
                                <div class="font-medium">{{ $item->product_name }}</div>
                                <div class="text-sm text-gray-500">Số lượng: {{ $item->qty }}</div>
                            </div>
                            <div class="font-medium">{{ number_format($item->price * $item->qty, 0, ',', '.') }} ₫</div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <h2 class="font-semibold mb-2">Thông tin khách</h2>
                <p><strong>Tên:</strong> {{ $order->name }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Phone:</strong> {{ $order->phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                <p class="mt-3"><strong>Tổng:</strong> {{ number_format($order->total_price, 0, ',', '.') }} ₫</p>

                <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="mt-3">
                    @csrf
                    <select name="status" class="border rounded p-2 w-full mb-2">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Đang xử lý</option>
                        <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                    <button class="w-full bg-indigo-600 text-white py-2 rounded">Cập nhật trạng thái</button>
                </form>
            </div>
        </div>
    </div>
@endsection