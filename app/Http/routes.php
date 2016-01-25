<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/user/search', 'UserController@search');
    Route::get('/home', 'HomeController@index');
    Route::patch('/user/update_password/{user}',
        [
            'as' => 'user.update_password',
            'uses' => 'UserController@updatePassword'
        ]);
    Route::resource('user', 'UserController');
    Route::resource('categories', 'CategoryController');
    Route::resource('words', 'WordController');
    Route::resource('follows', 'FollowController');
    Route::resource('lessons', 'LessonController');
    Route::resource('lesson_words', 'LessonWordController');
});
