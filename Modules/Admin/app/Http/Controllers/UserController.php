<?php

namespace Modules\Admin\Http\Controllers;

use Hash;
use Exception;
use Illuminate\Http\Request;

use App\Models\User;

use Modules\Admin\Http\Requests\User\StoreUserRequest;
use Modules\Admin\Http\Requests\User\UpdateUserRequest;

class UserController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keywords = $request->keywords ?: null;
        $per_page = $request->per_page ?: 20;
        $status = $request->status ?: null;

        $data = User::keywords($keywords)
            ->status($status)
            ->orderBy('id', 'DESC')
            ->paginate($per_page);

        return view('admin::user.index', compact(
            'data'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::user.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $data = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => $request->status,
                'gender' => $request->gender,
                'role' => $request->role,
                'password' => Hash::make($request->password),
                'image' => $request->password,
            ]);

            return redirect()->route('admin.user.edit', $data->id)->with('success', 'Khách hàng đã được tạo thành công.');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Tạo Khách hàng thất bại: ' . $exception->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $data = User::findOrFail($id);

        return view('admin::user.show', compact(
            'data'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = User::findOrFail($id);

        return view('admin::user.create-edit', compact(
            'data',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $data = User::findOrFail($id);

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => $request->status,
                'gender' => $request->gender,
                'role' => $request->role,
                'limit' => $request->limit,
                'image' => $request->image,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $data->update($updateData);

            return redirect()->route('admin.user.edit', $data->id)->with('success', 'Cập nhật thông tin khách hàng thành công.');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Cập nhật thông tin khách hàng thất bại: ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = User::findOrFail($id);

        $data->delete();

        return redirect()->route('admin.user.index')->with('success', 'Khách hàng đã được xóa.');
    }
}
