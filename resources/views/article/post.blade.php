@extends('layouts.master')

@section('title', $article->meta_title ?? $article->title)
@section('description', Str::limit(strip_tags($article->meta_description ?? $article->body), 160))
@section('keywords', $article->meta_keywords ?? implode(', ', explode(' ', $article->title)))

@section('head')
    {{-- Open Graph (Facebook, Zalo) --}}
    <meta property="og:title" content="{{ $article->meta_title ?? $article->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($article->meta_description ?? $article->body), 160) }}">
    <meta property="og:image"
        content="{{ !empty($article->image) ? asset($article->image) : asset('assets/frontend/img/default-article.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">
    <meta property="article:published_time" content="{{ $article->created_at->toIso8601String() }}">
    <meta property="article:modified_time" content="{{ $article->updated_at->toIso8601String() }}">
    <meta property="og:site_name" content="Tìm Trọ Tốt">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $article->meta_title ?? $article->title }}">
    <meta name="twitter:description"
        content="{{ Str::limit(strip_tags($article->meta_description ?? $article->body), 160) }}">
    <meta name="twitter:image"
        content="{{ !empty($article->image) ? asset($article->image) : asset('assets/frontend/img/default-article.jpg') }}">
    {{--
    <meta name="twitter:site" content="@"> --}}

    <link rel="canonical" href="{{ url()->current() }}">
    @php
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => url()->current(),
            ],
            'headline' => $article->title,
            'image' => [
                !empty($article->image) ? asset($article->image) : asset('assets/frontend/img/default-article.jpg'),
            ],
            'datePublished' => optional($article->created_at)->toIso8601String(),
            'dateModified' => optional($article->updated_at)->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => 'Tìm Trọ Tốt',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Tìm Trọ Tốt',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('assets/frontend/img/logo.png'),
                ],
            ],
            'description' => Str::limit(strip_tags($article->meta_description ?? $article->body), 160),
        ];
    @endphp
    <style>
        .post-content h1 {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 500;
            line-height: 1.2;
            margin: 1.5em 0 0.75em;
        }

        .post-content h2 {
            font-size: clamp(1.75rem, 3.5vw, 2.5rem);
            font-weight: 500;
            line-height: 1.25;
            margin: 1.4em 0 0.7em;
        }

        .post-content h3 {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 500;
            line-height: 1.3;
            margin: 1.3em 0 0.65em;
        }

        .post-content h4 {
            font-size: clamp(1.25rem, 2.5vw, 1.5rem);
            font-weight: 500;
            line-height: 1.35;
            margin: 1.2em 0 0.6em;
        }

        .post-content h5 {
            font-size: clamp(1.125rem, 2vw, 1.25rem);
            font-weight: 500;
            line-height: 1.4;
            margin: 1.1em 0 0.55em;
        }

        .post-content h6 {
            font-size: clamp(1rem, 1.5vw, 1.125rem);
            font-weight: 600;
            line-height: 1.4;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin: 1em 0 0.5em;
        }

        .post-content p {
            margin: 0.75em 0;
            line-height: 1.7;
        }

        .post-content strong {
            font-weight: 600;
        }

        .post-content em {
            font-style: italic;
        }

        .post-content a {
            color: #0077cc;
            text-decoration: underline;
            transition: color 0.2s;
        }

        .post-content a:hover {
            color: #005fa3;
        }

        .post-content ul,
        .post-content ol {
            margin: 1em 0 1em 1.5em;
            padding: 0;
        }

        .post-content ul {
            list-style-type: disc;
        }

        .post-content ol {
            list-style-type: decimal;
        }

        .post-content li {
            margin: 0.4em 0;
            line-height: 1.6;
        }

        .post-content blockquote {
            border-left: 4px solid #0077cc;
            margin: 1.5em 0;
            padding: 0.75em 1em;
            background-color: #f9f9f9;
            color: #555;
            font-style: italic;
        }

        .post-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5em 0;
            font-size: 0.95rem;
        }

        .post-content th,
        .post-content td {
            border: 1px solid #ccc;
            padding: 0.5em 0.75em;
            text-align: left;
        }

        .post-content th {
            background-color: #f3f3f3;
            font-weight: 600;
        }

        .post-content code {
            background: #f5f5f5;
            padding: 0.2em 0.4em;
            border-radius: 4px;
            font-family: "Fira Code", monospace;
            font-size: 0.9em;
        }

        .post-content pre {
            background: #1e1e1e;
            color: #f5f5f5;
            padding: 1em;
            border-radius: 8px;
            overflow-x: auto;
            font-family: "Fira Code", monospace;
            margin: 1.2em 0;
        }

        .post-content img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 1.2em auto;
            border-radius: 8px;
        }

        .post-content iframe {
            width: 100%;
            min-height: 400px;
            border: none;
            margin: 1.5em 0;
            border-radius: 8px;
        }

        .post-content hr {
            border: none;
            border-top: 2px solid #eee;
            margin: 2em 0;
        }

        .post-content figure {
            text-align: center;
            margin: 1.5em auto;
        }

        .post-content figcaption {
            font-size: 0.9rem;
            color: #666;
            margin-top: 0.5em;
        }

        .post-content table,
        .post-content blockquote,
        .post-content pre,
        .post-content figure {
            max-width: 100%;
            overflow-x: auto;
        }
    </style>

    <script type="application/ld+json">
            {!! json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

@endsection

@section('main')
    <main>
        <!--Breadcrumbs-->
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('page', $article) }}

        <div class="max-w-7xl mx-auto px-4 mb-6">
            <div class="md:grid grid-cols-12 gap-6 mt-6">
                <div class="col-span-9 mb-6">
                    <h1 class="md:text-4xl text-2xl mb-4 font-extrabold tracking-tight text-gray-700 line-clamp-2">
                        {{ $article->title }}
                    </h1>
                    <p class="text-gray-700">{{ $article->meta_description }}</p>
                    <div class="post-content space-y-4 mt-4 ">
                        {!! $article->content !!}
                    </div>
                </div>
                <div class="col-span-3">
                    <div class="col-span-10 sm:col-span-10 md:col-span-4 lg:col-span-3">
                        <div>
                            <form action="{{ route('form.search') }}" class="relative">
                                <input name="keywords"
                                    class="appearance-none border-2 border-[#c7a980] w-full py-4 px-4 rounded-lg placeholder-[#a27940] font-medium leading-tight focus:outline-none focus:shadow-outline"
                                    type="text" placeholder="Tìm kiếm">
                            </form>
                        </div>
                        {{-- <div class="mt-8">
                            <h3 class="text-xl font-bold mb-4">Chuyên mục</h3>
                            @if (isset($categories) && count($categories) > 0)
                            @foreach ($categories as $item)
                            <a href="{{ route('category', ['a' => $item->slug]) }}"
                                class="block text-gray-700 text-md font-semibold leading-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                                {{ $item->name }}
                            </a>
                            @endforeach
                            @endif
                        </div> --}}
                        <div>
                            <h3 class="text-xl font-bold my-4">Bài viết liên quan</h3>
                            @if (isset($article_related) && count($article_related) > 0)
                                @foreach ($article_related as $item)
                                    <div class="flex mb-4 gap-4">
                                        <div class="min-w-[128px] w-32 aspect-1">
                                            <img class="w-full h-full object-cover" src="{{ image($item->image) }}"
                                                loading="lazy" class="float-left" alt="">
                                        </div>
                                        <a href="{{ route('article', ['a' => $item->slug]) }}" class="block">
                                            <span class="text-sm text-gray-600">{{ $item->created_at }}</span>
                                            <p class="font-semibold text-justify line-clamp-3">{{ $item->title }}</p>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    {{-- <div class="bg-white p-4 rounded-lg shadow-lg">
                        <h2 class="text-center text-2xl block mb-6 text-darkgreen-900">Bài viết mới nhất</h2>
                        @if (isset($article_related) && count($article_related) > 0)
                        <ul>
                            @foreach ($article_related as $index => $item)
                            <ol>
                                <a href="{{ route('article', ['a' => $item->slug]) }}"
                                    class="flex mb-4 leading-5 text-gray-600 hover:text-darkgreen-900 hover:underline">
                                    <span class="text-left font-semibold"
                                        style="font-family: 'Chronicle SSm A', serif;color: #57696d;min-width: 20px;">{{
                                        $index + 1 }}</span>
                                    <p class="line-clamp-2"> {{ $item->title }} </p>
                                </a>
                            </ol>
                            @endforeach
                        </ul>
                        @endif
                    </div> --}}
                </div>

            </div>
        </div>
    </main>
@endsection

@section('footer')

@endsection
