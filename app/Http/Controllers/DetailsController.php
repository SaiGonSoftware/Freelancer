<?php
namespace App\Http\Controllers;

use Auth;
use SEO;
use App\Job;
use App\Tags;
use App\Comment;
use App\TagContent;
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

    public function details($slug, $date)
    {
        $date_format = date('Y-m-d', strtotime($date));
        $data['job'] = Job::whereRaw('slug = ? and post_at = ? ', [$slug, $date_format])->first();
        $tag_content = TagContent::where('job_id', '=', $data['job']->id)->first();
        $data['tag'] = explode(',', $tag_content->tag_content);
/*        var_dump($tag);echo "<br>";echo "<br>";
        foreach ($tag as $value) {
            $href = str_slug($value, "-");
            var_dump($href);
        }
        die;*/
        $data['slug'] = implode('-',$data['tag']);
        SEO::setTitle('Công việc: ' . $data['job']->title);
        SEO::setDescription('Cộng đồng freelancer Việt-Tìm việc freelancer ' . $data['job']->title);
        SEO::opengraph()->setUrl('http://localhost:8000/chi-tiet-cong-viec/' . $data['job']->title . '/' . $date);
        $data['related_job'] = Job::whereRaw('user_id = ? and id != ?', [$data['job']->user->id, $data['job']->id])->get();
        $data['job_comment'] = Comment::where('job_id', '=', $data['job']->id)->paginate(2);
        return view('ui.detail.detail',$data);
    }

    /**
     * Display related comment using ajax
     * @return related comment using ajax
     */

    public function findCommentAjax($slug, $date)
    {
        $date_format = date('Y-m-d', strtotime($date));
        $job = Job::whereRaw('slug = ? and post_at = ? ', [$slug, $date_format])->first();
        $job_comment = Comment::where('job_id', '=', $job->id)->paginate(2);
        return view('ui.detail.pagi', compact('job_comment'));
    }

    /**
     * Insert comment
     * @return related comment
     */

    public function newComment(Request $request)
    {
        try {
            $date_format = date('Y-m-d');
            $comment = new Comment();
            $comment->user_id = Auth::user()->id;
            $comment->introduce = $request->introduce;
            $comment->completed_day = $request->completed_day;
            $comment->allowance = str_replace(',', '', $request->allowance);
            $comment->post_at = $date_format;
            $comment->job_id = $request->job_id;
            $comment->save();
            return response()->json(array('mess' => 'Gửi báo giá thành công'));

        } catch (Exception $ex) {
            return response()->json(array('err' => 'Có lỗi vui lòng thử lại sau'));
        }

    }
}

?>