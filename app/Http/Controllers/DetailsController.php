<?php 
namespace App\Http\Controllers;
use App\Job;
use App\Comment;
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
	 * Display a job details
	 * and related comment
	 * @return details job page
	 */

	public function Details($slug,$date)
	{
		$date_format = date('Y-m-d', strtotime($date));
		$job=Job::whereRaw('slug = ? and post_at = ? ', [$slug,$date_format])->first();
		$related_job=Job::whereRaw('user_id = ? and id != ?',[$job->user->id,$job->id])->get();
		$job_comment=Comment::where('job_id', '=', $job->id)->paginate(2);
		return view('ui.detail.detail', compact('job','related_job','job_comment'));
	}

	public function FindCommentAjax($slug,$date)
	{
		$date_format = date('Y-m-d', strtotime($date));
		$job=Job::whereRaw('slug = ? and post_at = ? ', [$slug,$date_format])->first();
		$job_comment=Comment::where('job_id', '=', $job->id)->paginate(2);
		return view('ui.detail.pagi',compact('job_comment'));
	}
}



?>