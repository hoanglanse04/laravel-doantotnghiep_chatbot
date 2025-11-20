<!--------------------------------------------------
====================================================
 ______                 _ _  _
|  ____|               | | |/ |
| |____  ___  _ __   __| |   /
|  ____|/ _ \| '_ \ / _  |  |
| |    | (_) | | | | (_| |   \
|_|     \___/|_| |_|\__._|_|\_|

====================================================
 Giải pháp phần mềm và phát triển hệ thống cho doanh nghiệp
 Website: https://fondk.vn
 Copyright (c) 2018 - 2025
 Email: treconyl@gmail.com
 Hotline: 036.576.8965
 Facebook: https://www.facebook.com/treconyl
--------------------------------------------------->
<!DOCTYPE html>
<html lang="vi">

<head>
    <title>@yield('title', 'Thiết bị nhật minh')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="robots" content="@yield('robots', 'index, follow')">

    <meta charset="UTF-8">
    <meta http-equiv="content-language" content="vi" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="revisit-after" content="3 days" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:locale" content="vi_VN">
    <link rel="alternate" media="only screen and (max-width: 450px)" href="{{ url()->current() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('head')
    {!! setting('site_head') !!}
</head>

<body class="text-sm">
    {!! setting('site_body') !!}
    <header>
        <div class="border-b border-gray-200 border-t-4 border-t-[#ef233c]">
            <div class="max-w-7xl px-4 mx-auto py-2 flex items-center justify-between text-gray-500">
                <div class="text-sm lg:block hidden">

                </div>
                {{ menu('menu trên cùng', 'builder.menu.head') }}
            </div>
        </div>
        <div class="max-w-7xl px-4 mx-auto grid grid-cols-1 md:grid-cols-3 items-center gap-4 lg:mb-0 mb-2">
            <div class="flex items-center justify-between">
                <div class="flex justify-start lg:ml-[77px]">
                    <a href="/">
                        <img class="h-12 my-4" src="{{ setting('site_logo') }}" alt="{{ setting('site_name') }}">
                    </a>
                </div>
                <div class="flex justify-center space-x-6 md:hidden">
                    <a href="{{ route('user.login') }}" class="flex group/icon gap-2 items-center">
                        <x-icon.user w="26" />
                    </a>
                    <a href="{{ route('cart.index') }}" class="flex group/icon gap-2 items-center">
                        <x-icon.cart w="26" />
                    </a>
                </div>
            </div>
            <div class="flex justify-center">
                <form action="{{ route('form.search') }}" class="flex items-center w-full max-w-xl">
                    <input type="text" placeholder="Tìm kiếm.." name="keywords"
                        class="flex-grow border border-gray-200 border-r-0 p-3 rounded-l-md outline-none">
                    <button type="submit" aria-label="Tìm kiếm"
                        class="h-[46px] bg-[#ef233c] text-white px-4 rounded-r-md cursor-pointer">
                        <x-icon.search />
                    </button>
                </form>
            </div>
            <div class="hidden md:flex justify-end space-x-4">
                <a href="{{ route('user.login') }}" aria-label="thông tin người dùng"
                    class="flex group/icon gap-2 items-center">
                    <x-icon.user w="30" />
                </a>
                <a href="{{ route('cart.index') }}" aria-label="giỏ hàng"
                    class=" relative group/icon gap-2 items-center">
                    <x-icon.cart w="30" />
                    @if ($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-1.5">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
            </div>
        </div>

        <div class="w-full pc-menu top-0 left-0 z-50 bg-white lg:block hidden">
            <div class="max-w-7xl px-4 mx-auto flex items-center justify-between relative">
                <div class="flex items-center justify-between">
                    <div class="mr-8" id="category-toggle">
                        <div
                            class="h-[52px] flex items-center justify-between text-[15px] space-x-2 bg-[#ef233c] text-white py-3 rounded-t-md w-[280px] px-4 cursor-pointer">
                            <div class="flex items-center space-x-2">
                                <x-icon.hambuger w="26" />
                                <span>Chuyên mục sản phẩm</span>
                            </div>
                            <x-icon.arrow-down />
                        </div>

                        <div
                            class="w-[280px] bg-gray-50 absolute z-50 mx-4 top-13 left-0 border border-t-0 border-gray-200 transition-all duration-300 rounded-b-md hidden">
                            <ul>
                                @forelse ($categories_provider as $category)
                                    <li class="group relative">
                                        <a class="px-4 py-3 flex items-center justify-between hover:text-[#ef233c] group-hover:bg-white uppercase font-medium text-xs"
                                            href="{{ route('category', ['slug' => $category->slug]) }}">
                                            {{ $category->name }}
                                            @if ($category->children && $category->children->count())
                                                <x-icon.chevron-right w="14" />
                                            @endif
                                        </a>
                                        {{-- Kiểm tra nếu có children --}}
                                        @if ($category->children && $category->children->count())
                                            <ul
                                                class="w-78 absolute top-0 left-[278px] bg-gray-50 group-hover:block border border-gray-200 rounded-r-md hidden">
                                                @foreach ($category->children as $child)
                                                    <li class="">
                                                        <a href="{{ route('category', ['slug' => $child->slug]) }}"
                                                            class="block py-3 px-4 hover:text-[#ef233c]">
                                                            {{ $child->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @empty
                                    <li class="px-4 py-2 text-sm text-gray-500">Chưa có chuyên mục nào</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    {{ builder('menu-top', 'builder.menu.pc') }}
                </div>
                <div class="flex items-center space-x-2">
                    <img src="https://autogear-demo.myshopify.com/cdn/shop/files/delivery.png?v=1726048149"
                        alt="">
                    <p>Giao hàng miễn phí</p>
                </div>
            </div>
        </div>

        {{-- Overlay --}}
        <div id="mobileMenuOverlay" class="fixed inset-0 z-50 bg-black/40 hidden" onclick="closeMobileMenu()"></div>

        {{-- Sidebar --}}
        <div id="mobileMenuSidebar"
            class="fixed top-0 right-0 z-50 bg-white w-80 h-full overflow-y-scroll px-8 py-4 shadow-lg 
           translate-x-[100%] transition-transform duration-300">
            <div class="flex justify-between items-center mb-4">
                <h2 id="mobileMenuTitle" class="font-bold text-sm">MENU</h2>
                <button onclick="closeMobileMenu()" class="text-xl font-bold">×</button>
            </div>

            {{-- Danh sách menu chính --}}
            {{ builder('menu-top', 'builder.menu.mobile') }}

            {{-- Danh sách chuyên mục sản phẩm --}}
            <ul id="menuCategory" class="space-y-3 text-sm text-gray-700 hidden">
                @forelse ($categories_provider as $category)
                    <li>
                        <a class="py-1 block hover:text-[#ef233c]"
                            href="{{ route('category', ['slug' => $category->slug]) }}">
                            {{ $category->name }}
                        </a>

                        {{-- @if ($category->children && $category->children->count())
                    <ul class="ml-4 space-y-2 mt-1 text-gray-600 text-sm">
                        @foreach ($category->children as $child)
                        <li>
                            <a class="py-1 block hover:text-[#ef233c]"
                                href="{{ route('category', ['slug' => $child->slug]) }}">
                                {{ $child->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif --}}
                    </li>
                @empty
                    <li class="px-4 py-2 text-sm text-gray-500">Chưa có chuyên mục nào</li>
                @endforelse
            </ul>
        </div>
        {{-- Trigger --}}
        <div class="lg:hidden px-4 flex items-center justify-between space-x-4 menu-mobile">
            <div onclick="toggleMobileMenu('category')"
                class="flex items-center py-3 text-[15px] space-x-2 text-gray-600 rounded-t-md w-[280px] cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <rect width="24" height="24" fill="none" />
                    <g fill="none" stroke="currentColor" stroke-width="1.5">
                        <path
                            d="M4.979 9.685C2.993 8.891 2 8.494 2 8s.993-.89 2.979-1.685l2.808-1.123C9.773 4.397 10.767 4 12 4s2.227.397 4.213 1.192l2.808 1.123C21.007 7.109 22 7.506 22 8s-.993.89-2.979 1.685l-2.808 1.124C14.227 11.603 13.233 12 12 12s-2.227-.397-4.213-1.191z" />
                        <path stroke-linecap="round"
                            d="M22 12s-.993.89-2.979 1.685l-2.808 1.124C14.227 15.603 13.233 16 12 16s-2.227-.397-4.213-1.191L4.98 13.685C2.993 12.891 2 12 2 12m20 4s-.993.89-2.979 1.685l-2.808 1.124C14.227 19.603 13.233 20 12 20s-2.227-.397-4.213-1.192L4.98 17.685C2.993 16.891 2 16 2 16" />
                    </g>
                </svg>
                <span>Chuyên mục sản phẩm</span>
            </div>
            <button aria-label="menu mobile" class="py-3" onclick="toggleMobileMenu('main')">
                <x-icon.hambuger w="26" />
            </button>
        </div>
    </header>

    @yield('main')

    <footer class="bg-gray-900 text-white text-sm">
        {{ builder('service-highlights', 'builder.service-highlights') }}


        <!-- Middle Links Section -->
        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-2 lg:grid-cols-5 gap-6 px-4 py-10">
            <!-- Liên hệ -->
            <div>
                <p class="font-semibold text-lg mb-4">Liên hệ</p>
                <p class="mb-2">{{ setting(slug: 'site_name') }}</p>
                <p class="mb-2">{{ setting('tax_code') }}</p>

                <p class="mb-2">{{ setting('address') }}</p>
                <p class="mb-2">📧 {{ setting('contact_email') }}</p>
                <p>📞 {{ setting('contact_phone') }}</p>
            </div>

            <!-- Cần hỗ trợ? -->
            <div>
                <p class="font-semibold text-lg mb-4">Cần hỗ trợ?</p>
                {{ builder('menu-footer-1', 'builder.menu.footer') }}
            </div>

            <!-- Thông tin -->
            <div>
                <p class="font-semibold text-lg mb-4">Thông tin</p>
                {{ builder('menu-footer-2', 'builder.menu.footer') }}
            </div>

            <!-- Liên kết nhanh -->
            <div>
                <p class="font-semibold text-lg mb-4">Liên kết nhanh</p>
                {{ builder('menu-footer-3', 'builder.menu.footer') }}
            </div>

            <!-- Bản tin -->
            <div>
                <p class="font-semibold text-lg mb-4">Nhận thông tin mới nhất!</p>
                <p class="mb-4">Đăng ký bản tin để nhận ưu đãi, tin khuyến mãi và các chương trình sắp tới</p>


            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-gray-700 py-6 px-4 text-center text-gray-400">
            <div class="text-sm">Công ty TNHH Công nghệ Thủy Lợi</div>
        </div>
    </footer>

    <div>

        <a href="{{ setting('social_zalo') }}"
            class="w-11 h-11 fixed z-50 lg:bottom-36 bottom-16 lg:right-10 right-4">
            <img src="{{ asset('assets/frontend/img/logo-zalo-tron.png') }}" alt="logo-zalo">
        </a>
        <div id="backToTop"
            class="w-11 h-11 fixed z-50 lg:bottom-20 bottom-4 lg:right-10 right-4 bg-[#ef233c] text-[#fff2dc] flex items-center justify-center cursor-pointer transition duration-300 opacity-0 invisible">
            <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-white" width="24" height="24"
                viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="m17.71 11.29l-5-5a1 1 0 0 0-.33-.21a1 1 0 0 0-.76 0a1 1 0 0 0-.33.21l-5 5a1 1 0 0 0 1.42 1.42L11 9.41V17a1 1 0 0 0 2 0V9.41l3.29 3.3a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.42" />
            </svg>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="uk-flex-top uk-open bg-gray-500 bg-opacity-75" uk-modal style="display: block;">
            <div class="uk-modal-dialog uk-margin-auto-vertical !bg-transparent h-full">
                <div class="flex items-center justify-center flex-col h-full pt-4 px-4 pb-20 text-center sm:p-0">
                    <div
                        class="align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-darkgreen-200 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 fill-current text-darkgreen-900"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                        <path
                                            d="M14.5 2.792969L5.5 11.792969L1.851563 8.148438L1.5 7.792969L0.792969 8.5L1.148438 8.851563L5.5 13.207031L15.207031 3.5Z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-darkgreen-900" id="modal-title">
                                        Chúc mừng
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            {!! session()->get('success') !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                class="uk-modal-close w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white hover:bg-darkgreen-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-darkgreen-500 sm:ml-3 sm:w-auto sm:text-sm bg-gray-900"
                                type="button">Thoát</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(session()->has('error'))
        <div class="uk-flex-top uk-open bg-gray-500 bg-opacity-75" uk-modal style="display: block;">
            <div class="uk-modal-dialog uk-margin-auto-vertical !bg-transparent h-full">
                <div class="flex items-center justify-center flex-col h-full pt-4 px-4 pb-20 text-center sm:p-0">
                    <div
                        class="align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-darkgreen-200 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 fill-current text-darkgreen-900"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                        <path
                                            d="M14.5 2.792969L5.5 11.792969L1.851563 8.148438L1.5 7.792969L0.792969 8.5L1.148438 8.851563L5.5 13.207031L15.207031 3.5Z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-darkgreen-900" id="modal-title">
                                        Xin lỗi!
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            {!! session()->get('error') !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                class="uk-modal-close w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white hover:bg-darkgreen-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-darkgreen-500 sm:ml-3 sm:w-auto sm:text-sm bg-gray-900"
                                type="button">Thoát</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Overlay -->
    <div id="modal-alert-cart" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">

        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <!-- Nền mờ -->
            <div class="fixed inset-0 bg-gray-500/75 transition-opacity close-modal" aria-hidden="true"></div>

            <!-- Hộp modal -->
            <div
                class="relative z-[9999] bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div id="modal-icon-wrapper"
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-300/30 sm:mx-0 sm:h-10 sm:w-10">
                            <svg id="icon-success" class="h-6 w-6 fill-current text-green-500"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M22.59375 3.5L8.0625 18.1875L1.40625 11.5625L0 13L8.0625 21L24 4.9375Z"></path>
                            </svg>
                            <svg id="icon-error" class="h-6 w-6 fill-current text-red-500 hidden"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <rect width="24" height="24" fill="none" />
                                <g fill="none">
                                    <path stroke="currentColor" stroke-width="1.5"
                                        d="M5.312 10.762C8.23 5.587 9.689 3 12 3s3.77 2.587 6.688 7.762l.364.644c2.425 4.3 3.638 6.45 2.542 8.022S17.786 21 12.364 21h-.728c-5.422 0-8.134 0-9.23-1.572s.117-3.722 2.542-8.022z" />
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5"
                                        d="M12 8v5" />
                                    <circle cx="12" cy="16" r="1" fill="currentColor" />
                                </g>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <p class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Thêm vào giỏ hàng thành công
                            </p>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Quý khách đặt mua nhiều sản phẩm cùng một đơn hàng để được phí vận chuyển tốt hơn.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <a id="modal-cart-link" href="{{ route('cart.index') }}"
                    class="w-full text-center block justify-center shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-gray-50 hover:bg-green-700">
                    Xem giỏ hàng
                </a>
            </div>
        </div>
    </div>



    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/slick/slick.min.js') }}"></script>

    {!! setting('tong-quan-footer') !!}
    @vite(['resources/js/app.js'])
    @yield('footer')
    {!! setting('site_footer') !!}
    <script>
        const sidebar = document.getElementById("mobileMenuSidebar");
        const overlay = document.getElementById("mobileMenuOverlay");
        const menuTitle = document.getElementById("mobileMenuTitle");
        const menuMain = document.getElementById("menuMain");
        const menuCategory = document.getElementById("menuCategory");

        function openMobileMenu() {
            sidebar.classList.remove("translate-x-[100%]");
            sidebar.classList.add("translate-x-0");
            overlay.classList.remove("hidden");
        }

        function closeMobileMenu() {
            sidebar.classList.add("translate-x-[100%]");
            sidebar.classList.remove("translate-x-0");
            overlay.classList.add("hidden");
        }


        function toggleMobileMenu(type) {
            // Ẩn cả 2 menu
            menuMain.classList.add("hidden");
            menuCategory.classList.add("hidden");

            // Cập nhật tiêu đề và hiện đúng menu
            if (type === "category") {
                menuTitle.textContent = "SHOP BY CATEGORIES";
                menuCategory.classList.remove("hidden");
            } else {
                menuTitle.textContent = "MAIN MENU";
                menuMain.classList.remove("hidden");
            }

            openMobileMenu();
        }

        // Ngăn click trong menu đóng overlay
        sidebar.addEventListener("click", (e) => e.stopPropagation());
    </script>
</body>

</html>
