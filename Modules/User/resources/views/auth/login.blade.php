@extends('layouts.master')
@section('title', 'Đăng nhập')
@section('robots', 'noindex, nofollow')
@section('head')
@endsection

@section('main')
<main>
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('authenlicate', 'login') }}

    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col items-center justify-center lg:py-20 py-6">
            <div class="w-full bg-white rounded-lg border-2 border-solid border-gray-100 md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Đăng nhập vào tài khoản của bạn
                    </h1>
                    <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('user.login.submit') }}">
                        @csrf
                        @if ($errors->any())
                            <div class="mb-4 text-red-600 text-sm">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email của bạn</label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('email') border-red-500 @enderror"
                                placeholder="name@company.com" required>
                            @error('email')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Mật khẩu</label>
                            <input type="password" name="password" id="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('password') border-red-500 @enderror"
                                placeholder="••••••••" required>
                            @error('password')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="remember" class="text-gray-500">Nhớ tôi</label>
                                </div>
                            </div>
                            <a href="#" class="text-sm font-medium text-primary-600 hover:underline">Quên mật khẩu?</a>
                        </div>
                        <button type="submit" class="w-full text-white cursor-pointer bg-[#c7a97f] bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Đăng nhập</button>
                        <p class="text-sm font-light text-gray-500">
                            Không có tài khoản? <a href="{{ route('user.register') }}" class="font-medium text-primary-600 hover:underline">Đăng ký</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('footer')
@endsection
