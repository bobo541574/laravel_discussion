<?php

use Illuminate\Support\Facades\Session;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'ArticleController@index');

Route::resource('/articles', 'ArticleController');

Route::post('/like', 'LikeController@like')->name('likes'); //->middleware('auth');

Route::post('/like-comment', 'LikeController@likeComment')->name('likes-comment'); //->middleware('auth');

Route::post('/dislike', 'LikeController@dislike')->name('dislikes'); //->middleware('auth');

Route::resource('/comments', 'CommentController');

Route::get('/timeline/{user}/articles', 'UserController@index')->name('articles.timeline');