@extends('layouts.master')

@section('title', setting('site_name'))
@section('description', setting('site_description'))
@section('keywords', setting('site_keywords'))

@section('head')
    {{-- Open Graph cho Facebook --}}
    <meta property="og:title" content="{{ setting('site_name') }}">
    <meta property="og:description" content="{{ setting('site_description') }}">
    <meta property="og:image" content="{{ asset('assets/frontend/img/banner.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ setting('site_name') }}">
    <meta name="twitter:description" content="{{ setting('site_description') }}">
    <meta name="twitter:image" content="{{ asset('assets/frontend/img/banner.png') }}">

    {{-- Canonical URL để tránh trùng lặp nội dung --}}
    <link rel="canonical" href="{{ url()->current() }}">
    <script type="application/ld+json">
                    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => setting('site_name'),
        'url' => url(''),
        'logo' => url('android-chrome-192x192.png'),
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'telephone' => '+84' . ltrim(setting('contact_phone'), '0'),
            'contactType' => 'customer service',
            'areaServed' => 'VN',
            'availableLanguage' => 'Vietnamese',
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
                </script>
@endsection

@section('main')
    <div class="max-w-7xl mx-auto ">
        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative mb-4">
                <strong>Thành công!</strong> {!! session()->get('success') !!}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mb-4">
                <strong>Lỗi!</strong> {!! session()->get('error') !!}
            </div>
        @endif
        {{ builder('slider-banner', 'builder.banner') }}

    </div>

    <section class="max-w-7xl mx-auto px-4 lg:my-12 my-6">
        <div class="flex items-center justify-between mb-6 border-b border-gray-200 pb-2">
            <h2 class="text-2xl font-bold">Sản phẩm nổi bật</h2>
            <div class="flex gap-2">
                <button class="product-f-prev slick-arrow bg-gray-100 p-2 rounded hover:bg-gray-200 cursor-pointer">
                    <x-icon.chevron-left class="w-4 h-4" />
                </button>
                <button class="product-f-next slick-arrow bg-gray-100 p-2 rounded hover:bg-gray-200 cursor-pointer">
                    <x-icon.chevron-right class="w-4 h-4" />
                </button>
            </div>
        </div>

        <div class="product-f-slider -mx-3">
            @forelse($products as $product)
                <x-product :item="$product" />
            @empty
                <div class="px-4 w-full text-center text-gray-500 py-8">
                    Không có sản phẩm nào để hiển thị.
                </div>
            @endforelse
        </div>
    </section>

    {{ builder('ads', 'builder.ads', ['index' => 0]) }}

    <section class="max-w-7xl mx-auto px-4 my-12">
        <div class="flex items-center justify-between mb-6 border-b border-gray-200 pb-2">
            <h2 class="text-2xl font-bold">Sản phẩm mới nhất</h2>
            <div class="flex gap-2">
                <button class="product-prev slick-arrow bg-gray-100 p-2 rounded hover:bg-gray-200 cursor-pointer">
                    <x-icon.chevron-left class="w-4 h-4" />
                </button>
                <button class="product-next slick-arrow bg-gray-100 p-2 rounded hover:bg-gray-200 cursor-pointer">
                    <x-icon.chevron-right class="w-4 h-4" />
                </button>
            </div>
        </div>

        <div class="product-slider -mx-3">
            @forelse($products as $product)
                <x-product :item="$product" />
            @empty
                <div class="px-4 w-full text-center text-gray-500 py-8">
                    Không có sản phẩm nào để hiển thị.
                </div>
            @endforelse
        </div>
    </section>

    {{ builder('ads', 'builder.ads', ['index' => 1]) }}

    {{-- Bài viết mới nhất --}}
    <section class="max-w-7xl mx-auto px-4 my-12">
        <div class="flex items-center justify-between mb-6 border-b border-gray-200 pb-2">
            <h2 class="text-2xl font-bold">Bài viết mới nhất</h2>
            <div class="flex gap-2">
                <button class="blog-prev slick-arrow bg-gray-100 p-2 rounded hover:bg-gray-200 cursor-pointer">
                    <x-icon.chevron-left class="w-4 h-4" />
                </button>
                <button class="blog-next slick-arrow bg-gray-100 p-2 rounded hover:bg-gray-200 cursor-pointer">
                    <x-icon.chevron-right class="w-4 h-4" />
                </button>
            </div>
        </div>

        <div class="blog-slider -mx-4">
            @forelse($posts as $post)
                <x-post :item="$post" />
            @empty
                <div class="px-4 w-full text-center text-gray-500 py-8">
                    Không có bài viết nào để hiển thị.
                </div>
            @endforelse
        </div>
    </section>
@endsection

@section('footer')
    <script>
        $(document).ready(function () {
            $('.blog-slider').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                arrows: true,
                lazyLoad: 'progressive',
                prevArrow: $('.blog-prev'),
                nextArrow: $('.blog-next'),
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
                            slidesToShow: 1
                        }
                    }
                ]
            });

            $('.product-slider').slick({
                slidesToShow: 6,
                slidesToScroll: 1,
                arrows: true,
                lazyLoad: 'progressive',
                prevArrow: $('.product-prev'),
                nextArrow: $('.product-next'),
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
        });
    </script>
@endsection