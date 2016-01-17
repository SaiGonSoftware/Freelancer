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
Route::get('tim-viec', 'JobController@FindJob');
Route::get('/job/joblist','JobController@FindJobAjax');
Route::get('chi-tiet-cong-viec/{slug}/{date}','DetailsController@Details');
Route::get('/tai-khoan/{token}', 'Auth\AuthController@reactive');
Route::get('/tai-khoan/cap-nhat-mat-khau/{{$token}}', 'Auth\PasswordController@activeLostPass');
Route::get('/tai-khoan/thong-tin-ca-nhan/{name}/{token}', 'UserController@userDetail');
Route::get('/comment/{slug}/{date}','DetailsController@FindCommentAjax');
Route::get('/tai-khoan/quen-mat-khau','Auth\PasswordController@lostPass');
Route::get('/dang-xuat', 'Auth\AuthController@logout');



Route::post('user/register',['as' => 'register','uses'=>'Auth\AuthController@register']);
Route::post('tai-khoan/thong-tin-ca-nhan/{name}/upload', 'UserController@profileImage');
Route::post('tai-khoan/thong-tin-ca-nhan/{name}/updatePass',['as' => 'updatePass','uses'=>'Auth\PasswordController@newPass']);
Route::post('/comment/userReply',['as' => 'comment','uses'=>'DetailsController@newComment']);
Route::post('/password/email',['as' => 'resetPass','uses'=>'Auth\PasswordController@resetPass']);
Route::post('/password/new',['as' => 'newPass','uses'=>'Auth\PasswordController@activeLostPass']);



Route::resource('User','UserController');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
/*social*/
Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider');
Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');
Route::post('authen/login','Auth\AuthController@login');