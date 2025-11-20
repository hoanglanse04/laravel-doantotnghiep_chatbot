<?php

namespace Modules\User\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Vui lòng nhập họ và tên.',
            'name.string'       => 'Tên không hợp lệ.',
            'name.max'          => 'Tên không được vượt quá 255 ký tự.',

            'email.required'    => 'Vui lòng nhập email.',
            'email.email'       => 'Email không đúng định dạng.',
            'email.unique'      => 'Email đã được sử dụng.',

            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.string'   => 'Mật khẩu không hợp lệ.',
            'password.min'      => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed'=> 'Mật khẩu xác nhận không khớp.',
        ];
    }

}
