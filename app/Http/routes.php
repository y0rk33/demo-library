<?php

// route for only authenticated users
Route::group(['middleware' => 'auth'], function() {

    Route::get('/', function() {
        return view('welcome');
    });

    Route::get('/book_search', function() {
        return redirect('/');
    });

    /* Admin menu - operations with pending requests */
    Route::group(['namespace' => 'Admin'], function() {
        Route::get('/pending_request', 'RequestController@index');
        Route::get('/pending_request/show_all', 'RequestController@show_all');
        Route::post('/pending_request/search', 'RequestController@search');
        Route::get('/pending_request/lend/{id}', 'RequestController@lend');
        Route::get('/pending_request/cancel/{id}', 'RequestController@cancel');

        Route::get('/book_return', 'ReturnController@index');
        Route::get('/book_return/show_all', 'ReturnController@show_all');
        Route::get('/book_return/return/{id}', 'ReturnController@returned');
        Route::post('/book_return/search', 'ReturnController@search');

        Route::resource('/member', 'MemberController');
        Route::get('member_show_all', 'MemberController@show_all');
        Route::post('member_password_reset/{id}', 'MemberController@password_reset');
        Route::post('member_search', 'MemberController@search');
    });

    /* My Book Requests */
    Route::get('/book_request', 'BookRequestController@index');
    Route::post('/book_request/{id}', 'BookRequestController@request');
    Route::get('/book_request/cancel/{id}', 'BookRequestController@cancel');

    /* My Books On Loan */
    Route::get('/book_on_loan', 'BookRequestController@on_loan');

    /* Profile settings */
    Route::get('/my_profile/settings', 'UserSettingController@index');
    Route::get('/my_profile/edit', 'UserSettingController@edit');
    Route::post('/my_profile', 'UserSettingController@update');

    Route::resource('/book', 'BooksController');

    Route::post('/book_search', 'BooksController@search');
    Route::get('/book_show_all', 'BooksController@show_all');
    Route::post('/cover_update/{id}', 'BooksController@cover_update');

});


// authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');