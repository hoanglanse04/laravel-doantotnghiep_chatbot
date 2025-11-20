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
        <!-- Breadcrumb -->
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('page', $article) }}

        <section class="w-full aspect-[3/1]">
            {!! setting('google-map') !!}
        </section>

        <section class="md:py-20 py-10 bg-no-repeat bg-cover" style="background-image: url('assets/frontend/img/gradient-background.png')">
            <div class="max-w-7xl mx-auto px-4 grid grid-cols-12 md:gap-4 gap-6">
                <div class="md:col-span-6 col-span-12 transform space-y-6 my-auto">
                    <div class="inline-flex items-center py-2 px-3 space-x-3 bg-white rounded-lg shadow-5xl">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="12" height="12">
                            <path d="M25 11C17.28125 11 11 17.28125 11 25C11 32.71875 17.28125 39 25 39C32.71875 39 39 32.71875 39 25C39 17.28125 32.71875 11 25 11Z" fill="#4277bd" />
                        </svg>
                        <p class="text-gray-600 leading-4 font-bold text-xs">Thông tin liên hệ</p>
                    </div>
                    <h2 class="font-black text-3xl leading-[44px] text-[#35475b]"> Liên hệ ngay với chúng tôi </h2>
                    <p class="font-semibold text-sm leading-6 text-[#616f92] max-w-[483px]">Give us a call or drop by anytime, we endeavour to answer all enquiries within 24 hours on business days. We will be happy to answer your questions.</p>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-gray-600" viewBox="0 0 32 32" width="24" height="24">
                                <path d="M3 7L3 7.0332031L16 14.833984L29 7.0332031L29 7L3 7 z M 3 9.3652344L3 25L29 25L29 9.3652344L16 17.166016L3 9.3652344 z"/>
                            </svg>
                            <p class="font-semibold leading-6 text-sm text-[#35475b]">{{ setting('contact_email') }}</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-gray-600" viewBox="0 0 26 26" width="22" height="22">
                                <path d="M22.386719 18.027344C20.839844 16.703125 19.265625 15.898438 17.738281 17.222656L16.824219 18.019531C16.15625 18.601563 14.914063 21.3125 10.113281 15.785156C5.3125 10.269531 8.167969 9.410156 8.839844 8.835938L9.757813 8.035156C11.277344 6.710938 10.703125 5.042969 9.605469 3.324219L8.945313 2.285156C7.84375 0.574219 6.640625 -0.550781 5.117188 0.769531L4.292969 1.492188C3.617188 1.980469 1.734375 3.578125 1.277344 6.609375C0.726563 10.246094 2.464844 14.414063 6.4375 18.984375C10.40625 23.558594 14.296875 25.855469 17.976563 25.816406C21.035156 25.78125 22.886719 24.140625 23.464844 23.542969L24.289063 22.820313C25.8125 21.5 24.867188 20.152344 23.316406 18.828125Z"/>
                            </svg>
                            <p class="font-semibold leading-6 text-sm text-[#35475b">{{ setting('contact_phone') }}</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-gray-600" viewBox="0 0 50 50" width="24" height="24">
                                <path d="M25 1C16.179688 1 9 8.179688 9 17C9 31.113281 23.628906 47.945313 24.25 48.65625C24.441406 48.875 24.710938 49 25 49C25.308594 48.980469 25.558594 48.875 25.75 48.65625C26.371094 47.933594 41 30.8125 41 17C41 8.179688 33.820313 1 25 1 Z M 25 12C28.3125 12 31 14.6875 31 18C31 21.3125 28.3125 24 25 24C21.6875 24 19 21.3125 19 18C19 14.6875 21.6875 12 25 12Z"/>
                            </svg>
                            <p class="font-semibold leading-6 text-sm text-[#35475b">{{ setting('address') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl md:col-span-6 col-span-12 p-6 shadow-4xl space-y-6">
                    <div class="space-y-2">
                        <h2 class="font-black text-2xl leading-[44px] text-[#35475b]">Liên hệ ngay với chúng tôi</h2>
                        <p class="font-semibold text-sm leading-6 text-[#616f92]">Đội ngũ hỗ trợ của chúng tôi sẽ phản hôid trong vòng 1-2 tiếng làm việc</p>
                    </div>
                    <form action="{{ route('form.contact') }}" method="POST" class="space-y-4" id="recapchaform">
                        @csrf
                        <input type="hidden" name="url_current" value="{{ url()->current() }}">
                        <input type="hidden" name="recaptcha" id="recaptcha" class="hidden">

                        <div class="relative mb-6">
                            <div class="absolute top-2 left-3">
                                <p class="font-semibold text-[13px] leading-4 text-[#747e97]">Họ và tên</p>
                            </div>
                            <input type="text" name="name" class="border border-gray-300 text-sm rounded-xl block w-full pt-6 pl-3 pb-2 placeholder-input" placeholder="Nguyễn Văn A" required>
                        </div>
                        <div class="relative mb-6">
                            <div class="absolute top-2 left-3">
                                <p class="font-semibold text-[13px] leading-4 text-[#747e97]">Email</p>
                            </div>
                            <input type="email" name="email" class="border border-gray-300 text-sm rounded-xl block w-full pt-6 pl-3 pb-2 placeholder-input" placeholder="Example@gmail.com" required>
                        </div>
                        <div class="relative mb-6">
                            <div class="absolute top-2 left-3">
                                <p class="font-semibold text-[13px] leading-4 text-[#747e97]">Số điện thoại</p>
                            </div>
                            <input type="number" name="phone" class="border border-gray-300 text-sm rounded-xl block w-full pt-6 pl-3 pb-2 placeholder-input" placeholder="012 345 6789" required>
                        </div>
                        <div class="relative mb-6">
                            <div class="absolute top-2 left-3">
                                <p class="font-semibold text-[13px] leading-4 text-[#747e97]">Nội dung cần hỗ trợ</p>
                            </div>
                            <textarea name="message" class="border border-gray-300 text-sm rounded-xl block w-full pt-6 pl-3 pb-2 h-36 placeholder-input" placeholder="Hãy mô tả về vấn đề của bạn" required></textarea>
                        </div>
                        <button type="submit" class="flex items-center justify-center space-x-2 w-full rounded-lg text-sm py-3 bg-[#fff] transtion">
                            <p class="font-bold text-sm leading-6 text-white">Gửi thông tin </p>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="20" height="20">
                                <path d="M5.83,23.616c12.568-5.529,28.832-12.27,31.077-13.203c5.889-2.442,7.696-1.974,6.795,3.434 c-0.647,3.887-2.514,16.756-4.002,24.766c-0.883,4.75-2.864,5.313-5.979,3.258c-1.498-0.989-9.059-5.989-10.7-7.163 c-1.498-1.07-3.564-2.357-0.973-4.892c0.922-0.903,6.966-6.674,11.675-11.166c0.617-0.59-0.158-1.559-0.87-1.086 c-6.347,4.209-15.147,10.051-16.267,10.812c-1.692,1.149-3.317,1.676-6.234,0.838c-2.204-0.633-4.357-1.388-5.195-1.676 C1.93,26.43,2.696,24.995,5.83,23.616z" fill="#FCFCFC" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
