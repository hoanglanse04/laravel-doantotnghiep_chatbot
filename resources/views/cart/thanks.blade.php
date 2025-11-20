@extends('layouts.master')

@section('title', 'Cảm ơn!')

@section('head')
@endsection

@section('main')
    <div class="">
        <section class="relative py-12 sm:py-16 lg:pt-20 xl:pb-0">
            <img src="{{ asset('assets/frontend/img/thanks.png') }}" alt="Cảm ơn" class="m-auto">
            <div class="relative px-4 mx-auto sm:px-6 lg:px-8 max-w-7xl">
                <div class=" mx-auto text-center">
                    <h1 class="mt-5 text-4xl font-bold leading-tight text-gray-900 sm:text-5xl sm:leading-tight lg:text-6xl lg:leading-tight font-pj">Cảm ơn bạn đã đặt hàng!</h1>
                    <p class="max-w-lg mx-auto mt-6 text-base leading-7 text-gray-600 font-inter">Hóa đơn thanh toán đã được gửi tới email của bạn, vui lòng kiểm tra.</p>

                    <div class="relative inline-flex my-10 group">
                        <div class="absolute transitiona-all duration-1000 opacity-70 -inset-px bg-gradient-to-r from-[#44BCFF] via-[#FF44EC] to-[#FF675E] rounded-xl blur-lg group-hover:opacity-100 group-hover:-inset-1 group-hover:duration-200 animate-tilt"></div>

                        <a href="{{ route('welcome') }}" title="" class="relative inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-white transition-all duration-200 bg-gray-900 font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900" role="button">
                            Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('footer')
@endsection