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

    Route::get('/users/search', 'UserController@search');
    Route::get('/home', 'HomeController@index');
    Route::get('/words/search', ['as' => 'words.search', 'uses' => 'WordController@search']);
    Route::get('/users', ['as' => 'users.index', 'uses' => 'UserController@index']);
    Route::get('/users/create', ['as' => 'users.create', 'uses' => 'UserController@create']);
    Route::post('/users', ['as' => 'users.store', 'uses' => 'UserController@store']);
    Route::get('/users/{user}', ['as' => 'users.show', 'uses' => 'UserController@show']);
    Route::get('/users/{user}/edit', ['as' => 'users.edit', 'uses' => 'UserController@edit']);
    Route::patch('/users/{user}', ['as' => 'users.update', 'uses' => 'UserController@update']);
    Route::delete('/users/{user}', ['as' => 'users.destroy', 'uses' => 'UserController@destroy']);
    Route::patch('/users/update_password/{user}',
        [
            'as' => 'users.update_password',
            'uses' => 'UserController@updatePassword'
        ]);
    Route::resource('categories', 'CategoryController');
    Route::resource('words', 'WordController');
    Route::resource('follows', 'FollowController');
    Route::resource('lessons', 'LessonController');
    Route::resource('lesson_words', 'LessonWordController');

    Route::get('/exams', [
        'as' => 'exams',
        'uses' => 'LessonWordController@index'
    ]);

    Route::post('/exams', [
        'as' => 'exams',
        'uses' => 'LessonWordController@update'
    ]);

    Route::get('/results', 'LessonWordController@index');
    Route::get('/results/{lessonId}', 'LessonWordController@show');
});
