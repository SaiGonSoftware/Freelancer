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
        if(Auth::check()){
            if (Auth::user()->level == 1) {
                return redirect()->action('AdminController@index');
            }
        }
        return view('admin.login');
    }

    /**
     * @return index view for admin
     */
    public function index()
    {
        if(Auth::guest()){
            return redirect()->action('AdminController@loginPage');
        }
        if (Auth::user()->level != 1) {
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
    public function logOut(){
        $this->auth->logout();
        return redirect()->action('AdminController@loginPage');
    }
}
