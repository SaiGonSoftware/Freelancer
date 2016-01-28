<?php 
namespace App\Http\Controllers;
use Auth;
use Flash;
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

	public function details($slug,$date)
	{
		$date_format = date('Y-m-d', strtotime($date));
		$job=Job::whereRaw('slug = ? and post_at = ? ', [$slug,$date_format])->first();
		$title="Công việc-".$job -> title;
		$description="Tìm việc freelancer-".$job ->title;
		$related_job=Job::whereRaw('user_id = ? and id != ?',[$job->user->id,$job->id])->get();
		$job_comment=Comment::where('job_id', '=', $job->id)->paginate(2);
		return view('ui.detail.detail', compact('job','related_job','job_comment','title','description'));
	}

	/**
	 * Display related comment using ajax
	 * @return related comment using ajax
	 */

	public function findCommentAjax($slug,$date)
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
		try{
			$date_format = date('Y-m-d');
			$comment=new Comment();
			$comment->user_id=Auth::user()->id;
			$comment->introduce=$request->introduce;
			$comment->completed_day=$request->completed_day;
			$comment->allowance=str_replace( ',', '', $request->allowance);
			$comment->post_at=$date_format;
			$comment->job_id=$request->job_id;
			$comment->save();
			return response()->json(array('mess'=>'Gửi báo giá thành công'));
			
		}
		catch(Exception $ex){
			return response()->json(array('err'=>'Có lỗi vui lòng thử lại sau'));
		}

	}
}
?>