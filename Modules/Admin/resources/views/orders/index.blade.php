@extends('admin::layouts.master')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Danh sách đơn hàng</h1>

        <form method="GET" class="mb-4 flex gap-2">
            <input name="q" value="{{ $q ?? '' }}" placeholder="Tìm theo tên/phone/email/id"
                class="px-3 py-2 border rounded" />
            <select name="status" class="px-3 py-2 border rounded">
                <option value="">Tất cả trạng thái</option>
                <option value="pending" {{ (isset($status) && $status == 'pending') ? 'selected' : '' }}>pending</option>
                <option value="paid" {{ (isset($status) && $status == 'paid') ? 'selected' : '' }}>paid</option>
                <option value="cancelled" {{ (isset($status) && $status == 'cancelled') ? 'selected' : '' }}>cancelled
                </option>
            </select>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Tìm</button>
        </form>

        <div class="bg-white shadow rounded overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Khách</th>
                        <th class="px-4 py-3 text-left">Email / Phone</th>
                        <th class="px-4 py-3 text-left">Tổng</th>
                        <th class="px-4 py-3 text-left">Trạng thái</th>
                        <th class="px-4 py-3 text-left">Ngày</th>
                        <th class="px-4 py-3 text-left">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-t">
                            <td class="px-4 py-3">{{ $order->id }}</td>
                            <td class="px-4 py-3">{{ $order->name }}</td>
                            <td class="px-4 py-3">
                                <div class="text-sm">{{ $order->email }}</div>
                                <div class="text-xs text-gray-500">{{ $order->phone }}</div>
                            </td>
                            <td class="px-4 py-3">{{ number_format($order->total_price, 0, ',', '.') }} ₫</td>
                            <td class="px-4 py-3">{{ $order->status }}</td>
                            <td class="px-4 py-3">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600">Xem</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection