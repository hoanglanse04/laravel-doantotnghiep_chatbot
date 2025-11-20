<?php

namespace Modules\Admin\Http\Controllers;

use Exception;
use App\Enums\Common;
use App\Enums\ContentType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Post;

use Modules\Admin\Http\Requests\Post\CreatePostRequest;
use Modules\Admin\Http\Requests\Post\UpdatePostRequest;

class PostController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        $keywords = $request->input('keywords');
        $per_page = $request->input('per_page', 20);
        $status = $request->input('status');

        $data = Post::keywords($keywords)
            ->status($status)
            ->orderBy('id', 'DESC')
            ->paginate($per_page);

        return view('admin::post.index', compact('data'));
    }

    public function create()
    {
        $categories = Category::orderBy('type')
            ->orderBy('name')
            ->get()
            ->groupBy('type')
            ->mapWithKeys(function ($group, $type) {
                $label = ContentType::fromString($type)?->label() ?? 'Khác';
                return [$label => $group->pluck('name', 'id')->toArray()];
            })
            ->toArray();

        return view('admin::post.create-edit', compact('categories'));
    }

    public function store(CreatePostRequest $request)
    {
        try {
            $data = Post::create([
                'title' => $request->input('title'),
                'slug' => Str::slug($request->input('title'), '-'),
                'image' => $request->input('image'),
                'content' => $request->input('content'),
                'user_id' => Auth::guard('admin')->user()->id,
                'status' => $request->input('status'),
                'category_id' => $request->input('category_id'),
                'published_at' => $request->input('published_at'),
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keywords' => $request->input('meta_keywords'),
            ]);

            return redirect()->route('admin.post.edit', $data->id)->with('success', 'Bài viết đã được tạo thành công.');
        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Tạo Bài viết thất bại: ' . $exception->getMessage());
        }
    }

    public function show($id)
    {
        $data = Post::findOrFail($id);
        return view('admin::post.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Post::findOrFail($id);
        $categories = Category::where('type', Common::CATEGORY_POST->value)
            ->orderBy('id', 'desc')
            ->pluck('name', 'id')
            ->toArray();

        return view('admin::post.create-edit', compact('data', 'categories'));
    }

    public function update(UpdatePostRequest $request, $id)
    {
        try {
            $data = Post::findOrFail($id);

            $data->update([
                'title' => $request->input('title'),
                'slug' => Str::slug($request->input('title'), '-'),
                'image' => $request->input('image'),
                'content' => $request->input('content'),
                'status' => $request->input('status'),
                'category_id' => $request->input('category_id'),
                'user_id' => Auth::guard('admin')->user()->id,
                'published_at' => $request->input('published_at'),
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keywords' => $request->input('meta_keywords'),
            ]);

            return redirect()->route('admin.post.edit', $data->id)->with('success', 'Bài viết đã được tạo thành công.');
        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Tạo Bài viết thất bại: ' . $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        $data = Post::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.post.index')->with('success', 'Bài viết đã được xóa.');
    }
}
