<?php

namespace Modules\Admin\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Enums\Common;

use App\Models\Category;
use App\Models\Product;

use Modules\Admin\Http\Requests\Product\CreateProductRequest;
use Modules\Admin\Http\Requests\Product\UpdateProductRequest;

class ProductController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keywords = $request->keywords ?: null;
        $per_page = $request->per_page ?: 20;
        $status = $request->status ?: null;
        $category_id = $request->category_id ?: null;

        $data = Product::keywords($keywords)
            ->status($status)
            ->orderBy('id', 'DESC')
            ->paginate($per_page);

        return view('admin::product.index', compact(
            'data'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('type', Common::CATEGORY_PRODUCT->value)
            ->orderBy('id', 'desc')
            ->pluck('name', 'id')
            ->toArray();

        return view('admin::product.create-edit', compact(
            'categories'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        try {
            // Xóa dấu "." trong số tiền và chuyển về số nguyên
            $price = (int) str_replace(['.', 'đ', ' '], '', $request->price);
            $discount_percentage = (int) str_replace(['%', ' '], '', $request->discount_percentage);

            // Tính toán giá sau giảm
            $discount_price = ($price * $discount_percentage) / 100;
            $final_price = $price - $discount_price;


            // Lấy multiple_image và ảnh đầu tiên
            $multipleImage = $request->multiple_image ?? [];
            $firstImage = is_array($multipleImage) && count($multipleImage) > 0 ? $multipleImage[0] : null;

            $specifications = array_values(array_filter($request->specifications ?? [], function ($item) {
                return !empty($item['label']) || !empty($item['value']);
            }));

            // Tạo sản phẩm mới
            $data = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-'),
                'sku' => $request->sku ?? Str::random(8),
                'category_id' => $request->category_id,
                'price' => $price,
                'discount_percentage' => $discount_percentage,
                'discount_price' => (int) $discount_price,
                'final_price' => (int) $final_price,
                'status' => $request->status,
                'multiple_image' => $multipleImage,
                'image' => $firstImage,
                'content' => $request->content,
                'details' => $request->details,
                'user_id' => Auth::guard('admin')->user()->id,
                'description' => $request->description,
                'specifications' => $specifications,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ]);

            return redirect()->route('admin.product.edit', $data->id)->with('success', 'Sản phẩm đã được tạo thành công.');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Tạo sản phẩm thất bại: ' . $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Product::findOrFail($id);

        return view('admin::product.show', compact(
            'data'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Product::findOrFail($id);
        $categories = Category::where('type', Common::CATEGORY_PRODUCT->value)
            ->orderBy('id', 'desc')
            ->pluck('name', 'id')
            ->toArray();

        return view('admin::product.create-edit', compact(
            'data',
            'categories'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $data = Product::findOrFail($id);

            // Xóa dấu "." trong số tiền và chuyển về số nguyên
            $price = (int) str_replace(['.', 'đ', ' '], '', $request->price);
            $discount_percentage = (int) str_replace(['%', ' '], '', $request->discount_percentage);

            // Tính toán giá sau giảm
            $discount_price = ($price * $discount_percentage) / 100;
            $final_price = $price - $discount_price;

            // Lấy multiple_image và ảnh đầu tiên
            $multipleImage = $request->multiple_image ?? [];
            $firstImage = is_array($multipleImage) && count($multipleImage) > 0 ? $multipleImage[0] : null;

            $specifications = array_values(array_filter($request->specifications ?? [], function ($item) {
                return !empty($item['label']) || !empty($item['value']);
            }));

            $data->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'sku' => $request->sku,
                'category_id' => $request->category_id,
                'price' => $price,
                'discount_percentage' => $discount_percentage,
                'discount_price' => (int) $discount_price,
                'final_price' => (int) $final_price,
                'status' => $request->status,
                'multiple_image' => $multipleImage,
                'image' => $firstImage,
                'content' => $request->content,
                'details' => $request->details,
                'description' => $request->description,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
                'specifications' => $specifications,
            ]);

            return redirect()->back()->with('success', 'Sản phẩm đã được cập nhật.');
        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Cập nhật sản phẩm thất bại: ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Product::findOrFail($id);

        $data->delete();

        return redirect()->route('admin.product.index')->with('success', 'Sản phẩm đã được xóa.');
    }
}
