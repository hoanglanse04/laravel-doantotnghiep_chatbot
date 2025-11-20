<?php

namespace Modules\Admin\Http\Requests\Builder;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuilderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:menus,name',
            'slug' => 'nullable|string|max:255|unique:menus,slug',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên menu là bắt buộc.',
            'name.unique' => 'Tên menu đã tồn tại.',
            'name.max' => 'Tên menu không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug đã tồn tại.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
        ];
    }
}
