<?php

use App\User;
use Illuminate\Support\Facades\Auth;
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

// Auth::routes(['verify' => true]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Facebook Login
Route::get('/redirect/{provider}', 'SocialController@redirect');
Route::get('/callback/{provider}', 'SocialController@callback');

// Route::get('/', 'ArticleController@index');


Route::post('/like', 'LikeController@like')->name('likes');
Route::post('/dislike', 'LikeController@dislike')->name('dislikes');

Route::post('/like-comment', 'LikeController@likeComment')->name('likes-comment');
Route::post('/dislike-comment', 'LikeController@dislikeComment')->name('dislikes-comment');

Route::get('/search', 'SearchController@search')->name('search');

Route::resource('/comments', 'CommentController');

Route::get('/timeline/{user}/articles', 'UserController@index')->name('articles.timeline');

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'ArticleController@index');

    Route::resource('/articles', 'ArticleController');

    Route::get('/profiles/{user}', 'UserController@profile')->name('users.profile');

    Route::get('/profiles/{user}/edit', 'UserController@edit')->name('users.profile-edit');
    Route::put('/profiles/{user}', 'UserController@update')->name('users.profile-update');

    Route::post('/replies', 'ReplyController@create')->name('replies.create');
});

Route::get('/photo/migrate/{password}', function ($password) {
    if (auth()->attempt(['email' => "bobo@gmail.com", 'password' => $password])) {
        return abort('403');
    }

    $photo = "users/M5e7QUEWUSwQuqjugKdjannF0lGqEv6WzROuZbCe.png";

    $users = User::all();

    foreach ($users as $user) {
        $user->photo = $photo;
        $user->save();
    }
});
