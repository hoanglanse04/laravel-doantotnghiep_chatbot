@extends('layouts.master')

@section('title', $category->meta_title ?? $category->name ?? 'Danh sách bài viết')
@section('description', $category->meta_description ?? $category->description ?? 'Danh sách bài viết mới nhất, cập nhật liên tục')
@section('keywords', $category->meta_keywords ?? 'bài viết, tin tức, cập nhật, xu hướng')
@section('robots', request()->has('page') ? 'noindex, nofollow' : 'index, follow')

@section('head')
    @if (isset($category))
        {{-- Meta SEO --}}
        <title>{{ $category->meta_title ?? $category->name ?? 'Danh sách bài viết' }}</title>
        <meta name="description" content="{{ $category->meta_description ?? $category->description ?? 'Danh sách bài viết mới nhất, cập nhật liên tục' }}">
        <meta name="keywords" content="{{ $category->meta_keywords ?? 'bài viết, tin tức, cập nhật, xu hướng' }}">

        {{-- Open Graph --}}
        <meta property="og:title" content="{{ $category->meta_title ?? $category->name }}">
        <meta property="og:description" content="{{ $category->meta_description ?? $category->description }}">
        <meta property="og:image" content="{{ $category->image ? asset($category->image) : asset('assets/frontend/img/default.jpg') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="article">

        {{-- Twitter Card --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $category->meta_title ?? $category->name }}">
        <meta name="twitter:description" content="{{ $category->meta_description ?? $category->description }}">
        <meta name="twitter:image" content="{{ $category->image ? asset($category->image) : asset('assets/frontend/img/default.jpg') }}">
        <meta name="twitter:site" content="@thietbinhatminh">

        {{-- Canonical --}}
        <link rel="canonical" href="{{ url()->current() }}">

@php
    $schema = [
        '@context' => 'https://schema.org',
        '@type'    => 'ItemList',
        'itemListElement' => [],
    ];

    foreach ($data as $index => $item) {
        $schema['itemListElement'][] = [
            '@type'         => 'BlogPosting',
            'position'      => $index + 1,
            'headline'      => $item->title,
            'image'         => $item->image
                                ? asset($item->image)
                                : asset('assets/frontend/img/default.jpg'),
            'url'           => url('bai-viet/' . $item->slug),
            'datePublished' => Illuminate\Support\Carbon::parse($item->created_at)->toIso8601String(),
            'author'        => [
                '@type' => 'Organization',
                'name'  => setting('site_name'),
            ],
        ];
    }
@endphp

<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
    @endif
@endsection


@section('main')
    <main>
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('bai-viet') }}

        {{-- NEWS --}}
        <div class="lg:py-20 py-10">
            <div class="max-w-7xl mx-auto px-4">
                @if (isset($data) && count($data) > 0)
                    <div class="grid grid-cols-12 gap-6">
                        @foreach ($data as $item)
                            <x-post colSpan="lg:col-span-4 col-span-6" :item="$item"/>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection

@section('footer')

@endsection
