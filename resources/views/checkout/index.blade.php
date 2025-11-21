@extends('layouts.master')
@section('title', 'Thanh toán')
@section('robots', 'noindex, nofollow')

@section('main')
  <main>
    <div class="max-w-7xl m-4 mx-auto px-4">
      <div class="bg-white rounded-2xl shadow p-6">
        <h1 class="text-2xl font-semibold mb-4">Thanh toán</h1>


        <div class="grid grid-cols-12 gap-6">
          {{-- Left: Form --}}
          <div class="col-span-12 lg:col-span-4">
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

              <div class="mt-3 grid grid-cols-1 gap-2">
                <select id="province" class="rounded-md  border-gray-300 p-2">
                  <option value="">-- Chọn tỉnh/thành --</option>
                </select>

                <select id="district" class="rounded-md  border-gray-300 p-2" disabled>
                  <option value="">-- Chọn huyện/quận --</option>
                </select>


                <select id="ward" class="rounded-md border -gray-300 p-2" disabled>
                  <option value="">-- Chọn xã/phường --</option>
                </select>
              </div>

              <!-- Textarea address (street) -->
              <div class="mt-3">
                <label class="block text-sm font-medium text-gray-700">Địa chỉ (số nhà, đường...)</label>
                <textarea id="address_text" name="address" rows="3"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2" required maxlength="500"></textarea>
              </div>

              <!-- Hidden fields (gửi tên và combined) -->
              <input type="hidden" id="province_name" name="province_name" value="">
              <input type="hidden" id="district_name" name="district_name" value="">
              <input type="hidden" id="ward_name" name="ward_name" value="">
              <input type="hidden" id="location_full" name="location_full" value="">




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
          <div class="col-span-12 lg:col-span-8">
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
                            <div>Tổng đơn hàng:</div>
                            <div class="cart-total-price">
                              {{ number_format(\Treconyl\Shoppingcart\Facades\Cart::subtotal(), 0, ',', '.') }}đ
                            </div>
                          </li>
                        </ul>

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
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const JSON_URL = "/data/vietnamAddress.json"; // đường dẫn file bạn đã upload

      const provinceSelect = document.getElementById("province");
      const districtSelect = document.getElementById("district");
      const wardSelect = document.getElementById("ward");
      const addressText = document.getElementById("address_text");

      const provinceNameInput = document.getElementById("province_name");
      const districtNameInput = document.getElementById("district_name");
      const wardNameInput = document.getElementById("ward_name");
      const locationFullInput = document.getElementById("location_full");

      let data = [];

      // Load JSON (file path provided)
      fetch(JSON_URL)
        .then(res => res.json())
        .then(json => {
          data = Array.isArray(json) ? json : (json.provinces || []);
          loadProvinces();
        })
        .catch(err => {
          console.error("Cannot load locations JSON:", err);
        });

      function loadProvinces() {
        provinceSelect.innerHTML = '<option value="">-- Chọn tỉnh/thành --</option>';
        data.forEach(p => {
          // value giữ Id (để nếu cần), nhưng ta lưu tên ở data-name
          provinceSelect.innerHTML += `<option value="${p.Id}" data-name="${p.Name}">${p.Name}</option>`;
        });
      }

      provinceSelect.addEventListener("change", function () {
        const pid = this.value;
        districtSelect.innerHTML = `<option value="">-- Chọn huyện/quận --</option>`;
        wardSelect.innerHTML = `<option value="">-- Chọn xã/phường --</option>`;
        wardSelect.disabled = true;
        districtSelect.disabled = true;

        if (!pid) {
          // clear hidden
          provinceNameInput.value = "";
          districtNameInput.value = "";
          wardNameInput.value = "";
          updateLocationFull();
          return;
        }

        const province = data.find(p => String(p.Id) === String(pid));
        if (!province) return;

        // set province name hidden
        provinceNameInput.value = province.Name || "";

        // fill districts
        const districts = province.Districts || [];
        districtSelect.disabled = false;
        districts.forEach(d => {
          districtSelect.innerHTML += `<option value="${d.Id}" data-name="${d.Name}">${d.Name}</option>`;
        });

        // reset downstream hidden values
        districtNameInput.value = "";
        wardNameInput.value = "";
        updateLocationFull();
      });

      districtSelect.addEventListener("change", function () {
        const did = this.value;
        wardSelect.innerHTML = `<option value="">-- Chọn xã/phường --</option>`;
        wardSelect.disabled = true;

        if (!did) {
          districtNameInput.value = "";
          wardNameInput.value = "";
          updateLocationFull();
          return;
        }

        const province = data.find(p => String(p.Id) === String(provinceSelect.value));
        if (!province) return;

        const district = (province.Districts || []).find(d => String(d.Id) === String(did));
        if (!district) {
          districtNameInput.value = "";
          wardNameInput.value = "";
          updateLocationFull();
          return;
        }

        // set district name hidden
        districtNameInput.value = district.Name || "";

        // fill wards
        const wards = district.Wards || [];
        wardSelect.disabled = false;
        wards.forEach(w => {
          wardSelect.innerHTML += `<option value="${w.Id}" data-name="${w.Name}">${w.Name}</option>`;
        });

        // reset ward hidden
        wardNameInput.value = "";
        updateLocationFull();
      });

      wardSelect.addEventListener("change", function () {
        const wid = this.value;
        if (!wid) {
          wardNameInput.value = "";
          updateLocationFull();
          return;
        }
        const selectedOpt = wardSelect.options[wardSelect.selectedIndex];
        const wName = selectedOpt?.dataset?.name || selectedOpt?.text || "";
        wardNameInput.value = wName;
        updateLocationFull();
      });

      // update combined string and store to location_full hidden
      function updateLocationFull() {
        const p = provinceNameInput.value || "";
        const d = districtNameInput.value || "";
        const w = wardNameInput.value || "";
        // build "Xã, Huyện, Tỉnh" but skip empty parts
        const parts = [];
        if (w) parts.push(w);
        if (d) parts.push(d);
        if (p) parts.push(p);
        const combined = parts.join(', ');
        locationFullInput.value = combined;
        // optionally log
        // console.log('location_full=', combined);
      }

      // Before submit: combine address_text + location_full into textarea `address` (so server receives final)
      const forms = document.querySelectorAll('form'); // you can scope to specific form if needed
      forms.forEach(form => {
        form.addEventListener('submit', function (e) {
          // ensure hidden names are up-to-date (in case user didn't change ward)
          const selProv = provinceSelect.options[provinceSelect.selectedIndex];
          if (selProv) provinceNameInput.value = selProv.dataset?.name || selProv.text;

          const selDist = districtSelect.options[districtSelect.selectedIndex];
          if (selDist) districtNameInput.value = selDist.dataset?.name || selDist.text;

          const selWard = wardSelect.options[wardSelect.selectedIndex];
          if (selWard) wardNameInput.value = selWard.dataset?.name || selWard.text;

          updateLocationFull();

          // combine
          const street = addressText.value ? addressText.value.trim() : '';
          const loc = locationFullInput.value ? locationFullInput.value.trim() : '';
          if (loc) {
            addressText.value = street ? (street + ', ' + loc) : loc;
          } else {
            addressText.value = street;
          }
          // now the form will submit: it includes:
          // - address (full combined)
          // - province_name, district_name, ward_name (individual names)
          // - location_full (combined location)
        }, { capture: true });
      });

    });
  </script>




@endsection