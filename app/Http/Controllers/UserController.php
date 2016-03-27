<?php


namespace App\Http\Controllers;

use SEO;
use Auth;
use Input;
use Image;
use App\CV;
use App\Job;
use App\User;
use App\Recruit;
use App\Comment;
use App\Skill;
use App\JobApproved;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    /*
     * Get user info by their name
     * @param string $name to compare with the source
     * return manage page for user
     */
    public function userDetail($name, $token)
    {
        if (Auth::guest()) {
            return redirect()->intended('/');
        }

        $data ['userDetail'] = User::whereRaw('username = ? and remember_token = ? ', [
            $name,
            $token
        ])->first();
        if (!$data ['userDetail']) {
            return view('errors.404');
        }
        SEO::setTitle('Quản lý tài khoản-' . $data ['userDetail']->full_name);
        SEO::setDescription('Quản lý tài khoản,cập nhật ảnh đại diện,xem sửa xóa báo giá,tạo cv....');
        SEO::opengraph()->setUrl('http://localhost:8000/' . $name . '/' . $token);
        $data ['username'] = Auth::user()->username;
        $data ['job_comment_list'] = Comment::where('user_id', '=', Auth::user()->id)->get();
        $data ['list_cv'] = CV::where('user_id', '=', Auth::user()->id)->get();
        $data ['jobpost'] = Job::where('user_id', '=', Auth::user()->id)->orderBy('post_at', 'desc')->get();
        $data['recruit_job'] = Recruit::where('user_id', '=', Auth::user()->id)->orderBy('post_at', 'desc')->get();
        return view('ui.userinfo.uinfo', $data);
    }

    /**
     * [assignJob assignJob for user]
     * @return [type] [description]
     */
    public function assignJob()
    {
        $jobs_approved = new JobApproved();
        $jobs_approved->job_id = Input::get('job_id');
        $jobs_approved->user_assign = Input::get('user_assign');
        $jobs_approved->user_post = Input::get('user_post');
        $jobs_approved->save();
        return response()->json(array('mess' => 'Giao việc thành công'));
    }

    /**
     * [userDetailAjax load comment using ajax]
     *
     * @return response
     */
    public function userDetailAjax()
    {
        $job_comment_list = Comment::where('user_id', '=', Auth::user()->id)->paginate(4);
        return view('ui.userinfo.ajax', compact('job_comment_list'));
    }

    /*
     * Get user info by their name
     * @param string $name to compare with the source
     * @var newFileName create uniqe file name base on id
     * if directory doesn't exist create directory
     * return manage page for user
     */
    public function profileImage($name)
    {
        if (Auth::guest()) {
            return redirect()->intended('/');
        }
        $user = new User ();
        $userDetail = User::where('username', '=', $name)->first();
        $temp = $_FILES ['file'] ['tmp_name'];
        $image = $_FILES ['file'] ['name'];
        $ext = pathinfo($image, PATHINFO_EXTENSION);

        $newFileName = uniqid($userDetail->id);
        if (!is_dir("images/$name/")) {
            mkdir("images/$name", 0777);
        }
        $img = Image::make($temp);
        $img->fit(150, 150);
        $src = "images/$name/$newFileName.$ext";

        $img->save($src);
        $user = $userDetail;
        $user->avatar = $src;
        $user->save();
        return $src;
    }

    /**
     * [DeleteComment using ajax]
     *
     * @param $id comment
     *            to compare with source
     */
    public function deleteComment($id)
    {
        if (Auth::guest()) {
            return redirect()->intended('/');
        }
        Comment::where('id', '=', $id)->delete();
        return response()->json(array(
            'mess' => 'Xóa thành công'
        ));
    }

    /**
     * [createCV return new create cv view]
     *
     * @return [type] [description]
     */
    public function createCV()
    {
        if (Auth::guest()) {
            return redirect()->intended('/');
        }
        SEO::setTitle('Tạo mới CV');
        return view('ui.userinfo.cv');
    }

    /**
     * [saveCV save cv via ajax]
     * Upload avatarimg with cropping
     */
    public function saveCV()
    {
        $imgName = Input::get('avatar');
        $ext = pathinfo($imgName, PATHINFO_EXTENSION);
        $name = Auth::user()->username;
        $newFileName = uniqid(Auth::user()->id);
        if (!is_dir("images/$name/cv/")) {
            mkdir("images/$name/cv/", 0777);
        }
        $img = Image::make($imgName);
        $src = "images/$name/cv/$newFileName.jpg";
        $img->save($src);
        $cv = new CV ();
        $cv->avatar = $src;
        $cv->name = Input::get('name');
        $cv->job_name = Input::get('job_name');
        $cv->phone = Input::get('phone');
        $cv->email = Input::get('email');
        $cv->address = Input::get('address');
        $cv->experience = Input::get('experience');
        $cv->education = Input::get('education');
        $cv->activities = Input::get('activities');
        $cv->capabilities = Input::get('capabilities');
        $cv->interests = Input::get('interests');
        $cv->skill = Input::get('skill');
        $cv->user_id = Auth::user()->id;
        $cv->save();
        $skill_name=explode(',', Input::get('skill_name'));

        foreach ($skill_name as $skill_insert){
            $skill = new Skill();
            $skill->cv_id = $cv->id;
            $skill->skill_name = $skill_insert;
            $skill->save();
        }


       return response()->json(array(
            'mess' => 'Lưu thành công'
        ));
    }

    /**
     * [loadCV load cv]
     *
     * @param [type] $name
     *            [name of user]
     * @param [type] $id
     *            [id of cv,decrypt using substr]
     * @return [type] [description]
     */
    public function loadCV($name, $id)
    {
        $cv_id = substr($id, 0, -13);
        $data ['cv_info'] = CV::where('id', '=', $cv_id)->first();
        SEO::setTitle('Xem CV của ' . $name);
        return view('ui.userinfo.viewCV', $data);
    }

    /**
     * [updateCV View Cv to update]
     *
     * @param [type] $name
     *            [name of user]
     * @param [type] $id
     *            [id of cv]
     * @return [type] [description]
     */
    public function viewUpdateCV($name, $id)
    {
        $cv_id = substr($id, 0, -13);
        $data ['cv_info'] = CV::where('id', '=', $cv_id)->first();
        SEO::setTitle('Cập nhật CV của ' . $name);
        return view('ui.userinfo.updateCV', $data);
    }

    /**
     * [updateCV updateCV using ajax]
     *
     * @param [type] $id
     *            [id of the cv]
     * @return [type] [description]
     */
    public function updateCV($id)
    {
        $img = Input::get('avatar');
        if (isset ($img)) {
            $imgName = Input::get('avatar');
            $ext = pathinfo($imgName, PATHINFO_EXTENSION);
            $name = Auth::user()->username;
            $newFileName = uniqid(Auth::user()->id);
            if (!is_dir("images/$name/cv/")) {
                mkdir("images/$name/cv/", 0777);
            }
            $img = Image::make($imgName);
            $src = "images/$name/cv/$newFileName.jpg";
            $img->save($src);
        }

        $cv_id = substr($id, 0, -13);
        $cv = CV::where('id', '=', $cv_id)->update([
            'avatar' => $src,
            'name' => Input::get('name'),
            'job_name' => Input::get('job_name'),
            'phone' => Input::get('phone'),
            'email' => Input::get('email'),
            'address' => Input::get('address'),
            'education' => Input::get('education'),
            'activities' => Input::get('activities'),
            'capabilities' => Input::get('capabilities'),
            'interests' => Input::get('interests'),
            'skill' => Input::get('skill')
        ]);
        return response()->json(array(
            'mess' => 'Cập nhật thành công'
        ));
    }

    /**
     * [deleteCV DeleteCV using ajax]
     *
     * @param [type] $id
     *            [using id to compare with the source]
     * @return [type] [description]
     */
    public function deleteCV($id)
    {
        $cv_id = substr($id, 0, -13);
        CV::where('id', '=', $cv_id)->delete();
        return response()->json(array(
            'mess' => 'Xóa thành công'
        ));
    }
    /*public function downloadPDF()
    {
        $url='/cv/xem-cv/phuchung95/156bc84ce60db9';
        $url=explode('/', $url);
        $cv_id = substr($url[4], 0, -13);
        $name=Auth::user()->username;
        $cv_info=CV::where('id','=',$cv_id)->first();
        $html = view('ui.userinfo.viewCV',['cv_info'=> $cv_info])->render();
        return $this->pdf
        ->load($html)
        ->show();
    }*/
}
