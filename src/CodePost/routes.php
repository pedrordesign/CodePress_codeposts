<?php

Route::group([
    'prefix' => 'admin/posts',
    'as' => 'admin.posts.',
    'namespace'=>'CodePress\CodePost\Controllers',
    'middleware' => ['web']
],
    function(){

        Route::get('', [ 'uses' => 'AdminPostController@index', 'as' => 'index']);
        Route::get('/create', [ 'uses' => 'AdminPostController@create', 'as' => 'create']);
        Route::get('/edit', [ 'uses' => 'AdminPostController@create', 'as' => 'edit']);
        Route::post('/store', [ 'uses' => 'AdminPostController@store', 'as' => 'store']);

    });