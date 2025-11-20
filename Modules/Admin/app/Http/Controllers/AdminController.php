<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Modules\Admin\Http\Requests\LoginRequest;

class AdminController extends \App\Http\Controllers\Controller
{
    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.overview');
        }

        return view('admin::authenlicate.login');
    }

    public function authenticate(LoginRequest $request)
    {
        $attempt = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('admin')->attempt($attempt)) {
            $user = Auth::guard('admin')->user();

            // Kiểm tra role có thuộc ['admin', 'superadmin'] không
            if (in_array($user->role, ['admin', 'superadmin', 'editor'])) {
                return redirect()->route('admin.overview');
            }

            // Đăng xuất nếu role không hợp lệ
            Auth::guard('admin')->logout();
        }

        return redirect()->back()->with('error', 'Đăng nhập thất bại!');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
