<?php

/**
 * Root
 */
Route::get('/', 'ThreadsController@index');

/**
 * Auth
 */
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Threads
 */
Route::get('/threads', 'ThreadsController@index')->name('threads');
Route::get('/threads/create', 'ThreadsController@create');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy');
Route::post('/threads', 'ThreadsController@store');
Route::get('/threads/{channel}', 'ThreadsController@index');

/**
 * Replies
 */
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');

/**
 * Favorites
 */
Route::post('/replies/{reply}/favorites', 'FavoritesController@store');

/**
 * Profiles
 */
Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');
