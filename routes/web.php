<?php

Route::get('/{path?}', function () {
    return view('app');
})->where('path', '.+');