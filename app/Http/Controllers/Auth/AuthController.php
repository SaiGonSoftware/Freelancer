<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Mail;
class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;
    protected $redirectPath = '/';
	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	public function login(Request $request)
	{
		$auth = array(
			'username' => $request -> usernameLogin,
			'password' => $request -> passwordLogin,
			'active' => 1
		);
		if ($this-> auth -> attempt($auth)) {
			return redirect()->intended('/trang-chu');
		}
		else{
			echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu')</script>";
		}
	}

	public function logout()
	{
		$this->auth->logout();
		return redirect()->intended('/');
	}

	public function register(Request $request)
	{
		$user= new User();
		$user-> username =$request -> usernameRegis;
		$user-> full_name =$request -> fullnameRegis;
		$user-> email =$request -> emailRegis;
		$user-> password =Hash::make($request -> passwordRegis);
		$user-> remember_token =$request -> _token;
		$user-> total_post = 0;
		$user->save();
		$data=['username'=>$request -> fullnameRegis,'email'=>$request -> emailRegis,'token'=>$request -> _token];
		Mail::send('ui.mail.register',$data, function ($m) use ($user) {
            $m->from('ngohungphuc95@gmail.com', 'Hỗ trợ Freelancer');
			$m->to($user->email, $user->full_name)->subject('Email xác nhận');
        });
        
        echo "<script>alert('Đăng ký thành công vui lòng kiểm tra email')</script>";
		return redirect()->intended('/');
	}

	public function reactive($token)
	{
		User::where('remember_token', '=' , $token)->update(['active'=>1]);
		echo "<script>alert('Kích hoạt tài khoản thành công bạn có thể đăng nhập ')</script>";
		return redirect()->intended('/');
	}
}
