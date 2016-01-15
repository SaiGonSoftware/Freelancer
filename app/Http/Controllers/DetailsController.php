<?php 
namespace App\Http\Controllers;
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
	 * Insert comment using ajax
	 * @return related comment using ajax use input type hidden
	 */

	/*public function newComment($user_id, $introduce, $completed_day, $allowance, $job_id)
	{
		$comment=new Comment();
		$comment->user_id=$user_id;
		$comment->introduce=$introduce;
		$comment->completed_day=$completed_day;
		$comment->allowance=$allowance;
		$comment->job_id=$job_id;
		$comment->save();
		return true;
	}*/
	public function newComment(Request $request)
	{
		$slug=$request->slug;
		$date_format = date('Y-m-d', strtotime($request->date));
		$comment=new Comment();
		$comment->user_id=$request->user_id;
		$comment->introduce=$request->introduce;
		$comment->completed_day=$request->completed_day;
		$comment->allowance=$request->allowance;
		$comment->job_id=$request->job_id;
		$comment->save();
		echo "<script>alert('Thêm báo giá thành công')</script>";
		return redirect()->intended("/chi-tiet-cong-viec/".$slug."/".$date_format);
	}
}
?>