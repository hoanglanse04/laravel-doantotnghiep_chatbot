<?php

namespace Modules\Admin\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use Modules\Admin\Http\Requests\Category\CreateCategoryRequest;
use Modules\Admin\Http\Requests\Category\UpdateCategoryRequest;

class CategoryController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        $keywords = $request->input('keywords');
        $per_page = $request->input('per_page', 20);
        $status = $request->input('status');

        $data = Category::keywords($keywords)
            ->status($status)
            ->orderBy('id', 'DESC')
            ->paginate($per_page);

        return view('admin::category.index', compact('data'));
    }

    public function create()
    {
        $filenames = $this->getFilesInFolder('resources/views/article/templates/pages');
        $categories = ['' => 'Thuộc về lớn nhất'] + Category::getCategoryOptions();

        return view('admin::category.create-edit', compact('filenames', 'categories'));
    }

    public function store(CreateCategoryRequest $request)
    {
        try {
            $data = Category::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name'), '-'),
                'image' => $request->input('image'),
                'content' => $request->input('content'),
                'user_id' => Auth::guard('admin')->user()->id,
                'parent_id' => $request->input('parent_id'),
                'status' => $request->input('status'),
                'type' => $request->input('type'),
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keywords' => $request->input('meta_keywords'),
            ]);

            return redirect()->route('admin.category.edit', $data->id)
                ->with('success', 'chuyên mục đã được tạo thành công.');
        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Tạo chuyên mục thất bại: ' . $exception->getMessage());
        }
    }

    public function show($id)
    {
        $data = Category::findOrFail($id);

        return view('admin::category.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Category::findOrFail($id);
        $categories = ['' => 'Thuộc về lớn nhất'] + Category::getCategoryOptions();

        return view('admin::category.create-edit', compact('data', 'categories'));
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $data = Category::findOrFail($id);

            $data->update([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name'), '-'),
                'image' => $request->input('image'),
                'content' => $request->input('content'),
                'user_id' => Auth::guard('admin')->user()->id,
                'parent_id' => $request->input('parent_id'),
                'status' => $request->input('status'),
                'type' => $request->input('type'),
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keywords' => $request->input('meta_keywords'),
            ]);

            return redirect()->route('admin.category.edit', $data->id)
                ->with('success', 'chuyên mục đã được cập nhật thành công.');
        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Cập nhật chuyên mục thất bại: ' . $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        $data = Category::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.category.index')->with('success', 'Chuyên mục đã được xóa.');
    }
}
