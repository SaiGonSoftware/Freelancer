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
		$password=Input::get('password');
		User::where('id','=', \Auth::user()->id)->update(['password' => \Hash::make($password)]);
		return response()->json(array('mess'=>'Cập nhật mật khẩu thành công'));
	}

	/**
	 * Lost pass get view
	 * return lostpass view
	 */
	public function lostPass()
	{
		return view('ui.mail.lostpass');
	}

	/**
	 * Send confirm email to reset pass
	 */
	public function resetPass(Request $request)
	{
		$user= User::where('email', '=' , $request->email)->first();
		$data=['username'=>$user -> username,'email'=>$user -> email,'token'=>$user -> remember_token];
		Mail::send('ui.mail.reset',$data, function ($m) use ($user) {
            $m->from('ngohungphuc95@gmail.com', 'Reset mật khẩu');
			$m->to($user->email, $user->full_name)->subject('Email reset mật khẩu');
        });
        echo "<script>alert('Vui lòng kiểm tra email để kích hoạt')</script>";
	}

	public function activeLostPass($token)
	{
		$userDetail=new User();
		$name=Auth::user()->username;
		$newPass=Input::get('password');
		$userDetail->password=$newPass;
		$userDetail->where('remember_token',$token)->update(['password' => Hash::make($newPass)]);
		echo "<script>alert('Cập nhật mật khẩu thành công')</script>";
	}
}
