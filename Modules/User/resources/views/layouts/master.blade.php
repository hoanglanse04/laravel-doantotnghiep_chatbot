<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <meta name="description" content="{{ $description ?? '' }}">
    <meta name="keywords" content="{{ $keywords ?? '' }}">
    <meta name="author" content="{{ $author ?? '' }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

    <!-- CSS Styles -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/libs/uikit/uikit.min.css') }}">
    @vite(['resources/css/admin.css'])
    @yield('head')
</head>

<body class="bg-[#f9fafb]">
    <div class="hidden md:block w-60 h-full fixed left-0 top-0 bg-[#f2f5f1] pt-3">
        @include('user::partials.sidebar')
    </div>
    <div class="ml-60">
        @include('user::partials.top')
        <div class="p-6 mt-14">
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

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mb-4 text-sm">
                    <strong>Lỗi!</strong> Vui lòng kiểm tra các lỗi bên dưới.
                    <ul class="mt-2">
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/uikit/uikit.min.js') }}"></script>
    @vite(['resources/js/admin.js'])
    @yield('footer')
    @stack('footer')
</body>
