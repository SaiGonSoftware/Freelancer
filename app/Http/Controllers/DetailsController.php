<?php 
namespace App\Http\Controllers;
use Auth;
use App\Job;
use App\Comment;
use Illuminate\Http\Request;
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

	/**
	 * Display related comment using ajax
	 * @return related comment using ajax
	 */

	public function FindCommentAjax($slug,$date)
	{
		$date_format = date('Y-m-d', strtotime($date));
		$job=Job::whereRaw('slug = ? and post_at = ? ', [$slug,$date_format])->first();
		$job_comment=Comment::where('job_id', '=', $job->id)->paginate(2);
		return view('ui.detail.pagi',compact('job_comment'));
	}

	/**
	 * Insert comment
	 * @return related comment 
	 */

	public function newComment(Request $request)
	{
		/*$slug=$request->slug;
		$date_format = date('Y-m-d', strtotime($request->date));*/
		$comment=new Comment();
		$comment->user_id=Auth::user()->id;
		$comment->introduce=$request->introduce;
		$comment->completed_day=$request->completed_day;
		$comment->allowance=$request->allowance;
		$comment->job_id=$request->job_id;
		if($comment->save()){
			return "true";
		}
		else return "false";
		/*return redirect()->intended("/chi-tiet-cong-viec/".$slug."/".$date_format);*/
	}
}
?>