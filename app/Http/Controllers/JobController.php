<?php 
namespace App\Http\Controllers;
use App\Job;

class JobController extends Controller
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
	 * Display a listing of the resource.
	 *
	 * @return find job page 
	 */

	public function FindJob()
	{
		$data['job_pagi']= Job::orderBy('post_at', 'desc')->paginate(4);
		return view('ui.findjob.job',$data);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return find job page with paging
	 */

	public function FindJobAjax()
	{
		$job_pagi=Job::orderBy('post_at', 'desc')->paginate(4);
		return view('ui.findjob.pagi',compact('job_pagi'));
	}
}



?>