<?php

Route::auth();

Route::get('/', 'HomeController@index');

Route::get('/article/{hashid}','HomeController@article');

Route::get('/category/{hashid}','HomeController@category');

Route::post('/search','HomeController@search');

Route::get('/dashboard', 'HomeController@dashboard');

Route::get('/touch',function(){
    return view('touch');
});

Route::group(['prefix' => 'api', 'middleware' => 'auth', 'namespace' => 'Api'], function () {
        Route::resource('categories', 'CategoryController', ['except' => ['create', 'edit']]);
        Route::resource('tags', 'TagController', ['except' => ['create', 'edit']]);
        Route::resource('articles', 'ArticleController', ['except' => ['create', 'edit']]);

        Route::get('photos','UploadController@index');
        Route::post('upload','UploadController@uploadToCloud');
});
