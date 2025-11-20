<?php

namespace Modules\Admin\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có quyền gửi request này không.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Quy tắc validation cho request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                Rule::unique('products', 'slug')->ignore($this->product),
            ],
            'sku' => 'nullable|string|max:100',
            'discount_price' => 'nullable|numeric|min:0',
            'multiple_image' => 'nullable|array',
            'multiple_image.*' => 'string',
            'content' => 'nullable|string',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ];
    }

    /**
     * Thông báo lỗi tùy chỉnh.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.unique' => 'Slug đã tồn tại, vui lòng chọn slug khác.',
            'discount_price.numeric' => 'Giá giảm phải là số.',
            'multiple_image.array' => 'Danh sách ảnh không hợp lệ.',
            'multiple_image.*.string' => 'Mỗi ảnh phải là đường dẫn hợp lệ.',
        ];
    }
}
