<?php

/**
 * Root
 */
Route::get('/', 'ThreadsController@index');

/**
 * Auth
 */
Auth::routes();
Route::get('/register/confirm', 'Auth\RegisterConfirmationController@index')->name('register.confirm');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Threads
 */
Route::get('/threads', 'ThreadsController@index')->name('threads');
Route::get('/threads/create', 'ThreadsController@create');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy');
Route::post('/threads', 'ThreadsController@store')->middleware('must-be-confirmed');
Route::get('/threads/{channel}', 'ThreadsController@index');

/**
 * Thread subscriptions
 */
Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')
    ->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')
    ->middleware('auth');

/**
 * Replies
 */
Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
Route::patch('/replies/{reply}', 'RepliesController@update');
Route::delete('/replies/{reply}', 'RepliesController@destroy');

Route::post('/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');

/**
 * Favorites
 */
Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

/**
 * Profiles
 */
Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');
Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');

Route::get('/api/users', 'Api\UsersController@index');
Route::post('/api/users/{user}/avatar', 'Api\UserAvatarController@store')->name('avatar');
