<?php

namespace Modules\Admin\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

use App\Models\Role;

use Modules\Admin\Http\Requests\Post\CreatePostRequest;
use Modules\Admin\Http\Requests\Post\UpdatePostRequest;

class PermissionsController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keywords = $request->keywords ?: null;
        $per_page = $request->per_page ?: 20;
        $status = $request->status ?: null;

        $data = Role::keywords($keywords)
                        ->status($status)
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
        return view('admin::roles.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        try {
            $data = Role::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.roles.edit', $data->id)->with('success', 'Vai trò đã được tạo thành công.');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Tạo Vai trò thất bại: ' . $exception->getMessage());
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
        $data = Role::findOrFail($id);
        return view('admin::roles.create-edit', compact(
            'data'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, $id)
    {
        try {
            $data = Role::findOrFail($id);

            $data->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.post.edit', $data->id)->with('success', 'Vai trò đã được tạo thành công.');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Tạo Vai trò thất bại: ' . $exception->getMessage());
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
