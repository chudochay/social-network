<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')
    ->name('home')
    ->middleware('verified');
/**
 * Search
 */

Route::get('/search', 'SearchController@index')
    ->name('search.index');
/**
 * User profile
 */
Route::get('/profile/{id}{username}', 'ProfileController@show')
    ->name('profile.show');

Route::put('/profile/{id}{username}', 'ProfileController@update')
    ->name('profile.update')->middleware('auth');

Route::get('/profile/{id}{username}/edit', 'ProfileController@edit')
    ->name('profile.edit')->middleware('auth');
/**
 * Friends
 */
Route::get('/friends/{id}{username}', 'FriendController@index')
    ->name('friends.index')
    ->middleware('auth');

Route::get('/friends/add/{username}', 'FriendController@create')
    ->name('friend.create')
    ->middleware('auth');

Route::get('/friends/accept/{username}', 'FriendController@edit')
    ->name('friend.edit')
    ->middleware('auth');

Route::post('/friends/delete/{username}', 'FriendController@delete')
    ->name('friend.delete')
    ->middleware('auth');
/**
 * Posts
 */
Route::post('/post', 'PostController@create')
    ->name('post.create')
    ->middleware('auth');

Route::post('/post/{postId}/comment', 'PostController@comment')
    ->name('post.comment')
    ->middleware('auth');

Route::get('/post/{postId}/like', 'PostController@like')
    ->name('post.like')
    ->middleware('auth');
/**
 * Gallery
 */
Route::post('/gallery', 'GalleryController@create')
    ->name('gallery.create')
    ->middleware('auth');

Route::get('/gallery/{id}{username}', 'GalleryController@index')
    ->name('gallery.index')
    ->middleware('auth');

Route::get('/gallery/{gallery_id}', 'GalleryController@show')
    ->name('gallery.show')
    ->middleware('auth');
Route::delete('/gallery/{gallery_id}', 'GalleryController@destroy')
    ->middleware('auth')
    ->name('gallery.destroy');
/**
 * Images
 */
Route::post('/gallery/{gallery}', 'ImageController@store')
    ->middleware('auth')
    ->name('gallery.store');
Route::delete('/gallery/{gallery_id}/{image}', 'ImageController@destroy')
    ->middleware('auth')
    ->name('image.destroy');

