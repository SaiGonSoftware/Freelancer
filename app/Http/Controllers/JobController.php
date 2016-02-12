<?php
namespace App\Http\Controllers;

use SEO;
use Auth;
use Image;
use App\Job;
use App\User;
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

    public function remove($str)
    {
        $str = strtolower($str);
        $str = str_replace(' ', '-', $str);
        $unicode = array(

            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

            'd' => 'đ',

            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

            'i' => 'í|ì|ỉ|ĩ|ị',

            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',

            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

            'D' => 'Đ',

            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',

            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            );

        foreach ($unicode as $nonUnicode => $uni) {
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
        SEO::setTitle('Tìm việc freelancer-Cộng đồng freelancer Việt');
        SEO::setDescription('Cộng đồng freelancer Việt-Tìm việc freelancer');
        SEO::opengraph()->setUrl('http://localhost:8000/tim-viec');
        $data['job_pagi'] = Job::orderBy('post_at', 'desc')->paginate(4);
        $data['tag']=Tags::all();
        return view('ui.findjob.job', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return find job page with paging
     */

    public function FindJobAjax()
    {
        $job_pagi = Job::orderBy('post_at', 'desc')->paginate(4);
        return view('ui.findjob.pagi', compact('job_pagi'));
    }

    
    public function postJobView()
    {
        SEO::setTitle('Công việc freelancer-Cộng đồng freelancer Việt');
        SEO::setDescription('Cộng đồng freelancer Việt-Công việc freelancer');
        SEO::opengraph()->setUrl('http://localhost:8000/cong-viec-freelancer');
        return view('ui.postjob.postjob');
    }

    /**
     * [postJob post the job]
     * insert into job and content_tag
     */
    public function postJob(Request $request)
    {
        $job = new Job();
        $job->title = $request->title;
        $job->slug = $this->remove($request->title);
        if(isset($_FILES['file']['name'])){
            $job->description = "images/" . Auth::user()->username . "/baiviet/" . $_FILES['file']['name'];
        }
        $job->content = $request->job_description;
        $job->post_at = date('Y-m-d');
        $job->day_open = $request->day_open;
        $job->active = 0;
        $job->allowance_min = str_replace(',', '', $request->min_allowance);
        $job->allowance_max = str_replace(',', '', $request->max_allowance);
        $job->location = $request->location;
        $job->user_id = Auth::user()->id;
        $job->save();
        if(isset($_FILES['file']['name'])){
           $this->deImage($_FILES['file']['name']);
        }
        $jobID = $job->id;
        $content_tag = new TagContent();
        $content_tag->job_id = $jobID;
        $content_tag->tag_content = $request->value;
        $content_tag->save();
        return response()->json(
            array(
                'mess' => 'Đăng công việc thành công',
                'date' => $date_format = date('d-m-Y', strtotime(date('Y-m-d'))),
                'title' => $this->remove($request->title)
                )
            );
    }

    /**
     * [deImage upload img description for that post]
     * @param  [type] $name [name of the imgae]
     * @return [type]       [description]
     */
    public function deImage($name)
    {
        $user = new User();
        $userDetail = User::where('username', '=', Auth::user()->username)->first();
        $temp = $_FILES['file']['tmp_name'];
        $image = $_FILES['file']['name'];
        $ext = pathinfo($image, PATHINFO_EXTENSION);

        if (!is_dir("images/" . Auth::user()->username . "/baiviet")) {
            mkdir("images/" . Auth::user()->username . "/baiviet", 0777);
        }
        $img = Image::make($temp);
        $src = "images/" . Auth::user()->username . "/baiviet/$name.$ext";

        $img->save($src);
        $job = new Job();
        $job->description = $src;
        return $src;
    }

    /**
     * [findByTag find job by tag]
     * @param  [type] $tag [tag name]
     * @return [type]      [description]
     */
    public function findByTag($tag)
    {
        SEO::setTitle('Công việc '.$tag.'-Cộng đồng freelancer Việt');
        SEO::setDescription('Cộng đồng freelancer Việt-Tìm việc php');
        SEO::opengraph()->setUrl('http://localhost:8000/cong-viec/'.$tag);
        $data['tag_cotent']=TagContent::where('tag_content','like',"%{$tag}%")
        ->join('jobs', 'content_tag.job_id', '=', 'jobs.id')
        ->join('users', 'jobs.user_id', '=', 'users.id')
        ->select('users.*', 'jobs.*')
        ->paginate(2);
        foreach ($data['tag_cotent'] as  $value) {
            $data['check']=$value->title;
        }    
        $data['tag']=Tags::all();
        return view('ui.findjob.jobtag',$data);
    }

    /**
     * [findTagAjax ajax paging for search by tag page]
     * @param  [type] $name [tag name]
     * @return [type]       [description]
     */
    public function findTagAjax($name)
    {
        $data['tag_cotent']=TagContent::where('tag_content','like',"%{$name}%")
        ->join('jobs', 'content_tag.job_id', '=', 'jobs.id')
        ->join('users', 'jobs.user_id', '=', 'users.id')
        ->select('users.*', 'jobs.*')
        ->paginate(2);
        return view('ui.findjob.tagajax',$data);
    }
}


?>