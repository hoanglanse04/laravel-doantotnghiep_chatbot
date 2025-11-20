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
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => url()->current()
            ],
            'headline' => $article->title,
            'image' => [!empty($article->image) ? asset($article->image) : asset('assets/frontend/img/default-article.jpg')],
            'datePublished' => $article->created_at,
            'dateModified' => $article->updated_at,
            'author' => ['@type' => 'Person', 'name' => 'Thiết bị nhật minh'],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Thiết bị nhật minh',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('assets/frontend/img/logo.png')
                ]
            ],
            'description' => Str::limit(strip_tags($article->meta_description ?? $article->body), 160)
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endsection

@section('main')
    <main>
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('page', $article) }}

        <section class="max-w-7xl mx-auto px-4">
            <div class="md:grid grid-cols-12 gap-6 mt-6">
                <div class="col-span-12 mb-6 space-y-4">
                    {!! $article->content !!}
                </div>
            </div>
        </section>
    </main>
@endsection

@section('footer')

@endsection
