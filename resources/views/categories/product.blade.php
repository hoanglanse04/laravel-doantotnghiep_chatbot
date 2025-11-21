@extends('layouts.master')

@section('title', $category->meta_title ?? $category->name ?? 'Danh sách sản phẩm')
@section('description', $category->meta_description ?? $category->description ?? 'Danh sách sản phẩm mới nhất, đa dạng mẫu mã, cập nhật liên tục')
@section('keywords', $category->meta_keywords ?? 'sản phẩm, mua sắm, giá rẻ, chất lượng, xu hướng')
@section('robots', request()->has('page') ? 'noindex, nofollow' : 'index, follow')

@section('head')
    @if (isset($category))
        {{-- Meta SEO --}}
        <title>{{ $category->meta_title ?? $category->name ?? 'Danh sách sản phẩm' }}</title>
        <meta name="description"
            content="{{ $category->meta_description ?? $category->description ?? 'Danh sách sản phẩm mới nhất, đa dạng mẫu mã, cập nhật liên tục' }}">
        <meta name="keywords" content="{{ $category->meta_keywords ?? 'sản phẩm, mua sắm, giá rẻ, chất lượng, xu hướng' }}">

        {{-- Open Graph --}}
        <meta property="og:title" content="{{ $category->meta_title ?? $category->name }}">
        <meta property="og:description" content="{{ $category->meta_description ?? $category->description }}">
        <meta property="og:image"
            content="{{ $category->image ? asset($category->image) : asset('assets/frontend/img/default.jpg') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="product.group">

        {{-- Twitter Card --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $category->meta_title ?? $category->name }}">
        <meta name="twitter:description" content="{{ $category->meta_description ?? $category->description }}">
        <meta name="twitter:image"
            content="{{ $category->image ? asset($category->image) : asset('assets/frontend/img/default.jpg') }}">
        <meta name="twitter:site" content="@thietbinhatminh">

        {{-- Canonical --}}
        <link rel="canonical" href="{{ url()->current() }}">

        @php
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'ItemList',
                'itemListElement' => [],
            ];
            foreach ($data as $index => $item) {
                $schema['itemListElement'][] = [
                    '@type' => 'Product',
                    'position' => $index + 1,
                    'name' => $item->name,
                    'image' => $item->image ? asset($item->image) : asset('assets/frontend/img/default.jpg'),
                    'url' => url('san-pham/' . $item->slug),
                    'offers' => [
                        '@type' => 'Offer',
                        'price' => (float) $item->price,
                        'priceCurrency' => 'VND',
                        'availability' => 'https://schema.org/InStock',
                    ],
                ];
            }
        @endphp
        <script type="application/ld+json">
                                                                                                                                                                            {!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
                                                                                                                                                                        </script>
    @endif

    {{-- CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/range-slider-input/dist/range-slider-input.min.css">
@endsection


@section('main')
    <main>
        @if (isset($category))
            {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('category', $category) }}
        @else
            {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('san-pham') }}
        @endif

        {{-- NÚT TOGGLE: ngay dưới breadcrumb, chỉ hiện trên mobile --}}


        <form action="" method="GET" class="max-w-7xl mx-auto px-4 py-10">
            @csrf
            <div class="lg:hidden">
                <button id="filterToggle" type="button" aria-expanded="false" aria-controls="filterPanel" class="flex">
                    <!-- icon -->
                    <x-icon.category w="26" />

                    Chuyên mục
                </button>

            </div>
            <div class="grid grid-cols-12 gap-6">
                {{-- SIDEBAR --}}
                <div class="lg:col-span-3 col-span-12 order-1 lg:order-1">
                    {{-- PANEL có thể ẩn/hiện: hidden trên mobile, luôn hiện trên desktop --}}
                    <div id="filterPanel" class="hidden lg:block space-y-6">

                        {{-- Chuyên mục --}}
                        <div>

                            @if (isset($categories) && count($categories) > 0)
                                <ul class="js-accordion space-y-1">
                                    @foreach ($categories as $item)
                                        @php $hasChildren = $item->children && $item->children->count() > 0; @endphp

                                        <li class="border-b border-gray-100">
                                            <div class="flex items-center justify-between">
                                                <a href="{{ route('category', ['slug' => $item->slug]) }}"
                                                    class="text-gray-700 font-medium py-2 pr-2 transition hover:text-red-600 flex-1">
                                                    {{ $item->name }}
                                                </a>

                                                {{-- Toggle subcategory --}}
                                                @if ($hasChildren)
                                                    <button type="button"
                                                        class="accordion-trigger w-8 h-8 flex items-center justify-center rounded cursor-pointer hover:bg-gray-100"
                                                        aria-expanded="false" aria-controls="submenu-{{ $item->id }}"
                                                        title="Mở submenu">
                                                        <span
                                                            class="toggle-icon text-lg leading-none select-none text-gray-800">+</span>
                                                    </button>
                                                @endif
                                            </div>

                                            {{-- Sub menu --}}
                                            @if ($hasChildren)
                                                <ul id="submenu-{{ $item->id }}"
                                                    class="submenu hidden ml-4 border-l pl-4 mt-1 space-y-1" aria-hidden="true">
                                                    @foreach ($item->children as $child)
                                                        <li>
                                                            <a href="{{ route('category', ['slug' => $child->slug]) }}"
                                                                class="text-gray-600 hover:text-red-500 flex items-center justify-between py-1">
                                                                <span>{{ $child->name }}</span>
                                                                @if ($child->all_products_count > 0)
                                                                    <span class="text-xs bg-gray-200 px-2 py-0.5 rounded-full">
                                                                        {{ $child->all_products_count }}
                                                                    </span>
                                                                @endif
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        {{-- Khoảng giá --}}
                        <div class="text-gray-600 space-y-3">
                            <p class="text-lg mb-2 text-gray-600 uppercase">Khoảng giá</p>
                            <div class="range-slider" id="range-slider">
                                <input type="range" value="{{ request('price_min', 0) }}" min="0" max="30000000"
                                    step="100000">
                                <input type="range" value="{{ request('price_max', 30000000) }}" min="0" max="30000000"
                                    step="100000">
                                <div class="range-slider__thumb" data-lower></div>
                                <div class="range-slider__thumb" data-upper></div>
                                <div class="range-slider__range bg-[#ef233c]"></div>
                            </div>

                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <span>
                                    <span id="minPriceText">0</span> – <span id="maxPriceText">30.000.000</span>
                                </span>
                            </div>

                            <input type="hidden" name="price_min" id="priceMinInput" value="{{ request('price_min', 0) }}">
                            <input type="hidden" name="price_max" id="priceMaxInput"
                                value="{{ request('price_max', 30000000) }}">
                        </div>

                        {{-- Button Submit --}}
                        <button type="submit"
                            class="w-full mt-2 bg-[#ef233c] px-4 py-3 text-sm rounded text-white hover:bg-[#ef233c] transition cursor-pointer">
                            Lọc sản phẩm
                        </button>
                    </div> {{-- /#filterPanel --}}
                </div>

                {{-- MAIN LIST --}}
                <div class="lg:col-span-9 col-span-12 order-2 lg:order-2">
                    <div class="flex items-center justify-between text-gray-700 font-medium mb-6">
                        <div> Đang hiển thị {{ count($data) }} kết quả </div>
                        <select name="sort" id="sort" class="form-select">
                            <option value="">Mặc định</option>
                            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Giá thấp tới cao
                            </option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Giá cao tới
                                thấp</option>
                        </select>
                    </div>

                    @if (isset($data) && count($data) > 0)
                        <div class="grid grid-cols-12 gap-6">
                            @foreach ($data as $item)
                                <x-product colSpan="lg:col-span-3 col-span-6" :item="$item" />
                            @endforeach
                        </div>
                        <div class="max-w-max mx-auto my-6">
                            {{ $data->links('vendor/pagination.tailwind') }}
                        </div>
                    @else
                        <p class="text-white">Không tìm thấy sản phẩm nào phù hợp.</p>
                    @endif
                </div>
            </div>

            <div class="content-article space-y-4 mt-6">
                {!! $category->content ?? "" !!}
            </div>
        </form>
    </main>
@endsection

@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/range-slider-input"></script>

    {{-- Toggle panel (mobile) --}}
    <script>
        (function () {
            const btn = document.getElementById('filterToggle');
            const panel = document.getElementById('filterPanel');
            if (!btn || !panel) return;

            btn.addEventListener('click', () => {
                const isHidden = panel.classList.toggle('hidden'); // true khi vừa ẩn
                btn.setAttribute('aria-expanded', String(!isHidden));
                console.log('123');
            });

            // Đảm bảo khi đổi sang desktop (resize) panel vẫn hiện
            const mq = window.matchMedia('(min-width: 1024px)');
            const sync = () => { if (mq.matches) panel.classList.remove('hidden'); };
            mq.addEventListener ? mq.addEventListener('change', sync) : mq.addListener(sync);
        })();
    </script>

    {{-- Range slider --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slider = document.getElementById('range-slider');
            const minText = document.getElementById('minPriceText');
            const maxText = document.getElementById('maxPriceText');
            const minInput = document.getElementById('priceMinInput');
            const maxInput = document.getElementById('priceMaxInput');

            const formatMoney = (val) => val.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
            const update = (values) => {
                const [min, max] = values;
                minText.textContent = formatMoney(min);
                maxText.textContent = formatMoney(max);
                minInput.value = min;
                maxInput.value = max;
            };

            rangeSlider(slider, {
                min: 0,
                max: 30000000,
                step: 100000,
                value: [parseInt(minInput.value), parseInt(maxInput.value)],
                onInput: update,
            });

            update([parseInt(minInput.value), parseInt(maxInput.value)]);
        });
    </script>

    {{-- Accordion submenu --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.querySelector('.js-accordion');
            if (!container) return;

            const closeAll = () => {
                container.querySelectorAll('.submenu').forEach(ul => {
                    ul.classList.add('hidden'); ul.setAttribute('aria-hidden', 'true');
                });
                container.querySelectorAll('.accordion-trigger').forEach(btn => {
                    btn.setAttribute('aria-expanded', 'false');
                    const icon = btn.querySelector('.toggle-icon'); if (icon) icon.textContent = '+';
                });
            };

            container.addEventListener('click', (e) => {
                const btn = e.target.closest('.accordion-trigger'); if (!btn) return;
                const id = btn.getAttribute('aria-controls');
                const submenu = document.getElementById(id); if (!submenu) return;

                const isOpen = btn.getAttribute('aria-expanded') === 'true';
                closeAll();
                if (!isOpen) {
                    submenu.classList.remove('hidden');
                    submenu.setAttribute('aria-hidden', 'false');
                    btn.setAttribute('aria-expanded', 'true');
                    const icon = btn.querySelector('.toggle-icon'); if (icon) icon.textContent = '−';
                }
            });

            container.addEventListener('keydown', (e) => {
                const btn = e.target.closest('.accordion-trigger'); if (!btn) return;
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); btn.click(); }
            });
        });
    </script>
@endsection