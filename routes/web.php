<?php

use Illuminate\Support\Facades\Route;

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

//Auth
Route::get('/', ['middleware' => 'guest', function()
{
    return view('auth/login');
}]);
Route::get('/home', function () {
    return view('home');
});
Auth::routes();

//home
Route::get('/home', 'HomeController@index')->name('home');
Route::get('home', 'PostController@index');
Route::get('404', 'HomeController@notfound');

//Route::get('home', 'PostController@edit');

//post
Route::post('comments','PostController@comment');
Route::get('like/{id}','PostController@like');
Route::get('unlike/{id}','PostController@unlike');
Route::resource('posts','PostController');
Route::delete('comment/delete{id}', 'PostController@destroycomment');

//profile
//Route::get('profile/{id}','ProfileController@show');
Route::get('{user}', 'ProfileController@show')->name('user.show');
Route::get('{user}/likes', 'ProfileController@likedposts')->name('user.show');
Route::patch('updateprofile','ProfileController@update');
Route::delete('user/delete', 'ProfileController@destroy');

//follow
Route::post('/follow/{user}', 'FollowerController@follow');
Route::delete('/unfollow/{user}', 'FollowerController@unfollow');
Route::get('{user}/following', 'FollowerController@following');
Route::get('{user}/followers', 'FollowerController@follower');

//tags
Route::get('/hashtag/{tag}', 'TagController@show');
Route::post('/followtag/{tag}', 'FollowtagController@followtag');
Route::delete('/unfollowtag/{tag}', 'FollowtagController@unfollowtag');
Route::get('{user}/usertags', 'TagController@usertags');
Route::post('/favoritetag/{tag}', 'FollowtagController@favoritetag');
Route::post('/unfavoritetag/{tag}', 'FollowtagController@unfavoritetag');

//Notification
Route::get('showNt/{id}', 'HomeController@showNt');

//Settings
Route::get('settings/account', 'ProfileController@showAccountSettings');
Route::get('settings/security', 'ProfileController@showSecuritySettings');
Route::patch('updateAccountSettings','ProfileController@updateAccountSettings');
Route::patch('updateSecuritySettings','ProfileController@updateSecuritySettings');

//Search
Route::get('search/posts', 'SearchController@findPosts');
Route::get('search/users', 'SearchController@findUsers');
Route::get('search/tags', 'SearchController@findTags');
