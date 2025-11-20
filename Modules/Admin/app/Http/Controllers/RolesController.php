<?php

namespace Modules\Admin\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\Permission;

class RolesController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keywords = $request->keywords ?: null;
        $per_page = $request->per_page ?: 20;

        $data = Role::keywords($keywords)
                        ->orderBy('id', 'DESC')
                        ->paginate($per_page);

        return view('admin::roles.index', compact(
            'data'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('admin::roles.create-edit', compact(
            'permissions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = Role::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            // Gán quyền được chọn (nếu có)
            $data->permissions()->sync($request->permissions ?? []);

            return redirect()->route('admin.roles.edit', $data->id)->with('success', 'Vai trò đã được tạo thành công.');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Tạo vai trò thất bại: ' . $exception->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $data = Role::findOrFail($id);

        return view('admin::roles.show', compact(
            'data'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();

        return view('admin::roles.create-edit', compact(
            'data',
            'permissions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Role::findOrFail($id);

            $data->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            // Đồng bộ lại các permissions
            $data->permissions()->sync($request->permissions ?? []);

            return redirect()->route('admin.roles.edit', $data->id)->with('success', 'Vai trò đã được cập nhật thành công.');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Cập nhật vai trò thất bại: ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Role::findOrFail($id);

        $data->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Vai trò đã được xóa.');
    }
}
