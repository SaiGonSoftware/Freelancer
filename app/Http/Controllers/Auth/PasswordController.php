<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\User;
use Hash;
use Input;
use Flash;
use Request;
use Mail;
class PasswordController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

	use ResetsPasswords;

	/**
	 * Create a new password controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
	 * @return void
	 */
	public function __construct(Guard $auth, PasswordBroker $passwords)
	{
		$this->auth = $auth;
		$this->passwords = $passwords;
		$this->middleware('guest');
	}
	/**
	 * Update new password
	 * @param  
	 */
	public function newPass(Request $request)
	{
		$password=Input::get('newpassword');
		User::where('id','=', \Auth::user()->id)->update(['password' => \Hash::make($password)]);
		return response()->json(array('mess'=>'Cập nhật mật khẩu thành công'));
	}

	/**
	 * Send confirm email to reset pass
	 */
	public function resetPass()
	{
		$emailForgot=Input::get('emailForgot');
		$user= User::where('email', '=' , $emailForgot)->first();
		$user->remember_token;
		$data=['username'=>$user -> username,'email'=>$user -> email,'token'=>$user -> remember_token];
		Mail::send('ui.mail.reset',$data, function ($m) use ($user) {
            $m->from('ngohungphuc95@gmail.com', 'Reset mật khẩu');
			$m->to($user->email, $user->full_name)->subject('Email reset mật khẩu');
        });
        return response()->json(array('mess'=>'Vui lòng kiểm tra email để kích hoạt'));
	}

	/**
	 * [newLostPass use to update password]
	 * @param  [type] $token [compare token with the source and update pass]
	 * @return response
	 */
	public function newLostPass()
	{
		$token=explode('/',Input::get('url'));
		$newPass=Input::get('newpassword');
		User::where('username','=', $token[2])->update(['password' => \Hash::make($newPass)]);
		return response()->json(array('mess'=>'Cập nhật mật khẩu thành công'));
	}

}
