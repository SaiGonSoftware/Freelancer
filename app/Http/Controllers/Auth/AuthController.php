<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;

use Hash;
use Mail;
use Input;
use Auth;
use Socialite;
use App\User;
use App\TagContent;
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
	
	/**
     * Call to facebook provider
     *
     * @return Response
     */
	public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }
 
    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (Exception $e) {
            return redirect('auth/facebook');
        }

        $authUser = $this->findOrCreateUser($user);
 	
        Auth::login($authUser, true);
 
        return redirect()->intended('/');
    }
 
    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $facebookUser
     * @return User
     */
    private function findOrCreateUser($facebookUser)
    {
        $authUser = User::where('social_id', $facebookUser->id)->first();
 		
        if ($authUser){
            return $authUser;
        }
 		$username=TagContent::remove($facebookUser->name);
        return User::create([
            'username' => $username,
            'full_name' => $facebookUser->name,
            'email' => $facebookUser->email,
            'social_id' => $facebookUser->id,
            'avatar' => $facebookUser->avatar,
            'remember_token' => $facebookUser->token,
            'level'=>1,
            'total_post'=>0
        ]);
    }
   
	/**
	 * Login validate approriate user. 
	 * @return void
	 */
	public function login()
	{
		$auth = array(
			'username' => Input::get('usernameLogin'),
			'password' => Input::get('passwordLogin'),
			'active' =>1
		);
		if ($this-> auth -> attempt($auth)) {
			return "ok";
		}
		else {
			return "fail";
		}
	}

	/**
	 * Logout user. 
	 * @return index page
	 */
	public function logout()
	{
		$this->auth->logout();
		return redirect()->intended('/');
	}

	/**
	 * Register new user and send confirm email still to fix href in view
	 * @return index page
	*/
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
		echo "<script>alert('Vui lòng kiểm tra email để kích hoạt')</script>";
        return redirect()->intended('/');
	}


	/**
	 * Active account then user can login to website
	*/
	public function reactive($token)
	{
		User::where('remember_token', '=' , $token)->update(['active'=>1]);
		echo "<script>alert('Kích hoạt tài khoản thành công bạn có thể đăng nhập ')</script>";
		return redirect()->intended('/');
	}


}	

