<?php

namespace Modules\Admin\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Contact;

class ContactController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keywords = $request->keywords ?: null;
        $per_page = $request->per_page ?: 20;
        $status = $request->status ?: null;

        $data = Contact::keywords($keywords)
            ->status($status)
            ->orderBy('id', 'DESC')
            ->paginate($per_page);

        return view('admin::contact.index', compact(
            'data'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::contact.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = Contact::create([
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

            return redirect()->route('admin.contact.edit', $data->id)->with('success', 'Liên hệ đã được tạo thành công.');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Tạo Liên hệ thất bại: ' . $exception->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $data = Contact::findOrFail($id);

        return view('admin::contact.show', compact(
            'data'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Contact::findOrFail($id);

        return view('admin::contact.create-edit', compact(
            'data'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Contact::findOrFail($id);

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

            return redirect()->route('admin.contact.edit', $data->id)->with('success', 'Liên hệ đã được tạo thành công.');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Tạo Liên hệ thất bại: ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Contact::findOrFail($id);

        $data->delete();

        return redirect()->route('admin.contact.index')->with('success', 'Liên hệ đã được xóa.');
    }
}
