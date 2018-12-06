<?php

namespace App\Http\Requests\Api;

class CommentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'excerpt' => 'required|min:2',
        ];
    }

    public function messages()
    {
        return [
            'excerpt.required' => '评论内容不能为空',
            'excerpt.min'      => '评论内容长度至少2位',
        ];
    }
}
