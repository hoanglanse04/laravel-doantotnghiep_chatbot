@php
$images = is_array($article->multiple_image)
    ? $article->multiple_image
    : json_decode($article->multiple_image, true);
$images = $images ?? [];

$imageJson = count($images)
    ? collect($images)->map(fn($img) => '"' . asset($img) . '"')->implode(', ')
    : '"' . asset('assets/frontend/img/image_placeholder.png') . '"';
@endphp


@extends('layouts.master')

@section('title', $article->meta_title ?? $article->name)
@section('description', $article->meta_description ?? Str::limit(strip_tags($article->content), 160))
@section('keywords', $article->meta_keywords ?? implode(', ', explode(' ', $article->name)))

@section('head')
    {{-- Open Graph (Facebook, Zalo) --}}
    <meta property="og:title" content="{{ $article->meta_title ?? $article->name }}">
    <meta property="og:description"
        content="{{ $article->meta_description ?? Str::limit(strip_tags($article->content), 160) }}">
    <meta property="og:image"
        content="{{ !empty($images[0]) ? asset($images[0]) : asset('assets/frontend/img/banner.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="product">
    <meta property="article:published_time" content="{{ $article->created_at->toIso8601String() }}">
    <meta property="article:modified_time" content="{{ $article->updated_at->toIso8601String() }}">
    <meta property="og:site_name" content="thietbinhatminh">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $article->meta_title ?? $article->name }}">
    <meta name="twitter:description"
        content="{{ $article->meta_description ?? Str::limit(strip_tags($article->content), 160) }}">
    <meta name="twitter:image"
        content="{{ !empty($images[0]) ? asset($images[0]) : asset('assets/frontend/img/banner.png') }}">
    {{-- <meta name="twitter:site" content="@"> --}}

    {{-- Canonical URL để tránh trùng lặp nội dung --}}
    <link rel="canonical" href="{{ url()->current() }}">

    @php
$images = json_decode($imageJson, true);
if (!is_array($images) || empty($images)) {
    $images = [
        !empty($article->image) ? asset($article->image) : asset('assets/frontend/img/default-article.jpg'),
    ];
}

$data = [
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $article->meta_title ?? $article->name,
    'description' => $article->meta_description ?? ($article->description ?? ''),
    'sku' => $article->sku ?? 'SP-' . $article->id,
    'image' => $images,
    'offers' => [
        '@type' => 'Offer',
        'url' => url()->current(),
        'priceCurrency' => 'VND',
        'price' => (float) ($article->price ?? 0),
        'availability' =>
            $article->quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
        'itemCondition' => 'https://schema.org/NewCondition',
    ],
    'brand' => [
        '@type' => 'Organization',
        'name' => setting('site_name'),
    ],
];
    @endphp

    <script type="application/ld+json">
    {!! json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

@endsection

@section('main')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('product.detail', $article) }}

    <div class="pt-10">
        <div class="max-w-7xl p-4 mx-auto space-y-5">
            <div class="grid grid-cols-12 md:gap-12">
                <div class="lg:col-span-6 col-span-12">
                    <div class="flex gap-6 lg:flex-row-reverse flex-col">
                        <!-- Thumbnail slider -->
                        <div class="thumbnail-slider lg:w-[130px] w-full -m-1 order-2">
                            @foreach ($images as $image)
                                <div class="aspect-square thumbnail-item cursor-pointer m-1">
                                    <img class="w-full h-full object-cover border border-gray-200 rounded-md lazyload"
                                        data-src="{{ image($image) }}" alt="Thumb">
                                </div>
                            @endforeach
                        </div>

                        <!-- Main slider -->
                        <div class="main-slider w-full lg:max-w-[calc(100%-130px)] order-1">
                            @foreach ($images as $image)
                                <div class="aspect-square rounded-lg overflow-hidden border border-gray-200">
                                    <img class="w-full h-full object-cover lazyload rounded-xl"
                                        data-src="{{ image($image) }}" alt="Ảnh sản phẩm">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-6 col-span-12 lg:mt-0 mt-6">
                    <h1 class="lg:text-2xl text-xl font-semibold mb-4">{{ $article->name }}</h1>
                    @if (empty($article->price) || $article->price == 0)
                        <p class="text-lg text-red-500 font-semibold">Liên hệ</p>
                    @elseif ($article->discount_price <= 0)
                        <p class="text-lg text-red-500 font-semibold">{{ number_format($article->price, 0, '.', '.') }}đ
                        </p>
                    @else
                        <div class="flex items-center space-x-2">
                            <p class="text-lg text-red-500">{{ number_format($article->final_price, 0, '.', '.') }}đ</p>
                            <p class="text-lg line-through text-gray-400">
                                {{ number_format($article->price, 0, '.', '.') }}đ</p>
                        </div>
                    @endif

                    <div class="text-[#2C2C2C] text-md prose mb-6 mt-2">
                        {!! $article->description !!}
                    </div>

                    @if (!empty($article->specifications) && is_array($article->specifications))
                        <table class="w-full text-sm border border-gray-200 rounded overflow-hidden mt-4"
                            style="border-collapse: separate;
                                border-spacing: 3px;
                                font-size: 14px;
                                background-color: transparent;
                            }">
                            <tbody>
                                @foreach ($article->specifications as $spec)
                                    <tr class="border-t border-gray-200">
                                        <td class="px-3 py-2 font-medium w-1/3 bg-gray-50 text-gray-700">
                                            {{ $spec['label'] ?? '-' }}</td>
                                        <td class="px-3 py-2 text-gray-800">{{ $spec['value'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <div class="max-w-96">
                        @if (empty($article->price) || $article->price <= 1)
                            {{-- Nút yêu cầu báo giá (mở UIkit modal) --}}
                            <button type="button"
                                class="cursor-pointer w-full bg-red-600 text-white font-semibold px-6 py-3 rounded hover:bg-red-700 mt-6 transition"
                                uk-toggle="target: #quote-modal">
                                YÊU CẦU BÁO GIÁ
                            </button>
                        @else
                            {{-- Form số lượng + Thêm giỏ + Mua ngay --}}
                            <div class="flex items-center space-x-4 mt-6">
                                <div class="flex items-center border-2 border-gray-200 px-3 py-1.5 rounded">
                                    <button type="button" class="qty-decrease text-xl px-2 cursor-pointer">−</button>
                                    <input type="text" id="quantity" name="quantity" value="1" min="1"
                                        class="w-12 text-center border-none focus:outline-none appearance-none" />
                                    <button type="button" class="qty-increase text-xl px-2 cursor-pointer">+</button>
                                </div>

                                <button
                                    class="add-to-cart cursor-pointer w-full bg-red-600 text-white font-semibold px-6 py-3 rounded hover:bg-red-700 transition"
                                    data-id="{{ $article->id }}">
                                    THÊM VÀO GIỎ
                                </button>
                            </div>

                            <form method="POST" action="{{ route('cart.buyNow') }}" id="buyNowForm">
                                @csrf
                                <input type="hidden" name="id" value="{{ $article->id }}">
                                <input type="hidden" name="quantity" id="buyNowQuantity" value="1">
                                <button type="submit"
                                    class="buy-now cursor-pointer w-full bg-black text-white font-semibold py-3 mt-4 rounded hover:bg-gray-900 transition">
                                    MUA NGAY
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 mt-10 mb-6">
            <ul class="uk-tab" uk-tab>
                <li><a href="#" class="bg-[#ef233c] lg:px-6 px-4 !py-3 rounded-t-md max-w-max !text-white">Nội
                        dung</a></li>
                <li><a href="#" class="bg-[#ef233c] lg:px-6 px-4 !py-3 rounded-t-md max-w-max !text-white">Thông số
                        sản phẩm</a></li>
            </ul>

            <ul class="uk-switcher mt-4">
                <li>
                    <div class="space-y-4 border border-gray-200 p-4 content-article">
                        {!! $article->content !!}
                    </div>
                </li>
                <li>
                    <div class="space-y-4 border border-gray-200 p-4 content-article">
                        {!! $article->details !!}
                    </div>
                </li>
            </ul>
        </div>

        @if (!empty($related) && count($related))
            <div class="max-w-7xl mx-auto px-4 mt-10 mb-6">
                <h2 class="text-xl font-semibold mb-4">Sản phẩm liên quan</h2>
                <div class="product-f-slider -mx-3">
                    @forelse($related as $product)
                        <x-product :item="$product" />
                    @empty
                        <div class="px-4 w-full text-center text-gray-500 py-8">
                            Không có sản phẩm nào để hiển thị.
                        </div>
                    @endforelse
                </div>
            </div>
        @endif
    </div>

    <div id="quote-modal" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-margin-auto-vertical !rounded-xl">
            <button class="uk-modal-close-default" type="button" uk-close></button>

            <div class="uk-modal-header !rounded-t-xl">
                <h3 class="font-semibold text-[#35475b] text-lg">Liên hệ ngay với chúng tôi</h3>
                <p class="font-semibold text-sm leading-6 text-[#616f92] mb-3">
                    Đội ngũ hỗ trợ của chúng tôi sẽ phản hồi trong vòng 1–2 tiếng làm việc
                </p>
            </div>
            <div class="uk-modal-body">
                {{-- <form action="{{ route('form.contact') }}" method="POST" class="space-y-4" id="recapchaform">
                    @csrf
                    <input type="hidden" name="url_current" value="{{ url()->current() }}">
                    <input type="hidden" name="recaptcha" id="recaptcha" class="hidden">

                    <div class="space-y-2">
                        <label for="name" class="uk-form-label block text-[13px] font-semibold text-[#747e97]">Họ và tên</label>
                        <div class="uk-form-controls">
                            <input id="name" class="uk-input rounded-xl border border-gray-300" type="text" name="name"
                                placeholder="Nguyễn Văn A" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="uk-form-label block text-[13px] font-semibold text-[#747e97]">Email</label>
                        <div class="uk-form-controls">
                            <input class="uk-input rounded-xl border border-gray-300" type="email" name="email"
                                placeholder="example@gmail.com" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="uk-form-label block text-[13px] font-semibold text-[#747e97]">Số điện thoại</label>
                        <div class="uk-form-controls">
                            <input class="uk-input rounded-xl border border-gray-300" type="tel" name="phone"
                                placeholder="012 345 6789" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="uk-form-label block text-[13px] font-semibold text-[#747e97]">Nội dung cần hỗ trợ</label>
                        <div class="uk-form-controls">
                            <textarea class="uk-textarea rounded-xl border border-gray-300 h-36" name="content"
                                placeholder="Hãy mô tả về vấn đề của bạn" required></textarea>
                        </div>
                    </div>

                    <button type="submit" class="bg-red-700 text-white py-3 cursor-pointer uppercase font-semibold uk-width-1-1 rounded-lg">
                        Gửi thông tin
                    </button>
                </form> --}}
                <div class="rounded-xl ring-1 ring-black/5 overflow-hidden">
                    <iframe src="{{ setting(slug: 'link_contact') }}" class="w-full min-h-[980px]" loading="lazy">Đang tải…</iframe>
                </div>

                <p class="text-xs text-gray-500 text-end">
                    Nếu form không hiển thị, mở trực tiếp
                    <a class="text-blue-600 underline" href="{{ setting(slug: 'link_contact') }}" target="_blank" rel="noopener">tại
                        đây</a>.
                </p>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{ asset('assets/libs/uikit/uikit.min.js') }}"></script>
    <script>
        $('.product-f-slider').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            arrows: true,
            lazyLoad: 'progressive',
            prevArrow: $('.product-f-prev'),
            nextArrow: $('.product-f-next'),
            responsive: [

                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 640,
                    settings: {
                        slidesToShow: 2
                    }
                }
            ]
        });

        document.addEventListener('DOMContentLoaded', function() {
            const qtyInput = document.getElementById('quantity');
            const btnDecrease = document.querySelector('.qty-decrease');
            const btnIncrease = document.querySelector('.qty-increase');

            btnDecrease?.addEventListener('click', () => {
                const current = parseInt(qtyInput.value) || 1;
                if (current > 1) qtyInput.value = current - 1;
            });

            btnIncrease?.addEventListener('click', () => {
                const current = parseInt(qtyInput.value) || 1;
                qtyInput.value = current + 1;
            });

            document.querySelector('.buy-now')?.addEventListener('click', function() {
                const articleId = this.dataset.id;
                const qty = parseInt(qtyInput.value) || 1;
                window.location.href = `/cart`;
            });
        });

        $(document).ready(function() {
            $('.main-slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: '.thumbnail-slider'
            });

            $('.thumbnail-slider').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                asNavFor: '.main-slider',
                dots: false,
                arrows: true,
                focusOnSelect: true,
                vertical: true,
                verticalSwiping: true,
                prevArrow: '<button class="slick-prev"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"> <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m6 15l6-6l6 6" /></svg></button>',
                nextArrow: '<button class="slick-next"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"> <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m6 9l6 6l6-6" /></svg></button>',
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        vertical: false,
                        verticalSwiping: false
                    }
                }]
            });
        });
    </script>
@endsection
