@extends('layouts.master')
@section('title', 'Thanh toán')
@section('robots', 'noindex, nofollow')

@section('head')
@endsection

@section('main')
    <main>
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('cart') }}

        <form action="{{ route('order.cart') }}" method="POST" id="order-cart">@csrf</form>
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-12 gap-4">
                <div class="md:col-span-7 col-span-12 cart-items">
                    <!--Các mục trong giỏ-->
                    <div class="rounded-lg bg-white p-4 mb-4">
                        <h2 class="font-semibold mb-4 text-gray-700">Các mục trong giỏ</h2>
                        @if (isset($cart) && count($cart) > 0)
                            @foreach ($cart as $item)
                                <article class="flex items-center justify-between mb-4 cart-row">
                                    <div class="flex w-full">
                                        <div class="w-20 h-20 rounded-lg overflow-hidden" style="min-width: 80px">
                                            <img class="object-cover" src="{{ image($item->associatedModel->image) }}"
                                                alt="{{ $item->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-semibold">{{ $item->name }}</div>
                                            <div class="flex">
                                                <p class="cart-price">{{ number_format($item->price, 0, '.', '.') }}</p>đ
                                            </div>
                                        </div>
                                    </div>

                                    x{{ $item->quantity }}
                                    <div class="mx-3 text-right flex" style="min-width: 96px">
                                        <div class="cart-price-item">
                                            {{ number_format($item->getPriceSum(), 0, '.', '.') }}
                                        </div>đ
                                    </div>
                                </article>
                            @endforeach
                        @endif
                    </div>

                    <!--Thông tin giao hàng-->
                    <div class="rounded-lg bg-white p-4">
                        <h2 class="font-semibold mb-4 text-gray-700">Thông tin giao hàng</h2>
                        <div class="grid grid-cols-12 gap-4">

                            <div class="col-span-12 md:col-span-6">
                                <label for="full_name"
                                    class="mt-1 block w-full sm:text-sm border-2 border-solid border-gray-200 outline-none rounded-md px-3 py-1 mb-0">
                                    <p class="text-xs pt-1">Tên người nhận</p>
                                    <input form="order-cart"
                                        class="text-gray-400 bg-transparent border-none w-full px-0 py-2 text-sm"
                                        style="box-shadow: none;" type="text" name="full_name" placeholder="Ngxx"
                                        id="full_name" required>
                                </label>
                            </div>

                            <div class="col-span-12 md:col-span-6">
                                <label for="email"
                                    class="mt-1 block w-full sm:text-sm border-2 border-solid border-gray-200 outline-none rounded-md px-3 py-1 mb-0">
                                    <p class="text-xs pt-1">Địa chỉ email</p>
                                    <input form="order-cart"
                                        class="text-gray-400 bg-transparent border-none w-full px-0 py-2 text-sm"
                                        style="box-shadow: none;" type="text" name="email" placeholder="@" id="email"
                                        required>
                                </label>
                            </div>

                            <div class="col-span-12">
                                <label for="number_phone"
                                    class="mt-1 block w-full sm:text-sm border-2 border-solid border-gray-200 outline-none rounded-md px-3 py-1 mb-0">
                                    <p class="text-xs pt-1">Số điện thoại</p>
                                    <input form="order-cart"
                                        class="text-gray-400 bg-transparent border-none w-full px-0 py-2 text-sm"
                                        style="box-shadow: none;" type="text" name="number_phone" placeholder="0123xx"
                                        id="number_phone" required>
                                </label>
                            </div>

                            <div class="col-span-12 grid grid-cols-12 gap-4">
                                <div class="col-span-12 md:col-span-4">
                                    <label for="province"
                                        class="mt-1 block w-full sm:text-sm border-2 border-solid border-gray-200 outline-none rounded-md px-3 py-1 mb-0">
                                        <p class="text-xs pt-1">Thành phố</p>
                                        <select name="province" form="order-cart" id="province"
                                            class="w-full border-none pl-0 location" style="box-shadow: none" required>
                                            <option value="">Chọn thành phố</option>
                                            @if (isset($province) && count($province) > 0)
                                                @foreach ($province as $item)
                                                    <option value="{{$item->_name}}">{{$item->_name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </label>
                                </div>

                                <div class="col-span-12 md:col-span-4">
                                    <label for="district"
                                        class="mt-1 block w-full sm:text-sm border-2 border-solid border-gray-200 outline-none rounded-md px-3 py-1 mb-0">
                                        <p class="text-xs pt-1">Quận huyện</p>
                                        <select name="district" form="order-cart" id="district"
                                            class="w-full border-none pl-0 location" style="box-shadow: none" required>
                                            <option value="">Chọn</option>
                                        </select>
                                    </label>
                                </div>

                                <div class="col-span-12 md:col-span-4">
                                    <label for="ward"
                                        class="mt-1 block w-full sm:text-sm border-2 border-solid border-gray-200 outline-none rounded-md px-3 py-1 mb-0">
                                        <p class="text-xs pt-1">Phường xã</p>
                                        <select name="ward" form="order-cart" id="ward"
                                            class="w-full border-none pl-0 location" style="box-shadow: none" required>
                                            <option value="">Chọn</option>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="col-span-12">
                                <label for="location"
                                    class="mt-1 block w-full sm:text-sm border-2 border-solid border-gray-200 outline-none rounded-md px-3 py-1 mb-0">
                                    <p class="text-xs pt-1">Địa chỉ</p>
                                    <input form="order-cart"
                                        class="text-gray-400 bg-transparent border-none w-full px-0 py-2 text-sm"
                                        style="box-shadow: none;" type="text" name="location"
                                        placeholder="Số nhà xx - ngõ xx " id="location" required>
                                </label>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="md:col-span-5 col-span-12">

                    <div class="rounded-lg bg-white p-4 mb-4">
                        <h2 class="font-semibold text-gray-700">Ghi chú</h2>
                        <textarea name="note" id="note" form="order-cart" placeholder="Ghi chú đơn hàng"
                            class="w-full text-sm h-24 border-2 border-solid border-gray-200 rounded-lg mt-4"></textarea>

                        <h2 class="font-semibold text-gray-700 mb-2">Phương thức thanh toán</h2>
                        <ul class="pl-2 space-y-1">
                            <li class="text-gray-400 text-sm">- Thanh toán khi nhận hàng (COD)</li>
                            <li class="text-gray-400 text-sm">- Chưa bao gồm phí vận chuyển</li>
                        </ul>
                    </div>

                    <div class="rounded-lg bg-white p-4">
                        <h2 class="font-semibold text-gray-700">Thanh toán</h2>
                        <ul class="py-4">
                            <li class="flex items-center justify-between py-2">
                                <p>Tổng số lượng:</p>
                                <b class="cart-total-quantity">{{ Cart::getTotalQuantity() }}</b>
                            </li>
                            <li class="flex items-center justify-between py-2">
                                <p>Tổng số tiền thanh toán:</p>
                                <div>
                                    <b
                                        class="cart-total-price">{{ number_format(Cart::getTotal(), 0, ',', '.') }}</b><b>đ</b>
                                </div>
                            </li>
                        </ul>
                        <button type="submit" form="order-cart"
                            class="w-full block px-4 py-3 rounded-lg font-semibold transition text-gray-50 text-center uppercase"
                            style="background: linear-gradient(0deg, rgb(255 61 44 / 78%) 0%, rgb(255 131 87) 100%)"> Đặt
                            hàng </button>
                    </div>

                </div>
            </div>

        </div>
    </main>
@endsection
@section('footer')
    <script>
        $('.location').change(function (e) {
            e.preventDefault();
            let currentId = $(this).attr('id');
            let name = $(this).val();
            $.ajax({
                type: "post",
                url: "{{ route('location') }}",
                data: {
                    'name': name,
                    'type': currentId,
                    '_token': '{{ csrf_token() }}'
                },
                success: function (response) {
                    let html = '';
                    let element = '';
                    if (currentId == 'province') {
                        html = '<option value="">Chọn</option>';
                        element = '#district';
                        $.each(response.data, function (index, item) {
                            html += '<option value="' + item._name + '">' + item._name + '</option>';
                        });
                        $('#ward').html('').append('<option value="">Chọn</option>');
                    } else if (currentId == 'district') {
                        html = '<option value="">Chọn</option>';
                        element = '#ward';
                        $.each(response.data, function (index, item) {
                            html += '<option value="' + item._name + '">' + item._name + '</option>';
                        });
                    }
                    $(element).html('').append(html);
                }
            });
        });
    </script>
@endsection