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
Route::get('/trang-chu', 'IndexController@home');
Route::get('/tim-viec', 'JobController@FindJob');
Route::get('/danh-sach-tin-tuyen-dung', 'JobController@recruitJobList');
Route::get('/list_recruit', 'JobController@recruitJobListPagi');
Route::get('/job/joblist', 'JobController@FindJobAjax');
Route::get('/congviec/{name}', 'JobController@findTagAjax');
Route::get('/userinfo', 'UserController@userDetailAjax');
Route::get('/tai-khoan/{name}/cap-nhat-mat-khau/{token}', 'Auth\PasswordController@passwordView');
Route::get('/chi-tiet-cong-viec/{slug}/{date}', 'DetailsController@details');
Route::get('/tai-khoan/{token}', 'Auth\AuthController@reactive');
Route::get('/tai-khoan/thong-tin-ca-nhan/{name}/{token}', 'UserController@userDetail');
Route::get('/cong-viec-freelancer', 'JobController@postJobView');
Route::get('/tin-tuyen-dung', 'JobController@recruitView');
Route::get('/tin-tuyen-dung/{title}/{date}', 'JobController@recruitJobView');
Route::get('/dang-xuat', 'Auth\AuthController@logout');
Route::get('/auth/facebook', 'Auth\AuthController@redirectToProvider');
Route::get('/auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');
Route::get('/deleteComment/{id}', ['as' => 'del', 'uses' => 'UserController@deleteComment']);
Route::get('/comment/{slug}/{date}', 'DetailsController@FindCommentAjax');
Route::get('/getTags', 'JobController@getTags');
Route::get('/cong-viec/{tag}', 'JobController@findByTag');
Route::get('/cv/tao-cv', 'UserController@createCV');
Route::get('/cv/xem-cv/{name}/{id}', 'UserController@loadCV');
Route::get('/cv/sua-cv/{name}/{id}', 'UserController@viewUpdateCV');
Route::get('/cv/xoa-cv/{id}', ['as' => 'delCV', 'uses' => 'UserController@deleteCV']);
Route::get('/payment', ['as' => 'PaymentPaypal', 'uses' => 'PaymentController@store']);
Route::get('/delJobUserPost', ['as' => 'DelJobUserPost', 'uses' => 'JobController@deleteJob']);
Route::get('/delJobRecruit', ['as' => 'DelJobRecruit', 'uses' => 'JobController@deleteRecruitJob']);
Route::get('/tin-nhan/{username}', 'ChatController@index');
Route::get('/getMessage','ChatController@getMessages');

Route::group(['prefix'=>'/quan-ly'],function(){
	Route::get('',function () {
		return view('auth.login');
	});

});

Route::post('/message/newMessageDetials', ['as' => 'SaveMessageDetails', 'uses' => 'ChatController@insertMessageDetails']);
Route::post('/message/new', ['as' => 'SaveMessage', 'uses' => 'ChatController@insertMessage']);
Route::post('/job/postNewRecruit', ['as' => 'RecruitJob', 'uses' => 'JobController@recruitJob']);
Route::post('/assignCurJob', ['as' => 'AssignJob', 'uses' => 'UserController@assignJob']);
Route::post('/cv/download', ['as' => 'downloadCV', 'uses' => 'UserController@downloadPDF']);
Route::post('/cv/saveCV', ['as' => 'SaveCV', 'uses' => 'UserController@saveCV']);
Route::post('/cv/update/{id}', ['as' => 'UpdateCV', 'uses' => 'UserController@updateCV']);
Route::post('/job/postNewJob', ['as' => 'NewJob', 'uses' => 'JobController@postJob']);
Route::post('/updatePassword', ['as' => 'updatePass', 'uses' => 'Auth\PasswordController@newPass']);
Route::post('/displaycomment', 'DetailsController@findCommentAjax');
Route::post('/postComment', ['as' => 'post', 'uses' => 'DetailsController@newComment']);
Route::post('authen/login', 'Auth\AuthController@login');
Route::post('/user/register', ['as' => 'register', 'uses' => 'Auth\AuthController@register']);
Route::post('tai-khoan/thong-tin-ca-nhan/{name}/upload', 'UserController@profileImage');
Route::post('/findPassword', ['as' => 'findPass', 'uses' => 'Auth\PasswordController@resetPass']);
Route::post('/password/new', ['as' => 'newLostPass', 'uses' => 'Auth\PasswordController@newLostPass']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::any('/{page?}', function () {
	return View::make('errors.404');
})->where('page', '.*');


