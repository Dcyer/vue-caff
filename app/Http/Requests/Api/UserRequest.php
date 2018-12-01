<?php

namespace App\Http\Requests\Api;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name'         => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name',
                    'email'        => 'required|email|unique:users,email',
                    'password'     => 'required|string|min:6|confirmed',
                    'captcha_code' => 'required|string',
                    'captcha_key'  => 'required|string',
                ];
                break;
            case 'PATCH':
                $userId = \Auth::guard('api')->id();
                return [
                    'name'         => 'between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . $userId,
                    'introduction' => 'max:80',
                ];
                break;
        }
    }

    public function messages()
    {
        return [
            'name.unique'    => '用户名已被占用，请重新填写',
            'name.regex'     => '用户名只支持英文、数字、横杆和下划线。',
            'name.between'   => '用户名必须介于 3 - 25 个字符之间。',
            'name.required'  => '用户名不能为空。',
            'email.required' => '邮箱不能为空',
            'email.email'    => '邮箱格式不正确',
            'email.unique'   => '邮箱已注册',
        ];
    }
}
