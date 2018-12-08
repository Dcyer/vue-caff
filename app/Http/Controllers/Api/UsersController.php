<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $captchas = \Cache::get($request->captcha_key);

        if (!$captchas) {
            return $this->response->error('验证码已失效', 422);
        }

        \Cache::forget($request->captcha_key);

        if (!hash_equals($captchas['code'], $request->captcha_code)) {
            return $this->response->errorUnauthorized('验证码错误');
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'avatar'   => "https://api.adorable.io/avatars/200/$request->name.png",
        ]);

        return $this->response->item($user, new UserTransformer())
            ->setMeta([
                'access_token' => \Auth::guard('api')->fromUser($user),
                'token_type'   => 'Bearer',
                'expires_in'   => \Auth::guard('api')->factory()->getTTL() * 60,
            ])
            ->setStatusCode(201);
    }

    public function me()
    {
        return $this->response->item($this->user(), new UserTransformer());
    }

    public function show(User $user)
    {
        return $this->response->item($user, new UserTransformer());
    }

    public function update(UserRequest $request)
    {
        $user = $this->user();
        $this->authorize('update', $user);
        $attributes = $request->only(['name', 'introduction']);
        $user->update($attributes);

        return $this->response->item($user, new UserTransformer());
    }

    public function updatePassword(Request $request)
    {
        $user = $this->user();
        $this->authorize('update', $user);
        $password = bcrypt($request->password);
        $user->update(['password' => $password]);

        return $this->response->created();
    }

    public function activedIndex(User $user)
    {
        return $this->response->collection($user->getActiveUsers(), new UserTransformer());
    }

    public function statistics(User $user)
    {
        return $this->response->array($user->getStatistics());
    }
}
