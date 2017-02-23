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
   'uses'   => 'PostController@index',
    'as'    => 'user.show'
]);

Route::get('post/{user}/{uuid}', [
    'uses'   => 'PostController@show',
    'as'    => 'post.show'
]);

Route::get('tag/{tag}', [
    'uses'  => 'TagController@index',
    'as'    => 'tag.index'
]);

Route::get('place/{id}', [
    'uses'  => 'PlaceController@index',
    'as'    => 'place.index'
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

    Route::get('post/{user}/{uuid}/edit', [
        'uses'   => 'PostController@edit',
        'as'    => 'post.edit'
    ]);

    Route::post('post/{user}/{uuid}/edit', [
        'uses'   => 'PostController@update',
        'as'    => 'post.edit'
    ]);

    Route::post('image/create', [
       'uses'   => 'ImageController@store',
        'as'    => 'image.create'
    ]);

    Route::group(['namespace' => 'Users', 'prefix' => 'user'], function () {
        Route::get('/', [
            'uses'  => 'UserController@edit',
            'as'    => 'user.edit'
        ]);

        Route::post('/', [
            'uses'  => 'UserController@update',
            'as'    => 'user.edit'
        ]);

        Route::get('password', [
            'uses'  => 'PasswordController@edit',
            'as'    => 'user.password'
        ]);

        Route::post('password', [
            'uses'  => 'PasswordController@update',
            'as'    => 'user.password'
        ]);



        Route::get('avatar', [
            'uses'  => 'ImageController@edit',
            'as'    => 'user.avatar'
        ]);

        Route::post('avatar', [
            'uses'  => 'ImageController@update',
            'as'    => 'user.avatar'
        ]);

    });

    Route::group(['namespace' => 'Communities', 'prefix' => 'community'], function () {
        Route::get('publishing', [
            'uses'  => 'PublishingController@edit',
            'as'    => 'community.publishing.edit'
        ]);

        Route::post('publishing', [
            'uses'  => 'PublishingController@update',
            'as'    => 'community.publishing.edit'
        ]);

        Route::delete('publishing/token', [
            'uses'  => 'PublishingController@delete',
            'as'    => 'community.publishing.delete'
        ]);

        Route::get('redirect', [
            'uses'  => 'PublishingController@redirect',
            'as'    => 'community.redirect'
        ]);

        Route::get('callback', [
            'uses'  => 'PublishingController@callback',
            'as'    => 'community.callback'
        ]);



        Route::get('syndication', [
            'uses'  => 'SyndicationController@edit',
            'as'    => 'community.syndication.edit'
        ]);
    });

});

/*
 * Wildcards
 */
Route::get('image/{path}', [
    'uses' => 'ImageController@show',
    'as'   => 'image.src'
])->where('path', '.*');