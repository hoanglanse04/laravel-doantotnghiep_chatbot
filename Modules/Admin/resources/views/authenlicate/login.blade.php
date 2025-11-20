<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <title>Đăng nhập Quản trị</title>
        <script>
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const toggleIcon = document.getElementById('toggle-icon');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M2.69 6.705a.75.75 0 0 0-1.38.59zm12.897 6.624l-.274-.698zm-6.546.409a.75.75 0 1 0-1.257-.818zm-2.67 1.353a.75.75 0 1 0 1.258.818zM22.69 7.295a.75.75 0 0 0-1.378-.59zM19 11.13l-.513-.547zm.97 2.03a.75.75 0 1 0 1.06-1.06zm-8.72 3.34a.75.75 0 0 0 1.5 0zm5.121-.591a.75.75 0 1 0 1.258-.818zm-10.84-4.25A.75.75 0 0 0 4.47 10.6zm-2.561.44a.75.75 0 0 0 1.06 1.06z"></path></svg>';
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0"></path><path fill="currentColor" fill-rule="evenodd" d="M2 12c0 1.64.425 2.191 1.275 3.296C4.972 17.5 7.818 20 12 20s7.028-2.5 8.725-4.704C21.575 14.192 22 13.639 22 12c0-1.64-.425-2.191-1.275-3.296C19.028 6.5 16.182 4 12 4S4.972 6.5 3.275 8.704C2.425 9.81 2 10.361 2 12m10-3.75a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5" clip-rule="evenodd"></path></svg>';
                }
            }
        </script>
    </head>
    <body>
        <div class="p-8 bg-[url('https://nextuipro.nyc3.cdn.digitaloceanspaces.com/components-images/black-background-texture.jpeg')] bg-cover bg-center">
            <a href="/" class="inline-block">
                <img class="h-10 rounded-md object-cover" src="{{ setting('site_logo') }}" alt="{{ setting('site_name') }}">
            </a>
            <div class="flex h-dvh items-center">
                <form method="POST" action="{{ route('admin.login.process') }}" class="flex w-full mx-auto max-w-sm flex-col gap-4 rounded-2xl bg-white px-8 pb-10 pt-6 shadow-small">
                    @csrf
                    <p class="pb-2 text-xl font-medium text-gray-600 text-center">Đăng nhập quản trị</p>
                    @if(session()->has('error'))
                        <div class="text-red-500 text-sm">
                            {{ session()->get('error') }}
                        </div>
                    @endif

                    <div class="w-full flex flex-col gap-4">
                        <div class="relative w-full">
                            <label for="email" class="absolute top-2 left-3 text-gray-500 text-xs">Email</label>
                            <input id="email" type="email" name="email" placeholder="Nhập email của bạn" value="{{ old('email') }}" required class="w-full h-14 px-3 pt-6 border border-gray-300 rounded-lg focus:border-gray-500 focus:ring-1 focus:ring-gray-500 outline-none text-sm" />
                        </div>

                        <div class="w-full flex flex-col gap-4">
                            <div class="relative w-full">
                                <label for="password" class="absolute top-2 left-3 text-gray-500 text-xs">Mật khẩu</label>
                                <input id="password" type="password" name="password" value="{{ old('password') }}" placeholder="Nhập mật khẩu của bạn" required class="w-full h-14 px-3 pt-6 border border-gray-300 rounded-lg focus:border-gray-500 focus:ring-1 focus:ring-gray-500 outline-none text-sm" />
                                <button type="button" onclick="togglePassword()" class="absolute right-3 top-4 text-gray-500 hover:text-gray-700 cursor-pointer">
                                    <span id="toggle-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0"></path><path fill="currentColor" fill-rule="evenodd" d="M2 12c0 1.64.425 2.191 1.275 3.296C4.972 17.5 7.818 20 12 20s7.028-2.5 8.725-4.704C21.575 14.192 22 13.639 22 12c0-1.64-.425-2.191-1.275-3.296C19.028 6.5 16.182 4 12 4S4.972 6.5 3.275 8.704C2.425 9.81 2 10.361 2 12m10-3.75a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5" clip-rule="evenodd"></path></svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full text-sm px-3 py-3 font-normal bg-[#ed1936] rounded-lg text-gray-200 transition duration-300 hover:text-white hover:shadow-xl cursor-pointer">
                        Đăng nhập
                    </button>
                </form>
            </div>
        </div>
    </body>
</html>
