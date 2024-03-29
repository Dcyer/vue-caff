<?php

namespace App\Http\Requests\Api;

class AuthorizationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|string|email',
            'password' => 'required|string|min:6',
        ];
    }
}
