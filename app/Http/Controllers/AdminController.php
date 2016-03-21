<?php

namespace App\Http\Controllers;

use App\Tracker;
use Auth;
use Input;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
class AdminController extends Controller
{
    /**
     * Show login page
     *
     * @return \Illuminate\Http\Response
     */
    public function loginPage()
    {
        return view('admin.login');
    }
    
    /**
     * @return index view for admin
     */
    public function index()
    {
        if(Auth::user()->level!=1){
            return redirect()->action('AdminController@loginPage');
        }
        return view('admin.content');
    }

    /**
     * get page hit data to display chart
     */
    public function getPageHitData()
    {
        $chart_data=Tracker::groupBy('visit_date')->sum('hits');
        $date=Tracker::groupBy('visit_date')->get();
        foreach ($date as $date_hit){
            $date_hit['visit_date'];
        }
        return response()->json(array(
            'chart_data'=>$chart_data,
            'date'=>$date_hit['visit_date']
        ));
    }
}
