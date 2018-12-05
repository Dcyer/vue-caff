<?php

namespace App\Http\Requests\Api;

class UploadRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => '文件不能为空',
        ];
    }
}
