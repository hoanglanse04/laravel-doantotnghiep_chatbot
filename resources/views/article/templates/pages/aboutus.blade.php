@extends('layouts.master')
@section('title', $article->title)
@section('description', $article->meta_description)
@section('keywords', $article->meta_keywords)
@section('head')
    {{-- Open Graph cho Facebook --}}
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ $article->meta_description }}">
    <meta property="og:image" content="{{ $article->image }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $article->title }}">
    <meta name="twitter:description" content="{{ $article->meta_description }}">
    <meta name="twitter:image" content="{{ asset('assets/frontend/img/banner.png') }}">
    <meta name="twitter:site" content="@baodu">

    {{-- Canonical URL để tránh trùng lặp nội dung --}}
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('main')
    <main>
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('page', $article) }}

        <div class="space-y-4">
            {!! $article->body !!}
        </div>
    </main>
@endsection
