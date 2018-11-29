<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $captchas = \Cache::get($request->captcha_key);
        \Cache::forget($request->captcha_key);

        if (!$captchas) {
            return $this->response->error('验证码已失效', 422);
        }

        if (!hash_equals($captchas['code'], $request->captcha_code)) {
            return $this->response->errorUnauthorized('验证码错误');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'avatar' => "https://api.adorable.io/avatars/200/$request->name.png"
        ]);

        return $this->response->created();
    }
}
