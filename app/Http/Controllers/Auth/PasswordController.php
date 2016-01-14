<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\User;
use Hash;
use Input;
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

	public function newPass($name)
	{
		$userDetail=new User();
		$newPass=Input::get('password');
		$userDetail->password=$newPass;
		$userDetail->update(['password' => Hash::make($newPass)]);
		echo "<script>alert('Cập nhật mật khẩu thành công')</script>";
		return redirect()->intended('/tai-khoan/thong-tin-ca-nhan/'.$name);
	}
}
