@extends('layouts.master')
@section('title', 'Giỏ hàng')
@section('robots', 'noindex, nofollow')

@section('main')
    <main>
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('cart') }}

        <div class="max-w-7xl mx-auto px-4">
            @if (\Treconyl\Shoppingcart\Facades\Cart::content()->count() > 0)
                <div class="grid grid-cols-12 gap-4">
                    <div class="lg:col-span-7 col-span-12 rounded-lg bg-white p-4 cart-items">
                        <h2 class="font-semibold mb-4">Các mục trong giỏ</h2>

                        @php $cartItems = \Treconyl\Shoppingcart\Facades\Cart::content(); @endphp

                        @if ($cartItems->count() > 0)
                            @foreach ($cartItems as $row)
                                <article class="flex sm:flex-row flex-col justify-between mb-4 cart-row space-y-4">
                                    <a href="" class="flex w-full">
                                        <div class="w-20 h-20 min-w-20 rounded-lg overflow-hidden">
                                            <img class="object-cover" src="{{ image($row->model->image) }}" alt="{{ $row->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-semibold hover:text-[#c7a97f]">{{ $row->name }}</div>
                                            <div class="flex">
                                                <p class="cart-price">{{ number_format($row->price, 0, '.', '.') }}</p>đ
                                            </div>
                                        </div>
                                    </a>
                                    <div class="flex items-center">
                                        <div>
                                            <div class="quantity flex h-10 rounded-md overflow-hidden border border-solid border-gray-200 md:mx-2"
                                                data-productid="{{ $row->id }}">
                                                <input type="button" onclick="changeQuantity(this, -1)" value="-"
                                                    class="w-8 h-10 cursor-pointer font-semibold hover:bg-gray-300 transition">
                                                <input class="cart-quantity-input text-center w-8 h-10" name="quantity"
                                                    value="{{ $row->qty }}" data-rowid="{{ $row->rowId }}"
                                                    data-productid="{{ $row->id }}" id="number{{ $row->id }}">
                                                <input type="button" onclick="changeQuantity(this, 1)" value="+"
                                                    class="w-8 h-10 cursor-pointer font-semibold hover:bg-gray-300 transition">
                                            </div>
                                        </div>
                                        <div class="mx-3 flex" style="min-width: 50px">
                                            <div class="cart-price-item">
                                                {{ number_format($row->price * $row->qty, 0, '.', '.') }}
                                            </div>đ
                                        </div>
                                        <a href="" class="confirmation w-6 h-6 block">
                                            <svg class="w-full h-full fill-current text-[#c7a97f]" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 30 30">
                                                <path
                                                    d="M7.9785156 5.9804688 A 2.0002 2.0002 0 0 0 6.5859375 9.4140625L12.171875 15L6.5859375 20.585938 A 2.0002 2.0002 0 1 0 9.4140625 23.414062L15 17.828125L20.585938 23.414062 A 2.0002 2.0002 0 1 0 23.414062 20.585938L17.828125 15L23.414062 9.4140625 A 2.0002 2.0002 0 0 0 21.960938 5.9804688 A 2.0002 2.0002 0 0 0 20.585938 6.5859375L15 12.171875L9.4140625 6.5859375 A 2.0002 2.0002 0 0 0 7.9785156 5.9804688 z" />
                                            </svg>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        @endif
                    </div>
                    <div class="lg:col-span-5 col-span-12 pt-4">
                        <div class="rounded-lg bg-gray-50 p-4">
                            <h2 class="font-semibold">Tổng quan giỏ hàng</h2>
                            <ul class="py-4">
                                <li class="flex items-center justify-between py-2">
                                    <div>Tổng số lượng:</div>
                                    <div class="cart-total-quantity">{{ \Treconyl\Shoppingcart\Facades\Cart::count() }}</div>
                                </li>
                                <li class="flex items-center justify-between py-2">
                                    <div>Thuế:</div>
                                    <div>
                                        {{ number_format(\Treconyl\Shoppingcart\Facades\Cart::tax(), 0, ',', '.') }}đ
                                    </div>
                                </li>
                                <li class="flex items-center justify-between py-2">
                                    <div>Tổng đơn hàng:</div>
                                    <div class="cart-total-price">
                                        {{ number_format(\Treconyl\Shoppingcart\Facades\Cart::total(), 0, ',', '.') }}đ
                                    </div>
                                </li>
                            </ul>
                            <a href="{{ route('cart.checkout') }}"
                                class="block px-4 py-3 rounded-lg font-semibold bg-[#c7a97f] transition text-gray-50 text-center uppercase">
                                Thanh toán </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg lg:py-20 py-10 text-center">
                    <img class="max-w-xs mx-auto" src="{{ asset('assets/frontend/img/empty-cart.webp') }}" alt="empty cart">
                    <h2 class="font-semibold text-2xl">Giỏ hàng rỗng</h2>
                </div>
            @endif
        </div>
    </main>
@endsection

@section('footer')
    <script>
        function changeQuantity(button, delta) {
            const container = button.closest('.quantity');
            const input = container.querySelector('.cart-quantity-input');
            let current = parseInt(input.value);

            if (isNaN(current)) current = 1;
            const newQty = Math.max(1, current + delta);
            input.value = newQty;

            // Gọi sự kiện 'change' để kích hoạt cập nhật AJAX
            input.dispatchEvent(new Event('change'));
        }
        document.querySelectorAll('.cart-quantity-input').forEach(input => {
            input.addEventListener('change', function () {
                const newQty = parseInt(this.value);
                const rowId = this.dataset.rowid;
                const productId = this.dataset.productid;

                fetch("{{ route('cart.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        rowId: rowId,
                        quantity: newQty
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Cập nhật giá từng sản phẩm
                            this.closest('.cart-row').querySelector('.cart-price-item').innerText = data.item_subtotal;

                            // Cập nhật tổng
                            document.querySelector('.cart-total-price').innerText = data.total_price + 'đ';
                            document.querySelector('.cart-total-quantity').innerText = data.total_quantity;
                        } else {
                            alert(data.message);
                        }
                    });
            });
        });
        document.querySelectorAll('.confirmation').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const row = this.closest('.cart-row');
                const rowId = row.querySelector('.cart-quantity-input').dataset.rowid;

                fetch("{{ route('cart.remove') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ rowId: rowId })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            row.remove();
                            document.querySelector('.cart-total-price').innerText = data.total_price + 'đ';
                            document.querySelector('.cart-total-quantity').innerText = data.total_quantity;

                            if (data.total_quantity == 0) {
                                location.reload(); // reload nếu xoá hết
                            }
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(err => {
                        alert('Lỗi khi xoá sản phẩm!');
                        console.error(err);
                    });
            });
        });
    </script>
@endsection