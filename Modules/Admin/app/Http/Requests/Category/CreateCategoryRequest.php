<?php

namespace Modules\Admin\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'image' => 'nullable|string',
            'content' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên chuyên mục là bắt buộc.',
            'name.string' => 'Tên chuyên mục phải là chuỗi.',
            'name.max' => 'Tên chuyên mục không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên chuyên mục đã tồn tại.',

            'slug.string' => 'Slug phải là chuỗi.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug đã tồn tại.',

            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',

            'content.string' => 'Nội dung phải là chuỗi.',
            'image.string' => 'Đường dẫn hình ảnh phải là chuỗi.',

            'meta_title.string' => 'Tiêu đề SEO phải là chuỗi.',
            'meta_title.max' => 'Tiêu đề SEO không được vượt quá 255 ký tự.',

            'meta_description.string' => 'Mô tả SEO phải là chuỗi.',
            'meta_description.max' => 'Mô tả SEO không được vượt quá 500 ký tự.',

            'meta_keywords.string' => 'Từ khóa SEO phải là chuỗi.',
            'meta_keywords.max' => 'Từ khóa SEO không được vượt quá 255 ký tự.',
        ];
    }
}
