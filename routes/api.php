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
});