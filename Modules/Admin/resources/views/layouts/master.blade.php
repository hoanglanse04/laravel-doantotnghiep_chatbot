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
    <div class="hidden md:block w-60 h-full fixed left-0 top-0 bg-[#f2f5f1]">
        @include('admin::partials.sidebar')
    </div>
    <div class="ml-60">
        @include('admin::partials.top')
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

    <!-- Modal xác nhận xoá -->
    <div id="deleteModal" uk-modal>
        <div class="uk-modal-dialog uk-margin-auto-vertical !rounded-md overflow-hidden">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-center">
                    <x-admin::icon.danger class="h-10 w-10 fill-current text-red-600" />
                    <p class="ml-2 text-md leading-6 font-medium text-gray-800">Bạn có chắc chắn muốn xoá bản ghi này?</p>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button onclick="confirmDelete()" class="uk-modal-close bg-[#56a661] hover:bg-[#4b8c54] text-white px-4 py-2 rounded cursor-pointer">
                    Xác nhận
                </button>
                <button class="uk-modal-close bg-gray-600 hover:bg-gray-800 text-white px-4 py-2 rounded mr-2 cursor-pointer" type="button">
                    Thoát
                </button>
            </div>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/uikit/uikit.min.js') }}"></script>
    @vite(['resources/js/admin.js'])
    @yield('footer')
    @stack('footer')
</body>
