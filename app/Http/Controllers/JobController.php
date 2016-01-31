<?php 
namespace App\Http\Controllers;

use Auth;
use App\Job;
use App\Tags;
use App\TagContent;
use Illuminate\Http\Request;
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

	public function remove($str){
		$str=strtolower($str);
		$str=str_replace(' ','-',$str);
		$unicode = array(

			'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

			'd'=>'đ',

			'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

			'i'=>'í|ì|ỉ|ĩ|ị',

			'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

			'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

			'y'=>'ý|ỳ|ỷ|ỹ|ỵ',

			'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

			'D'=>'Đ',

			'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

			'I'=>'Í|Ì|Ỉ|Ĩ|Ị',

			'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

			'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

			'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
			);

		foreach($unicode as $nonUnicode=>$uni){
			$str = preg_replace("/($uni)/i", $nonUnicode, $str);
		}
		return $str;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return find job page 
	 */

	public function FindJob()
	{
		$data['title']="Tìm việc freelancer";
		$data['description']="Cộng đồng freelancer Việt-Tìm việc freelancer";
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

	/**
	 * [postJob post the job]
	 * insert into job and content_tag
	 */
	public function postJob(Request $request)
	{
		$job=new Job();
		$job->title=$request -> title;
		$job->slug=$this->remove($request -> title);
		$job->content=$request -> job_description;
		$job->post_at=date('Y-m-d');
		$job->day_open=$request -> day_open;
		$job->active=0;
		$job->allowance_min=$request -> min_allowance;
		$job->allowance_max=$request -> max_allowance;
		$job->location=$request -> location;
		$job->user_id=Auth::user()-> id;
		$job->save();
		$jobID=$job->id;
		$content_tag=new TagContent();
		$content_tag-> job_id=$jobID;
		$content_tag-> tag_content= $request->value;
		$content_tag-> save();
		return response()->json(array('mess'=>'Đăng công việc thành công'));
	}
}



?>