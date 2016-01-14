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
Route::get('chi-tiet-cong-viec/{slug}/{date}.html','DetailsController@Details');
Route::get('/tai-khoan/{token}', 'Auth\AuthController@reactive');
Route::get('/tai-khoan/thong-tin-ca-nhan/{name}', 'UserController@userDetail');

/* For user to logout*/
Route::get('/dang-xuat', 'Auth\AuthController@logout');

Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider');
Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');
/*Route post.For user to login*/
Route::post('authen/login','Auth\AuthController@login');
Route::post('user/register',['as' => 'register','uses'=>'Auth\AuthController@register']);
Route::post('tai-khoan/thong-tin-ca-nhan/{name}/upload', 'UserController@profileImage');
Route::post('tai-khoan/thong-tin-ca-nhan/{name}/updatePass',['as' => 'updatePass','uses'=>'Auth\PasswordController@newPass']);


Route::resource('User','UserController');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

