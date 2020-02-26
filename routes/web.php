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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('home');
//});

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('home')->middleware('verified');
/**
 * Search
 */

Route::get('/search', 'SearchController@getResults')->name('search.results');
/**
 * User profile
 */
Route::get('/profile/{id}{username}', 'ProfileController@getProfile')
    ->name('profile.index');

Route::put('/profile/{id}{username}', 'ProfileController@update')
    ->name('profile.update')->middleware('auth');

Route::get('/profile/{id}{username}/edit', 'ProfileController@edit')
    ->name('profile.edit')->middleware('auth');
/**
 * Friends
 */
Route::get('/friends', 'FriendController@getIndex')
    ->name('friend.index')
    ->middleware('auth');

Route::get('/friends/add/{username}', 'FriendController@getAdd')
    ->name('friend.add')
    ->middleware('auth');

Route::get('/friends/accept/{username}', 'FriendController@getAccept')
    ->name('friend.accept')
    ->middleware('auth');

Route::post('/friends/delete/{username}', 'FriendController@postDelete')
    ->name('friend.delete')
    ->middleware('auth');
/**
 * Posts
 */
Route::post('/post', 'PostController@createPost')
    ->name('post.create')
    ->middleware('auth');

Route::post('/post/{postId}/reply', 'PostController@createReply')
    ->name('post.reply')
    ->middleware('auth');

Route::get('/post/{postId}/like', 'PostController@getLike')
    ->name('post.like')
    ->middleware('auth');
/**
 * Gallery
 */
Route::get('/gallery', 'GalleryController@getIndex')
    ->name('gallery.index')
    ->middleware('auth');

Route::post('/gallery', 'GalleryController@createGallery')
    ->name('gallery.create')
    ->middleware('auth');
