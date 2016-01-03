<?php 
namespace App\Http\Controllers;
use App\Job;
class DetailsController extends Controller
{

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	*/
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Display a job details.
	 *
	 * @return details job page
	 */

	public function Details($slug)
	{
		$job=Job::where('slug', '=', $slug)->first();
		$related_job=Job::whereRaw('user_id = ? and id != ?',[$job->user->id,$job->id])->get();
		//dd($related_job);
		return view('ui.detail.detail', compact('job','related_job'));

	}

}



?>