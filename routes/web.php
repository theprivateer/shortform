<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('@{username}', [
   'uses'   => 'PostController@index'
]);

Route::get('post/{uuid}', [
    'uses'   => 'PostController@show',
    'as'    => 'post.show'
]);

Route::get('tag/{tag}', [
    'uses'  => 'TagController@index',
    'as'    => 'tag.index'
]);

Route::group(['middleware' => 'auth'], function()
{
    Route::get('home', [
        'uses'  => 'UserController@index',
        'as'    => 'home'
    ]);

    Route::post('post', [
       'uses'   => 'PostController@store',
        'as'    => 'post.create'
    ]);

    Route::delete('post', [
        'uses'   => 'PostController@delete',
        'as'    => 'post.delete'
    ]);

    Route::get('post/{uuid}/edit', [
        'uses'   => 'PostController@edit',
        'as'    => 'post.edit'
    ]);

    Route::post('post/{uuid}/edit', [
        'uses'   => 'PostController@update',
        'as'    => 'post.edit'
    ]);

    Route::post('image/create', [
       'uses'   => 'ImageController@store',
        'as'    => 'image.create'
    ]);

    Route::get('user', [
        'uses'  => 'UserController@edit',
        'as'    => 'user.edit'
    ]);

    Route::post('user', [
        'uses'  => 'UserController@update',
        'as'    => 'user.edit'
    ]);
});

/*
 * Wildcards
 */
Route::get('image/{path}', [
    'uses' => 'ImageController@show',
    'as'   => 'image.src'
])->where('path', '.*');