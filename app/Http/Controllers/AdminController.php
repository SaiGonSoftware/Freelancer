<?php

namespace App\Http\Controllers;

use App\Tracker;
use Auth;
use Illuminate\Support\Facades\DB;
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
            ->select('visit_date', DB::raw('count(id) as count_hits'))
            ->groupBy('visit_date')
            ->lists('count_hits', 'visit_date');
        return response()->json(array(
            'keys' => array_keys($results),
            'values' => array_values($results)
        ));
    }
}
