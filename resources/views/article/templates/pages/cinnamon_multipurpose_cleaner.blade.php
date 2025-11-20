@extends('layouts.master')
@section('title', $article->title)

@section('head')
    {{-- Thẻ SEO cơ bản --}}
    @section('title', $article->title)
    @section('description', Str::limit(strip_tags($article->meta_description ?? $article->body), 160))
    @section('keywords', implode(', ', explode(' ', $article->title)))

    {{-- Open Graph (Facebook, Zalo) --}}
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($article->meta_description ?? $article->body), 160) }}">
    <meta property="og:image" content="{{ !empty($article->image) ? asset($article->image) : asset('assets/frontend/img/default-article.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">
    <meta property="article:published_time" content="{{ $article->created_at }}">
    <meta property="article:modified_time" content="{{ $article->updated_at }}">
    <meta property="og:site_name" content="Tìm Trọ Tốt">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $article->title }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($article->meta_description ?? $article->body), 160) }}">
    <meta name="twitter:image" content="{{ !empty($article->image) ? asset($article->image) : asset('assets/frontend/img/default-article.jpg') }}">
    <meta name="twitter:site" content="@timtrotot">

    {{-- Canonical URL để tránh trùng lặp nội dung --}}
    <link rel="canonical" href="{{ url()->current() }}">

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Article",
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "{{ url()->current() }}"
            },
            "headline": "{{ $article->title }}",
            "image": [
                "{{ !empty($article->image) ? asset($article->image) : asset('assets/frontend/img/default-article.jpg') }}"
            ],
            "datePublished": "{{ $article->created_at }}",
            "dateModified": "{{ $article->updated_at }}",
            "author": {
                "@type": "Person",
                "name": "Tìm Trọ Tốt"
            },
            "publisher": {
                "@type": "Organization",
                "name": "Tìm Trọ Tốt",
                "logo": {
                    "@type": "ImageObject",
                    "url": "{{ asset('assets/frontend/img/logo.png') }}"
                }
            },
            "description": "{{ Str::limit(strip_tags($article->meta_description ?? $article->body), 160) }}"
        }
    </script>
@endsection

@section('main')
    <main>
        <!--Breadcrumbs-->
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('page', $article) }}

        <div class="grid grid-cols-12 bg-[#201c18] text-[#ddd2be]">
            <div class="md:col-span-6 col-span-12">
                <img src="https://scontent-hkg4-1.xx.fbcdn.net/v/t1.6435-9/59805936_2150032671749768_1483089814042443776_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeGySNf1FwDysLK4m3Nl8TsJqyjuBLQ4EiirKO4EtDgSKAV2W2CbdOw01Oi46HSk-EMuVmqSErVHvAo-1-Qskv0C&_nc_ohc=dxXYzCJP2coQ7kNvwG-bF2o&_nc_oc=AdkEIEq43Od44qQgJw1tecP8p9fCk4EdIY9FgMtD3OH7zsba8xJbhk4ED7ytDgl24GT-mioJlV1So6L137K4NL5z&_nc_zt=23&_nc_ht=scontent-hkg4-1.xx&_nc_gid=UQBy2ty695omHDO4gYkylg&oh=00_AfELuVe4Sy9brK2i12Bea7nQY8fqOk9lPFboro7Cn5Byrw&oe=68248A0A" alt="Nước rửa bát hương quế" class="w-full h-auto">
            </div>
            <div class="md:col-span-6 col-span-12 px-10 flex flex-col items-center justify-center text-center">
                <h1 class="lg:text-5xl text-2xl font-bold lg:text-left text-center mb-4 uppercase barlow-condensed-regular">{{ $article->title }}</h1>
                <p class="text-6xl mb-12 vollkorn">Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                <div class="mb-4">
                    lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 pt-40 pb-20">
            <div class="grid grid-cols-12 text-[#bf913b]">
                <div class="md:col-span-6 col-span-12">
                    <img class="w-full h-auto" src="https://image.cocoonvietnam.com/uploads/Ly_tuong_cho_16da8d6ca7.png" alt="demo1">
                </div>
                <div class="md:col-span-6 col-span-12 px-10 flex flex-col items-start justify-center text-left text-lg space-y-4">
                    <p class="lg:text-5xl text-2xl font-bold lg:text-left text-center mb-4 uppercase barlow-condensed-regular">{{ $article->title }}</p>
                    <p class="text-6xl mb-12 vollkorn">Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <p class="mb-4">lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 pt-40 pb-20">
            <div class="grid grid-cols-12 text-[#bf913b]">
                <div class="md:col-span-6 col-span-12 px-10 flex flex-col items-end justify-center text-right text-lg space-y-4">
                    <p class="lg:text-5xl text-2xl font-bold lg:text-left text-center mb-4 uppercase barlow-condensed-regular">Solution that grows with you</p>
                    <p>Sodales tempor sapien quaerat ipsum undo congue laoreet turpis neque auctor turpis vitae dolor luctus placerat magna and ligula cursus purus vitae purus an ipsum suscipit</p>
                    <p class="lg:text-5xl text-2xl font-bold lg:text-left text-center mb-4 uppercase barlow-condensed-regular">Connect your data sources</p>
                    <div class="mb-4">
                        Tempor sapien sodales quaerat ipsum undo congue laoreet turpis neque auctor turpis vitae dolor luctus placerat magna and ligula cursus purus an ipsum vitae suscipit purus
                        <ul>
                            <li>- Tempor sapien quaerat an ipsum laoreet purus and sapien dolor an ultrice ipsum aliquam undo congue dolor cursus</li>
                            <li>- Cursus purus suscipit vitae cubilia magnis volute egestas vitae sapien turpis ultrice auctor congue magna placerat</li>
                        </ul>
                    </div>
                </div>
                <div class="md:col-span-6 col-span-12">
                    <img class="w-full h-auto" src="https://image.cocoonvietnam.com/uploads/Ly_tuong_cho_16da8d6ca7.png" alt="demo1">
                </div>
            </div>
        </div>
    </main>
@endsection
