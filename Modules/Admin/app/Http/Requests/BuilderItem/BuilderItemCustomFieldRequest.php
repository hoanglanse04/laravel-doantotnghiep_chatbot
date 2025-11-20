<?php

namespace Modules\Admin\Http\Requests\BuilderItem;

use Illuminate\Foundation\Http\FormRequest;

class BuilderItemCustomFieldRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'menu_item_id' => 'required|exists:menu_items,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:textarea,code',
        ];
    }

    public function messages(): array
    {
        return [
            'menu_item_id.required' => 'Thiếu ID menu item.',
            'name.required' => 'Vui lòng nhập tên trường.',
            'type.required' => 'Vui lòng chọn loại trường.',
        ];
    }
}
