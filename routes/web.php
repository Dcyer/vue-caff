<?php

Route::get('/', function () {
    return view('app');
});

Route::get('/categories', function () {
    return response()->json(['分类', '社区', '头条', '公告']);
});