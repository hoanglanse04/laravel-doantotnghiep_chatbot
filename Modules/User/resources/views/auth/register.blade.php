@extends('layouts.master')
@section('title', 'Đăng ký thành viên')
@section('robots', 'noindex, nofollow')
@section('head')
@endsection

@section('main')
<main>
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('authenlicate', 'register') }}

    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col items-center justify-center lg:py-20 py-6">
            <div class="w-full bg-white rounded-lg border-2 border-solid border-gray-100 md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Đăng ký tài khoản của bạn
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="{{ route('user.register') }}" method="POST">
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
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Họ và tên</label>
                            <input type="text" name="name" id="name"
                                   value="{{ old('name') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                   placeholder="John Wick" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email của bạn</label>
                            <input type="email" name="email" id="email"
                                   value="{{ old('email') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                   placeholder="name@company.com" required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Mật khẩu</label>
                            <input type="password" name="password" id="password"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                   required>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Xác thực mật khẩu</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                   required>
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" aria-describedby="terms" type="checkbox"
                                       class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300"
                                       required>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-light text-gray-500">
                                    Tôi chấp nhận <a class="font-medium text-primary-600 hover:underline" href="#">Điều khoản và điều kiện</a>
                                </label>
                            </div>
                        </div>

                        <button type="submit"
                                class="w-full text-white cursor-pointer bg-[#c7a97f] bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Đăng ký một tài khoản
                        </button>

                        <p class="text-sm font-light text-gray-500">
                            Bạn đã có tài khoản? <a href="{{ route('user.login') }}" class="font-medium text-primary-600 hover:underline">Đăng nhập ở đây</a>
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
