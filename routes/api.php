<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => 'serializer:array'
], function($api) {
    // 分类
    $api->get('categories', 'CategoriesController@index')
        ->name('api.categories.index');
    // 图片验证码
    $api->post('captchas', 'CaptchasController@store')
        ->name('api.captchas.store');
    // 用户注册
    $api->post('users', 'UsersController@store')
        ->name('api.users.store');
    // 登录
    $api->post('authorizations', 'AuthorizationsController@store')
        ->name('api.authorizations.store');
    // 刷新token
    $api->put('authorizations/current', 'AuthorizationsController@update')
        ->name('api.authorizations.update');
    // 删除token
    $api->delete('authorizations/current', 'AuthorizationsController@destroy')
        ->name('api.authorizations.destroy');

    // 需要 token 验证的接口
    $api->group(['middleware' => 'api.auth'], function($api) {

        // 当前登录用户信息
        $api->get('user', 'UsersController@me')
            ->name('api.user.show');
        // 更改登录用户密码
        $api->patch('user/password', 'UsersController@updatePassword')
            ->name('api.user.password');
        // 编辑登录用户信息
        $api->patch('user', 'UsersController@update')
            ->name('api.user.update');
        // 上传头像
        $api->post('uploads/avatar', 'UploadsController@avatar')
            ->name('api.uploads.avatar');

    });
});