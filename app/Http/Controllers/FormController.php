<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contact;
use App\Models\Product;

class FormController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->input('keywords');
        $products = Product::query()
            ->where('name', 'like', '%' . $keyword . '%')
            ->orWhere('description', 'like', '%' . $keyword . '%')
            ->latest()
            ->paginate(12);

        return view('article.search', compact('products', 'keyword'));
    }

    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:11',
            'content' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'name.string' => 'Họ tên không hợp lệ.',
            'name.max' => 'Họ tên không được vượt quá 255 ký tự.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Định dạng email không hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',

            'phone.string' => 'Số điện thoại không hợp lệ.',
            'phone.max' => 'Số điện thoại không được vượt quá 11 ký tự.',

            'content.string' => 'Tin nhắn không hợp lệ.',
            'content.max' => 'Tin nhắn không được vượt quá 1000 ký tự.',
        ]);

        try {
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'content' => $request->input('content'),
                'status' => Contact::NEW,
                'url' => $request->url_current,
            ]);

            return redirect()->back()->with('success', 'Tin nhắn của bạn đã được gửi thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi trong quá trình gửi tin nhắn. Vui lòng thử lại sau.');
        }
    }
}
