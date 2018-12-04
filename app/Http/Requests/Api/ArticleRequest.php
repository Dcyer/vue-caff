<?php

namespace App\Http\Requests\Api;

class ArticleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => 'required|min:2',
            'category_id' => 'required|exists:categories,id',
            'body'        => 'required|min:1',
        ];
    }

    public function messages()
    {
        return [
            'title.required'       => '标题不能为空',
            'title.min'            => '标题长度不能小于2位',
            'category_id.required' => '必须选择文章类型',
            'category_id.exists'   => '文章类型不存在',
            'title.min'            => '标题长度不能小于2位',
            'body.required'        => '发布内容不能为空',
            'body.min'             => '发布内容长度不能小于1位',
        ];
    }
}
