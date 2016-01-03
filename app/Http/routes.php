<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route get*/
Route::get('/', 'IndexController@home');
Route::get('/trang-chu','IndexController@home');

Route::get('tim-viec.html', 'JobController@FindJob');
Route::get('/job/joblist','JobController@FindJobAjax');
Route::get('chi-tiet-cong-viec/{slug}.html','DetailsController@Details');

/* For user to logout*/
Route::get('/dang-xuat', 'Auth\AuthController@logout');

/*Route post.For user to login*/
Route::post('authen/login',['as' => 'login','uses'=>'Auth\AuthController@login']);
Route::post('user/register',['as' => 'register','uses'=>'Auth\AuthController@register']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

