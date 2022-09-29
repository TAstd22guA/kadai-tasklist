<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/
Route::get('/', 'TasksController@index');


Route::resource('tasks', 'TasksController');

Route::get('tasks', 'TasksController@allindex')->name('tasks.allindex');
Route::get('users', 'TasksController@allindex')->name('tasks.allindex');

Auth::routes();

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// 認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');


Route::group(['middleware' => ['auth']], function () {
    

    Route::group(['prefix' => 'users/{id}'], function () {
        
        //追加　お気に入りの設定
        Route::get('favorites', 'UsersController@favorites')->name('users.favorites');
        
    });


         // 追加　FavoritesControllerの設定
        Route::group(['prefix' => 'tasks/{id}'], function () {
        Route::post('favorite', 'FavoritesController@store')->name('favorites.favorite');
        Route::delete('unfavorite', 'FavoritesController@destroy')->name('favorites.unfavorite');
    });
    
    
    
    Route::resource('users', 'TasksController', ['only' => ['index','allindex','show']]);
    
    Route::resource('tasks', 'TasksController', ['only' => ['store', 'edit','destroy']]);

});
