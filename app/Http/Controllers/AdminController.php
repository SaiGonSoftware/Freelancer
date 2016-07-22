<?php

namespace App\Http\Controllers;

use Auth;
use Input;
use App\Http\Requests;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Job;
use App\User;
use App\Recruit;
use App\Tracker;
class AdminController extends Controller
{
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Show login page
     *
     * @return \Illuminate\Http\Response
     */
    public function loginPage()
    {
        if (Auth::check()) {
            return redirect()->action('AdminController@index');
        }
        return view('admin.login');
    }

    /**
     *For admin to login
     * @return string
     */
    public function adminLogin()
    {
        $username = Input::get('username');
        $password = Input::get('password');
        $captcha = Input::get('captcha');
        $rules = ['captcha' => 'required|captcha'];
        $validators = \Validator::make(Input::all(), $rules);
        if ($validators->fails()) {
            return response(['mess' => 'Captcha vừa nhập không đúng'], 500);
        } else {
            $auth = array(
                'username' => $username,
                'password' => $password,
                'level' => 1,
                'active' => 1
                );
            if ($this->auth->attempt($auth)) {
                return "ok";
            } else {
                return "fail";
            }

        }
    }

    /**
     * @return index view for admin
     */
    public function index()
    {
       $data['totalJob'] = Job::CountJobs();
       $data['totalUser'] = User::CountUser();
       $data['totalRecruitJob']= Recruit::CountRecruitment();
       $data['totalVisted']= Tracker::TotalVisted ();
       return view('admin.content',$data);
   }

    /**
     * get page hit data to display chart
     */
    public function getPageHitData()
    {
        $results = DB::table('tracker')
        ->select('visit_date', DB::raw('sum(hits) as count_hits'))
        ->groupBy('visit_date')
        ->lists('count_hits', 'visit_date');
        return response()->json(array(
            'keys' => array_keys($results),
            'values' => array_values($results)
            ));
    }

    /**
     * @return user managed view
     */
    public function getUserView(){
        $user=User::where('level','!=',1)->paginate(4);
        return view('admin.user',compact('user'));
    }

    /**
     * @return user managed view
     */
    public function getUserAjax(){
        $user=User::where('level','!=',1)->paginate(4);
        return view('admin.user_ajax',compact('user'));
    }

    /**
     * Deactive user account via ajax
     */
    public function deactiveAccount()
    {
        $id=Input::get('id');
        User::where('id','=',$id)->update(['active'=>0]);
        return response()->json(array(
           'mess'=>'Deactive tài khoản thành công'
           ));   
    }

    public function getPostView()
    {
        $post=Job::paginate(8);
        return view('admin.post',compact('post'));
    }  

    /**
     * Get job via ajax
     */
    public function getPostAjax()
    {
        $post=Job::paginate(8);
        return view('admin.post_ajax',compact('post'));
    }

    /**
     * Get job content for admin
     */
    public function getJobContent($id)
    {
        $jobContent=Job::where('id','=',$id)->get();
        return view('admin.view_post',compact('jobContent'));
    }

    /**
     * Delete post via ajax
     */
    public function deletePost()
    {
        $id=Input::get('id');
        Job::where('id','=',$id)->delete();
        return response()->json(array(
           'mess'=>'Xóa bài thành công'
           )); 
    }
    /**
     * Logout for admin
     */
    public function logOut()
    {
        $this->auth->logout();
        return redirect()->action('AdminController@loginPage');
    }
}
