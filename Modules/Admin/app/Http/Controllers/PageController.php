<?php

namespace Modules\Admin\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Page;

use Modules\Admin\Http\Requests\Page\CreatePageRequest;
use Modules\Admin\Http\Requests\Page\UpdatePageRequest;

class PageController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keywords = $request->keywords ?: null;
        $per_page = $request->per_page ?: 20;
        $status = $request->status ?: null;

        $data = Page::keywords($keywords)
            ->status($status)
            ->orderBy('id', 'DESC')
            ->paginate($per_page);

        return view('admin::page.index', compact(
            'data'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filenames = $this->getFilesInFolder('resources/views/article/templates/pages');

        $filenames = array_combine(
            $filenames,
            array_map(fn($filename) => ucfirst(str_replace('_', ' ', $filename)), $filenames)
        );

        return view('admin::page.create-edit', compact(
            'filenames'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePageRequest $request)
    {
        try {
            $data = Page::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-'),
                'image' => $request->image,
                'content' => $request->content,
                'template' => $request->template,
                'user_id' => Auth::guard('admin')->user()->id,
                'status' => $request->status,
                'published_at' => $request->published_at,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ]);

            return redirect()->route('admin.page.edit', $data->id)->with('success', 'Trang đơn đã được tạo thành công.');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Tạo trang đơn thất bại: ' . $exception->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $data = Page::findOrFail($id);

        return view('admin::page.show', compact(
            'data'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Page::findOrFail($id);
        $filenames = $this->getFilesInFolder('resources/views/article/templates/pages');

        $filenames = array_combine(
            $filenames,
            array_map(fn($filename) => ucfirst(str_replace('_', ' ', $filename)), $filenames)
        );

        return view('admin::page.create-edit', compact(
            'data',
            'filenames'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, $id)
    {
        try {
            $data = Page::findOrFail($id);

            $data->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-'),
                'image' => $request->image,
                'content' => $request->content,
                'template' => $request->template,
                'user_id' => Auth::guard('admin')->user()->id,
                'status' => $request->status,
                'published_at' => $request->published_at,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ]);

            return redirect()->route('admin.page.edit', $data->id)->with('success', 'Trang đơn đã được tạo thành công.');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Tạo trang đơn thất bại: ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Page::findOrFail($id);

        $data->delete();

        return redirect()->route('admin.page.index')->with('success', 'Trang đơn đã được xóa.');
    }
}
