<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings']
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
    // 文章详情
    $api->get('articles/{article}', 'ArticlesController@show')
        ->name('api.articles.show');
    // 某个用户的文章列表
    $api->get('users/{user}/articles', 'ArticlesController@userIndex')
        ->name('api.users.articles.index');
    // 用户详情
    $api->get('users/{user}', 'UsersController@show')
        ->name('api.users.show');
    // 文章列表
    $api->get('articles', 'ArticlesController@index')
        ->name('api.articles.index');

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
        // 发布文章上传图片
        $api->post('uploads/article_images', 'UploadsController@articleImages')
            ->name('api.uploads.article_images');

        // 发布文章
        $api->post('articles', 'ArticlesController@store')
            ->name('api.articles.store');
        // 编辑文章
        $api->patch('articles/{article}', 'ArticlesController@update')
            ->name('api.articles.update');
        // 删除文章
        $api->delete('articles/{article}', 'ArticlesController@destroy')
            ->name('api.articles.destroy');
        // 文章点赞
        $api->post('articles/{article}/votes', 'VotesController@store')
            ->name('api.articles.votes.store');
        // 取消点赞
        $api->delete('articles/{article}/votes', 'VotesController@destroy')
            ->name('api.articles.votes.destroy');
        // 发布评论
        $api->post('articles/{article}/comments', 'CommentsController@store')
            ->name('api.articles.comments.store');
        // 删除评论
        $api->delete('articles/{article}/comments/{comment}', 'CommentsController@destroy')
            ->name('api.articles.comments.destroy');

    });
});