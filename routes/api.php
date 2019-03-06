<?php

Route::group(['middleware' => ['api']], function(){
    Route::post('/auth/signup', 'AuthController@signup');
    Route::post('/auth/signin', 'AuthController@signin');
    //Post
    Route::get('/daftar-post' , 'PostController@index');
    Route::get('/post/{id}' , 'PostController@show');

    Route::group(['middleware' => ['jwt.auth']], function(){
    	Route::get('/profile', 'UserController@show');

    	Route::post('/post/create' , 'PostController@store');
    	Route::put('/post/edit/{id}' , 'PostController@update');
    	Route::delete('/delete/post/{id}', 'PostController@destroy');
    });
});
