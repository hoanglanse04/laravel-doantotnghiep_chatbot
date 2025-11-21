{{-- resources/views/order-search.blade.php --}}
@extends('layouts.master')

@section('title', 'Tìm đơn hàng theo mã đơn hàng')

@section('main')
  <main class="max-w-4xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow p-6">
      <h1 class="text-2xl font-semibold mb-4">Tìm đơn hàng theo mã đơn hàng</h1>

      <form method="GET" action="{{ route('order.search') }}" class="flex gap-2 mb-6">
        <input name="id" value="{{ old('id', $queryId ?? '') }}" placeholder="Nhập ID đơn hàng (ví dụ: 123)"
          class="flex-1 px-4 py-2 border rounded-md" required />
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Tìm</button>
      </form>

      {{-- Optional: show info about JSON path (dev requested) --}}

      @if($queryId !== null && $queryId !== '')
        @if($order)
          <div class="space-y-4">
            <div class="bg-gray-50 p-4 rounded">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <div class="text-sm text-gray-500">Mã đơn hàng</div>
                  <div class="font-semibold text-lg">#{{ $order->id }}</div>
                </div>
                <div>
                  <div class="text-sm text-gray-500">Trạng thái</div>
                  <div class="font-medium"><x-admin::chip :status="$order->status" /></div>
                </div>
                <div>
                  <div class="text-sm text-gray-500">Khách hàng</div>
                  <div class="font-medium">{{ $order->name }}</div>
                </div>
                <div>
                  <div class="text-sm text-gray-500">Số điện thoại / Email</div>
                  <div class="text-sm">{{ $order->phone }} / {{ $order->email }}</div>
                </div>
                <div class="col-span-2">
                  <div class="text-sm text-gray-500">Địa chỉ</div>
                  <div class="text-sm">{{ $order->address }}</div>
                </div>
                <div>
                  <div class="text-sm text-gray-500">Tổng tiền</div>
                  <div class="font-semibold">{{ number_format($order->total_price, 0, ',', '.') }} ₫</div>
                </div>
                <div>
                  <div class="text-sm text-gray-500">Ngày tạo</div>
                  <div class="text-sm">{{ optional($order->created_at)->format('d/m/Y H:i') }}</div>
                </div>
              </div>
            </div>

            <div class="bg-white rounded shadow p-4">
              <h2 class="font-semibold mb-3">Mục trong đơn</h2>
              @if($order->items && $order->items->count() > 0)
                <ul class="space-y-2">
                  @foreach($order->items as $item)
                    <li class="flex justify-between items-center border-b py-2">
                      <div>
                        <div class="font-medium">{{ $item->product_name ?? 'Sản phẩm #' . $item->product_id }}</div>
                        <div class="text-xs text-gray-500">Số lượng: {{ $item->qty }}</div>
                      </div>
                      <div class="text-sm font-medium">{{ number_format($item->price * $item->qty, 0, ',', '.') }} ₫</div>
                    </li>
                  @endforeach
                </ul>
              @else
                <div class="text-sm text-gray-500">Không có mục nào trong đơn.</div>
              @endif
            </div>

          </div>
        @else
          <div class="p-4 bg-red-50 rounded border border-red-100">
            <p class="text-red-600">Không tìm thấy đơn hàng với mã đơn hàng: <strong>{{ $queryId }}</strong></p>
          </div>
        @endif
      @endif
    </div>
  </main>
@endsection