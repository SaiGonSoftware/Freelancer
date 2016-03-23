<?php

namespace App\Http\Controllers;

use Auth;
use Input;
use App\Http\Requests;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
            if (Auth::user()->level == 1) {
                return redirect()->action('AdminController@index');
            }
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
        if (Auth::guest() || Auth::user()->level != 1) {
            return redirect()->action('AdminController@loginPage');
        }
        return view('admin.content');
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
     * Logout for admin
     */
    public function logOut()
    {
        $this->auth->logout();
        return redirect()->action('AdminController@loginPage');
    }
}
