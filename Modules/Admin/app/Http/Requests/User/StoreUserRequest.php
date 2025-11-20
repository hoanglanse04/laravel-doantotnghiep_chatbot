<?php

namespace Modules\Admin\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
            'gender' => 'nullable|in:male,female,other',
            'role' => 'required|string',
            'password' => 'required|string|min:6',
            'image' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được để trống.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',

            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',

            'phone.string' => 'Số điện thoại phải là chuỗi.',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',

            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',

            'gender.in' => 'Giới tính không hợp lệ.',

            'role.required' => 'Vai trò là bắt buộc.',
            'role.string' => 'Vai trò phải là chuỗi ký tự.',

            'password.required' => 'Mật khẩu không được để trống.',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',

            'image.string' => 'Ảnh đại diện phải là chuỗi đường dẫn.',

            'meta_title.string' => 'Meta title phải là chuỗi.',
            'meta_title.max' => 'Meta title không được vượt quá 255 ký tự.',

            'meta_description.string' => 'Meta description phải là chuỗi.',

            'meta_keywords.string' => 'Meta keywords phải là chuỗi.',
        ];
    }

}
