@extends('layouts.master')
@section('title', 'Thanh toán')
@section('robots', 'noindex, nofollow')

@section('main')
  <main>
    <div class="max-w-7xl m-4 mx-auto px-4">
      <div class="bg-white rounded-2xl shadow p-6">
        <h1 class="text-2xl font-semibold mb-4">Thanh toán</h1>


        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          {{-- Left: Form --}}
          <div>
            <form action="{{ route('cart.checkout.process') }}" method="POST" class="space-y-4">
              @csrf


              <div>
                <label class="block text-sm font-medium text-gray-700">Họ và tên</label>
                <input name="name" value="{{ old('name') }}"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 p-2"
                  required maxlength="255">
                @error('name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
              </div>


              <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input name="email" type="email" value="{{ old('email') }}"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 p-2"
                  required>
                @error('email')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
              </div>


              <div>
                <label class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                <input name="phone" value="{{ old('phone') }}"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 p-2"
                  required>
                @error('phone')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
              </div>


              <div>
                <label class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                <textarea name="address" rows="3"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 p-2"
                  required maxlength="500">{{ old('address') }}</textarea>
                @error('address')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
              </div>


              <div>
                <label class="block text-sm font-medium text-gray-700">Phương thức thanh toán</label>
                <select name="payment_method"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 p-2"
                  required>
                  <option value="">-- Chọn --</option>
                  <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>Thanh toán khi nhận hàng (COD)
                  </option>
                  <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Chuyển khoản ngân hàng
                  </option>
                  <option value="vnpay" {{ old('payment_method') == 'vnpay' ? 'selected' : '' }}>VNPay</option>
                </select>
                @error('payment_method')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
              </div>


              <div class="pt-4">
                <button type="submit"
                  class="w-full inline-flex items-center justify-center rounded-xl bg-indigo-600 text-white px-4 py-2 text-sm font-medium shadow hover:bg-indigo-700">Đặt
                  hàng</button>
              </div>
            </form>
          </div>


          {{-- Right: Order summary --}}
          <div>
            <div class="border rounded-lg p-4 bg-gray-50">
              <h2 class="text-lg font-medium mb-3">Tóm tắt đơn hàng</h2>


              <div class="space-y-3">
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
                                <div
                                  class="quantity flex h-10 rounded-md overflow-hidden border border-solid border-gray-200 md:mx-2"
                                  data-productid="{{ $row->id }}">
                                  <input type="button" onclick="changeQuantity(this, -1)" value="-"
                                    class="w-8 h-10 cursor-pointer font-semibold hover:bg-gray-300 transition">
                                  <input class="cart-quantity-input text-center w-8 h-10" name="quantity"
                                    value="{{ $row->qty }}" data-rowid="{{ $row->rowId }}" data-productid="{{ $row->id }}"
                                    id="number{{ $row->id }}">
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
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection

@section('footer')

@endsection