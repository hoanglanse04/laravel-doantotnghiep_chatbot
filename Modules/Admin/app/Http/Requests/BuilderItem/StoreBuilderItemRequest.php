<?php

namespace Modules\Admin\Http\Requests\BuilderItem;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuilderItemRequest extends FormRequest
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
            'menu_id' => 'required|exists:menus,id',
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'required|integer|min:0',
            'target' => 'nullable|string|in:_self,_blank'
        ];
    }

    /**
     * Thông báo lỗi tùy chỉnh.
     */
    public function messages(): array
    {
        return [
            'menu_id.required' => 'Trường menu_id là bắt buộc.',
            'menu_id.exists' => 'Menu không hợp lệ, vui lòng chọn menu hợp lệ.',
            'name.required' => 'Tên menu là bắt buộc.',
            'name.string' => 'Tên menu phải là chuỗi ký tự.',
            'name.max' => 'Tên menu không được vượt quá 255 ký tự.',
            'url.string' => 'URL phải là chuỗi hợp lệ.',
            'url.max' => 'URL không được vượt quá 255 ký tự.',
            'parent_id.required' => 'Trường parent_id là bắt buộc.',
            'parent_id.integer' => 'Parent ID phải là số nguyên.',
            'parent_id.min' => 'Parent ID không thể là giá trị âm.',
            'target.string' => 'Target phải là chuỗi.',
            'target.in' => 'Giá trị target chỉ được phép là "_self" hoặc "_blank".',
        ];
    }
}
