<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\User;

use Modules\User\Http\Requests\Auth\LoginRequest;
use Modules\User\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::guard('user')->check()) {
            return redirect()->route('user.overview');
        }

        return view('user::auth.login');
    }


    public function register()
    {
        if (Auth::guard('user')->check()) {
            return redirect()->route('user.overview');
        }

        return view('user::auth.register');
    }


    public function handleLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('user')->attempt($credentials, $request->filled('remember'))) {
            $user = Auth::guard('user')->user();
            if ($user->status !== 'active') {
                Auth::guard('user')->logout();
                return back()->withErrors([
                    'email' => 'Tài khoản của bạn đang bị khóa hoặc chưa kích hoạt.',
                ]);
            }

            return redirect()->route('user.overview')->with('success', 'Đăng nhập thành công.');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->withInput();
    }

    public function handleRegister(RegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'status'   => 'active',
            'role'     => 'user',
            'gender'   => $request->gender ?? 'other',
            'image'    => null,
        ]);

        Auth::guard('user')->login($user);

        return redirect('/')->route('user.login')->with('success', 'Đăng ký tài khoản thành công.');
    }

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();

        return redirect('/');
    }
}
