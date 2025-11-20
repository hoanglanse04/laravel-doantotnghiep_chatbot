<?php

namespace Modules\Admin\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                Rule::unique('products', 'slug')->ignore($this->product),
            ],
            'content' => 'nullable|string',
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
            'title.required' => 'Tên trang đơn là bắt buộc.',
            'title.string' => 'Tên trang đơn phải là chuỗi.',
            'title.max' => 'Tên trang đơn không được vượt quá 255 ký tự.',

            'slug.required' => 'Slug là bắt buộc.',
            'slug.string' => 'Slug phải là chuỗi.',
            'slug.unique' => 'Slug đã tồn tại, vui lòng chọn slug khác.',

            'content.string' => 'Nội dung phải là chuỗi.',

            'meta_title.string' => 'Tiêu đề SEO phải là chuỗi.',
            'meta_title.max' => 'Tiêu đề SEO không được vượt quá 255 ký tự.',

            'meta_description.string' => 'Mô tả SEO phải là chuỗi.',
            'meta_description.max' => 'Mô tả SEO không được vượt quá 500 ký tự.',

            'meta_keywords.string' => 'Từ khóa SEO phải là chuỗi.',
            'meta_keywords.max' => 'Từ khóa SEO không được vượt quá 255 ký tự.',
        ];
    }

}
