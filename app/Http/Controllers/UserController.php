<?php namespace App\Http\Controllers;

use Image;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Comment;
use App\Job;

class UserController extends Controller {

	/*
	*	Get user info by their name
	*	@param string $name to compare with the source
	*	return manage page for user
	*/
	public function userDetail($name,$token)
	{
		if (Auth::guest()) {
			return redirect()->intended('/');
		}

		$userDetail=User::whereRaw('username = ? and remember_token = ? ', [$name,$token])->first();
		if(!$userDetail){
			return view('errors.404');
		}

		$job_comment_list=Comment::where('user_id', '=', Auth::user()->id)->get();
		return view('ui.userinfo.uinfo',compact('userDetail','job_comment_list'));
	}

	/**
	 * [userDetailAjax load comment using ajax]
	 * @return response
	 */
	public function userDetailAjax()
	{
		$job_comment_list=Comment::where('user_id', '=', Auth::user()->id)->paginate(4);
		return view('ui.userinfo.ajax',compact('job_comment_list'));
	}

	/*
	*	Get user info by their name
	*	@param string $name to compare with the source
	*	@var newFileName create uniqe file name base on id
	*  	if directory doesn't exist create directory
	*	return manage page for user
	*/
	public function profileImage($name)
	{
		if (Auth::guest()) {
			return redirect()->intended('/');
		}
		$user=new User();
		$userDetail=User::where('username', '=', $name)->first();
		$temp=$_FILES['file']['tmp_name'];
		$image=$_FILES['file']['name'];
		$ext=pathinfo($image,PATHINFO_EXTENSION);

		$newFileName=uniqid($userDetail->id);
		if (!is_dir("images/$name/")) {
			mkdir("images/$name",0777);
		}
		$img=Image::make($temp);
		$img->fit(150, 150);
		$src = "images/$name/$newFileName.$ext";

		$img->save($src);
		$user=$userDetail;
		$user->avatar = $src;
		$user->save();
		return $src;
	}

	/**
	 * [DeleteComment using ajax]
	 * @param $id comment to compare with source
	 */
	public function deleteComment($id)
	{
		if (Auth::guest()) {
			return redirect()->intended('/');
		}
		Comment::where('id','=',$id)->delete();
		return response()->json(array('mess'=>'Xóa thành công'));
	}

	/**
	 * [jobUserPost get the job that user post]
	 * @return [type] [description]
	 */
	public function jobUserPost()
	{
		if (Auth::guest()) {
			return redirect()->intended('/');
		}
		$jobpost=Job::where('user_id','=', Auth::user()->id)->paginate(4);
		return view('ui.userinfo.uinfo',compact('jobpost'));
	}
}
